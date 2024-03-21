<?php 
echo $this->Html->css('bootstrapmodal');
echo $this->Html->script('jquery-ui',array('inline'=>false));
echo $this->Html->script('bootstrapmodal.js',array('inline'=>false));
echo $this->Html->script('ventas/declararventa',array('inline'=>false));

//vamos a armar la lista de nombres y documentos ya utilizados para cargarlos en el autocomplete

$listaAlicuotas = crearLista($tiposalicuotas,'Id','Desc');
$listaTributos = crearLista($tipostributos,'Id','Desc');
$listaComprobantes = crearLista($tiposcomprobantes,'Id','Desc');
$listaDocumentos = crearLista($tiposdocumentos,'Id','Desc');
$listaMonedas = crearLista($tiposmonedas,'Id','Desc');
$listaOpcionales = crearLista($tiposopcionales,'Id','Desc');

//vamos a agregar exento y no gravado en las opciones de Alicuotas
$listaAlicuotas[1]='Exento';
$listaAlicuotas[2]='Nogravado';

$cantDetalles  = 0;
$puntodeventasList = [];
/*$mispuntosDeVentas = $puntodeventas->ResultGet->PtoVenta;
if(is_array($mispuntosDeVentas)){
    foreach ($mispuntosDeVentas as $kPV => $puntodeventa) {
        $minumero = $puntodeventa->Nro;
       $puntodeventasList[$minumero] = $minumero;       
    }
}
print_r($puntodeventasList);*/

echo $this->Form->control('cantDetalles',array('value'=>$cantDetalles,'type'=>'hidden'));
echo $this->Form->control('cantComprobantesAsociados',array('value'=>0,'type'=>'hidden'));
echo $this->Form->control('cantCamposOpcionales',array('value'=>0,'type'=>'hidden'));
echo $this->Form->control('impTicket',array('value'=>$impTicket,'type'=>'hidden'));

