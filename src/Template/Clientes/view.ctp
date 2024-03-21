<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cliente $cliente
 */
use Cake\Routing\Router;
$this->Html->css([
    'AdminLTE./plugins/datepicker/datepicker3',
    'AdminLTE./plugins/datatables/dataTables.bootstrap',
  ],
  ['block' => 'css']);

$this->Html->script([
    'AdminLTE./plugins/datatables/jquery.dataTables.min',
    'AdminLTE./plugins/datepicker/bootstrap-datepicker',
    'AdminLTE./plugins/datatables/dataTables.bootstrap.min',
],
['block' => 'script']);
?>

<?php $this->start('scriptBottom'); ?>
<script>
  $(function () {
    /*$("#tblMovimientos").DataTable( {
        "order": [[0, "ASC" ]]
    } );*/
  });
  $('.datepicker').datepicker({
      autoclose: true,
      format: 'dd-mm-yyyy'
    });
</script>
<?php $this->end(); ?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h1 class="box-title"> Cliente:: <?= __($cliente->nombre) ?></h1></br>                   
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="obros index large-9 medium-8 columns content">
                        <table class="vertical-table" cellpadding="5">
                            <tr>
                                <th scope="row"><?= __('Mail') ?></th>
                                <td><?= h($cliente->mail) ?></td>
                                <th scope="row"><?= __('Telefono') ?></th>
                                <td><?= h($cliente->telefono) ?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?= __('Celular') ?></th>
                                <td><?= h($cliente->celular) ?></td>
                                <th scope="row"><?= __('Direccion') ?></th>
                                <td><?= h($cliente->direccion) ?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?= __('DNI') ?></th>
                                <td><?= h($cliente->DNI) ?></td>
                                <th scope="row"><?= __('CUIT') ?></th>
                                <td><?= h($cliente->CUIT) ?></td>
                            </tr>
                          
                        </table>
                        <div class="resumen box-header">
                            <?php 
                            $totalVentasSinCobrar = 0;
                            $totalCompras = 0;
                            $cuentacorriente = [];
                            foreach ($cliente->ventas as $venta){
                                $key = $venta->created->i18nFormat('yyyy MM dd HH:mm:ss');
                                $key .= ' Venta '.$venta->id;
                                $cuentacorriente[$key] = [];
                                $cuentacorriente[$key]['importe'] = $venta->total;
                                $cuentacorriente[$key]['concepto'] = 'Venta';
                                $cuentacorriente[$key]['fecha'] = $venta->created->i18nFormat('dd-MM-yyyy HH:mm:ss');
                                $cuentacorriente[$key]['id'] = $venta->id;
                                //if($ventas->cobrado!=1)
                                $totalVentasSinCobrar+=$venta->total;
                            } 
                            foreach ($cliente->compras as $compra){
                                $key = $compra->created->i18nFormat('yyyy MM dd HH:mm:ss');
                                $key .= ' Compra '.$compra->id;
                                $cuentacorriente[$key] = [];
                                $cuentacorriente[$key]['importe'] = $compra->total;
                                $cuentacorriente[$key]['concepto'] = 'Compra';
                                $cuentacorriente[$key]['fecha'] = $compra->created->i18nFormat('dd-MM-yyyy HH:mm:ss');
                                $cuentacorriente[$key]['id'] = $compra->id;
                                //if($ventas->cobrado!=1)
                                $totalCompras+=$compra->total;
                            } 
                            $totalCobrosRecibidos = 0;
                            $totalPagos = 0;
                            foreach ($cliente->pagos as $pago){
                                $key = $pago->created->i18nFormat('yyyy MM dd HH:mm:ss');
                                $key .= ' Cobro '.$pago->id;
                                $cuentacorriente[$key] = [];
                                $cuentacorriente[$key]['importe'] = $pago->importe;
                                
                                $cuentacorriente[$key]['fecha'] = $pago->created->i18nFormat('dd-MM-yyyy HH:mm:ss');
                                $cuentacorriente[$key]['id'] = $pago->id;
                                $cuentacorriente[$key]['metodo'] = $pago['metodo'];
                                if($pago['tipo']=='pago'){
                                    $cuentacorriente[$key]['concepto'] = 'Pago';
                                    if($pago['metodo']=='visa'){
                                        $totalPagos += $pago->importe;
                                    }else if($pago['metodo']=='mastercard'){
                                        $totalPagos += $pago->importe;
                                    }else if($pago['metodo']=='efectivo'){
                                        $totalPagos += $pago->importe;
                                    }else if($pago['metodo']=='cuentacorriente'){
                                        //no registro pago por que fue a cuenta corriente
                                        //$totalCobrosRecibidos += $pagos->importe;
                                    }   
                                }
                                if($pago['tipo']=='cobro'){
                                    $cuentacorriente[$key]['concepto'] = 'Cobro';
                                    if($pago['metodo']=='visa'){
                                        $totalCobrosRecibidos += $pago->importe;
                                    }else if($pago['metodo']=='mastercard'){
                                        $totalCobrosRecibidos += $pago->importe;
                                    }else if($pago['metodo']=='efectivo'){
                                        $totalCobrosRecibidos += $pago->importe;
                                    }else if($pago['metodo']=='cuentacorriente'){
                                        //no registro pago por que fue a cuenta corriente
                                        //$totalCobrosRecibidos += $pagos->importe;
                                    }   
                                }
                            }
                          
                            //tenemos que hacer los saldos
                            ksort($cuentacorriente);
                            $saldoCC= 0;                        
                            foreach ($cuentacorriente as $km => $movimiento){
                                if($movimiento['concepto']=='Venta'){
                                    $saldoCC -= $movimiento['importe'] ;
                                }else if($movimiento['concepto']=='Cobro'){
                                    if($movimiento['metodo']!='cuentacorriente')
                                        $saldoCC += $movimiento['importe'];    
                                }else if($movimiento['concepto']=='Compra'){
                                    $saldoCC += $movimiento['importe'] ;
                                }else if($movimiento['concepto']=='Pago'){
                                    if($movimiento['metodo']!='cuentacorriente')
                                        $saldoCC -= $movimiento['importe'];
                                }
                                $cuentacorriente[$km]['saldo']=$saldoCC;
                            }
                            //fin calculo saldos
                            $saldo = -$totalVentasSinCobrar + $totalCobrosRecibidos + $totalCompras - $totalPagos;
                            krsort($cuentacorriente);
                            ?>
                            <h2 class="box-title">
                                Total de Ventas: $<?php echo number_format($totalVentasSinCobrar,2,',','.'); ?></br>
                                Total de Cobros recibidos: $<?php echo number_format($totalCobrosRecibidos,2,',','.'); ?></br>
                                Total de Compras: $<?php echo number_format($totalCompras,2,',','.'); ?></br>
                                Total de Pagos emitidos: $<?php echo number_format($totalPagos,2,',','.'); ?></br>
                                <?php echo (($saldo>0)?'A Favor':'A Pagar').": $".number_format($saldo,2,',','.'); ?></h2>
                        </div>
                        <div class="related">
                            <h4><?= __('Movimientos') ?></h4>
                            <?php if (!empty($cuentacorriente)): ?>
                            <table cellpadding="5" cellspacing="0" id="tblMovimientos" style="width: 100%">
                                <thead>
                                <tr>
                                    <th scope="col"><?= __('Fecha') ?></th>
                                    <th scope="col"><?= __('Concepto') ?></th>
                                    <th scope="col"><?= __('Ventas') ?></th>
                                    <th scope="col"><?= __('Cobros') ?></th>
                                    <th scope="col"><?= __('Compras') ?></th>
                                    <th scope="col"><?= __('Pagos') ?></th>                         
                                    <th scope="col"><?= __('Saldo') ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php 
                                 $saldoCobro= 0;
                                 $saldoVenta= 0;
                                 foreach ($cuentacorriente as $km => $movimiento): 
                                    if(isset($movimiento['metodo'])&&$movimiento['metodo']=='cuentacorriente'){
                                        continue;
                                    }   
                                    ?>
                                <tr>
                                    <td>
                                        <span class="orderSpan" style="display: none;"><?= $km ?></span>
                                        <?php echo $movimiento['fecha'];?>
                                        </td>
                                    <td><?= $movimiento['concepto']?>
                                        <?php
                                        if($movimiento['concepto']=='Venta'){
                                            $iconoPrint = '<i class="fa fa-print"></i>';
                                            echo $this->Html->link($iconoPrint, [
                                                    'controller' => 'ventas','action' => 'view', $movimiento['id']
                                                ],
                                                [
                                                    'escape' => false,
                                                ]  
                                            ); 
                                        }
                                        if($movimiento['concepto']=='Compra'){
                                            $iconoPrint = '<i class="fa fa-print"></i>';
                                            echo $this->Html->link($iconoPrint, [
                                                    'controller' => 'compras','action' => 'view', $movimiento['id']
                                                ],
                                                [
                                                    'escape' => false,
                                                ]  
                                            ); 
                                        }
                                        if($movimiento['concepto']=='Cobro'){
                                            if($movimiento['metodo']=='efectivo'){
                                                echo "en Efectivo"; 
                                            }   
                                            if($movimiento['metodo']=='visa'){
                                                echo " Visa"; 
                                            }   
                                            if($movimiento['metodo']=='mastercard'){
                                                echo " Mastercard"; 
                                            }  
                                            if($movimiento['metodo']=='cuentacorriente'){
                                                echo " Cuenta corriente"; 
                                            }   
                                        }?>     
                                    </td>
                                    <td class="tdWithNumber"><?php
                                        if($movimiento['concepto']=='Venta'){
                                            echo "$".number_format($movimiento['importe'], 2, ",", "."); 
                                        }?>                                            
                                    </td>
                                    <td class="tdWithNumber"><?php
                                        if($movimiento['concepto']=='Cobro'){
                                            echo "$".number_format($movimiento['importe'], 2, ",", "."); 
                                        }?>                                            
                                    </td>
                                    <td class="tdWithNumber"><?php
                                        if($movimiento['concepto']=='Compra'){
                                            echo "$".number_format($movimiento['importe'], 2, ",", "."); 
                                        }?>                                            
                                    </td>
                                    <td class="tdWithNumber"><?php
                                        if($movimiento['concepto']=='Pago'){
                                           echo "$".number_format($movimiento['importe'], 2, ",", "."); 
                                        }?>                                            
                                    </td>
                                    <?php

                                    ?>                         
                                    <td class="tdWithNumber">$<?= number_format($movimiento['saldo'], 2, ",", "."); ?></td>      
                                    <?php /*  
                                    <td><?= h($saldoVenta) ?></td>        
                                    <td><?= h($saldoCobro) ?></td>        
                                    */ ?>
                                </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                            <?php endif; ?>                        
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
