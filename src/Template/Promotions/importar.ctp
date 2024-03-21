<?php
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
<script>
  $(function () {
    var table = $("#tblArchibosSubidos").DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
        }
    });
  });
</script>
<h1>Subir Archivo</h1>
<div class="content">
    <?= $this->Flash->render() ?>
    <div class="upload-frm">
        <?php echo $this->Form->create($uploadData, ['type' => 'file']); ?>
            <?php echo $this->Form->input('file', ['type' => 'file', 'class' => 'form-control']); ?>
            <?php echo $this->Form->button(__('Subir Archivo'), ['type'=>'submit', 'class' => 'form-controlbtn btn-default']); ?>
        <?php echo $this->Form->end(); ?>
    </div>
</div>
<h1>Archivos subidos</h1>
<div class="content">
    <!-- Table -->
    <table cellpadding="0" cellspacing="0" id="tblArchibosSubidos" class="toExcelTable">
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="20%">Archivo</th>
                <th width="12%">Fecha de subida</th>
                <th width="12%">Procesado</th>
                <th width="12%">Accion</th>
            </tr>
        </thead>
        <tbody>
            <?php if($filesRowNum > 0):$count = 0; foreach($files as $file): $count++;?>
            <tr>
                <td><?php echo $count; ?></td>
                <td><?php echo $file->name; ?></td>
                <td><?php echo $file->created; ?></td>
                <td><?php echo $file->procesado?'SI':'NO'; ?></td>
                <td><?= $this->Html->link(__('Procesar'), ['action' => 'procesar', $file->id]) ?></td>
            </tr>
            <?php endforeach; else:?>
            <tr><td colspan="3">No file(s) found......</td>
            <?php endif; ?>
        </tbody>
    </table>
</div>