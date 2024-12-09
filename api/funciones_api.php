<?php
error_reporting(7);
iconv_set_encoding('internal_encoding', 'utf-8');
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');


function validarSinEspacios($cadena) {
	$cadena = trim($cadena);
	$cadena = str_replace(' ', '', $cadena);
    return $cadena;
}

function agrega_cliente_bind($paciente_id) {
    // busca las contraseñas propias de la empresa
    $sql_key = "
    SELECT
        empresas.bind,
        empresas.`key`,
        empresas.authorization,
        empresas.CurrencyID,
        empresas.LocationID,
        empresas.empresa_id 
    FROM
        empresas
        INNER JOIN pacientes ON empresas.empresa_id = pacientes.empresa_id 
    WHERE
        pacientes.paciente_id = $paciente_id";
        $result_ke = ejecutar($sql_key);
        $row = mysqli_fetch_array($result_ke);
        extract($row);

	$sql = "
	SELECT
		pacientes.paciente_id,
		pacientes.usuario_id,
		pacientes.empresa_id,
		CONCAT( pacientes.paciente,' ', pacientes.apaterno,' ', pacientes.amaterno ) AS paciente,
		pacientes.email,
		pacientes.celular
	FROM
		pacientes
	WHERE
		paciente_id =$paciente_id";
	$result_insert = ejecutar($sql);
	$cnt = mysqli_num_rows($result_insert);
	$row = mysqli_fetch_array($result_insert);
	extract($row);
	//print_r($row);

	// echo "<hr>";

	$url = "https://api.bind.com.mx/api/Clients";
// Leonardo
	//$key = $key_bind "neuromodulaciongdl";
	//$authorization = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1bmlxdWVfbmFtZSI6Imxlb25hcmRvIHNhbnp8MTI3NzkyIiwiSW50ZXJuYWxJRCI6ImUzNzM4OWVkLTdmM2EtNDM0OS1iMmNmLTU3YTZmMDdjZDEwZCIsIm5iZiI6MTcxMzU0NTY3MiwiZXhwIjoxNzQ1MDgxNjcyLCJpYXQiOjE3MTM1NDU2NzIsImlzcyI6Ik1pbm50X1NvbHV0aW9uc19TQV9ERV9DViIsImF1ZCI6IkJpbmRfRVJQX0FQSV9Vc2VycyJ9.lA7OgjBx9QDh6dwMGkYeKdCa4eNTFlx7wtPy3gF7M_E";	
	$curl = curl_init($url);

	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

//N3ur0m0dul4c10ngdl

	# Request headers
	$headers = array('Content-Type: application/json', 'Cache-Control: no-cache', 'Ocp-Apim-Subscription-Key: '.$key.'', 'Authorization: Bearer '.$authorization.'');
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);


	$LocationID = ""; // Neuromodulacion
	$PriceListID = "f7929bd7-a45b-4eef-b272-78bd36261754"; // Tms


	// Validación y asignación del correo
	if (empty($email)) {
	    $email = "remisiones_bind@neuromodulaciongdl.com";
	} else {
	    // Remover espacios intermedios y convertir a minúsculas
	    $email = strtolower(validarSinEspacios($email));
	    
	    // Validar el formato del correo
	    if (!validarEmail($email)) {
	        // Si no es válido, asignar el correo predeterminado
	        $email = "remisiones_bind@neuromodulaciongdl.com";
	    }
	}
	
	if (empty($celular)) {
	    $celular = "";
	} else {
	    // Validar que no tenga espacios intermedios
	    $celular = validarSinEspacios($celular);
	}	
	
	# Request body
	$request_body = '
		{
		    "Email": "' . $email . '",
		    "RFC": "XAXX010101000",
		    "LegalName": "' . $paciente . '",
		    "CommercialName": "' . $paciente . '",
		    "Telephone": "' . $celular . '",	    
		    "CreditDays": 0,
		    "CreditAmount": 0.0,
		    "cuenta_contable": "110-001-000",
		    "AccountingNumber": "105-01-001",
		        "Address": {
		        "StreetName": "Av, Los Arcos",
		        "InteriorNumber": "",
		        "ExteriorNumber": "876",
		        "Colonia": "Jardines del Bosque",
		        "ZipCode": "44520",
		        "Localidad": "Guadalajara",
		        "City": "Guadalajara",
		        "State": "Jalisco"
		    },
		    "DefaultDiscount": 0,
		    "RegimenFiscal": "605",
		    "PriceListID": "' . $PriceListID . '",
		    "LocationID": "'.$LocationID.'"
		}';
		
	//echo $request_body."<hr>";	
		
	curl_setopt($curl, CURLOPT_POSTFIELDS, $request_body);

	$resp = curl_exec($curl);
	curl_close($curl);
	//var_dump($resp);

	//$response = '"683ad2ff-e871-419f-b335-eb4392eb16d7"';  // Ejemplo de respuesta recibida

	// Eliminar las comillas dobles del inicio y del final del string
	$id_bind = trim($resp, '"');

	
	// Debería mostrar algo asi: 683ad2ff-e871-419f-b335-eb4392eb16d7
	//echo $id_bind;
	
	$update = "
		UPDATE pacientes
		SET
			pacientes.id_bind = '$id_bind'
		WHERE 
			pacientes.paciente_id = $paciente_id
		";

	//echo "<hr>" . $update . "<hr>";
	$result_insert = ejecutar($update);
	
	actualiza_cliente($id_bind);
	
	
	if ($result_insert ==1) {
		$resultado = $id_bind; //"<b>Se guardo correctamente el PAciente en Bind ERP # $paciente_id - $paciente</b>";
	} else {
		$resultado = "<b>No se guardo el PAciente en Bind ERP # $paciente_id - $paciente</b>";
	}
	
	//echo $result_insert;
	return $resultado; 
}

