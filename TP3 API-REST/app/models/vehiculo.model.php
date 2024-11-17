<?php

class VehiculosModel {
    private $db;

    public function __construct() {
       $this->db = new PDO('mysql:host=localhost;dbname=concecionario1;charset=utf8', 'root', '');
    }
 
    public function getVehiculos($filtrarVendidos = null, $orderBy = false) {
        $sql = 'SELECT * FROM vehiculos';


        
        if($filtrarVendidos != null) {
            if($filtrarVendidos == 'true')
                $sql .= ' WHERE vendido = 1';
            else
                $sql .= ' WHERE vendido = 0';
        }

        if($orderBy) {
            switch($orderBy) {
                case 'kilometros':
                    $sql .= ' ORDER BY Kilometros';
                    break;
                case 'modelo':
                    $sql .= ' ORDER BY Modelo';
                    break;
            }
        }

        $query = $this->db->prepare($sql);
        $query->execute();
    
       
        $vehiculos = $query->fetchAll(PDO::FETCH_OBJ); 
    
        return $vehiculos;
    }
 
    public function getVehiculo($id) {    
        $query = $this->db->prepare('SELECT * FROM vehiculos WHERE id = ?');
        $query->execute([$id]);   
    
        $vehiculos = $query->fetch(PDO::FETCH_OBJ);
    
        return $vehiculos;
    }
 
    public function insertVehiculo($Marca, $Kilometros, $Patente,$Modelo, $finalizada = false) { 
        $query = $this->db->prepare('INSERT INTO vehiculos( Marca, Kilometros , Patente , Modelo , finalizada) VALUES (?, ?, ?, ?, ?)');
        $query->execute([$Marca, $Kilometros, $Patente,$Modelo, $finalizada]);
    
        $id = $this->db->lastInsertId();
    
        return $id;
    }
 
    public function deleteVehiculo($id) {
        $query = $this->db->prepare('DELETE FROM vehiculos WHERE id = ?');
        $query->execute([$id]);
    }

    public function setVendido($id, $vendido) {        
        $query = $this->db->prepare('UPDATE vehiculos SET vendido = ? WHERE id = ?');
        $query->execute([$vendido, $id,]);
    }

    function updateVehiculo($id, $Marca, $Kilometros, $Patente,$Modelo, $finalizada) {    
        $query = $this->db->prepare('UPDATE vehiculos SET Marca = ?, Kilometros = ?, Patente = ?, Modelo = ? ,finalizada = ? WHERE id = ?');
        $query->execute([$Marca, $Kilometros, $Patente,$Modelo, $finalizada, $id]);
    }
}
