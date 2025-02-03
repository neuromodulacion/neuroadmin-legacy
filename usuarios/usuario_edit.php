<?php
// Ruta base para incluir archivos
$ruta="../";

// Título de la página
$titulo = "Modificación de Médico o Usuario";

// Incluir el primer header de la página
include($ruta.'header1.php');
?>

<!-- Enlaces a archivos CSS necesarios para plugins -->
<link href="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
<link href="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />
<link href="<?php echo $ruta; ?>plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
<link href="<?php echo $ruta; ?>plugins/waitme/waitMe.css" rel="stylesheet" />
<link href="<?php echo $ruta; ?>plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

<?php
// Incluir el segundo header de la página, que contiene el menú de navegación y otros elementos
include($ruta.'header2.php'); 

// Consulta SQL para obtener datos del usuario a modificar
$sql = "
SELECT
    admin.usuario_id as usuario_idx, 
    admin.pwd as pwdx,
    admin.nombre, 
    admin.usuario, 
    admin.telefono,
    admin.funcion as funcionx,
		(SELECT cedula from cedulas WHERE admin.usuario_id = cedulas.usuario_id and cedulas.principal = 'si') as cedula_profesional 
FROM
    admin
WHERE
    admin.usuario_id = $usuario_idx";

// Ejecutar la consulta
$result = ejecutar($sql); 
$row = mysqli_fetch_array($result); // Obtener los datos del usuario
extract($row); // Extraer los datos obtenidos para usarlos directamente

// Limpiar espacios en los valores de teléfono y usuario
$telefono = validarSinEspacio($telefono);
$usuario = validarSinEspacio($usuario);
?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>ALTA DE USUARIOS</h2>
        </div>
        
        <!-- Contenido principal de la sección de alta de usuarios -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div style="height: 95%" class="header">
                        <h1 align="center">Alta de Médico o Usuario</h1>
                        <div class="body">
                            <!-- Formulario de modificación de usuario -->
                            <form id="wizard_with_validation" method="POST" action="actualiza_alta.php">                            	
                               <input type="hidden" id="usuario_idx" name="usuario_idx" value="<?php echo $usuario_idx; ?>" />
                               <h3>Nombre del Médico</h3>
                                <fieldset>
                                    <!-- Campo de Nombre -->
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" class="form-control" required>
                                            <label class="form-label">Nombre/s*</label>
                                        </div>
                                    </div>

                                    <!-- Campo de Correo Electrónico -->
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="email" id="usuario" name="usuario" class="form-control" value="<?php echo $usuario; ?>" required>
                                            <label class="form-label">Correo Electrónico*</label>
                                        </div>
                                    </div>

                                    <!-- Campo de Teléfono -->
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="tel" id="telefono" name="telefono" class="form-control" value="<?php echo $telefono; ?>" required>
                                            <label max="10" class="form-label">Celular*</label>
                                        </div>
                                    </div>

                                   <!-- Campo de Cedula Profesional -->
                                   <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="tel" id="cedula" name="cedula" class="form-control" value="<?php echo $cedula_profesional; ?>" required>
                                            <label max="10" class="form-label">Cedula Profesional</label>
                                        </div>
                                    </div>
                                    
                                    <!-- Campo de Tipo de Usuario (función) -->
                                    <div class="form-group form-float">
                                        <?php if ($funcion == 'TECNICO') { ?>
                                            <input type="hidden" id="funcionx" name="funcionx" value="<?php echo $funcionx; ?>">
                                        <?php } ?>
                                        
                                        <select id="funcionx" name="funcionx" class="form-control show-tick" >
                                            <?php // if ($funcion != 'ADMINISTRADOR' && $funcion != 'COORDINADOR ADMIN') { echo 'disabled'; } ?>>

                                            <?php
                                            // Consulta para obtener las opciones de funciones de usuario
                                            $sql_funciones = "
                                                SELECT
                                                    funciones.funcion as funciony 
                                                FROM
                                                    funciones 
                                                ORDER BY
                                                    1 ASC";
                                            $result_funciones = ejecutar($sql_funciones);
                                            
                                            while ($row_funciones = mysqli_fetch_array($result_funciones)) {
                                                extract($row_funciones); ?>
                                                
                                                <!-- Mostrar las opciones de función en el menú desplegable -->
                                                <option <?php if ($funcionx == $funciony) { echo "selected"; } ?> value="<?php echo $funciony; ?>">
                                                    <?php echo $funciony; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                        <label class="form-label">Tipo de Usuario</label>               	
                                    </div>

                                    <!-- Campo de Contraseña, visible solo para ciertos roles -->
                                    <?php if ($funcion == "SISTEMAS" || $funcion == 'COORDINADOR' || $funcion == 'ADMINISTRADOR') { ?>
                                        <div>
                                            <div class="form-line">
                                                <label max="10" class="form-label">Contraseña</label>
                                                <input type="tel" id="pwdx" name="pwdx" class="form-control" value="<?php echo $pwdx; ?>" disabled>
                                            </div>		                                	
                                        </div>	
                                    <?php } ?>                                    	                                    
                                </fieldset>
                                
                                <hr>

                                <!-- Botón para guardar los cambios -->
                                <div class="row clearfix demo-button-sizes">
                                    <div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
                                        <button type="submit" class="btn bg-green btn-block btn-lg waves-effect">GUARDAR</button>
                                    </div>
                                </div>                                     
                            </form>                       	
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include($ruta.'footer1.php'); ?>

<!-- Plugins JS necesarios para funcionalidad adicional -->
<script src="<?php echo $ruta; ?>plugins/momentjs/moment.js"></script>
<script src="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
<script src="<?php echo $ruta; ?>plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo $ruta; ?>plugins/autosize/autosize.js"></script>
<script src="<?php echo $ruta; ?>plugins/momentjs/moment.js"></script>

<?php include($ruta.'footer2.php'); ?>
