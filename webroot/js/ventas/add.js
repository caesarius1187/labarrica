$(function () {
    //Date picker
    $('#fecha').datepicker({
      autoclose: true,
      format: 'dd-mm-yyyy'
    });
   	$("#cliente-id").select2().change(function(){
        $("#pagos-cliente-id").val($(this).val());
    });
    $("#pagos-cliente-id").val($("#cliente-id").val());
    $('#buscador').change(
        function(){
            var searchkey = $(this).val();
            searchProductos( searchkey );
         });
    $("#porcentajedescuento").change(
        function(){
            calcularVenta();
        }
    );
     $("#importedescuento").change(
        function(){
            calcularVenta();
        }
    );
    $('#formAgregarVenta').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) { 
            e.preventDefault();
            var searchkey = $('#buscador').val();
            $('#buscador').val('');
            searchProductos( searchkey );
            return false;
        } 
    });
    CatchFormVenta();
    CatchFormCliente();
    CatchFormProducto();
    
    //Form Add Producto
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
    //FIN Form Add Producto
    //Autocomplete!
    var options = document.getElementById("productoslista");
    var optArray = [];
    for (var i = 0; i < options.length; i++) {
        optArray.push(options[i].text);
    }
    $('#buscador').autocomplete({
        source: function(request, response) {
            var results = $.ui.autocomplete.filter(optArray, request.term);
            response(results.slice(0, 30));
        },
        select: function (event, ui) {        
            var searchkey = ui.item.label;
            $('#buscador').val('');
            var result = searchkey.split('//');
            searchProductos( result[1] );
            return false;
        },
    });
    //Fin Autocomplete
    $('#presupuesto').change(function(){
        calcularVenta();
    });
    $(document).on("click", "a.removedetalleventa" , function() {
        $(this).parent().remove();
        calcularVenta();
    });
    $('#buscador').attr('disabled',false);
    document.addEventListener("keydown", function(e) {
      if (e.keyCode == 83 && (navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey)) {
        e.preventDefault();
        $('#formAgregarVenta').submit();
      }
    }, false);
  });
