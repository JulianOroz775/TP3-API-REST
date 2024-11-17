<?php

class TaskModel {
    private $db;

    public function __construct() {
       $this->db = new PDO('mysql:host=localhost;dbname=concecionario1;charset=utf8', 'root', '');
    }
 
    public function getTasks($filtrarFinalizadas = false, $orderBy = false) {
        $sql = 'SELECT * FROM vehiculos';

        if($filtrarFinalizadas){
           // al usar el .= le sumamos al SQL base el WHERE finalizada = 0
            $sql .= ' WHERE finalizada = 0' ;
        }

        // evitamos inyeccion sql
        if($orderBy){
            switch($orderBy){
                case 'titulo' :
                    $sql .= ' ORDER BY titulo ';
                    break;
                case 'prioridad' :
                    $sql .= ' ORDER BY prioridad ';
                    break;
            }
        }

       
        // 2. Ejecuto la consulta
        // saco el codigo sql afuera
        $query = $this->db->prepare($sql);
        $query->execute();
    
        // 3. Obtengo los datos en un arreglo de objetos
        $tasks = $query->fetchAll(PDO::FETCH_OBJ); 
    
        return $tasks;
    }
 
    // api/tareas/: id (GET)
    public function getTask($id) {    
        $query = $this->db->prepare('SELECT * FROM vehiculos WHERE id = ?');
        $query->execute([$id]);   
    
        $task = $query->fetch(PDO::FETCH_OBJ);
    
        return $task;
    }

    // api/tareas/: id (DELETE)
    public function deleteTask($id){
       
        $query=$this->db->prepare('DELETE FROM vehiculos WHERE id = ?');
        $query->execute([$id]);

    }


    // api/tareas (POST)
    public function insertTask($marca, $kilometros, $patente,$modelo ,$finished=0 ) { 
        $query = $this->db->prepare('INSERT INTO vehiculos(marca, kilometros, patente, modelo) VALUES (?, ?, ?, ?, ?)');
        $query->execute([$marca, $kilometros, $patente,$modelo ,$finished]);
    
        $id = $this->db->lastInsertId();
    
        return $id;
    }


    // api/tareas/: id (PUT)

    function updateTask($id,$marca, $kilometros, $patente,$modelo ,$finished) {    
        $query = $this->db->prepare('UPDATE tareas SET marca = ?, kilometros = ?, patente = ?, modelo = ?, finalizada = ? WHERE id = ?');
        $query->execute([$marca, $kilometros, $patente,$modelo ,$finished, $id]);
    }


 


  
}