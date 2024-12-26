<?php
// Iniciar la sesión del usuario
session_start();

// Configurar el nivel de reporte de errores (7 muestra errores y advertencias)
error_reporting(7);

// Establecer la codificación interna a UTF-8 para las funciones de conversión de cadenas
iconv_set_encoding('internal_encoding', 'utf-8');

// Enviar cabecera HTTP para especificar que el contenido es HTML con codificación UTF-8
header('Content-Type: text/html; charset=UTF-8');

// Establecer la zona horaria predeterminada
date_default_timezone_set('America/Monterrey');

// Configurar la localización en español para fechas y horas
setlocale(LC_TIME, 'es_ES.UTF-8');

// Guardar la hora actual en la sesión
$_SESSION['time'] = time();

// Definir la ruta base para acceder a otros archivos
$ruta = "../";

// Incluye archivos PHP necesarios para la funcionalidad adicional
include($ruta.'functions/funciones_mysql.php');
include($ruta.'functions/conexion_mysqli.php');
include($ruta.'functions/functions.php');

// Incluir el archivo de configuración y obtener las credenciales
$configPath = $ruta.'../config.php';

if (!file_exists($configPath)) {
    die('Archivo de configuración no encontrado.');
}

$config = require $configPath;

// Crear una instancia de la clase Mysql
$mysql = new Mysql($config['servidor'], $config['usuario'], $config['contrasena'], $config['baseDatos']);

extract($_SESSION);
extract($_POST);

//print_r($_POST);

$fecha_titulo = $fecha;

// En caso de que $tipo_consulta sea mensual, necesitamos extraer año y mes de $fecha (formato YYYY-MM)
if (strpos($fecha, '-') !== false) {
    $anio_sel = date('Y', strtotime($fecha));
    $mes_sel = date('m', strtotime($fecha));
} else {
    // Si $fecha no viene en el formato esperado, se puede manejar el error o usar valores por defecto
    $anio_sel = date('Y');
    $mes_sel = date('m');
}

