<?php
error_reporting(7);
iconv_set_encoding('internal_encoding', 'utf-8'); 
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Mazatlan');
setlocale(LC_TIME, 'es_ES.UTF-8');



function ejecutar($sql) {
    $mysqli = new mysqli("174.136.25.64", "lamanad1_conexion", "7)8S!K{%NBoL", "lamanad1_medico");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        exit();
    }
    $resultado = $mysqli->query($sql);
    $mysqli->close();
    return $resultado;
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mysqli = new mysqli("174.136.25.64", "lamanad1_conexion", "7)8S!K{%NBoL", "lamanad1_medico");
    if ($mysqli->connect_errno) {
        $message = "Falló la conexión con MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    } else {
        $nombre_completo = $mysqli->real_escape_string($_POST['nombre_completo']);
        $especialidad = $mysqli->real_escape_string($_POST['especialidad']);
        $otra_especialidad = isset($_POST['otra_especialidad']) ? $mysqli->real_escape_string($_POST['otra_especialidad']) : null;
        $experiencia_clinica = intval($_POST['experiencia_clinica']);
        $trd = intval($_POST['trd']);
        $pacientes_trd_mes = $mysqli->real_escape_string($_POST['pacientes_trd_mes']);
        $conocimiento_neuromodulacion = intval($_POST['conocimiento_neuromodulacion']);
        $claridad_presentaciones = intval($_POST['claridad_presentaciones']);
        $temas_relevantes = intval($_POST['temas_relevantes']);
        $tema_profundo = isset($_POST['tema_profundo']) ? $mysqli->real_escape_string($_POST['tema_profundo']) : null;
        $utilidad_rtms = intval($_POST['utilidad_rtms']);
        $utilidad_tdcs = intval($_POST['utilidad_tdcs']);
        $mas_demostraciones = intval($_POST['mas_demostraciones']);
        $organizacion_general = intval($_POST['organizacion_general']);
        $viabilidad_servicios = $mysqli->real_escape_string($_POST['viabilidad_servicios']);
        $prescripcion_plataforma = $mysqli->real_escape_string($_POST['prescripcion_plataforma']);
        $comentarios = isset($_POST['comentarios']) ? $mysqli->real_escape_string($_POST['comentarios']) : null;
        $mejoras = isset($_POST['mejoras']) ? $mysqli->real_escape_string($_POST['mejoras']) : null;
        $sugerencias = isset($_POST['sugerencias']) ? $mysqli->real_escape_string($_POST['sugerencias']) : null;
        $celular = $mysqli->real_escape_string($_POST['celular']);
        $correo_electronico = $mysqli->real_escape_string($_POST['correo_electronico']);
        $calidad_contenidos = intval($_POST['calidad_contenidos']);
        $duracion_seminario = intval($_POST['duracion_seminario']);
        $servicio_alimentos = intval($_POST['servicio_alimentos']);
        $dinamica_tecnicas = intval($_POST['dinamica_tecnicas']);
		$id = intval($_POST['id']);

       $sql = "
       INSERT INTO encuesta_satisfaccion 
            (nombre_completo, especialidad, otra_especialidad, experiencia_clinica, trd, pacientes_trd_mes, 
            conocimiento_neuromodulacion, claridad_presentaciones, temas_relevantes, tema_profundo, 
            utilidad_rtms, utilidad_tdcs, mas_demostraciones, organizacion_general, viabilidad_servicios, 
            prescripcion_plataforma, comentarios, mejoras, sugerencias, celular, correo_electronico,
            calidad_contenidos, duracion_seminario, servicio_alimentos, dinamica_tecnicas) 
        VALUES 
            ('$nombre_completo', '$especialidad', '$otra_especialidad', $experiencia_clinica, $trd, 
            '$pacientes_trd_mes', $conocimiento_neuromodulacion, $claridad_presentaciones, $temas_relevantes, 
            '$tema_profundo', $utilidad_rtms, $utilidad_tdcs, $mas_demostraciones, $organizacion_general, 
            '$viabilidad_servicios', '$prescripcion_plataforma', '$comentarios', '$mejoras', '$sugerencias', '$celular', 
            '$correo_electronico', $calidad_contenidos, $duracion_seminario, $servicio_alimentos, $dinamica_tecnicas)";


        if (ejecutar($sql)) {
            $message = "Encuesta enviada exitosamente. ¡Gracias por tu participación!";
        } else {
            $message = "Error al enviar la encuesta. Por favor, intenta nuevamente.";
        }

        // Redirigir para evitar el reenvío del formulario
        header("Location: resultado.php?id=".$id."&message=" . urlencode($message));
        exit();
    }
} else {
    $message = "Método de solicitud no permitido.";
    header("Location: resultado.php?.?id=".$id."&message=" . urlencode($message));
    exit();
}
?>
