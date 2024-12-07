<?php
// Configuración inicial del entorno

// Configurar el nivel de reporte de errores
error_reporting(7);

// Configurar la codificación interna a UTF-8
iconv_set_encoding('internal_encoding', 'utf-8'); 

// Establecer el encabezado del contenido como HTML con codificación UTF-8
header('Content-Type: text/html; charset=UTF-8');

// Configurar la zona horaria a Monterrey
date_default_timezone_set('America/Monterrey');

// Configurar la localización para fechas en español
setlocale(LC_TIME, 'es_ES.UTF-8');

// Obtener la marca de tiempo actual
$time = time();

// Ruta base para incluir archivos y recursos
$ruta = "../";

// Extraer variables del formulario GET para su uso en el script
extract($_GET);

// Obtener la fecha y hora actuales
$hoy = date("Y-m-d");
$ahora = date("H:i:00"); 
$anio = date("Y");
$mes_ahora = date("m");

// Título de la página
$titulo = "Alta Usuarios";

// Incluir el archivo de funciones MySQL para interactuar con la base de datos
include($ruta.'functions/funciones_mysql.php');

// Obtener los datos codificados de la URL
$datos_codificados = $_GET['datos'];

// Decodificar los datos
$datos_decodificados = base64_decode($datos_codificados);

// Separar los valores en un arreglo asociativo
$datos_array = [];
parse_str($datos_decodificados, $datos_array);

// Extraer los valores del arreglo
$uso = $datos_array['uso'];
$timex = $datos_array['time'];
$generador = $datos_array['generador'];
$vigencia = $datos_array['vigencia'];
$usuario_id = $datos_array['usuario_id'];
$empresa_id = $datos_array['empresa_id'];
$funcion = $datos_array['funcion'];

// Verificar si la invitación ha caducado comparando la fecha de hoy con la vigencia
$hoy = date('Y-m-d');     

// Consultar el estado de la invitación en la base de datos
$sql = "
SELECT
	invitaciones.estatus as estatus_liga, 
	invitaciones.uso
FROM
	invitaciones
WHERE
	time = $timex"; 

// Ejecutar la consulta SQL
$result_insert = ejecutar($sql);

// Obtener los resultados de la consulta
$row = mysqli_fetch_array($result_insert);
extract($row);

// Consultar información adicional de la empresa y administrador
$sql_protocolo = "
	SELECT
		admin.nombre,
		empresas.emp_nombre,
		empresas.body_principal,
		empresas.icono,
		empresas.logo,
		empresas.web,
		admin.sucursal_id 
	FROM
		admin
		INNER JOIN empresas ON admin.empresa_id = empresas.empresa_id 
	WHERE
		admin.usuario_id = $usuario_id";

// Ejecutar la consulta SQL
$result_protocolo = ejecutar($sql_protocolo);

// Obtener los resultados de la consulta
$row_protocolo = mysqli_fetch_array($result_protocolo);
extract($row_protocolo);

// Incluir el archivo de encabezado temporal para la página
include($ruta.'functions/header_temp.php');
?>

