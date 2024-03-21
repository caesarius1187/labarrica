<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Compra $compra
 */
echo $this->Html->script('qrcode', ['block' => true]);

?>
<SCRIPT TYPE="text/javascript">
    function imprimir(){
        $('.main-sidebar').hide();
        $('.main-header').hide();
        $('.btn_imprimir').hide();
        window.print();
        $('.main-sidebar').show();
        $('.main-header').show();
        $('.btn_imprimir').show();
    }
$(function () {
    
    // Clear Previous QR Code
    $('#qrcode').empty();

    var size = 96;
    // Set Size to Match User Input
    $('#qrcode').css({
        'width' : size,
        'height' : size
    })

    // Generate and Output QR Code
    $('#qrcode').qrcode({width: size,height: size,text: $('.qr-url').val()});
}); 
</SCRIPT>
<?php
    $comprobantesTipo=[];
    $comprobantesTipo[1]='A';
    $comprobantesTipo[2]='A';
    $comprobantesTipo[3]='A';
    $comprobantesTipo[6]='B';
    $comprobantesTipo[7]='B';
    $comprobantesTipo[8]='B';
    $comprobantesTipo[4]='A';
    $comprobantesTipo[5]='A';
    $comprobantesTipo[9]='B';
    $comprobantesTipo[10]='B';
    $comprobantesTipo[63]='A';
    $comprobantesTipo[64]='B';
    $comprobantesTipo[34]='A';
    $comprobantesTipo[35]='B';
    $comprobantesTipo[39]='A';
    $comprobantesTipo[40]='B';
    $comprobantesTipo[60]='A';
    $comprobantesTipo[61]='B';
    $comprobantesTipo[11]='C';
    $comprobantesTipo[12]='C';
    $comprobantesTipo[13]='C';
    $comprobantesTipo[15]='C';
    $comprobantesTipo[49]='C';
    $comprobantesTipo[51]='M';
    $comprobantesTipo[52]='M';
    $comprobantesTipo[53]='M';
    $comprobantesTipo[54]='M';
