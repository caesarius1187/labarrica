var ventasACargar ;
var listanombres ;
var listadocumentos ;
$(document).ready(function() {
    reloadDatePickers();
    $("#comprobante-id").on('change', function () {
        onChangeComprobante();
    });
    $("#condicioniva").on('change', function () {
        //onChangeCondicionIVA();
    });
    initializeComprobantesTipo();
    initializeAlicuotas();
    initializeCondicionesIVA();
    if($("#impticket").val()==1){
        //selecionamos comprobante B por que vamos a auto enviar el formulario
        $("#comprobante-id").val(6);
    }
    //onChangeComprobante();
    $('input[tipo="number"]').keyup(function(e){
      if (/\D/g.test(this.value))
      {
        // Filter non-digits from input value.
        this.value = this.value.replace(/\D/g, '');
      }
    });
    $("#documento").on('change', function () {
        checkCuit();
    });    
    //GetPointOfSales();
    catchDeclaracionForm();
    //$( "#formDeclaracionAfip input" ).prop( "readonly", 'readonly' ); //Readonly
    $(".fcodigoalicuota").each(function(){
        $(this).on('change', function () {
            var orden = $(this).attr('orden');
            switch($(this).val()){
                case '1' :
                    $("#detalleventas-"+orden+"-falicuota").val(0);
                break;
                case '2' :
                    $("#detalleventas-"+orden+"-falicuota").val(0);
                break;
                case '3' :
                    $("#detalleventas-"+orden+"-falicuota").val(0);
                break;
                case '4' :
                    $("#detalleventas-"+orden+"-falicuota").val(10.5);
                break;
                case '5' :
                    $("#detalleventas-"+orden+"-falicuota").val(21);
                break;
                case '6' :
                    $("#detalleventas-"+orden+"-falicuota").val(27);
                break;
                case '8' :
                    $("#detalleventas-"+orden+"-falicuota").val(5);
                break;
                case '9' :
                    $("#detalleventas-"+orden+"-falicuota").val(2.5);
                break;
            }
            calcularVenta();
        });
    });
    calcularVenta();
    var condicioniva = $("#condicioniva").val();
    if(condicioniva==1){
        $("#comprobante-id").change();
    }else{
        $("#comprobante-id").val("6").change();
    }

});
function checkCuit(){
    var contribuyenteCUIT = $("#documento" ).val();
    var redireccionar = true;
    if($("#documento" ).val().length!=11){
        alert("Faltan digitos en el CUIT hay "+$("#documento" ).val().length+" y deberian ser 11");
        redireccionar = false;
    }
    if(contribuyenteCUIT==""){
        alert("Debe completar el cuit antes de abrir la importacion, sin guion ni espacios");
        redireccionar = false;
    }
    if(!redireccionar){
        $("#documento" ).val('');
    }
    return redireccionar;
}
function loadAlicuotasForm(){
    $('#myModalAddAlicuota').modal('show');
}
var comprobantesTipo = [];
var alicuotas=[];
var condicionesFrenteIVA = [];
function initializeCondicionesIVA(){
    condicionesFrenteIVA["1"]="IVA Responsable Inscripto";
    condicionesFrenteIVA["4"]="IVA Sujeto Exento";
    condicionesFrenteIVA["5"]="Consumidor Final";
    condicionesFrenteIVA["6"]="Responsable Monotributo";
    condicionesFrenteIVA["8"]="Proveedor del Exterior";
    condicionesFrenteIVA["9"]="Cliente del Exterior";
    condicionesFrenteIVA["10"]="IVA Liberado - Ley Nº 19.640";
    condicionesFrenteIVA["11"]="IVA Responsable Inscripto - Agente de Percepción";
    condicionesFrenteIVA["13"]="Monotributista Social";
    condicionesFrenteIVA["15"]="IVA No Alcanzado";
}
function initializeComprobantesTipo(){
    comprobantesTipo[1]='A';
    comprobantesTipo[2]='A';
    comprobantesTipo[3]='A';
    comprobantesTipo[6]='B';
    comprobantesTipo[7]='B';
    comprobantesTipo[8]='B';
    comprobantesTipo[4]='A';
    comprobantesTipo[5]='A';
    comprobantesTipo[9]='B';
    comprobantesTipo[10]='B';
    comprobantesTipo[63]='A';
    comprobantesTipo[64]='B';
    comprobantesTipo[34]='A';
    comprobantesTipo[35]='B';
    comprobantesTipo[39]='A';
    comprobantesTipo[40]='B';
    comprobantesTipo[60]='A';
    comprobantesTipo[61]='B';
    comprobantesTipo[11]='C';
    comprobantesTipo[12]='C';
    comprobantesTipo[13]='C';
    comprobantesTipo[15]='C';
    comprobantesTipo[49]='C';
    comprobantesTipo[51]='M';
    comprobantesTipo[52]='M';
    comprobantesTipo[53]='M';
    comprobantesTipo[54]='M';
}
function initializeAlicuotas(){
    alicuotas[1]=0;
    alicuotas[2]=0;
    alicuotas[3]=0;
    alicuotas[4]=10.5;
    alicuotas[5]=21;
    alicuotas[6]=27;
    alicuotas[8]=5;
    alicuotas[9]=2.5;   
}
function calcularTributo(tributonumero){
    var baseimponible = parseFloat($("#tributo-"+tributonumero+"-baseimponible").val())||0;
    var alicuota = parseFloat($("#tributo-"+tributonumero+"-alicuota").val())||0;
    var importe = baseimponible*alicuota;
    $("#tributo-"+tributonumero+"-importe").val(importe);    
    calcularTotal();
    
}
function conmuteFieldsConIVA(show){
    if(show){
        $(".ventaConIVA").each(function(){
            $(this).parent().show();
        });
        //el precio debe ser Dividido por 1.21 para que sea el neto de la venta
        //a esto se le sumará el iva por lo que volverá a dar el total
        $(".precioDetalleVenta").each(function(){
            var precio = $(this).val();
            var precioOriginal = $(this).attr("precioOriginal")*1;
            //esto deberia ser por la alicuota seleccionada no fijo en 21%
            precioOriginal /= 1.21;
            $(this).val(precioOriginal.toFixed(2));
        });
        $("#divAlicuotas").show();
    }else{
        $(".ventaConIVA").each(function(){
            $(this).parent().hide();
        });
        //el precio debe ser multiplicado por 1.21 para que sea el total de la venta
        //pero al calcular la venta debe ser dividido de nuevo
        $(".precioDetalleVenta").each(function(){
            var precio = $(this).val();
            //esto deberia ser por la alicuota seleccionada no fijo en 21%
            var precioOriginal = $(this).attr("precioOriginal")*1;
            $(this).val(precioOriginal.toFixed(2));
        });
        $("#divAlicuotas").hide();
    }
}
function onChangeComprobante(){
    //limitar Condicion IVA
    var comprobanteElegido = $("#comprobante-id").val();
    var tipoComprobante = comprobantesTipo[comprobanteElegido];
    if(tipoComprobante=="A"||tipoComprobante=="M"){
        $("#condicioniva option[value='1']").show();
        $("#condicioniva option[value='4']").show();
        $("#condicioniva option[value='5']").hide();
        $("#condicioniva option[value='6']").hide();
        $("#condicioniva option[value='8']").show();
        $("#condicioniva option[value='9']").show();
        $("#condicioniva option[value='10']").show();
        $("#condicioniva option[value='11']").show();
        $("#condicioniva option[value='13']").hide();
        $("#condicioniva option[value='15']").show();
        conmuteFieldsConIVA(true);
    }else  if(tipoComprobante=="B"){
        $("#condicioniva option[value='1']").hide();
        $("#condicioniva option[value='4']").show();
        $("#condicioniva option[value='5']").show();
        $("#condicioniva option[value='6']").show();
        $("#condicioniva option[value='8']").hide();
        $("#condicioniva option[value='9']").hide();
        $("#condicioniva option[value='10']").hide();
        $("#condicioniva option[value='11']").hide();
        $("#condicioniva option[value='13']").show();
        $("#condicioniva option[value='15']").hide();
        conmuteFieldsConIVA(true);
    }else  if(tipoComprobante=="C"){
        $("#condicioniva option[value='1']").show();
        $("#condicioniva option[value='4']").show();
        $("#condicioniva option[value='5']").show();
        $("#condicioniva option[value='6']").show();
        $("#condicioniva option[value='8']").show();
        $("#condicioniva option[value='9']").show();
        $("#condicioniva option[value='10']").show();
        $("#condicioniva option[value='11']").show();
        $("#condicioniva option[value='13']").show();
        $("#condicioniva option[value='15']").show();
        conmuteFieldsConIVA(false);
    }
    $('#condicioniva option').each(function () {
        if ($(this).css('display') != 'none') {
            var condicionivaoriginal = $("#condicionivaoriginal").val();
            if(condicionivaoriginal != null){
                $(this).val(condicionivaoriginal);
            }else{
                $(this).prop("selected", true);
            }
            return false;
        }
    });    
    //cargar Numero de Comprobante
    GetLastVoucher();
    calcularVenta();
}
function reloadDatePickers(){
    jQuery(document).ready(function($) {
            $( "input.datepicker" ).datepicker({
                yearRange: "-100:+50",
                changeMonth: true,
                changeYear: true,
                constrainInput: false,
                dateFormat: 'dd-mm-yy',
            });	
            $( "input.datepicker-day-month" ).datepicker({
                yearRange: "-100:+50",
                changeMonth: true,
                changeYear: false,
                constrainInput: false,
                dateFormat: 'dd-mm',
            });	
            $( "input.datepicker-month-year" ).datepicker({
                yearRange: "-100:+50",
                changeMonth: true,
                changeYear: true,
                constrainInput: false,
                dateFormat: 'mm-yy',
            });	
            $( "input.datepicker-year" ).datepicker({
                yearRange: "-100:+50",
                changeMonth: false,
                changeYear: true,
                constrainInput: false,
                dateFormat: 'yy',
            });	
    });		
}

