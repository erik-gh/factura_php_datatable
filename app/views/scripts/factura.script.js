$(document).ready(function () {
    recordFacturas();
    mostrarForm(false);
    recordsClientes();//Recorrer filas
    ultNumSerie();
    $("#serie").change(ultNumSerie);

});
function saveFactura() {
    //e.preventDefault();
//    toma los datos con el atributo name
    var formData = new FormData($("#formFactura")[0]);
    $.ajax({
        url: "../../app/controllers/factura.controller.php?opt=saveFactura",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
            //tabla.ajax.reload();
        }
    });
}
var tabla;
function recordsClientes() {
    $.post("../../app/controllers/factura.controller.php?opt=readClientes",
            function (r) {
                $("#idCliente").html(r);
//        $('#idCliente').selectpicker('refresh');
            });
}
function recordsProductos() {
    $("#tblProductos").DataTable({
        ajax: {
            url: "../../app/controllers/factura.controller.php?opt=readProductos"
        }
    });
}
function recordFacturas() {
    tabla = $("#tbListadoFacturas").DataTable({
        ajax: {
            url: "../../app/controllers/factura.controller.php?opt=readFacturas"
        }
    });
}

var cont = 0;
var detalles = 0;
function addDetallefactura(idProducto, descProducto) {
    var cantidad = 1;
    var precio_venta = 1;
    var subtotal = cantidad * precio_venta;
    var filaDetalle =
            '<tr class="filas" id="fila' + cont + '">' +
            '<td><input type="hidden" name="idProducto[]" value="' + idProducto + '">' + idProducto + '</td>' +
            '<td><input type="hidden" name="nomProducto[]" value="' + descProducto + '">' + descProducto + '</td>' +
            '<td><input type="number" name="cantProducto[]" id="cantProducto[]" value="' + cantidad + '"></td>' +
            '<td><input type="number" name="precVenta[]" id="precVenta[]" value="' + precio_venta + '"></td>' +
            '<td><span name="subtotal" id="subtotal' + cont + '">' + subtotal + '</span></td>' +
            '<td>' +
            '<button type="button" class="btn btn-info" onclick="editSubTotales()">Calcular</button>' +
            '<button type="button" class="btn btn-danger" onclick="deleteDetalle(' + cont + ')">Eliminar</button>' +
            '</td>' +
            '</tr>';
    cont++;
    detalles++;
    $('#tblDetalles').append(filaDetalle);
}
function editSubTotales() {
    var cant = document.getElementsByName("cantProducto[]");
    var prec = document.getElementsByName("precVenta[]");
    var subT = document.getElementsByName("subtotal");
    for (var i = 0; i < cant.length; i++) {
        var factCant = cant[i];
        var factPrec = prec[i];
        var inpS = subT[i];
        inpS.value = factCant.value * factPrec.value;
        document.getElementsByName("subtotal")[i].innerHTML = inpS.value;
    }
    calcularTotales();
}
function calcularTotales() {
    var subTotal = document.getElementsByName("subtotal");
    var total = 0.0;
    for (var i = 0; i < subTotal.length; i++) {
        total += document.getElementsByName("subtotal") [i].value;
    }
    $("#total").html("S/." + total);
    $("#total_venta").val(total);
}
function deleteDetalle(indice) {
    $("#fila" + indice).remove();
    calcularTotales();
    detalles -= 1;
}
function detailsFactura() {
}
function mostrarForm(flag) {
    if (flag) {// si es true
        $("#divListadoFacturas").hide();
        $("#divRegistrarFactura").show();
//         tablaProductos.ajax.reload();
        recordsProductos();
    } else { // si es false
        $("#divRegistrarFactura").hide();
        $("#divListadoFacturas").show();
    }
}
function cancelarForm() {
//    limpiarForm();
    mostrarForm(false);
}
function ultNumSerie() {
    var NumSerie = $("#serie option:selected").val();
    $.post("../../app/controllers/factura.controller.php?opt=readSerie", {numSerie: NumSerie},
            function (data) {
                dataJson = JSON.parse(data);
                numeroMostrar = dataJson.num_factura.padStart(8, "0");
                $("#numFac").val(numeroMostrar);
            });
}

