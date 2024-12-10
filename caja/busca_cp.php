<?php
// Incluye el archivo con funciones generales de MySQL
include('../functions/funciones_mysql.php');

session_start();

// Establecer el nivel de notificación de errores
error_reporting(E_ALL); // Reemplaza `7` por `E_ALL` para usar la constante más clara y recomendada

// Establecer la codificación interna a UTF-8 (ya no se utiliza `iconv_set_encoding`, sino `ini_set`)
ini_set('default_charset', 'UTF-8');

// Configurar la cabecera HTTP con codificación UTF-8
header('Content-Type: text/html; charset=UTF-8');

// Configurar la zona horaria
date_default_timezone_set('America/Monterrey');

// Configurar la localización para manejar fechas y horas en español
setlocale(LC_TIME, 'es_ES.UTF-8');

// Asignar el tiempo actual a la sesión en formato de timestamp
$_SESSION['time'] = time(); // `time()` es el equivalente moderno a `mktime()`

// Define la ruta base para las inclusiones de archivos
$ruta = "../";

// Extrae las variables de la sesión y las convierte en variables locales
extract($_SESSION);

// Genera un ticket basado en la marca de tiempo actual
$ticket = time();	 

// Extrae las variables enviadas por POST y las convierte en variables locales
extract($_POST);

// Consulta SQL para obtener la información relacionada con el código postal ingresado
$sqlx ="
SELECT
	CPdescarga.d_codigo,
	CPdescarga.D_mnpio,
	CPdescarga.d_estado as cEstado,
	CPdescarga.d_ciudad as cCiudad 
FROM
	CPdescarga 
WHERE
	CPdescarga.d_codigo = '$cCodigoPostal'";
	
// Ejecuta la consulta SQL y obtiene los resultados
$resultx = ejecutar($sqlx); 
$row = mysqli_fetch_array($resultx);
extract($row); // Extrae los resultados de la consulta para usarlos más adelante
?>

<!-- Etiqueta y campo para seleccionar la colonia -->
<label class="form-label">Colonia</label>
<div class="form-group form-float">
    <select class='form-control show-tick' id="cColonia" name="cColonia">
        <option value="">-- Selecciona la Colonia--</option>
		<?php
		// Consulta SQL para obtener todas las colonias asociadas al código postal ingresado
		$sql_table ="
		SELECT
			CPdescarga.d_asenta 
		FROM
			CPdescarga 
		WHERE
			CPdescarga.d_codigo = '$cCodigoPostal'"; 
		
		// Ejecuta la consulta SQL y muestra los resultados en el campo select
		$result_sem2 = ejecutar($sql_table); 
		while($row_sem2 = mysqli_fetch_array($result_sem2)){
		    extract($row_sem2);		
		?>
    	<option value="<?php echo $d_asenta; ?>"><?php echo $d_asenta; ?></option>
		<?php } ?>        
    </select>                	
</div>

<!-- Etiqueta y campo para mostrar la ciudad -->
<label class="form-label">Ciudad</label>
<div class="form-group form-float">
    <div class="form-line">
        <input type="text" id="cCiudad" name="cCiudad" class="form-control" placeholder="Ciudad" required value="<?php echo htmlspecialchars($cCiudad); ?>">
    </div>
</div>

<!-- Etiqueta y campo para mostrar el estado -->
<label class="form-label">Estado</label>
<div class="form-group form-float">
    <div class="form-line">
        <input type="text" id="cEstado" name="cEstado" class="form-control" placeholder="Estado" required value="<?php echo htmlspecialchars($cEstado); ?>">
    </div>
</div>

<!-- Etiqueta y campo para mostrar el país (prellenado con "México") -->
<label class="form-label">País</label>
<div class="form-group form-float">
    <div class="form-line">
        <input type="text" id="cPais" name="cPais" class="form-control" placeholder="País" required value="México">
    </div>
</div>
