<?php
use Cake\Routing\Router;
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Compra[]|\Cake\Collection\CollectionInterface $compras
 */
$this->Html->css([
    'AdminLTE./plugins/datatables/dataTables.bootstrap',
  ],
  ['block' => 'css']);

$this->Html->script([
  'AdminLTE./plugins/datatables/jquery.dataTables.min',
  'AdminLTE./plugins/datatables/dataTables.bootstrap.min',
],
['block' => 'script']);
?>

<?php $this->start('scriptBottom'); ?>
<script>
  $(function () {
    $("#tblCaja").DataTable();
  });
</script>
<?php $this->end(); 
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Caja $caja
 */
$totalCierre = 0;
$totalPagos = 0;
$totalPagosVisa = 0;
$totalPagosMastercard = 0;
$totalPagosCuentaCorriente = 0;
$totalPagosOtros = 0;
$totalCobros = 0;
$totalCobrosVisa = 0;
$totalCobrosMastercard = 0;
$totalCobrosCuentaCorriente = 0;
$totalCobrosOtros = 0;
$totalExtracciones = 0;
$totalDepositos = 0;
$eventos = [];
$visa = [];
$mastercard = [];
$cuentacorriente = [];
$otros = [];
foreach ($pagos as $kv => $pago) {
    $creadoTS = $pago['created'];
    $creado = $creadoTS->i18nFormat('dd HH:mm:ss');
    
    if($pago['metodo']=='visa'){
        $visa[$creado] = [];
        $visa[$creado]['monto'] = $pago['importe'];
        $visa[$creado]['concepto'] = $pago['descripcion'];
        $visa[$creado]['descripcion'] = $pago['descripcion'];
    }else if($pago['metodo']=='mastercard'){
        $mastercard[$creado] = [];
        $mastercard[$creado]['monto'] = $pago['importe'];
        $mastercard[$creado]['concepto'] = $pago['descripcion'];
        $mastercard[$creado]['descripcion'] = $pago['descripcion'];
    }else if($pago['metodo']=='efectivo'){
        $eventos[$creado] = [];
        $eventos[$creado]['monto'] = $pago['importe'];
        $eventos[$creado]['concepto'] = $pago['descripcion'];
        $eventos[$creado]['descripcion'] = $pago['descripcion'];
    }else if($pago['metodo']=='cuentacorriente'){
        $cuentacorriente[$creado] = [];
        $cuentacorriente[$creado]['monto'] = $pago['importe'];
        $cuentacorriente[$creado]['concepto'] = $pago['descripcion'];
        $cuentacorriente[$creado]['descripcion'] = $pago['descripcion'];
    }else if($pago['metodo']=='otros'){
        $otros[$creado] = [];
        $otros[$creado]['monto'] = $pago['importe'];
        $otros[$creado]['concepto'] = $pago['descripcion'];
        $otros[$creado]['descripcion'] = $pago['descripcion'];
    }
    if($pago['tipo']=='cobro'){
        if($pago['metodo']=='visa'){
            $visa[$creado]['concepto'] = 'Cobro numero '.$pago['numero']." a ".$pago['cliente']['nombre'];
            $totalCobrosVisa += $pago['importe']*1;
        }else if($pago['metodo']=='mastercard'){
            $mastercard[$creado]['concepto'] = 'Cobro numero '.$pago['numero']." a ".$pago['cliente']['nombre'];
            $totalCobrosMastercard += $pago['importe']*1;
        }else if($pago['metodo']=='efectivo'){
            $eventos[$creado]['concepto'] = 'Cobro numero '.$pago['numero']." a ".$pago['cliente']['nombre'];
            $totalCobros += $pago['importe']*1;
            $eventos[$creado]['suma'] = 1;
        }else if($pago['metodo']=='cuentacorriente'){
            $cuentacorriente[$creado]['concepto'] = 'Cobro a Cuenta Corriente numero '.$pago['numero']." a ".$pago['cliente']['nombre'];
            $totalCobrosCuentaCorriente += $pago['importe']*1;
        }else if($pago['metodo']=='otros'){
            $otros[$creado]['concepto'] = 'Cobro con Otros numero '.$pago['numero']." a ".$pago['cliente']['nombre'];
            $totalCobrosOtros += $pago['importe']*1;
        }
    }
    if($pago['tipo']=='pago'){
        if($pago['metodo']=='visa'){
            $visa[$creado]['concepto'] = 'Pago numero '.$pago['numero']." a ".$pago['cliente']['nombre'];
            $totalPagosVisa += $pago['importe']*1;
        }else if($pago['metodo']=='mastercard'){
            $mastercard[$creado]['concepto'] = 'Pago numero '.$pago['numero']." a ".$pago['cliente']['nombre'];
            $totalPagosMastercard += $pago['importe']*1;
        }else if($pago['metodo']=='efectivo'){
            $eventos[$creado]['concepto'] = 'Pago numero '.$pago['numero']." a ".$pago['cliente']['nombre'];
            $totalPagos += $pago['importe']*1;
            $eventos[$creado]['suma'] = 0;
        }else if($pago['metodo']=='cuentacorriente'){
            $cuentacorriente[$creado]['concepto'] = 'Pago a cuenta Corriente numero '.$pago['numero']." a ".$pago['cliente']['nombre'];
            $totalPagosCuentaCorriente += $pago['importe']*1;
        }else if($pago['metodo']=='otros'){
            $otros[$creado]['concepto'] = 'Pago numero '.$pago['numero']." a ".$pago['cliente']['nombre'];
            $totalPagosOtros += $pago['importe']*1;
        }
    }
    if($pago['tipo']=='retiro'){
        $eventos[$creado]['concepto'] = 'Retiro numero '.$pago['numero'];
        $totalExtracciones += $pago['importe']*1;
        $eventos[$creado]['suma'] = 0;
    }
    if($pago['tipo']=='deposito'){
        $eventos[$creado]['concepto'] = 'Deposito numero '.$pago['numero'];
        $totalDepositos += $pago['importe']*1;
        $eventos[$creado]['suma'] = 1;
    }
}
 $totalCierre+= $caja->importeapertura;
