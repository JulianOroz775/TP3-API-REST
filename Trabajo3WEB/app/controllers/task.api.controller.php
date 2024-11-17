<?php
require_once './app/models/task.model.php';
require_once './app/views/json.view.php';

class TaskApiController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new TaskModel();
        $this->view = new JSONView();
    }

    // /api/tareas
    // /api/tareas
    public function getAll($req, $res) {
      // para filtrar entre las tareas finalizadas si o no
        //primero declaro esta variable tasks como algo vacio
        $filtrarFinalizadas= false;
        //despues me fijo si los query estan seteados como finalizado y ademas esta en false entonces pedimos las tareas finalizadas
        if (isset($req->query->finalizada) && $req->query->finalizada == 'false') {
            $filtrarFinalizadas= true; }
     
       
       //ordenamos x prioridad
        $orderBy = false;
        // y si esta seteado lo vamos a leer
        if(isset($req->query->orderBy)){
            $orderBy=$req->query->orderBy;
        }
        
        $tasks = $this->model->getTasks($filtrarFinalizadas, $orderBy);

        // mando las tareas a la vista
        return $this->view->response($tasks);
    }


    // /api/tareas/:id
    public function get($req, $res) {
        // obtengo el id de la tarea desde la ruta
        $id = $req->params->id;

        // obtengo la tarea de la DB
        $task = $this->model->getTask($id);

        // pregunto si esta
        if(!$task) {
            // le pasamos el status porque queremos algo distinto de 200
            return $this->view->response("La tarea con el id=$id no existe", 404);
            // si no esta envio dicho mensaje a la vista 
        }

        // mando la tarea a la vista
        return $this->view->response($task);
    }

    //api/tareas/:id con el verbo (DELETE)

    public function delete($req,$res){
        $id= $req->params->id;
        
        //chequeo si existe la tarea
        $task= $this->model->getTask($id);
        
        if(!$task){
            // le mando un mensaje y un codigo en este caso el 404 not found 
            return $this->view->response("La tarea con el id=$id no existe",404);
        }

        $this->model->deleteTask($id);
        $this->view->response("La tarea con el id=$id se elimino correctamente");

    }

    //  api/tareas (POST)

    public function create($req,$res){
         //valido los datos
         if(empty($req->body->titulo)||empty($req->body->prioridad)){
            //400 bad request
           return $this->view->response("Los datos a cargar no se encuentran",400);
        };
        
        // obtengo los datos
            // obtendo los datos del body del request
            
            $titulo= $req->body->titulo;
            $descripcion= $req->body->descripcion;
            $prioridad= $req->body->prioridad;
            $finalizada= $req->body->finalizada;
        
    
        //inserto los datos
        $id=$this->model->insertTask($titulo,$descripcion,$prioridad,$finalizada);

        //una vez insertado si no, devolvia false
        if(!$id){
            return $this->view->response("Eror al insertar tarea",500);
        }
           
        // devuelvo la tarea que inserte
        $task= $this->model->getTask($id); 
        return $this->view->response($task,201);
        
    }

    //  api/tareas/:id (PUT)

    public function update($req,$res){
        $id= $req->params->id;

        //chequeo si existe la tarea
        $task= $this->model->getTask($id);
        
        if(!$task){
            // le mando un mensaje y un codigo en este caso el 404 not found 
             return $this->view->response("La tarea con el id=$id no existe",404);
        }

        //valido los datos
        if(empty($req->body->titulo)||empty($req->body->prioridad)){
            //400 bad request
           return $this->view->response("Los datos a cargar no se encuentran",400);
        };
        
        // obtengo los datos
            // obtendo los datos del body del request
            
            $titulo= $req->body->titulo;
            $descripcion= $req->body->descripcion;
            $prioridad= $req->body->prioridad;
            $finalizada= $req->body->finalizada;
        

        $this->model->updateTask($id,$titulo,$descripcion,$prioridad,$finalizada);

        $task= $this->model->getTask($id);

        $this->view->response($task,200);
    }

}