?>
<div class="gestioncompras view">
    <?php 
    $condicionesiva = [
                       1=>"IVA Responsable Inscripto",
                       4=>"IVA Sujeto Exento",
                       5=>"Consumidor Final",
                       6=>"Responsable Monotributo",
                       8=>"Proveedor del Exterior",
                       9=>"Cliente del Exterior",
                       10=>"IVA Liberado - Ley Nº 19.640",
                       11=>"IVA Responsable Inscripto - Agente de Percepción",
                       13=>"Monotributista Social",
                       15=>"IVA No Alcanzado",
                    ];
    //$comprobantesAFIP = $tiposcomprobantes['respuesta'][0];

    $comprobantesAFIP = json_decode('[{"Id":1,"Desc":"Factura A","FchDesde":"20100917","FchHasta":"NULL"},{"Id":2,"Desc":"Nota de D\u00e9bito A","FchDesde":"20100917","FchHasta":"NULL"},{"Id":3,"Desc":"Nota de Cr\u00e9dito A","FchDesde":"20100917","FchHasta":"NULL"},{"Id":6,"Desc":"Factura B","FchDesde":"20100917","FchHasta":"NULL"},{"Id":7,"Desc":"Nota de D\u00e9bito B","FchDesde":"20100917","FchHasta":"NULL"},{"Id":8,"Desc":"Nota de Cr\u00e9dito B","FchDesde":"20100917","FchHasta":"NULL"},{"Id":4,"Desc":"Recibos A","FchDesde":"20100917","FchHasta":"NULL"},{"Id":5,"Desc":"Notas de Compra al contado A","FchDesde":"20100917","FchHasta":"NULL"},{"Id":9,"Desc":"Recibos B","FchDesde":"20100917","FchHasta":"NULL"},{"Id":10,"Desc":"Notas de Compra al contado B","FchDesde":"20100917","FchHasta":"NULL"},{"Id":63,"Desc":"Liquidacion A","FchDesde":"20100917","FchHasta":"NULL"},{"Id":64,"Desc":"Liquidacion B","FchDesde":"20100917","FchHasta":"NULL"},{"Id":34,"Desc":"Cbtes. A del Anexo I, Apartado A,inc.f),R.G.Nro. 1415","FchDesde":"20100917","FchHasta":"NULL"},{"Id":35,"Desc":"Cbtes. B del Anexo I,Apartado A,inc. f),R.G. Nro. 1415","FchDesde":"20100917","FchHasta":"NULL"},{"Id":39,"Desc":"Otros comprobantes A que cumplan con R.G.Nro. 1415","FchDesde":"20100917","FchHasta":"NULL"},{"Id":40,"Desc":"Otros comprobantes B que cumplan con R.G.Nro. 1415","FchDesde":"20100917","FchHasta":"NULL"},{"Id":60,"Desc":"Cta de Vta y Liquido prod. A","FchDesde":"20100917","FchHasta":"NULL"},{"Id":61,"Desc":"Cta de Vta y Liquido prod. B","FchDesde":"20100917","FchHasta":"NULL"},{"Id":11,"Desc":"Factura C","FchDesde":"20110426","FchHasta":"NULL"},{"Id":12,"Desc":"Nota de D\u00e9bito C","FchDesde":"20110426","FchHasta":"NULL"},{"Id":13,"Desc":"Nota de Cr\u00e9dito C","FchDesde":"20110426","FchHasta":"NULL"},{"Id":15,"Desc":"Recibo C","FchDesde":"20110426","FchHasta":"NULL"},{"Id":49,"Desc":"Comprobante de Compra de Bienes Usados a Consumidor Final","FchDesde":"20130904","FchHasta":"NULL"},{"Id":51,"Desc":"Factura M","FchDesde":"20150522","FchHasta":"NULL"},{"Id":52,"Desc":"Nota de D\u00e9bito M","FchDesde":"20150522","FchHasta":"NULL"},{"Id":53,"Desc":"Nota de Cr\u00e9dito M","FchDesde":"20150522","FchHasta":"NULL"},{"Id":54,"Desc":"Recibo M","FchDesde":"20150522","FchHasta":"NULL"},{"Id":201,"Desc":"Factura de Cr\u00e9dito electr\u00f3nica MiPyMEs (FCE) A","FchDesde":"20190310","FchHasta":"NULL"},{"Id":202,"Desc":"Nota de D\u00e9bito electr\u00f3nica MiPyMEs (FCE) A","FchDesde":"20190310","FchHasta":"NULL"},{"Id":203,"Desc":"Nota de Cr\u00e9dito electr\u00f3nica MiPyMEs (FCE) A","FchDesde":"20190310","FchHasta":"NULL"},{"Id":206,"Desc":"Factura de Cr\u00e9dito electr\u00f3nica MiPyMEs (FCE) B","FchDesde":"20190310","FchHasta":"NULL"},{"Id":207,"Desc":"Nota de D\u00e9bito electr\u00f3nica MiPyMEs (FCE) B","FchDesde":"20190310","FchHasta":"NULL"},{"Id":208,"Desc":"Nota de Cr\u00e9dito electr\u00f3nica MiPyMEs (FCE) B","FchDesde":"20190310","FchHasta":"NULL"},{"Id":211,"Desc":"Factura de Cr\u00e9dito electr\u00f3nica MiPyMEs (FCE) C","FchDesde":"20190310","FchHasta":"NULL"},{"Id":212,"Desc":"Nota de D\u00e9bito electr\u00f3nica MiPyMEs (FCE) C","FchDesde":"20190310","FchHasta":"NULL"},{"Id":213,"Desc":"Nota de Cr\u00e9dito electr\u00f3nica MiPyMEs (FCE) C","FchDesde":"20190310","FchHasta":"NULL"}]');                    ;

    echo $this->Form->button('Imprimir',
                        array('type' => 'button',
                            'class' =>"btn_imprimir",
                            'onClick' => "imprimir()"
                            )
    );
    $original = false;
    if(!is_null($compra['comprobantedesde'])){
        if($original){
            echo $this->Html->link( 'ver Facturado', ['controller' => 'Compras', 'action' => 'view', $compra['id'] , 0]);
        }else{
            echo $this->Html->link( 'ver Original', ['controller' => 'Compras', 'action' => 'view', $compra['id'] , 1]);
        }   
    }
    $numeroComprobante = getNumeroComprobante($compra,$original);
    $fechaEmision = strtotime($compra['fecha']);
    $cuitEmisor = "24250699154";
    $tipoComprobante = getCodigoComprobanteById($compra['comprobante_id'],$original);
    ?>
    <table cellpadding = "0" cellspacing = "0" class="tblToPrint" style="width: 90%;margin-left: 5%;margin-top: 10px;">
        <tr>
            <td colspan="20" class="tdborder" style="text-align: center;font-size: 14px;">ORIGINAL</td>
        </tr>
        <tr>
            <td class="tdborderleft" style="text-align: center;font-size: 18px;padding-top: 12px">Compra de La Barrica</td>
            <td class="tdborderleftrightbottom">
                <label id="lblLetraComprobante" style="text-align: center;font-size: 24px;    width: 100%;">
                    <?php echo getLetraComprobanteById($compra['comprobante_id'],$comprobantesAFIP,$original);  ?>
                </label>
                <label id="lblCodigoComprobante" style="text-align: center;font-size: 8px;    display: block;">
                Cod. <?php echo $tipoComprobante;?>
                    
                </label>
            </td>
            <td style="" class="tdborderright">
                <label id="lblPalabraComprobante" style="font-size: 18px;margin-top: 12px;    width: 100%;text-align: center;">
                    <?= getComprobanteById($compra['comprobante_id'],$comprobantesAFIP,$original) ?>
                </label>
            </td>
        </tr>
        <tr>
            <td class="tdborderleft"></td>
            <td rowspan="3" class="tdborderbottom"><div class="vl"></div></td>
            <td class="tdborderright">
                Comp. Nro: <?= $numeroComprobante ?>
            </td>
        </tr>
        <tr>
            <td class="tdborderleft">Raz&oacute;n Social: <?= $compra['cliente']['nombre'] ?></td>
            <td class="tdborderright">
                Fecha de emisión: <?php echo date('d/m/Y', $fechaEmision)?>
            </td>
        </tr>
        <tr>
            <td class="tdborderleft">Domicilio Comercial: Zabala 298 </td>
            <td class="tdborderright">
                <label>CUIT: <?= $compra['cliente']['CUIT'] ?></label>
                <label>Ingresos Brutos: <?= $compra['cliente']['CUIT'] ?></label>
            </td>
        </tr>
        <tr>
            <td class="tdborderleftright" colspan="20">
                <table style="width: 100%" class="tbl_border">
                    <tr>
                        <th>C&oacute;digo</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>% Bonif</th>
                        <th>% Imp. Bonif.</th>
                        <th>Subtotal</th>
                        <?php
                        if($compra['comprobante_id']!=''){
                            if($comprobantesTipo[$compra['comprobante_id']]=='A'||$comprobantesTipo[$compra['comprobante_id']]=='M'){
                            ?>
                            <th>Alicuota</th>
                            <th>IVA</th>
                            <th>Subtotal</th>
                            <?php } 
                        }?>
                    </tr>
                    <?php
                     foreach ($compra['detallecompras'] as $kdv => $dv){ ?>
                        <tr>
                            <td>
                            <?php
                                echo $dv['producto']['codigo']
                            ?>
                            </td>
                            <td>
                            <?php
                                echo $dv['producto']['nombre'];
                            ?>
                            </td>
                            <td class="tdWithNumber">
                            <?php
                                echo number_format(getDetalleCompra($dv,'cantidad',$original), 2, ",", ".");
                            ?>
                            </td>
                            <td class="tdWithNumber">
                            <?php
                                echo number_format(getDetalleCompra($dv,'precio',$original), 2, ",", ".");
                            ?>
                            </td>
                            <td class="tdWithNumber">
                            <?php
                                echo number_format(getDetalleCompra($dv,'porcentajedescuento',$original), 2, ",", ".");;
                            ?>
                            </td>
                            <td class="tdWithNumber">
                            <?php
                                echo number_format(getDetalleCompra($dv,'importedescuento',$original), 2, ",", ".");;
                            ?>
                            </td>
                            <td class="tdWithNumber">
                            <?php
                                echo number_format(getDetalleCompra($dv,'neto',$original), 2, ",", ".");;
                            ?>
                            </td>
                            <?php
                            if($compra['comprobante_id']!=''){
                                if($comprobantesTipo[$compra['comprobante_id']]=='A'||$comprobantesTipo[$compra['comprobante_id']]=='M'){
                                ?>
                                <td class="tdWithNumber">
                                <?php
                                    echo number_format(getDetalleCompra($dv,'alicuota',$original), 2, ",", ".");;
                                ?>
                                </td>
                                <td class="tdWithNumber">
                                <?php
                                    echo number_format(getDetalleCompra($dv,'iva',$original), 2, ",", ".");;
                                ?>
                                </td>
                                <td class="tdWithNumber">
                                <?php
                                    echo number_format(getDetalleCompra($dv,'total',$original), 2, ",", ".");;
                                ?>
                                </td>
                            <?php   } 
                            }?>
                        </tr>
                    <?php } ?>
                </table>
            </td>
        </tr>
       
        <tr class="tdborderleftrightbottom">
            <td colspan="20" class="tdWithNumber" style="padding-top: 5px">
                <?php
                $importeTotal = getCompra($compra,'total',$original);
                if($compra['comprobante_id']!=''){
                    if($comprobantesTipo[$compra['comprobante_id']]=='A'||$comprobantesTipo[$compra['comprobante_id']]=='M'){
                    ?>
                    Subtotal:$ <?php echo number_format(getCompra($compra,'neto',$original), 2, ",", ".") ?></br>
                    Importe IVA:$ <?php echo number_format(getCompra($compra,'iva',$original), 2, ",", "."); ?></br>
                    <?php } 
                }
                ?>
                Importe total:$ <?php echo number_format($importeTotal, 2, ",", "."); ?></br>
            </td>
        </tr>
        <tr>
             <td colspan="20" class="tdWithNumber">
            </td>
        </tr>
    </table>
