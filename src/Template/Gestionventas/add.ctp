<?php 
echo $this->Html->css('bootstrapmodal');
echo $this->Html->script('jquery-ui',array('inline'=>false));
echo $this->Html->script('bootstrapmodal.js',array('inline'=>false));
?>
<?php echo $this->Html->script('gestionventas/add',array('inline'=>false));

//vamos a armar la lista de nombres y documentos ya utilizados para cargarlos en el autocomplete
$listanombres = [];
$listadocumentos = [];
foreach ($listaventas as $kv => $venta) {
    if(!in_array($venta['Gestionventa']['nombre'],$listanombres)){
        $listanombres[] = $venta['Gestionventa']['nombre'];
    }
    if(!in_array($venta['Gestionventa']['documento'],$listadocumentos)){
        $listadocumentos[] = $venta['Gestionventa']['documento'];
    }
}
echo $this->Form->input('listanombres',array('value'=> json_encode($listanombres),'type'=>'hidden'));
echo $this->Form->input('listadocumentos',array('value'=> json_encode($listadocumentos),'type'=>'hidden'));


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
echo $this->Form->input('cantDetalles',array('value'=>$cantDetalles,'type'=>'hidden'));
echo $this->Form->input('cantComprobantesAsociados',array('value'=>0,'type'=>'hidden'));
echo $this->Form->input('cantCamposOpcionales',array('value'=>0,'type'=>'hidden'));
echo $this->Form->input('tiposopcionales',array(
    'options'=>$listaOpcionales,
    'type'=>'select',
    'div'=>[
        'style'=>'display:none'
    ]));

?>

