<?php
session_start();

// Verificar si el script está recibiendo la solicitud POST correctamente
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['timezone'])) {
        $timezone = $data['timezone'];
        date_default_timezone_set($timezone);
        $_SESSION['timezone'] = $timezone;

        echo json_encode(['status' => 'success', 'timezone' => $timezone]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No timezone provided']);
    }
} else {
    // Si el método no es POST, devolver un mensaje de error
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>

