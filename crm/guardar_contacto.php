<?php
include('../functions/conexion_mysqli.php');
$ruta = "../";
session_start();

// Validar si la sesión está activa y las variables necesarias existen
if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['empresa_id'])) {
    die('Sesión no válida. Por favor, inicie sesión.');
}
// print_r($_POST);
// Validar que se haya enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Instanciar conexión
    $configPath = '../../config.php';
    if (!file_exists($configPath)) {
        die('Archivo de configuración no encontrado.');
    }
    $config = require $configPath;
    $conexion = new Mysql($config['servidor'], $config['usuario'], $config['contrasena'], $config['baseDatos']);

    // Capturar datos del formulario
    $medico_id = intval($_POST['medico_id']);
    $metodo_contacto = trim($_POST['metodo_contacto']);
    $exito = intval($_POST['exito']);
    $observaciones = trim($_POST['observaciones']);
    $usuario_id = $_SESSION['usuario_id'];
    $empresa_id = $_SESSION['empresa_id'];
    $telefono = trim($_POST['telefono']);
    $domicilio = trim($_POST['domicilio']);
    $f_visita = $_POST['f_visita'];
    

    // Insertar el contacto en la tabla `contactos`
    $query = "
        INSERT INTO contactos (
            medico_id,telefono,domicilio, metodo_contacto, exito, observaciones, usuario_id, empresa_id, f_visita
        ) VALUES (?, ?, ?,?, ?, ?, ?, ?, ?)";
    $resultado = $conexion->consulta_simple($query, [
        $medico_id, $telefono, $domicilio, $metodo_contacto, $exito, $observaciones, $usuario_id, $empresa_id, $f_visita
    ]);

    try {
        // Consulta para obtener el nombre del médico
        $query = "
            SELECT
                nombre
            FROM
                admin_tem 
            WHERE
                medico_id = ?";
        
        $medicos = $conexion->consulta($query, [$medico_id]);
    
        // Validar resultados
        if ($medicos['numFilas'] > 0) {
            $medico = $medicos['resultado'][0]; // Obtén el primer resultado
            $nombre = htmlspecialchars($medico['nombre'], ENT_QUOTES, 'UTF-8'); // Sanitiza el valor
        } else {
            $nombre = "No encontrado"; // Valor predeterminado si no se encuentran registros
        }
    
    } catch (Exception $e) {
        $nombre = "Error al consultar el nombre";
        error_log($e->getMessage()); // Registrar errores para depuración
    }
    

    // Verificar si el registro fue exitoso
    if ($resultado) {
        $mensaje = "El contacto se registró correctamente.";
        $mens1 = "ÉXITO";
    } else {
        $mensaje = "Error al registrar el contacto.";
        $mens1 = "ERROR";
    }
} else {
    die("Método de solicitud no permitido.");
}
?>

<!-- HTML para mostrar el mensaje de éxito de registro -->
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
                <!-- Mensaje de confirmación de éxito -->
                <div><h1><?php echo $mens1; ?></h1></div>
                <div><h2>Se guardo correctamente la información</h2></div>
                <div align="center"> 
                    <div style="width: 90% !important;" align="left">
                        <h2><?php echo $mensaje; ?></h2>
                        <!-- Mostrar información del usuario registrado -->
                        Registro: <?php echo $medico_id; ?><br>
                        Nombre: <?php echo $nombre; ?><br>
                        Teléfono: <?php echo $telefono; ?><br>
                        Observaciones: <?php echo $observaciones; ?><br><br>               
                        <!-- Botón para continuar al menú principal -->
                        <a href="<?php echo $ruta; ?>menu.php" class="btn bg-green btn-lg waves-effect">CONTINUAR</a>                
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