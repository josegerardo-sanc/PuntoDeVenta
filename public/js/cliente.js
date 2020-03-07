$(function() {

var t='';
var ruta_cliente='';
var metodo_cliente='';

 function cargar_clientes(){

    t = $('#example').DataTable({
        "ajax":{
            "method":"GET",
            "url":"listarclientes"
        },
        "columns":[
            {"data":"cliente"},
            {"data":"cliente"},
            {"data":"telefono"},
            {"data":"img_cliente",
             "render":function(data,type,row){
                    return '<img src="storage/'+data+'" style="width:100px; height: 110px; display: block; object-fit: cover;">';
             }
            },
            {"data":"tipo",
            "render":function(data,type,row){
                if(row.tipo==="no"){return 'Cliente';}
                else{return 'Negocio';}
                }
            },
            {"defaultContent":" <div class='d-flex'><button class='editar_btn btn btn-info'><i class='fas fa-edit'></i></button><button class='eliminar_btn btn btn-danger'><i class='fas fa-trash'></i></button></div>"}
        ],
        "columnDefs": [ {
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],
        "order": [[1, 'asc' ]],
        "destroy": true,
        "language": Idioma,
        "lengthMenu": [[10, 20, 25, 50, -1], [10, 20, 25, 50, "Todos"]],
        "iDisplayLength": 10
    });
    t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    }).draw();

    //editar_table_ajax('#example tbody',t);
 }
 cargar_clientes();

 $(document).on('click','.editar_btn',function(){

     $('#formulario_cliente')[0].reset();

     $('.conte_negocio').hide('fast');
     $('#registro_cliente_title').text('Actualizar registro');
     $('#btn_cliente__').addClass('btn-warning text-white').text('Actualizar Registro');

     var data="";
      if(t.row(this).child.isShown()){
         data = t.row(this).data();
        }else{
         data = t.row($(this).parents("tr")).data();
        }
      console.log(data);
    // return false;
      ruta_cliente='clienteupdate';
      metodo_cliente='post';
      //console.log(data);
    $('#_clave_cliente').val(data.id);
     var name_cliente=$('#name_cliente').val(data.cliente);
     var telefono_cliente=$('#telefono_p').val(data.telefono);
     var dire_cliente=$('#direccion_p').val(data.direccion_p);
     $("#img_cliente_img").attr("src","/storage/"+data.img_cliente);
     $('#name_negocio').val(data.img_negocio);
     if(data.tipo=='yes'){
        //console.log("yes");
       $('#negocio').click().first();
        $('#img_negocio_img').attr("src","/storage/"+data.img_negocio);
        var name_negocio=$('#name_negocio').val(data.negocio);
        var direccion_negocio=$('#direccion_negocio').val(data.direccion_n);
     }else{
        $('#img_negocio_img').attr("src","/storage/upload/12345negocio_negocio.jpg");
        var name_negocio=$('#name_negocio').val('');
        var direccion_negocio=$('#direccion_negocio').val('');
     }
     $('#Cliente_negocio').modal('show');
    });


    $(document).on('click','.eliminar_btn',function(){
        var token=$('#token_cliente').val();
        var data="";
        if(t.row(this).child.isShown()){
            data = t.row(this).data();
           }else{
            data = t.row($(this).parents("tr")).data();
           } var clave=data.id;
           var r = confirm("Estas seguro de elimnar este cliente??");
           if (!r) {
            return false;
           }
        console.log(clave);
        $.ajax({
            url:'cliente/'+clave,
            headers:{'X-CSRF-TOKEN':token},
            method:'DELETE',
           }).done(function(respuesta){
                console.log(respuesta);
                //if(respuesta['data'].respuesta){
                    cargar_clientes();
                //}
        });


    });


$('#new_cliente_').on('click',function(e){
    e.preventDefault();

ruta_cliente='cliente';
metodo_cliente='POST';
    $('#registro_cliente_title').text('Registrar Cliente');
    $('#btn_cliente__').removeClass('btn-warning text-white').text('Nuevo cliente');
    $('.conte_negocio').hide('fast');
    $("#img_cliente_img").attr("src","/storage/upload/12345persona_persona.jpg");
    $('#img_negocio_img').attr("src","/storage/upload/12345negocio_negocio.jpg");
    $('#formulario_cliente')[0].reset();
    $('#Cliente_negocio').modal('show');
    console.log("estamos en el click para mostrar modal");

});


 $('#formulario_cliente').on('submit',function(e){
     e.preventDefault();
     //var _clave_cliente=$('#_clave_cliente').val();
     var token=$('#token_cliente').val();
     var form=new FormData(this);
     var name_cliente=$('#name_cliente').val();
     var telefono_cliente=$('#telefono_p').val();
     var dire_cliente=$('#direccion_p').val();
      if(!(name_cliente!=""&&telefono_cliente!=""&&dire_cliente))
      {
        alert("rellene los campos cliente!!!");
        return false;
      }
    if ($('#negocio').is(":checked")){
          var name_negocio=$('#name_negocio').val();
          var direccion_negocio=$('#direccion_negocio').val();

         if(!(name_negocio!=""&&direccion_negocio!=""))
         {
            alert("rellene los campos!!,Usted selecciono la opcion de negocio");
            return false;
         }
    }else{
        $('#img_negocio_img').attr("src","/storage/upload/12345negocio_negocio.jpg");
        var name_negocio=$('#name_negocio').val('');
        var direccion_negocio=$('#direccion_negocio').val('');
    }
    $('#btn_cliente__').attr('disabled','disabled');
  $.ajax({
        url:ruta_cliente,
        headers:{'X-CSRF-TOKEN':token},
        method:metodo_cliente,
        processData:false,
        contentType:false,
        data:form
       }).done(function(respuesta){
            console.log(respuesta);
            if(respuesta['data'].respuesta){
                cargar_clientes();
             if(respuesta['data'].respuesta_num=='1')
                     {alert("Registro con exito");}
                else{alert("actualizacion con exito");}
            }
            $('#btn_cliente__').removeAttr('disabled');
    });
 });

            $('#negocio').on('change', function() {
                if ($(this).is(":checked")) {
                    $('.conte_negocio').fadeIn();
                } else {
                    $('.conte_negocio').fadeOut();
                }
            });

            $('.nombre').on('focus', function() {
                $(this).parent().find('.img').css({
                    border: '1px solid #80bdff',
                    boxShadow: '0 0 0 0.2rem rgba(0,123,255,.25)',
                    outline: '0'
                });

            }).on('blur', function() {
                $(this).parent().find('.img').css({
                    border: '1px solid #ced4da',
                    boxShadow: 'none'

                });
            });
        });

        $('.file_usuario').on('change', function() {
            var file_input=this;
            var ext=['jpeg','jpg','png'];
            var name=file_input.files[0].name.split('.').pop().toLocaleLowerCase();
            if(ext.indexOf(name)==-1){alert("archivo permitidos: "+ext.toString()); return false;}
            else{
                var img=URL.createObjectURL(file_input.files[0]);
                //console.log(file_input.parentElement);
                file_input.parentElement.children[0].src=img;
            }
        });
