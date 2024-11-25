<?php
$ruta = '../';
// Inicia una nueva sesión o reanuda la existente
session_start();

// Configura la notificación de errores para mostrar todos los errores
error_reporting(E_ALL);

// Establece el conjunto de caracteres predeterminado como UTF-8
ini_set('default_charset', 'UTF-8');

// Configura la cabecera HTTP para que el contenido se interprete como HTML con codificación UTF-8
header('Content-Type: text/html; charset=UTF-8');

// Establece la zona horaria predeterminada para la aplicación
// date_default_timezone_set('America/Monterrey'); // Opción comentada para Monterrey
date_default_timezone_set('America/Monterrey');

// Asegurar que se establezca la configuración regional para los nombres de mes y día
setlocale(LC_TIME, 'es_ES.UTF-8');  // Para sistemas Unix
if (stripos(PHP_OS, 'WIN') === 0) {
    setlocale(LC_TIME, 'Spanish_Spain.1252');  // Para sistemas Windows
}

// Extrae variables de sesión, POST y GET para su uso directo
extract($_SESSION);
extract($_POST);
extract($_GET);
include($ruta.'functions/conexion_mysqli.php');

// Incluir el archivo de configuración y obtener las credenciales
$configPath = $ruta.'../config.php';

if (!file_exists($configPath)) {
    die('Archivo de configuración no encontrado.');
}

$config = require $configPath;

// Crear una instancia de la clase Mysql
$mysql = new Mysql($config['servidor'], $config['usuario'], $config['contrasena'], $config['baseDatos']);

// Crear una instancia de la clase Mysql
$conexion = new Mysql($config['servidor'], $config['usuario'], $config['contrasena'], $config['baseDatos']);

