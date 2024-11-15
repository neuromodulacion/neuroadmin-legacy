<?php session_start();
error_reporting(7);
iconv_set_encoding('internal_encoding', 'utf-8');
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');
$_SESSION['time'] = mktime();

$ruta = "../";
$title = 'INICIO';

extract($_SESSION);
//print_r($_SESSION);
extract($_POST);

$titulo = "Reporte";

$hoy = date("Y-m-d");
$ahora = date("H:i:00");
$anio = date("Y");
$mes_ahora = date("m");
$mes = strftime("%B");
$dia = date("N");
$semana = date("W");

if ($fechaInput == "") {
	$fechaInput = $anio . "-" . $mes_ahora;
	$mes_sel = $mes_ahora;
	$anio_sel = $anio;
} else {
	$mes_sel = date('m', strtotime($fechaInput));
	$anio_sel = date('Y', strtotime($fechaInput));
}



include ($ruta . 'header1.php');
?>
<link href="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

<!-- Bootstrap Material Datetime Picker Css -->
<link href="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

<!-- Bootstrap DatePicker Css -->
<link href="<?php echo $ruta; ?>plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />

<!-- Wait Me Css -->
<link href="<?php echo $ruta; ?>plugins/waitme/waitMe.css" rel="stylesheet" />

<!-- Bootstrap  Css -->
<link href="<?php echo $ruta; ?>plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.0/html2canvas.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.2/raphael-min.js"></script>
<script src="../morris.js-master/morris.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prettify/r224/prettify.min.js"></script>
<script src="../morris.js-master/examples/lib/example.js"></script>
<!--<script src="../morris.js-master/lib/example.js"></script>
<link rel="stylesheet" href="../morris.js-master/examples/lib/example.css">-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prettify/r224/prettify.min.css">
<link rel="stylesheet" href="../morris.js-master/morris.css">

		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<style type="text/css">
			${demo.css}
		</style>

<script src="../highcharts/js/highcharts.js"></script>
<script src="../highcharts/js/highcharts-more.js"></script>
<script src="../highcharts/js/modules/exporting.js"></script>



<?php
include ($ruta . 'header2.php');
//print_r($_SESSION);
?>

<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>REPORTE DE TÉCNICOS</h2>

		</div>
		<!-- // ************** Contenido ************** // -->
		<!-- CKEditor -->
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div style="height: 95%"  class="header">
						<h1 align="center">Reporte de Técnicos</h1>
						<hr>
						<?php // print_r($_POST);
						// echo $mes_sel."<br>";
						// echo $anio_sel."<br>";
						?>
						<div align="right">
							<form action="test.php" method="post">
								<?php // echo $fechaInput; ?>
								<input id="fechaInput" name="fechaInput" style="width: 180px" align="center" type="month" class="form-control" value="<?php echo $fechaInput; ?>"/>
								<input id="us" name="us" align="center" type="hidden" class="form-control" value="<?php echo $us; ?>"/>
							</form>
							<script>
								$(document).ready(function() {
									// Evento que detecta cambio en el valor del input de fecha
									$('#fechaInput').change(function() {
										// Envía el formulario en el que se encuentra este input
										$(this).closest('form').submit();
									});
								});
							</script>
						</div>
						<hr>

					</div>
				</div>
				<hr>
				<script type="text/javascript">
				$(function () {
				
				    $('#container').highcharts({
				        
				        chart: {
				            type: 'heatmap',
				            marginTop: 40,
				            marginBottom: 40
				        },
				
				
				        title: {
				            text: 'Sales per employee per weekday'
				        },
				
				        xAxis: {
				            categories: ['Alexander', 'Marie', 'Maximilian', 'Sophia', 'Lukas', 'Maria', 'Leon', 'Anna', 'Tim', 'Laura']
				        },
				
				        yAxis: {
				            categories: ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'],
				            title: null
				        },
				
				        colorAxis: {
				            min: 0,
				            minColor: '#FFFFFF',
				            maxColor: Highcharts.getOptions().colors[0]
				        },
				
				        legend: {
				            align: 'right',
				            layout: 'vertical',
				            margin: 0,
				            verticalAlign: 'top',
				            y: 25,
				            symbolHeight: 320
				        },
				
				        tooltip: {
				            formatter: function () {
				                return '<b>' + this.series.xAxis.categories[this.point.x] + '</b> sold <br><b>' +
				                    this.point.value + '</b> items on <br><b>' + this.series.yAxis.categories[this.point.y] + '</b>';
				            }
				        },
				
				        series: [{
				            name: 'Sales per employee',
				            borderWidth: 1,
				            data: [[0,0,10],[0,1,19],[0,2,8],[0,3,24],[0,4,67],[1,0,92],[1,1,58],[1,2,78],[1,3,117],[1,4,48],[2,0,35],[2,1,15],[2,2,123],[2,3,64],[2,4,52],[3,0,72],[3,1,132],[3,2,114],[3,3,19],[3,4,16],[4,0,38],[4,1,5],[4,2,8],[4,3,117],[4,4,115],[5,0,88],[5,1,32],[5,2,12],[5,3,6],[5,4,120],[6,0,13],[6,1,44],[6,2,88],[6,3,98],[6,4,96],[7,0,31],[7,1,1],[7,2,82],[7,3,32],[7,4,30],[8,0,85],[8,1,97],[8,2,123],[8,3,64],[8,4,84],[9,0,47],[9,1,114],[9,2,31],[9,3,48],[9,4,91]],
				            dataLabels: {
				                enabled: true,
				                color: 'black',
				                style: {
				                    textShadow: 'none',
				                    HcTextStroke: null
				                }
				            }
				        }]
				
				    });
				});
				</script>
				<div id="container" style="height: 400px; min-width: 310px; max-width: 800px; margin: 0 auto"></div>
		
			</div>
		</div>
	</div>
</section>

<?php
	include ($ruta . 'footer1.php');
	?>

<!-- Moment Plugin Js -->
<script src="<?php echo $ruta; ?>plugins/momentjs/moment.js"></script>

<!-- Bootstrap Material Datetime Picker Plugin Js -->
<script src="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

<!-- Bootstrap Datepicker Plugin Js -->
<script src="<?php echo $ruta; ?>plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

<!-- Waves Effect Plugin Js -->
<!-- Autosize Plugin Js -->
<script src="<?php echo $ruta; ?>plugins/autosize/autosize.js"></script>

<!-- Moment Plugin Js -->
<script src="<?php echo $ruta; ?>plugins/momentjs/moment.js"></script>

<!-- Jquery Knob Plugin Js -->
<script src="<?php echo $ruta; ?>plugins/jquery-knob/jquery.knob.min.js"></script>

<!-- Custom Js -->
<script src="<?php echo $ruta; ?>js/pages/charts/jquery-knob.js"></script>

<?php
	include ($ruta . 'footer2.php');
?>