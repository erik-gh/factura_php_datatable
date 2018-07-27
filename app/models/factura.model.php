<?php

require_once '../../config/database.config.php';

class FacturaModel {

    protected $db;

    function __construct() {
        $newDB = new Database();
        $this->db = $newDB->getConnecion();
    }

    function __destruct() {
        $this->db = null;
    }

    public function readFacturas() {
        $cd_q = "SELECT F.id_factura,C.nombre,F.serie,F.num_factura,F.fec_hora,F.total_venta FROM tb_factura F INNER JOIN tb_cliente C ON F.id_cliente=C.id_cliente";
        $query = $this->db->prepare($cd_q);
        $query->execute();
        return $query->fetchAll();
    }

    public function saveFactura($arg_id_cliente, $arg_serie, $arg_numfactura, $arg_fechora, $arg_totalventa, $arg_idfactura) {
        $query = null;
        if ($arg_idfactura === null) {
            $query = $this->db->prepare("INSERT INTO tb_factura(id_cliente,serie,num_factura,fec_hora,total_venta) VALUES(:id_cliente,:serie,:num_factura,:fec_hora,:total_venta)");
        } else {
            $query = $this->db->prepare("UPDATE tb_factura SET id_cliente=:id_cliente,serie=:serie,num_factura=:num_factura,fec_hora=:fec_hora,total_venta=:total_venta WHERE id_factura=:id_factura");
            $query->bindParam(":id_factura", $arg_idfactura);
        }

        $query->bindParam(":id_cliente", $arg_id_cliente);
        $query->bindParam(":serie", $arg_serie);
        $query->bindParam(":num_factura", $arg_numfactura);
        $query->bindParam(":fec_hora", $arg_fechora);
        $query->bindParam(":total_venta", $arg_totalventa);
        $query->execute();
        return $this->db->lastInsertId();
    }

    public function detailsFactura($arg_id_factura) {
        $query = $this->db->prepare("select * from tb_factura where id_factura = :id_factura");
        $query->bindParam(":id_factura", $arg_id_factura);
        $query->execute();
        return $query->fetch();
    }

    public function readNumeroSerie($arg_serie) {
        $query = $this->db->prepare("SELECT num_factura FROM tb_factura WHERE serie = :serie ORDER BY num_factura DESC LIMIT 1");
        $query->bindParam(":serie", $arg_serie);
        $query->execute();
        return $query->fetch();
    }

}
