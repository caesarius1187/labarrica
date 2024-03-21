<?php 
use Cake\Routing\Router;
?>
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Bienvenidos a 
        <small>La Barrica</small>
      </h1>      
    </section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <!-- Left col -->
    <section class="col-lg-4 connectedSortable">
       <!-- Map box -->
      <div class="box box-solid bg-light-blue-gradient">
        <div class="box-header">
          <!-- tools box -->
          <div class="pull-right box-tools">
            <button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
              <i class="fa fa-minus"></i></button>
          </div>
          <!-- /. tools -->

          <i class="fa fa-bank"></i>

          <h3 class="box-title">
            Cajas
          </h3>
        </div>
        <div class="box-body">
            <?php 
            $idCaja = 0;
            $cajaAbierta = false;
            if(!empty($cajasabiertas)){
                foreach ($cajasabiertas as $kc => $caja) {
                  $idCaja = $caja['id'];
                  $cajaAbierta = true;
                }
            }
             echo $this->Form->button(
                  'Listar', 
                    array(
                        'onclick' => "window.location.href='".Router::url(
                            array(
                                'controller' => 'cajas',
                                'action' => 'index')
                         )."'",
                        'class'=>'btn btn-block btn-primary btn-flat',                            
                    )
                );
             if($cajaAbierta){
                echo $this->Form->button(
                  'Movimientos', 
                    array(
                        'onclick' => "window.location.href='".Router::url(
                            array(
                                'controller' => 'pagos',
                                'action' => 'index')
                         )."'",
                        'class'=>'btn btn-block btn-primary btn-flat',                            
                    )
                );
                echo $this->Form->button(
                  'Cerrar', 
                    array(
                        'onclick' => "window.location.href='".Router::url(
                            array(
                                'controller' => 'cajas',
                                'action' => 'cerrar',
                                $idCaja
                              )
                         )."'",
                        'class'=>'btn btn-block btn-primary btn-flat',                            
                    )
                );
            }else{
                echo $this->Form->button(
                  'Abrir', 
                    array(
                        'onclick' => "window.location.href='".Router::url(
                            array(
                                'controller' => 'cajas',
                                'action' => 'add',
                              )
                         )."'",
                        'class'=>'btn btn-block btn-primary btn-flat',                            
                    )
                );
            }
              
            ?>      
        </div>
        <!-- /.box-body-->
      </div>
      <!-- /.box -->
      <!-- Map box -->
      <div class="box box-solid bg-light-blue-gradient">
        <div class="box-header">
          <!-- tools box -->
          <div class="pull-right box-tools">
            <button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
              <i class="fa fa-minus"></i></button>
          </div>
          <!-- /. tools -->

          <i class="fa fa-shopping-cart"></i>

          <h3 class="box-title">
            Ventas
          </h3>
        </div>
        <div class="box-body">
            <?php 
              echo $this->Form->button(
                  'Listar', 
                  array(
                      'onclick' => "window.location.href='".Router::url(
                          array(
                              'controller' => 'ventas',
                              'action' => 'index')
                       )."'",
                      'class'=>'btn btn-block btn-primary btn-flat',                            
                  )
              );
            ?>    
            <?php 
              echo $this->Form->button(
                  'Detalle Ventas', 
                  array(
                      'onclick' => "window.location.href='".Router::url(
                          array(
                              'controller' => 'ventas',
                              'action' => 'listado')
                       )."'",
                      'class'=>'btn btn-block btn-primary btn-flat',                            
                  )
              );
            ?>     
            <?php 
              echo $this->Form->button(
                  'Agregar', 
                  array(
                      'onclick' => "window.location.href='".Router::url(
                          array(
                              'controller' => 'ventas',
                              'action' => 'addventa')
                       )."'",
                      'class'=>'btn btn-block btn-primary btn-flat',                            
                  )
              );
            ?>      
        </div>
        <!-- /.box-body-->
      </div>
      <!-- /.box -->
      <!-- Map box -->
      <div class="box box-solid bg-light-blue-gradient">
        <div class="box-header">
          <!-- tools box -->
          <div class="pull-right box-tools">
            <button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
              <i class="fa fa-minus"></i></button>
          </div>
          <!-- /. tools -->

          <i class="fa fa-money"></i>

          <h3 class="box-title">
            Compras
          </h3>
        </div>
        <div class="box-body">
            <?php 
              echo $this->Form->button(
                  'Listar', 
                  array(
                      'onclick' => "window.location.href='".Router::url(
                          array(
                              'controller' => 'compras',
                              'action' => 'index')
                       )."'",
                      'class'=>'btn btn-block btn-primary btn-flat',                            
                  )
              );
            ?>     
            <?php 
              echo $this->Form->button(
                  'Agregar', 
                  array(
                      'onclick' => "window.location.href='".Router::url(
                          array(
                              'controller' => 'compras',
                              'action' => 'add')
                       )."'",
                      'class'=>'btn btn-block btn-primary btn-flat',                            
                  )
              );
            ?>      
        </div>
        <!-- /.box-body-->
      </div>
      <!-- /.box -->
    </section>
    <!-- Right col -->
    <section class="col-lg-4 connectedSortable">     
      <!-- Map box -->
      <div class="box box-solid bg-light-blue-gradient">
        <div class="box-header">
          <!-- tools box -->
          <div class="pull-right box-tools">
            <button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
              <i class="fa fa-minus"></i></button>
          </div>
          <!-- /. tools -->

          <i class="fa fa-male"></i>

          <h3 class="box-title">
            Clientes/Provedores
          </h3>
        </div>
        <div class="box-body">
            <?php 
            echo $this->Form->button(
              'Listar', 
                array(
                    'onclick' => "window.location.href='".Router::url(
                        array(
                            'controller' => 'clientes',
                            'action' => 'index',
                          )
                     )."'",
                    'class'=>'btn btn-block btn-primary btn-flat',                            
                )
            );           
            ?>      
        </div>
        <!-- /.box-body-->
      </div>
      <!-- /.box -->
       <!-- Map box -->
      <div class="box box-solid bg-light-blue-gradient">
        <div class="box-header">
          <!-- tools box -->
          <div class="pull-right box-tools">
            <button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
              <i class="fa fa-minus"></i></button>
          </div>
          <!-- /. tools -->

          <i class="fa fa-users"></i>

          <h3 class="box-title">
            Usuarios
          </h3>
        </div>
        <div class="box-body">
            <?php 
            echo $this->Form->button(
              'Listar', 
                array(
                    'onclick' => "window.location.href='".Router::url(
                        array(
                            'controller' => 'usuarios',
                            'action' => 'index',
                          )
                     )."'",
                    'class'=>'btn btn-block btn-primary btn-flat',                            
                )
            );
            echo $this->Form->button(
              'Agregar', 
                array(
                    'onclick' => "window.location.href='".Router::url(
                        array(
                            'controller' => 'usuarios',
                            'action' => 'add',
                          )
                     )."'",
                    'class'=>'btn btn-block btn-primary btn-flat',                            
                )
            );
            ?>      
        </div>
        <!-- /.box-body-->
      </div>
      <!-- /.box -->
       <!-- Map box -->
      <div class="box box-solid bg-light-blue-gradient">
        <div class="box-header">
          <!-- tools box -->
          <div class="pull-right box-tools">
            <button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
              <i class="fa fa-minus"></i></button>
          </div>
          <!-- /. tools -->

          <i class="fa fa-building-o"></i>

          <h3 class="box-title">
            Puntos de Ventas
          </h3>
        </div>
        <div class="box-body">
            <?php 
            echo $this->Form->button(
              'Listar', 
                array(
                    'onclick' => "window.location.href='".Router::url(
                        array(
                            'controller' => 'puntodeventas',
                            'action' => 'index',
                          )
                     )."'",
                    'class'=>'btn btn-block btn-primary btn-flat',                            
                )
            );
            echo $this->Form->button(
              'Agregar', 
                array(
                    'onclick' => "window.location.href='".Router::url(
                        array(
                            'controller' => 'puntodeventas',
                            'action' => 'add',
                          )
                     )."'",
                    'class'=>'btn btn-block btn-primary btn-flat',                            
                )
            );
            ?>      
        </div>
        <!-- /.box-body-->
      </div>
      <!-- /.box -->
    </section>
    <section class="col-lg-4 connectedSortable">        
      <!-- Map box -->
      <div class="box box-solid bg-light-blue-gradient">
        <div class="box-header">
          <!-- tools box -->
          <div class="pull-right box-tools">
            <button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
              <i class="fa fa-minus"></i></button>
          </div>
          <!-- /. tools -->

          <i class="fa fa-barcode"></i>

          <h3 class="box-title">
            Productos
          </h3>
        </div>
        <div class="box-body">
            <?php 
              echo $this->Form->button(
                  'Listar', 
                  array(
                      'onclick' => "window.location.href='".Router::url(
                          array(
                              'controller' => 'productos',
                              'action' => 'index')
                       )."'",
                      'class'=>'btn btn-block btn-primary btn-flat',                            
                  )
              );
            ?>     
            <?php 
              /*echo $this->Form->button(
                  'Agregar', 
                  array(
                      'onclick' => "window.location.href='".Router::url(
                          array(
                              'controller' => 'productos',
                              'action' => 'add')
                       )."'",
                      'class'=>'btn btn-block btn-primary btn-flat',                            
                  )
              );*/
            ?>      
        </div>
        <!-- /.box-body-->
      </div>
       <!-- Map box -->
      <div class="box box-solid bg-light-blue-gradient">
        <div class="box-header">
          <!-- tools box -->
          <div class="pull-right box-tools">
            <button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
              <i class="fa fa-minus"></i></button>
          </div>
          <!-- /. tools -->

          <i class="fa fa-barcode"></i>

          <h3 class="box-title">
            Promociones
          </h3>
        </div>
        <div class="box-body">
            <?php 
              echo $this->Form->button(
                  'Listar', 
                  array(
                      'onclick' => "window.location.href='".Router::url(
                          array(
                              'controller' => 'promotions',
                              'action' => 'index')
                       )."'",
                      'class'=>'btn btn-block btn-primary btn-flat',                            
                  )
              );
            ?>     
            <?php 
              echo $this->Form->button(
                  'Agregar', 
                  array(
                      'onclick' => "window.location.href='".Router::url(
                          array(
                              'controller' => 'promotions',
                              'action' => 'add')
                       )."'",
                      'class'=>'btn btn-block btn-primary btn-flat',                            
                  )
              );
            ?>      
        </div>
        <!-- /.box-body-->
      </div>
      <!-- /.box -->
       <!-- Map box -->
      <div class="box box-solid bg-light-blue-gradient">
        <div class="box-header">
          <!-- tools box -->
          <div class="pull-right box-tools">
            <button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
              <i class="fa fa-minus"></i></button>
          </div>
          <!-- /. tools -->

          <i class="fa fa-barcode"></i>

          <h3 class="box-title">
            Rubros
          </h3>
        </div>
        <div class="box-body">
            <?php 
              echo $this->Form->button(
                  'Listar', 
                  array(
                      'onclick' => "window.location.href='".Router::url(
                          array(
                              'controller' => 'rubros',
                              'action' => 'index')
                       )."'",
                      'class'=>'btn btn-block btn-primary btn-flat',                            
                  )
              );
            ?>     
            <?php 
              echo $this->Form->button(
                  'Agregar', 
                  array(
                      'onclick' => "window.location.href='".Router::url(
                          array(
                              'controller' => 'rubros',
                              'action' => 'add')
                       )."'",
                      'class'=>'btn btn-block btn-primary btn-flat',                            
                  )
              );
            ?>      
        </div>
        <!-- /.box-body-->
      </div>
      <!-- /.box -->
    </section>
  </div>
  <!-- /.row (main row) -->
