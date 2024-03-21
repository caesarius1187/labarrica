<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Venta $venta
 */

    debug($voucherInfo);
    debug($tiposcomprobantes);

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
</SCRIPT>
<div class="gestionventas view">
    <?php echo $this->Form->button('Imprimir',
                        array('type' => 'button',
                            'class' =>"btn_imprimir",
                            'onClick' => "imprimir()"
                            )
    );
    ?>
    <table cellpadding = "0" cellspacing = "0" class="tblToPrint" style="width: 90%;margin-left: 5%;margin-top: 10px;">
        <tr>
            <td colspan="20" class="tdborder" style="text-align: center;font-size: 14px;padding-left: 53px;">ORIGINAL</td>
        </tr>
        <tr>
            <td class="tdborderleft" style="text-align: center;font-size: 18px;padding-top: 12px">La Barrica</td>
            <td class="tdborderleftrightbottom">
                <label id="lblLetraComprobante" style="text-align: center;font-size: 24px;    width: 100%;">
                    <?php echo getLetraComprobanteById($venta['comprobante_id'],$tiposcomprobantes['respuesta'][0]);  ?>
                </label>
                <label id="lblCodigoComprobante" style="text-align: center;font-size: 8px;    display: block;">
                Cod. <?php echo str_pad($venta['comprobante']['codigo'], 3, "0", STR_PAD_LEFT);?>
                    
                </label>
            </td>
            <td style="" class="tdborderright">
                <label id="lblPalabraComprobante" style="font-size: 18px;margin-top: 12px;    width: 100%;text-align: center;">
                    Presupuesto
                </label>
            </td>
        </tr>
        <tr>
            <td class="tdborderleft"></td>
            <td rowspan="4" class="tdborderbottom"><div class="vl"></div></td>
            <td class="tdborderright">
                Punto de Venta: <?php echo str_pad($venta['puntodeventa']['numero'], 5, "0", STR_PAD_LEFT); ?>
                Comp. Nro: <?php echo str_pad($venta['numero'], 8, "0", STR_PAD_LEFT);?>
            </td>
        </tr>
        <tr>
            <td class="tdborderleft">Raz&oacute;n Social: Romano Ortiz Miguel Angel</td>
            <td class="tdborderright">
                Fecha de emisión: <?php echo $venta['fecha']?>
            </td>
        </tr>
        <tr>
            <td class="tdborderleft">Domicilio Comercial: Zabala 298 </td>
            <td class="tdborderright">
                <label>CUIT: 24250699154</label>
                <label>Ingresos Brutos: 24250699154</label>
            </td>
        </tr>
        <tr>
            <td class="tdborderleftbottom">Condicion frente al IVA: Responsable Inscripto</td>
            <td class="tdborderrightbottom">
                Fecha de Inicio de Actividades: 01-07-2012
            </td>
        </tr>
        <tr> 
            <td class="tdbordertopleft">CUIT: <?php echo h($venta['cliente']['CUIT']); ?></td>
            <td class="tdbordertopright" colspan="2">Apellido y Nombre/Raz&oacute;n Social:<?php echo $venta['cliente']['nombre']; ?></td>       
        </tr>
        <tr>    
            <td class="tdborderleft">Condicion frente al IVA: <?php echo $venta['cliente']['condicioniva'] ?></td>
            <td colspan="2"  class="tdborderright">Domicilio: <?php echo $venta['cliente']['direccion'] ?> </td>
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
                                echo number_format($dv['cantidad'], 2, ",", ".");;
                            ?>
                            </td>
                            <td class="tdWithNumber">
                            <?php
                                echo number_format($dv['precio'], 2, ",", ".");;
                            ?>
                            </td>
                            <td class="tdWithNumber">
                            <?php
                                echo number_format($dv['porcentajedescuento'], 2, ",", ".");;
                            ?>
                            </td>
                            <td class="tdWithNumber">
                            <?php
                                echo number_format($dv['importedescuento'], 2, ",", ".");;
                            ?>
                            </td>
                            <td class="tdWithNumber">
                            <?php
                                echo number_format($dv['subtotal'], 2, ",", ".");;
                            ?>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </td>
        </tr>
        <tr class="tdborderleftrightbottom">
            <td colspan="20" class="tdWithNumber">
                    Subtotal:$ <?php echo number_format($venta['neto'], 2, ",", ".") ?></br>
                    Importe IVA:$ <?php echo number_format($venta['iva'], 2, ",", "."); ?></br>
                    Importe total:$ <?php echo number_format($venta['total'], 2, ",", "."); ?></br>
            </td>
        </tr>        
    </table>
</div>
<?php

function getComprobanteById($compid,$comprobantes){

}
function getLetraComprobanteById($compid,$comprobantes){

    foreach ($comprobantes as $kcomp => $comprobante) {
        if($comprobante->Id==$compid){
            return substr($comprobante->Desc, -1);
        }else{
        }
    }
    return 0;
}
?>