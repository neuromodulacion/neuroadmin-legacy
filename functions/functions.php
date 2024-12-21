<?php
function codificacionUTF($texto) {
    // Validar si $texto es null o no es una cadena
    if ($texto === null || !is_string($texto)) {
        return ''; // Retorna un string vacío si el texto es null
    }

    // Detectar la codificación actual del texto
    $encodingActual = mb_detect_encoding($texto, ['UTF-8', 'ISO-8859-1', 'ASCII'], true);

    // Inicializar la variable para la conversión
    $textoConvertido = $texto;

    // Aplicar la conversión basada en la codificación detectada
    if ($encodingActual === 'UTF-8') {
        // Convertir de UTF-8 a ISO-8859-1
        $textoConvertido = mb_convert_encoding($texto, 'ISO-8859-1', 'UTF-8');
    } elseif ($encodingActual === 'ISO-8859-1') {
        // Convertir de ISO-8859-1 a UTF-8
        $textoConvertido = mb_convert_encoding($texto, 'UTF-8', 'ISO-8859-1');
    }

    // Retornar el texto convertido o el original si no hubo conversión
    return $textoConvertido;
}


function obMesActualespaniol($fecha) {
    $formatter = new IntlDateFormatter(
        'es_ES',  // Configuración regional en español
        IntlDateFormatter::FULL,
        IntlDateFormatter::NONE,
        'UTC',  // Zona horaria
        IntlDateFormatter::GREGORIAN,
        'MMMM'  // Formato de mes completo
    );
    return ucfirst($formatter->format(strtotime($fecha))); // Capitalizar el primer carácter
}

function format_fecha_esp_dmy($f_ini) {
    // Diccionario de meses en inglés a español
    $meses_espanol = [
        'Jan' => 'Ene', 'Feb' => 'Feb', 'Mar' => 'Mar', 'Apr' => 'Abr', 'May' => 'May',
        'Jun' => 'Jun', 'Jul' => 'Jul', 'Aug' => 'Ago', 'Sep' => 'Sep', 'Oct' => 'Oct',
        'Nov' => 'Nov', 'Dec' => 'Dic'
    ];

    if (isset($f_ini)) {
        try {
            // Crear un objeto DateTime desde la fecha proporcionada
            $fecha_objeto = new DateTime($f_ini);
            // Formatear la fecha al formato deseado (d-M-Y)
            $f_ini_formateado = $fecha_objeto->format('d-M-Y');
            // Reemplazar los meses en inglés por los equivalentes en español
            $f_ini_formateado = strtr($f_ini_formateado, $meses_espanol);
        } catch (Exception $e) {
            error_log("Error formateando la fecha: " . $e->getMessage());
            $f_ini_formateado = ""; // Devolver vacío en caso de error
        }
    } else {
        $f_ini_formateado = "";
    }

    return $f_ini_formateado;
}