function addComprobanteAsociado(){
    var numComprobante = $("#cantComprobantesAsociados").val();
    
    var $options = $("#comprobante-id > option").clone();
    var labelTipo = "";
    var labelpuntoventa = "";
    var labelnumero = "";
    var labelCuit = "";
    if(numComprobante==0){
        var labelTipo = $("<label>")
                        .val(0)
                        .attr('for','comprobantesAsociado'+numComprobante+'Tipo')
                        .html('Tipo');
        var labelpuntoventa = $("<label>")
                        .val(0)
                        .attr('for','comprobantesAsociado'+numComprobante+'Puntodeventa')
                        .html('Punto de Venta');
        var labelnumero = $("<label>")
                        .val(0)
                        .attr('for','comprobantesAsociado'+numComprobante+'Numero')
                        .html('Num. Comp.');
        var labelCuit = $("<label>")
                        .val(0)
                        .attr('for','comprobantesAsociado'+numComprobante+'Cuit')
                        .html('CUIT');
    }
   
    
    $("#divComprobantes").append(
        $('<div>')
            .attr('id','divComprobante0'+numComprobante)
            .addClass('divComprobanteAsociado')
            .append(
                $("<div>").append(
                    labelTipo
                ).append(
                    $("<select>")
                        .val(0)
                        .attr('id','comprobantesasociado-'+numComprobante+'-tipo')
                        .attr('name','data[Venta][0][Comprobantesasociado]['+numComprobante+'][tipo]')
                        .attr('type','select')
                ).addClass("input select")            
            ).append(
                $("<div>").append(
                    labelpuntoventa
                ).append(
                    $("<input>")
                        .val(0)
                        .attr('id','comprobantesasociado-'+numComprobante+'-puntodeventa')
                        .attr('name','data[Venta][0][Comprobantesasociado]['+numComprobante+'][puntodeventa]')
                        .attr('type','text')
                ).addClass("input text")
            ).append(
                $("<div>").append(
                    labelnumero
                ).append(
                    $("<input>")
                        .val(0)
                        .attr('id','comprobantesasociado-'+numComprobante+'-numero')
                        .attr('name','data[Venta][0][Comprobantesasociado]['+numComprobante+'][numero]')
                        .attr('type','text')
                ).addClass("input text")
            ).append(
                $("<div>").append(
                    labelCuit
                ).append(
                    $("<input>")
                        .val(0)
                        .attr('id','comprobantesasociado-'+numComprobante+'-cuit')
                        .attr('name','data[Venta][0][Comprobantesasociado]['+numComprobante+'][cuit]')
                        .attr('type','text')
                ).addClass("input text")
            ).append(
                $("</br>")
            )
    );
    $('#comprobantesasociado'+numComprobante+'Tipo').append($options)
    numComprobante ++;
    $("#cantComprobantesAsociados").val(numComprobante);
}
function addCaposOpcionales(){
    var numComprobante = $("#cantCamposOpcionales").val();
    var $options = $("#tiposopcionales > option").clone();
    var labelTipo = "";
    var labelImporte = "";
    if(numComprobante==0){
        var labelTipo = $("<label>")
                        .val(0)
                        .attr('for','camposopcionale-'+numComprobante+'-idafip')
                        .html('Tipo');
        var labelImporte = $("<label>")
                        .val(0)
                        .attr('for','camposopcionale-'+numComprobante+'-valor')
                        .html('Importe');
     
    }
   
    
    $("#divOpcionales").append(
        $('<div>')
            .attr('id','divOpcionales0'+numComprobante)
            .addClass('divOpcionale')
            .append(
                $("<div>").append(
                    labelTipo
                ).append(
                    $("<select>")
                        .val(0)
                        .attr('id','camposopcionale-'+numComprobante+'-idafip')
                        .attr('name','data[Venta][0][Camposopcionale]['+numComprobante+'][idafip]')
                        .attr('type','select')
                ).addClass("input select")            
            ).append(
                $("<div>").append(
                    labelImporte
                ).append(
                    $("<input>")
                        .val(0)
                        .attr('id','camposopcionale-'+numComprobante+'-valor')
                        .attr('name','data[Venta][0][Camposopcionale]['+numComprobante+'][valor]')
                        .attr('type','text')
                ).addClass("input text")
            ).append(
                $("</br>")
            )
    );
    $('#camposopcionale'+numComprobante+'Idafip').append($options)
    numComprobante ++;
    $("#cantCamposOpcionales").val(numComprobante);
}
function catchDeclaracionForm(){
    $('#formDeclaracionAfip').submit(function(){
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
                    alert("La venta se ha enviado con exito.");
                    var ventaid =respuesta.datosenviados.ventaguardada.id;
                    //aca vamos a ver si es un ticket entonces vamos a mandar a vista de ticket b
                    if($("#impticket").val()==1){
                        var url = serverLayoutURL+'/ventas/ticketb/'+ventaid;
                    }else{
                        var url = serverLayoutURL+'/ventas/view/'+ventaid;    
                    }
                    window.location = url;
                }else{
                    alert(respuesta.response);
                }
            },
            error: function(xhr,textStatus,error){
                    alert(textStatus);
            }
        });        
        return false;
    });
}
function loadServerStatus(){
    $.ajax({
        type: 'POST',
        url: 'http://localhost/conta/ventas/afipgetserverstatus',
        data: '',
        success: function(data,textStatus,xhr){
            var respuesta = JSON.parse(data);
            alert(respuesta.respuesta);            
        },
        error: function(xhr,textStatus,error){
            alert(textStatus);
        }
    });
   
}
function GetListOf(method){
     $.ajax({
        type: 'GET',
        url: 'http://localhost/conta/ventas/afipget/'+method,
        data: '',
        success: function(data,textStatus,xhr){
            var respuesta = JSON.parse(data);
            alert(respuesta.respuesta);            
        },
        error: function(xhr,textStatus,error){
            alert(textStatus);
        }
    });
}

