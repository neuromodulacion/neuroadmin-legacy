<?php
// Iniciar sesión para acceso a variables de sesión
session_start();
error_reporting(E_ALL);

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

// Usar el espacio de nombres de PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Función para generar una contraseña aleatoria
function generateRandomPassword($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ*-+%#';
    $password = '';

    for ($i = 0; $i < $length; $i++) {
        $randomIndex = random_int(0, strlen($characters) - 1); // Usar random_int
        $password .= $characters[$randomIndex];
    }

    return $password;
}


// Verificar el método de solicitud
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si se recibió el usuario_idx
    $usuario_idx = isset($_POST['usuario_idx']) ? intval($_POST['usuario_idx']) : 0;

    if ($usuario_idx === 0) {
        echo "ID de usuario no válido.";
        exit();
    }

    try {
        // Obtener los datos del usuario desde admin_tem
        $querySelect = "
            SELECT
                admin_tem.medico_id, 
                admin_tem.nombre, 
                admin_tem.usuario, 
                admin_tem.observaciones, 
                admin_tem.horarios, 
                admin_tem.funcion, 
                admin_tem.f_alta, 
                admin_tem.h_alta, 
                admin_tem.estatus, 
                admin_tem.telefono, 
                admin_tem.empresa_id, 
                admin_tem.especialidad, 
                admin_tem.domicilio
            FROM
                admin_tem
            WHERE
                admin_tem.medico_id = ?
        ";

        $resultado = $conexion->consulta($querySelect, [$usuario_idx]);

        if ($resultado['numFilas'] === 0) {
            echo "Usuario no encontrado.";
            exit();
        }

        // Extraer los datos del usuario
        $datos = $resultado['resultado'][0];

        // Insertar los datos en la tabla admin
        $queryInsert = "
            INSERT INTO admin (
                 nombre, usuario, observaciones, horarios,pwd,funcion_id, funcion, 
                f_alta, h_alta, estatus, telefono, empresa_id, especialidad
            )
            VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ";

        $conexion->consulta_simple($queryInsert, [
            $datos['nombre'],
            $datos['usuario'],
            $datos['observaciones'],
            $datos['horarios'],
            generateRandomPassword(),
            '4',
            $datos['funcion'],
            $datos['f_alta'],
            $datos['h_alta'],
            'Activo',
            $datos['telefono'],
            $datos['empresa_id'],
            $datos['especialidad']
        ]);

        // Actualizar el estatus y el campo transferido en admin_tem
        $queryUpdate = "
            UPDATE admin_tem
            SET estatus = 'transferido', transferido = 'SI'
            WHERE medico_id = ?
        ";

        $conexion->consulta_simple($queryUpdate, [$usuario_idx]);

        echo "Usuario transferido correctamente.";
    } catch (Exception $e) {
        // Registrar errores en el log y devolver mensaje genérico al cliente
        error_log("Error al transferir usuario: " . $e->getMessage());
        echo "Ocurrió un error al transferir el usuario. Por favor, inténtelo más tarde.";
    }
} else {
    echo "Método de solicitud no permitido.";
}
?>
