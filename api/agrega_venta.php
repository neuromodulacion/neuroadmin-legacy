<?php

//pagina de pruebas

$key = "neuromodulaciongdl";
$authorization = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1bmlxdWVfbmFtZSI6Imxlb25hcmRvIHNhbnp8MTI3NzkyIiwiSW50ZXJuYWxJRCI6ImUzNzM4OWVkLTdmM2EtNDM0OS1iMmNmLTU3YTZmMDdjZDEwZCIsIm5iZiI6MTcxMzU0NTY3MiwiZXhwIjoxNzQ1MDgxNjcyLCJpYXQiOjE3MTM1NDU2NzIsImlzcyI6Ik1pbm50X1NvbHV0aW9uc19TQV9ERV9DViIsImF1ZCI6IkJpbmRfRVJQX0FQSV9Vc2VycyJ9.lA7OgjBx9QDh6dwMGkYeKdCa4eNTFlx7wtPy3gF7M_E";	

# Request headers
$headers = array(
'Content-Type: application/json', 
'Cache-Control: no-cache', 
'Ocp-Apim-Subscription-Key: '.$key.'', 
'Authorization: Bearer '.$authorization.'');

$url = "https://api.bind.com.mx/api/Invoices";
$curl = curl_init($url);

curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);


// WarehouseID son el almaces o sucursal

// $WarehouseID  ="807a4560-f643-4c1c-94e1-c6871c018b1f"; // prueba
$WarehouseID ="affa8228-2347-4cc3-92a1-547633ba7bf2"; // alejandro aldana
// $WarehouseID ="7bd33fc1-9fc2-40a5-93d9-0da551c4408e"; // Neuromodulacion

// $LocationID = "a790a1c9-fef8-47d7-8add-15a0089fe86c"; // prueba
$LocationID = "b644ac68-663a-45fe-875e-fa4aee3f77c9"; // alejandro aldana
// $LocationID = "5110f104-2530-4727-9edb-cb3d172c8b1d"; // Neuromodulacion
/************************************************************************************/

// Almacenes  =  WarehouseID = ID
 		// {
            // "ID": "7bd33fc1-9fc2-40a5-93d9-0da551c4408e",
            // "Name": "Matriz",
            // "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            // "AvailableInOtherLoc": false
        // },
        // {
            // "ID": "affa8228-2347-4cc3-92a1-547633ba7bf2",
            // "Name": "JESUS ALEJANDRO ALDANA LOPEZ",
            // "LocationID": "b644ac68-663a-45fe-875e-fa4aee3f77c9",
            // "AvailableInOtherLoc": false
        // },
        // {
            // "ID": "807a4560-f643-4c1c-94e1-c6871c018b1f",
            // "Name": "PRUEBA",
            // "LocationID": "a790a1c9-fef8-47d7-8add-15a0089fe86c",
            // "AvailableInOtherLoc": false
        // }
        


// clientes

//$ClientID = "aea94e0f-f8c8-47fa-a2a5-aa7fca5dede0";  //JUAN CARLOS PEREZ cliente prueba
$ClientID = "b42a09ea-7230-4de0-8e9f-75b06b0f13f1";  //Abel de Jesús Aguilar Castañeda cliente prueba
/************************************************************************************/
$fecha = date('Y-m-d\TH:i:s');
echo $fecha; 
echo "<hr>";
$CurrencyID = "b7e2c065-bd52-40ca-b508-3accdd538860"; // esta presente en todo creo que es nuestro ID

// listas de precios

$PriceListID = "1c47a12f-2719-4315-9bf9-18ad44817679"; // CONSULTAS
//$PriceListID = "f7929bd7-a45b-4eef-b272-78bd36261754"; // TMS - TDCS

// comentarios
$Comments = "prueba de facturacion";

$Emails = "admin@neuromodulaciongdl.com";

/****************************************************************/
// servicios
$ID = "bdc8e887-40d5-4051-bed5-e15bcc348f2f";
$Title = "CONSULTA MEDICA EN SEGUIMIENTO TRATAMIENTO ESTIMULACIÓN MAGNETICA TRANSCRANEAL";
$Description = "CONSULTA MEDICA EN SEGUIMIENTO A TRATAMIENTO DE TMS 1";
$Price = "1.0";
$Qty = "1"; // cantidad
/****************************************************************/ 
            
