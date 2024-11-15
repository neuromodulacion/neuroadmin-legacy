<?php 
// Incluye funciones necesarias para el manejo de la base de datos y la API

include('../functions/funciones_mysql.php');
include('../api/funciones_api.php');

// Inicia la sesión del usuario
session_start();

// Establece el nivel de reporte de errores (7 es E_WARNING)
error_reporting(7);

// Configura la codificación interna como UTF-8
iconv_set_encoding('internal_encoding', 'utf-8');

// Establece la cabecera HTTP para que el contenido se interprete como HTML con codificación UTF-8
header('Content-Type: text/html; charset=UTF-8');

// Configura la zona horaria predeterminada para la aplicación
date_default_timezone_set('America/Mazatlan');

// Establece la configuración regional para el manejo de fechas y tiempos en español (España)
setlocale(LC_TIME, 'es_ES.UTF-8');

// Guarda el tiempo actual en la sesión
$_SESSION['time'] = mktime(); // Almacena la marca de tiempo actual

// Define la ruta base para las inclusiones de archivos
$ruta = "../";

// Extrae las variables de la sesión y las convierte en variables locales
extract($_SESSION);
//print_r($_SESSION);
// Genera un ticket basado en la marca de tiempo actual
$ticket = mktime();	 

// Extrae las variables enviadas por POST y las convierte en variables locales
extract($_POST);

// $paciente = "Cooper"; 
// $apaterno = "test";
// $amaterno = "test";
// $celular = "3333333333";
// $email = "sanzaleonardo@gmail.com";


// Validación y normalización del correo electrónico
if (empty($email) || $email == "admin@neuromodulaciongdl.com" || $email == "no@no.com") {
    // Asigna un correo por defecto si el campo email está vacío o tiene valores predefinidos
    $email = "remisiones_bind@neuromodulaciongdl.com";
} else {
    // Validar que no tenga espacios intermedios y convertir a minúsculas
    $email = strtolower(validarSinEspacios($email)); 
}

// Validación y normalización del número de celular
if (empty($celular)) {
    $celular = "";
} else {
    // Validar que no tenga espacios intermedios
    $celular = validarSinEspacios($celular);
}

// Consulta SQL para insertar un nuevo paciente en la base de datos
$insert = "
	INSERT IGNORE INTO paciente_consultorio 
	( 	
		paciente_consultorio.paciente, 
		paciente_consultorio.paciente_id,
		paciente_consultorio.apaterno, 
		paciente_consultorio.amaterno, 
		paciente_consultorio.celular, 
		paciente_consultorio.email, 
		paciente_consultorio.empresa_id,
		paciente_consultorio.medico
	)
	VALUES
	( 
		'$paciente',
		$paciente_id,
		'$apaterno',
		'$amaterno',
		'$celular',
		'$email',
		$empresa_id,
		'$medico'
	)";	
//echo $insert."<hr>";
// Ejecuta la consulta de inserción
ejecutar($insert);
//echo $paciente_cons_id."<hr>";
// Consulta SQL para obtener el último ID de paciente insertado en la tabla
$sqlx ="
	SELECT
	    MAX(paciente_consultorio.paciente_cons_id) as paciente_cons_id
	FROM
	    paciente_consultorio";
	
// Ejecuta la consulta y obtiene el resultado
$resultx = ejecutar($sqlx); 
$row = mysqli_fetch_array($resultx);
extract($row); // Extrae el ID del paciente consultado

// Verifica si la empresa tiene un ID específico (1 o 3)
if ($empresa_id == 1 || $empresa_id == 3) {
	
	// Llama a la función para agregar el cliente en el sistema de consultas externas
	$ID = agrega_cliente_bind_consulta($paciente_cons_id);	
	
	// Actualiza la tabla de pacientes con el ID de bind (sistema externo)
	$update ="
	UPDATE paciente_consultorio
	SET
		paciente_consultorio.id_bind = '$ID'
	WHERE
		paciente_consultorio.paciente_cons_id = $paciente_cons_id
	";
	// Ejecuta la consulta de actualización
	$result_update = ejecutar($update); 			
}

