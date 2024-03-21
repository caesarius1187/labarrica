$(function () {
    //Date picker
    $('#fecha').datepicker({
      autoclose: true,
      format: 'dd-mm-yyyy'
    });
    $('#buscador').change(
        function(){
            var searchkey = $(this).val();
            searchProductos( searchkey );
         });
    $("#porcentajedescuento").change(
        function(){
            calcularCompra();
        }
    );
    $('#formAgregarCompra').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) { 
            e.preventDefault();
            var searchkey = $('#buscador').val();
            $('#buscador').val('');
            searchProductos( searchkey );
            return false;
        } 
    });
    CatchFormCompra();
    CatchFormCliente();
    CatchFormProducto();
    $('#buscador').attr('disabled',false);
    $('#ganancia').change(function(){
        calcularProducto();
    });
    $('#costo').change(function(){
        calcularProducto();
    });
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
    $(document).on("click", "a.removedetallecompra" , function() {
        $(this).parent().remove();
        calcularCompra();
    });
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
    //bueno ahora ya tenemos el producto que vamos a agregar
    //ahora hay que saber exactamente como lo detectamos
    //por que este dato nos permitirá saber si la keyword era del producto o de la caja del producto
    micantidad = 1;
    minombre = producto.nombre;
    miprecio = producto.costo;
    miganancia = producto.ganancia;
    if(producto.codigo == keyword){
        
    }else if(producto.codigopack == keyword){
        micantidad = producto.cantpack;
        minombre = producto.nombre+"(Pack)";
    }
    $("#fsDetalles").append(
        $('<div>')
            .attr('id','divDetalleCompra0'+numDetalle)
            .addClass('divDV divDetalleCompra'+numDetalle)
            .append(
                $("<label>")
                    .html(minombre)
                    .addClass('lblDetalleCompra')
                    .attr('style','display: inline-block;')
            )
            .append(
                $("<input>")
                    .attr('type','hidden')
                    .attr('name','detallecompras['+numDetalle+'][id]')
                    .attr('id','detallecompras-'+numDetalle+'-id]')
            )
            .append(
                $("<input>")
                    .attr('type','hidden')
                    .attr('name','detallecompras['+numDetalle+'][compra_id]')
                    .attr('id','detallecompras-'+numDetalle+'-compra_id]')
            ).append(
                    $("<input>")
                        .attr('name','detallecompras['+numDetalle+'][costo]')
                        .attr('id','detallecompras-'+numDetalle+'-costo')
                        .attr('type','hidden')
                        .val(producto.costo)
            ).append(
                    $("<input>")
                        .attr('name','detallecompras['+numDetalle+'][ganancia]')
                        .attr('id','detallecompras-'+numDetalle+'-ganancia')
                        .attr('type','hidden')
                        .val(miganancia)
            ).append(
                $("<input>")
                    .addClass("form-control")
                    .attr('type','hidden')
                    .attr('name','detallecompras['+numDetalle+'][producto_id]')
                    .attr('id','detallecompras-'+numDetalle+'-producto_id]')
                    .val(producto.id)
            )
           .append(
                $("<div>").append(
                    $("<input>")
                        .attr('name','detallecompras['+numDetalle+'][precio]')
                        .attr('id','detallecompras-'+numDetalle+'-precio')
                        .attr('type','number')
                        .attr('step','any')
                        .attr('title','Precio')
                        .attr('onchange','calcularCompra()')
                        .val(miprecio)
                        .addClass("form-control")
                ).addClass("form-group input number")
            ).append(
                $("<div>").append(
                    $("<input>")
                        .attr('name','detallecompras['+numDetalle+'][cantidad]')
                        .attr('id','detallecompras-'+numDetalle+'-cantidad')
                        .attr('type','number')
                        .attr('step','any')
                        .attr('title','Cantidad')
                        .attr('onchange','calcularCompra()')
                        .addClass("form-control")
                        .val(micantidad)
                ).addClass("form-group input number")
            ).append(
                $("<div>").append(
                    $("<input>")
                        .attr('name','detallecompras['+numDetalle+'][porcentajedescuento]')
                        .attr('id','detallecompras-'+numDetalle+'-porcentajedescuento')
                        .attr('type','number')
                        .attr('step','any')
                        .attr('placeholder','% Desc')
                        .attr('onchange','calcularCompra()')
                        .attr('title','% Desc')
                        .addClass("form-control")
                ).addClass("form-group input number")
            ).append(
                $("<div>").append(
                    $("<input>")
                        .val(0)
                        .attr('name','detallecompras['+numDetalle+'][importedescuento]')
                        .attr('id','detallecompras-'+numDetalle+'-importedescuento')
                        .attr('type','number')
                        .attr('step','any')
                        .attr('readonly','readonly')
                        .attr('placeholder','Desc')
                        .attr('title','Desc')
                        .addClass("form-control")
                ).addClass("form-group input number")
            ).append(
                $("<div>").append(
                    $("<input>")
                        .val(0)
                        .attr('name','detallecompras['+numDetalle+'][subtotal]')
                        .attr('id','detallecompras-'+numDetalle+'-subtotal')
                        .attr('type','number')
                        .attr('step','any')
                        .attr('title','SubTotal')
                        .attr('readonly','readonly')
                        .attr('numDetalle',numDetalle)
                        .addClass("form-control subtotalcompra")
                ).addClass("form-group input number")
            ).append(
                $("<a>")
                    .append(
                        $("<i>")
                            .addClass("fa fa-trash")
                        )
                    .addClass("btn btn-app removedetallecompra")
                    .attr('style','width: 37px;height: 34px;padding: 5px 0 0 0;min-width: 0px;margin: -4px 0 0 3px;')
            ).append(
                $("</br>")
            )
            
            
    );
    //$('#detallecompras-'+numDetalle+'-producto-id').append($options)
    $('#detallecompras-'+numDetalle+'-producto-id').val(producto)
     numDetalle ++;
    $("#cantdetalle").val(numDetalle);
    calcularCompra();
    //$("#buscador").val('');
}
function calcularCompra(){
    var netoCompra = 0;
    $('.subtotalcompra').each(function(){
        var numDetalle = $(this).attr('numDetalle');
        var precio = $("#detallecompras-"+numDetalle+"-precio").val()*1;
        var cantidad = $("#detallecompras-"+numDetalle+"-cantidad").val()*1;
        var totalito = precio*cantidad;
        var porcdesc = $("#detallecompras-"+numDetalle+"-porcentajedescuento").val()*1;
        var desc = totalito*porcdesc/100;
        $("#detallecompras-"+numDetalle+"-importedescuento").val(desc);
        var subtotal = totalito-desc;
        $("#detallecompras-"+numDetalle+"-subtotal").val(subtotal);
        netoCompra += subtotal;
    });
    $("#neto").val(netoCompra);
    var porcDescV = $("#porcentajedescuento").val()*1;

    var DescV = netoCompra*porcDescV/100;
    $("label[for='importedescuento']").text('Total a Descontar: $'+DescV); 
     $("#importedescuento").val(DescV);
    var total = netoCompra-DescV;
    $("#total").val(total);
    $("label[for='total']").text('Total a Pagar: $'+total); 
}
function calcularProducto(){
    var costo = $('#costo').val();
    var ganancia = $('#ganancia').val();
    var precio = costo*(1+(ganancia/100));
    $('#precio').val(precio.toFixed(2));
    var gananciapack = $('#gananciapack').val();
    var preciopack = costo*(1+(gananciapack/100));
    $('#preciopack').val(preciopack.toFixed(2));
}
function CatchFormCompra(){
    $('#formAgregarCompra').submit(function(){
        //serialize form data
        var formData = $(this).serialize();
        //get form action
        var formUrl = $(this).attr('action');
        $.ajax({
            type: 'POST',
            url: formUrl,
            data: formData,
            success: function(data,textStatus,xhr){
                var respuesta = JSON.parse(data);
                if(respuesta.result=="success"){
                    //reiniciamos la compra
                    $("#cantdetalle").val(0);$
                    $(".divDV").each(function(){
                       $(this).remove();
                    });
                    calcularCompra();
                    $("#numero").val(0);
                }
                    alert(respuesta.respuesta);
                },
            error: function(xhr,textStatus,error){
                    alert(textStatus);
            }
        });
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
                searchProductos(respuesta.producto.codigo);
               
            },
            error: function(xhr,textStatus,error){
                callAlertPopint(textStatus);
            }
        });
        return false;
    });
}