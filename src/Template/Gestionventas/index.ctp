<?php 
echo $this->Html->css('bootstrapmodal');

echo $this->Html->script('jquery-ui.js',array('inline'=>false));

echo $this->Html->script('languages.js',array('inline'=>false));
echo $this->Html->script('numeral.js',array('inline'=>false));
echo $this->Html->script('moment.js',array('inline'=>false));
echo $this->Html->script('jquery-calx-2.2.6',array('inline'=>false));

echo $this->Html->script('jquery.dataTables.js',array('inline'=>false));
echo $this->Html->script('dataTables.altEditor.js',array('inline'=>false));
echo $this->Html->script('bootstrapmodal.js',array('inline'=>false));
echo $this->Html->script('dataTables.buttons.min.js',array('inline'=>false));
echo $this->Html->script('buttons.print.min.js',array('inline'=>false));
echo $this->Html->script('buttons.flash.min.js',array('inline'=>false));
echo $this->Html->script('jszip.min.js',array('inline'=>false));
echo $this->Html->script('pdfmake.min.js',array('inline'=>false));
echo $this->Html->script('vfs_fonts.js',array('inline'=>false));
echo $this->Html->script('buttons.html5.min.js',array('inline'=>false));

echo $this->Html->script('gestionventas/index',array('inline'=>false));
?>
<div class="gestionventas index">
    
    <div class="fab blue" style="float: right">
        <core-icon icon="add" align="center" style="margin: 0px 3px;">
            <?php echo $this->Form->button('+', 
                array('type' => 'button',
                    'class' =>"btn_add",
                    'onClick' => "window.location.href='".Router::url(array(
                            'controller'=>'gestionventas', 
                            'action'=>'add')
                        )."'"
                    )
            );?> 
        </core-icon>
        <paper-ripple class="circle recenteringTouch" fit></paper-ripple>
    </div>
    <h2><?php echo __('Ventas'); ?></h2>
    <table cellpadding="0" cellspacing="0" id="tblVentas">
	<thead>
            <tr>
                <th>Nombre</th>
                <th>Documento</th>
                <th>Punto de venta</th>
                <th>Comprobante</th>
                <th>Nro Comp</th>
                <th>Fecha</th>
                <th>Concepto</th>
                <th>Condicion IVA</th>
                <th>Neto</th>
                <th>IVA</th>
                <th>Tributos</th>
                <th>IVA exento</th>
                <th>Netogravado</th>
                <th>Total</th>
                <th class="actions">Acciones</th>
            </tr>
	</thead>
	<tbody>
	<?php foreach ($gestionventas as $gestionventa): ?>
            <tr>
                <td><?php echo h($gestionventa['Gestionventa']['nombre']); ?>&nbsp;</td>
                <td><?php echo h($gestionventa['Gestionventa']['documento']); ?>&nbsp;</td>
                <td>
                    <?php echo $this->Html->link($gestionventa['Puntosdeventa']['nombre'], array('controller' => 'puntosdeventas', 'action' => 'view', $gestionventa['Puntosdeventa']['id'])); ?>
                </td>
                <td><?php echo h($gestionventa['Gestionventa']['comprobante']); ?>&nbsp;</td>
                <td><?php echo h($gestionventa['Gestionventa']['comprobantedesde']); ?>&nbsp;</td>
                <td><?php echo h($gestionventa['Gestionventa']['fecha']); ?>&nbsp;</td>
                <td><?php echo h($gestionventa['Gestionventa']['concepto']); ?>&nbsp;</td>
                <td><?php echo h($gestionventa['Gestionventa']['condicioniva']); ?>&nbsp;</td>
                <td><?php echo h($gestionventa['Gestionventa']['importeneto']); ?>&nbsp;</td>
                <td><?php echo h($gestionventa['Gestionventa']['importeiva']); ?>&nbsp;</td>
                <td><?php echo h($gestionventa['Gestionventa']['importetributos']); ?>&nbsp;</td>
                <td><?php echo h($gestionventa['Gestionventa']['importeivaexento']); ?>&nbsp;</td>
                <td><?php echo h($gestionventa['Gestionventa']['importenetogravado']); ?>&nbsp;</td>
                <td><?php echo h($gestionventa['Gestionventa']['importetotal']); ?>&nbsp;</td>
                <td class="actions">
                        <?php echo $this->Html->link(__('View'), array('action' => 'view', $gestionventa['Gestionventa']['id'])); ?>
                        <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $gestionventa['Gestionventa']['id'])); ?>
                        <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $gestionventa['Gestionventa']['id']), array(), __('Are you sure you want to delete # %s?', $gestionventa['Gestionventa']['id'])); ?>
                </td>
            </tr>
<?php endforeach; ?>
	</tbody>
        <tfoot>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
	</tfoot>
    </table>
</div>

