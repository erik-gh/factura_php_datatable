<?php

require_once '../../config/database.config.php';

class DetalleFacturaModel {

    protected $db;

    function __construct() {
        $newDB = new Database();
        $this->db = $newDB->getConnecion();
    }

    function __destruct() {
        $this->db = null;
    }

    public function saveDetalleFactura($arg_idFactura, $arg_idProducto, $arg_cantidad, $arg_preVenta) {

        $query = $this->db->prepare("INSERT INTO tb_detalle_factura(id_factura,id_producto,cantidad,pre_venta) VALUES(:id_factura,:id_producto,:cantidad,:pre_venta)");

        $query->bindParam(":id_factura", $arg_idFactura);
        $query->bindParam(":id_producto", $arg_idProducto);
        $query->bindParam(":cantidad", $arg_cantidad);
        $query->bindParam(":pre_venta", $arg_preVenta);
        $query->execute();
    }

}
