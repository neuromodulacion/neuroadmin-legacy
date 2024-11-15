<?php
// Incluir archivo de funciones MySQL necesarias para interactuar con la base de datos
include('../functions/funciones_mysql.php');

// Iniciar sesión y configurar opciones de error, codificación y zona horaria
session_start();
error_reporting(E_ALL);
ini_set('default_charset', 'UTF-8');
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Mazatlan');
setlocale(LC_TIME, 'es_ES.UTF-8');

$ruta = "../"; // Ruta base para incluir archivos y recursos

// Extraer variables de la sesión y del formulario POST
extract($_SESSION);
extract($_POST);

// Configurar variables de fecha y hora actuales
$hoy = date("Y-m-d");
$ahora = date("H:i:00"); 
$anio = date("Y");
$mes_ahora = date("m");
$mes = strftime("%B"); // Nombre del mes en español
$dia = date("N"); // Día de la semana (1-7, donde 1 es lunes)
$semana = date("W"); // Número de la semana del año

// Registrar la fecha y hora actuales para la creación del evento
$f_registro = date("Y-m-d");
$h_registro = date("H:i:s");

// Convertir horas de inicio y fin al formato correcto
$h_ini = date("H:i:s", strtotime($h_ini.":00"));
$h_fin = date("H:i:s", strtotime($h_fin.":00"));

// Obtener el array de días seleccionados desde el formulario
$dias_semana = $_POST['dias_semana']; // Ejemplo: Array ( [0] => 1 [1] => 2 [2] => 3 [3] => 4 [4] => 5 )			

// Convertir el array en una cadena para usarlo en la consulta SQL
$dias_semana_str = implode(',', $dias_semana);			
echo $dias_semana_str." dias_semana_str<hr>"; // Salida: "1,2,3,4,5"

// Ajustar la recurrencia si no se seleccionaron días para un evento diario
if ($dias_semana_str =='' && $recurrencia == 'diaria') {
	$recurrencia = "corrida";
}

echo "<h2>".$recurrencia."</h2>";

// Seleccionar la consulta SQL dependiendo de la recurrencia del evento
switch ($recurrencia) {
	case 'corrida':
		// Evento recurrente sin restricciones de días
		$sql ="
		SELECT
			fechas.id, 
		    fechas.fecha as f_ini, 
		    fechas.fecha as f_fin,
			fechas.semana, 
			fechas.dia
		FROM
			fechas
		WHERE
			fechas.fecha >='$f_ini'
		LIMIT $frecuencia";
		break;	
	
	case 'diaria':
		// Evento recurrente en días específicos de la semana
		$sql ="
		SELECT
			fechas.id, 
		    fechas.fecha as f_ini, 
		    fechas.fecha as f_fin, 
			fechas.semana, 
			fechas.dia
		FROM
			fechas
		WHERE
			fechas.fecha >='$f_ini'
			AND fechas.dia IN($dias_semana_str)
		LIMIT $frecuencia";
		break;
	
	case 'semanal':
		// Evento recurrente semanal en días específicos de la semana
		$sql ="
		SELECT
			fechas.id, 
		    fechas.fecha as f_ini, 
		    fechas.fecha as f_fin, 
			fechas.semana, 
			fechas.dia
		FROM
			fechas
		WHERE
			fechas.fecha >='$f_ini'
			AND fechas.dia IN($dias_semana_str)
		LIMIT $frecuencia";	
		break;

	case 'mensual':
		// Evento recurrente mensual en un día específico del mes
		$d_ini = date("d", strtotime($f_ini));
		$sql = "
		SELECT
		    fechas.id, 
		    fechas.fecha as f_ini, 
		    fechas.fecha as f_fin,
		    fechas.semana, 
		    fechas.dia
		FROM
		    fechas
		WHERE
		    EXTRACT(DAY FROM fechas.fecha) = $d_ini
		    AND fechas.fecha >= '$f_ini'
		ORDER BY
		    fechas.fecha
		LIMIT $frecuencia";
		break;
		
	default:
		// Caso por defecto: evento en un solo día
		$sql = "
		SELECT
		    fechas.id, 
		    fechas.fecha as f_ini, 
		    fechas.fecha as f_fin,
		    fechas.semana, 
		    fechas.dia
		FROM
		    fechas
		WHERE
		    fechas.fecha  = '$f_ini'
		ORDER BY
		    fechas.fecha
		LIMIT $frecuencia";		
		break;				
}

// Ejecutar la consulta seleccionada y procesar los resultados
$result = ejecutar($sql);
while($row = mysqli_fetch_array($result)){
    extract($row);	 
    
	// Insertar cada evento en la tabla de agenda, ignorando duplicados
    $insert ="
    INSERT IGNORE INTO agenda 
        (
            f_ini,
            f_fin,
            h_ini,
            h_fin,
            paciente_id,
            usuario_id,
            f_registro,
            h_registro,
            observ,
            empresa_id
        ) 
    VALUES
        (
            '$f_ini',
            '$f_fin',
            '$h_ini',
            '$h_fin',
            $paciente_id,
            $usuario_id,
            '$f_registro',
            '$h_registro',
            '$observ',
            $empresa_id
        ) ";
    // Ejecutar la consulta de inserción
    ejecutar($insert);
}

// Mostrar un mensaje de éxito y un botón para continuar
echo "
<div class='modal-footer'>
    <div class='form-group'> 
        <div class='col-sm-12'>
            <h1>Se agendó correctamente</h1>
            <a class='btn bg-$body waves-effect' href='agenda.php?paciente_id=$paciente_id'>
                 <b>Continuar</b>
            </a>
        </div>
    </div>
</div>";
?>
