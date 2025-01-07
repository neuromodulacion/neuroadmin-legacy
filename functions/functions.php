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

function format_fecha_esp_extensa($fecha) {
    // Salida: Domingo 5 de enero de 2025
    // Verifica si la fecha está definida y es válida
    if (!$fecha || strtotime($fecha) === false) {
        return ""; // Retorna vacío si la fecha no es válida
    }

    try {
        // Crear un objeto DateTime
        $fecha_objeto = new DateTime($fecha);

        // Configuración del formateador con la configuración regional de español
        $formateador = new IntlDateFormatter(
            'es_ES', // Configuración regional (español de España, ajusta según necesidad)
            IntlDateFormatter::FULL, // Formato completo para la fecha
            IntlDateFormatter::NONE, // Sin formato para la hora
            $fecha_objeto->getTimezone(), // Zona horaria del objeto DateTime
            IntlDateFormatter::GREGORIAN // Calendario gregoriano
        );

        // Personaliza el formato
        $formateador->setPattern("EEEE d 'de' MMMM 'de' yyyy");

        // Devuelve la fecha formateada
        return $formateador->format($fecha_objeto);
    } catch (Exception $e) {
        error_log("Error formateando la fecha: " . $e->getMessage());
        return ""; // Retorna vacío en caso de error
    }
}


function mesCorto($numeroMes) {
    $mesesCortos = [
        1 => "Ene", 2 => "Feb", 3 => "Mar", 4 => "Abr",
        5 => "May", 6 => "Jun", 7 => "Jul", 8 => "Ago",
        9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dic"
    ];

    // Normalizar el mes como un entero
    $numeroMes = (int) ltrim($numeroMes, '0');

    // Validar si el mes es válido
    if (isset($mesesCortos[$numeroMes])) {
        return $mesesCortos[$numeroMes];
    }

    return "Mes inválido";
}

function mesLargo($numeroMes) {
    $mesesLargos = [
        1 => "Enero", 2 => "Febrero", 3 => "Marzo", 4 => "Abril",
        5 => "Mayo", 6 => "Junio", 7 => "Julio", 8 => "Agosto",
        9 => "Septiembre", 10 => "Octubre", 11 => "Noviembre", 12 => "Diciembre"
    ];

    // Normalizar el mes como un entero
    $numeroMes = (int) ltrim($numeroMes, '0');

    // Validar si el mes es válido
    if (isset($mesesLargos[$numeroMes])) {
        return $mesesLargos[$numeroMes];
    }

    return "Mes inválido";
}

/**
 * Formatea una fecha en el estilo "día - mesAbreviado" en español
 * por ejemplo, "2024-12-25" => "25 - dic"
 *
 * @param string $fecha Cadena con la fecha (ejemplo: '2024-12-25')
 * @return string       Cadena formateada en español (ejemplo: '25 - dic')
 */
function formdiaanoEsp($fecha)
{
    // Creamos un arreglo manual con los meses en español
    $meses = [
        1 => 'ene', 2 => 'feb', 3 => 'mar', 4 => 'abr',
        5 => 'may', 6 => 'jun', 7 => 'jul', 8 => 'ago',
        9 => 'sep', 10 => 'oct', 11 => 'nov', 12 => 'dic'
    ];

    // Convertimos la fecha a objeto DateTime
    $fechaObj = new DateTime($fecha);

    // Obtenemos el día y el número de mes
    $dia    = $fechaObj->format('d');    // 01 al 31
    $numMes = (int) $fechaObj->format('n'); // 1 al 12

    // Devolvemos la fecha con el formato "día - mesAbreviado"
    return "{$dia} - {$meses[$numMes]}";
}

/**
 * Formatea una fecha tipo "día-mesAbrev-año hora:min:seg AM/PM" en español
 * Ejemplo: '2024-12-25 13:05:06' => '25-dic-2024 01:05:06 PM'
 *
 * @param  string $fecha Cadena con la fecha (e.g. "2024-12-25 13:05:06")
 * @return string        Cadena formateada (e.g. "25-dic-2024 01:05:06 PM")
 */
function formatearFechaCompleta($fecha)
{
    // Meses abreviados en español
    $meses = [
        1  => 'ene', 2  => 'feb', 3  => 'mar', 4  => 'abr',
        5  => 'may', 6  => 'jun', 7  => 'jul', 8  => 'ago',
        9  => 'sep', 10 => 'oct', 11 => 'nov', 12 => 'dic'
    ];

    // Convertimos la fecha a objeto DateTime
    $fechaObj = new DateTime($fecha);

    // Obtenemos partes de la fecha
    $dia     = $fechaObj->format('d');    // 01-31
    $numMes  = (int) $fechaObj->format('n'); // 1-12
    $anio    = $fechaObj->format('Y');    // año con 4 dígitos
    $hora12  = $fechaObj->format('h');    // 12-horas (con 0 a la izquierda)
    $min     = $fechaObj->format('i');    // minutos
    $seg     = $fechaObj->format('s');    // segundos
    $ampm    = $fechaObj->format('A');    // AM o PM

    // Retornamos en formato "día-mesAbrev-año hh:mm:ss AM/PM"
    return "{$dia}-{$meses[$numMes]}-{$anio} {$hora12}:{$min}:{$seg} {$ampm}";
}