function agrega_cliente_bind_consulta($paciente_cons_id) {

	$sql = "
	SELECT
		paciente_consultorio.paciente_cons_id, 
		paciente_consultorio.paciente_id, 
		paciente_consultorio.empresa_id, 
		CONCAT( paciente_consultorio.paciente,' ', paciente_consultorio.apaterno,' ', paciente_consultorio.amaterno ) AS paciente,		
		paciente_consultorio.email, 
		paciente_consultorio.celular,
		paciente_consultorio.medico
	FROM
		paciente_consultorio
	WHERE
		paciente_consultorio.paciente_cons_id = $paciente_cons_id
		limit 5
		";
		
	$result_insert = ejecutar($sql);
	$cnt = mysqli_num_rows($result_insert);
	$row = mysqli_fetch_array($result_insert);
	extract($row);
	//print_r($row);

	// echo "<hr>";

	$url = "https://api.bind.com.mx/api/Clients";
// Leonardo
	$key = "neuromodulaciongdl";
	$authorization = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1bmlxdWVfbmFtZSI6Imxlb25hcmRvIHNhbnp8MTI3NzkyIiwiSW50ZXJuYWxJRCI6ImUzNzM4OWVkLTdmM2EtNDM0OS1iMmNmLTU3YTZmMDdjZDEwZCIsIm5iZiI6MTcxMzU0NTY3MiwiZXhwIjoxNzQ1MDgxNjcyLCJpYXQiOjE3MTM1NDU2NzIsImlzcyI6Ik1pbm50X1NvbHV0aW9uc19TQV9ERV9DViIsImF1ZCI6IkJpbmRfRVJQX0FQSV9Vc2VycyJ9.lA7OgjBx9QDh6dwMGkYeKdCa4eNTFlx7wtPy3gF7M_E";	
	$curl = curl_init($url);

	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);


	switch ($medico) {
		case 'Dr Capacitacion':
			$LocationID = "a790a1c9-fef8-47d7-8add-15a0089fe86c";// PRUEBA
			$PriceListID = "1c47a12f-2719-4315-9bf9-18ad44817679"; // Consultas
			break;
		case 'Dr. Alejandro Aldana':
			$LocationID = "b644ac68-663a-45fe-875e-fa4aee3f77c9"; // ALDANA
			$PriceListID = "1c47a12f-2719-4315-9bf9-18ad44817679"; // Consultas
			break;
		case 'Dra. Eleonora Ocampo':
			$LocationID = "8be4576e-d656-4d5c-a845-ccc535b57bb6"; // Eleonora
			$PriceListID = "1c47a12f-2719-4315-9bf9-18ad44817679"; // Consultas
			break;
		default:
			$LocationID = "b644ac68-663a-45fe-875e-fa4aee3f77c9"; // ALDANA
			$PriceListID = "1c47a12f-2719-4315-9bf9-18ad44817679"; // Consultas		
			break;								
	}



	// Validación y asignación del correo
	if (empty($email)) {
	    $email = "remisiones_bind@neuromodulaciongdl.com";
	} else {
	    // Remover espacios intermedios y convertir a minúsculas
	    $email = strtolower(validarSinEspacios($email));
	    
	    // Validar el formato del correo
	    if (!validarEmail($email)) {
	        // Si no es válido, asignar el correo predeterminado
	        $email = "remisiones_bind@neuromodulaciongdl.com";
	    }
	}
	
	if (empty($celular)) {
	    $celular = "";
	} else {
	    // Validar que no tenga espacios intermedios
	    $celular = validarSinEspacios($celular);
	}	

	# Request headers
	$headers = array('Content-Type: application/json', 'Cache-Control: no-cache', 'Ocp-Apim-Subscription-Key: '.$key.'', 'Authorization: Bearer '.$authorization.'');
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

	# Request body
	$request_body = '
		{
		    "Email": "' . $email . '",
		    "RFC": "XAXX010101000",
		    "LegalName": "' . $paciente . '",
		    "CommercialName": "' . $paciente . '",
		    "Telephone": "' . $celular . '",		    
		    "CreditDays": 0,
		    "CreditAmount": 0.0,
		    "cuenta_contable": "110-001-000",
		    "AccountingNumber": "105-01-001",
		        "Address": {
		        "StreetName": "Av, Los Arcos",
		        "InteriorNumber": "",
		        "ExteriorNumber": "876",
		        "Colonia": "Jardines del Bosque",
		        "ZipCode": "44520",
		        "Localidad": "Guadalajara",
		        "City": "Guadalajara",
		        "State": "Jalisco"
		    },
		    "DefaultDiscount": 0,
		    "RegimenFiscal": "605",
		    "PriceListID": "' . $PriceListID . '",
		    "LocationID": "' . $LocationID . '"
		}';
	echo $request_body."<hr>";	
		
	curl_setopt($curl, CURLOPT_POSTFIELDS, $request_body);

	$resp = curl_exec($curl);
	curl_close($curl);
	//var_dump($resp);

	//$response = '"683ad2ff-e871-419f-b335-eb4392eb16d7"';  // Ejemplo de respuesta recibida

	// Eliminar las comillas dobles del inicio y del final del string
	$id_bind = trim($resp, '"');

	
	// Debería mostrar algo asi: 683ad2ff-e871-419f-b335-eb4392eb16d7
	//echo $id_bind;
	
		
	$update = "
		UPDATE paciente_consultorio
		SET
			paciente_consultorio.id_bind = '$id_bind',
			paciente_consultorio.email = '$email',
			paciente_consultorio.celular = '$celular'
			
		WHERE 
			paciente_consultorio.paciente_cons_id = $paciente_cons_id
		";
	$result_update=ejecutar($update);
	
	actualiza_cliente($id_bind);
	
	if ($result_insert ==1) {
		$resultado = $id_bind; // "<b>Se guardo correctamente el Paciente en Bind ERP # $paciente_id - $paciente</b>";
	} else {
		$resultado = "<b>No se guardo el Paciente en Bind ERP # $paciente_id - $paciente</b>";
	}
	
	//echo $result_insert;
	return $resultado; 
}