// Función auxiliar para sanitizar valores y evitar pasar null a htmlspecialchars()
function sanitizarValor($valor) {
    return htmlspecialchars($valor ?? '', ENT_QUOTES, 'UTF-8');
}
?>
<input type="hidden" id="paciente_id" name="paciente_id" value="<?php echo $paciente_id; ?>"/>
<?php  

    // Consulta segura para obtener datos del paciente
    $sql_paciente = "
        SELECT 
            CONCAT(paciente, ' ', apaterno, ' ', amaterno) AS paciente,
            tratamiento 
        FROM pacientes 
        WHERE paciente_id = ?";
    $params = [$paciente_id]; // Parámetro preparado para la consulta

    $result_paciente = $mysql->consulta($sql_paciente, $params);

    if ($result_paciente['numFilas'] > 0) {
        $row_paciente = $result_paciente['resultado'][0]; // Obtener la primera fila del resultado
        $paciente = mb_convert_encoding($row_paciente['paciente'] ?? 'Paciente no encontrado', 'ISO-8859-1', 'UTF-8');
        $tratamiento = mb_convert_encoding($row_paciente['tratamiento'] ?? 'N/A', 'ISO-8859-1', 'UTF-8');

        // Generar la URL del paciente
        $rutax = $ruta . 'paciente/info_paciente.php?paciente_id=' . $paciente_id;
    } else {
        // Manejo de error si el paciente no existe
        $paciente = "Paciente no encontrado";
        $tratamiento = "N/A";
        $rutax = "#"; // URL predeterminada o de error
    }

    // Construir el encabezado de la tabla
    $tabla = "<br>
        <h3><b>Protocolo que está Indicado:</b></h3>
        <h2 align='center'><b><i>{$tratamiento}</i></b></h2>
        <hr>
        <table class='table table-bordered table-striped table-hover dataTable'>
            <caption style='text-align: center'>
                <h3>
                    <b>Paciente No. {$paciente_id} - {$paciente}</b>
                    <a class='btn bg-blue waves-effect' href='{$rutax}'>
                        <i class='material-icons'>chat</i> <b>Datos</b>
                    </a>
                </h3>
            </caption>
            <thead>
                <tr>
                    <th>Equipo</th>
                    <th>Protocolo</th>
                    <th>Sesiones Aplicadas</th>
                </tr>
            </thead>
            <tbody>";
    
    // Consulta para obtener los protocolos del paciente
    $sql = "
        SELECT 
            historico_sesion.paciente_id,
            historico_sesion.protocolo_ter_id,
            COUNT(protocolo_terapia.prot_terapia) AS total_sesion,
            CONCAT(protocolo_terapia.prot_terapia, ' ', historico_sesion.anodo, ' ', historico_sesion.catodo) AS prot_terapia,
            pacientes.estatus,
            equipos.equipo
        FROM 
            historico_sesion
        INNER JOIN 
            protocolo_terapia ON historico_sesion.protocolo_ter_id = protocolo_terapia.protocolo_ter_id
        INNER JOIN 
            pacientes ON historico_sesion.paciente_id = pacientes.paciente_id
        INNER JOIN 
            equipos ON protocolo_terapia.equipo_id = equipos.equipo_id
        WHERE 
            historico_sesion.paciente_id = ?
        GROUP BY 
            historico_sesion.paciente_id, historico_sesion.protocolo_ter_id";
    $params = [$paciente_id]; // Preparar el parámetro para evitar inyección SQL
    
    $result_protocolo = $mysql->consulta($sql, $params);
    
    $total_sesiones = 0;
    $Gtotal = 0;
    
    // Procesar los resultados y construir las filas de la tabla
    if ($result_protocolo['numFilas'] > 0) {
        foreach ($result_protocolo['resultado'] as $row) {
            $equipo = $row['equipo'];
            $prot_terapia = $row['prot_terapia'];
            $total_sesion = $row['total_sesion'];
    
            $tabla .= "
                <tr>
                    <td>{$equipo}</td>
                    <td>{$prot_terapia}</td>
                    <td style='text-align: center'>{$total_sesion}</td>
                </tr>";
    
            $Gtotal += $total_sesion;
        }
    }
    
    // Agregar el total de sesiones a la tabla
    $tabla .= "
        <tr>
            <th style='text-align: center' colspan='2'>Total</th>
            <th style='text-align: center'>{$Gtotal}</th>
        </tr>
        </tbody>
        </table>";
    
    // Mostrar la tabla
    echo $tabla;

    // Consulta segura para obtener las métricas del paciente
    $sql_metrica = "
        SELECT 
            metricas.x, 
            metricas.y, 
            metricas.umbral, 
            metricas.observaciones
        FROM
            metricas
        WHERE
            metricas.paciente_id = ?";
    $params = [$paciente_id]; // Parámetro preparado para la consulta
    
    // Ejecutar la consulta usando una clase segura como Mysql
    $result_metrica = $mysql->consulta($sql_metrica, $params);
    
    if ($result_metrica['numFilas'] > 0) {
        // Obtener la primera fila del resultado
        $row_metrica = $result_metrica['resultado'][0];
        $x = $row_metrica['x'];
        $y = $row_metrica['y'];
        $umbral = $row_metrica['umbral'];
        $observaciones = $row_metrica['observaciones'];
        ?>
        <!-- Renderizar la tabla con los resultados -->
        <table class="table table-bordered table-striped table-hover dataTable">
            <thead>
                <tr>
                    <th style="text-align: center">X</th>
                    <th style="text-align: center">Y</th>
                    <th style="text-align: center">Umbral</th>
                    <th>Observaciones</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: center"><?php echo htmlspecialchars($x); ?></td>
                    <td style="text-align: center"><?php echo htmlspecialchars($y); ?></td>
                    <td style="text-align: center"><?php echo htmlspecialchars($umbral); ?></td>
                    <td><?php echo htmlspecialchars($observaciones); ?></td>
                </tr>
            </tbody>
        </table>
        <hr>
        <?php
    } else {
        echo "<p>No se encontraron métricas para este paciente.</p>";
    }

    $dia = "
        <div class='panel-group' id='accordion_1' role='tablist' aria-multiselectable='true'>
            <div class='panel panel-col-$body'>
                <div class='panel-heading' role='tab' id='headingSesion'>
                    <h4 class='panel-title'>
                        <a role='button' data-toggle='collapse' data-parent='#accordion_1' href='#collapseSesion' aria-expanded='true' aria-controls='collapseSesion'>
                            Historico de Sesiones
                        </a>
                    </h4>
                </div>
                <div id='collapseSesion' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingSesion'>
                    <div class='panel-body'>";
    
    // Consulta segura para obtener el historial de sesiones
    $sql_table = "
        SELECT
            admin.usuario_id,
            admin.nombre,
            pacientes.paciente_id,
            pacientes.paciente,
            pacientes.apaterno,
            pacientes.amaterno,
            historico_sesion.f_captura,
            historico_sesion.h_captura,
            historico_sesion.umbral,
            historico_sesion.observaciones,
            equipos.equipo,
            protocolo_terapia.prot_terapia 
        FROM
            historico_sesion
            INNER JOIN admin ON historico_sesion.usuario_id = admin.usuario_id
            INNER JOIN pacientes ON historico_sesion.paciente_id = pacientes.paciente_id
            INNER JOIN protocolo_terapia ON historico_sesion.protocolo_ter_id = protocolo_terapia.protocolo_ter_id
            INNER JOIN equipos ON protocolo_terapia.equipo_id = equipos.equipo_id 
        WHERE
            historico_sesion.paciente_id = ?
        ORDER BY historico_sesion.f_captura ASC";
    $params = [$paciente_id]; // Parámetro para consulta preparada
    
    $result_sem2 = $mysql->consulta($sql_table, $params);
    
    if ($result_sem2['numFilas'] > 0) {
        $dia .= "
            <table class='table table-bordered'>
                <thead>
                    <tr>
                        <th>Sesión</th>
                        <th>Aplico</th>
                        <th>Equipo</th>
                        <th>Hora</th>
                        <th>Umbral</th>
                        <th>Observaciones</th>
                    </tr>
                </thead>
                <tbody>";
    
        $meses_espanol = [
            'Jan' => 'Ene',
            'Feb' => 'Feb',
            'Mar' => 'Mar',
            'Apr' => 'Abr',
            'May' => 'May',
            'Jun' => 'Jun',
            'Jul' => 'Jul',
            'Aug' => 'Ago',
            'Sep' => 'Sep',
            'Oct' => 'Oct',
            'Nov' => 'Nov',
            'Dec' => 'Dic',
        ];
    
        $cnt_a = 1;
        foreach ($result_sem2['resultado'] as $row) {
            $f_captura = (new DateTime($row['f_captura']))->format('d-M-Y');
            $f_captura = strtr($f_captura, $meses_espanol); // Reemplazar meses en español
    
            $dia .= "
                <tr>
                    <td style='text-align: center'>{$cnt_a}</td>
                    <td>{$row['nombre']}</td>
                    <td>{$row['equipo']}</td>
                    <td>{$f_captura}<br>{$row['h_captura']}</td>
                    <td style='text-align: center'>{$row['umbral']}</td>
                    <td>{$row['observaciones']}</td>
                </tr>";
    
            $cnt_a++;
        }
    
        $dia .= "</tbody></table>";
    } else {
        $dia .= "<p>No hay historial de sesiones para este paciente.</p>";
    }

    $dia .= "

                    </div>
                </div>
            </div>
        </div>";
        ?>
        <input type="hidden" id="protocolo_ter_id" name="protocolo_ter_id" value="<?php echo htmlspecialchars($protocolo_ter_id ?? '', ENT_QUOTES, 'UTF-8'); ?>"/>
        <input type="hidden" id="prot_terapia" name="prot_terapia" value="<?php echo htmlspecialchars($prot_terapia ?? '', ENT_QUOTES, 'UTF-8'); ?>"/>
        <input type="hidden" id="sesion_id" name="sesion_id" value="<?php echo htmlspecialchars($sesion_id ?? '', ENT_QUOTES, 'UTF-8'); ?>"/>
        <input type="hidden" id="terapia_id" name="terapia_id" value="<?php echo htmlspecialchars($terapia_id ?? '', ENT_QUOTES, 'UTF-8'); ?>"/>
        <input type="hidden" id="Gtotal" name="Gtotal" value="<?php echo htmlspecialchars($Gtotal ?? 0, ENT_QUOTES, 'UTF-8'); ?>"/>
        <input type="hidden" id="paciente" name="paciente" value="<?php echo htmlspecialchars(($paciente ?? '') . ' ' . ($apaterno ?? '') . ' ' . ($amaterno ?? ''), ENT_QUOTES, 'UTF-8'); ?>"/>
      <?php  
    echo $dia;