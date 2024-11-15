<?php

error_reporting(7);
iconv_set_encoding('internal_encoding', 'utf-8'); 
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Mazatlan');
setlocale(LC_TIME, 'es_ES.UTF-8');
$_SESSION['time']=mktime(); 

include('../functions/funciones_mysql.php');
include('funciones_api.php');

// $url = 'https://api.bind.com.mx/api/Clients?$skip=900';
// ?$skip=300


for ($i=0; $i < 13; $i++) { 
	//echo $i;
	$skip = ($i*100);
	
	if ($i == 0) {
		$url = 'https://api.bind.com.mx/api/Clients';
	} else {
		$url = 'https://api.bind.com.mx/api/Clients?$skip='.$skip;
	}
		 
	echo $url.'<hr>';


//$url = 'https://api.bind.com.mx/api/Clients';
$curl = curl_init($url);
# Request headers
$key = "neuromodulaciongdl";
$authorization = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1bmlxdWVfbmFtZSI6Imxlb25hcmRvIHNhbnp8MTI3NzkyIiwiSW50ZXJuYWxJRCI6ImUzNzM4OWVkLTdmM2EtNDM0OS1iMmNmLTU3YTZmMDdjZDEwZCIsIm5iZiI6MTcxMzU0NTY3MiwiZXhwIjoxNzQ1MDgxNjcyLCJpYXQiOjE3MTM1NDU2NzIsImlzcyI6Ik1pbm50X1NvbHV0aW9uc19TQV9ERV9DViIsImF1ZCI6IkJpbmRfRVJQX0FQSV9Vc2VycyJ9.lA7OgjBx9QDh6dwMGkYeKdCa4eNTFlx7wtPy3gF7M_E";	

	
$headers = array(
	'Content-Type: application/json', 
	'Cache-Control: no-cache', 
	'Ocp-Apim-Subscription-Key: '.$key.'', 
	'Authorization: Bearer '.$authorization.'');

	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	
	$resp = curl_exec($curl);
	curl_close($curl);
	// var_dump($resp);
	
	$data = json_decode($resp, true);
	
	$valueArray = $data['value'];
	$nextLink = $data['nextLink'];
	$count = $data['count'];

	foreach ($valueArray as $value) {
	    $ID = $value['ID'];
	    $Number = $value['Number'];
	    $ClientName = $value['ClientName'];
	    $LegalName = $value['LegalName'];
	    $RFC = $value['RFC'];
	    $Email = $value['Email'];
	    $Phone = $value['Phone'];
	    $NextContactDate = $value['NextContactDate'];
	    $LocationID = $value['LocationID'];
	    $RegimenFiscal = $value['RegimenFiscal'];
			
		echo "<hr><h1>Cliente</h1><br>";		
	    echo "ID: $ID<br>";
	    echo "Number: $Number<br>";
	    echo "ClientName: $ClientName<br>";
	    echo "LegalName: $LegalName<br>";
	    echo "RFC: $RFC<br>";
	    echo "Email: $Email<br>";
	    echo "Phone: $Phone<br>";
	    echo "NextContactDate: $NextContactDate<br>";
	    echo "LocationID: $LocationID<br>"; 
	    echo "RegimenFiscal: $RegimenFiscal<br>";

		//echo actualiza_cliente($ID);
		
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
				
	        echo "<br>".$sql_protocolo;
	        $result_protocolo=ejecutar($sql_protocolo); 
			$cnt_protocolo = mysqli_num_rows($result_protocolo);
	        $row_protocolo = mysqli_fetch_array($result_protocolo);
	            extract($row_protocolo);	
				//print_r($row_protocolo);    
	    	echo "<hr>Regimen Fiscal: neuro - $regimenfiscal bind - ".$RegimenFiscal."<br>";
			echo "paciente: neuro - ".$paciente." bind - ".$LegalName,"<br>";
	    	echo "celular: neuro - ".$celular." bind - ".$Telephones." - ".validarSinEspacios($Telephones)."<br>";
	    	echo "email: neuro - ".$email." bind - ".$Email." - ".validarSinEspacios($Email)."<hr>";
	    
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
			)VALUE(
				'$ID',
				'$Number',
				'$ClientName',
				'$LegalName',
				'$RFC',
				'$Email',
				'$Phone',
				'$NextContactDate',
				'$LocationID',
				'$RegimenFiscal'
			)
			";
			echo "<b>".$insert."</b><hr>";
			$result_update=ejecutar($insert); 	
	        
	    }else{
	    				
		    $update = "	    
		        UPDATE pacientes_bind 
		        SET 
		            Email = '$Email',
		            Phone = '$Telephones'
		        WHERE ID = '$ID';
		    ";		
		    echo $update . "<hr>";
		    $result_update = ejecutar($update);			
		}

    	echo "<br>";			
}


}