function modifica_cliente_bind_consulta($paciente_cons_id) {

    $sql = "
    SELECT
        paciente_consultorio.paciente_cons_id, 
        paciente_consultorio.paciente_id, 
        paciente_consultorio.empresa_id, 
        CONCAT(paciente_consultorio.paciente, ' ', paciente_consultorio.apaterno, ' ', paciente_consultorio.amaterno) AS paciente,        
        paciente_consultorio.email, 
        paciente_consultorio.celular,
        paciente_consultorio.id_bind
    FROM
        paciente_consultorio
    WHERE
        paciente_consultorio.paciente_cons_id = $paciente_cons_id";
        
    $result_insert = ejecutar($sql);
    $cnt = mysqli_num_rows($result_insert);
    $row = mysqli_fetch_array($result_insert);
    extract($row);
    //print_r($row);

    //echo "<hr>";

    $url = "https://api.bind.com.mx/api/Clients";
    $key = "neuromodulaciongdl";
    $authorization = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1bmlxdWVfbmFtZSI6Imxlb25hcmRvIHNhbnp8MTI3NzkyIiwiSW50ZXJuYWxJRCI6ImUzNzM4OWVkLTdmM2EtNDM0OS1iMmNmLTU3YTZmMDdjZDEwZCIsIm5iZiI6MTcxMzU0NTY3MiwiZXhwIjoxNzQ1MDgxNjcyLCJpYXQiOjE3MTM1NDU2NzIsImlzcyI6Ik1pbm50X1NvbHV0aW9uc19TQV9ERV9DViIsImF1ZCI6IkJpbmRfRVJQX0FQSV9Vc2VycyJ9.lA7OgjBx9QDh6dwMGkYeKdCa4eNTFlx7wtPy3gF7M_E";    
    $curl = curl_init($url);


	$celular = validarSinEspacios($celular);
	
	// Validación y asignación del correo
	if (empty($email)) {
	    $email = "remisiones_bind@neuromodulaciongdl.com";
	} else {
	    // Remover espacios intermedios y convertir a minúsculas
	    $email = strtolower(validarSinEspacios($email));
	    
	    // Validar el formato del correo
	    if (!validarEmail($email)) {
	        // Si no es válido, asignar el correo predeterminado
	        $email = "remisiones_bind@neuromodulaciongdl.com";
	    }
	}
	



    # Request body
    $request_body = json_encode(array(
        "ID" => $id_bind,
        "RFC" => "XAXX010101000",
        "LegalName" => $paciente,
        "CommercialName" => $paciente,
        "CreditDays" => 0,
        "CreditAmount" => 0.0000,
        "Status" => "Activo",
        "Loctaion" => "Matriz",
        "LoctaionID" => "",
        "Comments" => null,
        "PriceList" => "A",
        "PriceListID" => "f7929bd7-a45b-4eef-b272-78bd36261754",
        "Email" => $email,
        "Telephones" => $celular,
        "AccountingNumber" => "105-01-001",
        "Account" => "105-01-001 105-01-001",
        "RegimenFiscal" => "616"
    ));

    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $request_body);

    # Request headers
    $headers = array(
        'Content-Type: application/json',
        'Cache-Control: no-cache',
        'Ocp-Apim-Subscription-Key: ' . $key,
        'Authorization: Bearer ' . $authorization,
        'Content-Length: ' . strlen($request_body) // Añade esta línea
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

   //  echo $request_body . "<hr>";

    $resp = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    if ($httpCode == 200 || $httpCode == 204) {
        // Si la respuesta es 200 OK o 204 No Content, se considera éxito
        $resultado = $id_bind; //"<b>Se guardó correctamente el Paciente en Bind ERP # $paciente_id - $paciente</b>";
    } else {
        $resultado = "<b>No se guardó el Paciente en Bind ERP # $paciente_id - $paciente. Error: $resp HTTP Code: $httpCode</b>";
    }
	
	// echo "<h1>".$resultado."</h1>";
	return $resultado; 
}

