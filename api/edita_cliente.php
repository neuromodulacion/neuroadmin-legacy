<?php
// Incluir archivos necesarios para funciones de MySQL y API
include('../functions/funciones_mysql.php');
include('funciones_api.php');

// Iniciar sesión y configurar opciones de error y codificación
session_start();
error_reporting(7);
iconv_set_encoding('internal_encoding', 'utf-8'); 
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Mazatlan');
setlocale(LC_TIME, 'es_ES.UTF-8');
$_SESSION['time'] = mktime();

// Consulta para obtener los datos de pacientes actualizados
$sql = "
    SELECT
        pacientes_bind.ID, 
        pacientes_bind.Number, 
        pacientes_bind.ClientName, 
        pacientes_bind.LegalName, 
        pacientes_bind.RFC, 
        pacientes_bind.Email, 
        pacientes_bind.Phone, 
        pacientes_bind.LocationID, 
        pacientes_bind.RegimenFiscal, 
        pacientes_bind.PriceListID, 
        pacientes_bind.Source, 
        pacientes_bind.`STATUS`, 
        pacientes_bind.actualizacion
    FROM
        pacientes_bind
    WHERE
        pacientes_bind.Source = 'Actualizado'
";

// Ejecutar la consulta SQL y obtener resultados
echo $sql."<hr>";	
$result_insert = ejecutar($sql);
$cnt = mysqli_num_rows($result_insert);

echo "<b>Registros: ".$cnt."</b><br>".$ID."<hr>";

while ($row = mysqli_fetch_array($result_insert)) {
    extract($row);
    echo "<h1>Cliente</h1><hr>".$ID."<hr>";
    
    // Validar y establecer valores predeterminados para RegimenFiscal, Email y Phone
    if ($RegimenFiscal == '') { 
        $RegimenFiscal = '616'; 
    }

    if (empty($Email) || $Email == 'no@no.com' || $Email == 'no@aplica.com') {
        $Email = "remisiones_bind@neuromodulaciongdl.com";
    } else {
        // Validar que no tenga espacios intermedios
        $Email = validarSinEspacios($Email); 
    }
    
    if (empty($Phone) || $Phone == "3333333333") {
        $Phone = "";
    } else {
        // Validar que no tenga espacios intermedios
        $Phone = validarSinEspacios($Phone);
    }    
    
    // Cuerpo de la solicitud con los datos del cliente para la API de Bind
    $request_body = '{
        "ID": "'.$ID.'",
        "RFC": "'.$RFC.'",
        "LegalName": "'.$LegalName.'",
        "CommercialName": "'.$ClientName.'",
        "CreditDays": 0,
        "CreditAmount": 0.0000,
        "PriceListID": "1c47a12f-2719-4315-9bf9-18ad44817679",
        "PaymentMethod": 0,
        "PaymentTerm": 0,
        "LocationID": "",
        "SalesEmployeeID": "3bdd78d1-cfbd-4760-96ab-4a0da91e501d",
        "Email": "'.$Email.'",
        "Telephones": "'.$Phone.'",
        "AccountingNumber": "105-03-001",
        "DefaultDiscount": 0,
        "RegimenFiscal": "'.$RegimenFiscal.'"
    }';
    echo $request_body."<hr>";
    
    // URL del API de Bind para modificar cliente
    $url = "https://api.bind.com.mx/api/Clients";
    
    // Llave de suscripción y token de autorización
    $key = "neuromodulaciongdl";
    $authorization = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1bmlxdWVfbmFtZSI6Imxlb25hcmRvIHNhbnp8MTI3NzkyIiwiSW50ZXJuYWxJRCI6ImUzNzM4OWVkLTdmM2EtNDM0OS1iMmNmLTU3YTZmMDdjZDEwZCIsIm5iZiI6MTcxMzU0NTY3MiwiZXhwIjoxNzQ1MDgxNjcyLCJpYXQiOjE3MTM1NDU2NzIsImlzcyI6Ik1pbm50X1NvbHV0aW9uc19TQV9ERV9DViIsImF1ZCI6IkJpbmRfRVJQX0FQSV9Vc2VycyJ9.lA7OgjBx9QDh6dwMGkYeKdCa4eNTFlx7wtPy3gF7M_E";
    
    // Configuración de la solicitud cURL para la API de Bind
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
    // Encabezados para la solicitud HTTP
    $headers = array(
        'Content-Type: application/json', 
        'Cache-Control: no-cache', 
        'Ocp-Apim-Subscription-Key: '.$key, 
        'Authorization: Bearer '.$authorization,
        'Content-Length: ' . strlen($request_body) // Añade esta línea para Content-Length
    );
    
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $request_body);
    
    // Ejecutar la solicitud cURL y mostrar la respuesta
    $resp = curl_exec($curl);
    curl_close($curl);
    var_dump($resp);
    
    // Actualizar la base de datos con la información enviada a la API
    $update = "	    
        UPDATE pacientes_bind 
        SET 
            `LocationID` = '',
            Email = '$Email',
            Phone = '$Phone',
            RegimenFiscal = '$RegimenFiscal',
            Source = 'Actualizado 12 ago'
        WHERE ID = '$ID';
    ";		
    echo "<hr>" . $update . "<hr>";
    $result_update = ejecutar($update);			
    
    echo "<h1>Concluido</h1><hr>";
    
    // Código de la transacción
	usleep(500000); // Pausa de 0.5 segundos (500,000 microsegundos)
    
}
?>
