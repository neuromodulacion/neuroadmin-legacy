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
//print_r($_SESSION);
$hoy = date("Y-m-d");
$ahora = date("H:i:00"); 
$anio = date("Y");
$mes_ahora = date("m");
$titulo ="Menú TMS";
include($ruta.'header1.php');
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
    

      
<?php
include($ruta.'header2.php'); 

//print_r($_SESSION);
?>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>INICIO</h2>
                <!-- <?php echo $ubicacion_url; 
                echo "<br> $ruta.'/proyecto_medico/menu.php'"?> -->
            </div>
<!-- // ************** Contenido ************** // -->
            <!-- CKEditor -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div style="height: 95%"  class="header">
                        	<h1 align="center"><?php echo $emp_nombre; ?></h1>
                        	
<div class="body">
<?php
$sql = "
SELECT
	solicitudes.*,
	admin.nombre 
FROM
	solicitudes
	INNER JOIN admin ON solicitudes.usuario_id = admin.usuario_id 
WHERE estado <> 'Resuelto'
ORDER BY
	solicitudes.prioridad DESC,
	solicitudes.fecha_creacion ASC"; 
		$result_sql = ejecutar($sql);				

	$num_rows = mysqli_num_rows($result_sql);

?>	
        <h2>Solicitudes Pendientes</h2><hr>
        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Tipo</th>
                    <th>Prioridad</th>
                    <th>Solicito</th>
                    <th>Estado</th>
                    <th>Fecha de Creación</th>
                    
                    <th>Acciones</th>
                </tr>
            </thead> 
            <tbody >
                <?php
                if ($num_rows > 0) {
                    while($row = mysqli_fetch_array($result_sql)) {
                    	extract($row);
                    	
                    	if ($funcion == 'SISTEMAS') {
							$disabled = '';
						} else {
							$disabled = 'style="display: none"';
						}
						
                    	
                    	switch ($estado) {
							case 'Resuelto':
								$class = 'class="success"';
								break;
							
							case 'Pendiente':
								$class = 'class="warning"';
								break;
							
							case 'En Proceso':
								$class = 'class="danger"';
								break;
														
						}
						
                        echo "<tr>
                                <td>$id</td>
                                <td>{$row['titulo']}</td>
                                <td>{$row['descripcion']}</td>
                                <td>{$row['tipo']}</td>
                                <td>{$row['prioridad']}</td>
                                <td $class>{$row['estado']}</td>
                                <td>{$row['nombre']}</td>
                                <td>{$row['fecha_creacion']}</td>
                                <td>
                                    <a href='editar_solicitud.php?id={$row['id']}' class='btn btn-primary btn-sm' $disabled>Editar</a>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No hay solicitudes</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <hr>
<?php
$sql = "
SELECT
	solicitudes.*,
	admin.nombre 
FROM
	solicitudes
	INNER JOIN admin ON solicitudes.usuario_id = admin.usuario_id 
WHERE estado = 'Resuelto'
ORDER BY
	solicitudes.prioridad DESC,
	solicitudes.fecha_creacion ASC"; 
		$result_sql = ejecutar($sql);				

	$num_rows = mysqli_num_rows($result_sql);

?>	
        <h2>Solicitudes Resueltas</h2><hr>
        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Tipo</th>
                    <th>Prioridad</th>
                    <th>Observaciones</th>
                    <th>Fecha de Cierre</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($num_rows > 0) {
                    while($row = mysqli_fetch_array($result_sql)) {
                    	extract($row);
                    	
                    	switch ($estado) {
							case 'Resuelto':
								$class = 'class="success"';
								break;
							
							case 'Pendiente':
								$class = 'class="warning"';
								break;
							
							case 'En Proceso':
								$class = 'class="danger"';
								break;
														
						}
						
                        echo "<tr>
                                <td>$id</td>
                                <td>{$row['titulo']}</td>
                                <td>{$row['descripcion']}</td>
                                <td>{$row['tipo']}<br>{$row['prioridad']}</td>
                                <td $class>{$row['estado']}</td>
                                <td>{$row['observaciones_cierre']}</td>
                                <td>{$row['fecha_cierre']}</td>

                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No hay solicitudes</td></tr>";
                }
                ?>
            </tbody>
        </table>        
        
    </div>                        	
                        	
                        	
                    	</div>
                	</div>
            	</div>
        	</div>           
        </div>
    </section>
<?php	include($ruta.'footer1.php');	?>

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

<?php	include($ruta.'footer2.php');	?>