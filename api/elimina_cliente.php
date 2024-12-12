<?php
include('../functions/funciones_mysql.php');

extract($_GET);
print_r($_GET);
	
function actualiza_cliente($ID){
		
	$url = 'https://api.bind.com.mx/api/Clients/' . $ID;
	$curl = curl_init($url);
	
	$key = "neuromodulaciongdl";
	$authorization = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1bmlxdWVfbmFtZSI6Imxlb25hcmRvIHNhbnp8MTI3NzkyIiwiSW50ZXJuYWxJRCI6ImUzNzM4OWVkLTdmM2EtNDM0OS1iMmNmLTU3YTZmMDdjZDEwZCIsIm5iZiI6MTcxMzU0NTY3MiwiZXhwIjoxNzQ1MDgxNjcyLCJpYXQiOjE3MTM1NDU2NzIsImlzcyI6Ik1pbm50X1NvbHV0aW9uc19TQV9ERV9DViIsImF1ZCI6IkJpbmRfRVJQX0FQSV9Vc2VycyJ9.lA7OgjBx9QDh6dwMGkYeKdCa4eNTFlx7wtPy3gF7M_E";

	$headers = array(
		'Content-Type: application/json', 
		'Cache-Control: no-cache', 
		'Ocp-Apim-Subscription-Key: '.$key, 
		'Authorization: Bearer '.$authorization
	);
		
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

    $resp = curl_exec($curl);

    if($resp === false) {
        echo 'Curl error: ' . curl_error($curl);
    } else {
        var_dump($resp);

        $update = "	    
            UPDATE pacientes_bind 
            SET 
                STATUS = 'Eliminado'
            WHERE
                ID = '$ID';	
        ";		
        echo "<hr>" . $update . "<hr>";
        $result_update = ejecutar($update);
    }
    
    curl_close($curl);	
}		
	 
	 echo "<hr>";	
     actualiza_cliente($ID);
     echo "<hr>";	


	
// if (!empty($paciente_id)) {
    // echo "paciente_id = $paciente_id<hr>";	
    // $delete ="
    // DELETE 
	// FROM
		// pacientes 
	// WHERE
		// id_bind = '$ID'";	
	// echo $delete."<hr>";
	// // $result = ejecutar($delete);
// }

if (!empty($paciente_cons_id)) {
    echo "paciente_cons_id  = $paciente_cons_id<hr>";	
    $delete ="
    DELETE 
	FROM
		paciente_consultorio 
	WHERE
		id_bind = '$ID'";
	echo $delete."<hr>";
	 $result = ejecutar($delete);
}

	$update = "
	UPDATE pacientes_bind
	SET
		pacientes_bind.`STATUS` = 'Eliminado'
	WHERE
		pacientes_bind.ID = '$ID'";	
		
	echo $update."<hr>";
	$result = ejecutar($update);	
		
// $sql_protocolo = "
// SELECT
	// eliminar.Number,
	// eliminar.ClientName,
	// eliminar.validacion,
	// eliminar.ID 
// FROM
	// eliminar"; 
// 
	// echo $sql_protocolo."<hr>";  
// $result_protocolo = ejecutar($sql_protocolo); 
// 
// while($row_protocolo = mysqli_fetch_array($result_protocolo)) {
    // $ID = $row_protocolo['ID'];
    // print_r($row_protocolo);
    // actualiza_cliente($ID);
    // echo "<hr>";
// }

?>
