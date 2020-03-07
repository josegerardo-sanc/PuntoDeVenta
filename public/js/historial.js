$(function(){

    
    JsBarcode(".barcode").init();
    
    var ini="";
    var fin="";
    var code="";

    $('#imprimir_historial').submit(function(e){
       
       /* e.preventDefault();
         ini=$('#fecha_ini').val();
         fin=$('#fecha_fin').val();
         code=$('#codigo_product').val().length==11?$('#codigo_product').val():'';
         $.ajax({
            url:'printPDF',
            type:'GET',
            data:{'fecha_ini':ini,'fecha_fin':fin,'code':code,'action':'imprimir'}
           }).done(function( data, textStatus, jqXHR ) {
                console.log(data);
           });
         console.log("enviar.........");
       */
    });

    $('.fecha_AJAX').on('change',function(e){
         e.preventDefault();
         ini=$('#fecha_ini').val();
         fin=$('#fecha_fin').val();
         code=$('#codigo_product').val().length==11?$('#codigo_product').val():'';
         DataTable_(ini,fin,code);
    });
    $('#codigo_product').keyup(function(e){
        e.preventDefault();
        ini=$('#fecha_ini').val();
        fin=$('#fecha_fin').val();
        code=$('#codigo_product').val().length==11?$('#codigo_product').val():'';
        DataTable_(ini,fin,code);
   });

  function DataTable_(ini,fin,code){
    $.ajax({
        url:'reabastecer',
        type:'GET',
        data:{'fecha_ini':ini,'fecha_fin':fin,'code':code,'action':'get'}
       }).done(function( data, textStatus, jqXHR ) {
           console.log(data);
           $('#example').DataTable({
            'destroy':true,
            'data':data,
            'columns':[
                {"data":"codigo"},
                {"data":"nombre"},
                {"data":"fecha"},
                {"data":"cantidad"}
            ],
            "language": Idioma,
            "lengthMenu": [[10, 20, 25, 50, -1], [10, 20, 25, 50, "Todos"]],
            "iDisplayLength": 10,
        } );
        JsBarcode(".barcode").init();
       })
       .fail(function( jqXHR, textStatus, errorThrown ) {
           if ( console && console.log ) {
               console.log( "La solicitud a fallado: " +  textStatus);
           }
    });
  }
});