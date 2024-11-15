<?php
session_start();
error_reporting(7);
iconv_set_encoding('internal_encoding', 'utf-8'); 
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');
$_SESSION['time']=mktime();

$ruta="../";
$title = 'INICIO';

extract($_SESSION);
extract($_POST);
extract($_GET);
//print_r($_SESSION);

$hoy = date("Y-m-d");
$ahora = date("H:i:00"); 
$anio = date("Y");
$mes_ahora = date("m");
$mes = strftime("%B");
$dia = date("N");
$semana = date("W");
$titulo ="Agenda";
$genera ="";



include($ruta.'header1.php');

include('calendario.php');

$sql_agenda = "
SELECT
	agenda.agenda_id, 
	agenda.paciente_id, 
	agenda.usuario_id, 
	agenda.f_ini, 
	agenda.h_ini, 
	agenda.f_fin, 
	agenda.h_fin, 
	agenda.f_registro, 
	agenda.h_registro, 
	agenda.color, 
	CONCAT(pacientes.paciente,' ',pacientes.apaterno,' ',pacientes.amaterno) as paciente,  
	agenda.observ, 
	pacientes.email, 
	pacientes.celular,
	pacientes.empresa_id
FROM
	agenda
	INNER JOIN pacientes ON agenda.paciente_id = pacientes.paciente_id
WHERE
	pacientes.empresa_id = $empresa_id
	";
$result_agenda = ejecutar($sql_agenda);  
$cnt_agenda = mysqli_num_rows($result_agenda);
//include($ruta.'header.php');
?>

    <!-- JQuery DataTable Css -->
    <link href="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
<!-- <script src='<?php echo $ruta; ?>fullcalendar-6.1.7/packages/bootstrap5/index.global.js'></script> -->
<script src='<?php echo $ruta; ?>fullcalendar-6.1.7/dist/index.global.js'></script>
<script>

	document.addEventListener('DOMContentLoaded', function() {
	    var calendarEl = document.getElementById('calendar');
	    var calendar = new FullCalendar.Calendar(calendarEl, {
	    	

	      	initialDate: '<?php echo $hoy; ?>',
	      	initialView: 'timeGridWeek',
	      	slotMinTime: '09:00:00',
    		slotMaxTime: '20:00:00',
	  		headerToolbar: {	
		        language: 'es',
		        left: 'prev,next today',
		        center: 'title',
		        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek' 
	      	},
			height: 'auto',
			navLinks: true, // can click day/week names to navigate views
			editable: false,
			selectable: false,
			selectMirror: false,
			weekNumbers: true,
			nowIndicator: true,
			select: function(arg) {
			    var title = prompt('Event Title:');
			    if (title) {
			      calendar.addEvent({
			        title: title,
			        start: arg.start,
			        end: arg.end,
			        allDay: arg.allDay
			      })
			    }
			    calendar.unselect()
			},
	  	    eventClick: function(info) {
			    var title = info.event.title;
			    var start = info.event.start;
			    var end = info.event.end;
			    var id = info.event.id;
				var id = 'id='+id;
				$('#contenido').html('');
				$('#load').show();
				$('#modal').click();
				$.ajax({
	                url: 'evento.php',
	                type: 'POST',
	                data: id,
	                cache: false,
	                success:function(html){
	                	//alert('Se modifico correctemente');        
	                    $('#contenido').html(html);
	                    $('#load').hide(); 
						//$('#modal').click();
	                    //$('#muestra_asegurado').click();
					}
				});
			},
		      
			editable: true,
			dayMaxEvents: true,       
			events: [
				<?php
					$cnt = 1;
				while($row_agenda = mysqli_fetch_array($result_agenda)){
	            extract($row_agenda);
			    echo " {	
			          title: '$paciente',
			          id: '$agenda_id',
			          start: '".$f_ini."T".$h_ini."',
			          end: '".$f_fin."T".$h_fin."',
			          color: '#3A87AD',
			          textColor: '#ffffff',
			          description: 'Lorem ipsum 1...'
			        } ";   
					if ($cnt_agenda <> $cnt) {
						echo ",";
					}        
	            	$cnt++;
	        	}
	            ?>
			]
	    });
	    	calendar.render();
	});

