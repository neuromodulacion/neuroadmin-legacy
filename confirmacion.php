<?php
include('functions/funciones_mysql.php');

error_reporting(7);
iconv_set_encoding('internal_encoding', 'utf-8'); 
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');
$_SESSION['time']=time();

$ruta = "";
extract($_GET);
//print_r($_GET);
// echo "<hr>";
// extract($_SESSION);
// print_r($_SESSION);
// echo "<hr>";
//$aviso = stripslashes($_POST['aviso']); 

$f_alta = date("Y-m-d");
$h_alta = date("H:i:s");

   $UPDATE= "
		UPDATE 
			admin 
			SET estatus = 'Activo' 
		WHERE
			usuario_id = $us";
				
	 //1echo $UPDATE." <hr>";
	 $ejecuta_access = ejecutar($UPDATE);
 

include($ruta.'functions/header_temp.php'); ?>	
<!-- <body class="five-zero-zero"></body>-->
<body class="theme-<?php echo $body; ?>">	
    <div align="center" class="five-zero-zero-container">
        <div> <h1>Exito</h1></div>
        <div> <h2>Se completo el registro</h2>
        	</div>
        <div align="center"> 
			<h3>Favor de iniciar Sesión</h3>
			<a href="index.php" class="btn bg-green btn-lg waves-effect">CONTINUAR</a>        		
        </div>
    </div>
</body>
        
<?php include($ruta.'functionsfooter_temp.php');  ?>         
 	 