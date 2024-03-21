var gcajaId = 0;
var gcontrolado = false;
$(function () {    
    $('.controlarCajaForm').submit(()=>{
       var formData = $("#formControlarCaja"+gcajaId).serialize();
        //get form action
        var formUrl = $("#formControlarCaja"+gcajaId).attr('action');
      
        $.ajax({
           
            type: 'POST',
            url: formUrl,
            data: formData,
            beforeSend: function(xhr){
                xhr.setRequestHeader("X-CSRF-Token", $("#formControlarCaja"+gcajaId).find('[name="_csrfToken"]').val());
            },
            success: function(data,textStatus,xhr){
                var respuesta = JSON.parse(data);
                alert(respuesta.respuesta);

            },
            error: function(xhr,textStatus,error){
                alert('Error');
            }
        });
        return false;
    });
});

function controlar(cajaId){
    gcajaId = $("#RBContoladaId"+cajaId).val();
    gcontrolado = $("#RBContoladaId"+cajaId).parent().find("[name='controlada']").attr('checked')?1:0;
    $("#formControlarCaja"+cajaId).submit();

}