function modifica_cliente_bind($paciente_id) {
/*
 * Consulta para obtener los datos del paciente: 
 *     Realiza una consulta a la base de datos para obtener los datos del paciente.
 * Ejecutar la consulta: 
 *     Ejecuta la consulta SQL y extrae los datos del paciente.
 * URL del API de Bind para modificar cliente: 
 *     La URL del endpoint de la API que se usará para modificar el cliente.
 * Llave de suscripción y token de autorización: 
 *     Se indican las variables que contienen la llave de suscripción y el token de autorización necesarios para realizar la solicitud.
 * Validar y limpiar email y celular: 
 *     Elimina espacios y valida el formato de los datos.
 * Cuerpo de la solicitud con los datos del cliente: 
 *     JSON con los datos necesarios para modificar el cliente.
 * Configuración de la solicitud cURL: 
 *     Configura los parámetros necesarios para la solicitud PUT.
 * Encabezados para la solicitud HTTP: 
 *     Se especifican los encabezados necesarios para la solicitud, incluyendo el tipo de contenido, las credenciales y la longitud del contenido.
 * Ejecutar la solicitud cURL: 
 *     Ejecuta la solicitud y guarda la respuesta.
 * Verificar el código de respuesta HTTP y establecer el resultado: 
 *     Comprueba si la respuesta fue exitosa (códigos 200 o 204) y establece un mensaje de resultado.
 * 
 * Modifica los datos del cliente en Bind
 */	
	
    // Consulta para obtener los datos del paciente
    $sql = "
    SELECT
        pacientes.paciente_id,
        pacientes.usuario_id,
        pacientes.empresa_id,
        CONCAT(pacientes.paciente,' ', pacientes.apaterno,' ', pacientes.amaterno) AS paciente,
        pacientes.email,
        pacientes.celular,
        pacientes.id_bind
    FROM
        pacientes
    WHERE
        paciente_id = $paciente_id";
    
    // Ejecutar la consulta
    $result_insert = ejecutar($sql);
    $cnt = mysqli_num_rows($result_insert);
    $row = mysqli_fetch_array($result_insert);
    extract($row);    

    // URL del API de Bind para modificar cliente
    $url = "https://api.bind.com.mx/api/Clients";
    // Llave de suscripción y token de autorización
    $key = "neuromodulaciongdl";
    $authorization = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1bmlxdWVfbmFtZSI6Imxlb25hcmRvIHNhbnp8MTI3NzkyIiwiSW50ZXJuYWxJRCI6ImUzNzM4OWVkLTdmM2EtNDM0OS1iMmNmLTU3YTZmMDdjZDEwZCIsIm5iZiI6MTcxMzU0NTY3MiwiZXhwIjoxNzQ1MDgxNjcyLCJpYXQiOjE3MTM1NDU2NzIsImlzcyI6Ik1pbm50X1NvbHV0aW9uc19TQV9ERV9DViIsImF1ZCI6IkJpbmRfRVJQX0FQSV9Vc2VycyJ9.lA7OgjBx9QDh6dwMGkYeKdCa4eNTFlx7wtPy3gF7M_E";    
    $curl = curl_init($url);

    // Validar y limpiar email y celular
	
	// Validación y asignación del correo
	if (empty($email)) {
	    $email = "remisiones_bind@neuromodulaciongdl.com";
	} else {
	    // Remover espacios intermedios y convertir a minúsculas
	    $email = strtolower(validarSinEspacios($email));
	    
	    // Validar el formato del correo
	    if (!validarEmail($email)) {
	        // Si no es válido, asignar el correo predeterminado
	        $email = "remisiones_bind@neuromodulaciongdl.com";
	    }
	}
    $celular = validarSinEspacios($celular);
    
    // Cuerpo de la solicitud con los datos del cliente
    $request_body = json_encode(array(
        "ID" => $id_bind,
        "RFC" => "XAXX010101000",
        "LegalName" => $paciente,
        "CommercialName" => $paciente,
        "CreditDays" => 0,
        "CreditAmount" => 0.0000,
        "Status" => "Activo",
        "Loctaion" => "Matriz",
        "LoctaionID" => "5110f104-2530-4727-9edb-cb3d172c8b1d",
        "Comments" => null,
        "PriceList" => "A",
        "PriceListID" => "f7929bd7-a45b-4eef-b272-78bd36261754",
        "Email" => $email,
        "Telephones" => $celular,
        "AccountingNumber" => "105-01-001",
        "Account" => "105-01-001 105-01-001",
        "RegimenFiscal" => "616"
    ));

    // Configuración de la solicitud cURL
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $request_body);

    // Encabezados para la solicitud HTTP
    $headers = array(
        'Content-Type: application/json',
        'Cache-Control: no-cache',
        'Ocp-Apim-Subscription-Key: ' . $key,
        'Authorization: Bearer ' . $authorization,
        'Content-Length: ' . strlen($request_body) // Añade esta línea
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

    // Ejecutar la solicitud cURL
    $resp = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    // Verificar el código de respuesta HTTP y establecer el resultado
    if ($httpCode == 200 || $httpCode == 204) {
        // Si la respuesta es 200 OK o 204 No Content, se considera éxito
        $resultado = "<b>Se guardó correctamente el Paciente en Bind ERP # $paciente_id - $paciente</b>";
    } else {
        $resultado = "<b>No se guardó el Paciente en Bind ERP # $paciente_id - $paciente. Error: $resp HTTP Code: $httpCode</b>";
    }
	
    // echo "<h1>".$resultado."</h1>";
}

