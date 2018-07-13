<?php

require_once '../models/factura.model.php';
$objFactura = new FacturaModel();


$idFactura = (!empty($_POST['idFactura'])) ? $_POST['idFactura'] : null;
$opt = (string) filter_input(INPUT_GET, 'opt');
switch ($opt) {
    case 'readFacturas':
        $ary_listFacturas = $objFactura->readFacturas();
        $data = [];
        foreach ($ary_listFacturas as $key) {
            $data[] = [
                "0" => $key->id_factura,
                "1" => $key->nombre,
                "2" => $key->serie . " - " . str_pad($key->num_factura, 8, "0", STR_PAD_LEFT),
                "3" => $key->fec_hora,
                "4" => $key->total_venta,
                "5" => "<button class='btn btn-warning' onclick='getFacturaDetails(" . $key->id_factura . ")'>Actualizar</button>",
                "6" => "<button class='btn btn-danger' onclick='deleteFactura(" . $key->id_factura . ")'>Eliminar</button>"
            ];
        }
        $rDataTable = array("aaData" => $data);
        echo json_encode($rDataTable);
        break;
    case 'saveFactura':
        /* Varibles de Factura */
        $idClie = isset($_POST['idCliente']) ? $_POST['idCliente'] : null;
        $serie = isset($_POST['serie']) ? $_POST['serie'] : null;
        $numSerFac = isset($_POST['numFac']) ? $_POST['numFac'] : null;
        $fhFact = isset($_POST['fhFactura']) ? $_POST['fhFactura'] : null;
        $totVent = isset($_POST['total_venta']) ? $_POST['total_venta'] : null;

        /* Varibles de Detalle Factura */
        $idProd = isset($_POST['idProducto']) ? $_POST['idProducto'] : null;
        $nomProd = isset($_POST['nomProducto']) ? $_POST['nomProducto'] : null;
        $canProd = isset($_POST['cantProducto']) ? $_POST['cantProducto'] : null;
        $preVent = isset($_POST['precVenta']) ? $_POST['precVenta'] : null;

        $lastIdFactura = $objFactura->saveFactura($idClie, $serie, $numSerFac, $fhFact, $totVent, $idFactura);
        require_once '../models/factura_detalle.model.php';
        $objDetFactura = new DetalleFacturaModel();
        for ($i = 0; $i < count($idProd); $i++) {
            $objDetFactura->saveDetalleFactura($lastIdFactura, $idProd[$i], $canProd[$i], $preVent[$i]);
        }
        break;
    case 'detailsFactura':
        $detFactura = $objFactura->detailsFactura($idFactura);
        echo json_encode($detFactura);
        break;
    case 'deleteFactura':

        break;
    case 'readSerie':
        $nSerie = !empty($_POST['numSerie']) ? $_POST['numSerie'] : null;
        $numSerie = $objFactura->readNumeroSerie($nSerie);
        echo json_encode($numSerie);
        break;
    case 'readClientes':
        require_once '../models/cliente.model.php';
        $objCliente = new ClienteModel();
        $ary_listCliente = $objCliente->readClientes();
        foreach ($ary_listCliente as $key) {
            echo '<option value="' . $key->id_cliente . '">' . $key->nombre . '</option>';
        }
        break;
    case 'readProductos':
        require_once '../models/producto.model.php';
        $objProducto = new ProductoModel();
        $ary_listProductos = $objProducto->readProductos();
        $data = [];
        foreach ($ary_listProductos as $key) {
            $data[] = [
                "0" => $key->id_producto,
                "1" => $key->descripcion,
                "2" => $key->stock,
                "3" => "<button class='btn btn-warning' onclick='addDetallefactura(" . $key->id_producto . ",\"" . $key->descripcion . "\")'>Agregar</button>",
            ];
        }
        $rDataTable = array("aaData" => $data);
        echo json_encode($rDataTable);
        break;
}