?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <?php
                        $creadoTS = $caja['apertura'];
                        $creado = $creadoTS->i18nFormat('dd HH:mm:ss');
                        ?>
                    <h3><?= __('Usuario que Abrio Caja: '.$caja->user->first_name." a las ".$creado) ?></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="pagos index large-9 medium-8 columns content">
                        <fieldset>
                            <legend><?= __('Cerrar Caja') ?></legend>
                            <h3>Descripcion Apertura: 
                            <?= __($caja->descripcionapertura) ?></h3>
                             <label>Importe Apertura: <?php echo $totalCierre?></label></br>
                                <label>Total Pagos: <?php echo $totalPagos?></label></br>
                                <label>Total Cobros: <?php echo $totalCobros?></label></br>
                                <label>Total Retiros: <?php echo $totalExtracciones?></label></br>
                                <label>Total Depositos: <?php echo $totalDepositos?></label></br>
                               
                                <?php
                                $tz = '-0300';
                                $timestamp = time();
                                $dt = new DateTime("now", new DateTimeZone($tz)); //first argument "must" be a string
                                $dt->setTimestamp($timestamp); //adjust the object to correct timestamp
                                if(is_null($caja->cierre)){            
                                    $importecierre = $totalCierre+$totalCobros-$totalPagos-$totalExtracciones+$totalDepositos;
                                    ?>
                                    <label>Saldo Caja: <?php echo $importecierre?></label></br>
                                    <?php
                                     echo $this->Form->create($caja,[
                                        'class'=>'form-control-horizontal',
                                    ]); 
                                    echo $this->Form->control('cierre', [
                                                            'type'=>'text',
                                                            'label'=>'Hora cierre',
                                                            'default'=>$dt->format('d.m.Y, H:i:s'),
                                                            //'label' => false,
                                                            'readonly' => 'readonly',
                                                            'class'=>'form-control pull-right',
                                                        ]);            
                                    echo $this->Form->control('importecierre',['value'=>$importecierre]);
                                    echo $this->Form->control('descripcioncierre',['value'=>'sin novedades','style'=>'width:250px']);
                                    echo $this->Form->button(__('Cerrar'));
                                    echo $this->Form->end(); 
                                }else{
                                    ?><label>Saldo Caja: <?php echo $caja->importecierre?></label></br><?php
                                    ?><label>Descripcion cierre: <?php echo $caja->descripcioncierre?></label></br><?php
                                }
                            ?>
                        </fieldset>
                       
                        <table id="" >
                            <thead>
                                <tr>
                                    <th style="width:90px;">Hora</th>
                                    <th>Concepto</th>
                                    <th>Importe</th>
                                    <th>Descripcion</th>
                                    <th>Saldo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="tdborder"><?php 
                                        echo $creado; 
                                        $saldoCaja = 0
                                        ?>
                                    </td>
                                    <td class="tdborder">Apertura</td>
                                    <td class="tdborder">$<?php echo number_format($caja->importeapertura,2,',','.'); ?></td>
                                    <td class="tdborder"></td>
                                    <?php 
                                    $saldoCaja += $caja->importeapertura*1;
                                    ?>
                                    <td class="tdborder">$<?php echo number_format($saldoCaja,2,',','.'); ?></td>
                                </tr>
                                <?php
                                    foreach ($eventos as $ke => $evento) {
                                        ?>
                                        <tr>
                                            <td class="tdborderleftrightbottom"><?php echo $this->Form->label($ke);?></td>
                                            <td class="tdborderleftrightbottom"><?php echo $evento['concepto']?></td>
                                            <td class="tdborderleftrightbottom">$ <?php echo number_format($evento['monto'],2,',','.') ?></td>
                                            <td class="tdborderleftrightbottom"><?php echo $evento['descripcion']?></td>
                                            <?php 
                                            if($evento['suma']){
                                                $saldoCaja += $evento['monto']*1;    
                                            }else{
                                                $saldoCaja -= $evento['monto']*1;
                                            }
                                            
                                            ?>
                                            <td class="tdborder">$<?php echo number_format($saldoCaja,2,',','.'); ?></td>
                                        </tr>
                                        <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                        <table id="">
                            <thead>
                                <tr>
                                    <td colspan="4"><h2>Movimientos con Visa</h2></td>
                                </tr>
                                <tr>
                                    <th style="width:90px;">Hora</th>
                                    <th>Concepto</th>
                                    <th>Importe</th>
                                    <th>Descripcion</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                <?php
                                    foreach ($visa as $kv => $vis) {
                                        ?>
                                        <tr>
                                            <td><?php echo $this->Form->label($kv);?></td>
                                            <td><?php echo $this->Form->label($vis['concepto']);?></td>
                                            <td>$ <?php echo number_format($vis['monto'],2,',','.') ?></td>
                                            <td><?php echo $vis['descripcion']?></td>
                                        </tr>
                                        <?php
                                    }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>Total Pagos: </td>
                                    <td><?php echo $totalPagosVisa?></td>
                                </tr>
                                <tr>
                                    <td>Total Cobros: </td>
                                    <td><?php echo $totalCobrosVisa?></td>
                                </tr>
                            </tfoot>
                        </table>
                        <table id="">
                            <thead>
                                <tr>
                                    <td colspan="4"><h2>Movimientos con Mastercard</h2></td>
                                </tr>
                                <tr>
                                    <th style="width:90px;">Hora</th>
                                    <th>Concepto</th>
                                    <th>Importe</th>
                                    <th>Descripcion</th>
                                </tr>
                            </thead>
                            <tbody>            
                                <?php
                                    foreach ($mastercard as $kv => $vis) {
                                        ?>
                                        <tr>
                                            <td><?php echo $this->Form->label($kv);?></td>
                                            <td><?php echo $this->Form->label($vis['concepto']);?></td>
                                            <td>$ <?php echo number_format($vis['monto'],2,',','.') ?></td>
                                            <td><?php echo $vis['descripcion']?></td>
                                        </tr>
                                        <?php
                                    }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>Total Pagos: </td>
                                    <td><?php echo $totalPagosMastercard?></td>
                                </tr>
                                <tr>
                                    <td>Total Cobros: </td>
                                    <td><?php echo $totalCobrosMastercard?></td>
                                </tr>
                            </tfoot>
                        </table>
                        <table id="">
                            <thead>
                                <tr>
                                    <td colspan="4"><h2>Movimientos a Cuenta Corriente</h2></td>
                                </tr>
                                <tr>
                                    <th style="width:90px;">Hora</th>
                                    <th>Concepto</th>
                                    <th>Importe</th>
                                    <th>Descripcion</th>
                                </tr>
                            </thead>
                            <tbody>            
                                <?php
                                    foreach ($cuentacorriente as $kcc => $cue) {
                                        ?>
                                        <tr>
                                            <td><?php echo $this->Form->label($kcc);?></td>
                                            <td><?php echo $this->Form->label($cue['concepto']);?></td>
                                            <td>$ <?php echo number_format($cue['monto'],2,',','.') ?></td>
                                            <td><?php echo $cue['descripcion']?></td>
                                        </tr>
                                        <?php
                                    }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>Total Pagos: </td>
                                    <td><?php echo $totalPagosCuentaCorriente?></td>
                                </tr>
                                <tr>
                                    <td>Total Cobros: </td>
                                    <td><?php echo $totalCobrosCuentaCorriente?></td>
                                </tr>
                            </tfoot>
                        </table>
                        <table id="">
                            <thead>
                                <tr>
                                    <td colspan="4"><h2>Movimientos a Otros</h2></td>
                                </tr>
                                <tr>
                                    <th style="width:90px;">Hora</th>
                                    <th>Concepto</th>
                                    <th>Importe</th>
                                    <th>Descripcion</th>
                                </tr>
                            </thead>
                            <tbody>            
                                <?php
                                    foreach ($otros as $ko => $otro) {
                                        ?>
                                        <tr>
                                            <td><?php echo $this->Form->label($ko);?></td>
                                            <td><?php echo $this->Form->label($otro['concepto']);?></td>
                                            <td>$ <?php echo number_format($otro['monto'],2,',','.') ?></td>
                                            <td><?php echo $otro['descripcion']?></td>
                                        </tr>
                                        <?php
                                    }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>Total Pagos: </td>
                                    <td><?php echo $totalPagosOtros?></td>
                                </tr>
                                <tr>
                                    <td>Total Cobros: </td>
                                    <td><?php echo $totalCobrosOtros?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
