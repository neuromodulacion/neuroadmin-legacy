<?php
include('../functions/funciones_mysql.php');
include('../functions/email.php');

error_reporting(7);
iconv_set_encoding('internal_encoding', 'utf-8'); 
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');
$time = time();

$ruta = "../";

extract($_POST);
//echo "<br><br><br><br><br>";
// print_r($_POST);
// echo "<hr>";

$f_captura = date("Y-m-d");
$h_captura = date("H:i:s"); 
$mes =  substr($mes_ano, 5, 2);
$ano = substr($mes_ano, 0, 4);

$sql_protocolo = "
	SELECT
		empresas.emp_nombre,
		empresas.body_principal,
		empresas.icono,
		empresas.logo,
		empresas.web,
		empresas.e_mail,
		empresas.pdw,
		empresas.tipo_email,
		empresas.puerto,
		empresas.`host` as e_host
	FROM
		empresas 
	WHERE
		empresas.empresa_id = $empresa_id 									
    ";
	
//echo $sql_protocolo;
$result_protocolo=ejecutar($sql_protocolo); 

$row_protocolo = mysqli_fetch_array($result_protocolo);
extract($row_protocolo);
// print_r($row_protocolo);
// echo "<br>mes ".$mes."<br>";
//echo "<hr>";
$sql = "SELECT
			admin.usuario 
		FROM
			admin
		WHERE
			admin.usuario ='$usuario'"; 
//echo $sql."<hr>";			
$result_insert = ejecutar($sql);
$cnt = mysqli_num_rows($result_insert);
//echo $cnt."<hr>";

