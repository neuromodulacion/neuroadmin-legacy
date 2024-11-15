<?php
include('../functions/funciones_mysql.php');
include('../functions/email.php');

error_reporting(7);
iconv_set_encoding('internal_encoding', 'utf-8'); 
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');
$time = mktime();

$ruta = "../";

extract($_POST);
//echo "<br><br><br><br><br>";
// print_r($_POST);
// echo "<hr>";

$f_captura = date("Y-m-d");
$h_captura = date("H:i:s"); 
$mes =  substr($mes_ano, 5, 2);
$ano = substr($mes_ano, 0, 4);

	include($ruta.'functions/header_temp.php');

	?>
	<!--  ----------------------------------- INICIA -------------------------------------------  -->
    <div align="center" class="five-zero-zero-container">
        <div><h1>Ya capturado anteriormente</h1></div>
        <div><h2>Usuario registrado</h2></div>
        <div align="center"> 
			<div style="width: 90% ;!important;" align="left" >
				<h2><?php echo $mensaje; ?></h2>
			        	Registro: <?php echo $usuario_id; ?><br>
			        	Nombre: <?php echo $nombre; ?><br>
			        	Correo Electronico: <?php echo $usuario; ?><br>
			        	Telefono: <?php echo $celular; ?><br><br>			        	 
				<a href="recupera.php" class="btn bg-green btn-lg waves-effect">RECUPERAR CONTRASEÑA</a>     	      	
	    	</div>        		
        </div>
    </div>
	<!--  ----------------------------------- TERMINA -------------------------------------------  -->
<?php	
	include($ruta.'functions/footer_temp.php');	