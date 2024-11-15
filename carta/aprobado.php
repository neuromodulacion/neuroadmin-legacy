<?php
// Puedes obtener información del pago si lo deseas
$payment_id = $_GET['payment_id'];
$status = $_GET['status'];
$payment_type = $_GET['payment_type'];
$external_reference = $_GET['external_reference'];
$merchant_order_id = $_GET['merchant_order_id'];

// Opcional: Procesa la información del pago y guárdala en tu base de datos

// Redirigir a index.php después de un breve mensaje
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pago Exitoso</title>
    <meta http-equiv="refresh" content="5;url=index.php">
</head>
<body>
    <h1>¡Pago exitoso!</h1>
    <p>Gracias por tu pago. Serás redirigido en breve.</p>
    <p>Si no eres redirigido automáticamente, haz clic <a href="index.php">aquí</a>.</p>
</body>
</html>