function guarda_venta($CurrencyID, $ClientID, $LocationID, $WarehouseID, $PriceListID, $Comments, $uuid, $Title, $Price, $Qty, $Description, $Emails, $ticket, $PaymentTerm, $AccountID) {
/*
 * Llave de suscripción y token de autorización: 
 *     Se indican las variables que contienen la llave de suscripción y el token de autorización necesarios para realizar la solicitud.
 * Encabezados para la solicitud HTTP: 
 *     Se especifican los encabezados necesarios para la solicitud, incluyendo el tipo de contenido y las credenciales.
 * URL del API de facturación: 
 *     La URL del endpoint de la API que se usará para generar la factura.
 * Fecha de la factura en formato ISO 8601: 
 *     Se obtiene la fecha actual en el formato requerido.
 * Cuerpo de la solicitud con los datos de la venta: 
 *     JSON con los datos necesarios para realizar la venta.
 * Configuración de la solicitud cURL: 
 *     Configura los parámetros necesarios para la solicitud POST.
 * Ejecución de la solicitud cURL: 
 *     Ejecuta la solicitud y guarda la respuesta.
 * Manejo de errores cURL: 
 *     Comprueba si se produjo un error durante la ejecución de cURL.
 * Verificación del código de respuesta HTTP: 
 *     Obtiene el código de estado HTTP de la respuesta.
 * Cerrar la conexión cURL: 
 *     Cierra la sesión cURL.
 * Obtener el ID de la factura del API: 
 *     Extrae y guarda el ID de la factura de la respuesta de la API.
 * Actualizar la tabla de cobros con el ID de la factura: 
 *     Actualiza la base de datos con el ID de la factura.
 * Ejecutar la actualización en la base de datos: 
 *     Ejecuta la consulta SQL para actualizar la tabla de cobros.
 */
	
	
    // Llave de suscripción y token de autorización
    $key = "neuromodulaciongdl";
    $authorization = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1bmlxdWVfbmFtZSI6Imxlb25hcmRvIHNhbnp8MTI3NzkyIiwiSW50ZXJuYWxJRCI6ImUzNzM4OWVkLTdmM2EtNDM0OS1iMmNmLTU3YTZmMDdjZDEwZCIsIm5iZiI6MTcxMzU0NTY3MiwiZXhwIjoxNzQ1MDgxNjcyLCJpYXQiOjE3MTM1NDU2NzIsImlzcyI6Ik1pbm50X1NvbHV0aW9uc19TQV9ERV9DViIsImF1ZCI6IkJpbmRfRVJQX0FQSV9Vc2VycyJ9.lA7OgjBx9QDh6dwMGkYeKdCa4eNTFlx7wtPy3gF7M_E";    

    // Encabezados para la solicitud HTTP
    $headers = [
        'Content-Type: application/json',
        'Cache-Control: no-cache',
        'Ocp-Apim-Subscription-Key: ' . $key,
        'Authorization: Bearer ' . $authorization
    ];

    // URL del API de facturación
    $url = "https://api.bind.com.mx/api/Invoices";
    $curl = curl_init($url);

    // Fecha de la factura en formato ISO 8601
    $fecha = date('Y-m-d\TH:i:s');
   
    // Cuerpo de la solicitud con los datos de la venta
    $request_body = json_encode([
        "CurrencyID" => $CurrencyID,
        "ClientID" => $ClientID,
        "LocationID" => $LocationID,
        "WarehouseID" => $WarehouseID,
        "CFDIUse" => 12,
        "InvoiceDate" => $fecha,
        "PriceListID" => $PriceListID,
        "ExchangeRate" => 1.0000,
        "ISRRetRate" => 0.0000,
        "VATRetRate" => 0.0000,
        "Comments" => $Comments,
        "VATRate" => 0.0000,
        "DiscountType" => 0,
        "DiscountAmount" => 0,
        "Services" => [
            [
                "ID" => $uuid,
                "Title" => $Title,
                "Price" => $Price,
                "Qty" => $Qty,
                "VAT" => 0,
                "Comments" => $Description
            ]
        ],
        "Emails" => [$Emails],
        "PurchaseOrder" => null,
        "CreditDays" => 0,
        "IsFiscalInvoice" => false,
        "ShowIEPS" => true,
        "Number" => 0,
        "Account" => "105-03-001",
        
	    "Payments" =>  [
	    	[
		        "PaymentMethod" => $PaymentTerm,
		        "AccountID" => $AccountID,
		        "Amount" => $Price,
		        "Reference" => "",
		        "ExchangeRate" => 01,
		        "ExchangeRateAccount" => 0
	    	]
	    ],       
    
        "Serie" => "",
        "Reference" => "",
        "PaymentTerm" => $PaymentTerm
    ]);

    // Configuración de la solicitud cURL
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $request_body);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

    // Ejecución de la solicitud cURL
    $resp = curl_exec($curl);

	echo $request_body."<hr>";    
    
    // Manejo de errores cURL
    if (curl_errno($curl)) {
        echo 'Error cURL: ' . curl_error($curl);
        curl_close($curl);
        return;
    }

    // Verificación del código de respuesta HTTP
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    if ($httpCode != 200 && $httpCode != 201) {
        echo 'Error HTTP: ' . $httpCode . ' Respuesta: ' . $resp;
        curl_close($curl);
        return;
    }

    // Cerrar la conexión cURL
    curl_close($curl);

    // Obtener el ID de la factura del API
    $InvoiceID = trim($resp, '"');
    echo $InvoiceID . "<hr>";

    // Actualizar la tabla de cobros con el ID de la factura
    $update = "
        UPDATE cobros
        SET
            cobros.Invoice_ID = '$InvoiceID'
        WHERE 
            cobros.ticket = $ticket
    ";
    //echo $update . "<hr>";

    // Ejecutar la actualización en la base de datos
    $result_update = ejecutar($update);  
	
	// Devuelve el ID de la factura del API
	return $InvoiceID;  
}

