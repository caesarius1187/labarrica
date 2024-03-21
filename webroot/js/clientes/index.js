$(function () {
    //Date picker
    $('#fecha').datepicker({
      autoclose: true,
      format: 'dd-mm-yyyy'
    });
    CatchFormCliente();
    $("#tblClientes").DataTable( {
        "order": [[0, "ASC" ]],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
        }
    } );
    $('.datepicker').datepicker({
      autoclose: true,
      format: 'dd-mm-yyyy'
    });
});
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
                    $("button[data-dismiss='modal']").trigger( "click" );
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