<!-- Inicio del contenido principal de la página -->
<div style="height: auto" class="header">
	<img src="<?php echo $ruta.$logo; ?>" alt="Descripción de la imagen" width="150" height="auto">
	<h1 align="center">Alta de Usuario</h1>
	<?php
	// Verificar si la invitación ha caducado o si ya ha sido usada en caso de ser de uso único
	if ($vigencia < $hoy || ($estatus_liga == 'usado' && $uso == 'unico')) {
	    echo "<h1>La invitación ha caducado.</h1>
	    <h3>Solicita una nueva invitación</h3>";
	} else {
	    echo "Invitación válida generada por: $nombre ";
	    // Si la invitación es válida, mostrar el formulario de alta de usuario
	?>
	    <div class="body">
	        <!-- Formulario para registrar un nuevo usuario -->
	        <form target="_blank" id="wizard_with_validation" method="POST" action="guarda_invitados.php"> 
	        	<input type="hidden" name="empresa_id" id="empresa_id" value="<?php echo $empresa_id; ?>"/>
	        	<input type="hidden" name="usuario_id" id="usuario_id" value="<?php echo $usuario_id; ?>"/>
	        	<input type="hidden" name="timex" id="time" value="<?php echo $timex; ?>"/> 
	        	<input type="hidden" name="uso" id="uso" value="<?php echo $uso; ?>"/>    
	        	<input type="hidden" name="sucursal_id" id="sucursal_id" value="<?php echo $sucursal_id; ?>"/>                        	
	            <!-- Campo para ingresar el nombre del nuevo usuario -->
	            <h3>NOMBRE DE <?php echo $funcion; ?></h3>
	            <fieldset>
	                <div class="form-group form-float">
	                    <div class="form-line">
	                        <input type="text" id="nombre" name="nombre" class="form-control" required>
	                        <label class="form-label">Nombre/s*</label>
	                    </div>
	                </div>
	                
	                <!-- Campo para ingresar el correo electrónico -->
	                <div class="form-group form-float">
	                    <div class="form-line">
	                        <input type="email" id="usuario" name="usuario" class="form-control" required>
	                        <label class="form-label">Correo Electronico*</label>
	                    </div>
	                </div>

	                <!-- Campo para ingresar el número de celular -->
	                <div class="form-group form-float">
	                    <div class="form-line">
	                        <input type="tel" id="celular" name="celular" class="form-control" required>
	                        <label max="10" class="form-label">Celular*</label>
	                    </div>
	                </div>

	                <!-- Selección del tipo de usuario (función) -->
	                <div class="form-group form-float">
	                	<select id="funcion" name="funcion" class="form-control show-tick">
						  <option selected value="<?php echo $funcion; ?>"><?php echo $funcion; ?></option>
						</select>
	                    <label class="form-label">Tipo de Usuario</label>               	
	                </div>	

	                <!-- Campo para ingresar la contraseña -->
					<div class="form-group form-float">
					    <div class="form-line">
					        <input type="password" id="password" name="password" class="form-control" required>
					        <label class="form-label">Contraseña*</label>
					    </div>
					</div>
					
					<!-- Campo para confirmar la contraseña -->
					<div class="form-group form-float">
					    <div class="form-line">
					        <input type="password" id="password_c" name="password_c" class="form-control" required>
					        <label class="form-label">Confirmación*</label>
					    </div>
					</div>
					
					<!-- Div para mostrar el mensaje de validación de coincidencia de contraseñas -->
					<div id="password-match-message"></div><br>
					
					<!-- Botón para guardar el formulario, deshabilitado por defecto -->
					<div class="row clearfix demo-button-sizes">
					    <div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
					        <button type="submit" id="guardar-btn" class="btn bg-green btn-block btn-lg waves-effect" disabled>GUARDAR</button>
					    </div>
					</div>
	
					<!-- Script para verificar si las contraseñas coinciden -->
					<script>
					$(document).ready(function() {
					    // Obtener los elementos de los campos de contraseña
					    var passwordField = $("#password");
					    var confirmPasswordField = $("#password_c");
					    var passwordMatchMessage = $("#password-match-message");
					    var guardarBtn = $("#guardar-btn");
					
					    // Función para verificar si las contraseñas coinciden
					    function checkPasswordMatch() {
					        var password = passwordField.val();
					        var confirmPassword = confirmPasswordField.val();
					
					        if (password === confirmPassword) {
					            passwordMatchMessage.text("Las contraseñas coinciden.").css("color", "green");
					            guardarBtn.prop("disabled", false);
					        } else {
					            passwordMatchMessage.text("Las contraseñas no coinciden.").css("color", "red");
					            guardarBtn.prop("disabled", true);
					        }
					    }
					
					    // Llamar a la función de verificación cuando se escriba en los campos de contraseña
					    passwordField.on("input", checkPasswordMatch);
					    confirmPasswordField.on("input", checkPasswordMatch);
					});
					</script>
	            </fieldset>
	        </form>                       	
	    </div>
	    <?php									
		}                        	                     	
		?>					                
	</div>
	
	<!-- Sección de carga mientras se procesa la solicitud -->
	<div style="display: none" align="center" id="load">
	<div class="preloader pl-size-xl">
	    <div class="spinner-layer">
	       <div class="spinner-layer pl-teal">
	            <div class="circle-clipper left">
	                <div class="circle"></div>
	            </div>
	            <div class="circle-clipper right">
	                <div class="circle"></div>
	            </div>
	        </div>
	    </div>
	</div>
	<h3>Cargando...</h3>			                        	
	</div>

	<!-- Divs para mostrar contenido adicional si es necesario -->
	<div align="left" id="contenido"></div>
	<div align="left" id="contenido2"></div>

<!-- Fin del contenido principal -->
<?php	
// Incluir el archivo de pie de página temporal para la página
include($ruta.'functions/footer_temp.php');	    
