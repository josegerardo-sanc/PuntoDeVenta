$(function(){



    /*funciones de bsuqueda de producto index*/

 $('#search_product_index').keypress(function(e) {
        var key = window.Event ? e.which : e.keyCode;
        var patron=/^[A-Za-z0-9\s]+$/;
        var tecla_final=String.fromCharCode(key);
        console.log(tecla_final);
        return patron.test(tecla_final);

 });

    $('#search_product_index').keyup(function(e){
        e.preventDefault();
    var key = window.Event ? e.which : e.keyCode;
    if(this.value!="" || key==8 ){
      var token=$('#token_token_').val();
      console.log(token)
       $.ajax({
       url:'buscarProducto',
       type:"POST",
       headers:{'X-CSRF-TOKEN':token},
       data:{'search':this.value,'token_':token}
       }).done(function(data) {
          //console.log(data);
          if(data.length!=0){
            $('.conte_productos_').empty();
            $('.conte_productos_').append(data);

          }else{
            $('.conte_productos_').html("<div class='col-sm-12'><h1 class='display-4'>No se encontraron resultados</h1></div>");
        }

         });
        }
    });
/*funciones del carrito */
$('#telefono_modal_search').on('submit',function(e){
   e.preventDefault();
   var token=$('.token_TipVenta').val();
   var num_telefonico=$('#num_telefonico').val();
   $.ajax({
      url:'search_cliente',
      type:"POST",
      headers:{'X-CSRF-TOKEN':token},
      data:{'telefono':num_telefonico}
     }).done(function(data) {
        console.log(data);
        //console.log(json['data'].length);
        var json=JSON.parse(data);
          if(json.resp=="2"){
             alert("debes ingresar solo numeros");
             return false;
          }else{
             if(!json['data'].length>0){
   //no enontradooo no encontrado

               $('#conte_elements_m').css({'display':'none'});
                alert("Numero no encontrado!!")
                return false;
             }

               //input del seect que tiene el data
               $('#id_cliente_').val("true");
               $('#name_busqueda_new_cambio').text(json['data'][0].cliente);
               $('#conte_data_cliente').fadeIn();

               ///ocultamos el click para el modal
               $('.TipoVenta').removeAttr('disabled');
               $('.cliente_actual_').hide();

                /////////////////////////

          $('#conte_elements_m').fadeIn();
         console.log(json['data'][0].cliente);
         $('#img_m').attr("src",'/storage/'+json['data'][0].img_cliente);
         $('#name_m').val(json['data'][0].cliente);
         var tipo=json['data'][0].tipo=="yes"?'Negocio':'Cliente';
         var direccion=json['data'][0].tipo=="yes"?json['data'][0].direccion_n:json['data'][0].direccion_p;
         $('#direccion_m').val(direccion);
         $('#tipo_m').val(tipo);
          }
      });
});

function Mostrar_modal(){
   var cliente_actual=$('#id_cliente_').val();
   console.log(cliente_actual);
   if(cliente_actual=="false")
   {
      $('#buscar_cliente').modal('show');
   }
}
$('.cliente_actual_').on('click',function(e){
   Mostrar_modal();
});

$('#credito_check').on('click',function(){
    if($(this).is(":checked"))
    {
    Mostrar_modal();
    }
 });

///////////btn del conte cliente buscado por su telefono///////////////////
$('#busqueda_new_cambio').on('click',function(){
    var cliente_actual=$('#id_cliente_').val();

    cliente_actual=cliente_actual?'false':'true';
     console.log(cliente_actual);
   if(cliente_actual=="false")
   {
      $('#buscar_cliente').modal('show');
   }
});

$('.btn_delete_producto').on('click',function(e){
    e.preventDefault();
    const element_this=this;
    var token=$('#token_enviar').val();
    var clave=$(this).parents('form').data('id');
    console.log(clave);
    $.ajax({
        url:'borrar_producto',
        type:"POST",
        headers:{'X-CSRF-TOKEN':token},
        data:{'clave':clave},
        beforeSend: function( xhr ) {
         $(element_this).addClass('btn-danger');
         $(element_this).html("<i class='fas fa-sync fa-spin'></i>");
        }
       }).done(function(respuesta) {
        console.log(respuesta);
        var data=JSON.parse(respuesta);
        //console.log(data['data']);
        if(!data['data'].length>0){
            $('#id_cliente_').val("false");
            $('#conte_data_cliente').hide();
                console.log("esta vacio el carrito ocultar el conte de cliente");
            }
        if(data.respuesta=='eliminar_fila'){
           console.log("eliminar fila btn_delete");
           $(element_this).parents('ul.contenido').remove();

        }
        var Total=0;
        var Num_products=0;
        data['data'].forEach(element => {
          if(clave==element['ID'])
           {

           $(element_this).parents('.contenido').find('._total_').text(element.CANTIDAD * element.PRECIO);
           }
           Total=Total+element.CANTIDAD * element.PRECIO;
           Num_products=Num_products+parseInt(element.CANTIDAD);
        });
        $('#TOTAL_PRECOMPRA').text(Total);
        $('#num_products').text(Num_products);
        //$(elemento).html('<i class="fas fa-trash"></i>');

       });

});


   $('.btn_editar').on('click',function(e){
      e.preventDefault();

     // $(this).parents('.contenido').find('.input_cantidad').val(30);
     $(this).parents('.contenido').find('._total_').text('1000');


    });

    $('.TipoVenta').on('change',function(e){
       var ruta=$('.form_TipVenta').attr('action');
       var token=$('.token_TipVenta').val();

       var clave=$(this).parents('.contenido').find('form').data('id');
       var opcion=$(this).val();


       const element_this=this;
        $.ajax({
        url:ruta,
        type:"POST",
        headers:{'X-CSRF-TOKEN':token},
        data:{'TipoVenta':opcion,'clave':clave}
       }).done(function(data) {
               //console.log(data);
               var datajson=JSON.parse(data);
               if(!datajson.resultado)
               {
                alert('ups!! No se encontro el producto');
               }
              var Total=0;
              var Num_products=0;
              datajson['data'].forEach(element => {
              if(clave==element['ID'])
                {
                $(element_this).parents('.contenido').find('._precio').text(element.PRECIO);
                $(element_this).parents('.contenido').find('._total_').text(element.CANTIDAD * element.PRECIO);
                }
                Total=Total+element.CANTIDAD * element.PRECIO;
                });
                $('#TOTAL_PRECOMPRA').text(Total);
       });

    });


    $('.input_cantidad').keypress(function(e) {
           var key = window.Event ? e.which : e.keyCode;
           var patron=/[z0-9]/;
           var tecla_final=String.fromCharCode(key);
           console.log(tecla_final);
           return patron.test(tecla_final);

    });


     $('.input_cantidad').keyup(function(e) {
         var key = window.Event ? e.which : e.keyCode;
         if((key >= 48 && key <= 57) || (key==8)){
            if(this.value!=""){
                var token=$('#token_enviar').val();
                var cantidad=$(this).val();
                var clave=$(this).parent().parent().find('form').data('id');
                var url_=$('#formulario_').attr('action');

                const element_this = $(this);
                $.ajax({
                    url:url_,
                    headers:{'X-CSRF-TOKEN':token},
                    method:"post",
                    data:{'btn_accion':'addCarrito','ajax':'addCarrito_','cantidad':cantidad,'clave':clave},
                    beforeSend:function() {
                     //$(element_this).attr('disabled', 'disabled');
                    }}).done(function(respuesta){
                     //$(element_this).removeAttr('disabled');
                        console.log(respuesta);

                        var data=JSON.parse(respuesta);
                        console.log(data['data']);
                        if(data.respuesta=='eliminar_fila'){
                           console.log("eliminar fila");
                           $(element_this).parents('.contenido').remove();
                        }
                        var Total=0;
                        var Num_products=0;
                        if(!data['data'].length>0){
                            $('#id_cliente_').val("false");
                            $('#conte_data_cliente').hide();
                                console.log("esta vacio el carrito ocultar el conte de cliente");
                        }
                        data['data'].forEach(element => {
                          if(clave==element['ID'])
                           {
                           $(element_this).val(element.CANTIDAD);
                           $(element_this).parents('.contenido').find('._total_').text(element.CANTIDAD * element.PRECIO);
                           }
                           Total=Total+element.CANTIDAD * element.PRECIO;
                           Num_products=Num_products+parseInt(element.CANTIDAD);
                        });
                        $('#TOTAL_PRECOMPRA').text(Total);
                        $('#num_products').text(Num_products);
                        if(!data.respuesta){
                          $('#contenido_msj').text('Producto agotado');
                          $('#contenido_msj2').text('Solo se encontraon '+$(element_this).val());
                             $('#modal_msj').modal('show');
                          }
                     }).fail(function(){
                         console.log("No se ha podido obtener la información");
                     });

               }
            }
      })
      .on("cut copy paste",function(e){
        e.preventDefault();
      });

});