</div>
<?php

function getComprobanteById($compid,$comprobantes,$original){
    if($original){
        return 'Comprobante no valido como factura';
    }
    foreach ($comprobantes as $kcomp => $comprobante) {
        if($comprobante->Id==$compid){
            return substr($comprobante->Desc, 0,-1);
        }else{

        }
    }
    return 'Comprobante no valido como factura';
}
function getCodigoComprobanteById($compid,$original){
    if($original){ return str_pad(0, 3, "0", STR_PAD_LEFT);}
    if(!is_null($compid)){
        return str_pad($compid, 3, "0", STR_PAD_LEFT);
    }else{
        return str_pad(0, 3, "0", STR_PAD_LEFT);
    }
}
function getCUITCliente($compra,$original){
    if($original){
        return $compra['cliente']['CUIT'];
    }else{
        return $compra['fcuit'];
    }    
}
function getNombreCliente($compra,$original){
    if($original){
        return $compra['cliente']['nombre'];
    }else{
        return $compra['fnombre'];
    }    
}
function getDireccionCliente($compra,$original){
    if($original){
        return $compra['cliente']['direccion'];
    }else{
        return $compra['fdomicilio'];
    }    
}
function getLetraComprobanteById($compid,$comprobantes,$original){
    if($original){ return 0; }
    foreach ($comprobantes as $kcomp => $comprobante) {
        if($comprobante->Id==$compid){
            return substr($comprobante->Desc, -1);
        }else{
        }
    }
    return 0;
}
function getNumeroComprobante($compra,$original){
    if($original){ return str_pad($compra->numero, 8, "0", STR_PAD_LEFT); }
    if(!is_null($compra->comprobantedesde)){
        return str_pad($compra->comprobantedesde, 8, "0", STR_PAD_LEFT);
    }else{
        return str_pad($compra->numero, 8, "0", STR_PAD_LEFT);
    }
}
function getCompra($compra,$columna,$original){
    if($original){
        return $compra[$columna];
    }else{
        return $compra['f'.$columna];
    }
}
function getDetalleCompra($detallecompra,$columna,$original){
    return $detallecompra[$columna];
}
?>