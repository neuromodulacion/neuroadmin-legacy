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

// Incluir el archivo con la clase Mysql o las funciones necesarias para la conexión a la base de datos
include('../functions/conexion_mysqli.php'); // Asegúrate de que este archivo contiene la instancia $mysql
$ruta = "../";
// Incluir el archivo de configuración y obtener las credenciales
$configPath = $ruta.'../config.php';

if (!file_exists($configPath)) {
    die('Archivo de configuración no encontrado.');
}

$config = require $configPath;

// Crear instancia de la clase Mysql
$mysql = new Mysql($config['servidor'], $config['usuario'], $config['contrasena'], $config['baseDatos']);

// Función auxiliar para sanitizar valores y evitar pasar null a htmlspecialchars()
function sanitizarValor($valor) {
    return htmlspecialchars($valor ?? '', ENT_QUOTES, 'UTF-8');
}

// Función para validar y limpiar entradas sin espacios
function validarSinEspacio($input) {
    $input = $input ?? ''; // Asignar cadena vacía si es null
    $input = trim($input); // Eliminar espacios al inicio y al final
    $input = str_replace(' ', '', $input); // Eliminar todos los espacios
    return $input;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir y limpiar datos del formulario
    $usuario_id = isset($_POST['usuario_id']) ? intval($_POST['usuario_id']) : 0;
    $nombre = isset($_POST['nombre']) ? sanitizarValor($_POST['nombre']) : '';
    $usuario = isset($_POST['usuario']) ? validarSinEspacio($_POST['usuario']) : '';
    $telefono = isset($_POST['telefono']) ? validarSinEspacio($_POST['telefono']) : '';
    $observaciones = isset($_POST['observaciones']) ? sanitizarValor($_POST['observaciones']) : '';
    $especialidad = isset($_POST['especialidad']) ? sanitizarValor($_POST['especialidad']) : '';
    $horarios = isset($_POST['horarios']) ? sanitizarValor($_POST['horarios']) : '';
    $estatus = isset($_POST['estatus']) ? sanitizarValor($_POST['estatus']) : '';
    $cedula = isset($_POST['cedula']) ? validarSinEspacio($_POST['cedula']) : '';
    // Validar datos requeridos
    if ($usuario_id <= 0) {
        die('ID de usuario inválido.');
    }

    try {
        // Iniciar una transacción
        $mysql->comenzarTransaccion();
    
        // Query para actualizar la tabla admin
        $sql_update_admin = "
            UPDATE admin 
            SET 
                nombre = ?,
                usuario = ?,
                telefono = ?,
                observaciones = ?,
                especialidad = ?,
                horarios = ?,
                estatus = ? 
            WHERE usuario_id = ?
        ";
    
        // Parámetros para la actualización en admin
        $params_admin = [
            $nombre,
            $usuario,
            $telefono,
            $observaciones,
            $especialidad,
            $horarios,
            $estatus,
            $usuario_id
        ];
    
        // Ejecutar la actualización en admin
        $resultado_update_admin = $mysql->actualizar($sql_update_admin, $params_admin);
    
        // Query para actualizar o insertar en la tabla cedulas
        $sql_update_cedula = "
            UPDATE cedulas 
            SET 
                cedula = ?, 
                principal = 'si' 
            WHERE usuario_id = ?
        ";
    
        // Parámetros para la actualización en cedulas
        $params_cedula = [
            $cedula,
            $usuario_id
        ];
    
        // Ejecutar la actualización en cedulas
        $resultado_update_cedula = $mysql->actualizar($sql_update_cedula, $params_cedula);
    
        // Confirmar la transacción si ambas consultas se ejecutaron correctamente
        $mysql->confirmarTransaccion();
    
        // Verificar si hubo cambios en alguna de las dos consultas
        if ($resultado_update_admin >= 0 || $resultado_update_cedula >= 0) {
            echo "Registro actualizado con éxito.";
        } else {
            echo "No se realizaron cambios en los registros.";
        }
    } catch (Exception $e) {
        // Revertir cambios en caso de error
        $mysql->revertirTransaccion();
        
        // Registrar error y mostrar mensaje
        error_log($e->getMessage());
        echo "Hubo un error al actualizar los datos.";
    }
    
}
?>