/**************************************************************************************************************************/


	// $insert ="
	// INSERT INTO pacientes_bind
	// (	
		// pacientes_bind.ID, 
		// pacientes_bind.Number, 
		// pacientes_bind.ClientName, 
		// pacientes_bind.LegalName, 
		// pacientes_bind.RFC, 
		// pacientes_bind.Email, 
		// pacientes_bind.Phone, 
		// pacientes_bind.NextContactDate, 
		// pacientes_bind.LocationID, 
		// pacientes_bind.RegimenFiscal
	// )VALUE(
		// '$ID',
		// '$Number',
		// '$ClientName',
		// '$LegalName',
		// '$RFC',
		// '$Email',
		// '$Phone',
		// '$NextContactDate',
		// '$LocationID',
		// '$RegimenFiscal'
	// )
	// ";
	// echo $insert."<br>";
	// $result_update=ejecutar($insert); 
// 	

	
	
	// $sql_protocolo = "
		// SELECT
			// paciente_consultorio.paciente_cons_id,
			// paciente_consultorio.paciente_id,
			// paciente_consultorio.empresa_id,
			// CONCAT( paciente_consultorio.paciente, ' ', paciente_consultorio.apaterno, ' ', paciente_consultorio.amaterno ) AS paciente,
			// paciente_consultorio.email,
			// paciente_consultorio.celular,
			// paciente_consultorio.id_bind 
		// FROM
			// paciente_consultorio 
		// WHERE
			// CONCAT( paciente_consultorio.paciente, ' ', paciente_consultorio.apaterno, ' ', paciente_consultorio.amaterno ) = '$ClientName' 
			// AND ISNULL( paciente_consultorio.id_bind ) 
			// "; 
        // echo "<br>".$sql_protocolo;
        // $result_protocolo=ejecutar($sql_protocolo); 
            // //echo $cnt."<br>";  
            // //echo "<br>";    
            // //$cnt=1;
            // $total = 0;
            // $ter="";
			// $cnt = mysqli_num_rows($result_protocolo);
        // $row_protocolo = mysqli_fetch_array($result_protocolo);
            // extract($row_protocolo);	
			// print_r($row_protocolo);
// 
// 			
		// if ($cnt <> 0) {
			// $update ="
			// UPDATE paciente_consultorio
			// SET
				// paciente_consultorio.id_bind = '$ID'
			// WHERE
				// paciente_consultorio.paciente_cons_id = $paciente_cons_id
			// ";
			// echo $update."<br>";
			// $result_update=ejecutar($update); 		
		// }		
			// $cnt ="0";
			
						
    // echo "<hr>";			
// }

// echo "NextLink: $nextLink<br>";
// echo "Count: $count<br>";

	// $sql_protocolo = "
		// SELECT
			// pacientes_bind.ID 
		// FROM
			// pacientes_bind
		// limit 2
			// "; 
        // $result_protocolo=ejecutar($sql_protocolo); 
// 
        // while($row_protocolo = mysqli_fetch_array($result_protocolo)){
            // extract($row_protocolo);
