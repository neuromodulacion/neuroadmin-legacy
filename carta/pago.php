<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Incluir el autoload de Composer o el SDK manualmente
require __DIR__ . '/../vendor/autoload.php'; // Ajusta la ruta si es necesario

// Agrega tus credenciales
MercadoPago\SDK::setAccessToken('dev_24c65fb163bf11ea96500242ac130004'); // Reemplaza con tu Access Token

// Crea una preferencia de pago
$preference = new MercadoPago\Preference();

// Crea un ítem en la preferencia
$item = new MercadoPago\Item();
$item->title = 'Pago de Servicio';
$item->quantity = 1;
$item->unit_price = 1000.00; // Monto en MXN

$preference->items = array($item);

// URLs de retorno
$preference->back_urls = array(
    "success" => "https://tu-dominio.com/aprobado.php",
    "failure" => "https://tu-dominio.com/error.php",
    "pending" => "https://tu-dominio.com/pendiente.php"
);
$preference->auto_return = "approved";

// Guarda la preferencia
$preference->save();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pagar con Mercado Pago</title>
</head>
<body>
    <h1>Pagar $1,000 MXN</h1>
    <!-- Botón de pago -->
    <a href="<?php echo $preference->init_point; ?>" target="_blank">Pagar con Mercado Pago</a>
</body>
</html>
