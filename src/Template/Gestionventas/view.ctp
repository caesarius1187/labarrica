<?php
echo $this->Html->script('gestionventas/view',array('inline'=>false));
?>
<div class="gestionventas view">
    <table cellpadding = "0" cellspacing = "0" class="" style="width: 90%;margin-left: 5%;margin-top: 10px;">
        <tr>
            <td colspan="20" class="tdborder" style="text-align: center;font-size: 14px;padding-left: 53px;">ORIGINAL</td>
        </tr>
        <tr>
            <td class="tdborderleft" style="text-align: center;font-size: 18px;padding-top: 12px"><?php echo $gestionventa['Cliente']['nombre'] ?></td>
            <td class="tdborderleftrightbottom">
                <label id="lblLetraComprobante" style="text-align: center;font-size: 24px">
                    <?php echo $gestionventa['Gestionventa']['comprobante'] ?>
                </label>
                <label id="lblCodigoComprobante" style="text-align: center;font-size: 8px"></label>
            </td>
            <td style="" class="tdborderright">
                <label id="lblPalabraComprobante" style="font-size: 18px;margin-top: 12px">
                </label>
            </td>
        </tr>
        <tr>
            <td class="tdborderleft"></td>
            <td rowspan="4" class="tdborderbottom"><div class="vl"></div></td>
            <td class="tdborderright">
                Punto de Venta: <?php echo $gestionventa['Puntosdeventa']['nombre']?>
                Comp. Nro: <?php echo $gestionventa['Gestionventa']['comprobantedesde']?>
            </td>
        </tr>
        <tr>
            <td class="tdborderleft">Raz&oacute;n Social: <?php echo $gestionventa['Cliente']['nombre'] ?></td>
            <td class="tdborderright">
                Fecha de emisión: <?php echo $gestionventa['Gestionventa']['fecha']?>
            </td>
        </tr>
        <tr>
            <td class="tdborderleft">Domicilio Comercial: <?php 
            echo $gestionventa['Puntosdeventa']['Domicilio']['calle']."-".
                    $gestionventa['Puntosdeventa']['Domicilio']['Localidade']['Partido']['nombre']."-".
                    $gestionventa['Puntosdeventa']['Domicilio']['Localidade']['nombre'];?>
            </td>
            <td class="tdborderright">
                <label>CUIT: <?php echo $gestionventa['Cliente']['cuitcontribullente']?></label>
                <label>Ingresos Brutos: <?php echo $gestionventa['Cliente']['cuitcontribullente']?></label>
            </td>
        </tr>
        <tr>
            <td class="tdborderleftbottom">Condicion frente al IVA: <?php echo $impclisactivados['condicionIVA']; ?></td>
            <td class="tdborderrightbottom">
                Fecha de Inicio de Actividades: <?php echo $gestionventa['Cliente']['fchcumpleanosconstitucion']?>
            </td>
        </tr>
        <?php
        if($gestionventa['Gestionventa']['concepto']!=1){
            ?>
        <tr>
            <td colspan="2" class="tdbordertopleftbottom">
                Per&iacute;odo Facturado Desde: <?php echo $gestionventa['Gestionventa']['servdesde'] ?>
                Per&iacute;odo Facturado Desde: <?php echo $gestionventa['Gestionventa']['servhasta'] ?>
            </td>
            <td class="tdbordertoprightbottom">
                Fecha de Vto. para el pago: <?php echo $gestionventa['Cliente']['vtopago']?>
            </td>
        </tr>
            <?php
        }
        ?>
        <tr>

            <td>CUIT: <?php echo h($gestionventa['Gestionventa']['documento']); ?></td>
            <td colspan="2">Apellido y Nombre/Raz&oa&oacute;n Social:<?php echo __('Nombre'); ?></td>        
        </tr>
        <tr>    
            <td>Condicion frente al IVA: <?php echo $gestionventa['Gestionventa']['condicioniva'] ?></td>
            <td colspan="2">Domicilio: <?php echo $gestionventa['Gestionventa']['domicilio'] ?> </td>
        </tr>
        <tr>
            <td>
                    Condicion de venta: ????
            </td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                    Subtotal:$ <?php echo h($gestionventa['Gestionventa']['importeneto']); ?>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                    Importe IVA:$ <?php echo h($gestionventa['Gestionventa']['importeiva']); ?>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                    Importe Otros Tributos:$ <?php echo h($gestionventa['Gestionventa']['importetributos']); ?>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                    Importe Exento:$ <?php echo h($gestionventa['Gestionventa']['importeivaexento']); ?>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                    Importe No Gravado:$ <?php echo h($gestionventa['Gestionventa']['importenetogravado']); ?>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                    Importe total:$ <?php echo h($gestionventa['Gestionventa']['importetotal']); ?>
            </td>
        </tr>

    </table>
</div>
<div class="related">
	<h3><?php echo __('Related Gestionalicuotas'); ?></h3>
	<?php if (!empty($gestionventa['Gestionalicuota'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Gestionventa Id'); ?></th>
		<th><?php echo __('Idafip'); ?></th>
		<th><?php echo __('Baseimponible'); ?></th>
		<th><?php echo __('Importe'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($gestionventa['Gestionalicuota'] as $gestionalicuota): ?>
		<tr>
			<td><?php echo $gestionalicuota['id']; ?></td>
			<td><?php echo $gestionalicuota['gestionventa_id']; ?></td>
			<td><?php echo $gestionalicuota['idafip']; ?></td>
			<td><?php echo $gestionalicuota['baseimponible']; ?></td>
			<td><?php echo $gestionalicuota['importe']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'gestionalicuotas', 'action' => 'view', $gestionalicuota['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'gestionalicuotas', 'action' => 'edit', $gestionalicuota['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'gestionalicuotas', 'action' => 'delete', $gestionalicuota['id']), array(), __('Are you sure you want to delete # %s?', $gestionalicuota['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>
<div class="related">
	<h3><?php echo __('Related Gestiontributos'); ?></h3>
	<?php if (!empty($gestionventa['Gestiontributo'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Gestionventa Id'); ?></th>
		<th><?php echo __('Idafip'); ?></th>
		<th><?php echo __('Desc'); ?></th>
		<th><?php echo __('Baseimponible'); ?></th>
		<th><?php echo __('Alicuota'); ?></th>
		<th><?php echo __('Importe'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($gestionventa['Gestiontributo'] as $gestiontributo): ?>
		<tr>
			<td><?php echo $gestiontributo['id']; ?></td>
			<td><?php echo $gestiontributo['gestionventa_id']; ?></td>
			<td><?php echo $gestiontributo['idafip']; ?></td>
			<td><?php echo $gestiontributo['desc']; ?></td>
			<td><?php echo $gestiontributo['baseimponible']; ?></td>
			<td><?php echo $gestiontributo['alicuota']; ?></td>
			<td><?php echo $gestiontributo['importe']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'gestiontributos', 'action' => 'view', $gestiontributo['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'gestiontributos', 'action' => 'edit', $gestiontributo['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'gestiontributos', 'action' => 'delete', $gestiontributo['id']), array(), __('Are you sure you want to delete # %s?', $gestiontributo['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>
