<?php

require_once '../../config/database.config.php';

class ProductoModel {

    protected $db;

    function __construct() {
        $newDB = new Database();
        $this->db = $newDB->getConnecion();
    }

    function __destruct() {
        $this->db = null;
    }

    public function readProductos() {
        $query = $this->db->prepare("SELECT * FROM tb_producto");
        $query->execute();
        return $query->fetchAll();
    }

}