function procesa_pago($CurrencyID, $InvoiceID, $AccountID, $Price, $PaymentTerm, $ticket) {
/*
 * Llave de suscripción y token de autorización: 
 *     Se indican las variables que contienen la llave de suscripción y el token de autorización necesarios para realizar la solicitud.
 * Encabezados para la solicitud HTTP: 
 *     Se especifican los encabezados necesarios para la solicitud, incluyendo el tipo de contenido y las credenciales.
 * Fecha actual en formato ISO 8601: 
 *     Se obtiene la fecha actual en el formato requerido.
 * URL del API para procesar el pago: 
 *     La URL del endpoint de la API que se usará para procesar el pago.
 * Configuración de la solicitud cURL: 
 *     Configura los parámetros necesarios para la solicitud POST.
 * Cuerpo de la solicitud con los datos del pago: 
 *     JSON con los datos necesarios para realizar el pago.
 * Asignar el cuerpo de la solicitud a cURL: 
 *     Añade el cuerpo JSON a la solicitud cURL.
 * Ejecutar la solicitud cURL: 
 *     Ejecuta la solicitud y guarda la respuesta.
 * Cerrar la conexión cURL: 
 *     Cierra la sesión cURL.
 * Devolver el ID de la factura procesada: 
 *     Retorna el ID de la factura procesada.
 */
	
    // Llave de suscripción y token de autorización
    $key = "neuromodulaciongdl";
    $authorization = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1bmlxdWVfbmFtZSI6Imxlb25hcmRvIHNhbnp8MTI3NzkyIiwiSW50ZXJuYWxJRCI6ImUzNzM4OWVkLTdmM2EtNDM0OS1iMmNmLTU3YTZmMDdjZDEwZCIsIm5iZiI6MTcxMzU0NTY3MiwiZXhwIjoxNzQ1MDgxNjcyLCJpYXQiOjE3MTM1NDU2NzIsImlzcyI6Ik1pbm50X1NvbHV0aW9uc19TQV9ERV9DViIsImF1ZCI6IkJpbmRfRVJQX0FQSV9Vc2VycyJ9.lA7OgjBx9QDh6dwMGkYeKdCa4eNTFlx7wtPy3gF7M_E";    

    // Encabezados para la solicitud HTTP
    $headers = [
        'Content-Type: application/json',
        'Cache-Control: no-cache',
        'Ocp-Apim-Subscription-Key: ' . $key,
        'Authorization: Bearer ' . $authorization
    ];

    // Fecha actual en formato ISO 8601
    $fecha = date('Y-m-d\TH:i:s');

    // URL del API para procesar el pago
    $url = "https://api.bind.com.mx/api/Invoices/Payment";
    $curl = curl_init($url);

    // Configuración de la solicitud cURL
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

    // Cuerpo de la solicitud con los datos del pago
    $request_body = json_encode([
        "CurrencyID" => $CurrencyID,
        "InvoiceID" => $InvoiceID,
        "AccountID" => $AccountID,
        "Date" => $fecha,
        "Reference" => "Ticket $ticket AdminNeuromodulación",
        "Amount" => $Price,
        "PaymentTerm" => $PaymentTerm,
        "Comments" => "Pago desde la aplicacion de Neuromodulacion ticket $ticket",
        "ExchangeRate" => 0,
        "ExchangeRateAccount" => 0
    ]);

    // Asignar el cuerpo de la solicitud a cURL
    curl_setopt($curl, CURLOPT_POSTFIELDS, $request_body);

    // Ejecutar la solicitud cURL
    $resp = curl_exec($curl);
    
	echo $request_body."<hr>";
    // Cerrar la conexión cURL
    curl_close($curl);

    // Devolver el ID de la factura procesada
    return $InvoiceID;    
}

function procesa_pdf($InvoiceID, $ticket) {
/*
 * 	Llave de suscripción y token de autorización: 
 * 		Se indican las variables que contienen la llave de suscripción y el token de autorización necesarios para realizar la solicitud.
 *	Encabezados para la solicitud HTTP: 
 * 		Se especifican los encabezados necesarios para la solicitud, incluyendo el tipo de contenido y las credenciales.
 *	Fecha actual en formato ISO 8601: 
 * 		Se obtiene la fecha actual en el formato requerido.
 *	URL del API para obtener el PDF de la factura: 
 * 		La URL del endpoint de la API que se usará para obtener el PDF de la factura.
 *	Inicializar cURL: 
 * 		Inicializa una sesión cURL con la URL especificada.
 *	Configurar la solicitud cURL: 
 * 		Configura los parámetros necesarios para la solicitud GET.
 *	Ejecutar la solicitud cURL: 
 * 		Ejecuta la solicitud y guarda la respuesta.
 *	Verificar si hubo algún error durante la ejecución de la solicitud: Comprueba si se produjo un error durante la ejecución de cURL.
 *	Obtener el código de respuesta HTTP: 
 * 		Obtiene el código de estado HTTP de la respuesta.
 *	Cerrar la sesión cURL: Cierra la sesión cURL.
 *	Verificar el código de respuesta HTTP: 
 * 		Comprueba si la respuesta fue exitosa (código 200).
 *	Ruta donde se guardará el archivo en el servidor: 
 * 		Define la ruta donde se guardará el archivo PDF en el servidor.
 *	Guardar el PDF en el servidor: 
 * 		Intenta guardar el PDF en el servidor y muestra un mensaje de éxito o error.
 *	Mostrar el código de respuesta HTTP y la respuesta completa para depuración: 
 * 		En caso de error, muestra el código de respuesta y la respuesta completa para ayudar en la depuración.
 * 
 * Todo este proceso nos ayuda a Generar el pdf de la remision con los datos a facturar
*/	

    // Llave de suscripción y token de autorización
    $key = "neuromodulaciongdl";
    $authorization = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1bmlxdWVfbmFtZSI6Imxlb25hcmRvIHNhbnp8MTI3NzkyIiwiSW50ZXJuYWxJRCI6ImUzNzM4OWVkLTdmM2EtNDM0OS1iMmNmLTU3YTZmMDdjZDEwZCIsIm5iZiI6MTcxMzU0NTY3MiwiZXhwIjoxNzQ1MDgxNjcyLCJpYXQiOjE3MTM1NDU2NzIsImlzcyI6Ik1pbm50X1NvbHV0aW9uc19TQV9ERV9DViIsImF1ZCI6IkJpbmRfRVJQX0FQSV9Vc2VycyJ9.lA7OgjBx9QDh6dwMGkYeKdCa4eNTFlx7wtPy3gF7M_E";    

    // Encabezados para la solicitud HTTP
    $headers = [
        'Content-Type: application/json',
        'Cache-Control: no-cache',
        'Ocp-Apim-Subscription-Key: ' . $key,
        'Authorization: Bearer ' . $authorization
    ];
    
    // URL de la API con el ID de la factura
    $url = "https://api.bind.com.mx/api/Invoices/{$InvoiceID}/pdf";
    
    // Inicializar cURL
    $curl = curl_init($url);
    
    // Configurar la solicitud cURL
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    
    // Ejecutar la solicitud cURL
    $response = curl_exec($curl);
    
    // Verificar si hubo algún error durante la ejecución de la solicitud
    if (curl_errno($curl)) {
        echo 'Error cURL: ' . curl_error($curl);
        curl_close($curl);
        return;
    }
    
    // Obtener el código de respuesta HTTP
    $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    
    // Cerrar la sesión cURL
    curl_close($curl);
    
    // Verificar el código de respuesta HTTP
    if ($http_status == 200) {
        // Verificar que el contenido de la respuesta no esté vacío
        if (empty($response)) {
            echo 'Error: La respuesta está vacía.';
            return;
        }

        // Ruta donde se guardará el archivo en el servidor
        $file_path = 'pdf/' . $ticket . '.pdf'; // Reemplaza con la ruta correcta
        
        // Verificar que el directorio exista
        if (!file_exists('pdf')) {
            mkdir('pdf', 0777, true); // Crear el directorio si no existe
        }

        // Guardar el PDF en el servidor
        if (file_put_contents($file_path, $response)) {
            echo $file_path; //'PDF guardado exitosamente en: ' 
        } else {
            echo 'Error al guardar el PDF en el servidor.';
        }
    } else {
        // Mostrar el código de respuesta HTTP y la respuesta completa para depuración
        echo 'Error: No se pudo obtener el PDF. Código de respuesta HTTP: ' . $http_status . '<br>';
        echo 'Respuesta del servidor: ' . $response;
    }
	return;
}

