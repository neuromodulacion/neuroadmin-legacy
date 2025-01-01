<?php
require __DIR__ . '/../vendor/autoload.php';

use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\MercadoPagoConfig;

// Configura tu Access Token
MercadoPagoConfig::setAccessToken("APP_USR-484555813626005-081211-94ec958f8f21caec85d9eafc503bdec0-70524605");

// Verificar si la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decodificar el JSON recibido
    $input = json_decode(file_get_contents('php://input'), true);

    // Validar que se haya podido decodificar el JSON
    if (json_last_error() !== JSON_ERROR_NONE) {
        header('Content-Type: application/json');
        http_response_code(400); // Bad Request
        echo json_encode(["error" => "Formato JSON inválido"]);
        exit;
    }

    // Validar si los campos requeridos existen en el payload
    $requiredFields = ['token', 'issuer_id', 'payment_method_id', 'transaction_amount', 'installments', 'payer'];

    foreach ($requiredFields as $field) {
        if (!isset($input[$field])) { // Validar existencia del campo
            header('Content-Type: application/json');
            http_response_code(400); // Bad Request
            echo json_encode(["error" => "Falta el campo requerido: $field"]);
            exit;
        }
    }

    try {
        $client = new PaymentClient();

        // Crear el pago con los datos recibidos
        $payment = $client->create([
            "token" => $input['token'],
            "issuer_id" => $input['issuer_id'],
            "payment_method_id" => $input['payment_method_id'], // Asegúrate de usar el nombre correcto
            "transaction_amount" => (float)$input['transaction_amount'],
            "installments" => $input['installments'],
            "payer" => $input['payer'], // Usar directamente el objeto "payer"
        ]);

        // Responder con el resultado del pago
        header('Content-Type: application/json');
        echo json_encode($payment);

    } catch (Exception $e) {
        // Manejar errores
        header('Content-Type: application/json');
        http_response_code(500); // Internal Server Error
        echo json_encode(["error" => $e->getMessage()]);
    }
} else {
    // Si no es una solicitud POST
    header('Content-Type: application/json');
    http_response_code(405); // Method Not Allowed
    echo json_encode(["error" => "Solo se permiten solicitudes POST"]);
}
?>