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

    public function recordDetalleFactura($arg_idFactura) {
        $cslt = "SELECT DF.id_dfactura,P.descripcion,DF.cantidad,DF.pre_venta,(DF.cantidad*DF.pre_venta) AS subtotal
                 FROM tb_detalle_factura DF INNER JOIN tb_producto P ON DF.id_producto=P.id_producto
                 WHERE id_factura = :id_factura;";
        $query = $this->db->prepare($cslt);
        $query->bindParam(":id_factura", $arg_idFactura);
        $query->execute();
        return $query->fetchAll();
    }

    public function deleteDetalleFactura($arg_idFactura) {
        $query = $this->db->prepare("DELETE FROM tb_detalle_factura WHERE id_factura= :id_factura");
        $query->bindParam(":id_factura", $arg_idFactura);
        $query->execute();
    }

}