<div class="clientes form index">	
    <h2>Crear Nueva Venta</h2>
    <?php 	  
    echo $this->Form->create('Gestionventas',array('action'=>'guardarVenta','class' => 'formVentaAFIP'));        
    ?>
    <div id="divCabecera" class="divVentaAfip" style="width: 100%;">
        <?php
        echo $this->Form->input('Gestionventa.0.id',array('type'=>'hidden'));
        echo $this->Form->input('Gestionventa.0.cliente_id',array('type'=>'hidden','value'=>$cliente_id));
        echo $this->Form->input('Gestionventa.0.puntosdeventa_id',array(
                'type'=>'select',
                'options'=>$puntosdeventas
                )); 
        echo $this->Form->input('Gestionventa.0.fecha',[
            'type'=>'text',
            'default'=>date('d-m-Y'),
            'class'=>'datepicker'
            ]);
        echo $this->Form->input('Gestionventa.0.comprobante',array(
                                    'type'=>'select',
                                    'options'=>$listaComprobantes     
                                            )
                            ); 
        echo $this->Form->input('Gestionventa.0.comprobantedesde',array(  
                        'label'=>'Nro Comprobante desde',
                        'readonly'=>'readonly'
                        )
        ); 
        echo $this->Form->input('Gestionventa.0.comprobantehasta',array(    
                        'label'=>'Nro Comprobante hasta',
                        'readonly'=>'readonly'
                                            )
                            ); 
        
        echo "</br>";
        $conceptoOptions = [1=>'Productos', 2=>'Servicios',3=>'Productos y Servicios'];
        echo $this->Form->input('Gestionventa.0.concepto',[
            'type'=>'select',
            'options'=>$conceptoOptions   
        ]); 

        echo $this->Form->input('Gestionventa.0.servdesde',[
            'type'=>'text',
            'label'=>'Servicio Desde',
            'class'=>'datepicker',
            'default'=>date('d-m-Y')
            ]);                 
        echo $this->Form->input('Gestionventa.0.servhasta',[
            'type'=>'text',
            'label'=>'Servicio Hasta',
            'class'=>'datepicker',
            'default'=>date('d-m-Y')
            ]);                 
        echo $this->Form->input('Gestionventa.0.vto',[
            'label'=>'Vto. para el pago',
            'class'=>'datepicker',
            'default'=>date('t-m-Y')
            ]);     
        echo "</br>";
        echo $this->Form->input('Gestionventa.0.condicioniva',array(
                'label'=>'Condicion IVA',
                'type'=>'select',
                'options'=>$condicionesiva
            )
        ); 
        echo $this->Form->input('Gestionventa.0.tipodocumento', [
                    'type'=>'select',
                    'options'=>$listaDocumentos,   
                    'label'=>'Tipo de Documento',
             ]
        );
        echo $this->Form->input('Gestionventa.0.documento', array(
                    'label'=>'Numero',
                    'type'=>'number')
        );
        echo $this->Form->input('Gestionventa.0.nombre', array(
                   'label'=>'Apellido. y Nombre o Razón Social',)
        );
        echo $this->Form->input('Gestionventa.0.domicilio', array(
                   'label'=>'Domicilio',)
        );
        echo $this->Form->input('Gestionventa.0.moneda', array(
                    'type'=>'select',
                    'options'=>$listaMonedas,   
                    'label'=>'Moneda',
            )
        );
    ?>
    </div>
    <div id="divDetalles" class="divVentaAfip" style="width: 100%">
        <a href="#nuevo_tributo" class="button_view" onclick="addDetalle();">
            <h2 style="display: inline;">Detalles de la venta</h2>
            <?php echo $this->Html->image('add_view.png', array('alt' => 'add','id'=>'img12','class'=>'img_add'));?>
        </a>
        </br>
        <div id="divDetalleVenta0" class="divDetalleVenta">
            <?php
            echo $this->Form->input('Gestionventa.0.Gestiondetalleventa.0.id',array(
                    'type'=>'hidden'
                )
            ); 
            echo $this->Form->input('Gestionventa.0.Gestiondetalleventa.0.gestionproducto_id',array(
                    'empty'=>'Seleccione un Producto',
                    'onchange'=>'calcularDetalleVenta(0)',
                )
            ); 
            echo $this->Form->input('Gestionventa.0.Gestiondetalleventa.0.descripcion',array(
                       
                )
            ); 
            echo $this->Form->input('Gestionventa.0.Gestiondetalleventa.0.cantidad',array(
                    'type'=>'number',
                    'onchange'=>'calcularDetalleVenta(0)'   
                )
            ); 
            echo $this->Form->input('Gestionventa.0.Gestiondetalleventa.0.preciounitario',array(
                    'value'=>0,
                    'type'=>'number',
                    'onchange'=>'calcularDetalleVenta(0)'    
                )
            ); 
            echo $this->Form->input('Gestionventa.0.Gestiondetalleventa.0.bonificacion',array(
                    'value'=>0  ,
                    'type'=>'number',
                    'onchange'=>'calcularDetalleVenta(0)'      
                )
            ); 
            echo $this->Form->input('Gestionventa.0.Gestiondetalleventa.0.importebonificacion',array(
                    'value'=>0,
                    'type'=>'number',
                    'readonly'=>'readonly'
                )
            ); 
            echo $this->Form->input('Gestionventa.0.Gestiondetalleventa.0.subtotal',array(
                    'value'=>0,
                    'type'=>'number',
                    'readonly'=>'readonly'     
                )
            ); 
            echo $this->Form->input('Gestionventa.0.Gestiondetalleventa.0.codigoalicuota',array(
                    'type'=>'select',
                    'options'=>$listaAlicuotas,
                    'onchange'=>'calcularDetalleVenta(0)'    
                )
            ); 
            echo $this->Form->input('Gestionventa.0.Gestiondetalleventa.0.importeiva',array(
                    'value'=>0,
                    'type'=>'number',
                    'readonly'=>'readonly'        
                )
            ); 
            echo $this->Form->input('Gestionventa.0.Gestiondetalleventa.0.subtotalconiva',array(
                    'value'=>0,
                    'type'=>'number',
                    'readonly'=>'readonly'        
                )
            ); 
            ?>
        </div>
        </br>
    </div>
    <div id="divTributos" class="divVentaAfip" style="float: left">
        <a href="#nuevo_tributo" class="button_view">
            <h2 class="h2header" id="lblProvedores" style="display: inline;">
                <?php echo __('Tributos'); ?>
            </h2>
            <?php echo $this->Html->image('add_view.png', array('alt' => 'add','id'=>'img12','class'=>'img_add'));?>
        </a>
        <?php
        echo "</br>";   
        $t=0;
        foreach ($listaTributos as $kt => $tributo) {
            showTributo($this, $t, $kt, $tributo);
            $t++;
        }
        ?>
    </div>
    <div id="divAlicuotas" class="divVentaAfip" style="float: left;">
        <h2 class="h2header" id="lblProvedores" style="display: inline;">
            <?php echo __('Alicuotas'); ?>
        </h2>
        <?php
        echo "</br>";
        showAlicuota($this,0,3,0);
        showAlicuota($this,1,4,10.5);
        showAlicuota($this,2,5,21);
        showAlicuota($this,3,6,27);
        showAlicuota($this,4,8,5);
        showAlicuota($this,5,9,2.5);
        ?>
    </div>
    <div id="divOpcionales" class="divVentaAfip" style="width: 20%;float: left">
        <a href="#nuevo_opcionales" class="button_view" onclick="addCaposOpcionales();">
            <h2 class="h2header" id="lblProvedores" style="display: inline;">
                <?php echo __('Opcionales'); ?>
            </h2>
            <?php echo $this->Html->image('add_view.png', array('alt' => 'add','id'=>'img12','class'=>'img_add'));?>
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
    
    
    <div id="divTotales" class="divVentaAfip" style="width: 100%">
        <h2>Totales</h2>
        <?php
        echo $this->Form->input('Gestionventa.0.importeneto', array(
                   'label'=>'Importe Neto',)
        );
        echo $this->Form->input('Gestionventa.0.importeiva', array(
                   'label'=>'Importe IVA',)
        );
        echo $this->Form->input('Gestionventa.0.importetributos', array(
                   'label'=>'Importe Tributos',)
        );
        echo $this->Form->input('Gestionventa.0.importenetoivaexento', array(
                   'label'=>'Importe IVA Exento',)
        );
        echo $this->Form->input('Gestionventa.0.importenetonogravado', array(
                   'label'=>'Importe Neto no gravado',)
        );
        echo $this->Form->input('Gestionventa.0.importetotal', array(
                   'label'=>'Importe Total',)
        );
        echo $this->Form->end(__('Aceptar')); 
        ?>    
    </div>

