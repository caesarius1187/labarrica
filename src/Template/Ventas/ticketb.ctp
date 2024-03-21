<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Venta $venta
 */
echo $this->Html->script('qrcode', ['block' => true]);


?>
<SCRIPT TYPE="text/javascript">
$(document).ready(function() {
     // Clear Previous QR Code
    $('#qrcode').empty();

    var size = 160;
    // Set Size to Match User Input
    $('#qrcode').css({
        'width' : size,
        'height' : size
    })

    // Generate and Output QR Code
    $('#qrcode').qrcode({width: size,height: size,text: $('.qr-url').val()});

    //imprimir();
    });
function imprimir(){
    $('.main-sidebar').hide();
    $('.main-header').hide();
    $('.btn_imprimir').hide();
    $('.main-footer').hide();
    $('.dontPrint').hide();
    $('iframe').hide();
    setTimeout(
      function() 
      {
        window.print();
        $('.main-sidebar').show();
        $('.main-header').show();
        $('.btn_imprimir').show();
        $('.main-footer').show();
        $('.dontPrint').show();
        $('iframe').show();
      }, 2000);
}
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
    echo $this->Form->button('Imprimir',
                        array('type' => 'button',
                            'class' =>"btn_imprimir dontPrint",
                            'onClick' => "imprimir()"
                            )
    );
    if(!is_null($venta['comprobantedesde'])){
        if($original){
            echo $this->Html->link( 'ver Facturado', ['controller' => 'Ventas', 'action' => 'view', $venta['id'] , 0],['class'=>'dontPrint']);
        }else{
            echo $this->Html->link( 'ver Original', ['controller' => 'Ventas', 'action' => 'view', $venta['id'] , 1],['class'=>'dontPrint']);
        }   
    }
    ?>
    <table cellpadding = "0" cellspacing = "0" class="tblToPrint" style="width: 155px;margin-left: 5%;margin-top: 10px;font-size: 8px">
        <tr>
            <td class="tdborderlefttoprightbottom" style="text-align: center;font-size: 18px;padding-top: 12px">La Barrica</td>
        </tr>
        <tr>
            <td class="tdborderleftright">Romano Ortiz Miguel Angel</td>
        </tr>
        <tr>
            <td class="tdborderleftright">
                <label>C.U.I.T.: 24250699154</label>
            </td>
        </tr>
        <tr>
            <td class="tdborderleftright">
                <label>Ingresos Brutos: 24250699154</label>
            </td>
        </tr>
        <tr>
            <td class="tdborderleftright">Domicilio Comercial: Zabala 298 </td>
        </tr>
        <tr>
            <td class="tdborderleftright">
                Inicio de Actividades: 01/07/2012
            </td>
        </tr>
        <tr>
            <td class="tdborderleftrightbottom">IVA Responsable Inscripto</td>            
        </tr>
        <tr>
            <td class="tdborderleftright text-center">Original</td>            
        </tr>
        <tr>
            <td class="tdborderleftright">
                <label id="lblLetraComprobante" style="width: 100%;">
                    Factura <?php echo getLetraComprobanteById($venta['comprobante_id'],$comprobantesAFIP,$original); ?>
                     Num: <?= str_pad($venta['puntodeventa']['numero'], 5, "0", STR_PAD_LEFT)."-".getNumeroComprobante($venta,$original) ?>
                </label>
            </td>
        </tr>
        <tr>
            <td class="tdborderleftrightbottom" >Fecha: <?php echo $venta['fecha']->i18nFormat('dd/MM/yyyy')?> Hora: <?php echo $venta['created']->i18nFormat('HH:mm:ss')?></td>
        </tr>
        <tr> 
            <td class="tdborderleftright"><?php echo getNombreCliente($venta,$original); ?></td>       
        </tr>
        <tr> 
            <td class="tdborderleftright">CUIT: <?php echo getCUITCliente($venta,$original); ?></td>
        </tr>
          <tr>
            <td class="tdborderleftright" colspan="20">
                <table style="width: 100%" class="tbl_border">
                    <?php
                     foreach ($venta['detalleventas'] as $kdv => $dv){ ?>
                        <tr>
                            <td class="text-left">
                            <?php
                                echo /*$dv['producto']['codigo']." ".*/$dv['producto']['nombre'];
                            ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">
                            <?php
                                //si es factura B le vamos a sumar el iva

                                $precio = getDetalleVenta($dv,'precio',$original);
                                $iva = getDetalleVenta($dv,'importeiva',$original);
                                $cantidad = getDetalleVenta($dv,'cantidad',$original);
                                if($comprobantesTipo[$venta['comprobante_id']]=='B'){
                                    $precio += ($iva/$cantidad);
                                }
                                echo number_format($cantidad, 2, ",", ".")."*".number_format($precio , 2, ",", ".")."=";

                                if(!$original){
                                    $subtotalconiva = getDetalleVenta($dv,'subtotalconiva',$original);
                                    //
                                    $subtotalconivaRounded = round ( $subtotalconiva , 0 , PHP_ROUND_HALF_EVEN); 
                                    echo number_format($subtotalconiva, 2, ",", ".");
                                }else{
                                    echo number_format(getDetalleVenta($dv,'subtotal',$original), 2, ",", ".");
                                }
                            ?>
                            </td>
                        </tr>
                        <?php
                        if(getDetalleVenta($dv,'importedescuento',$original)*1!=0){
                            ?>
                            <tr>    
                                <td class="text-right">
                                <?php
                                    echo number_format(getDetalleVenta($dv,'porcentajedescuento',$original), 2, ",", ".")." ".number_format(getDetalleVenta($dv,'importedescuento',$original), 2, ",", ".");
                                ?>
                                </td>
                            </tr>
                            <?php
                        }
                        /*
                        ?>
                        <tr>
                            <td class="tdWithNumber">
                            <?php
                                if(!$original){
                                    $subtotalconiva = getDetalleVenta($dv,'subtotalconiva',$original);
                                    //
                                    $subtotalconivaRounded = round ( $subtotalconiva , 0 , PHP_ROUND_HALF_EVEN); 
                                    echo number_format($subtotalconiva, 2, ",", ".");
                                }else{
                                    echo number_format(getDetalleVenta($dv,'subtotal',$original), 2, ",", ".");
                                }
                                
                            ?>
                            </td>
                        </tr>
                            <?php *//*
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
                            } ?>
                        </tr>
                    <?php  */ } ?>
                </table>
            </td>
        </tr>
        <tr class="tdborderleftrightbottom">
            <td colspan="20" class="tdWithNumber" style="font-size: 12px;">
                <?php
                if($venta['comprobante_id']!=''){
                    if($comprobantesTipo[$venta['comprobante_id']]=='A'||$comprobantesTipo[$venta['comprobante_id']]=='M'){
                    ?>
                    Subtotal:$ <?php echo number_format(getVenta($venta,'neto',$original), 2, ",", ".") ?></br>
                    Importe IVA:$ <?php echo number_format(getVenta($venta,'iva',$original), 2, ",", "."); ?></br>
                    <?php } 
                }?>
                Importe total:$ <?php echo number_format(getVenta($venta,'total',$original), 2, ",", "."); ?></br>
            </td>
        </tr>       
        <tr class="tdborderleftrightbottom">
            <td colspan="20" class="tdWithNumber" style="font-size: 12px;">
                <div class="container-fluid">
                    <div class="row">
                      <div class="col-sm-12">
                        <?php
                        $fechaEmision = strtotime($venta['fecha']);
                        $cuitEmisor = "24250699154";
                        $tipoComprobante = getCodigoComprobanteById($venta['comprobante_id'],$original);
                        $numeroComprobante = getNumeroComprobante($venta,$original);
                        $importeTotal = getVenta($venta,'total',$original);

                        $jsonQR = '{"ver":1,"fecha":"'.date('Y-m-d', $fechaEmision).'","cuit":'.$cuitEmisor.',"ptoVta":'.$venta['puntodeventa']['numero'].',"tipoCmp":'.($tipoComprobante*1).',"nroCmp":'.($numeroComprobante*1).'  ,"importe":'.number_format($importeTotal, 2, ".", "").',"moneda":"PES","ctz":1,"tipoDocRec":80,"nroDocRec":'.getCUITCliente($venta,$original).',"tipoCodAut":"E","codAut":'.$voucherInfo['respuesta'][0]  ->CodAutorizacion.'}';
                        $urlQR = 'https://www.afip.gob.ar/fe/qr/?p=';
                        $encodedJson = base64_encode($jsonQR);
                        ?>
                        <div id="qrcode" style="float: left;margin-bottom: 5px;width: 96px;margin-left: 2%;height: 96px;margin-top: 5px;;"></div>
                        <input type="hidden" class="qr-url" value="<?= $urlQR.$encodedJson; ?> " placeholder="URL or Text">         
                      </div>
                      <div class="col-sm-12" style="font-size: 6px;">
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
                <?php
                if(!$original){
                    echo $voucherInfo['respuesta'][0]->EmisionTipo." N:".$voucherInfo['respuesta'][0]->CodAutorizacion."-Vencimiento:".date('d-m-Y',strtotime($voucherInfo['respuesta'][0]->FchVto));
                }
                ?>
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