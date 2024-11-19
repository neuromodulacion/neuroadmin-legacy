<?php
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


include('fun_protocolo.php');

$ruta = "../";
extract($_SESSION);

$titulo_encuesta = $_POST['titulo_encuesta'];
$descripcion_encuesta = $_POST['descripcion_encuesta'];
$preguntas = $_POST['preguntas'];

// Insertar la encuesta y obtener el ID
$insertEncuestaSQL = "INSERT INTO encuestas (encuesta, descripcion) VALUES ('$titulo_encuesta', '$descripcion_encuesta')";
$mysqli = ejecutar_id($insertEncuestaSQL);
$encuesta_id = $mysqli->insert_id; // Obtener el ID de la encuesta recién insertada

// Insertar las preguntas y sus respuestas
foreach ($preguntas as $index => $preguntaData) {
    $preguntaTexto = $preguntaData['pregunta'];
    $tipoPregunta = $preguntaData['tipo'];
    
    // Insertar la pregunta y obtener el ID
    $insertPreguntaSQL = "INSERT INTO preguntas_encuestas (encuesta_id, numero, pregunta, tipo) VALUES ($encuesta_id, $index, '$preguntaTexto', '$tipoPregunta')";
    $mysqli = ejecutar_id($insertPreguntaSQL);
    $pregunta_id = $mysqli->insert_id; // Obtener el ID de la pregunta recién insertada

    // Insertar las respuestas
    foreach ($preguntaData['respuestas'] as $respuestaData) {
        if (!empty($respuestaData['texto'])) {
            $respuestaTexto = $respuestaData['texto'];
            $respuestaValor = $respuestaData['valor'];
            $insertRespuestaSQL = "INSERT INTO respuestas (respuesta, valor, encuesta_id) VALUES ('$respuestaTexto', $respuestaValor, $encuesta_id)";
            ejecutar_id($insertRespuestaSQL);
        }
    }
}

$x = crea_new($encuesta_id);

header("Location: clinimetria.php");
?>

