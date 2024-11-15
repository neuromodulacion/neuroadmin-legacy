
<?php
// Incluir el autoload de Composer o el SDK manualmente
require __DIR__ . '/../vendor/autoload.php'; // Ajusta la ruta si es necesario


  use MercadoPago\Client\Payment\PreferenceClient;
  use MercadoPago\MercadoPagoConfig;


  MercadoPagoConfig::setAccessToken("dev_24c65fb163bf11ea96500242ac130004");

  $client = new PreferenceClient();
  $request_options = new MPRequestOptions();
  $request_options->setCustomHeaders(["X-Idempotency-Key: <SOME_UNIQUE_VALUE>"]);

  $preference = $client->create([
    "items"=> array(
      array(
        "title" => "My product",
        "quantity" => 1,
        "unit_price" => 2000
      )
    ),
    false
  ]);
  echo implode($payment);
?>
 
<html>
<head>
    <script src="https://sdk.mercadopago.com/js/v2">
    </script>
</head>
<body>
    <div id="wallet_container">
    </div>
    <script>
      const mp = new MercadoPago('YOUR_PUBLIC_KEY', {
        locale: 'es-MX'
      });

      mp.bricks().create("wallet", "wallet_container", {
        initialization: {
            preferenceId: "<PREFERENCE_ID>",
        },
      });
  </script>
</body>
</html>
        


       