function searchProductos( keyword ){
    //$("#buscador").val('');
    if(keyword==""){
        return false;
    }
    var data = keyword;
    var url = serverLayoutURL+"/productos/search";
    $.ajax({
        method: 'get',
        url : url,
        data: {keyword:data},
        success: function( response )
        {       
            if(response.productos.length==0){
                $("label[for='buscador']").text("Buscador: NO encontre un producto");
                alert("Buscador: NO encontre un producto");
            }else if(response.productos.length==1){
                $("label[for='buscador']").text("Buscador");
                agregarDetalle(response.productos[0],keyword);
            }else{
                $("label[for='buscador']").text("Buscador: Hay mas de un producto para ese filtro, en total: "+response.productos.length);              
            }
        }
    });
};
function agregarDetalle(producto,keyword){
	var numDetalle = $("#cantdetalle").val();
    //el producto que nos pasan puede ser una promo por lo que vamos a preguntar esto promero que nada
    if(producto.promocion){
        $(producto.promotions).each(function(){
            var miProducto = this.producto;
            $("#fsDetalles").append(
                $('<div>')
                    .attr('id','divDetalleVenta0'+numDetalle)
                    .addClass('divDV divDetalleVenta'+numDetalle)
                    .append(
                        $("<label>")
                            .html(miProducto.nombre)
                            .addClass('lblDetalleVenta')
                            .attr('style','width:200px;display: inline-flex;text-overflow: ellipsis;overflow: hidden;white-space: nowrap;')
                    )
                    .append(
                        $("<input>")
                            .attr('type','hidden')
                            .attr('name','detalleventas['+numDetalle+'][id]')
                            .attr('id','detalleventas-'+numDetalle+'-id]')
                    )
                    .append(
                        $("<input>")
                            .attr('type','hidden')
                            .attr('name','detalleventas['+numDetalle+'][venta_id]')
                            .attr('id','detalleventas-'+numDetalle+'-venta_id]')
                    ).append(
                            $("<input>")
                                .attr('name','detalleventas['+numDetalle+'][costo]')
                                .attr('id','detalleventas-'+numDetalle+'-costo')
                                .attr('type','hidden')
                                .val(this.costo)
                    ).append(
                            $("<input>")
                                .attr('name','detalleventas['+numDetalle+'][ganancia]')
                                .attr('id','detalleventas-'+numDetalle+'-ganancia')
                                .attr('type','hidden')
                                .val(this.ganancia)
                    ).append(
                            $("<input>")
                                .attr('name','detalleventas['+numDetalle+'][tipoprecio]')
                                .attr('id','detalleventas-'+numDetalle+'-tipoprecio')
                                .attr('type','hidden')
                                .val('promocion')
                    ).append(
                        $("<input>")
                            .addClass("form-control")
                            .attr('type','hidden')
                            .attr('name','detalleventas['+numDetalle+'][producto_id]')
                            .attr('id','detalleventas-'+numDetalle+'-producto_id]')
                            .val(miProducto.id)
                    )
                   .append(
                        $("<div>")
                            .append(
                                $("<label>")
                                    .attr('for','detalleventas-'+numDetalle+'-precio')
                                    .html('Precio')
                            )
                            .append(
                                $("<input>")
                                    .attr('name','detalleventas['+numDetalle+'][precio]')
                                    .attr('id','detalleventas-'+numDetalle+'-precio')
                                    .attr('type','number')
                                    .attr('step','any')
                                    .attr('title','Precio')
                                    .attr('onchange','calcularVenta()')
                                    .val(this.precio)
                                    .addClass("form-control")
                            )
                        .addClass("form-group input number")
                    ).append(
                        $("<div>")
                            .append(
                                $("<label>")
                                    .attr('for','detalleventas-'+numDetalle+'-cantidad')
                                    .html('Cantidad')
                            )                           
                            .append(
                            $("<input>")
                                .attr('name','detalleventas['+numDetalle+'][cantidad]')
                                .attr('id','detalleventas-'+numDetalle+'-cantidad')
                                .attr('type','number')
                                .attr('step','any')
                                .attr('title','Cantidad')
                                .attr('onchange','calcularVenta()')
                                .addClass("form-control")
                                .val(this.cantidad)
                        ).addClass("form-group input number")
                    ).append(
                        $("<div>")
                            .append(
                                $("<label>")
                                    .attr('for','detalleventas-'+numDetalle+'-porcentajedescuento')
                                    .html('%Desc')
                            ).append(
                            $("<input>")
                                .attr('name','detalleventas['+numDetalle+'][porcentajedescuento]')
                                .attr('id','detalleventas-'+numDetalle+'-porcentajedescuento')
                                .attr('type','number')
                                .attr('step','any')
                                .attr('placeholder','% Desc')
                                .attr('onchange','calcularVenta()')
                                .attr('title','% Desc')
                                .addClass("form-control")
                        ).addClass("form-group input number")
                    ).append(
                        $("<div>")
                            .append(
                                $("<label>")
                                    .attr('for','detalleventas-'+numDetalle+'-importedescuento')
                                    .html('Imp Desc')
                            ).append(
                            $("<input>")
                                .val(0)
                                .attr('name','detalleventas['+numDetalle+'][importedescuento]')
                                .attr('id','detalleventas-'+numDetalle+'-importedescuento')
                                .attr('type','number')
                                .attr('step','any')
                                .attr('placeholder','Desc')
                                .attr('title','Desc')
                                .addClass("form-control")
                        ).addClass("form-group input number")
                    ).append(
                        $("<div>")
                            .append(
                                $("<label>")
                                    .attr('for','detalleventas-'+numDetalle+'-subtotal')
                                    .html('SubTotal')
                            ).append(
                            $("<input>")
                                .val(0)
                                .attr('name','detalleventas['+numDetalle+'][subtotal]')
                                .attr('id','detalleventas-'+numDetalle+'-subtotal')
                                .attr('type','number')
                                .attr('step','any')
                                .attr('title','SubTotal')
                                .attr('readonly','readonly')
                                .attr('numDetalle',numDetalle)
                                .addClass("form-control subtotalventa")
                        ).addClass("form-group input number")
                    ).append(
                        $("<a>")
                            .append(
                                $("<i>")
                                    .addClass("fa fa-trash")
                                )
                            .addClass("btn btn-app removedetalleventa")
                            .attr('style','vertical-align: bottom;width: 37px;height: 34px;padding: 5px 0 0 0;min-width: 0px;margin: -4px 0 15px 3px;;')
                    ).append(
                        $("</br>")
                    )                    
            );
            numDetalle ++;
            $("#cantdetalle").val(numDetalle);
            calcularVenta();
        });
        return;
    }

    //bueno ahora ya tenemos el producto que vamos a agregar
    //ahora hay que saber exactamente como lo detectamos
    //por que este dato nos permitirá saber si la keyword era del producto o de la caja del producto
    micantidad = 1;
    minombre = producto.nombre;
    miprecio = 0;
    miganancia = 0;
    tipoprecio = 'Precio unitario';
    if(producto.codigo == keyword){
        miprecio = producto.precio;
        miganancia = producto.ganancia;
        tipoprecio = 'Precio unitario';
    }else if(producto.codigopack == keyword){
        miprecio = producto.preciopack;
        miganancia = producto.gananciapack;
        micantidad = producto.cantpack;
        minombre = producto.nombre+"(Pack)";
        tipoprecio = 'Precio pack';
    }else{
        miprecio = producto.precio;
        miganancia = producto.ganancia;
        tipoprecio = 'Precio unitario';
    }
    var myPrecioSelect =  $("<select>")
                            .attr('id','detalleventas-'+numDetalle+'-selectprecio')
                            .attr('name','detalleventas['+numDetalle+'][selectprecio]')
                            .attr('detalleNumero',numDetalle)
                            .addClass("selectPrecio")
                            .append($('<option>', {value:producto.precio, text:'Precio unitario'}))
                            .append($('<option>', {value:producto.preciopack0, text:'Precio pack'}))
                            .append($('<option>', {value:producto.preciopack1, text:'Mayor 1'}))
                            .append($('<option>', {value:producto.preciopack2, text:'Mayor 2'}))
                            .append($('<option>', {value:producto.preciopack3, text:'Mayor 3'}))
                            .append($('<option>', {value:producto.preciopack4, text:'Mayor 4'}))
                            ;
    $("#fsDetalles").append(
        $('<div>')
            .attr('id','divDetalleVenta0'+numDetalle)
            .addClass('divDV divDetalleVenta'+numDetalle)
            .append(
                $("<label>")
	                .html(minombre)
                    .addClass('lblDetalleVenta')
                    .attr('style','width:200px;display: inline-flex;text-overflow: ellipsis;overflow: hidden;white-space: nowrap;')
            )
            .append(
                $("<input>")
	                .attr('type','hidden')
	                .attr('name','detalleventas['+numDetalle+'][id]')
	                .attr('id','detalleventas-'+numDetalle+'-id]')
            )
            .append(
                $("<input>")
	                .attr('type','hidden')
	                .attr('name','detalleventas['+numDetalle+'][venta_id]')
	                .attr('id','detalleventas-'+numDetalle+'-venta_id]')
            ).append(
                    $("<input>")
                        .attr('name','detalleventas['+numDetalle+'][costo]')
                        .attr('id','detalleventas-'+numDetalle+'-costo')
                        .attr('type','hidden')
                        .val(producto.costo)
            ).append(
                    $("<input>")
                        .attr('name','detalleventas['+numDetalle+'][ganancia]')
                        .attr('id','detalleventas-'+numDetalle+'-ganancia')
                        .attr('type','hidden')
                        .val(miganancia)
            ).append(
                $("<input>")
		            .addClass("form-control")
		            .attr('type','hidden')
		            .attr('name','detalleventas['+numDetalle+'][producto_id]')
		            .attr('id','detalleventas-'+numDetalle+'-producto_id]')
		            .val(producto.id)
            )
           .append(
                $("<div>")
                    .append(
                       myPrecioSelect
                    )
                    .append(
                            $("<input>")
                                .attr('name','detalleventas['+numDetalle+'][tipoprecio]')
                                .attr('id','detalleventas-'+numDetalle+'-tipoprecio')
                                .attr('type','hidden')
                                .val(tipoprecio)
                    )
                    .append(
                        $("<input>")
                            .attr('name','detalleventas['+numDetalle+'][precio]')
                            .attr('id','detalleventas-'+numDetalle+'-precio')
                            .attr('type','number')
                            .attr('step','any')
                            .attr('title','Precio')
                            .attr('onchange','calcularVenta()')
                            .val(miprecio)
                            .addClass("form-control")
                    )
                .addClass("form-group input number")
            ).append(
                $("<div>")
                    .append(
                        $("<label>")
                            .attr('for','detalleventas-'+numDetalle+'-cantidad')
                            .html('Cantidad')
                    )
                    .append(
                        $("<span>")
                            .attr('id','detalleventas-'+numDetalle+'-cantpack')
                            .attr('style','display:none')
                            .html(producto.cantpack)
                    )
                    .append(
                        $("<input>")
                            .attr('name','detalleventas['+numDetalle+'][cantidad]')
                            .attr('id','detalleventas-'+numDetalle+'-cantidad')
                            .attr('type','number')
                            .attr('step','any')
                            .attr('title','Cantidad')
                            .attr('onchange','calcularVenta()')
                            .addClass("form-control")
                            .val(micantidad)
                ).addClass("form-group input number")
            ).append(
                $("<div>")
                    .append(
                        $("<label>")
                            .attr('for','detalleventas-'+numDetalle+'-porcentajedescuento')
                            .html('%Desc')
                    ).append(
                    $("<input>")
                        .attr('name','detalleventas['+numDetalle+'][porcentajedescuento]')
                        .attr('id','detalleventas-'+numDetalle+'-porcentajedescuento')
                        .attr('type','number')
                        .attr('step','any')
                        .attr('placeholder','% Desc')
                        .attr('onchange','calcularVenta()')
                        .attr('title','% Desc')
                        .addClass("form-control")
                ).addClass("form-group input number")
            ).append(
                $("<div>")
                    .append(
                        $("<label>")
                            .attr('for','detalleventas-'+numDetalle+'-importedescuento')
                            .html('Imp Desc')
                    ).append(
                    $("<input>")
                        .val(0)
                        .attr('name','detalleventas['+numDetalle+'][importedescuento]')
                        .attr('id','detalleventas-'+numDetalle+'-importedescuento')
                        .attr('type','number')
                        .attr('step','any')
                        .attr('onchange',"calcularPorcentajeDescuentoDetalleVenta('"+numDetalle+"')")
                        .attr('placeholder','Desc')
                        .attr('title','Desc')
                        .addClass("form-control")
                ).addClass("form-group input number")
            ).append(
                $("<div>")
                    .append(
                        $("<label>")
                            .attr('for','detalleventas-'+numDetalle+'-subtotal')
                            .html('SubTotal')
                    ).append(
                    $("<input>")
                        .val(0)
                        .attr('name','detalleventas['+numDetalle+'][subtotal]')
                        .attr('id','detalleventas-'+numDetalle+'-subtotal')
                        .attr('type','number')
                        .attr('step','any')
                        .attr('title','SubTotal')
                        .attr('readonly','readonly')
                        .attr('numDetalle',numDetalle)
                        .addClass("form-control subtotalventa")
                ).addClass("form-group input number")
            ).append(
                $("<a>")
                    .append(
                        $("<i>")
                            .addClass("fa fa-trash")
                        )
                    .addClass("btn btn-app removedetalleventa")
                    .attr('style','vertical-align: bottom;width: 37px;height: 34px;padding: 5px 0 0 0;min-width: 0px;margin: -4px 0 15px 3px;;')
            ).append(
                $("</br>")
            )                    
    );
    numDetalle ++;
    $("#cantdetalle").val(numDetalle);
    calcularVenta();
    $(".selectPrecio").change(function (){
        var precio = $(this).val();
        var numDetalle = $(this).attr('detalleNumero');
        var tipoprecio = $(this).children("option").filter(":selected").text();
       $('#detalleventas-'+numDetalle+'-tipoprecio').val(tipoprecio);
        if(tipoprecio!='Precio unitario'){
             var cantpack =  $('#detalleventas-'+numDetalle+'-cantpack').html();
            var precioUnitario =  precio/cantpack;
            precioUnitario = precioUnitario.toFixed(2);
             $('#detalleventas-'+numDetalle+'-precio').val(precioUnitario);
             $('#detalleventas-'+numDetalle+'-cantidad').val(cantpack);

        }else{
            $('#detalleventas-'+numDetalle+'-precio').val(precio);
             $('#detalleventas-'+numDetalle+'-cantidad').val(1);
        }
        calcularVenta();
    });
}
function calcularPorcentajeDescuentoDetalleVenta(numDetalle){
    var precio = $("#detalleventas-"+numDetalle+"-precio").val();
    var cantidad = $("#detalleventas-"+numDetalle+"-cantidad").val();
    var valorDescuento = $("#detalleventas-"+numDetalle+"-importedescuento").val();
    var SubTotal = precio*cantidad;
    var porcdesc = valorDescuento/SubTotal*100;
    $("#detalleventas-"+numDetalle+"-porcentajedescuento").val(porcdesc.toFixed(2));
    calcularVenta();
}
function calcularVenta(){
	var netoVenta = 0;
    $('.subtotalventa').each(function(){
        var numDetalle = $(this).attr('numDetalle');
        var precio = $("#detalleventas-"+numDetalle+"-precio").val()*1;
        var cantidad = $("#detalleventas-"+numDetalle+"-cantidad").val()*1;
        var totalito = precio*cantidad;
        var porcdesc = $("#detalleventas-"+numDetalle+"-porcentajedescuento").val()*1;
        var desc = totalito*porcdesc/100;
        $("#detalleventas-"+numDetalle+"-importedescuento").val(desc.toFixed(2));
        var subtotal = totalito-desc;
        subtotal = Math.round(subtotal);
        $("#detalleventas-"+numDetalle+"-subtotal").val(subtotal);
        netoVenta += subtotal;
    });
   
    if (!$('#presupuesto').is(':checked')) {
    	
        $("#neto").val(netoVenta);
        var porcDescV = $("#porcentajedescuento").val()*1;
        var impDescV = $("#importedescuento").val()*1;

        if(porcDescV!=0){
            var DescV = netoVenta*porcDescV/100;
        }else{
            var DescV = impDescV;
        }
        
        $("label[for='importedescuento']").text('Total a Descontar: $'+DescV); 
         $("#importedescuento").val(DescV);
        var total = netoVenta-DescV;
        total = Math.round(total);
        $("#total").val(total.toFixed(2));
        $("label[for='total']").text('Total a Pagar: $'+total.toFixed(2)); 
        $("#pagos-importe").val(total.toFixed(2));
    }else{
        
        $("#neto").val(netoVenta);
        var porcDescV = $("#porcentajedescuento").val()*1;
        var impDescV = $("#importedescuento").val()*1;

        if(porcDescV!=0){
            var DescV = netoVenta*porcDescV/100;
        }else{
            var DescV = impDescV;
        }
        
        $("label[for='importedescuento']").text('Total a Descontar: $'+DescV); 
         $("#importedescuento").val(DescV);
        var total = netoVenta-DescV;
        total = Math.round(total);
        $("#total").val(0);
        $("label[for='total']").text('Total a Pagar: $'+total); 
        $("#pagos-importe").val(0);
    }
	
}
function CatchFormVenta(){
    $('#formAgregarVenta').submit(function(){
        //serialize form data
        var formData = $(this).serialize();
        //get form action
        var formUrl = $(this).attr('action');
        $.ajax({
            type: 'POST',
            url: formUrl,
            data: formData,
            beforeSend: function(xhr){
                xhr.setRequestHeader("X-CSRF-Token", $('[name="_csrfToken"]').val());
            },
            success: function(data,textStatus,xhr){
                var respuesta = JSON.parse(data);
                if(respuesta.result=="success"){
                    var venid = respuesta.venid;
                    var vennum = respuesta.vennum;
                    $("#ulPrintLastSales").prepend(
                        $("<li>").append(
                            $("<a>")
                                .html("Imprimir venta numero "+vennum)
                                .attr('href',serverLayoutURL+'/ventas/view/'+venid)
                                .attr('target',"_blank" )
                        ).append(
                            $("<a>")
                                .html("Declarar venta numero "+vennum)
                                .attr('href',serverLayoutURL+'/ventas/declararventa/'+venid)
                                .attr('target',"_blank" )
                        ).append(
                            $("<a>")
                                .html("Declarar e imprimir "+vennum)
                                .attr('href',serverLayoutURL+'/ventas/declararventa/'+venid+'/1')
                                .attr('target',"_blank" )
                        )
                    );
                }else{
                     alert(respuesta.respuesta);
                }
            },
            error: function(xhr,textStatus,error){
                    alert(textStatus);
            }
        });
        //No vamos a esperar la respuesta para acelerar la venta
        //reiniciamos la venta
        $("#cantdetalle").val(0);
        $(".divDV").each(function(){
           $(this).remove();
        });
        calcularVenta();
        var numeroVenta = $("#numero").val()*1;
        numeroVenta = numeroVenta*1+1;
        $("label[for='numero']").text("N Venta "+(numeroVenta));
        $("#numero").val(numeroVenta);
        
        var numeroPago = $("#pagos-numero").val()*1;
        numeroPago = numeroPago*1+1;
        $("label[for='pagos-numero']").text("N Cobro "+(numeroPago));
        $("#pagos-numero").val(numeroPago);
        //reiniciamos todos los "selectables"
        $("#presupuesto").prop('checked', false);
        $("#cliente-id").val(1).change();
        $("#pagos-metodo").val('efectivo').change();
        $("#pagos-descripcion").val('');

        return false;
    });
}
function CatchFormCliente(){
    $('#formAgregarCliente').submit(function(){
        var formData = $(this).serialize();
        var formUrl = $(this).attr('action');
        $.ajax({
            type: 'POST',
            url: formUrl,
            data: formData,
            success: function(data,textStatus,xhr){
                var respuesta = JSON.parse(data);      
                if(respuesta.result == "success"){
                    $("#cliente-id").append($('<option>', {
                        value:respuesta.cliente.id, 
                        text: respuesta.cliente.nombre+" "+respuesta.cliente.CUIT+" "+respuesta.cliente.DNI
                    }));
                    $("#cliente-id").val(respuesta.cliente.id);
                    $("button[data-dismiss='modal']").trigger( "click" );
                }
               
            },
            error: function(xhr,textStatus,error){
                callAlertPopint(textStatus);
            }
        });
        return false;
    });
}
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
                if(respuesta.error!=0){
                    alert(respuesta.response);
                }else{
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
    $('#precio').val(Math.round(precio));
    var gananciapack = $('#gananciapack').val();
    var preciopack = costo*(1+(gananciapack/100));
    var preciopackcalculado = preciopack*cantidad;
    $('#preciopack').val(Math.round(preciopack));
    $('#preciopack0').val(Math.round(preciopackcalculado));

    var ganancia1 = $('#ganancia1').val();
    var preciopack1 = costo*(1+(ganancia1/100));
    $('#preciomayor1').val(Math.round(preciopack1));
    preciopackcalculado = preciopack1*cantidad;
    $('#preciopack1').val(Math.round(preciopackcalculado));

     var ganancia2 = $('#ganancia2').val();
    var preciopack2 = costo*(1+(ganancia2/100));
    $('#preciomayor2').val(Math.round(preciopack2));
    preciopackcalculado = preciopack2*cantidad;
    $('#preciopack2').val(Math.round(preciopackcalculado));

     var ganancia3 = $('#ganancia3').val();
    var preciopack3 = costo*(1+(ganancia3/100));
    $('#preciomayor3').val(Math.round(preciopack3));
    preciopackcalculado = preciopack3*cantidad;
    $('#preciopack3').val(Math.round(preciopackcalculado));

    var ganancia4 = $('#ganancia4').val();
    var preciopack4 = costo*(1+(ganancia4/100));
    $('#preciomayor4').val(Math.round(preciopack4));
    preciopackcalculado = preciopack4*cantidad;
    $('#preciopack4').val(Math.round(preciopackcalculado));
}
