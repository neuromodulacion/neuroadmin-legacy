<?php		error_reporting(7); 
    iconv_set_encoding('internal_encoding', 'utf-8'); 
    header('Content-Type: text/html; charset=UTF-8');
    date_default_timezone_set('America/Monterrey');
	
    include ("../funciones/funciones_mysql.php");
    include ("../funciones/funciones.php");     
    
    $conexion = conectar("dish_calidad"); 
    $usuario = $_POST["usuario"];
	$cartera = $_POST["tabla"];
	$sesion = $_POST["sesion"];
	
	$completar = 0;
	$flag = 0;
	$bandera = 0;
	
	if($sesion <> 'On'){ header('Location: ../prueba/index.php'); } else{
		$num_eco = $_POST["num_eco"];		
		$f_carga = $_POST["f_carga"];
		$f_captura = date('Y-m-d');
		$hr_captura = date('H:i:s');
		$estado = $_POST["estado"];
		$importe = $_POST["importe"];
		$kilometraje = $_POST["kilometraje"];
		$litros = $_POST["litros"];
		$latitud = $_POST["latitud"];
		$longitud = $_POST["longitud"];
		$precision = $_POST["precision"];
		
		if(($usuario == "") || (($num_eco == '') || ($num_eco == 0)) || ($f_carga == '') || ($estado == '') || (($importe == '') || ($importe == 0)) || (($kilometraje == '') || ($kilometraje == 0)) || (($litros == '') || ($litros == 0)) || (($latitud == '') || ($latitud == 0)) || ($longitud == '') || ($precision == '')){
			$completar = 1;	
			$resultado = "¡FALTARON DATOS POR CAPTURAR!"; 
			$mensaje = "Olvidó capturar uno o más datos:<br /><br />Usuario: <strong>".$usuario."</strong><br />Núm. Economico: <strong>".$num_eco."</strong><br />Fecha de Carga: <strong>".$f_carga."</strong><br />Estado: <strong>".$estado."</strong><br />Importe: $<strong>".$importe."</strong><br />Kilometrtaje: <strong>".$kilometraje."</strong><br />Litros: <strong>".$litros."</strong><br />";
			if(($latitud == "") || ($latitud == 0)){
				$mensaje .= "Latitud: <strong>No especificada</strong><br />";
				$flag += 1;
			}
			if(($longitud == "") || ($longitud == 0)){
				$mensaje .= "Longitud: <strong>No especificada</strong><br />";
				$flag += 1;
			}
			if(($precision == "") || ($precision == 0)){
				$mensaje .= "Precisión: <strong>No especificada</strong><br />";
				$flag += 1;
			}			
			if($flag > 0){ $mensaje .= '<br />Es obligatorio hacer clic en el botón "Permitir" (Debajo de la barra de direcciones) para compartir su ubicación.<br /><br />Se enviará reporte al coordinador.'; }
			if($usuario == ""){ $bandera = 1; }	 	
			
			$xmensaje = "<strong>No se cargó ninguna foto.</strong>";	  
		} else{
			$ano = date('Y');
			$mes = date('m');
			$dir_raiz = "fotos_aseg/$ano"; 
			$dir_mes = "fotos_aseg/$ano/$mes"; 
			$dir_aseg = "fotos_aseg/$ano/$mes/combustible";
			$dir_cliente = "fotos_aseg/$ano/$mes/combustible/$num_eco";
			
			if(!is_dir($dir_raiz)){
				mkdir($dir_raiz,0777); 
				if(is_dir($dir_raiz) && !is_dir($dir_mes)){
					mkdir($dir_mes,0777);
					if(is_dir($dir_mes) && !is_dir($dir_aseg)){
						mkdir($dir_aseg,0777);
						if(is_dir($dir_aseg) && !is_dir($dir_cliente)){
							mkdir($dir_cliente,0777);
							$ruta = "$dir_cliente";
						}
					}
				}
			} else{
				if(!is_dir($dir_mes)){
					mkdir($dir_mes,0777);
					if(is_dir($dir_mes) && !is_dir($dir_aseg)){
						mkdir($dir_aseg,0777);
						if(is_dir($dir_aseg) && !is_dir($dir_cliente)){
							mkdir($dir_cliente,0777);
							$ruta = "$dir_cliente";
						}
					}
				} else{
					if(!is_dir($dir_aseg)){
						mkdir($dir_aseg,0777);
						if(is_dir($dir_aseg) && !is_dir($dir_cliente)){
							mkdir($dir_cliente,0777);	
							$ruta = "$dir_cliente";					
						}
					} else{
						if(!is_dir($dir_cliente)){
							mkdir($dir_cliente,0777);
							$ruta = "$dir_cliente";
						} else{
							$ruta = "$dir_cliente";
						}
					}
				}
			}	
			
			$inserta = 0;
			$actualiza = 0;
			$resultado = "";
			$mensaje = "";
			$xmensaje = "";
			
			$sql = "SELECT DISTINCT * FROM admin_gasolina WHERE num_eco = $num_eco AND f_carga = '$f_carga'; ";
			$result = ejecutar($sql,$conexion);
			$valida_num = mysql_num_rows($result);
			
			if($valida_num > 0){
				$actualizar = "UPDATE admin_gasolina SET usuario = '$usuario', f_carga = '$f_carga', f_captura = '$f_captura', hr_captura = '$hr_captura', estado = '$estado', num_eco = $num_eco, importe = $importe, kilometraje = $kilometraje,  litros = $litros, latitud = $latitud, longitud = $longitud, precision_ = $precision WHERE num_eco = $num_eco AND f_carga = '$f_carga'; ";
				$result_actualizar = ejecutar($actualizar,$conexion);
				if($result_actualizar){ $actualiza += 1; }
			} else{
				$insertar = "INSERT INTO admin_gasolina (usuario,f_carga,f_captura,hr_captura,estado,num_eco,importe,kilometraje,litros,latitud,longitud,precision_) VALUES ('$usuario','$f_carga', '$f_captura', '$hr_captura', '$estado', $num_eco, $importe, $kilometraje, $litros, $latitud, $longitud, $precision); ";
				$result_insertar = ejecutar($insertar,$conexion);
				if($result_insertar){ $inserta += 1; }
			}	
			
			if(($actualiza > 0) || ($inserta > 0)){ $resultado = "¡ÉXITO!"; $mensaje = "Los datos se han actualizado con éxito."; }
			else{ $resultado = "¡FALLA DE CAPTURA!"; $mensaje = "La información no pudo ser añadida."; }
			
			$sql_id = "SELECT DISTINCT id FROM admin_gasolina WHERE num_eco = $num_eco AND f_carga = '$f_carga';  "; //echo "$sql_id<br />";
			$result_id = ejecutar($sql_id,$conexion);
			$fila_id = mysql_fetch_array($result_id);
			$xid = $fila_id["id"];
			
			$dir_id = "fotos_aseg/".$ano."/".$mes."/combustible/".$num_eco."/id_".$xid;		
			if(!is_dir($dir_id)){
				mkdir($dir_id,0777);
				$ruta = "$dir_id";
			} else{
				$ruta = "$dir_id";
			}
			
			$pic_1 = "pic_1";
			$pic_2 = "pic_2";
			$pic_3 = "pic_3";
			
			$fotos = array($pic_1,$pic_2,$pic_3);
			$count_fotos = count($fotos);
			$i = 0;
			$xname = "";
			$xvalida_foto = 0;
			while ($count_fotos > 0){
				$foto = $fotos[$i];
				if($foto == $pic_1){ $xname = "km_antes"; }
				else if($foto == $pic_2){ $xname = "km_despues"; }
				else if($foto == $pic_3){ $xname = "ticket"; }
				
				$tipo = extension_foto($foto);	
				$valida_foto = carga_fotos($foto,$ruta,$xname);
				
				if($valida_foto > 0){ $xmensaje .= '<img src="../images/ico_ok.png" alt="En base de datos"> > Se cargó la foto '.$xname.'.'.$tipo.'.<br />'; }
				else{ $xmensaje .= '<img src="../images/ico_remove.png" alt="No cargada"> > <strong>NO</strong> se cargó la foto '.$xname.'.'.$tipo.'.<br />'; }
				
				$actual_ruta = "UPDATE admin_gasolina SET ruta = '$ruta' WHERE num_eco = $num_eco AND f_carga = '$f_carga';  "; //echo "$actual_ruta<br /><br />";
				$result_actu_ruta = ejecutar($actual_ruta,$conexion);
				
				$i++;
				$count_fotos--;
			}
			$i++;
			$count_fotos--;
		}

		$sql = "SELECT * FROM admin_gasolina WHERE id = $xid; ";
		$result = ejecutar($sql,$conexion);
		$row = mysql_fetch_assoc($result);			
		$postdata = http_build_query($row);
		
		$opts = array('http' =>
		    array(
		        'method'  => 'POST',
		        'header'  => 'Content-type: application/x-www-form-urlencoded',
		        'content' => $postdata
		    )
		);
		
		$context  = stream_context_create($opts);

		/**
		* Simple example script using PHPMailer with exceptions enabled
		* @package phpmailer
		* @version $Id$
		*/
		
		require '../class.phpmailer.php';
		
		try {
			$mail = new PHPMailer(true); //New instance, with exceptions enabled
		
			$body             = file_get_contents('reporte_gasolina.php', false, $context);
			$body             = preg_replace('/\\\\/','', $body); //Strip backslashes
		
			$mail->IsSMTP();                           // tell the class to use SMTP
			$mail->SMTPAuth   = true;                  // enable SMTP authentication
			$mail->Port       = 25;                    // set the SMTP server port
			$mail->Host       = "191.1.1.199"; // SMTP server
			$mail->Username   = "carlos.sonora@dish.com.mx";     // SMTP server username
			$mail->Password   = "Sonora2013";            // SMTP server password
		
			$mail->IsSendmail();  // tell the class to use Sendmail
		
			$mail->AddReplyTo("carlos.sonora@dish.com.mx","Carlos Sonora");
		
			$mail->From       = "carlos.sonora@dish.com.mx";
			$mail->FromName   = "Carlos Sonora";
			
			$sql = "SELECT * FROM test;";
			$result = ejecutar($sql,$conexion);
			
			while ($row = mysql_fetch_array ($result)) {
		  		$mail->AltBody    = "¡Para ver el mensaje utilice un visor de correo electrponico compatible con HTML, por favor!"; // optional, comment out and test
			  	$mail->MsgHTML($body);
			  	$mail->AddAddress($row["email"], $row["full_name"]);
			  	$mail->AddStringAttachment($row["photo"], "YourPhoto.jpg");
			
			  	if(!$mail->Send()) {
			    	echo "Mailer Error (" . str_replace("@", "&#64;", $row["email"]) . ') ' . $mail->ErrorInfo . '<br>';
			  	} else {
			    	echo "Message sent to :" . $row["full_name"] . ' (' . str_replace("@", "&#64;", $row["email"]) . ')<br>';
			  	}
			  	// Clear all addresses and attachments for next loop
			  	$mail->ClearAddresses();
			  	$mail->ClearAttachments();
			}
    
		
			$to = "carlos.sonora.jr@gmail.com";		
			$mail->AddAddress($to);
			$to = "sanzaleonardo@gmail.com";		
			$mail->AddAddress($to);
			$to = "santiago.sanz@dish.com.mx";		
			$mail->AddAddress($to);
		
			$mail->Subject  = "First PHPMailer Message";
		
			$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
			$mail->WordWrap   = 80; // set word wrap
		
			$mail->MsgHTML($body);
		
			$mail->IsHTML(true); // send as HTML
		
			$mail->Send();
			echo 'Message has been sent.';
		} catch (phpmailerException $e) {
			echo $e->errorMessage();
		}
		
/**********************************************************************************************************************************************************************************************************************************/ ?>
<!DOCTYPE html> 
<html>
	<head>
		<title>Captura Representantes</title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1" > 
		
		<link rel="stylesheet" href="../css/jquery.mobile-1.2.0.min.css" />
		<link rel="stylesheet" href="../css/dish_mobile.min.css" /> 
	
		<script src="../js/jquery-1.8.2.min.js"></script>
		<script src="../js/jquery.mobile-1.2.0.min.js"></script>
	</head>
	 
	<body> 	
		<div data-role="dialog">	
			<div data-role="header" data-theme="a">
				<h1>Mensaje</h1>	
			</div>	
			<div data-role="content">
				<h1><?	echo $resultado;	?></h1>
				<p><?	echo $mensaje;	?></p>
				<div data-role="collapsible" data-content-theme="d" data-collapsed="false">
				   <h3>Detalle fotografías</h3>
				   <p style="padding: 2px"><div style="width: 90%; height: 150px; overflow-y: scroll" align="center"><? echo $xmensaje; ?></div></p>
				</div>
		<? if($completar == 1){ ?>
				<div class="ui-grid-solo">
					<div class="ui-block-a">
						<form action="admin_gasolina.php" method="post" id="form_antena" enctype="multipart/form-data" data-ajax="false">
							<input type="hidden" name="usuario" id="usuario" value="<? echo $usuario; ?>" />
							<input type="hidden" name="tabla" id="tabla" value="<? echo $cartera; ?>" />
							<input type="hidden" name="sesion" id="sesion" value="On" />
							<input type="hidden" name="bandera" id="bandera" value="<? echo $bandera; ?>" />
							<input type="hidden" name="completar" id="completar" value="<? echo $completar; ?>" />
							<input type="hidden" id="num_eco " name="num_eco " value="<? echo $num_eco  ?>'" />
							<input type="hidden" id="f_carga " name="f_carga " value="<? echo $f_carga  ?>'" />
							<input type="hidden" id="estado " name="estado " value="<? echo $estado  ?>'" />
							<input type="hidden" id="importe " name="importe " value="<? echo $importe  ?>'" />
							<input type="hidden" id="kilometraje " name="kilometraje " value="<? echo $kilometraje  ?>'" />
							<input type="hidden" id="litros " name="litros " value="<? echo $litros  ?>'" />
							<input type="submit" value="Capturar datos faltantes" />
						</form>
					</div>
				</div>
		<? } else { ?>
				<div class="ui-grid-solo">
					<div class="ui-block-a">
						<form action="admin_gasolina.php" method="post" id="form_antena" enctype="multipart/form-data" data-ajax="false">
							<input type="hidden" name="usuario" id="usuario" value="<? echo $usuario; ?>" />
							<input type="hidden" name="tabla" id="tabla" value="<? echo $cartera; ?>" />
							<input type="hidden" name="sesion" id="sesion" value="On" />
							<input type="submit" value="Capturar otra carga" />
						</form>
					</div>
				</div>
				<div class="ui-grid-solo">
					<div class="ui-block-a">
						<form action="menu.php" method="post" id="form_antena" enctype="multipart/form-data" data-ajax="false">
							<input type="hidden" name="usuario" id="usuario" value="<? echo $usuario; ?>" />
							<input type="hidden" name="tabla" id="tabla" value="<? echo $cartera; ?>" />
							<input type="hidden" name="sesion" id="sesion" value="On" />
							<input type="submit" value="Regresar al menú" />
						</form>
					</div>	   
				</div>
		<?	} ?>		
			</div>
		</div>
	</body>
</html>
<?	} mysql_close($conexion); ?>