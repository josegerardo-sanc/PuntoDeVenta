$(function () {
listar();
});


setInterval(() => {
$('#status').alert('close');
}, 3000);

var listar = function () {
    var table = $('#example').DataTable({
        "destroy": true,
        "language": Idioma,
        "lengthMenu": [[10, 20, 25, 50, -1], [10, 20, 25, 50, "Todos"]],
        "iDisplayLength": 10
    });
    historial('#example tbody', table);
    eliminar('#example tbody', table);

JsBarcode(".barcode").init();
}

function historial (nameTable, table) {
    console.log("historial...");
    $(nameTable).on('click', 'a.historial', function (e) {
        $('#form_reabastecer')[0].reset();
        var elemento = this.children[0].value;
        $('#clave_producto').val(elemento);
        $('#reabastecer_modal').modal('show');
    });

}
function eliminar (nameTable, table) {
    $(nameTable).on('click', 'a.eliminar', function (e) {
        var elemento = this.children[0].value;
        var formulario = $('#formulario_eliminar').attr('action', elemento);
        $('#eliminar_modal').modal('show');
        //var data = $(this).parents('tr');
        //console.log(data);
        //var data = table.row($(this).parents('tr').data());*/

    });
}
var Idioma = {
    "emptyTable": "<i>No hay datos disponibles en la tabla.</i>",
    "info": "Del _START_ al _END_ de _TOTAL_ ",
    "infoEmpty": "Mostrando 0 registros de un total de 0.",
    "infoFiltered": "(filtrados de un total de _MAX_ registros)",
    "infoPostFix": "(actualizados)",
    "lengthMenu": "Mostrar _MENU_ registros",
    "loadingRecords": "Cargando...",
    "processing": "Procesando...",
    "search": "<span style='font-size:15px;'>Buscar:</span>",
    "searchPlaceholder": "Dato para buscar",
    "zeroRecords": "No se han encontrado coincidencias.",
    "paginate": {
        "first": "Primera",
        "last": "Última",
        "next": "Siguiente",
        "previous": "Anterior"
    },
    "aria": {
        "sortAscending": "Ordenación ascendente",
        "sortDescending": "Ordenación descendente"
    }
}

