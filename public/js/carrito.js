$(function(){
 
    table_carrito();
 
})
var table_carrito=function(){
    var table = $('#carrito').DataTable({
        "destroy": true,
        "language": Idioma,
        "lengthMenu": [[10, 20, 25, 50, -1], [10, 20, 25, 50, "Todos"]],
        "iDisplayLength": 10
    });
}