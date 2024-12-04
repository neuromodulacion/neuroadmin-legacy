<?php
// Iniciar sesión para acceder a las variables de sesión
session_start();

// Configuración para mostrar todos los errores
error_reporting(E_ALL);

// Configurar la zona horaria y el locale para fechas en español
date_default_timezone_set('America/Monterrey');
// Nota: setlocale puede no funcionar en algunos sistemas operativos si el locale no está instalado
setlocale(LC_TIME, 'es_ES.UTF-8');

// Registrar el tiempo de la sesión actual
$_SESSION['time'] = time();

// Obtener variables de sesión de forma segura
$empresa_id = isset($_SESSION['empresa_id']) ? intval($_SESSION['empresa_id']) : 0;
$usuario_id = isset($_SESSION['usuario_id']) ? intval($_SESSION['usuario_id']) : 0;

// Ruta para incluir archivos necesarios
$ruta = "../";
include($ruta . 'functions/funciones_mysql.php');
include($ruta . 'functions/conexion_mysqli.php');

// Ruta del archivo de configuración
$configPath = $ruta . '../config.php';

if (!file_exists($configPath)) {
    die('Archivo de configuración no encontrado.');
}

// Obtener la configuración
$config = require $configPath;

// Crear una instancia de la clase Mysql
try {
    $conexion = new Mysql($config['servidor'], $config['usuario'], $config['contrasena'], $config['baseDatos']);
    //echo "Conexión establecida correctamente.";
} catch (Exception $e) {
    die("Error en la conexión: " . $e->getMessage());
}

// Función auxiliar para sanitizar valores y evitar pasar null a htmlspecialchars()
function sanitizarValor($valor) {
    return htmlspecialchars($valor ?? '', ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturar los datos del formulario y sanitizar
    $nombre = isset($_POST['nombre']) ? sanitizarValor(trim($_POST['nombre'])) : '';
    $usuario = isset($_POST['usuario']) ? sanitizarValor(trim($_POST['usuario'])) : '';
    $celular = isset($_POST['celular']) ? sanitizarValor(trim($_POST['celular'])) : '';
    $domicilio = isset($_POST['domicilio']) ? sanitizarValor(trim($_POST['domicilio'])) : '';
    $horarios = isset($_POST['horarios']) ? sanitizarValor(trim($_POST['horarios'])) : '';
    $observaciones = isset($_POST['observaciones']) ? sanitizarValor(trim($_POST['observaciones'])) : '';
    $especialidad = isset($_POST['especialidad']) ? sanitizarValor(trim($_POST['especialidad'])) : '';

    // Validar campos requeridos
    if (empty($nombre) || empty($usuario) || empty($celular)) {
        die('Nombre, correo electrónico y celular son campos obligatorios.');
    }

    // Validar correo electrónico
    if (!filter_var($usuario, FILTER_VALIDATE_EMAIL)) {
        die('Correo electrónico inválido.');
    }

    // Definir otras variables
    $funcion = 'MEDICO';
    $f_alta = date("Y-m-d");
    $h_alta = date("H:i:s");
    $estatus = 'Activo';
    $organizacion = ''; // Campo vacío por defecto
    $id_bind = ''; // Campo vacío por defecto

    try {
        
        // Verificar si el usuario ya existe en la tabla
        $verificaQuery = "SELECT COUNT(*) AS total FROM admin_tem WHERE usuario = ?";
        $resultadoVerifica = $conexion->consulta($verificaQuery, [$usuario]);

        if ($resultadoVerifica['resultado'][0]['total'] > 0) {
            $mensaje = "El usuario con el correo '$usuario' ya existe.";
            $accion = 'Error';
            include 'mensaje.php';
            exit();
        }

        // Consulta para insertar los datos
        $query = "
            INSERT INTO admin_tem (
                usuario_id, nombre, usuario, observaciones, horarios, 
                funcion, f_alta, h_alta, estatus, telefono, empresa_id, 
                especialidad, domicilio
            ) VALUES (
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
            )
        ";
    /*echo $query."<hr>".$usuario_id."<br>".$nombre."<br>".$usuario."<br>".$observaciones."<br>".$horarios,
    $funcion."<br>".$f_alta."<br>".$h_alta."<br>".$estatus."<br>".$celular."<br>".$empresa_id,
    $id_bind."<br>".$especialidad."<br>".$domicilio;*/


        // Ejecutar la consulta
        $resultado = $conexion->consulta_simple($query, [
            $usuario_id, $nombre, $usuario,  $observaciones, $horarios,
            $funcion, $f_alta, $h_alta, $estatus, $celular, $empresa_id,
            $especialidad, $domicilio
        ]);
    
        if (!$resultado) {
            throw new Exception("Error en la consulta SQL. Consulta: $query");
        }
    
        $mensaje = "Consulta ejecutada correctamente.";
        $accion = "Exito";
        include 'mensaje.php';
        exit();
    } catch (Exception $e) {
        // Manejar errores y registrar detalles
        $errorMsg = $e->getMessage();
        error_log("Error al guardar los datos: $errorMsg");
        error_log("Detalles de la consulta: " . json_encode([
            'usuario_id' => $usuario_id,
            'nombre' => $nombre,
            'usuario' => $usuario,
            'organizacion' => $organizacion,
            'observaciones' => $observaciones,
            'horarios' => $horarios,
            'funcion' => $funcion,
            'f_alta' => $f_alta,
            'h_alta' => $h_alta,
            'estatus' => $estatus,
            'telefono' => $celular,
            'empresa_id' => $empresa_id,
            'id_bind' => $id_bind,
            'especialidad' => $especialidad,
            'domicilio' => $domicilio,
        ]));
    
        $mensaje = "Error al guardar los datos. Por favor, inténtelo de nuevo más tarde.";
        $accion = "Error";
        include 'mensaje.php';
        exit();
    }
    
} else {
    // Si no se accede mediante POST
    $mensaje = "Método de solicitud no permitido.";
    $accion = "Error";
    include 'mensaje.php';
    exit();
}
?>
  
