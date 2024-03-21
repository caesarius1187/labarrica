<?php
use Cake\Routing\Router;
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Venta[]|\Cake\Collection\CollectionInterface $ventas
 */
$this->Html->css([
    'AdminLTE./plugins/datepicker/datepicker3',
    'AdminLTE./plugins/datatables/dataTables.bootstrap',
  ],
  ['block' => 'css']);

$this->Html->script([
    'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.5/Chart.min.js',
    'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js',
    'AdminLTE./plugins/datatables/jquery.dataTables.min',
    'AdminLTE./plugins/datepicker/bootstrap-datepicker',
    'AdminLTE./plugins/datatables/dataTables.bootstrap.min',
],
['block' => 'script']);
?>

<?php $this->start('scriptBottom'); ?>
<?php 
$ventasBlancas = 0;
$ventasNegras = 0;

$datosGraficoVenta = [];
$datosGraficoCantidad = [];
$datosGraficoGanancias = [];
 
foreach ($detalleventas as $detalleventa){ 
  $ganancia = $detalleventa->nuevaganancia ;
  //$cantidad = $detalleventa->nuevocantidad ;
  $cantidad = 1;
  $kfecha = $detalleventa->created->i18nFormat('yyyy-MM');
   if(!isset($datosGraficoVenta[$kfecha])){
        $datosGraficoVenta[$kfecha] = 0;
    }
    if(!isset($datosGraficoGanancias[$kfecha])){
        $datosGraficoGanancias[$kfecha] = 0;
    }
    if(!isset($datosGraficoCantidad[$kfecha])){
        $datosGraficoCantidad[$kfecha] = 0;
    }
   $miganancia = $detalleventa->nuevosubtotal - $detalleventa->nuevacosto ;
   $datosGraficoGanancias[$kfecha] += $miganancia;
}
foreach ($ventas as $venta){ 
    if(is_null($venta->comprobante_id)){
        $ventasNegras += $venta->nuevototal ;
    }else{
        $ventasBlancas += $venta->nuevototal ;
    }
    $kfecha = $venta->created->i18nFormat('yyyy-MM');
    if(!isset($datosGraficoVenta[$kfecha])){
        $datosGraficoVenta[$kfecha] = 0;
    }
    if(!isset($datosGraficoCantidad[$kfecha])){
        $datosGraficoCantidad[$kfecha] = 0;
    }
    if(!isset($datosGraficoGanancias[$kfecha])){
        $datosGraficoGanancias[$kfecha] = 0;
    }
    $datosGraficoVenta[$kfecha] += $venta->nuevototal ;
    $datosGraficoCantidad[$kfecha] += $venta->nuevacantidad ;
} 

ksort($datosGraficoVenta);
ksort($datosGraficoCantidad);
ksort($datosGraficoGanancias);

