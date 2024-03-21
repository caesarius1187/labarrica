<?php
use Cake\Routing\Router;

echo $this->Form->control('cantDetalle', [
    'type' => 'hidden', 
    'value' =>count($producto->promotions), 
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
<?php $this->start('scriptBottom'); ?>
    <script>
     $(function () {
        var cantDetalle = $("#cantDetalle").val();
        for (var i = 0; i < cantDetalle; i++) {
            calcularProducto(i);
        }
     });
    var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
    </script>
<?php  $this->end(); ?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box" style="float: left">
                <?php echo $this->Form->create($producto,[
                            'id' => "formAgregarPromocion", 
                            'class'=>'form-control-horizontal',
                            'type'=>'post',
                            'action'=>'edit'
                        ]);?>

                <div class="box-header">
                    <h3 class="box-title">Editar una Promocion</h3>                
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
                            foreach ($producto->promotions as $kp => $promocion) {
                                echo '<div id="divPromotion0'.$kp.'" class="divDV divPromotion'.$kp.'">';
                                echo $this->Form->label($promocion->nombre, [],[
                                    'text' => $promocion->producto->nombre, 
                                    'class' => 'lblPromotion', 
                                    'style' => 'width:200px;display: inline-flex;text-overflow: ellipsis;overflow: hidden;white-space: nowrap;'
                                ]);  
                                echo $this->Form->control('promotions.'.$kp.'.id', [
                                    'type' => 'hidden', 
                                    'value' => $promocion->id
                                ]);  
                                echo $this->Form->control('promotions.'.$kp.'.producto_id', [
                                    'type' => 'hidden', 
                                    'value' => $promocion->producto_id
                                ]); 
                                echo $this->Form->control('promotions.'.$kp.'.productopromocion_id', [
                                    'type' => 'hidden', 
                                    'value' => $promocion->productopromocion_id
                                ]);  
                                echo $this->Form->control('promotions.'.$kp.'.costo', [
                                    'value' => $promocion->costo,
                                    'onchange'=>'calcularProducto('.$kp.')',
                                ]); 
                                echo $this->Form->control('promotions.'.$kp.'.ganancia', [
                                    'value' => $promocion->ganancia,
                                    'onchange'=>'calcularProducto('.$kp.')',
                                ]); 
                                echo $this->Form->control('promotions.'.$kp.'.precio', [
                                    'value' => $promocion->precio,
                                    'onchange'=>'calcularGananciaProducto('.$kp.')',
                                ]); 
                                echo $this->Form->control('promotions.'.$kp.'.cantidad', [
                                    'value' => $promocion->cantidad,
                                    'onchange'=>'calcularProducto('.$kp.')',
                                ]);
                                echo $this->Form->control('promotions.'.$kp.'.subtotal', [
                                    'value' => $promocion->subtotal,
                                    'onchange'=>'calcularProducto('.$kp.')',
                                    'numDetalle'=>$kp,
                                    'class'=>'form-control subtotalproducto',
                                ]); 
                                echo '<a class="btn btn-app removedetallepromocion" style="vertical-align: bottom;width: 37px;height: 34px;padding: 5px 0 0 0;min-width: 0px;margin: -4px 0 15px 3px;" onclick="deletePromotion('.$promocion->id.','.$kp.')">
                                        <i class="fa fa-trash"></i>
                                    </a>';
                                echo '</div>';
                            }
                             
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
                        echo $this->Form->control('codigo');
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
//vamos a generar estoy post links para hacerlo fuera del form original y ejecutarlos desde dentro del form original
  foreach ($producto->promotions as $kp => $promocion) {
             echo $this->Form->postLink(__('Eliminar'), 
                [
                    'controller' => 'promotions',
                    'action' => 'delete', 
                    $promocion->id
                ], 
                [
                    'id' => "postLinkDelete".$promocion->id,
                    'style' => "display:none",
                    'confirm' => __('Are you sure you want to delete # {0}?', $promocion->id)
                ]);                    
    }
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