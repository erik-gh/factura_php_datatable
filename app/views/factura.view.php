<!doctype html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>MVC Facturas</title>
        <!--Archivos CSS-->
        <link rel="stylesheet" type="text/css" href="../../public/css/bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css" href="../../public/datatable/jquery.dataTables.min.css"/>

        <!--Archivos JS-->
        <script type="text/javascript" src="../../public/js/jquery-3.1.1.min.js"></script>
        <script type="text/javascript" src="../../public/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../../public/datatable/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="scripts/factura.script.js"></script>
    </head>
    <body>
        <!-- Contenido -->
        <div class="container">
            <!-- Main content -->
            <div class="panel-body" id="divListadoFacturas">
                <div class="row">
                    <div class="pull-right">
                        <button id="btnAgregar" class="btn btn-success" onclick="agregarFactura()">Agregar Factura</button>
                    </div>
                    <h1> LISTADO FACTURA </h1>
                </div>
                <div class="row">
                    <table id="tbListadoFacturas" class="table table-bordered table-hover">
                        <thead>
                        <th>#</th>
                        <th>Nombre Cliente</th>
                        <th>Numero Factura</th>
                        <th>Fecha Hora</th>
                        <th>Total Venta</th>
                        <th>Actualizar</th>
                        <th>Eliminar</th>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                        <th>#</th>
                        <th>Nombre Cliente</th>
                        <th>Numero Factura</th>
                        <th>Fecha Hora</th>
                        <th>Total Venta</th>
                        <th>Actualizar</th>
                        <th>Eliminar</th>
                        </tfoot>
                    </table>
                </div>
            </div> <!-- /.divListadoFacturas -->

            <div class="panel-body" id="divRegistrarFactura">
                <h1> REGISTRAR FACTURA </h1>
                <form name="formFactura" id="formFactura" method="POST">
                    <div class="form-group col-md-5">
                        <label>Cliente(*) : </label>
                        <select name="id_cliente" id="id_cliente" class="form-control" data-live-search="true" required></select>
                    </div>
                    <div class="form-group col-md-2">
                        <label>Serie(*) : </label>
                        <select name="serie" id="serie" class="form-control" data-live-search="true">
                            <option value='001'>001</option>
                            <option value='002'>002</option>
                            <option value='003'>003</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label>Numero(*) : </label>
                        <input type="text" class="form-control" name="num_factura" id="num_factura" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Fecha(*) : </label>
                        <input type="date" class="form-control" name="fec_fac" id="fec_fac" required>
                    </div>
                    <div class="form-group col-md-12" style="text-align:center;">
                        <input type="hidden" name="id_factura" id="id_factura">
                        <a data-toggle="modal" href="#myModal">
                            <button class="btn btn-primary" type="button" id="btnAgregarArt">Agregar Productos</button>
                        </a>
                    </div>
                    <div class="form-group col-md-12">
                        <table id="tblDetalles" class="table table-striped table-bordered table-condensed table-hover">
                            <thead style="background-color: #A9D0F5">
                            <th>#</th>
                            <th>Articulo</th>
                            <th>Cantidad</th>
                            <th>Precio Venta</th>
                            <th>SubTotal</th>
                            <th>Opciones</th>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                            <th>TOTAL</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>    
                                <label for="total_venta">S/.
                                    <input type="text" name="total_venta" id="total_venta" placeholder="0.00" readonly="true" style="border:0;" size="10">
                                </label>
                            </th>
                            <th></th>
                            </tfoot>
                        </table>
                    </div>
                    <div class="form-group col-md-12" id="divGuardarCancelar">
                        <button class="btn btn-primary" id="btnGuardar">Guardar</button>
                        <button class="btn btn-danger" id="btnCancelar" onclick="cancelarForm()" type="button">Cancelar</button>
                    </div>
                </form>
            </div>
            <!-- Fin centro -->
        </div><!-- /.container -->
        <!--Fin-Contenido-->
        <!--Inicio Modal--> 
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Seleccione un Articulo</h4>
                    </div>
                    <div class="modal-body">
                        <table id="tblProductos" class="table table-striped table-bordered table-hover">
                            <thead>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Stock</th>
                            <th>Opcion</th>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Stock</th>
                            <th>Opcion</th>
                            </tfoot>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div> <!-- Fin Modal producto -->
    </body>
</html>