function genera_remision_bind($CurrencyID, $ClientID, $LocationID, $WarehouseID, $fecha, $PriceListID, $Comments, $Title, $Price, $Qty, $Description, $Emails, $ticket, $uuid, $AccountID) {
	$key = "neuromodulaciongdl";
	$authorization = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1bmlxdWVfbmFtZSI6Imxlb25hcmRvIHNhbnp8MTI3NzkyIiwiSW50ZXJuYWxJRCI6ImUzNzM4OWVkLTdmM2EtNDM0OS1iMmNmLTU3YTZmMDdjZDEwZCIsIm5iZiI6MTcxMzU0NTY3MiwiZXhwIjoxNzQ1MDgxNjcyLCJpYXQiOjE3MTM1NDU2NzIsImlzcyI6Ik1pbm50X1NvbHV0aW9uc19TQV9ERV9DViIsImF1ZCI6IkJpbmRfRVJQX0FQSV9Vc2VycyJ9.lA7OgjBx9QDh6dwMGkYeKdCa4eNTFlx7wtPy3gF7M_E";	

    $headers = [
        'Content-Type: application/json',
        'Cache-Control: no-cache',
        'Ocp-Apim-Subscription-Key: ' . $key,
        'Authorization: Bearer ' . $authorization
    ];
	// Genera la venta
    $url = "https://api.bind.com.mx/api/Invoices";
    $curl = curl_init($url);

    $fecha = date('Y-m-d\TH:i:s');
    $request_body = json_encode([
        "CurrencyID" => $CurrencyID,
        "ClientID" => $ClientID,
        "LocationID" => $LocationID,
        "WarehouseID" => $WarehouseID,
        "CFDIUse" => 3,
        "InvoiceDate" => $fecha,
        "PriceListID" => $PriceListID,
        "ExchangeRate" => 1.0000,
        "ISRRetRate" => 0.0000,
        "VATRetRate" => 0.0000,
        "Comments" => $Comments,
        "VATRate" => 0.0000,
        "DiscountType" => 0,
        "DiscountAmount" => 0,
        "Services" => [
            [
                "ID" => $uuid,
                "Title" => $Title,
                "Price" => $Price,
                "Qty" => $Qty,
                "VAT" => 0,
                "Comments" => $Description
            ]
        ],
        "Emails" => [$Emails],
        "PurchaseOrder" => null,
        "CreditDays" => 0,
        "IsFiscalInvoice" => false,
        "ShowIEPS" => true,
        "Number" => 0,
        "Account" => "105-03-001",
        "Serie" => "",
        "Reference" => "",
        "PaymentTerm" => 0
    ]);

    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $request_body);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

    $resp = curl_exec($curl);
	
	echo $request_body;
	
    if (curl_errno($curl)) {
        echo 'Error cURL: ' . curl_error($curl);
        curl_close($curl);
        return;
    }
	
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    if ($httpCode != 200 && $httpCode != 201) {
        echo 'Error HTTP: ' . $httpCode . ' Respuesta: ' . $resp;
        curl_close($curl);
        return;
    }
    curl_close($curl);

    $InvoiceID = trim($resp, '"');
	
	echo $InvoiceID."<hr>";

	$update = "
		UPDATE cobros
		SET
			cobros.Invoice_ID = '$InvoiceID'
		WHERE 
			cobros.ticket = $ticket
		";
	echo $update."<hr>";
	$result_update=ejecutar($update);

/**************************************************************************************************/
// genera el proceso de pago


$fecha = date('Y-m-d\TH:i:s');

$url = "https://api.bind.com.mx/api/Invoices/Payment";
$curl = curl_init($url);

curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

/****************************************************************/ 
// se procesa pago
//$AccountID = "00bf530b-a4d8-4859-b58d-8304b7f09eee"; // Banco prueba

            
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


    return $InvoiceID;
}

