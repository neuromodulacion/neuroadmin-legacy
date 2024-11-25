<?php
session_start();

// Establecer el nivel de notificación de errores
error_reporting(E_ALL); // Reemplaza `7` por `E_ALL` para usar la constante más clara y recomendada

// Establecer la codificación interna a UTF-8 (ya no se utiliza `iconv_set_encoding`, sino `ini_set`)
ini_set('default_charset', 'UTF-8');

// Configurar la cabecera HTTP con codificación UTF-8
header('Content-Type: text/html; charset=UTF-8');

// Configurar la zona horaria
date_default_timezone_set('America/Monterrey');

// Configurar la localización para manejar fechas y horas en español
setlocale(LC_TIME, 'es_ES.UTF-8');

// Asignar el tiempo actual a la sesión en formato de timestamp
$_SESSION['time'] = time(); // `time()` es el equivalente moderno a `mktime()`

$ruta = "../";
include($ruta.'functions/funciones_mysql.php');
extract($_SESSION);		
extract($_POST);
//extract($_GET);

//print_r($_POST);


$sql ="
SELECT
	clientes_sat.cCodigoCliente,
	clientes_sat.cRFC 
FROM
	clientes_sat
WHERE
	clientes_sat.cRFC = '$cRFC'";

//echo "<hr>".$sql."<hr>";	
$result =ejecutar($sql); 
$cnt = mysqli_num_rows($result);

//print_r($row);
if ($cnt >= 1) {
	
	$update="
		UPDATE clientes_sat SET
		  cRazonSocial = '".utf8_encode($cRazonSocial)."', 
		  cRFC = '$cRFC', 
		  cNombreCalle = '".utf8_encode($cNombreCalle)."', 
		  cNumeroExterior = '".utf8_encode($cNumeroExterior)."', 
		  cNumeroInterior = '".utf8_encode($cNumeroInterior)."', 
		  cColonia = '".utf8_encode($cColonia)."', 
		  cCodigoPostal = '$cCodigoPostal', 
		  cCiudad = '".utf8_encode($cCiudad)."', 
		  cEstado = '".utf8_encode($cEstado)."', 
		  cPais = '".utf8_encode($cPais)."', 
		  aRegimen = '$aRegimen', 
		  email_address = '$email_address'
		WHERE clientes_sat.cRFC = '$cRFC';
		
	";
	//echo $update."<hr>";
	$result=ejecutar($update);
	
} else {
	
	$insert="
		INSERT INTO clientes_sat (
		  cRazonSocial, 
		  cRFC, 
		  cNombreCalle, 
		  cNumeroExterior, 
		  cNumeroInterior, 
		  cColonia, 
		  cCodigoPostal, 
		  cCiudad, 
		  cEstado, 
		  cPais, 
		  aRegimen, 
		  email_address
		)value(
		  '".utf8_encode($cRazonSocial)."', 
		  '$cRFC', 
		  '".utf8_encode($cNombreCalle)."', 
		  '".utf8_encode($cNumeroExterior)."', 
		  '".utf8_encode($cNumeroInterior)."', 
		  '".utf8_encode($cColonia)."', 
		  '$cCodigoPostal', 
		  '".utf8_encode($cCiudad)."', 
		  '".utf8_encode($cEstado)."', 
		  '".utf8_encode($cPais)."', 
		  '$aRegimen', 
		  '$email_address'
		)
	";
	//echo $insert."<hr>";	
	$result=ejecutar($insert);
}
?>

<div align="left" class="body">
	<h1 align="center">Valida la Información</h1>
    <h2 align="center">Detalles del Ticket</h2>
	<div class="row">
	  	<div class="col-md-6"> 				    
		    <p><strong>Razón Social:</strong> <?php echo htmlspecialchars($ticket); ?></p>
		    <p><strong>Razón Social:</strong> <?php echo htmlspecialchars($cRazonSocial); ?></p>
		    <p><strong>RFC:</strong> <?php echo htmlspecialchars($cRFC); ?></p>
		    <p><strong>Régimen:</strong> <?php echo htmlspecialchars($aRegimen); ?></p>
		    <p><strong>Correo Electronico:</strong> <?php echo htmlspecialchars($email_address); ?></p>		    				    
		</div>
	  	<div class="col-md-6">   				    
		    <p><strong>Nombre Calle:</strong> <?php echo htmlspecialchars($cNombreCalle); ?></p>
		    <p><strong>Número Exterior:</strong> <?php echo htmlspecialchars($cNumeroExterior); ?></p>
		    <p><strong>Número Interior:</strong> <?php echo htmlspecialchars($cNumeroInterior); ?></p>
		    <p><strong>Código Postal:</strong> <?php echo htmlspecialchars($cCodigoPostal); ?></p>
		    <p><strong>Colonia:</strong> <?php echo htmlspecialchars($cColonia); ?></p>
		    <p><strong>Ciudad:</strong> <?php echo htmlspecialchars($cCiudad); ?></p>
		    <p><strong>Estado:</strong> <?php echo htmlspecialchars($cEstado); ?></p>
		    <p><strong>País:</strong> <?php echo htmlspecialchars($cPais); ?></p>
		</div>
	</div>	
    <div align="center">
		<input type="hidden" name="cRazonSocial" value="<?php echo htmlspecialchars($ticket); ?>">
		<input type="hidden" name="cRazonSocial" value="<?php echo htmlspecialchars($cRazonSocial); ?>">
		<input type="hidden" name="cRFC" value="<?php echo htmlspecialchars($cRFC); ?>">
		<input type="hidden" name="aRegimen" value="<?php echo htmlspecialchars($aRegimen); ?>">
		
		<input type="hidden" name="cNombreCalle" value="<?php echo htmlspecialchars($cNombreCalle); ?>">
		<input type="hidden" name="cNumeroExterior" value="<?php echo htmlspecialchars($cNumeroExterior); ?>">
		<input type="hidden" name="cNumeroInterior" value="<?php echo htmlspecialchars($cNumeroInterior); ?>">
		<input type="hidden" name="cCodigoPostal" value="<?php echo htmlspecialchars($cCodigoPostal); ?>">
		<input type="hidden" name="cColonia" value="<?php echo htmlspecialchars($cColonia); ?>">
		<input type="hidden" name="cCiudad" value="<?php echo htmlspecialchars($cCiudad); ?>">
		<input type="hidden" name="cEstado" value="<?php echo htmlspecialchars($cEstado); ?>">
		<input type="hidden" name="cPais" value="<?php echo htmlspecialchars($cPais); ?>">
		<input type="hidden" name="email_address" value="<?php echo htmlspecialchars($email_address); ?>">
	</div>
</div>
               