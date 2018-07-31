var tabla;
var cont = 0;
var detalles = 0;
var tabProductos;
var tabDetfactura = null;
$(document).ready(function () {
//    mostrarForm(false);
    recordFacturas();
    $("#formFactura").on("submit", function (e) {
        saveFactura(e);
    });
    $("#serie").change(ultNumSerie);
});
function agregarFactura() {
    recordClientes();//Recorrer filas
    ultNumSerie(); // llena el numero de factura
    mostrarForm();
    recordsProductos();
    $("#btnAgregarArt").show();
    $("#btnGuardar").show();
//    tabProductos.ajax.reload();
    var fn = new Date();
    var dia = ("0" + fn.getDate()).slice(-2);
    var mes = ("0" + (fn.getMonth() + 1)).slice(-2);
    var hoy = fn.getFullYear() + "-" + (mes) + "-" + (dia);
    $("#fec_fac").val(hoy);
    if (tabDetfactura != null) {
        tabDetfactura.clear().draw();
        tabDetfactura.destroy();
        tabDetfactura = null;
    }

}
function mostrarForm(flag) {
    if (flag) {// si es true
//        $("#divListadoFacturas").hide();
//        $("#divRegistrarFactura").show();
//         tabProductos.ajax.reload();
//         tabDetfactura.ajax.reload();
//        recordsProductos();
    } else { // si es false
//        $("#divRegistrarFactura").hide();
//        $("#divListadoFacturas").show();
//        $("#formFactura")[0].reset();
        limpiarForm();
    }
}
function limpiarForm() {
    $("#formFactura")[0].reset();
}
function detailsFactura(idFactura) {
    mostrarForm(true);
    $("#btnAgregarArt").hide();
    $("#btnGuardar").hide();
    $.get("../../app/controllers/factura.controller.php?opt=detailsFactura",
            {id_factura: idFactura},
            function (data) {
                // console.log(data);
                $.each(data, function (key, value) {
                    $("#" + key).val(value);
                });
            }, "json");

    //Aqui muestra los detalles de la factura
    tabDetfactura = $("#tblDetalles").DataTable({
        ajax: {
            url: "../../app/controllers/factura.controller.php?opt=detailDetFactura&id_factura=" + idFactura
        },
        "bDestroy": true
    });
}
function saveFactura(e) {
    e.preventDefault();
//   Toma los datos con el atributo name
//    var formData = new FormData($("#formFactura")[0]);
    var data = $("#formFactura").serializeArray();
    console.log(data);

    $.post("../../app/controllers/factura.controller.php?opt=saveFactura", data,
            function () {
                // clear fields from the popup
                mostrarForm(false);
                // read records again
                tabla.ajax.reload();
            });
    if (tabDetfactura != null) {
        tabDetfactura.clear().draw();
        tabDetfactura.destroy();
        tabDetfactura = null;
    }
    /*
     $.ajax({
     url: "../../app/controllers/factura.controller.php?opt=saveFactura",
     type: "POST",
     data: formData,
     contentType: false,
     processData: false,
     success: function (data) {
     tabla.ajax.reload();
     }
     });
     */
}
function recordFacturas() {
    tabla = $("#tbListadoFacturas").DataTable({
        ajax: {
            url: "../../app/controllers/factura.controller.php?opt=readFacturas"
        }
    });
}
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
function recordClientes() {
    $.post("../../app/controllers/factura.controller.php?opt=readClientes",
            function (r) {
                $("#id_cliente").html(r);
//        $('#id_cliente').selectpicker('refresh');
            });
}
function recordsProductos() {
    tabProductos = $("#tblProductos").DataTable({
        ajax: {
            url: "../../app/controllers/factura.controller.php?opt=readProductos"
        },
        "bDestroy": true
    });
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
                numeroMostrar = "";
                if (dataJson) {
                    numero = parseInt(dataJson.num_factura, 10) + 1;
                    numeroMostrar = numero.toString().padStart(8, "0");
                } else {
                    numeroMostrar = "00000001";
                }
                $("#num_factura").val(numeroMostrar);
            });
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
    //$("#total").html("S/." + total);
    $("#total_venta").val(total);
}
function deleteDetalle(indice) {
    $("#fila" + indice).remove();
    calcularTotales();
    detalles -= 1;
}
function deleteFactura(idFactura) {
    var conf = confirm("¿Estas Seguro, que quieres eliminar esta Factura?");
    if (conf) {
        $.get("../../app/controllers/factura.controller.php?opt=deleteFactura",
                {id_factura: idFactura},
                function (data) {
                    tabla.ajax.reload();
                });
    }
}