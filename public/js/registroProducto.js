 $(function () {
    
    JsBarcode(".barcode").init();
    
    $('.img_producto').on('change',function(e){
        var file_input=this.files[0];
        var ext=['jpeg','jpg','png'];
        var name=file_input.name.split('.').pop().toLocaleLowerCase();
        if(ext.indexOf(name)==-1){alert("archivo permitidos: "+ext.toString()); return false;}
        else{
            var img=URL.createObjectURL(file_input);
            $('#img_producto_img').attr('src',img);
        }
     });


     $('#form_producto').on('submit', function (e) {
         e.preventDefault();
         var token=$('#token_producto').val();
         var input_ruta_method=$('#input_rut_meth').val();
         console.log(input_ruta_method);

         var ruta="";
         var method="POST";
         if(input_ruta_method==""){
            ruta='/producto';
         }
         else{
             //input_ruta===id
            ruta='/update_post';
         }
         var form=new FormData (this);
         for(var pair of form.entries()) {
            console.log(pair[0]+ ', '+ pair[1]); 
         }
         console.log(method);
            
         $.ajax({
          url:ruta,
          type:method,
           headers:{'X-CSRF-TOKEN':token},
           data:form,
           cache: false,
           contentType: false,
           processData: false,
           beforeSend:function(){
               $('.cont_img_carga_gif').css({'display':'flex'});
           }  
           }).done(function(data) {
              console.log(data);
              var json=JSON.parse(data);
            if(json.respuesta==1){
                alert("producto registrado con exito");
                $('#form_producto')[0].reset();
                $('#img_producto_img').attr('src','/storage/upload/subir_imagen_12323131321323imagen_.png');
            }
            if(json.respuesta==2){
                alert("producto actualizado con exito");
            }
            if(json.respuesta==0){
                alert("Error:Intente nuevamente");
            }
            $('.cont_img_carga_gif').css({'display':'none'});              
          });

     });


 });