# Request body
$request_body = '{
    "CurrencyID": "'.$CurrencyID.'",
    "ClientID": "'.$ClientID.'",
    "LocationID": "'.$LocationID.'",
    "WarehouseID": "'.$WarehouseID.'",
    "CFDIUse": 3,
    "InvoiceDate": "'.$fecha.'",
    "PriceListID": "'.$PriceListID.'",
    "ExchangeRate": 1.0000,
    "ISRRetRate": 0.0000,
    "VATRetRate": 0.0000,
    "Comments": "'.$Comments.'",
    "VATRate": 0.0000,
    "DiscountType": 0,
    "DiscountAmount": 0,
    "Services": [{
        "ID": "'.$ID.'",
        "Title": "'.$Title.'",
        "Price": '.$Price.',
        "Qty": '.$Qty.',
        "VAT": 0,
        "Comments": "'.$Description.'"
    }],
    "Emails": ["'.$Emails.'"],
    "PurchaseOrder": null,
    "CreditDays": 0,
    "IsFiscalInvoice": false,
    "ShowIEPS": true,
    "Number": 0,
    "Account": "105-03-001",
    "Serie": "",
    "Reference": "",
    "PaymentTerm": 0
}';

// echo $request_body;

curl_setopt($curl, CURLOPT_POSTFIELDS, $request_body);

$resp = curl_exec($curl);
curl_close($curl);
//var_dump($resp);


//echo $request_body."<hr>";
$InvoiceID = trim($resp, '"');
echo $InvoiceID;
echo "<hr>";
/**************************************************************************************************/
$fecha = date('Y-m-d\TH:i:s');

$url = "https://api.bind.com.mx/api/Invoices/Payment";
$curl = curl_init($url);

curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

/****************************************************************/ 
$AccountID = "00bf530b-a4d8-4859-b58d-8304b7f09eee"; // Banco prueba

            
# Request body
$request_body = '{
	"CurrencyID": "'.$CurrencyID.'",
    "InvoiceID": "'.$InvoiceID.'",
    "AccountID": "'.$AccountID.'",
    "Date": "'.$fecha.'",
    "Reference": "string",
    "Amount": 1,
    "PaymentTerm": 0,
    "Comments": "string",
    "ExchangeRate": 0,
    "ExchangeRateAccount": 0
}';

//echo $request_body."<hr>";
curl_setopt($curl, CURLOPT_POSTFIELDS, $request_body);

$resp = curl_exec($curl);
curl_close($curl);
//var_dump($resp);

$clabe = substr($InvoiceID, -8);
echo $clabe."<hr>";
$InvoiceID= '08650711-5de5-48ff-94e8-ee5866f05c23';
$ticket = '1721857385';
/**************************************************************************************************/
$fecha = date('Y-m-d\TH:i:s');

$url = "https://api.bind.com.mx/api/Invoices/{$InvoiceID}/pdf";

// URL de la API con el ID de la factura

$curl = curl_init($url);

// Configurar la solicitud cURL
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

// Ejecutar la solicitud cURL
$response = curl_exec($curl);

// Verificar si hubo algún error durante la ejecución de la solicitud
if (curl_errno($curl)) {
    echo 'Error:' . curl_error($curl);
    exit;
}

// Obtener el código de respuesta HTTP
$http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

// Cerrar la sesión cURL
curl_close($curl);

$fecha = date('YmdHis');
// Verificar el código de respuesta HTTP
if ($http_status == 200) {
    // Ruta donde se guardará el archivo en el servidor
    $file_path = 'pdf/'.$ticket.'.pdf'; // Reemplaza con la ruta correcta

    // Guardar el PDF en el servidor
    if (file_put_contents($file_path, $response)) {
        echo 'PDF guardado exitosamente en: ' . $file_path;
    } else {
        echo 'Error al guardar el PDF en el servidor.';
    }
} else {
    // Mostrar el código de respuesta HTTP y la respuesta completa para depuración
    echo 'Error: No se pudo obtener el PDF. Código de respuesta HTTP: ' . $http_status;
    echo 'Respuesta del servidor: ' . $response;
}

echo "<hr>";
$fecha = date('Y-m-d\TH:i:s');
echo $fecha; 
?>