<?php
require_once './app/models/vehiculo.model.php';
require_once './app/views/json.view.php';

class VehiculosApiController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new VehiculosModel();
        $this->view = new JSONView();
    }


    public function getAll($req, $res) {
      
  
      
        $filtrarVendidos= false;
        
        if (isset($req->query->vendido) && $req->query->vendido == 'false') {
            $filtrarVendidos= true; }
     
       
      
        $orderBy = false;
       
        if(isset($req->query->orderBy)){
            $orderBy=$req->query->orderBy;
        }
        
        $tasks = $this->model->getVehiculos($filtrarVendidos, $orderBy);

        
        return $this->view->response($tasks);
    }


    public function get($req, $res) {
        
        $id = $req->params->id;
        $task = $this->model->getVehiculo($id);

 
        if(!$task) {
           
            return $this->view->response("El vehiculo con el id=$id no existe", 404);
           
        }

       
        return $this->view->response($task);
    }



    public function delete($req,$res){
        $id= $req->params->id;
        
     
        $task= $this->model->getVehiculo($id);
        
        if(!$task){
       
            return $this->view->response("El vehiculo con el id=$id no existe",404);
        }

        $this->model->deleteVehiculo($id);
        $this->view->response("El vehiculo con el id=$id se elimino correctamente");

    }

   

    public function create($req,$res){

         if(empty($req->body->Marca)||empty($req->body->Modelo)){
    
           return $this->view->response("Los datos a cargar no se encuentran",400);
        };
        
    
            
            $Marca= $req->body->Marca;
            $Kilometros= $req->body->Kilometros;
            $Patente= $req->body->Patente;
            $Modelo= $req->body->Modelo;
            $finalizada= $req->body->finalizada;
        
    

        $id=$this->model->insertVehiculo($Marca, $Kilometros, $Patente,$Modelo, $finalizada);

  
        if(!$id){
            return $this->view->response("Eror al insertar vehiculo",500);
        }
           
  
        $task= $this->model->getVehiculo($id); 
        return $this->view->response($task,201);
        
    }



    public function update($req,$res){
        $id= $req->params->id;


        $task= $this->model->getVehiculo($id);
        
        if(!$task){
          
             return $this->view->response("La tarea con el id=$id no existe",404);
        }

     
        if(empty($req->body->Marca)||empty($req->body->Modelo)){
     
           return $this->view->response("Los datos a cargar no se encuentran",400);
        };
        
       
            
            $Marca= $req->body->Marca;
            $Kilometros= $req->body->Kilometros;
            $Patente= $req->body->Patente;
            $Modelo= $req->body->Modelo;
            $finalizada= $req->body->finalizada;
        

        $this->model->updateVehiculo($id,$Marca, $Kilometros, $Patente,$Modelo, $finalizada);

        $vehiculo= $this->model->getVehiculo($id);

        $this->view->response($vehiculo,200);
    }
    public function setVendido($req, $res) {
        $id = $req->params->id;

      
        $vehiculo = $this->model->getVehiculo($id);
        if (!$vehiculo) {
            return $this->view->response("El vehiculo con el id=$id no existe", 404);
        }

        if (!isset($req->body->vendido)) {
            return $this->view->response('Faltan completar datos', 400);
        }

        if ($req->body->vendido!== 1 && $req->body->vendido !== 0) {
            return $this->view->response('Tipo de dato incorrecto', 400);
        }

 
        $this->model->setVendido($id, $req->body->vendido);
            

         $task = $this->model->getVehiculo($id);
         $this->view->response($task, 200);
    }



}