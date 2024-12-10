<?php
$ruta = "../";
// Incluir archivos necesarios para funciones de base de datos y envío de correos electrónicos
include($ruta.'functions/funciones_mysql.php');
include($ruta.'functions/email.php');
include($ruta.'functions/conexion_mysqli.php');

// Incluir el archivo de configuración y obtener las credenciales
$configPath = $ruta.'../config.php';

if (!file_exists($configPath)) {
    die('Archivo de configuración no encontrado.');
}

$config = require $configPath;

// Crear una instancia de la clase Mysql
$mysql = new Mysql($config['servidor'], $config['usuario'], $config['contrasena'], $config['baseDatos']);
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


// Definir la ruta de los archivos
$ruta = "../";

// Extraer variables de sesión y de $_POST para usarlas directamente
extract($_SESSION);
extract($_POST);

// Fecha y hora de registro actual
$f_registro = date("Y-m-d");
$h_registro = date("H:i:s");

$paciente_id = $_POST['paciente_id'] ?? null;
$contacto = $_POST['contacto'] ?? '';
$no_contacto = $_POST['no_contacto'] ?? '';
$beneficios = $_POST['beneficios'] ?? '';
$costo = $_POST['costo'] ?? '';
$f_pago = $_POST['f_pago'] ?? '';
$ini_tratamiento = $_POST['ini_tratamiento'] ?? '';
$forma_pago = $_POST['forma_pago'] ?? '';
$no_tratamiento = $_POST['no_tratamiento'] ?? '';
$otros = $_POST['otros'] ?? '';
$new_contacto = $_POST['new_contacto'] ?? '';
$f_contacto_prox = $_POST['f_contacto_prox'] ?? null;
$observaciones = $_POST['observaciones'] ?? '';
$usuario_id = $_SESSION['usuario_id'] ?? 0;
$empresa_id = $_SESSION['empresa_id'] ?? 0;


// Consulta para insertar un nuevo registro de llamada en la tabla `registro_llamadas`
$insert1 = "
INSERT IGNORE INTO registro_llamadas 
    (
        paciente_id,
        contacto,
        no_contacto,
        beneficios,
        costo,
        f_pago,
        ini_tratamiento,
        forma_pago,
        no_tratamiento,
        otros,
        new_contacto,
        f_contacto_prox,
        observaciones,
        f_registro,
        h_registro,
        usuario_id
    ) 
VALUES
    (
        '$paciente_id',
        '$contacto',
        '$no_contacto',
        '$beneficios',
        '$costo',
        '$f_pago',
        '$ini_tratamiento',
        '$forma_pago',
        '$no_tratamiento',
        '$otros',
        '$new_contacto',
        '$f_contacto_prox',
        '$observaciones',
        '$f_registro',
        '$h_registro',
        $usuario_id
    )";

// Ejecutar la consulta de inserción
$result_insert = ejecutar($insert1);

// Consulta para obtener detalles del paciente y el usuario asociado
$sql = "
SELECT
    pacientes.paciente_id, 
    pacientes.usuario_id as usuario_idx, 
    admin.usuario as usuariox,
    CONCAT(pacientes.paciente, ' ', pacientes.apaterno, ' ', pacientes.amaterno) as paciente, 
    admin.nombre
FROM
    pacientes
    INNER JOIN
    admin
    ON pacientes.usuario_id = admin.usuario_id
WHERE
    pacientes.paciente_id = '$paciente_id'"; 

// Ejecutar la consulta de selección y extraer los resultados
$result_sql = ejecutar($sql);
$row = mysqli_fetch_array($result_sql);
extract($row); // Extrae los datos obtenidos para usarlos directamente

// Lógica para determinar el estatus del paciente según el contacto y decisión de tratamiento