$labelsGraficoLineal = [];
foreach ($datosGraficoVenta as $key => $value) {
    $newLabel = date('d-m-Y',strtotime($key));
    array_push($labelsGraficoLineal,$newLabel);
}
?>
<script>
  $(function () {
    $('.datepicker').datepicker({
      autoclose: true,
      format: 'mm-yyyy'
    });
    
    //-------------
    //- LINE CHART Ventas-
    //--------------
    var areaChartData = {
      labels: <?= json_encode($labelsGraficoLineal) ?>,
      datasets: [
        {
            label: "Ventas",
            fillColor: "rgba(53, 209, 48, 1)",
            strokeColor: "rgba(53, 209, 48, 1)",
            pointColor: "rgba(53, 209, 48, 1)",
            pointStrokeColor: "#c1c7d1",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(53, 209, 48,1)",
            data: <?= json_encode(array_values($datosGraficoVenta)) ?>,
            lineTension: 0.3,
            fill: false,
            borderColor: 'rgba(53, 209, 48, 1)',
            backgroundColor: 'transparent',
            pointBorderColor: 'rgba(53, 209, 48, 1)',
            pointBackgroundColor: 'rgba(53, 209, 48, 1)',
            pointRadius: 5,
            pointHoverRadius: 15,
            pointHitRadius: 30,
            pointBorderWidth: 2,
            pointStyle: 'rect'
        }
      ]
    };    
    var areaChartOptions = {
      //Boolean - If we should show the scale at all
      showScale: true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines: false,
      //String - Colour of the grid lines
      scaleGridLineColor: "rgba(0,0,0,.05)",
      //Number - Width of the grid lines
      scaleGridLineWidth: 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines: true,
      //Boolean - Whether the line is curved between points
      bezierCurve: true,
      //Number - Tension of the bezier curve between points
      bezierCurveTension: 0.3,
      //Boolean - Whether to show a dot for each point
      pointDot: false,
      //Number - Radius of each point dot in pixels
      pointDotRadius: 4,
      //Number - Pixel width of point dot stroke
      pointDotStrokeWidth: 1,
      //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
      pointHitDetectionRadius: 20,
      //Boolean - Whether to show a stroke for datasets
      datasetStroke: true,
      //Number - Pixel width of dataset stroke
      datasetStrokeWidth: 2,
      //Boolean - Whether to fill the dataset with a color
      datasetFill: true,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
      //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio: true,
      //Boolean - whether to make the chart responsive to window resizing
      responsive: true,
      xAxes: [{
        type: 'time',
        position: 'bottom',
        time: {
          displayFormats: {'day': 'MM/YY'},
          tooltipFormat: 'DD/MM/YY',
          unit: 'month',
         }
      }],
    };
    var lineChartCanvas = $("#lineChart");
    var lineChartOptions = areaChartOptions;
    lineChartOptions.datasetFill = false;
    var lineChart = new Chart(lineChartCanvas, {
        type: 'line',
        data: areaChartData,
        options: lineChartOptions
    });
    //-------------
    //- LINE CHART Ganancias-
    //--------------
   
    var areaChartData = {
      labels: <?= json_encode($labelsGraficoLineal) ?>,
      datasets: [
        {
            label: "Ganancias",
            fillColor: "rgba(242, 239, 58,0.9)",
            strokeColor: "rgba(242, 239, 58,0.9)",
            pointColor: "rgba(242, 239, 58,0.9)",
            pointStrokeColor: "#c1c7d1",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(242, 239, 58,1)",
            data: <?= json_encode(array_values($datosGraficoGanancias)) ?>,
            lineTension: 0.3,
            fill: false,
            borderColor: 'rgba(242, 239, 58,1)',
            backgroundColor: 'transparent',
            pointBorderColor: 'rgba(242, 239, 58,1)',
            pointBackgroundColor: 'rgba(242, 239, 58,1)',
            pointRadius: 5,
            pointHoverRadius: 15,
            pointHitRadius: 30,
            pointBorderWidth: 2,
            pointStyle: 'rect'
        }

      ]
    };
    
    var lineChartCanvas2 = $("#lineChartGanancias");
    lineChartOptions.datasetFill = false;
    var lineChart = new Chart(lineChartCanvas2, {
        type: 'line',
        data: areaChartData,
        options: lineChartOptions
    });

    //-------------
    //- LINE CHART Cantidad-
    //--------------
    var areaChartData = {
      labels: <?= json_encode($labelsGraficoLineal) ?>,
      datasets: [
        {
            label: "Cantidad",
            fillColor: "rgba(244, 66, 66,0.9)",
            strokeColor: "rgba(244, 66, 66,0.8)",
            pointColor: "rgba(244, 66, 66,0.8)",
            pointStrokeColor: "rgba(244, 66, 66,1)",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(244, 66, 66,1)",
            data: <?= json_encode(array_values($datosGraficoCantidad)) ?>,
            fill: false,
            borderColor: "rgba(244, 66, 66,0.8)",
            backgroundColor: 'transparent',
            pointBorderColor: "rgba(244, 66, 66,0.8)",
            pointBackgroundColor: "rgba(244, 66, 66,0.8)",
            pointRadius: 5,
            pointHoverRadius: 15,
            pointHitRadius: 30,
            pointBorderWidth: 2,
            pointStyle: 'rect'
        }
      ]
    };
    var lineChartCantidad = $("#lineChartCantidad");
    var lineChart = new Chart(lineChartCantidad, {
        type: 'line',
        data: areaChartData,
        options: lineChartOptions
    });
    
   });
</script>
<?php $this->end(); ?>

<section class="content">
    
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <?php
                    echo $this->Form->create($miventa,[
                            'id' => "formListarVenta", 
                            'class'=>'form-control-horizontal',
                            ]) ?>
                    <fieldset>
                        <legend>

                            <?=__('Informe desde: ')?>     
                            <?= __(date('d-m-Y',strtotime($fechaVentasDesde))) ?> 
                            <?= __(' hasta: '.date('d-m-Y',strtotime($fechaVentasHasta))) ?> 
                            
                        </legend>
                        <?php
                            echo $this->Form->label('Desde');
                             echo $this->Form->control('fecha', [
                                    'label'=>false,
                                    'type'=>'text',
                                    'default'=>date('d-m-Y',strtotime('-1 months')),
                                    //'label' => false,
                                    'empty' => true,
                                    'class'=>'form-control pull-right datepicker',
                                ]);
                             echo $this->Form->label('Hasta');
                              echo $this->Form->control('fechahasta', [
                                    'label'=>false,
                                    'type'=>'text',
                                    'default'=>date('d-m-Y'),
                                    //'label' => false,
                                    'empty' => true,
                                    'class'=>'form-control pull-right datepicker',
                                ]);
                        ?>
                      <?= $this->Form->button(__('Ver'),[
                        'style'=>'vertical-align: bottom;'
                      ]) ?>
                    </fieldset>                  
                    <?= $this->Form->end() ?>                      
                </div>
                         
                
                <div class="box box-info">
                        <div class="box-header with-border">
                          <h3 class="box-title">Ventas</h3>
                          <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                          </div>
                        </div>
                        <div class="box-body" style="display: block;">
                          <div class="chart">
                            <canvas id="lineChart" style="height: 250px; width: 594px;" height="312" width="742"></canvas>
                          </div>
                        </div>
                        <!-- /.box-body -->
                </div>        
                <div class="box box-info">
                        <div class="box-header with-border">
                          <h3 class="box-title">Ganancias</h3>
                          <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                          </div>
                        </div>
                        <div class="box-body" style="display: block;">
                          <div class="chart">
                            <canvas id="lineChartGanancias" style="height: 250px; width: 594px;" height="312" width="742"></canvas>
                          </div>
                        </div>
                        <!-- /.box-body -->
                </div>        
                <div class="box box-info">
                        <div class="box-header with-border">
                          <h3 class="box-title">Cantidad</h3>
                          <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                          </div>
                        </div>
                        <div class="box-body" style="display: block;">
                          <div class="chart">
                            <canvas id="lineChartCantidad" style="height: 250px; width: 594px;" height="312" width="742"></canvas>
                          </div>
                        </div>
                        <!-- /.box-body -->
                </div>             
            <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->
