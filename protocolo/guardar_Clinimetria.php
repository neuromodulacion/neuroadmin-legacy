<?php
include('../functions/funciones_mysql.php');
include('fun_protocolo.php');

print_r($_POST);

// Obtener datos del formulario
$tituloEncuesta = $_POST['encuesta'];
$descripcionEncuesta = $_POST['descripcion'];
$preguntas = $_POST['preguntas'];

// Escapar caracteres especiales para evitar inyección SQL
$tituloEncuesta = addslashes($tituloEncuesta);
$descripcionEncuesta = addslashes($descripcionEncuesta);

// Insertar la encuesta en la base de datos
$sqlEncuesta = "INSERT INTO encuestas (encuesta, descripcion) VALUES ('$tituloEncuesta', '$descripcionEncuesta')";
$conexion = ejecutar_id($sqlEncuesta);
$encuestaId = $conexion->insert_id;

// Recorrer las preguntas y guardarlas en la base de datos
foreach ($preguntas as $index => $preguntaData) {
    $textoPregunta = addslashes($preguntaData['pregunta']);
    $tipoPregunta = $preguntaData['tipo'];
    $numeroPregunta = isset($preguntaData['numero']) ? $preguntaData['numero'] : NULL;

    // Inicializar variables para respuestas posibles
    $respuestasCampos = '';
    $respuestasValores = '';

    // Recorremos las respuestas y las asignamos a los campos correspondientes
    for ($i = 1; $i <= 10; $i++) {
        $respuestaTexto = isset($preguntaData['respuestas'][$i]['texto']) ? addslashes($preguntaData['respuestas'][$i]['texto']) : '';
        $respuestaCampo = "respuesta_$i";
        $respuestasCampos .= ", $respuestaCampo";
        $respuestasValores .= ", '$respuestaTexto'";
    }

    // Construir la consulta para insertar la pregunta
    $sqlPregunta = "INSERT INTO preguntas_encuestas (encuesta_id, numero, pregunta, tipo $respuestasCampos) VALUES ('$encuestaId', '$numeroPregunta', '$textoPregunta', '$tipoPregunta' $respuestasValores)";
    ejecutar($sqlPregunta);

    // Si el tipo de pregunta es 'radio', almacenamos las respuestas en la tabla 'respuestas'
    if ($tipoPregunta == 'radio') {
        foreach ($preguntaData['respuestas'] as $respuesta) {
            $textoRespuesta = isset($respuesta['texto']) ? addslashes($respuesta['texto']) : '';
            $valorRespuesta = isset($respuesta['valor']) ? $respuesta['valor'] : 0;

            // Validar que la respuesta tenga texto
            if (!empty($textoRespuesta)) {
                $sqlRespuesta = "INSERT INTO respuestas (respuesta, valor, encuesta_id) VALUES ('$textoRespuesta', '$valorRespuesta', '$encuestaId')";
                ejecutar($sqlRespuesta);
            }
        }
    }
}



$x = crea_new($encuestaId);

echo "<hr>".$x;

echo "Clinimetría guardada exitosamente.";
// header("Location: clinimetria.php"); // Descomenta esta línea si deseas redireccionar al formulario nuevamente
?>
