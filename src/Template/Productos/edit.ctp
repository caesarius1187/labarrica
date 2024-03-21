<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Producto $producto
 */
echo $this->Html->script('productos/edit',array('inline'=>false));

?>
<div class=" modal-primary fade in" id="modal-primary" style="display: block; padding-right: 20px;">
    <div class="modal-dialog">
        <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Editar Producto</h4>
              </div>
              <div class="modal-body">
                <?php
                echo $this->Form->create($producto,[
                            'id' => "formEditarProducto", 
                            'class'=>'form-control-horizontal',
                            'url'=>[                                
                                'controller'=>'Productos',
                                'action'=>'edit',
                            ]
                        ]);
                        echo $this->Form->control('id', ['type' => 'hidden']);
                        echo $this->Form->control('rubro_id', ['options' => $rubros]);
                        echo $this->Form->control('nombre',['style'=>'width:250px;'])."</br>";
                        echo $this->Form->control('costo')."</br>";
                        echo $this->Form->control('ganancia',[]);
                        echo $this->Form->control('precio')."</br>";

                        echo $this->Form->control('gananciapack',[]);
                        echo $this->Form->control('preciopack',['label'=>'Precion unidad en pack 0']);
                        echo $this->Form->control('preciopack0')."</br>";

                        echo $this->Form->control('ganancia1',[]);
                        echo $this->Form->control('preciomayor1',['label'=>'Precion unidad en pack 1']);
                        echo $this->Form->control('preciopack1')."</br>";

                        echo $this->Form->control('ganancia2',[]);
                        echo $this->Form->control('preciomayor2',['label'=>'Precion unidad en pack 2']);
                        echo $this->Form->control('preciopack2')."</br>";

                        echo $this->Form->control('ganancia3',[]);
                        echo $this->Form->control('preciomayor3',['label'=>'Precion unidad en pack 3']);
                        echo $this->Form->control('preciopack3')."</br>";

                        echo $this->Form->control('ganancia4',[]);
                        echo $this->Form->control('preciomayor4',['label'=>'Precion unidad en pack 4']);
                        echo $this->Form->control('preciopack4')."</br>";

                        echo $this->Form->control('codigo');
                        echo $this->Form->control('codigopack');
                        echo $this->Form->control('cantpack',[]);
                        echo $this->Form->control('stockminimo',[]);
                        echo $this->Form->control('stock',[]);


                       unlockfields($this);

                    ?>
                <?= $this->Form->end() ?>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick='$("#formEditarProducto").submit()'>Guardar Producto</button>
              </div>
        </div>
            <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<?php
function unlockfields($context){
     $context->Form->unlockField('ganancia');
     $context->Form->unlockField('precio');

     $context->Form->unlockField('gananciapack');
     $context->Form->unlockField('preciopack');
     $context->Form->unlockField('preciopack0');
     $context->Form->unlockField('ganancia1');
     $context->Form->unlockField('preciomayor1');
     $context->Form->unlockField('preciopack1');

     $context->Form->unlockField('ganancia2');
     $context->Form->unlockField('preciomayor2');
     $context->Form->unlockField('preciopack2');

     $context->Form->unlockField('ganancia3');
     $context->Form->unlockField('preciomayor3');
     $context->Form->unlockField('preciopack3');

     $context->Form->unlockField('ganancia4');
     $context->Form->unlockField('preciomayor4');
     $context->Form->unlockField('preciopack4');
}