// 
	 		// //$ID = "8f4fee82-742b-4228-b689-77f3b3941343";
// 	
			// $url = 'https://api.bind.com.mx/api/Clients/'.$ID;
// 			
			// echo $url."<br>";
// 			
			// $headers = array(
				// 'Content-Type: application/json', 
				// 'Cache-Control: no-cache', 
				// 'Ocp-Apim-Subscription-Key: '.$key.'', 
				// 'Authorization: Bearer '.$authorization.'');
// 			
			// curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
			// curl_setopt($curl, CURLOPT_URL, $url);
			// curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			// curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
// 			
			// $resp = curl_exec($curl);
			// curl_close($curl);
			// //var_dump($resp);
// 			
			// $data = json_decode($resp, true);
			// $valueArray = $data['value'];
// 			
			// //print_r($data);
// 	
			// // Almacenar valores en variables
			// $ID = $data['ID'];
			// $RFC = $data['RFC'];
			// $LegalName = $data['LegalName'];
			// $CommercialName = $data['CommercialName'];
			// $CreditDays = $data['CreditDays'];
			// $CreditAmount = $data['CreditAmount'];
			// $PaymentMethod = $data['PaymentMethod'];
			// $CreationDate = $data['CreationDate'];
			// $Status = $data['Status'];
			// $SalesContact = $data['SalesContact'];
			// $CreditContact = $data['CreditContact'];
			// $Loctaion = $data['Loctaion'];
			// $LoctaionID = $data['LoctaionID'];
			// $Comments = $data['Comments'];
			// $PriceList = $data['PriceList'];
			// $PriceListID = $data['PriceListID'];
			// $PaymentTermType = $data['PaymentTermType'];
			// $Email = $data['Email'];
			// $Telephones = $data['Telephones'];
			// $Number = $data['Number'];
			// $AccountNumber = $data['AccountNumber'];
			// $DefaultDiscount = $data['DefaultDiscount'];
			// $ClientSource = $data['ClientSource'];
			// $Account = $data['Account'];
			// $City = $data['City'];
			// $State = $data['State'];
			// $Addresses = implode(", ", $data['Addresses']);
			// $RegimenFiscal = $data['RegimenFiscal'];
// 			
			// $update = "	    
				// UPDATE pacientes_bind 
				// SET CreditDays = '$CreditDays',
					// CreditAmount = '$CreditAmount',
					// PaymentMethod = '$PaymentMethod',
					// STATUS = '$STATUS',
					// `SalesContact` = '$SalesContact',
					// `Loctaion` = '$Loctaion',
					// Comments = '$Comments',
					// `PriceList` = '$PaymentTermType',
					// PriceListID = 'f7929bd7-a45b-4eef-b272-78bd36261754',
					// Email = '$Email',
					// Phone = '$Telephones',
					// AccountNumber = '$AccountNumber',
					// DefaultDiscount = '$DefaultDiscount',
					// `Account` = '$Account',
					// City = '$State',
					// `State` = '$State',
					// `Addresses` = '$Addresses' 
				// WHERE
					// ID = '$ID';	
			// ";		
			// echo "<hr>".$update."<hr>";
			// $result_update=ejecutar($update);
// 		
// 			
		// }

// function actualiza_cliente($ID){
//     
//     
    // $url = 'https://api.bind.com.mx/api/Clients/' . $ID;
    // $curl = curl_init($url);
// 
    // $key = "neuromodulaciongdl";
    // $authorization = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1bmlxdWVfbmFtZSI6Imxlb25hcmRvIHNhbnp8MTI3NzkyIiwiSW50ZXJuYWxJRCI6ImUzNzM4OWVkLTdmM2EtNDM0OS1iMmNmLTU3YTZmMDdjZDEwZCIsIm5iZiI6MTcxMzU0NTY3MiwiZXhwIjoxNzQ1MDgxNjcyLCJpYXQiOjE3MTM1NDU2NzIsImlzcyI6Ik1pbm50X1NvbHV0aW9uc19TQV9ERV9DViIsImF1ZCI6IkJpbmRfRVJQX0FQSV9Vc2VycyJ9.lA7OgjBx9QDh6dwMGkYeKdCa4eNTFlx7wtPy3gF7M_E";