// Si el tipo de consulta es 'Consulta Medica', devuelve el ID del paciente
if($tipo_c === 'Consulta Medica'){
	echo $paciente_cons_id;
}else{	
	?>
		<!-- Muestra los datos del paciente en una fila de tabla -->
		<td><?php echo $paciente ; ?></td>
		<td><?php echo $apaterno ; ?></td>
		<td><?php echo $amaterno ; ?></td>
		<td><?php echo $celular ; ?></td>
		<td><?php echo $email ; ?></td>
		<td><?php echo $medico ; ?></td>
		<td>
			<!-- Botón para seleccionar al paciente -->
			<button type="button" id="selecciona_<?php echo $paciente_cons_id ; ?>" class="btn bg-purple waves-effect" data-toggle="modal" data-target="#Modal_busca">
				<i class="material-icons">check_circle</i> Selecciona
			</button>	

			<script>
				// Función que se ejecuta al hacer clic en el botón de selección del paciente
				$('#selecciona_<?php echo $paciente_cons_id ; ?>').click(function() {
					// Asigna los valores del paciente a las variables correspondientes
					var paciente = "<?php echo $paciente ; ?>";
					var apaterno = "<?php echo $apaterno ; ?>";
					var amaterno = "<?php echo $amaterno ; ?>";
					var celular = "<?php echo $celular ; ?>";
					var email = "<?php echo $email ; ?>";
					var tipo_c = $('#tipo_c').val();
				
					// Llena los campos del formulario con la información del paciente seleccionado
					$('#paciente_consulta').val(paciente+' '+apaterno+' '+amaterno);
					$('#paciente_consultax').val(paciente+' '+apaterno+' '+amaterno);				
					$('#email').val(email);
					$("#info_cliente").show(); // Muestra la información del cliente
					$("#info_busca").hide(); // Oculta la búsqueda del cliente
					
					// Llena otros campos relacionados
					$('#paciente_c').val(paciente);
					$('#apaterno').val(apaterno);
					$('#amaterno').val(amaterno);
					$('#celular').val(celular);
					$('#mail').val(email);			
				});
			</script>					
		</td>
	<?php } ?>

<?php /*
include('../functions/funciones_mysql.php');
include('../api/funciones_api.php');
session_start();
error_reporting(7);
iconv_set_encoding('internal_encoding', 'utf-8'); 
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');
$_SESSION['time']=mktime();

$ruta = "../";
extract($_SESSION);
//print_r($_SESSION);

$ticket = mktime();	 
// echo "<hr>";
extract($_POST);
//print_r($_POST);

$insert = "
	INSERT IGNORE INTO paciente_consultorio 
	( 	
		paciente_consultorio.paciente, 
		paciente_consultorio.paciente_id,
		paciente_consultorio.apaterno, 
		paciente_consultorio.amaterno, 
		paciente_consultorio.celular, 
		paciente_consultorio.email, 
		paciente_consultorio.empresa_id,
		paciente_consultorio.medico
	)
		values
	( 
		'$paciente',
		$paciente_id,
		'$apaterno',
		'$amaterno',
		'$celular',
		'$email',
		$empresa_id,
		'$medico'
	)";	
	
//echo $insert."<hr>";
$result_insert = ejecutar($insert);	

$sqlx ="
	SELECT
	    MAX(paciente_consultorio.paciente_cons_id) as paciente_cons_id
	FROM
	    paciente_consultorio";
	
	//echo $sqlx."<hr>";	
	$resultx =ejecutar($sqlx); 
	$row = mysqli_fetch_array($resultx);
	extract($row);

	if ($empresa_id == 1 || $empresa_id == 3) {
		
		$ID = agrega_cliente_bind_consulta($paciente_cons_id);	
		
		$update ="
		UPDATE paciente_consultorio
		SET
			paciente_consultorio.id_bind = '$ID'
		WHERE
			paciente_consultorio.paciente_cons_id = $paciente_cons_id
		";
		//echo $update."<br>";
		$result_update=ejecutar($update); 			
	}
	
	
	if($tipo_c === 'Consulta Medica'){
		echo $paciente_cons_id;
	}else{	
	?>
		<td><?php echo $paciente ; ?></td>
		<td><?php echo $apaterno ; ?></td>
		<td><?php echo $amaterno ; ?></td>
		<td><?php echo $celular ; ?></td>
		<td><?php echo $email ; ?></td>
		<td><?php echo $medico ; ?></td>
		<td>
			<button type="button" id="selecciona_<?php echo $paciente_cons_id ; ?>" class="btn bg-purple waves-effect" data-toggle="modal" data-target="#Modal_busca">
				<i class="material-icons">check_circle</i> Selecciona
			</button>	
<!-- data-toggle="modal" data-target="#Modal_busca" -->
			<script>
				$('#selecciona_<?php echo $paciente_cons_id ; ?>').click(function() {
					//alert('Test');
					
					
					var paciente = "<?php echo $paciente ; ?>";
					var apaterno = "<?php echo $apaterno ; ?>";
					var amaterno = "<?php echo $amaterno ; ?>";
					var celular = "<?php echo $celular ; ?>";
					var email = "<?php echo $email ; ?>";
					var tipo_c = $('#tipo_c').val();
				
					$('#paciente_consulta').val(paciente+' '+apaterno+' '+amaterno);
					$('#paciente_consultax').val(paciente+' '+apaterno+' '+amaterno);				
					$('#email').val(email);
					$( "#info_cliente" ).show();
					$( "#info_busca" ).hide();		
					
					
					$('#paciente_c').val(paciente);
					$('#apaterno').val(apaterno);
					$('#amaterno').val(amaterno);
					$('#celular').val(celular);
					$('#mail').val(email);			
					


				});
			</script>					
		</td>
	<?php } ?>
