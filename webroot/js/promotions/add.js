$(function () {
    //Date picker
    $('#buscador').change(
        function(){
            var searchkey = $(this).val();
            searchProductos( searchkey );
         });

    $('#formAgregarPromocion').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) { 
            e.preventDefault();
            var searchkey = $('#buscador').val();
            $('#buscador').val('');
            searchProductos( searchkey );
            return false;
        } 
    });    
    $('#buscador').attr('disabled',false);    
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
    $(document).on("click", "a.removepromotion" , function() {
        $(this).parent().remove();
        calcularPromocion();
    });    
    var numDetalle = $("#cantdetalle").val();
    for (var i = 0; i <= numDetalle; i++) {
         calcularProducto(i);
     }
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
    numDetalle++;
    //bueno ahora ya tenemos el producto que vamos a agregar
    //ahora hay que saber exactamente como lo detectamos
    //por que este dato nos permitirá saber si la keyword era del producto o de la caja del producto
    tipoprecio = 'unitario';
    if(producto.promocion==1){
        alert("No se puede agregar una promocion a una promocion.");
        return false;
    }
    if(producto.codigo == keyword){
        tipoprecio = 'unitario';
    }   
    $("#fsDetalles").append(
        $('<div>')
            .attr('id','divPromotion0'+numDetalle)
            .addClass('divDV divPromotion'+numDetalle)
            .append(
                $("<label>")
	                .html(producto.nombre)
                    .addClass('lblPromotion')
                    .attr('style','width:200px;display: inline-flex;text-overflow: ellipsis;overflow: hidden;white-space: nowrap;')
            )
            .append(
                $("<input>")
	                .attr('type','hidden')
	                .attr('name','promotions['+numDetalle+'][id]')
	                .attr('id','promotions-'+numDetalle+'-id]')
            )
            .append(
                $("<input>")
		            .addClass("form-control")
		            .attr('type','hidden')
		            .attr('name','promotions['+numDetalle+'][producto_id]')
		            .attr('id','promotions-'+numDetalle+'-producto_id]')
		            .val(0)
            )
            .append(
                $("<input>")
                    .addClass("form-control")
                    .attr('type','hidden')
                    .attr('name','promotions['+numDetalle+'][productopromocion_id]')
                    .attr('id','promotions-'+numDetalle+'-productopromocion_id]')
                    .val(producto.id)
            )
            .append(
                $("<div>")
                    .append(
                        $("<label>")
                            .attr('for','promotions-'+numDetalle+'-costo')
                            .html('Costo')
                    ).append(
                    $("<input>")
                        .attr('name','promotions['+numDetalle+'][costo]')
                        .attr('id','promotions-'+numDetalle+'-costo')
                        .attr('type','number')
                        .attr('step','any')
                        .attr('title','Costo')
                        .attr('onchange','calcularProducto('+numDetalle+')')
                        .addClass("form-control")
                        .val(producto.costo)
                ).addClass("form-group input number")
            ).append(
                $("<div>")
                    .append(
                        $("<label>")
                            .attr('for','promotions-'+numDetalle+'-ganancia')
                            .html('Ganancia')
                    ).append(
                    $("<input>")
                        .attr('name','promotions['+numDetalle+'][ganancia]')
                        .attr('id','promotions-'+numDetalle+'-ganancia')
                        .attr('type','number')
                        .attr('step','any')
                        .attr('title','Ganancia')
                        .attr('onchange','calcularProducto('+numDetalle+')')
                        .addClass("form-control")
                        .val(producto.ganancia)
                ).addClass("form-group input number")
            ).append(
                $("<div>")
                    .append(
                        $("<label>")
                            .attr('for','promotions-'+numDetalle+'-precio')
                            .html('Precio')
                    ).append(
                    $("<input>")
                        .attr('name','promotions['+numDetalle+'][precio]')
                        .attr('id','promotions-'+numDetalle+'-precio')
                        .attr('type','number')
                        .attr('step','any')
                        .attr('title','Precio')
                        .attr('onchange','calcularGananciaProducto('+numDetalle+')')
                        .addClass("form-control")
                        .val(producto.precio.toFixed(0))
                ).addClass("form-group input number")
            ).append(
                $("<div>")
                    .append(
                        $("<label>")
                            .attr('for','promotions-'+numDetalle+'-cantidad')
                            .html('Cantidad')
                    ).append(
                    $("<input>")
                        .attr('name','promotions['+numDetalle+'][cantidad]')
                        .attr('id','promotions-'+numDetalle+'-cantidad')
                        .attr('type','number')
                        .attr('step','any')
                        .attr('title','Cantidad')
                        .attr('onchange','calcularProducto('+numDetalle+')')
                        .addClass("form-control")
                        .val(1)
                ).addClass("form-group input number")
            ).append(
                $("<div>")
                    .append(
                        $("<label>")
                            .attr('for','promotions-'+numDetalle+'-subtotal')
                            .html('SubTotal')
                    ).append(
                    $("<input>")
                        .val(0)
                        .attr('name','promotions['+numDetalle+'][subtotal]')
                        .attr('id','promotions-'+numDetalle+'-subtotal')
                        .attr('type','number')
                        .attr('step','any')
                        .attr('title','SubTotal')
                        .attr('readonly','readonly')
                        .attr('numDetalle',numDetalle)
                        .addClass("form-control subtotalproducto")
                ).addClass("form-group input number")
            ).append(
                $("<a>")
                    .append(
                        $("<i>")
                            .addClass("fa fa-trash")
                        )
                    .addClass("btn btn-app removepromotion")
                    .attr('style','vertical-align: bottom;width: 37px;height: 34px;padding: 5px 0 0 0;min-width: 0px;margin: -4px 0 15px 3px;;')
            ).append(
                $("</br>")
            )                    
    );
    //$('#promotions-'+numDetalle+'-producto-id').append($options)
    $('#promotions-'+numDetalle+'-producto-id').val(producto)
    calcularProducto(numDetalle);
    $("#cantdetalle").val(numDetalle);
}
function calcularPromocion(){
    var netoPromocion = 0;
    var costoPromocion = 0;
	$('.subtotalproducto').each(function(){
		var numDetalle = $(this).attr('numDetalle');
		var precio = $("#promotions-"+numDetalle+"-precio").val()*1;
        var cantidad = $("#promotions-"+numDetalle+"-cantidad").val()*1;
        var costo = $("#promotions-"+numDetalle+"-costo").val()*1;
        netoPromocion+=precio*cantidad;
        costoPromocion+=costo*cantidad;
	});
    $("#costo").val(costoPromocion);
    $("#precio").val(netoPromocion);
}
function calcularProducto(index){
    var costo = $('#promotions-'+index+'-costo').val();
    var ganancia = $('#promotions-'+index+'-ganancia').val();
    var cantidad = $('#promotions-'+index+'-cantidad').val();
    var precio = costo*(1+(ganancia/100));
    precio=precio.toFixed(0);
    $('#promotions-'+index+'-precio').val(precio);
    $('#promotions-'+index+'-subtotal').val(precio*cantidad);
    calcularPromocion();
}
function calcularGananciaProducto(index){
    var costo = $('#promotions-'+index+'-costo').val();
    var cantidad = $('#promotions-'+index+'-cantidad').val();
    var precio =  $('#promotions-'+index+'-precio').val()*1;
    var ganancia = ((precio/costo)-1)*100;
    $('#promotions-'+index+'-ganancia').val(ganancia);
    $('#promotions-'+index+'-subtotal').val(precio.toFixed(2)*cantidad);
    calcularPromocion();
}
function deletePromotion(promoId,posicion){
    $("#postLinkDelete"+promoId).trigger('click');
}