</script>
<style>

  body {
    margin: 40px 10px;
    padding: 0;
    font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
    font-size: 14px;
  }

  #calendar {
    max-width: 1100px;
    margin: 0 auto;
  }

</style>
<?php
$paciente_id ='';
extract($_POST);
extract($_GET);

  include($ruta.'header2.php'); ?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>AGENDA</h2>  
        </div>
        <div style="min-width: 350px" class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div style="height: 95%"  class="header">
                    	<h1 align="center">Agenda</h1>
				        <button style="display: none" type="button" id="modal" class="btn btn-default waves-effect m-r-20" data-toggle="modal" data-target="#largeModal">MODAL - LARGE SIZE</button>							
						<hr>
						<?php if ($funcion == 'SISTEMAS' || $funcion == 'ADMINISTRADOR' || $funcion == 'TECNICO' || $funcion == 'RECEPCION'  ) { ?>
						<button id="agendar" type="button" class="btn bg-<?php echo $body; ?>" data-dismiss="modal"><i class="material-icons">add_box</i> Agendar</button>
                        <script>
                            $('#agendar').click(function(){ 
                            	//alert($('#dia_busca').val()); 
                                $('#contenido').html(''); 
                                $('#load').show();
                                $('#modal').click(); 
                                var paciente_id = '<?php echo $paciente_id; ?>';
                                
                				$.ajax({
					                url: 'add_evento.php',
					                type: 'POST',
					                data: 'paciente_id='+paciente_id,
					                cache: false,
					                success:function(html){
					                	//alert('Se modifico correctemente');        
					                    $('#contenido').html(html);
					                    $('#load').hide(); 
										//$('#modal').click();
					                    //$('#muestra_asegurado').click();
									}
								});
                            });
                        </script>
                        <?php } ?> 								
						<hr>
						<div id='calendar'></div>                                	
			            <!-- Default Size -->
			            <!-- Large Size -->
			            <div class="modal fade" id="largeModal" tabindex="-1" role="dialog">
			                <div class="modal-dialog modal-lg" role="document">
			                    <div class="modal-content">
			                        <div class="modal-header">
			                        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                            <h4 class="modal-title" id="largeModalLabel">Calendario</h4>
			                        </div>
									<div style="display: none" align="center" id='load'>											
		                                <div class="preloader pl-size-xl">
		                                    <div class="spinner-layer">
		                                        <div class="circle-clipper left">
		                                            <div class="circle"></div>
		                                        </div>
		                                        <div class="circle-clipper right">
		                                            <div class="circle"></div>
		                                        </div>
		                                    </div>
		                                </div>
		                                <h4>Cargando</h4>
	                                </div>					                        
									<div id="contenido"></div>              
			                    </div>
			                </div>
			            </div>					                                           
                	</div>
            	</div>
        	</div>
    	</div>
    </div>   
</section>
<?php	include($ruta.'footer1.php');	?>
	<!-- Jquery DataTable Plugin Js -->
	<script src="<?php echo $ruta; ?>plugins/jquery-datatable/jquery.dataTables.js"></script>
	<script src="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
	<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
	<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
	<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
	<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
	<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
	<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
	<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>
	<script src="<?php echo $ruta; ?>js/pages/tables/jquery-datatable.js"></script>

	<!-- Autosize Plugin Js -->
	<script src="<?php echo $ruta; ?>plugins/autosize/autosize.js"></script>
	
	<!-- Moment Plugin Js -->
	<script src="<?php echo $ruta; ?>plugins/momentjs/moment.js"></script>

<?php	include($ruta.'footer2.php');	?>