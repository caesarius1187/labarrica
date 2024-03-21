<?php
use Cake\Routing\Router;

echo $this->Form->control('cantDetalle', [
    'type' => 'hidden', 
    'value' => 0, 
]);  
echo $this->Form->control('allproductos', [
    'value' => "", 
    'type'=>'hidden'
    ]);


echo $this->Html->script('promotions/add', ['block' => true]);
$this->Html->css([
    'AdminLTE./plugins/datepicker/datepicker3',
    'AdminLTE./plugins/select2/select2.min',
  ],
  ['block' => 'css']);
$this->Html->script([
    'AdminLTE./plugins/select2/select2.full.min',
    'AdminLTE./plugins/datepicker/bootstrap-datepicker',
],
['block' => 'script']);
echo $this->Form->input('productoslista', [
    'type' => 'select', 
    'label' => false, 
    'style' => 'display:none;margin-bottom:0px;', 
    'options' => $productos, 
    'div'=>[
        'style' => 'display:none;margin-bottom:0px;', 
    ]
]);  
echo $this->Form->input('urlBuild', [
    'type' => 'hidden', 
    'value' => $this->Url->build( [ 'controller' => 'Productos', 'action' => 'search' ] ), 
]);  
echo $this->Form->input('urlBuildAutocomplete', [
    'type' => 'hidden', 
    'value' => $this->Url->build( [ 'controller' => 'Productos', 'action' => 'autoComplete' ] ), 
]);  
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Promotion $promotion
 */
?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box" style="float: left">
                <?php echo $this->Form->create($producto,[
                            'id' => "formAgregarPromocion", 
                            'class'=>'form-control-horizontal',
                            'action'=>'add'
                        ]);?>

                <div class="box-header">
                    <h3 class="box-title">Agregar una Promocion</h3>                
                </div>
                <!-- /.box-header -->
                <div class="box-body col-xs-8">
                    <div class="promotions index large-9 medium-8 columns content">
                        <fieldset id="fsDetalles">
                            <legend><?= __('Detalle de promocion') ?></legend>
                            <?php
                            echo $this->Form->control('buscador',[ 
                                    'style'=>'width:390px',
                                    'type'=>'text',
                                    'disabled'=>true,
                                    //'options' => $productos, 
                                    //'onchange' => 'agregarDetalle();', 
                                    'empty' => true]
                            );
                            ?>
                            <?php
                            $this->Form->unlockField('buscador');
                            unlockDetallefields($this);
                            ?>
                            </br>                               
                        </fieldset>                          
                    </div>
                </div>
                <div class="box-body col-xs-4">
                    <div class="promotions index large-9 medium-8 columns content">
                        <?php
                        echo $this->Form->control('id', [
                            'type' => 'hidden', 
                        ]);     
                         echo $this->Form->control('promocion', [
                            'type' => 'hidden', 
                            'value'=>1
                        ]);      
                        echo $this->Form->control('rubro_id', ['options' => $rubros])."</br>";
                        echo $this->Form->control('nombre',['style'=>'width:250px;'])."</br>";
                        echo $this->Form->control('codigo',['value'=>$topproducto[0]['ultimoproducto']+1,]);
                        echo $this->Form->control('costo');
                        echo $this->Form->control('precio')."</br>";
                        ?>
                    </div>
                </div>
            <!-- /.box-body -->
                <?= $this->Form->button(__('Guardar')) ?>
                <?= $this->Form->end() ?>
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<?php
function unlockDetallefields($context){
    for ($i=0; $i < 50; $i++) { 
        $context->Form->unlockField('promotions.'.$i.'.id');
        $context->Form->unlockField('promotions.'.$i.'.producto_id');
        $context->Form->unlockField('promotions.'.$i.'.productopromocion_id');
        $context->Form->unlockField('promotions.'.$i.'.precio');
        $context->Form->unlockField('promotions.'.$i.'.ganancia');
        $context->Form->unlockField('promotions.'.$i.'.costo');
        $context->Form->unlockField('promotions.'.$i.'.cantidad');
        $context->Form->unlockField('promotions.'.$i.'.subtotal');
    }
}?>