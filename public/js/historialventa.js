$(function(){

    var token=$('.token_TipVenta').val();
    var clave="";
    var select_actual="";

    $(document).on('change','.pagarHistorial',function(){

        $('#formulario_abono')[0].reset();
        select_actual=$(this).parents('tr');
        pago_bool=$(this).parents('tr').find('.pago_bool').val();
        var option=$(this).val();
        var i = $(this).find("option").length;

        console.log(option);
        console.log(pago_bool);
        //i===3?$('#ocultar_pago').hide():$('#ocultar_pago').show();
        if(option!=3){
            $('.ocultar_pago').hide();
        }
        if((option==3&&pago_bool==false)||(option==3&&pago_bool=="false")){
            //si es false no ha termiando de pagar!!!!
            console.log("aqui entrammoss");
            $('.ocultar_pago').show();
        }
         clave=$(this).data('clave');
        $('.body_compra').html("");

        if(option==3){
            $.ajax({
                url:'abonoCliente',
                type:"POST",
                headers:{'X-CSRF-TOKEN':token},
                data:{'clave':clave,'action':'consult_abonos'}
               }).done(function(data) {
                console.log(data);
                var fila="";
                var adeuda=data[0].importe;
                var total=0;
                if(data==""){
                    fila="<tr><th class='text-danger'>Aun no se ha realizado ningun abono</th></tr>";
                }else{
                    fila="<tr><th>Fecha</th><th>Abono</th></tr>";
                    data.forEach(element => {
                        if(element.abono!=null){
                    fila+='<tr><td>'+element.fecha+'</td>';
                    fila+='<td>'+element.abono+'</td>';
                    fila+='</tr>';
                    total=total+parseFloat(element.abono);
                    }
                });
                fila+='<tr><td>Total: </td><td colspan="2">'+total+'</td></tr>';
                adeuda=data[0].importe-total;
                }
                //var importe=$(this).data('importe');
                //var adeuda=$(this).data('adeuda');

                $('#msj_modal').html('<strong>Nº factura </strong>'+data[0].numerofactura+'<strong>  importe </strong>'+data[0].importe+'<strong>  Adeuda </strong><span id="adeuda_alert">'+adeuda+'</span>');
                $('.body_compra').html(fila);
                $('#modal_compra').modal('show');
               });


        }
        if(option==1){
            $.ajax({
                url:'abonoCliente',
                type:"POST",
                headers:{'X-CSRF-TOKEN':token},
                data:{'clave':clave,'action':'consul_carrito'}
               }).done(function(data) {
                console.log(data);
                if(data[0].cliente==null){
                    data[0].cliente="";
                }
                var fila='<tr style="border-none;"><th colspan="3" class="text-info">'+data[0].cliente+'</th><th class="text-success">'+data[0].venta+'</th></div>';
                fila+="<tr><th>Nombre</th><th>Precio</th><th>Tipo_venta</th><th>Cantidad</th><th>SubTotal</th></tr>";
                var total=0;
                   data.forEach(element => {
                    var subTotal=parseFloat(element.precio)*parseFloat(element.cantidad);
                    fila+='<tr><td>'+element.nombre+'</td>';
                    fila+='<td>'+element.precio+'</td>';
                    fila+='<td>'+element.tipo_venta+'</td>';
                    fila+='<td>'+element.cantidad+'</td>';
                    fila+='<td>'+subTotal+'</td>';
                    fila+='</tr>';
                });
                fila+='<tr><td colspan="4" align="right"><strong>Total: </strong></td><td>'+data[0].importe+'</td></tr>';
                console.log(fila);
                $('#msj_modal').html('<strong>Nº factura </strong>'+data[0].numerofactura);
                $('.body_compra').html(fila);
                $('#modal_compra').modal('show');

               });
        }
        $(this).val(0);
    });

 $('#formulario_abono').submit(function(e){
        e.preventDefault();
        console.log(token);
        console.log(clave);

        var cantidad=$("#cantidad_input").val();
        $.ajax({
           url:'abonoCliente',
           type:"POST",
           headers:{'X-CSRF-TOKEN':token},
           data:{'clave':clave,'cantidad':cantidad,'action':'insert_abono'}
          }).done(function(data) {
            console.log(data);

              //console.log(data.abonos);
              if(data.valor===1){
                 if(data.ocultar){
                    $('.ocultar_pago').hide();
                  }
                  alert(data.respuesta);
                  fila="<tr><th>Fecha</th><th>Abono</th></tr>";
                  var total=0;
                  data.abonos.forEach(element => {
                  fila+='<tr><td>'+element.fecha+'</td>';
                  fila+='<td>'+element.abono+'</td>';
                  fila+='</tr>';
                  total=total+parseFloat(element.abono);
              });
              fila+='<tr><td>Total: </td><td colspan="2">'+total+'</td></tr>';

              var adeuda=data.abonos[0].importe-total;
              if(adeuda==0){
                $('.ocultar_pago').hide();
                //$(select_actual).attr('pago_bool',true);
                    $(select_actual).find('.pago_bool').val(true);
                    $(select_actual).find('.venta_venta').html('Credito <i class="fas fa-circle text-success"></i>');
               }else{
                $(select_actual).find('.venta_venta').html('Credito <i class="fas fa-circle text-danger"></i><span class="text-danger">'+adeuda+'</span>');
               }
              $('#msj_modal').html('<strong>Nº factura </strong>'+data.abonos[0].numerofactura+'<strong>  importe </strong>'+data.abonos[0].importe+'<strong>  Adeuda </strong>'+adeuda);
              $('.body_compra').html(fila);
              }else{
                  alert(data.respuesta);
              }

          });
    });

    var table = $('#example').DataTable({
        "select": true,
        "destroy": true,
        "language": Idioma,
        "lengthMenu": [[10, 20, 25, 50, -1], [10, 20, 25, 50, "Todos"]],
        "iDisplayLength": 10
    });

});
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
