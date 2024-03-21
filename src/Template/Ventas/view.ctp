<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Venta $venta
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
<div class="gestionventas view">
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
    $comprobantesAFIP = $tiposcomprobantes['respuesta'][0];

    //$comprobantesAFIP = json_decode('[{"Id":1,"Desc":"Factura A","FchDesde":"20100917","FchHasta":"NULL"},{"Id":2,"Desc":"Nota de D\u00e9bito A","FchDesde":"20100917","FchHasta":"NULL"},{"Id":3,"Desc":"Nota de Cr\u00e9dito A","FchDesde":"20100917","FchHasta":"NULL"},{"Id":6,"Desc":"Factura B","FchDesde":"20100917","FchHasta":"NULL"},{"Id":7,"Desc":"Nota de D\u00e9bito B","FchDesde":"20100917","FchHasta":"NULL"},{"Id":8,"Desc":"Nota de Cr\u00e9dito B","FchDesde":"20100917","FchHasta":"NULL"},{"Id":4,"Desc":"Recibos A","FchDesde":"20100917","FchHasta":"NULL"},{"Id":5,"Desc":"Notas de Venta al contado A","FchDesde":"20100917","FchHasta":"NULL"},{"Id":9,"Desc":"Recibos B","FchDesde":"20100917","FchHasta":"NULL"},{"Id":10,"Desc":"Notas de Venta al contado B","FchDesde":"20100917","FchHasta":"NULL"},{"Id":63,"Desc":"Liquidacion A","FchDesde":"20100917","FchHasta":"NULL"},{"Id":64,"Desc":"Liquidacion B","FchDesde":"20100917","FchHasta":"NULL"},{"Id":34,"Desc":"Cbtes. A del Anexo I, Apartado A,inc.f),R.G.Nro. 1415","FchDesde":"20100917","FchHasta":"NULL"},{"Id":35,"Desc":"Cbtes. B del Anexo I,Apartado A,inc. f),R.G. Nro. 1415","FchDesde":"20100917","FchHasta":"NULL"},{"Id":39,"Desc":"Otros comprobantes A que cumplan con R.G.Nro. 1415","FchDesde":"20100917","FchHasta":"NULL"},{"Id":40,"Desc":"Otros comprobantes B que cumplan con R.G.Nro. 1415","FchDesde":"20100917","FchHasta":"NULL"},{"Id":60,"Desc":"Cta de Vta y Liquido prod. A","FchDesde":"20100917","FchHasta":"NULL"},{"Id":61,"Desc":"Cta de Vta y Liquido prod. B","FchDesde":"20100917","FchHasta":"NULL"},{"Id":11,"Desc":"Factura C","FchDesde":"20110426","FchHasta":"NULL"},{"Id":12,"Desc":"Nota de D\u00e9bito C","FchDesde":"20110426","FchHasta":"NULL"},{"Id":13,"Desc":"Nota de Cr\u00e9dito C","FchDesde":"20110426","FchHasta":"NULL"},{"Id":15,"Desc":"Recibo C","FchDesde":"20110426","FchHasta":"NULL"},{"Id":49,"Desc":"Comprobante de Compra de Bienes Usados a Consumidor Final","FchDesde":"20130904","FchHasta":"NULL"},{"Id":51,"Desc":"Factura M","FchDesde":"20150522","FchHasta":"NULL"},{"Id":52,"Desc":"Nota de D\u00e9bito M","FchDesde":"20150522","FchHasta":"NULL"},{"Id":53,"Desc":"Nota de Cr\u00e9dito M","FchDesde":"20150522","FchHasta":"NULL"},{"Id":54,"Desc":"Recibo M","FchDesde":"20150522","FchHasta":"NULL"},{"Id":201,"Desc":"Factura de Cr\u00e9dito electr\u00f3nica MiPyMEs (FCE) A","FchDesde":"20190310","FchHasta":"NULL"},{"Id":202,"Desc":"Nota de D\u00e9bito electr\u00f3nica MiPyMEs (FCE) A","FchDesde":"20190310","FchHasta":"NULL"},{"Id":203,"Desc":"Nota de Cr\u00e9dito electr\u00f3nica MiPyMEs (FCE) A","FchDesde":"20190310","FchHasta":"NULL"},{"Id":206,"Desc":"Factura de Cr\u00e9dito electr\u00f3nica MiPyMEs (FCE) B","FchDesde":"20190310","FchHasta":"NULL"},{"Id":207,"Desc":"Nota de D\u00e9bito electr\u00f3nica MiPyMEs (FCE) B","FchDesde":"20190310","FchHasta":"NULL"},{"Id":208,"Desc":"Nota de Cr\u00e9dito electr\u00f3nica MiPyMEs (FCE) B","FchDesde":"20190310","FchHasta":"NULL"},{"Id":211,"Desc":"Factura de Cr\u00e9dito electr\u00f3nica MiPyMEs (FCE) C","FchDesde":"20190310","FchHasta":"NULL"},{"Id":212,"Desc":"Nota de D\u00e9bito electr\u00f3nica MiPyMEs (FCE) C","FchDesde":"20190310","FchHasta":"NULL"},{"Id":213,"Desc":"Nota de Cr\u00e9dito electr\u00f3nica MiPyMEs (FCE) C","FchDesde":"20190310","FchHasta":"NULL"}]');                    ;

    echo $this->Form->button('Imprimir',
                        array('type' => 'button',
                            'class' =>"btn_imprimir",
                            'onClick' => "imprimir()"
                            )
    );
    if(!is_null($venta['comprobantedesde'])){
        if($original){
            echo $this->Html->link( 'ver Facturado', ['controller' => 'Ventas', 'action' => 'view', $venta['id'] , 0]);
        }else{
            echo $this->Html->link( 'ver Original', ['controller' => 'Ventas', 'action' => 'view', $venta['id'] , 1]);
        }   
    }
    $numeroComprobante = getNumeroComprobante($venta,$original);
    $fechaEmision = strtotime($venta['fecha']);
    $cuitEmisor = "24250699154";
    $tipoComprobante = getCodigoComprobanteById($venta['comprobante_id'],$original);
    ?>
    <table cellpadding = "0" cellspacing = "0" class="tblToPrint" style="width: 90%;margin-left: 5%;margin-top: 10px;">
        <tr>
            <td colspan="20" class="tdborder" style="text-align: center;font-size: 14px;">ORIGINAL</td>
        </tr>
        <tr>
            <td class="tdborderleft" style="text-align: center;font-size: 18px;padding-top: 12px">La Barrica</td>
            <td class="tdborderleftrightbottom">
                <label id="lblLetraComprobante" style="text-align: center;font-size: 24px;    width: 100%;">
                    <?php echo getLetraComprobanteById($venta['comprobante_id'],$comprobantesAFIP,$original);  ?>
                </label>
                <label id="lblCodigoComprobante" style="text-align: center;font-size: 8px;    display: block;">
                Cod. <?php echo $tipoComprobante;?>
                    
                </label>
            </td>
            <td style="" class="tdborderright">
                <label id="lblPalabraComprobante" style="font-size: 18px;margin-top: 12px;    width: 100%;text-align: center;">
                    <?= getComprobanteById($venta['comprobante_id'],$comprobantesAFIP,$original) ?>
                </label>
            </td>
        </tr>
        <tr>
            <td class="tdborderleft"></td>
            <td rowspan="4" class="tdborderbottom"><div class="vl"></div></td>
            <td class="tdborderright">
                Punto de Venta: <?= str_pad($venta['puntodeventa']['numero'], 5, "0", STR_PAD_LEFT); ?>
                Comp. Nro: <?= $numeroComprobante ?>
            </td>
        </tr>
        <tr>
            <td class="tdborderleft">Raz&oacute;n Social: Romano Ortiz Miguel Angel</td>
            <td class="tdborderright">
                Fecha de emisión: <?php echo date('d/m/Y', $fechaEmision)?>
            </td>
        </tr>
        <tr>
            <td class="tdborderleft">Domicilio Comercial: Zabala 298 </td>
            <td class="tdborderright">
                <label>CUIT: <?= $cuitEmisor ?></label>
                <label>Ingresos Brutos: <?= $cuitEmisor ?></label>
            </td>
        </tr>
        <tr>
            <td class="tdborderleftbottom">Condicion frente al IVA: Responsable Inscripto</td>
            <td class="tdborderrightbottom">
                Fecha de Inicio de Actividades: 01-07-2012
            </td>
        </tr>
        <tr> 
            <td class="tdbordertopleft">CUIT: <?php echo getCUITCliente($venta,$original); ?></td>
            <td class="tdbordertopright" colspan="2">Apellido y Nombre/Raz&oacute;n Social:<?php echo getNombreCliente($venta,$original); ?></td>       
        </tr>
        <tr>    
            <td class="tdborderleft">Condicion frente al IVA: <?php echo  $venta['condicioniva']!=''?$condicionesiva[$venta['condicioniva']]:''; ?></td>
            <td colspan="2"  class="tdborderright">Domicilio: <?php echo getDireccionCliente($venta,$original); ?> </td>
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
                        if($venta['comprobante_id']!=''){
                            if($comprobantesTipo[$venta['comprobante_id']]=='A'||$comprobantesTipo[$venta['comprobante_id']]=='M'){
                            ?>
                            <th>Alicuota</th>
                            <th>IVA</th>
                            <th>Subtotal</th>
                            <?php } 
                        }?>
                    </tr>
                    <?php
                     foreach ($venta['detalleventas'] as $kdv => $dv){ ?>
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
                                echo number_format(getDetalleVenta($dv,'cantidad',$original), 2, ",", ".");
                            ?>
                            </td>
                            <td class="tdWithNumber">
                            <?php
                                echo number_format(getDetalleVenta($dv,'precio',$original), 2, ",", ".");
                            ?>
                            </td>
                            <td class="tdWithNumber">
                            <?php
                                echo number_format(getDetalleVenta($dv,'porcentajedescuento',$original), 2, ",", ".");;
                            ?>
                            </td>
                            <td class="tdWithNumber">
                            <?php
                                echo number_format(getDetalleVenta($dv,'importedescuento',$original), 2, ",", ".");;
                            ?>
                            </td>
                            <td class="tdWithNumber">
                            <?php
                                echo number_format(getDetalleVenta($dv,'subtotal',$original), 2, ",", ".");;
                            ?>
                            </td>
                            <?php
                            if($venta['comprobante_id']!=''){
                                if($comprobantesTipo[$venta['comprobante_id']]=='A'||$comprobantesTipo[$venta['comprobante_id']]=='M'){
                                ?>
                                <td class="tdWithNumber">
                                <?php
                                    echo number_format(getDetalleVenta($dv,'alicuota',$original), 2, ",", ".");;
                                ?>
                                </td>
                                <td class="tdWithNumber">
                                <?php
                                    echo number_format(getDetalleVenta($dv,'importeiva',$original), 2, ",", ".");;
                                ?>
                                </td>
                                <td class="tdWithNumber">
                                <?php
                                    echo number_format(getDetalleVenta($dv,'subtotalconiva',$original), 2, ",", ".");;
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
                $importeTotal = getVenta($venta,'total',$original);
                if($venta['comprobante_id']!=''){
                    if($comprobantesTipo[$venta['comprobante_id']]=='A'||$comprobantesTipo[$venta['comprobante_id']]=='M'){
                    ?>
                    Subtotal:$ <?php echo number_format(getVenta($venta,'neto',$original), 2, ",", ".") ?></br>
                    Importe IVA:$ <?php echo number_format(getVenta($venta,'iva',$original), 2, ",", "."); ?></br>
                    <?php } 
                }
                ?>
                Importe total:$ <?php echo number_format($importeTotal, 2, ",", "."); ?></br>
            </td>
        </tr>
        <tr class="tdborderleftrightbottom">
            <td colspan="20" class="tdWithNumber" style="padding-top: 5px">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-sm-3">
                        <?php
                            if(!$original){

                        $jsonQR = '{"ver":1,"fecha":"'.date('Y-m-d', $fechaEmision).'","cuit":'.$cuitEmisor.',"ptoVta":'.$venta['puntodeventa']['numero'].',"tipoCmp":'.($tipoComprobante*1).',"nroCmp":'.($numeroComprobante*1).',"importe":'.number_format($importeTotal, 2, ".", "").',"moneda":"PES","ctz":1,"tipoDocRec":80,"nroDocRec":'.getCUITCliente($venta,$original).',"tipoCodAut":"E","codAut":'.$voucherInfo['respuesta'][0]->CodAutorizacion.'}';
                        $urlQR = 'https://www.afip.gob.ar/fe/qr/?p=';
                        $encodedJson = base64_encode($jsonQR);
                        ?>
                        <div id="qrcode" style="float: left;margin-bottom: 2px;"></div>
                        <input type="hidden" class="qr-url" value="<?= $urlQR.$encodedJson; ?> " placeholder="URL or Text"> 
                        <?php } ?>        
                    </div>
                    <div class="col-sm-9" style="font-size: 10px;">
                        <?php echo $this->Html->image('AFIP.png', array('alt' => 'add','id'=>'imgAFIP','class'=>'img_add')); ?></br>
                        <label><b>Comprobante Autorizado</b></label></br>
                        <label>Esta administraci&oacute;n no se responsabiliza por los datos ingresados en el detalle de la operaci&oacute;n</label>
                         <?php
                            if(!$original){
                                echo $voucherInfo['respuesta'][0]->EmisionTipo." N:".$voucherInfo['respuesta'][0]->CodAutorizacion."</br>Fecha de Vencimiento CAE:".date('d-m-Y',strtotime($voucherInfo['respuesta'][0]->FchVto));
                            }
                            ?>
                    </div>
                 
                  </div>
                </div>
                
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
function getCUITCliente($venta,$original){
    if($original){
        return $venta['cliente']['CUIT'];
    }else{
        return $venta['fcuit'];
    }    
}
function getNombreCliente($venta,$original){
    if($original){
        return $venta['cliente']['nombre'];
    }else{
        return $venta['fnombre'];
    }    
}
function getDireccionCliente($venta,$original){
    if($original){
        return $venta['cliente']['direccion'];
    }else{
        return $venta['fdomicilio'];
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
function getNumeroComprobante($venta,$original){
    if($original){ return str_pad($venta->numero, 8, "0", STR_PAD_LEFT); }
    if(!is_null($venta->comprobantedesde)){
        return str_pad($venta->comprobantedesde, 8, "0", STR_PAD_LEFT);
    }else{
        return str_pad($venta->numero, 8, "0", STR_PAD_LEFT);
    }
}
function getVenta($venta,$columna,$original){
    if($original){
        return $venta[$columna];
    }else{
        return $venta['f'.$columna];
    }
}
function getDetalleVenta($detalleventa,$columna,$original){
    if($original){
        return $detalleventa[$columna];
    }else{
        return $detalleventa['f'.$columna];
    }
}
?>