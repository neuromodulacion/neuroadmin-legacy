<?php
$ruta="../";
$titulo ="Solicitudes";
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


    $id = $_GET['id'];
    $sql = "SELECT * FROM solicitudes WHERE id=$id";
	$result_sql = ejecutar($sql);				
	$solicitud = mysqli_fetch_array($result_sql);
		

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
        <h2>Editar Solicitud</h2>
        <form action="guarda_edita.php" method="post">
            <input type="hidden" name="id" value="<?php echo $solicitud['id']; ?>">
            <div class="form-line">
                <label for="titulo">Título</label>
                <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo $solicitud['titulo']; ?>" disabled>
            </div>
            <div class="form-line">
                <label for="descripcion">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" disabled><?php echo $solicitud['descripcion']; ?></textarea>
            </div>
            <div class="form-line">
                <label for="tipo">Tipo</label>
                <select class="form-control" id="tipo" name="tipo" disabled>
                    <option value="Mejora" <?php if ($solicitud['tipo'] == 'Mejora') echo 'selected'; ?>>Mejora</option>
                    <option value="Falla" <?php if ($solicitud['tipo'] == 'Falla') echo 'selected'; ?>>Falla</option>
                </select>
            </div>
            <div class="form-line">
                <label for="prioridad">Prioridad</label>
                <select class="form-control" id="prioridad" name="prioridad">
                    <option value="Baja" <?php if ($solicitud['prioridad'] == 'Baja') echo 'selected'; ?>>Baja</option>
                    <option value="Media" <?php if ($solicitud['prioridad'] == 'Media') echo 'selected'; ?>>Media</option>
                    <option value="Alta" <?php if ($solicitud['prioridad'] == 'Alta') echo 'selected'; ?>>Alta</option>
                </select>
            </div>
            <div class="form-line">
                <label for="estado">Estado</label>
                <select class="form-control" id="estado" name="estado">
                    <option value="Pendiente" <?php if ($solicitud['estado'] == 'Pendiente') echo 'selected'; ?>>Pendiente</option>
                    <option value="En Proceso" <?php if ($solicitud['estado'] == 'En Proceso') echo 'selected'; ?>>En Proceso</option>
                    <option value="Resuelto" <?php if ($solicitud['estado'] == 'Resuelto') echo 'selected'; ?>>Resuelto</option>
                    <option value="Cancelado" <?php if ($solicitud['estado'] == 'Cancelado') echo 'selected'; ?>>Cancelado</option>
                </select>
            </div>
            <div class="form-line">
                <label for="descripcion">Observaciones de Cierre</label>
                <textarea class="form-control" id="observaciones_cierre" name="observaciones_cierre" rows="3" ><?php echo $solicitud['observaciones_cierre']; ?></textarea>
            </div>            
            <hr>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </form>
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