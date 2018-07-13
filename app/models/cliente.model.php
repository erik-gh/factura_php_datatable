<?php

require_once '../../config/database.config.php';

class ClienteModel {

    protected $db;

    function __construct() {
        $newDB = new Database();
        $this->db = $newDB->getConnecion();
    }

    function __destruct() {
        $this->db = null;
    }

    public function readClientes() {
        $cd_q = "SELECT * FROM tb_cliente";
        $query = $this->db->prepare($cd_q);
        $query->execute();
        return $query->fetchAll();
    }
    
    public function saveFacturas(){       
    }

}

