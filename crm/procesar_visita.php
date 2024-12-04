<?php
include('../functions/funciones_mysql.php'); // Incluir el archivo con la función ejecutar

// Inicia una nueva sesión o reanuda la existente
session_start();

// Configura la notificación de errores para mostrar todos los errores
error_reporting(E_ALL);

// Establece el conjunto de caracteres predeterminado como UTF-8
ini_set('default_charset', 'UTF-8');

// Configura la cabecera HTTP para que el contenido se interprete como HTML con codificación UTF-8
header('Content-Type: text/html; charset=UTF-8');

// Establece la zona horaria predeterminada para la aplicación
date_default_timezone_set('America/Monterrey');

// Establece la configuración regional para las funciones de tiempo a español (España) con codificación UTF-8
setlocale(LC_TIME, 'es_ES.UTF-8');
$usuario_id = $_SESSION['usuario_id'];
$empresa_id = $_SESSION['empresa_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir y limpiar datos del formulario
    $medico_id = $_POST['usuario_id'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $duracion = $_POST['duracion'];
    $objetivo = $_POST['objetivo'];
    $resultados = $_POST['resultados'];
    $observaciones = $_POST['observaciones'];
	$f_visita = $_POST['f_visita'];
	$p_visita = $_POST['p_visita'];

    // Construir la consulta SQL para insertar los datos
    $sql = "INSERT INTO registro_visitas (medico_id, fecha, hora, duracion, objetivo, resultados, observaciones,usuario_id,p_visita,f_visita,empresa_id) 
            VALUES ('$medico_id', '$fecha', '$hora', '$duracion', '$objetivo', '$resultados', '$observaciones',$usuario_id,'$p_visita','$f_visita',$empresa_id)";
echo $sql;
    // Ejecutar la consulta usando la función ejecutar
    $resultado = ejecutar($sql);

    // Verificar si la inserción fue exitosa
    if ($resultado) {
        echo "Registro de la visita guardado con éxito.";
    } else {
        echo "Hubo un error al guardar los datos de la visita.";
    }
}
?>