</section>
<!-- /.content -->
<?php
$this->Html->css([
    'AdminLTE./plugins/iCheck/flat/blue',
    'AdminLTE./plugins/morris/morris',
    'AdminLTE./plugins/jvectormap/jquery-jvectormap-1.2.2',
    'AdminLTE./plugins/datepicker/datepicker3',
    'AdminLTE./plugins/daterangepicker/daterangepicker',
    'AdminLTE./plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min'
  ],
  ['block' => 'css']);

$this->Html->script([
  'https://code.jquery.com/ui/1.11.4/jquery-ui.min.js',
  'https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js',
  'AdminLTE./plugins/morris/morris.min',
  'AdminLTE./plugins/sparkline/jquery.sparkline.min',
  'AdminLTE./plugins/jvectormap/jquery-jvectormap-1.2.2.min',
  'AdminLTE./plugins/jvectormap/jquery-jvectormap-world-mill-en',
  'AdminLTE./plugins/knob/jquery.knob',
  'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js',
  'AdminLTE./plugins/daterangepicker/daterangepicker',
  'AdminLTE./plugins/datepicker/bootstrap-datepicker',
  'AdminLTE./plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min',
  'AdminLTE./js/pages/dashboard',
],
['block' => 'script']);
?>

<?php $this->start('scriptBottom'); ?>
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
<?php  $this->end(); ?>
