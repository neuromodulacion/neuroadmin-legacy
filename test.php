<?php
// Definir la ruta base para las inclusiones de archivos
$ruta = "../";

// Obtener la fecha actual en formato "YYYY-MM-DD"
$hoy = date("Y-m-d");

// Obtener la hora actual en formato "HH:MM:00"
$ahora = date("H:i:00"); 

// Obtener el año actual
$anio = date("Y");

// Obtener el mes actual en formato numérico "MM"
$mes_ahora = date("m");

// Definir el título de la página
$titulo = "Datos Medico";

// Incluir la primera parte del header que contiene configuraciones iniciales
include($ruta.'header1.php');

// Incluir archivos CSS adicionales necesarios para el funcionamiento de la página
?>
    <!-- Estilos para la tabla de datos de JQuery DataTable -->
    <link href="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
    
    <!-- Estilos para el selector de fecha y hora con Bootstrap Material -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

    <!-- Estilos para el selector de fecha de Bootstrap -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />

    <!-- Estilos para el plugin "Wait Me" que muestra un indicador de carga -->
    <link href="<?php echo $ruta; ?>plugins/waitme/waitMe.css" rel="stylesheet" />

    <!-- Estilos para el select de Bootstrap -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />   

<?php  
// Incluir la segunda parte del header que contiene la barra de navegación y el menú
include($ruta.'header2.php'); 

    $sql_medico = "
        SELECT
            admin.usuario_id as usuario_idx,
            admin.nombre as nombrex,
            admin.usuario as usuariox,
            admin.funcion as funcionx,
            admin.observaciones,
            admin.organizacion,
            admin.estatus as estatusx,
            admin.telefono,
            (SELECT COUNT(*) FROM pacientes WHERE pacientes.usuario_id = admin.usuario_id) as pacientes
        FROM
            admin 
        WHERE
            admin.empresa_id = $empresa_id
            AND (admin.funcion = 'MEDICO' OR usuario_id = 11)
    ";
    $result_medico = ejecutar($sql_medico);  // Ejecutar la consulta SQL
    $row_medico = mysqli_fetch_array($result_medico);
    extract($row_medico);

?>

    <!-- Inicio del contenido principal de la página -->
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>DATOS MEDICO</h2>
            </div>
			<!-- Contenido principal de la página -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <!-- Encabezado de la tarjeta que muestra el nombre de la empresa -->
                        <div style="height: 95%" class="header">
                        	<?php print_r($_GET); ?>