if ($cnt >= 1) {	 
	$row = mysqli_fetch_array($result_insert);
	extract($row);	
	//print_r($row);
	include($ruta.'functions/header_temp.php');

	
// Codificar los datos en base64
$datos_codificados = base64_encode("usuario_id=$usuario_id&vigencia=$fecha_expiracion&empresa_id=$empresa_id&funcion=$funcion&time=$time&uso=$uso");

// URL base
$url_base = "https://neuromodulaciongdl.com/usuarios/invitacion.php";

// Construir la URL completa
$enlace_invitacion = "$url_base?datos=$datos_codificados";	
	?>
	<!--  ----------------------------------- INICIA -------------------------------------------  -->
	<section class="user-registered">
		<div class="five-zero-zero-container" style="text-align: center;">
			<div>
				<h1>Ya capturado anteriormente</h1>
			</div>
			<div>
				<h2>Usuario registrado</h2>
			</div>
			<div style="margin: 0 auto; max-width: 600px; text-align: left;">
				<h3><?php echo htmlspecialchars($mensaje ?? 'Usuario ya registrado.', ENT_QUOTES, 'UTF-8'); ?></h3>
				<p><strong>Registro:</strong> <?php echo htmlspecialchars($usuario_id ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></p>
				<p><strong>Nombre:</strong> <?php echo htmlspecialchars($nombre ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></p>
				<p><strong>Correo Electrónico:</strong> <?php echo htmlspecialchars($usuario ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></p>
				<p><strong>Teléfono:</strong> <?php echo htmlspecialchars($celular ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></p>
				<br>
				<a href="recupera.php" class="btn bg-green btn-lg waves-effect">RECUPERAR CONTRASEÑA</a>
			</div>
		</div>
	</section>

	<!--  ----------------------------------- TERMINA -------------------------------------------  -->
<?php	
	include($ruta.'functions/footer_temp.php');	

}else{ 

	$sql = "
		SELECT
			funciones.funciones_id
		FROM
			funciones
		WHERE 
			funciones.funcion = '$funcion'"; 
	$result_insert = ejecutar($sql);
	$row1 = mysqli_fetch_array($result_insert);
	extract($row1);
	//echo "<hr>";

	$f_alta = date("Y-m-d");
	$h_alta = date("H:i:s"); 
	$insert1 ="
		INSERT IGNORE INTO admin 
			(
				nombre,
				usuario,
				pwd,
				acceso,
				funciones_id,
				funcion,
				telefono,
				saldo,
				f_alta,
				h_alta ,
				estatus,
				empresa_id
			) 
		VALUE
			(
				'$nombre',
				'$usuario',
				'$password_c',
				'0',
				$funciones_id,
				'$funcion',
				'$celular',
				'0',
				'$f_alta',
				'$h_alta',
				'Pendiente',
				$empresa_id
			) ";
    //echo $insert1."<hr>";
	$result_insert = ejecutar($insert1);
	//echo $result_insert."<hr>";
 
	$sql = "SELECT
				max(usuario_id)  as usuario_id 
			FROM
				admin"; 
	$result_insert = ejecutar($sql);
	$row1 = mysqli_fetch_array($result_insert);
	extract($row1);
	//echo "<hr>";
	
	$insert1 ="
		INSERT IGNORE INTO herramientas_sistema 
			(
				usuario_id,
				body,
				notificaciones
			) 
		VALUE
			(
				'$usuario_id',
				'$body_principal',
				'Si'
			) ";
	    //  echo $insert1."<hr>";
	$result_insert = ejecutar($insert1);
	// print_r($row1);

		$update ="
		
		UPDATE invitaciones
		SET
			invitaciones.estatus ='usado'
		WHERE
			invitaciones.time = $timex";
			
		    // echo $update."<hr>";
		$result_insert = ejecutar($update);

	$destinatario = $usuario; 
	$asunto = "Alta de Usuario"; 
	$cuerpo = ' 
	<html> 
	<head> 
	   <title>Concluye el proceso</title> 
	</head> 
	<body> 
	
	<div> <h2>Se guardo correctamente la información dale en continuar para confirmar el correo</h2></div>
	<div align="center"> 
		<div style="width: 90% ;!important;" align="left" >
	    	<b>Nombre:</b> '.$nombre.'<br>
	    	<b>Correo Electronico y Usuario:</b> '.$usuario.'<br>
	    	<b>Celular:</b> '.$celular.'<br>
	    	Atte. '.$emp_nombre.'   <br>	
	    	<a class="btn btn-default" href="https://'.$dominio.'"/confirmacion.php?us='.$usuario_id.'" role="button"><h1>Confirmar</h1></a><br>  	  
			   	      	
		</div> 
	</div> 
	</body> 
	</html> 
	'; 
	$cuerpo = $usuario_id;
	//$mail = correo_electronico($correo_pac,$asunto,$cuerpo_correo,$paciente,$empresa_id);
	//https://confirmacion.php?us='.$usuario_id
	
	$accion =  "normal"; // "Invitacion"; // "RFC"; // "General"; // 
	 
	$mail = correo_electronico($usuario,$asunto,$cuerpo,$nombre,$empresa_id,$accion);
	
	//$mail = correo_electronico_invitacion($usuario,$asunto,$cuerpo,$nombre,$empresa_id);
     
	include($ruta.'functions/header_temp.php');
	?>            
		<!--  ----------------------------------- INICIA -------------------------------------------  -->
		<section class="success-message">
			<div class="five-zero-zero-container" style="text-align: center;">
				<div>
					<h1>Éxito</h1>
				</div>
				<div>
					<h2>Se guardó correctamente la información</h2>
				</div>
				<div style="margin: 0 auto; max-width: 600px; text-align: left;">
					<h3><?php echo htmlspecialchars($mensaje ?? 'Operación completada exitosamente.', ENT_QUOTES, 'UTF-8'); ?></h3>
					<p><strong>Registro:</strong> <?php echo htmlspecialchars($usuario_id ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></p>
					<p><strong>Nombre:</strong> <?php echo htmlspecialchars($nombre ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></p>
					<p><strong>Correo Electrónico:</strong> <?php echo htmlspecialchars($usuario ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></p>
					<p><strong>Teléfono:</strong> <?php echo htmlspecialchars($celular ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></p>
					<p><?php echo htmlspecialchars($mail ?? 'No se proporcionó información adicional.', ENT_QUOTES, 'UTF-8'); ?></p>
					<a href="<?php echo htmlspecialchars($ruta ?? '#', ENT_QUOTES, 'UTF-8'); ?>inicio.html" class="btn bg-green btn-lg waves-effect">CONTINUAR</a>
				</div>
			</div>
		</section>

		<!--  ----------------------------------- TERMINA -------------------------------------------  -->
	<?php 
	include($ruta.'functions/footer_temp.php');
}	
?>