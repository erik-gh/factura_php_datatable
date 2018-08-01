var tabla;
var cont = 0;
var detalles = 0;
var tabProductos;
var tabDetfactura = null;

$(document).ready(function () {
    mostrarForm(true);
    recordFacturas();
    $("#formFactura").on("submit", function (e) {
        saveFactura(e);
    });
    $("#serie").change(ultNumSerie);
});

function saveFactura(e) {
    e.preventDefault();
    var data = $("#formFactura").serializeArray();
    $.post("../../app/controllers/factura.controller.php?opt=saveFactura", data,
            function () {
                mostrarForm(true);
                $(".filas").remove();
                tabla.ajax.reload();
            });
}

function detailsFactura(idFactura) {
    mostrarForm(false);
    $("#btnAgregarArt").hide();
//    $("#btnGuardar").hide();

    // Aqui se muestra los campos de Factura
    $.get("../../app/controllers/factura.controller.php?opt=detailsFactura",
            {id_factura: idFactura},
            function (data) {
                $.each(data, function (key, value) {
                    $("#" + key).val(value);
                });
            }, "json");

    //Aqui muestra las filas de detalles de la factura
    tabDetfactura = $("#tblDetalles").DataTable({
        ajax: {
            url: "../../app/controllers/factura.controller.php?opt=detailDetFactura&id_factura=" + idFactura
        },
        "bDestroy": true
    });
}

function deleteFactura(idFactura) {
    var conf = confirm("¿Estas Seguro, que quieres eliminar esta Factura?");
    if (conf) {
        $.get("../../app/controllers/factura.controller.php?opt=deleteFactura",
                {id_factura: idFactura},
                function () {
                    tabla.ajax.reload();
                });
    }
}

function recordFacturas() {
    tabla = $("#tbListadoFacturas").DataTable({
        ajax: {
            url: "../../app/controllers/factura.controller.php?opt=readFacturas"
        }
    });
}

function recordClientes() {
    $.post("../../app/controllers/factura.controller.php?opt=readClientes",
            function (r) {
                $("#id_cliente").html(r);
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

function btnAgregarFactura() {
    recordClientes();//Recorrer filas
    ultNumSerie(); // llena el numero de factura
    recordsProductos();
    // falta limpiar los inputs de factura
    mostrarForm(false);
    $("#btnAgregarArt").show();
    var fn = new Date();
    var dia = ("0" + fn.getDate()).slice(-2);
    var mes = ("0" + (fn.getMonth() + 1)).slice(-2);
    var hoy = fn.getFullYear() + "-" + (mes) + "-" + (dia);
    $("#fec_fac").val(hoy);

    if (tabDetfactura !== null) {
        tabDetfactura.clear().draw();
        tabDetfactura.destroy();
        tabDetfactura = null;
    }
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
    $("#tblDetalles").append(filaDetalle);
    $("#btnGuardar").show();
}
function deleteDetalle(indice) {
    $("#fila" + indice).remove();
    calcularTotal();
    detalles -= 1;
    if (detalles == 0) {
        $("#btnGuardar").show();
    }
}
function mostrarForm(flag) {
    if (flag) {// si es true
        $("#divRegistrarFactura").hide();
        $("#divListadoFacturas").show();
    } else { // si es false
        $("#divListadoFacturas").hide();
        $("#divRegistrarFactura").show();
        $("#btnGuardar").hide();
//        limpiarForm();
    }
}
function limpiarForm() {
    $("#formFactura")[0].reset();
}
function cancelarForm() {
    mostrarForm(true);
    limpiarForm();
    $(".filas").remove();
}
function ultNumSerie() {
    var NumSerie = $("#serie option:selected").val();
    $.post("../../app/controllers/factura.controller.php?opt=readSerie", {numSerie: NumSerie},
            function (data) {
                numeroMostrar = "";
                if (data) {
                    numero = parseInt(data.num_factura, 10) + 1;
                    numeroMostrar = numero.toString().padStart(8, "0");
                } else {
                    numeroMostrar = "00000001";
                }
                $("#num_factura").val(numeroMostrar);
            }, "json");
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
    calcularTotal();
}
function calcularTotal() {
    var subTotal = document.getElementsByName("subtotal");
    var total = 0.0;
    for (var i = 0; i < subTotal.length; i++) {
        subt = subTotal[i].value;
        total = total + subt;
    }
    $("#total_venta").val(total);
}

