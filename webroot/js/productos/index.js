$(function () {
    var table = $("#tblProductos").DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
        }
    });
    $( "#clickExcel" ).click(function() {
        setTimeout(
            function() 
            {
               var table2excel = new Table2Excel();
                table2excel.export(document.querySelectorAll(".toExcelTable"));
            }, 2000
        );
        
    });
    CatchFormProducto();
    $('#ganancia').change(function(){
        calcularProducto();
    });
    $('#gananciapack').change(function(){
        calcularProducto();
    });
    $('#ganancia1').change(function(){
        calcularProducto();
    });
    $('#ganancia2').change(function(){
        calcularProducto();
    });
    $('#ganancia3').change(function(){
        calcularProducto();
    });
    $('#ganancia4').change(function(){
        calcularProducto();
    });
    $('#costo').change(function(){
        calcularProducto();
    });
    $('#cantpack').change(function(){
        calcularProducto();
    });
    catchPreciosChange();
    calcularProducto();
  });
    function CatchFormProducto(){
        $('#formAgregarProducto').submit(function(){
            var formData = $(this).serialize();
            var formUrl = $(this).attr('action');
            $.ajax({
                type: 'POST',
                url: formUrl,
                data: formData,
                success: function(data,textStatus,xhr){
                    var respuesta = JSON.parse(data);
                    if(respuesta.result=="fail"){
                        alert(respuesta.response)
                    }else{
                        alert("Producto guardado con exito, recargando la pagina.");
                        location.reload();                        
                    }
                },
                error: function(xhr,textStatus,error){
                    callAlertPopint(textStatus);
                }
            });
            return false;
        });
    }
    function calcularGanancia(ganancia,precio,preciopack,costo){
        var precio = $('#'+precio).val();
        var costo = $('#'+costo).val();
        var porcentaje = precio/costo;
        porcentaje -= 1;
        porcentaje = porcentaje*100;
        $('#'+ganancia).val((porcentaje).toFixed(2));
         if(preciopack!=''){
            var cantidad = $("#cantpack").val();
            var preciopackcalculado = cantidad*precio;
            $('#'+preciopack).val((preciopackcalculado).toFixed(2));
        }
     }
    function calcularPrecioUnidad(ganancia,precio,preciopack,costo){
        var preciopack = $('#'+preciopack).val();
        var cantidadPack = $('#cantpack').val();
        var preciocalculado = preciopack/cantidadPack;
        var costo = $('#'+costo).val();
        var porcentaje = preciocalculado/costo;
        porcentaje -= 1;
        porcentaje = porcentaje*100;
        $('#'+ganancia).val((porcentaje).toFixed(2));
        $('#'+precio).val((preciocalculado).toFixed(2));
     }
    function catchPreciosChange(){
        $('#precio').change(
           function(){
              calcularGanancia('ganancia','precio','','costo');
        });
        $('#preciopack').change(
           function(){
              calcularGanancia('gananciapack','preciopack','preciopack0','costo');
        });
        $('#preciomayor1').change(
           function(){
              calcularGanancia('ganancia1','preciomayor1','preciopack1','costo');
        });
        $('#preciomayor2').change(
           function(){
              calcularGanancia('ganancia2','preciomayor2','preciopack2','costo');
        });
        $('#preciomayor3').change(
           function(){
              calcularGanancia('ganancia3','preciomayor3','preciopack3','costo');
        });
        $('#preciomayor4').change(
           function(){
              calcularGanancia('ganancia4','preciomayor4','preciopack4','costo');
        });                
        $('#preciopack0').change(
            function(){
               calcularPrecioUnidad('gananciapack','preciopack','preciopack0','costo')
           }
        );
        $('#preciopack1').change(
            function(){
               calcularPrecioUnidad('ganancia1','preciomayor1','preciopack1','costo')
           }
        );
        $('#preciopack2').change(
            function(){
               calcularPrecioUnidad('ganancia2','preciomayor2','preciopack2','costo')
           }
        );
        $('#preciopack3').change(
            function(){
               calcularPrecioUnidad('ganancia3','preciomayor3','preciopack3','costo')
           }
        );
        $('#preciopack4').change(
            function(){
               calcularPrecioUnidad('ganancia4','preciomayor4','preciopack4','costo')
           }
        );
    }
    function calcularProducto(){
        var costo = $('#costo').val();
        var ganancia = $('#ganancia').val();
        var cantidad = $('#cantpack').val();
        var precio = costo*(1+(ganancia/100));
        $('#precio').val(precio.toFixed(2));
        var gananciapack = $('#gananciapack').val();
        var preciopack = costo*(1+(gananciapack/100));
        var preciopackcalculado = preciopack*cantidad;
        $('#preciopack').val(preciopack.toFixed(2));
        $('#preciopack0').val(preciopackcalculado.toFixed(2));

        var ganancia1 = $('#ganancia1').val();
        var preciopack1 = costo*(1+(ganancia1/100));
        $('#preciomayor1').val(preciopack1.toFixed(2));
        preciopackcalculado = preciopack1*cantidad;
        $('#preciopack1').val(preciopackcalculado.toFixed(2));

         var ganancia2 = $('#ganancia2').val();
        var preciopack2 = costo*(1+(ganancia2/100));
        $('#preciomayor2').val(preciopack2.toFixed(2));
        preciopackcalculado = preciopack2*cantidad;
        $('#preciopack2').val(preciopackcalculado.toFixed(2));

         var ganancia3 = $('#ganancia3').val();
        var preciopack3 = costo*(1+(ganancia3/100));
        $('#preciomayor3').val(preciopack3.toFixed(2));
        preciopackcalculado = preciopack3*cantidad;
        $('#preciopack3').val(preciopackcalculado.toFixed(2));

         var ganancia4 = $('#ganancia4').val();
        var preciopack4 = costo*(1+(ganancia4/100));
        $('#preciomayor4').val(preciopack4.toFixed(2));
        preciopackcalculado = preciopack4*cantidad;
        $('#preciopack4').val(preciopackcalculado.toFixed(2));
    }