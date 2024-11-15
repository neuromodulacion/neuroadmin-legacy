<?php
// Habilitar la visualización de todos los errores para el desarrollo
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Configuración de codificación y localización
iconv_set_encoding('internal_encoding', 'utf-8'); 
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');

// Separador visual para el inicio del script
echo "<hr>";

// Incluir las funciones necesarias para la conexión a la base de datos MySQL
include('../functions/funciones_mysql.php');

// Función para actualizar un cliente en la base de datos local usando la API de Bind
function actualiza_cliente($ID){
    // URL del API de Bind para obtener los datos del cliente
    $url = 'https://api.bind.com.mx/api/Clients/' . $ID;
    $curl = curl_init($url);

    // Llave de suscripción y token de autorización
    $key = "neuromodulaciongdl";
    $authorization = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1bmlxdWVfbmFtZSI6Imxlb25hcmRvIHNhbnp8MTI3NzkyIiwiSW50ZXJuYWxJRCI6ImUzNzM4OWVkLTdmM2EtNDM0OS1iMmNmLTU3YTZmMDdjZDEwZCIsIm5iZiI6MTcxMzU0NTY3MiwiZXhwIjoxNzQ1MDgxNjcyLCJpYXQiOjE3MTM1NDU2NzIsImlzcyI6Ik1pbm50X1NvbHV0aW9uc19TQV9ERV9DViIsImF1ZCI6IkJpbmRfRVJQX0FQSV9Vc2VycyJ9.lA7OgjBx9QDh6dwMGkYeKdCa4eNTFlx7wtPy3gF7M_E";
    
    // Configuración de los encabezados para la solicitud HTTP
    $headers = array(
        'Content-Type: application/json', 
        'Cache-Control: no-cache', 
        'Ocp-Apim-Subscription-Key: '.$key, 
        'Authorization: Bearer '.$authorization
    );
    
    // Configuración de la solicitud cURL
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET"); // Método GET para obtener los datos del cliente
    curl_setopt($curl, CURLOPT_URL, $url); // URL de la API
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Devolver el resultado como string
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers); // Añadir los encabezados

    // Ejecutar la solicitud cURL y obtener la respuesta
    $resp = curl_exec($curl);
    
    // Verificar si hubo un error en la solicitud cURL
    if (curl_errno($curl)) {
        echo 'Error de cURL: ' . curl_error($curl);
        return; // Salir de la función en caso de error
    }

    // Cerrar la conexión cURL
    curl_close($curl);

    // Decodificar la respuesta JSON a un array asociativo
    $data = json_decode($resp, true);
    if ($data === null) {
        echo "Error en la decodificación JSON: " . json_last_error_msg();
        return; // Salir de la función en caso de error
    }

    // Almacenar los valores obtenidos de la API en variables
    $ID = $data['ID'];
    $RFC = $data['RFC'];
    $LegalName = $data['LegalName'];
    $CommercialName = $data['CommercialName'];
    $CreditDays = $data['CreditDays'];
    $CreditAmount = $data['CreditAmount'];
    $PaymentMethod = $data['PaymentMethod'];
    $CreationDate = $data['CreationDate'];
    $Status = $data['Status'];
    $SalesContact = $data['SalesContact'];
    $CreditContact = $data['CreditContact'];
    $Loctaion = $data['Loctaion'];
    $LoctaionID = $data['LoctaionID'];
    $Comments = $data['Comments'];
    $PriceList = $data['PriceList'];
    $PriceListID = $data['PriceListID'];
    $PaymentTermType = $data['PaymentTermType'];
    $Email = $data['Email'];
    $Telephones = $data['Telephones'];
    $Number = $data['Number'];
    $AccountNumber = $data['AccountNumber'];
    $DefaultDiscount = $data['DefaultDiscount'];
    $ClientSource = $data['ClientSource'];
    $Account = $data['Account'];
    $City = $data['City'];
    $State = $data['State'];
    $Addresses = implode(", ", $data['Addresses']); // Convertir el array de direcciones en una cadena
    $RegimenFiscal = $data['RegimenFiscal'];
    // Agregar las otras variables aquí según sea necesario...

    // Consulta SQL para actualizar los datos del cliente en la base de datos local
    $update = "	    
        UPDATE pacientes_bind 
        SET CreditDays = '$CreditDays',
            CreditAmount = '$CreditAmount',
            PaymentMethod = '$PaymentMethod',
            STATUS = '$Status',
            SalesContact = '$SalesContact',
            Loctaion = '$Loctaion',
            Comments = '$Comments',
            PriceList = '$PaymentTermType',
            PriceListID = 'f7929bd7-a45b-4eef-b272-78bd36261754',
            Email = '$Email',
            Phone = '$Telephones',
            AccountNumber = '$AccountNumber',
            DefaultDiscount = '$DefaultDiscount',
            Account = '$Account',
            City = '$State',
            State = 'Aguascalientes',
            Addresses = '$Addresses' 
        WHERE ID = '$ID';
    ";
    
    // Mostrar la consulta de actualización
    echo "<hr>" . $update . "<hr>";
    
    // Ejecutar la consulta de actualización en la base de datos
    $result_update = ejecutar($update);			
}

// Consulta SQL para obtener clientes sin lista de precios asignada
$sql_protocolo = "
SELECT
	pacientes_bind.ID, 
	pacientes_bind.PriceListID
FROM
	pacientes_bind
WHERE
	pacientes_bind.PriceListID = ''
LIMIT 40	
";

// Ejecutar la consulta y obtener los resultados
$result_protocolo = ejecutar($sql_protocolo); 

// Iterar sobre los resultados y actualizar cada cliente usando la función anterior
while ($row_protocolo = mysqli_fetch_array($result_protocolo)) {
    extract($row_protocolo);
    actualiza_cliente($ID);
}
?>