function actualiza_cliente($ID){
    
    // Construye la URL para la solicitud GET a la API usando el ID del cliente
    $url = 'https://api.bind.com.mx/api/Clients/' . $ID;
    $curl = curl_init($url);

    // Clave de suscripción y token de autorización para acceder a la API
    $key = "neuromodulaciongdl";
    $authorization = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1bmlxdWVfbmFtZSI6Imxlb25hcmRvIHNhbnp8MTI3NzkyIiwiSW50ZXJuYWxJRCI6ImUzNzM4OWVkLTdmM2EtNDM0OS1iMmNmLTU3YTZmMDdjZDEwZCIsIm5iZiI6MTcxMzU0NTY3MiwiZXhwIjoxNzQ1MDgxNjcyLCJpYXQiOjE3MTM1NDU2NzIsImlzcyI6Ik1pbm50X1NvbHV0aW9uc19TQV9ERV9DViIsImF1ZCI6IkJpbmRfRVJQX0FQSV9Vc2VycyJ9.lA7OgjBx9QDh6dwMGkYeKdCa4eNTFlx7wtPy3gF7M_E";
    
    // Define los encabezados para la solicitud HTTP
    $headers = array(
        'Content-Type: application/json', 
        'Cache-Control: no-cache', 
        'Ocp-Apim-Subscription-Key: '.$key, 
        'Authorization: Bearer '.$authorization
    );
    
    // Configura las opciones de cURL para hacer la solicitud GET a la API
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

    // Ejecuta la solicitud y almacena la respuesta
    $resp = curl_exec($curl);
    
    // Verifica si hubo un error en la ejecución de cURL
    if (curl_errno($curl)) {
        // Muestra el error y sale de la función
        echo 'Error de cURL: ' . curl_error($curl);
        return;
    }

    // Cierra la sesión de cURL
    curl_close($curl);

    // Decodifica la respuesta JSON en un array asociativo
    $data = json_decode($resp, true);
    if ($data === null) {
        // Muestra el error de decodificación JSON y sale de la función
        echo "Error en la decodificación JSON: " . json_last_error_msg();
        return;
    }

    // Almacena los valores obtenidos de la API en variables locales
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
    $Addresses = implode(", ", $data['Addresses']);
    $RegimenFiscal = $data['RegimenFiscal'];
    // Agrega las otras variables aquí...

    // Construye una consulta SQL para verificar si el cliente ya existe en la base de datos
    $sql_protocolo = "
        SELECT
            pacientes_bind.ID, 
            pacientes_bind.ClientName as paciente, 
            pacientes_bind.RFC as rfc, 
            pacientes_bind.Email as email, 
            pacientes_bind.Phone as celular, 
            pacientes_bind.RegimenFiscal as regimenfiscal
        FROM
            pacientes_bind
        WHERE
            pacientes_bind.ID = '$ID' 
    "; 
			
    //echo "<br>".$sql_protocolo;
    
    // Ejecuta la consulta y cuenta cuántas filas fueron retornadas
    $result_protocolo = ejecutar($sql_protocolo); 
    $cnt_protocolo = mysqli_num_rows($result_protocolo);
    
	if ($cnt_protocolo<>0) {
	    // Extrae la fila resultante en caso de que el cliente exista
	    $row_protocolo = mysqli_fetch_array($result_protocolo);
	    extract($row_protocolo);	
	    //print_r($row_protocolo);  
	    
	    // Compara los valores del cliente de la base de datos con los obtenidos de la API
	    echo "<hr>Regimen Fiscal: neuro - $regimenfiscal bind - ".$RegimenFiscal."<br>";
	    echo "paciente: neuro - ".$paciente." bind - ".$LegalName,"<br>";
	    echo "celular: neuro - ".$celular." bind - ".$Telephones." - ".validarSinEspacios($Telephones)."<br>";
	    echo "email: neuro - ".$email." bind - ".$Email." - ".validarSinEspacios($Email)."<hr>";
    	    		
	}
  


    // Si el cliente no existe, inserta un nuevo registro en la base de datos
    if ($cnt_protocolo == 0) {
        $insert ="
        INSERT INTO pacientes_bind
        (	
            pacientes_bind.ID, 
            pacientes_bind.Number, 
            pacientes_bind.ClientName, 
            pacientes_bind.LegalName, 
            pacientes_bind.RFC, 
            pacientes_bind.Email, 
            pacientes_bind.Phone, 
            pacientes_bind.NextContactDate, 
            pacientes_bind.LocationID, 
            pacientes_bind.RegimenFiscal
        ) VALUE (
            '$ID',
            '$Number',
            '$LegalName',
            '$LegalName',
            '$RFC',
            '$Email',
            '$Phone',
            '$NextContactDate',
            '$LocationID',
            '$RegimenFiscal'
        )
        ";
        //echo "<b>".$insert."</b><hr>";
        $result_update = ejecutar($insert); 	
    }
    
    // Si el cliente ya existe, actualiza la información en la base de datos
    $update = "	    
        UPDATE pacientes_bind 
        SET 
            CreditDays = '$CreditDays',
            CreditAmount = '$CreditAmount',
            PaymentMethod = '$PaymentMethod',
            STATUS = '$Status',
            `SalesContact` = '$SalesContact',
            `Loctaion` = '$Loctaion',
            Comments = '$Comments',
            `PriceList` = '$PaymentTermType',
            PriceListID = 'f7929bd7-a45b-4eef-b272-78bd36261754',
            Email = '$Email',
            Phone = '$Telephones',
            `AccountNumber` = '$AccountNumber',
            `Account` = '$Account',
            City = '$City',
            `State` = '$State',
            `Addresses` = '$Addresses',
            Source = 'Actualizado'
        WHERE ID = '$ID';
    ";		
    //echo $update . "<hr>";
    $result_update = ejecutar($update);			
}

// Función para validar que el correo electrónico tenga formato correcto
function validarEmail($email) {
    // Expresión regular para verificar que el correo contenga un '@' y un dominio válido
    $patron = "/^[\w\.-]+@[\w\.-]+\.(com|com\.mx|org|net|edu)$/";
    
    // Verificar si el correo cumple con el patrón
    return preg_match($patron, $email);
}