switch ($tipo_consulta) {
    case 'total':
        ?>
        <h1 style="text-align: center"><b><?php echo $fecha_titulo; ?></b></h1>
        <table class="table table-bordered">
            <tr>
                <th>Hora</th>
                <th>Médico</th>
                <th>No</th>
                <th>Paciente</th>
                <th>Terapia</th>
            </tr>
        <?php
        $sql = "
        SELECT
            historico_sesion.sesion,
            historico_sesion.f_captura,
            historico_sesion.h_captura,
            historico_sesion.usuario_id AS medico_id,
            admin.nombre AS medico,
            historico_sesion.paciente_id,
            CONCAT( pacientes.paciente, ' ', pacientes.apaterno, ' ', pacientes.amaterno ) AS pacientes,
            protocolo_terapia.terapia 
        FROM
            historico_sesion
            INNER JOIN admin ON historico_sesion.usuario_id = admin.usuario_id
            INNER JOIN pacientes ON historico_sesion.paciente_id = pacientes.paciente_id
            INNER JOIN protocolo_terapia ON historico_sesion.protocolo_ter_id = protocolo_terapia.protocolo_ter_id 
        WHERE
            historico_sesion.f_captura = '$fecha'
            AND admin.empresa_id = $empresa_id";

        $result=ejecutar($sql); 
        $cnt = mysqli_num_rows($result);

        if ($cnt != 0) {
            while($row = mysqli_fetch_array($result)){
                extract($row);
                ?>
                <tr>
                    <td><?php echo $h_captura; ?></td>
                    <td><?php echo $medico; ?></td>
                    <td><?php echo $paciente_id; ?></td>
                    <td><?php echo $pacientes; ?></td>
                    <td><?php echo $terapia; ?></td>
                </tr>
                <?php
            }
        } else { ?>
            <tr>
                <td style="text-align: center" colspan="5"><b>No hay registros</b></td>
            </tr>
        <?php } ?>
        </table>
        <?php
    break;

    case 'diaria':
        ?>
        <h1 style="text-align: center"><b><?php echo $fecha_titulo; ?></b></h1>
        <h2>Médico: <?php echo $medico; ?></h2>
        <table class="table table-bordered">
            <tr>
                <th>Hora</th>
                <th>No</th>
                <th>Paciente</th>
                <th>Terapia</th>
            </tr>
        <?php
        $sql = "
        SELECT
            historico_sesion.sesion,
            historico_sesion.f_captura,
            historico_sesion.h_captura,
            historico_sesion.usuario_id AS medico_id,
            admin.nombre AS medico,
            historico_sesion.paciente_id,
            CONCAT( pacientes.paciente, ' ', pacientes.apaterno, ' ', pacientes.amaterno ) AS pacientes,
            protocolo_terapia.terapia 
        FROM
            historico_sesion
            INNER JOIN admin ON historico_sesion.usuario_id = admin.usuario_id
            INNER JOIN pacientes ON historico_sesion.paciente_id = pacientes.paciente_id
            INNER JOIN protocolo_terapia ON historico_sesion.protocolo_ter_id = protocolo_terapia.protocolo_ter_id 
        WHERE
            historico_sesion.f_captura = '$fecha'
            AND admin.empresa_id = $empresa_id
            AND historico_sesion.usuario_id = $usuario_idx";

        $result=ejecutar($sql); 
        $cnt = mysqli_num_rows($result);

        if ($cnt != 0) {
            while($row = mysqli_fetch_array($result)){
                extract($row);
                ?>
                <tr>
                    <td><?php echo $h_captura; ?></td>
                    <td><?php echo $paciente_id; ?></td>
                    <td><?php echo $pacientes; ?></td>
                    <td><?php echo $terapia; ?></td>
                </tr>
                <?php
            }
        } else { ?>
            <tr>
                <td style="text-align: center" colspan="4"><b>No hay registros</b></td>
            </tr>
        <?php } ?>
        </table>
        <?php
    break;

    case 'mensual':
        // Reporte mensual de un técnico específico
        $mesLargo = mesLargo($mes_sel);
        ?>
        <h1 style="text-align: center"><b><?php echo $mesLargo.' del '.$anio_sel; ?></b></h1>
        <h2>Médico: <?php echo $medico; ?></h2>
        <table class="table table-bordered">
            <tr>
                <th>Fecha</th>
                <th>Hora</th>
                <th>No</th>
                <th>Paciente</th>
                <th>Terapia</th>
            </tr>
        <?php
        $sql = "
        SELECT
            historico_sesion.sesion,
            historico_sesion.f_captura,
            historico_sesion.h_captura,
            historico_sesion.usuario_id AS medico_id,
            admin.nombre AS medico,
            historico_sesion.paciente_id,
            CONCAT( pacientes.paciente, ' ', pacientes.apaterno, ' ', pacientes.amaterno ) AS pacientes,
            protocolo_terapia.terapia 
        FROM
            historico_sesion
            INNER JOIN admin ON historico_sesion.usuario_id = admin.usuario_id
            INNER JOIN pacientes ON historico_sesion.paciente_id = pacientes.paciente_id
            INNER JOIN protocolo_terapia ON historico_sesion.protocolo_ter_id = protocolo_terapia.protocolo_ter_id 
        WHERE
            YEAR(historico_sesion.f_captura) = $anio_sel
            AND MONTH(historico_sesion.f_captura) = $mes_sel
            AND admin.empresa_id = $empresa_id
            AND historico_sesion.usuario_id = $usuario_idx
        ORDER BY historico_sesion.f_captura, historico_sesion.h_captura ASC";

        $result=ejecutar($sql); 
        $cnt = mysqli_num_rows($result);

        if ($cnt != 0) {
            while($row = mysqli_fetch_array($result)){
                extract($row);
                ?>
                <tr>
                    <td><?php echo $f_captura; ?></td>
                    <td><?php echo $h_captura; ?></td>
                    <td><?php echo $paciente_id; ?></td>
                    <td><?php echo $pacientes; ?></td>
                    <td><?php echo $terapia; ?></td>
                </tr>
                <?php
            }
        } else { ?>
            <tr>
                <td style="text-align: center" colspan="5"><b>No hay registros</b></td>
            </tr>
        <?php } ?>
        </table>
        <?php
    break;

    case 'total_mensual':
        // Reporte mensual total (para todos los técnicos)
        $mesLargo = mesLargo($mes_sel);
        ?>
        <h1 style="text-align: center"><b><?php echo $mesLargo.' del '.$anio_sel; ?></b></h1>
        <h2>Reporte Mensual General</h2>
        <table class="table table-bordered">
            <tr>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Médico</th>
                <th>No</th>
                <th>Paciente</th>
                <th>Terapia</th>
            </tr>
        <?php
        $sql = "
        SELECT
            historico_sesion.sesion,
            historico_sesion.f_captura,
            historico_sesion.h_captura,
            admin.usuario_id AS medico_id,
            admin.nombre AS medico,
            historico_sesion.paciente_id,
            CONCAT( pacientes.paciente, ' ', pacientes.apaterno, ' ', pacientes.amaterno ) AS pacientes,
            protocolo_terapia.terapia 
        FROM
            historico_sesion
            INNER JOIN admin ON historico_sesion.usuario_id = admin.usuario_id
            INNER JOIN pacientes ON historico_sesion.paciente_id = pacientes.paciente_id
            INNER JOIN protocolo_terapia ON historico_sesion.protocolo_ter_id = protocolo_terapia.protocolo_ter_id
        WHERE
            YEAR(historico_sesion.f_captura) = $anio_sel
            AND MONTH(historico_sesion.f_captura) = $mes_sel
            AND admin.empresa_id = $empresa_id
        ORDER BY historico_sesion.f_captura, historico_sesion.h_captura ASC";

        $result=ejecutar($sql); 
        $cnt = mysqli_num_rows($result);

        if ($cnt != 0) {
            while($row = mysqli_fetch_array($result)){
                extract($row);
                ?>
                <tr>
                    <td><?php echo $f_captura; ?></td>
                    <td><?php echo $h_captura; ?></td>
                    <td><?php echo $medico; ?></td>
                    <td><?php echo $paciente_id; ?></td>
                    <td><?php echo $pacientes; ?></td>
                    <td><?php echo $terapia; ?></td>
                </tr>
                <?php
            }
        } else { ?>
            <tr>
                <td style="text-align: center" colspan="6"><b>No hay registros</b></td>
            </tr>
        <?php } ?>
        </table>
        <?php
    break;

    default:
        echo "<h2>No se ha definido un tipo de consulta válido.</h2>";
    break;          
}
?>
