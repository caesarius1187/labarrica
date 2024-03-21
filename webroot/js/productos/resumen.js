$(function () {
  var tblProductosResumen = $("#tblProductosResumen").DataTable({
    "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
        }
  });
  $('.datepicker').datepicker({
      autoclose: true,
      format: 'dd-mm-yyyy'
    });
  calcularFooterTotales(tblProductosResumen);
});
function StrToNumber (strNumber){
    if (typeof strNumber === 'string') {
        if(strNumber.charAt(0)=="<"){
            //es un p y no se debe sumar
            strNumber = 0
        }else{
            strNumber = strNumber.replace('.', "");
            strNumber = strNumber.replace('.', "");
            strNumber = strNumber.replace(',', ".");
        }
    }
    return parseFloat(strNumber).toFixed(2)*1;
}
function calcularFooterTotales(mitabla){
        mitabla.columns( '.sum' ).every( function () {
            try {
                var micolumndata = this.data();
                var columnLength = this.data().length;
                if(columnLength > 0){
                    var sum = this
                        .data()
                        .reduce( function (a,b) {
                            if (a != null && b != null) {

                                if (typeof a === 'string') {
                                    a = a.replace('.', "");
                                    a = a.replace('.', "");
                                    a = a.replace(',', ".");
                                }
                                a = Number(a);
                                if (typeof b === 'string') {
                                    b = b.replace('.', "");
                                    b = b.replace('.', "");
                                    b = b.replace(',', ".");
                                }
                                b = Number(b);
                                var resultado = a + b;
                                return resultado;
                            } else {
                                return 0;
                            }
                        } );
                    if (typeof sum === 'string') {
                        sum = sum.replace('.', "");
                        sum = sum.replace('.', "");
                        sum = sum.replace(',', ".");
                        $( this.footer() ).html((sum*1).toFixed(2));
                    }else{
                        $( this.footer() ).html(sum.toFixed(2));
                    }
                }
            }
            catch (e)
            {
                alert(e.message);
            }
        } );
    }
$( "#clickExcel" ).click(function() {
    setTimeout(
        function() 
        {
           var table2excel = new Table2Excel();
            table2excel.export(document.querySelectorAll(".toExcelTable"));
        }, 2000
    );
    
});