function GetLastVoucher(){
    var ptoventa = parseInt($("#puntodeventas-id").val());
    var tipoComprobante = $("#comprobante-id option:selected").val();
     $.ajax({
        type: 'GET',
        url: serverLayoutURL+'/ventas/getlastvoucher/'+ptoventa+'/'+tipoComprobante,
        data: '',
        success: function(data,textStatus,xhr){
            var respuesta = JSON.parse(data);
            var nextComp = respuesta.response*1 + 1 
            $("#comprobantedesde").val(nextComp);                        
            $("#comprobantehasta").val(nextComp);  

            //esto se debe ejecutar al ultimo, si es ticket B entonces se debe auto enviar e imprimir
            //lo ponemos aca por que es lo unico que necesitamos tener para poder auto enviar la venta
            if($("#impticket").val()==1){                
                $('#formDeclaracionAfip').submit();
            }

        },
        error: function(xhr,textStatus,error){
            alert('Error combinacion de punto de venta y comprobante incorrecta. Pruebe otra.');
            $("#comprobantedesde").val(-1);      
            $("#comprobantehasta").val(-1);      
        }
    });
}
function GetPointOfSales(){
     $.ajax({
        type: 'GET',
        url: 'http://localhost/conta/ventas/GetPointOfSales',
        data: '',
        success: function(data,textStatus,xhr){
            var respuesta = JSON.parse(data);
            var err = checkErrors(respuesta.respuesta.respuesta)
            if(err!=-1){
                alert("Consulta de Puntos de ventas habilitados para Factuweb-Metodo:"+err.Msg+" Error:"+err.Code);
                return;
            }
        },
        error: function(xhr,textStatus,error){
            alert('Error combinacion de punto de venta y comprobante incorrecta. Pruebe otra.');
        }
    });
}
function checkErrors(respuesta){
    if(respuesta[0].hasOwnProperty('Errors')){
        var error = Array.isArray(respuesta[0].Errors.Err)?respuesta[0].Errors.Err[0]:respuesta[0].Errors.Err;
            return error;
    }else{
        return -1;
    }
}
function calcularVenta(){
    var netoVenta = 0;
    var ivaTotal = 0;
    var tributosTotal = 0;
    var ivanogravado = 0;
    var ivaexento = 0;
    var iva000 = 0;
    var iva105 = 0;
    var iva210 = 0;
    var iva270 = 0;
    var iva050 = 0;
    var iva025 = 0;
    var ivaBasenogravado = 0;
    var ivaBaseexento = 0;
    var ivaBase000 = 0;
    var ivaBase105 = 0;
    var ivaBase210 = 0;
    var ivaBase270 = 0;
    var ivaBase050 = 0;
    var ivaBase025 = 0;
    //recalculando productos
    $('.subtotalventa').each(function(){
        var numDetalle = $(this).attr('numDetalle');
        var precio = $("#detalleventas-"+numDetalle+"-fprecio").val()*1;
        var cantidad = $("#detalleventas-"+numDetalle+"-fcantidad").val()*1;
        var totalito = precio*cantidad;
        var porcdesc = $("#detalleventas-"+numDetalle+"-fporcentajedescuento").val()*1;
        var desc = totalito*porcdesc/100;
        $("#detalleventas-"+numDetalle+"-fimportedescuento").val(desc.toFixed(2));
        var subtotal = totalito-desc;
        //subtotal = Math.round(subtotal);
        $("#detalleventas-"+numDetalle+"-fsubtotal").val(subtotal.toFixed(2));
        var alicuota =  $("#detalleventas-"+numDetalle+"-falicuota").val();
        var comprobanteElegido = $("#comprobante-id").val();
        var tipoComprobante = comprobantesTipo[comprobanteElegido];
        if(tipoComprobante=="A"||tipoComprobante=="M"||tipoComprobante=="B"){
            subtotal = subtotal/(1);
        }else{
            //primero lo llevamos al neto y dsp le sacamos el iva
            alicuota = 0;
            subtotal = subtotal/(1+(alicuota/100));
        }
        netoVenta += subtotal;
        var importeIVA = subtotal*(alicuota/100);
        $("#detalleventas-"+numDetalle+"-fimporteiva").val(importeIVA.toFixed(2));
        var subtotalConIVa =  importeIVA + subtotal;
        $("#detalleventas-"+numDetalle+"-fsubtotalconiva").val(subtotalConIVa.toFixed(2));
        switch ($("#detalleventas-"+numDetalle+"-fcodigoalicuota").val()){
            case '1' :
            //0
            ivaexento+=importeIVA;
            ivaBaseexento+=subtotal;
            break;
            case '2' :
            //0
            ivanogravado+=importeIVA;
            ivaBasenogravado+=subtotal;
            break;
            case '3' :
            //0
            iva000+=importeIVA;
            ivaBase000+=subtotal;
            break;
            case '4' :
            //0
            iva105+=importeIVA;
            ivaBase105+=subtotal;
            break;
            case '5' :
            //0
            iva210+=importeIVA;
            ivaBase210+=subtotal;
            break;
            case '6' :
            //0
            iva270+=importeIVA;
            ivaBase270+=subtotal;
            break;
            case '8' :
            //0
            iva050+=importeIVA;
            ivaBase050+=subtotal;
            break;
            case '9' :
            //0
            iva025+=importeIVA;
            ivaBase025+=subtotal;
            break;
        }
    });
    //ivaexento
    $(".baseimponibleAlicuota1").each(function(){
        $(this).val(ivaBaseexento.toFixed(2));
        var orden = $(this).attr('orden');
        $("#alicuotas-"+orden+"-importe").val(ivaexento.toFixed(2));
    });
    //ivanogravado
    $(".baseimponibleAlicuota2").each(function(){
        $(this).val(ivaBasenogravado.toFixed(2));
        var orden = $(this).attr('orden');        
        $("#alicuotas-"+orden+"-importe").val(ivanogravado.toFixed(2));
    });
    //iva000
    $(".baseimponibleAlicuota3").each(function(){
        $(this).val(ivaBase000.toFixed(2));
        var orden = $(this).attr('orden');
        $("#alicuotas-"+orden+"-importe").val(iva000.toFixed(2));
    });
    //iva105
    $(".baseimponibleAlicuota4").each(function(){
        $(this).val(ivaBase105.toFixed(2));
        var orden = $(this).attr('orden');
        $("#alicuotas-"+orden+"-importe").val(iva105.toFixed(2));
    });
    //iva210
    $(".baseimponibleAlicuota5").each(function(){
        $(this).val(ivaBase210.toFixed(2));
        var orden = $(this).attr('orden');
        $("#alicuotas-"+orden+"-importe").val(iva210.toFixed(2));
    });
    //iva270
    $(".baseimponibleAlicuota6").each(function(){
        $(this).val(ivaBase270.toFixed(2));
        var orden = $(this).attr('orden');
        $("#alicuotas-"+orden+"-importe").val(iva270.toFixed(2));
    });
    //iva050
    $(".baseimponibleAlicuota8").each(function(){
        $(this).val(ivaBase050.toFixed(2));
        var orden = $(this).attr('orden');
        $("#alicuotas-"+orden+"-importe").val(iva050.toFixed(2));
    });
    //iva025
    $(".baseimponibleAlicuota9").each(function(){
        $(this).val(ivaBase025.toFixed(2));
        var orden = $(this).attr('orden');
        $("#alicuotas-"+orden+"-importe").val(iva025.toFixed(2));
    });
    $('.importeIvaAlicuota').each(function(){
        ivaTotal += $(this).val()*1;
    });
    $("#fneto").val(netoVenta.toFixed(2));
    var ivaexento = $("#fimportenetoivaexento").val();
    var total = netoVenta*1+ivaTotal*1+ivaexento*1;
    $("#ftotal").val(total.toFixed(2));
    $("#fiva").val(ivaTotal.toFixed(2));
    $("label[for='ftotal']").text('Total a Pagar: $'+total.toFixed(2)); 
}