// Verificar si se contactó al paciente
if ($contacto == 'Si') {
    // Si el paciente quiere iniciar tratamiento
    if ($ini_tratamiento == 'Si') {
        // Verificar el método de pago para actualizar el estatus
        if ($forma_pago == 'No sabe en este momento') {
            // Actualizar estatus a "Seguimiento" si el método de pago es incierto
            $updatesi = "
                UPDATE pacientes
                SET estatus='Seguimiento' WHERE paciente_id = $paciente_id";
            $result = ejecutar($updatesi);
        } else {
            // Actualizar estatus a "Confirmado" si tiene claridad sobre el pago
            $updatesi = "
                UPDATE pacientes
                SET estatus='Confirmado' WHERE paciente_id = $paciente_id";
            $result = ejecutar($updatesi);
        }
    } else {
        // Si no desea iniciar tratamiento
        if ($new_contacto == 'No') {
            // Si no quiere ser contactado nuevamente, actualizar estatus a "No interesado"
            $update2 = "
                UPDATE pacientes
                SET estatus='No interesado' WHERE paciente_id = $paciente_id";
            $result = ejecutar($update2);
            $mensajes = 'El motivo que mencionó el paciente para no iniciar el tratamiento fue ' . $msg;
        } else {
            // Si desea ser contactado en el futuro, actualizar estatus a "Seguimiento" y programar seguimiento
            $update1 = "
                UPDATE pacientes
                SET estatus='Seguimiento' WHERE paciente_id = $paciente_id";
            $result = ejecutar($update1);

            // Insertar seguimiento en la tabla `seguimientos` con la fecha de contacto próxima
            $insert = "
            INSERT IGNORE INTO seguimientos
                (
                    seguimientos.fecha, 
                    seguimientos.f_registro, 
                    seguimientos.h_registro, 
                    seguimientos.paciente_id, 
                    seguimientos.mensaje, 
                    seguimientos.observaciones, 
                    seguimientos.usuario_id, 
                    seguimientos.empresa_id
                ) 
            VALUES
                (
                    '$f_contacto_prox',
                    '$f_registro',
                    '$h_registro',
                    $paciente_id,
                    'Llamar a paciente para validar sobre el tratamiento',
                    '$observaciones',
                    $usuario_id,
                    $empresa_id
                )";
            $result = ejecutar($insert);
        }
    }
} else {
    // Si no se contactó al paciente
    if ($no_contacto == 'Ya no esta interesado') {
        // Actualizar estatus a "No interesado" si ya no está interesado
        $update2 = "
            UPDATE pacientes
            SET estatus='No interesado' WHERE paciente_id = $paciente_id";
        $result = ejecutar($update2);
    } else {
        // Si no se contactó pero se requiere seguimiento, actualizar estatus a "Seguimiento"
        $update1 = "
            UPDATE pacientes
            SET estatus='Seguimiento' WHERE paciente_id = $paciente_id";
        $result = ejecutar($update1);
    }
}

?>            
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Guardado</title>
    <!-- Favicon-->
    <link rel="icon" href="../../favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="../plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="../plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="../css/style.css" rel="stylesheet">
</head>

<body class="theme-<?php echo $body; ?>">    
    <div style="padding-top: 30px" class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div align="center" style="padding: 20px;" class="five-zero-zero-container card">
                <div> <h2>Se guardó la información</h2></div>
                <div align="center"> 
                    <div style="width: 90% !important;" align="left">
                        <h3>Se contactó al paciente para la terapia</h3>
                        <div style="width: 90% !important;" align="left">
                            <!-- Mostrar detalles de la llamada de contacto y estatus del paciente -->
                            Registro: <b><?php echo $paciente_id; ?></b><br>
                            Nombre: <b><?php echo $paciente; ?></b><br>
                            Decidió iniciar el tratamiento: <b><?php echo $ini_tratamiento; ?></b><br>              
                        </div> 
                        <!-- Botón para continuar al listado de pendientes -->
                        <a href="<?php echo $ruta; ?>paciente/pendientes.php" class="btn bg-green btn-lg waves-effect">CONTINUAR</a>  
                        <!-- Botón para agendar si el paciente decidió iniciar tratamiento -->
                        <?php if ($ini_tratamiento == 'Si') { ?>
                        <a class="btn bg-cyan waves-effect" href="<?php echo $ruta; ?>paciente/agenda.php?paciente_id=<?php echo $paciente_id; ?>">
                             <i class="material-icons">call_missed_outgoing</i> <b>Agendar</b>
                         </a>                           
                        <?php } ?>           
                    </div>                
                </div>
            </div>
        </div>
        <div class="col-md-4"></div>
    </div>                

    <!-- Jquery Core Js -->
    <script src="../../plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="../../plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="../../plugins/node-waves/waves.js"></script>
</body>

</html>  	