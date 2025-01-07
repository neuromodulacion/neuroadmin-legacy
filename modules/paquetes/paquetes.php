<?php
$ruta = "../../";
require_once($ruta.'functions/conexion_mysqli.php');

// Incluir el archivo de configuración y obtener las credenciales
$configPath = $ruta.'../config.php';

if (!file_exists($configPath)) {
    die('Archivo de configuración no encontrado.');
}

$config = require $configPath;

// Crear una instancia de la clase Mysql
$mysql = new Mysql($config['servidor'], $config['usuario'], $config['contrasena'], $config['baseDatos']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Registrar o actualizar paquete
    $paquete_id = $_POST['paquete_id'] ?? null;
    $nombre_paquete = $_POST['nombre_paquete'] ?? null;
    $descripcion = $_POST['descripcion'] ?? null;
    $precio = $_POST['precio'] ?? null;
    $vigencia = $_POST['vigencia'] ?? null;
    $modulos = $_POST['modulos'] ?? []; // IDs de módulos asignados

    try {
        $mysql->comenzarTransaccion();

        if ($paquete_id) {
            // Actualizar paquete existente
            $query = "UPDATE paquetes SET nombre_paquete = ?, descripcion = ?, precio = ?, vigencia = ? WHERE paquete_id = ?";
            $mysql->consulta_simple($query, [$nombre_paquete, $descripcion, $precio, $vigencia, $paquete_id]);

            // Eliminar las relaciones actuales del paquete
            $mysql->consulta_simple("DELETE FROM paquete_modulo WHERE paquete_id = ?", [$paquete_id]);
        } else {
            // Insertar nuevo paquete
            $query = "INSERT INTO paquetes (nombre_paquete, descripcion, precio, vigencia) VALUES (?, ?, ?, ?)";
            $paquete_id = $mysql->insertar($query, [$nombre_paquete, $descripcion, $precio, $vigencia]);
        }

        // Insertar nuevas relaciones de módulos
        foreach ($modulos as $modulo_id) {
            $queryRelacion = "INSERT INTO paquete_modulo (paquete_id, modulo_id) VALUES (?, ?)";
            $mysql->consulta_simple($queryRelacion, [$paquete_id, $modulo_id]);
        }

        $mysql->confirmarTransaccion();
        echo "Paquete " . ($paquete_id ? "actualizado" : "registrado") . " correctamente.";
    } catch (Exception $e) {
        $mysql->revertirTransaccion();
        echo "Error: " . $e->getMessage();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Obtener paquetes con módulos asignados
    $query = "
        SELECT p.paquete_id, p.nombre_paquete, p.descripcion, p.precio, p.vigencia, m.modulo_id, m.nombre_modulo 
        FROM paquetes p
        LEFT JOIN paquete_modulo pm ON p.paquete_id = pm.paquete_id
        LEFT JOIN modulos m ON pm.modulo_id = m.modulo_id
        ORDER BY p.paquete_id, m.nombre_modulo";
    $result = $mysql->consulta($query);

    // Reestructurar el resultado para agrupar módulos bajo el paquete correspondiente
    $paquetes = [];
    foreach ($result['resultado'] as $row) {
        $paquete_id = $row['paquete_id'];
        if (!isset($paquetes[$paquete_id])) {
            $paquetes[$paquete_id] = [
                'paquete_id' => $paquete_id,
                'nombre_paquete' => $row['nombre_paquete'],
                'descripcion' => $row['descripcion'],
                'precio' => $row['precio'],
                'vigencia' => $row['vigencia'],
                'modulos' => [],
            ];
        }
        if ($row['modulo_id']) {
            $paquetes[$paquete_id]['modulos'][] = [
                'modulo_id' => $row['modulo_id'],
                'nombre_modulo' => $row['nombre_modulo'],
            ];
        }
    }

    header('Content-Type: application/json');
    echo json_encode(array_values($paquetes));
}
?>