//     
    // $headers = array(
        // 'Content-Type: application/json', 
        // 'Cache-Control: no-cache', 
        // 'Ocp-Apim-Subscription-Key: '.$key, 
        // 'Authorization: Bearer '.$authorization
    // );
//     
    // curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
    // curl_setopt($curl, CURLOPT_URL, $url);
    // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    // curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
// 
    // $resp = curl_exec($curl);
    // var_dump($resp);
//     
    // if (curl_errno($curl)) {
        // echo 'Error de cURL: ' . curl_error($curl);
        // return; // Salir de la función en caso de error
    // }
// 
    // curl_close($curl);
// 
    // $data = json_decode($resp, true);
    // if ($data === null) {
        // echo "Error en la decodificación JSON: " . json_last_error_msg();
        // return; // Salir de la función en caso de error
    // }
// 
		// //print_r($data);
// 
		// // Almacenar valores en variables
		// $ID = $data['ID'];
		// $RFC = $data['RFC'];
		// $LegalName = $data['LegalName'];
		// $CommercialName = $data['CommercialName'];
		// $CreditDays = $data['CreditDays'];
		// $CreditAmount = $data['CreditAmount'];
		// $PaymentMethod = $data['PaymentMethod'];
		// $CreationDate = $data['CreationDate'];
		// $Status = $data['Status'];
		// $SalesContact = $data['SalesContact'];
		// $CreditContact = $data['CreditContact'];
		// $Loctaion = $data['Loctaion'];
		// $LoctaionID = $data['LoctaionID'];
		// $Comments = $data['Comments'];
		// $PriceList = $data['PriceList'];
		// $PriceListID = $data['PriceListID'];
		// $PaymentTermType = $data['PaymentTermType'];
		// $Email = $data['Email'];
		// $Telephones = $data['Telephones'];
		// $Number = $data['Number'];
		// $AccountNumber = $data['AccountNumber'];
		// $DefaultDiscount = $data['DefaultDiscount'];
		// $ClientSource = $data['ClientSource'];
		// $Account = $data['Account'];
		// $City = $data['City'];
		// $State = $data['State'];
		// $Addresses = implode(", ", $data['Addresses']);
		// $RegimenFiscal = $data['RegimenFiscal'];
    // // Agrega las otras variables aquí...
// 
    // $update = "	    
        // UPDATE pacientes_bind 
        // SET CreditDays = '$CreditDays',
            // CreditAmount = '$CreditAmount',
            // PaymentMethod = '$PaymentMethod',
            // STATUS = '$Status',
            // `SalesContact` = '$SalesContact',
            // `Loctaion` = '$Loctaion',
            // Comments = '$Comments',
            // `PriceList` = '$PaymentTermType',
            // PriceListID = 'f7929bd7-a45b-4eef-b272-78bd36261754',
            // Email = '$Email',
            // Phone = '$Telephones',
            // AccountNumber = '$AccountNumber',
            // DefaultDiscount = '$DefaultDiscount',
            // `Account` = '$Account',
            // City = '$State',
            // `State` = 'Aguascalientes',
            // `Addresses` = '$Addresses' 
        // WHERE ID = '$ID';
    // ";		
    // echo "<hr>" . $update . "<hr>";
    // $result_update = ejecutar($update);			
// }		
// 		

// $sql_protocolo = "
    // SELECT
        // pacientes_bind.ID 
    // FROM
        // pacientes_bind
    // limit 2"; 
//     
// $result_protocolo = ejecutar($sql_protocolo); 
// 
// while($row_protocolo = mysqli_fetch_array($result_protocolo)) {
    // extract($row_protocolo); 
    // actualiza_cliente($ID);
// }

	 
?>