</div>
<!-- /.modal -->
<!-- Popin Modal para edicion de ventas a utilizar por datatables-->
<div class="modal fade" id="myModalAddAlicuota" tabindex="-1" role="dialog">
    <div class="modal-dialog" style="width:90%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
<!--                    <span aria-hidden="true">&times;</span>-->
                </button>
                <h4 class="modal-title">Agregar Alicuota</h4>
            </div>
            <div class="modal-body">
                <div id="form_empleado" class="form" style="width: 94%;float: none; ">
                    <?php
                    echo $this->Form->create('Gestionalicuota',array('class'=>'formTareaCarga','controller'=>'Gestionalicuotas','action'=>'add')); ?>
                    <h3><?php echo __('Agregar Empleado'); ?></h3>
                    <fieldset style="">
                        <legend style="color:#1e88e5;font-weight:normal;">Datos Personales</legend>
                        <?php
                       
                        ?>
                    </fieldset>
                        <?php
                    echo $this->Form->end(__('Aceptar')); ?>
                </div>        
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <!--                <button type="button" class="btn btn-primary">Save changes</button>-->
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
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
function showAlicuota($context,$num,$idafip,$porcentaje){
    echo $context->Form->input('Gestionventa.0.Gestionalicuota.'.$num.'.idafip',array(
            'value'=>$idafip,
            'type'=>'hidden'
        )
    ); 
    echo $context->Form->input('Gestionventa.0.Gestionalicuota.'.$num.'.baseimponible',array('style'=>'width:150px',
        'label'=>$porcentaje.'% Base Imponible',
        'readonly'=>'readonly',
        ));
    echo $context->Form->input('Gestionventa.0.Gestionalicuota.'.$num.'.importe',array(
        'label'=>'Importe',
        'readonly'=>'readonly',));
    echo "</br>";   
}
function showTributo($context,$num,$idafip,$desc){
    $label = ($num==0)?true:false;
    echo $context->Form->input('Gestionventa.0.Gestiontributo.'.$num.'.idafip',array(
            'value'=>$idafip,
            'type'=>'hidden'
        )
    ); 
    echo $context->Form->input('Gestionventa.0.Gestiontributo.'.$num.'.descripcion',array(
            'value'=>$desc,
            'type'=>'hidden'    
        )
    ); 
    echo $context->Form->label('Gestionventa.0.Gestiontributo.'.$num.'.label',
            $desc
           ); 
    echo $context->Form->input('Gestionventa.0.Gestiontributo.'.$num.'.baseimponible',array('style'=>'width:150px',
        'label'=>'Base Imponible',
        'label'=> ($num==0)?'Base Imponible':false,
        'onchange'=>'calcularTributo('.$num.')',
        'required'=>false
    ));
    echo $context->Form->input('Gestionventa.0.Gestiontributo.'.$num.'.alicuota',array('style'=>'width:150px',
        'label'=>'% alicuota',
        'label'=>($num==0)?'Alicuota':false,
        'onchange'=>'calcularTributo('.$num.')',
        'required'=>false    
        ));
    echo $context->Form->input('Gestionventa.0.Gestiontributo.'.$num.'.importe',array(
        'label'=>($num==0)?'Importe':false,
        'readonly'=>'readonly',
        'class'=>'inputSubtotalTributos',
        'required'=>false
        ));
    echo "</br>";   
}
?>