?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box" style="float: left">
                <div class="box-body col-xs-12">
                    <div class="ventas index large-9 medium-8 columns content">
                        <h2>
                            <?php 
                            if($impTicket==1){
                                __('Enviando Venta a AFIP e Imprimiendo Ticket por favor espere...');
                            }else{
                                __('Enviando Venta a AFIP');    
                            }
                            ?>
                        </h2>
                        <?php     
                        echo $this->Form->create($venta,['class' => 'formVentaAFIP','id'=>'formDeclaracionAfip'])     
                        ?>
                        <div id="divCabecera" class="divVentaAfip" style="width: 59%;float: left;">
                            <fieldset id="">
                                <legend><?= __('Venta') ?></legend>
                                <?php
                                echo $this->Form->control('id',array('type'=>'hidden'));
                                echo $this->Form->control('cliente_id',array('type'=>'text'));
                                echo $this->Form->control('puntodeventas_id',array(
                                        'options'=>$puntodeventas,
                                        'value'=>$venta->puntodeventa->numero
                                        )); 
                                /*echo $this->Form->control('puntodeventa',array(
                                        'type'=>'text',
                                        'value'=>$venta->puntodeventa->numero
                                        )); */
                                echo $this->Form->control('fecha',[
                                    'type'=>'text',
                                    'default'=>date('d-m-Y'),
                                    'class'=>'datepicker'
                                    ]);
                                //el comprobante_id es el IDAFIP no de la base de datos
                                echo $this->Form->control('comprobante_id',array(
                                                            'type'=>'select',
                                                            'options'=>$listaComprobantes     
                                                                    )
                                                    ); 
                                echo $this->Form->control('numero',array(  
                                                'label'=>'Nro Interno',
                                                'readonly'=>'readonly'
                                                )
                                ); 
                                echo $this->Form->control('comprobantedesde',array(  
                                                'label'=>'Nro Comprobante desde',
                                                'readonly'=>'readonly'
                                                )
                                ); 
                                echo $this->Form->control('comprobantehasta',array(    
                                                'label'=>'Nro Comprobante hasta',
                                                'readonly'=>'readonly'
                                                                    )
                                                    ); 
                                
                                echo "</br>";
                                $conceptoOptions = [1=>'Productos', 2=>'Servicios',3=>'Productos y Servicios'];
                                echo $this->Form->control('concepto',[
                                    'type'=>'select',
                                    'options'=>$conceptoOptions   
                                ]); 

                                echo $this->Form->control('servdesde',[
                                    'type'=>'text',
                                    'label'=>'Servicio Desde',
                                    'class'=>'datepicker',
                                    'default'=>date('d-m-Y')
                                    ]);                 
                                echo $this->Form->control('servhasta',[
                                    'type'=>'text',
                                    'label'=>'Servicio Hasta',
                                    'class'=>'datepicker',
                                    'default'=>date('d-m-Y')
                                    ]);                 
                                echo $this->Form->control('vto',[
                                    'label'=>'Vto. para el pago',
                                    'class'=>'datepicker',
                                    'default'=>date('t-m-Y')
                                    ]);     
                                echo "</br>";
                               
                            ?>
                            </fieldset>
                           
                        </div>
                        <div id="" class="divVentaAfip" style="width: 39%;float: right;">
                            <fieldset id="">
                                <legend><?= __('Cliente') ?></legend>
                                <?php
                                echo $this->Form->control('condicioniva',array(
                                        'label'=>'Condicion IVA',
                                        'type'=>'select',
                                        'options'=>$condicionesiva,
                                        'value'=> $venta->cliente->condicioniva
                                    )
                                ); 
                                echo $this->Form->control('condicionivaOriginal',array(
                                        'type'=>'hidden',
                                        'value'=> $venta->cliente->condicioniva
                                    )
                                ); 
                                $cuit = 2000000001;
                                $nombre = 'consumidor final';
                                $defaultcodigo = 80;
                                if($venta->cliente->CUIT!=0){
                                    $cuit = $venta->cliente->CUIT;
                                    $nombre = $venta->cliente->nombre;
                                    $defaultcodigo = 80;
                                }else if($venta->cliente->DNI!=0){
                                    $cuit = $venta->cliente->DNI;
                                    $nombre = $venta->cliente->nombre;
                                    $defaultcodigo = 96;
                                }

                                echo $this->Form->control('tipodocumento', [
                                            'type'=>'select',
                                            'options'=>$listaDocumentos,   
                                            'label'=>'Tipo de Documento',
                                            'default'=>$defaultcodigo
                                     ]
                                );

                                echo $this->Form->control('fcuit', array(
                                            'label'=>'Numero',
                                            'style'=>'width:130px;',
                                            'value'=>$cuit,
                                            'type'=>'number')
                                );
                                echo $this->Form->control('fnombre', array(
                                           'label'=>'Apellido. y Nombre o Razón Social',
                                           'style'=>'width:200px;',
                                            'value'=>$nombre,)
                                );
                                echo $this->Form->control('fdomicilio', array(
                                        'label'=>'Domicilio',
                                        'style'=>'width:250px;',
                                        'value'=>$venta->cliente->direccion,)
                                );
                                echo $this->Form->control('moneda', array(
                                            'type'=>'select',
                                            'options'=>$listaMonedas,   
                                            'label'=>'Moneda',
                                    )
                                );
                                ?>
                            </fieldset>
                        </div>
                        <div id="divDetalles" class="divVentaAfip" style="width: 59%;float: left;height: -webkit-fill-available">
                            <fieldset id="">
                                <legend><?= __('Productos de la venta') ?></legend>
                            <?php 
                            foreach ($venta['detalleventas'] as $kdv => $detalleventa) {
                            ?>
                                <div id="divDetalleVenta0" class="divDetalleVenta">
                                    <h4><?= $detalleventa->producto->nombre.": ".$detalleventa->descripcion ?></h4>
                                    <?php
                                    echo $this->Form->control('detalleventas.'.$kdv.'.id',array(
                                            'type'=>'hidden',
                                            'value'=> $detalleventa->id
                                        )
                                    ); 
                                    echo $this->Form->control('detalleventas.'.$kdv.'.producto_id',array(
                                            'type'=>'hidden',
                                            'value'=> $detalleventa->producto_id
                                        )
                                    ); 
                                    echo $this->Form->control('detalleventas.'.$kdv.'.producto',array(
                                            'type'=>'hidden',
                                            'value'=> $detalleventa->producto->nombre
                                        )
                                    ); 
                                    echo $this->Form->control('detalleventas.'.$kdv.'.descripcion',array(
                                            'value'=> $detalleventa->descripcion,
                                            'type'=>'hidden',
                                        )
                                    ); 
                                    echo $this->Form->control('detalleventas.'.$kdv.'.fcantidad',array(
                                            'type'=>'number',
                                            'style'=>'width:60px',
                                            'onchange'=>'calcularVenta()',
                                            'label'=> $kdv==0?'Cantidad':'',
                                            'value'=> $detalleventa->cantidad 
                                        )
                                    ); 
                                    /*Para la barrica vamos a poner el precio dividido 1.21 por que el no carga iva en las ventas*/
                                    //$precioBarrica = round($detalleventa->precio  / 1.21,2);
                                    $precioBarrica = round($detalleventa->precio,2);
                                    //este ajuste lo vamos a hacer por JavaScript
                                    echo $this->Form->control('detalleventas.'.$kdv.'.fprecio',array(
                                            'value'=>0,
                                            'type'=>'number',
                                            'onchange'=>'calcularVenta()',
                                            'label'=> $kdv==0?'Precio':'',
                                            'value'=> $precioBarrica,
                                            'class'=> 'precioDetalleVenta',    
                                            'precioOriginal'=> $detalleventa->precio    
                                        )
                                    ); 
                                    echo $this->Form->control('detalleventas.'.$kdv.'.fporcentajedescuento',array(
                                            'value'=>0  ,
                                            'type'=>'number',
                                            'onchange'=>'calcularVenta()',
                                            'style'=>'width:60px',
                                            'label'=> $kdv==0?'% Desc.':'',
                                            'value'=> $detalleventa->porcentajedescuento       
                                        )
                                    ); 
                                    $importedescuento = $precioBarrica*( $detalleventa->porcentajedescuento/100 );
                                    echo $this->Form->control('detalleventas.'.$kdv.'.fimportedescuento',array(
                                            'value'=>0,
                                            'type'=>'number',
                                            'onchange'=>'calcularVenta()',
                                            'label'=> $kdv==0?'Imp.Desc.':'',
                                            'value'=>  $importedescuento
                                        )
                                    ); 
                                    $subtotalSinIVA = ($detalleventa->cantidad * $precioBarrica) - $importedescuento;
                                    echo $this->Form->control('detalleventas.'.$kdv.'.fsubtotal',array(
                                            'value'=>0,
                                            'type'=>'number',
                                            'readonly'=>'readonly',
                                            'value'=> $subtotalSinIVA,
                                            'class'=>'subtotalventa',
                                            'label'=> $kdv==0?'Total sin IVA':'',
                                            'numDetalle'=>$kdv,
                                        )
                                    ); 
                                    echo $this->Form->control('detalleventas.'.$kdv.'.fcodigoalicuota',array(
                                            'type'=>'select',
                                            'options'=>$listaAlicuotas,
                                            'orden'=>$kdv,
                                            'class'=>'fcodigoalicuota',
                                            'onchange'=>'calcularVenta()',
                                            'label'=> $kdv==0?'Alicuota':'',
                                            //'disabled'=>'disabled',
                                            'value'=>5,
                                            'style'=>'width:80px;',
                                        )
                                    ); 
                                    echo $this->Form->control('detalleventas.'.$kdv.'.falicuota',array(
                                            'value'=>21,
                                            'type'=>'hidden',
                                            'readonly'=>'readonly',                                            
                                        )
                                    ); 
                                    $this->Form->unlockField('detalleventas.'.$kdv.'.falicuota');    
                                    $importeIVA = round($subtotalSinIVA * 0.21,2);
                                    echo $this->Form->control('detalleventas.'.$kdv.'.fimporteiva',array(
                                            'value'=>0,
                                            'type'=>'number',
                                            'readonly'=>'readonly',
                                            'label'=> $kdv==0?'Imp. IVA':'',
                                            //'value'=> $detalleventa->importeiva         
                                            'value'=> $importeIVA,                                            
                                            'class'=>'ventaConIVA'        
                                        )
                                    ); 
                                    $subTotalConIVA = $subtotalSinIVA + $importeIVA;
                                    echo $this->Form->control('detalleventas.'.$kdv.'.fsubtotalconiva',array(
                                            'value'=>0,
                                            'type'=>'number',
                                            'label'=> $kdv==0?'SubTotal':'',
                                            'readonly'=>'readonly',
                                            'value'=> $subTotalConIVA,                                            
                                            'class'=>'ventaConIVA'        
                                        )
                                    );  
                                    ?>
                                </div>
                            <?php } ?>
                            </fieldset>
                        </div>
                        <?php 
                        if(count($venta['tributos'])>0){ ?>
                        <div id="divTributos" class="divVentaAfip" style="float: right;width: 39%;">
                            <a href="#" class="button_view">
                                <h2 class="h2header" id="lblProvedores" style="display: inline;">
                                    <?php echo __('Tributos'); ?>
                                </h2>
                            </a>
                            <?php
                            echo "</br>";   
                            $t=0;
                            foreach ($venta['tributos'] as $ktr => $tributo) {
                                showTributo($this, $t, $ktr, $tributo);
                                $t++;
                            }
                            ?>
                        </div>
                        <?php } ?>
                        <div id="divAlicuotas" class="divVentaAfip" style="float: right;width: 39%;">
                            <fieldset id="">
                                <legend><?= __('Alicuotas') ?></legend>
                                <?php
                                echo "</br>";
                                showAlicuota($this,0,3,0,$venta['detalleventas']);
                                showAlicuota($this,1,4,10.5,$venta['detalleventas']);
                                showAlicuota($this,2,5,21,$venta['detalleventas']);
                                showAlicuota($this,3,6,27,$venta['detalleventas']);
                                showAlicuota($this,4,8,5,$venta['detalleventas']);
                                showAlicuota($this,5,9,2.5,$venta['detalleventas']);
                                showAlicuota($this,6,1,0,$venta['detalleventas']);
                                showAlicuota($this,7,2,0,$venta['detalleventas']);
                                ?>
                            </fieldset>
                        </div>
                        <?php /*
                        <div id="divOpcionales" class="divVentaAfip" style="width: 20%;float: left">
                            <a href="#nuevo_opcionales" class="button_view" onclick="addCaposOpcionales();">
                                <h2 class="h2header" id="lblProvedores" style="display: inline;">
                                    <?php echo __('Opcionales'); ?>
                                </h2>
                            </a>
                        </div>
                        <div id="divComprobantes" class="divVentaAfip" style="width: 40%;float: left">
                            <a href="#nuevo_comprobantesasoc" class="button_view" onclick="addComprobanteAsociado()">
                                <h2 class="h2header" id="lblProvedores" style="display: inline;">
                                    <?php echo __('Comprobantes Asociados'); ?>
                                </h2>
                                <?php echo $this->Html->image('add_view.png', array('alt' => 'add','id'=>'img12','class'=>'img_add'));?>
                            </a>
                        </div>
                        */ ?>
                        <div id="divTotales" class="divVentaAfip" style="width: 39%;float: right;">
                            <fieldset id="">
                                <legend><?= __('Totales') ?></legend>
                            <?php
                            echo $this->Form->control('fneto', array(
                                       'label'=>'Importe Neto',
                                       'value'=>$venta->neto,
                                       'class'=>'ventaConIVA'  
                                   )
                            );
                            echo $this->Form->control('fiva', array(
                                       'label'=>'Importe IVA',
                                       'value'=>$venta->iva,                                            
                                        'class'=>'ventaConIVA' )
                            );
                            echo $this->Form->control('fimptributos', array(
                                       'label'=>'Importe Tributos',
                                       'value'=>$venta->imptributos)
                            );
                            echo $this->Form->control('fimportenetoivaexento', array(
                                       'label'=>'Importe IVA Exento',
                                       'value'=>$venta->importeivaexento,                                            
                                       'class'=>'ventaConIVA' )
                            );
                            echo $this->Form->control('fimportenetonogravado', array(
                                       'label'=>'Importe Neto no gravado',
                                       'value'=>$venta->importenetogravado,                                            
                                        'class'=>'ventaConIVA' )
                            );
                            echo $this->Form->control('ftotal', array(
                                       'label'=>'Importe Total',
                                       'value'=>$venta->total)
                            );
                            echo $this->Form->button('Aceptar'); 
                           
                            ?>    
                            </fieldset>
                        </div>
                        <?php 
                        echo $this->Form->end(); 
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
function crearLista($listaOriginal,$campoValor,$campoAMostrar){
    $listaADevolver = [];
    $listaOriginalArray = (array)$listaOriginal;
    foreach ($listaOriginalArray as $key => $value) {
        $valueArray = (array)$value;
        $listaADevolver[$valueArray[$campoValor]]=$valueArray[$campoAMostrar];
    }
    return $listaADevolver;
}
function showAlicuota($context,$num,$idafip,$porcentaje,$detalleventas){
    $baseimponible = 0;
    $iva = 0;
    $showThisAlicuota = true;
    $venta_id = 0;
    foreach ($detalleventas as $kdv => $detalleventa) {
       if($detalleventa->alicuota == $porcentaje){
            $baseimponible += $detalleventa->subtotal;
            $iva += $detalleventa->importeiva;
            $showThisAlicuota = true;
            $venta_id = $detalleventa->venta_id;
       }
    }
    if($showThisAlicuota){
        echo $context->Form->control('alicuotas.'.$num.'.venta_id',array(
                'value'=>$venta_id,
                'type'=>'hidden'
            )
        ); 
        echo $context->Form->control('alicuotas.'.$num.'.idafip',array(
                'value'=>$idafip,
                'type'=>'hidden'
            )
        ); 
        echo $context->Form->control('alicuotas.'.$num.'.baseimponible',array('style'=>'width:150px',
            'label' => $porcentaje.'% Base Imponible',
            'readonly' => 'readonly',
            'value' => $baseimponible,
            'class' =>'baseimponibleAlicuota'.$idafip,
            'orden' => $num
            ));
        echo $context->Form->control('alicuotas.'.$num.'.importe',array(
            'label'=>'Importe',
            'readonly'=>'readonly',
            'class'=>'importeIvaAlicuota',
            'value'=>$iva,
        ));
        echo "</br>";   
    }
}
function showTributo($context,$num,$tributo){
    $label = ($num==0)?true:false;
    echo $context->Form->control('tributos.'.$num.'.id',array(
            'value'=>$tributo->id,
            'type'=>'hidden'
        )
    ); 
    echo $context->Form->control('tributos.'.$num.'.idafip',array(
            'value'=>$tributo->idafip,
            'type'=>'hidden'
        )
    ); 
    echo $context->Form->control('tributos.'.$num.'.descripcion',array(
            'value'=>$tributo->descripcion,
            'type'=>'hidden'    
        )
    ); 
    echo $context->Form->label('tributos.'.$num.'.label',
            $descripcion
           ); 
    echo $context->Form->control('tributos.'.$num.'.baseimponible',array('style'=>'width:150px',
        'label'=>'Base Imponible',
        'label'=> ($num==0)?'Base Imponible':false,
        'required'=>false
    ));
    echo $context->Form->control('tributos.'.$num.'.alicuota',array('style'=>'width:150px',
        'label'=>'% alicuota',
        'label'=>($num==0)?'Alicuota':false,
        'required'=>false    
        ));
    echo $context->Form->control('tributos.'.$num.'.importe',array(
        'label'=>($num==0)?'Importe':false,
        'readonly'=>'readonly',
        'class'=>'inputSubtotalTributos',
        'required'=>false
        ));
    echo "</br>";   
}
?>