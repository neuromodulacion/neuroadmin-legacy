<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$ruta = "../";
// Configurar variables de fecha y hora actuales
$hoy = date("Y-m-d");
$ahora = date("H:i:00"); 
$anio = date("Y");
$mes_ahora = date("m");
$mes = strftime("%B"); // Nombre del mes en español
$dia = date("N"); // Día de la semana (1-7, donde 1 es lunes)
$semana = date("W"); // Número de la semana del año
$titulo = "Agenda"; // Título de la página
$genera = ""; // Variable para posibles usos adicionales

// Incluir archivos de encabezado
include($ruta.'header1.php');

// Consulta SQL para obtener los eventos de la agenda asociados a una empresa específica
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
	CONCAT(pacientes.paciente, ' ', pacientes.apaterno, ' ', pacientes.amaterno) as paciente,  
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

// Ejecutar la consulta SQL y obtener los resultados
$result_agenda = ejecutar($sql_agenda);  
$cnt_agenda = mysqli_num_rows($result_agenda);

// Incluir el segundo archivo de encabezado (opcional, comentado)
// include($ruta.'header.php');
?>

<!-- Incluir estilos y scripts necesarios para la tabla y el calendario -->
<link href="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
<script src='<?php echo $ruta; ?>fullcalendar-6.1.7/dist/index.global.js'></script>

<script>
	document.addEventListener('DOMContentLoaded', function() {
	    var calendarEl = document.getElementById('calendar');
	    var calendar = new FullCalendar.Calendar(calendarEl, {
	    	// Configuración inicial del calendario
	      	initialDate: '<?php echo $hoy; ?>', // Fecha de inicio del calendario
	      	initialView: 'timeGridWeek', // Vista inicial por semana
	      	slotMinTime: '09:00:00', // Hora mínima para mostrar
    		slotMaxTime: '20:00:00', // Hora máxima para mostrar
	  		headerToolbar: {	
		        language: 'es', // Configurar el idioma a español
		        left: 'prev,next today', // Botones de navegación
		        center: 'title', // Mostrar título en el centro
		        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek' // Vistas disponibles
	      	},
			height: 'auto', // Ajustar la altura automáticamente
			navLinks: true, // Permitir clic en los días para cambiar de vista
			editable: false, // Deshabilitar la edición directa de eventos
			selectable: false, // Deshabilitar la selección de rangos
			selectMirror: false, 
			weekNumbers: true, // Mostrar el número de la semana
			nowIndicator: true, // Mostrar un indicador de la hora actual

			// Configuración del clic en un evento
	  	    eventClick: function(info) {
			    var id = 'id=' + info.event.id; // Obtener el ID del evento
				$('#contenido').html(''); // Limpiar el contenido actual
				$('#load').show(); // Mostrar el indicador de carga
				$('#modal').click(); // Abrir el modal

				// Solicitud AJAX para obtener los detalles del evento
				$.ajax({
	                url: 'evento.php',
	                type: 'POST',
	                data: id,
	                cache: false,
	                success:function(html){
	                    $('#contenido').html(html); // Mostrar el contenido en el modal
	                    $('#load').hide(); // Ocultar el indicador de carga
					}
				});
			},

			editable: true, // Permitir la edición (pero está deshabilitada arriba)
			dayMaxEvents: true, // Limitar la cantidad de eventos visibles por día
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

	    // Renderizar el calendario en la página
	    calendar.render();
	});
</script>

<!-- Estilos adicionales para la página del calendario -->
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
// Extraer variables POST y GET para su uso
$paciente_id = '';
extract($_POST);
extract($_GET);

// Incluir el segundo encabezado (opcional)
include($ruta.'header2.php'); 
?>

<!-- Contenido principal de la página -->
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>AGENDA</h2>  
        </div>
        <div style="min-width: 350px" class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div style="height: 95%" class="header">
                    	<h1 align="center">Agenda</h1>
				        <button style="display: none" type="button" id="modal" class="btn btn-default waves-effect m-r-20" data-toggle="modal" data-target="#largeModal">MODAL - LARGE SIZE</button>							
						<hr>
						
						<!-- Botón para agregar un evento si el usuario tiene permisos -->
						<?php if ($funcion == 'SISTEMAS' || $funcion == 'ADMINISTRADOR' || $funcion == 'TECNICO' || $funcion == 'RECEPCION') { ?>
						<button id="agendar" type="button" class="btn bg-<?php echo $body; ?>" data-dismiss="modal"><i class="material-icons">add_box</i> Agendar</button>
                        <script>
                            $('#agendar').click(function(){ 
                                $('#contenido').html(''); 
                                $('#load').show();
                                $('#modal').click(); 
                                var paciente_id = '<?php echo $paciente_id; ?>';

                                // Solicitud AJAX para agregar un nuevo evento
                				$.ajax({
					                url: 'add_evento.php',
					                type: 'POST',
					                data: 'paciente_id='+paciente_id,
					                cache: false,
					                success:function(html){
					                    $('#contenido').html(html);
					                    $('#load').hide(); 
									}
								});
                            });
                        </script>
                        <?php } ?> 								
						<hr>
						
						<!-- Div para mostrar el calendario -->
						<div id='calendar'></div>                                	

			            <!-- Modal para mostrar detalles de eventos -->
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

<?php	
// Incluir pie de página
include($ruta.'footer1.php');	
?>

<!-- Scripts adicionales para tablas y formularios -->
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

<?php	
// Incluir el segundo pie de página
include($ruta.'footer2.php');	
?>