<form id="wizard_with_validation" method="POST" action="actualiza_alta.php" >                            	
	                               <input type="hidden" id="usuario_idx" name="usuario_idx" value="<?php echo $usuario_idx; ?>" />
	                               <h3>Nombre del Medico</h3>
	                                <fieldset>
	                                    <div class="form-group form-float">
	                                        <div class="form-line">
	                                            <input type="text" id="nombre" name="nombre" value="<?php echo $nombrex; 
	                                            
	                                           // print_r($_SESSION);
	                                            ?>" class="form-control" required>
	                                            <label class="form-label">Nombre/s*</label>
	                                        </div>
	                                    </div>
	                                    <div class="form-group form-float">
	                                        <div class="form-line">
	                                            <input type="email" id="usuario"  name="usuario" class="form-control" value="<?php echo $usuariox; ?>" required>
	                                            <label class="form-label">Correo Electronico*</label>
	                                        </div>
	                                    </div>
	                                    <div class="form-group form-float">
	                                        <div class="form-line">
	                                            <input type="tel" id="telefono" name="telefono" class="form-control" value="<?php echo $telefonox; ?>" required>
	                                            <label max="10" class="form-label">Celular*</label>
	                                        </div>
	                                    </div> 
		                                <div class="form-group form-float">
		                                	<div class="form-line">
												<label class="form-label">Observaciones</label>
												<textarea id="observaciones" name="observaciones" class="form-control" ><?php echo $observaciones; ?></textarea>
											</div>		                                                   	
		                                </div>
	                                    <div class="form-group form-float">
	                                        <div class="form-line">
	                                            <input type="text" id="organizacion" name="organizacion" class="form-control" value="<?php echo $organizacion; ?>" required>
	                                            <label max="10" class="form-label">Organización</label>
	                                        </div>
	                                    </div> 		
	                                    <div class="form-group form-float">
	                                        <div class="form-line">	   
	                                        	<label class="form-label">Estatus <?php echo $estatusx; ?></label><br>                                 
                                            	<select id="estatus<?php echo $usuario_idx; ?>" name="estatus<?php echo $usuario_idx; ?>" class="form-control show-tick">
												  <option <?php if($estatusx == 'Activo'){ echo "selected";} ?>  value="Activo" >Activo</option>
												  <option <?php if($estatusx == 'Pendiente'){ echo "selected";} ?>  value="Pendiente" >Pendiente</option>
												  <option <?php if($estatusx == 'Inactivo'){ echo "selected";} ?>  value="Inactivo" >Inactivo</option>
												  <option <?php if($estatusx == 'Bloqueado'){ echo "selected";} ?>  value="Bloqueado" >Bloqueado</option>
												</select>	                                    
	                                        </div>
	                                    </div> 		                                    
	                                                                                                        	                                    
                                    </fieldset>
	                                <hr>                               
	                                <div class="row clearfix demo-button-sizes">
	                                	<div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
	                                		<button type="submit" class="btn bg-green btn-block btn-lg waves-effect">GUARDAR</button>
	                            		</div>
	                        		</div>                                     
                                </form>   

                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-xs-12 ol-sm-12 col-md-12 col-lg-12">
                                    <div class="panel-group" id="accordion_17" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-col-pink">
                                            <div class="panel-heading" role="tab" id="headingOne_17">
                                                <h4 class="panel-title">
                                                    <a role="button" data-toggle="collapse" data-parent="#accordion_17" href="#collapseOne_17" aria-expanded="true" aria-controls="collapseOne_17">
                                                        <i class="material-icons">account_circle</i> Pacientes
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseOne_17" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne_17">
                                                <div class="panel-body">
                                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute,
                                                    non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum
                                                    eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid
                                                    single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh
                                                    helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                                                    Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table,
                                                    raw denim aesthetic synth nesciunt you probably haven't heard of them
                                                    accusamus labore sustainable VHS.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-col-cyan">
                                            <div class="panel-heading" role="tab" id="headingTwo_17">
                                                <h4 class="panel-title">
                                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_17" href="#collapseTwo_17" aria-expanded="false"
                                                       aria-controls="collapseTwo_17">
                                                        <i class="material-icons">place</i> Visitas
                                                        
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseTwo_17" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo_17">
                                                <div class="panel-body">
                                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute,
                                                    non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum
                                                    eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid
                                                    single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh
                                                    helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                                                    Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table,
                                                    raw denim aesthetic synth nesciunt you probably haven't heard of them
                                                    accusamus labore sustainable VHS.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-col-teal">
                                            <div class="panel-heading" role="tab" id="headingThree_17">
                                                <h4 class="panel-title">
                                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_17" href="#collapseThree_17" aria-expanded="false"
                                                       aria-controls="collapseThree_17">
                                                        <i class="material-icons">folder_shared</i> Cortecias
                                                        
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseThree_17" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree_17">
                                                <div class="panel-body">
                                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute,
                                                    non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum
                                                    eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid
                                                    single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh
                                                    helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                                                    Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table,
                                                    raw denim aesthetic synth nesciunt you probably haven't heard of them
                                                    accusamus labore sustainable VHS.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-col-orange">
                                            <div class="panel-heading" role="tab" id="headingFour_17">
                                                <h4 class="panel-title">
                                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_17" href="#collapseFour_17" aria-expanded="false"
                                                       aria-controls="collapseFour_17">
                                                        <i class="material-icons">person_pin</i> Ubicación de Medico
                                                        #4
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseFour_17" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour_17">
                                                <div class="panel-body">
                                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute,
                                                    non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum
                                                    eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid
                                                    single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh
                                                    helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                                                    Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table,
                                                    raw denim aesthetic synth nesciunt you probably haven't heard of them
                                                    accusamus labore sustainable VHS.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                                                	
						<!-- Contenido de la pagina -->
			                
                    	</div>
                	</div>
            	</div>
        	</div>
        </div>
    </section>
<?php 
// Incluir la primera parte del footer que contiene scripts y configuraciones iniciales del pie de página
include($ruta.'footer1.php'); 
?>

    <!-- Scripts adicionales necesarios para la funcionalidad de la página -->

    <!-- Plugin Moment para manejar fechas y horas --> 
    <script src="<?php echo $ruta; ?>plugins/momentjs/moment.js"></script>

    <!-- Plugin para el selector de fecha y hora con Bootstrap Material -->
    <script src="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

    <!-- Plugin para el selector de fecha de Bootstrap -->
    <script src="<?php echo $ruta; ?>plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

    <!-- Plugin para efecto de ondas en los botones -->
    <script src="<?php echo $ruta; ?>plugins/node-waves/waves.js"></script>

    <!-- Plugin Autosize para ajustar automáticamente el tamaño de los campos de texto -->
    <script src="<?php echo $ruta; ?>plugins/autosize/autosize.js"></script>

    <!-- Repetición del plugin Moment para garantizar su disponibilidad -->
    <script src="<?php echo $ruta; ?>plugins/momentjs/moment.js"></script>

<?php 
// Incluir la segunda parte del footer que finaliza la estructura del pie de página
include($ruta.'footer2.php'); 
?>
