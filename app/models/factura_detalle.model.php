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

        $query = $this->db->prepare("INSERT INTO tb_detalle_factura(id_factura,id_producto,cantidad,pre_venta) VALUES(:id_factura,:id_producto,;cantidad,:pre_venta)");

        $query->bindParam(":id_factura", $arg_idFactura);
        $query->bindParam(":id_producto", $arg_idProducto);
        $query->bindParam(":cantidad", $arg_cantidad);
        $query->bindParam(":pre_venta", $arg_preVenta);
        $query->execute();
    }

    /*
      public function readFacturas() {
      $cd_q = "SELECT F.id_factura,C.nombre,F.serie,F.num_factura,F.fec_hora,F.total_venta FROM tb_factura F INNER JOIN tb_cliente C ON F.id_cliente=C.id_cliente";
      $query = $this->db->prepare($cd_q);
      $query->execute();
      return $query->fetchAll();
      }
     */

    /*
      public function detailsFactura($arg_id_factura) {
      $query = $this->db->prepare("select * from tb_factura where id_factura = :id_factura");
      $query->bindParam(":id_factura", $arg_id_factura);
      $query->execute();
      return $query->fetch();
      }
     */
    /*
      public function readNumeroSerie($arg_serie) {
      $query = $this->db->prepare("SELECT (num_factura+1) AS num_factura FROM tb_factura WHERE serie = :serie ORDER BY num_factura DESC LIMIT 1");
      $query->bindParam(":serie", $arg_serie);
      $query->execute();
      return $query->fetch();
      }
     */
}
