<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte pdf</title>
    
    <style>
    .table{
        width: 100%;
        text-align: center;
    }
    thead{
        background-color: dodgerblue;
        color: white;
    }
    th,td{
        padding: 10px;
        font-family: 'Times New Roman', Times, serif;
    }
    </style>
</head>
<body>
<table id="example" class="table">
                <thead>
                      <tr>
                          <th>Codigo</th>
                          <th>Producto</th>
                          <th>Fecha</th>
                          <th>Cantidad</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach($reabastecimientos as $key=>$abastecimiento)    
                     <tr>
                        <td>    
                            {{$abastecimiento->codigo}}
                            {{--<svg class="barcode"
                            jsbarcode-format="upc"
                            jsbarcode-value="{{$abastecimiento->codigo}}"
                            jsbarcode-textmargin="0"
                            jsbarcode-fontoptions="bold">
                            </svg> --}}     
                         </td>
                         <td>{{$abastecimiento->nombre}}</td>
                         <td>{{$abastecimiento->fecha}}</td>
                         <td>{{$abastecimiento->cantidad}}</td>
                     </tr>
                     @endforeach
                  </tbody>
              </table>
</body>

<script src="{{asset('bootstrap/js/jquery-3.3.1.js')}}"></script>
<script src="{{asset('bootstrap/JsBarcode.all.min.js')}}"></script>
<script>
$(function(){
    JsBarcode(".barcode").init();
    
});
</script>
</html>