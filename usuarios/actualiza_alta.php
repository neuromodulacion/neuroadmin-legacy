<?php
include('../functions/funciones_mysql.php');
session_start();
error_reporting(7);
iconv_set_encoding('internal_encoding', 'utf-8'); 
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');
$_SESSION['time']=time();
extract($_SESSION);

$ruta = "../";
extract($_POST);

	// print_r($_SESSION);
	// echo "<hr>";
	// print_r($_POST);

//$aviso = stripslashes($_POST['aviso']); 

$f_captura = date("Y-m-d");
$h_captura = date("H:i:s"); 
$option = isset($option) ? $option : '';

switch ($option) {
	case 'perfil':

		$update ="
		UPDATE admin
		SET
			admin.nombre ='$nombre',
			admin.usuario ='$usuario',
			admin.pwd ='$pwdx',
			admin.funcion ='$funcion',
			admin.telefono ='$telefono'
		
		WHERE
			admin.usuario_id = $usuario_idx";
			
			// echo $update."<hr>";
			$result_insert = ejecutar($update);

			// Verificar si existe el campo cedula para el usuario
			$check_query = "SELECT COUNT(*) as count FROM cedulas WHERE usuario_id = $usuario_idx and principal = 'si'";
			$result_check = ejecutar($check_query);
			$row = mysqli_fetch_assoc($result_check);

			if ($row['count'] > 0) {
				// Si existe, hacer update
				$update = "
				UPDATE cedulas
				SET
					cedulas.cedula ='$cedula',
					cedulas.principal = 'si'
				WHERE
					cedulas.usuario_id = $usuario_idx";
			} else {
				// Si no existe, hacer insert
				$update = "
				INSERT INTO cedulas (usuario_id, cedula, principal)
				VALUES ($usuario_idx, '$cedula', 'si')";
			}

			// echo $update."<hr>";
			$result_insert = ejecutar($update);
		?>            
<!-- HTML para mostrar el mensaje de éxito de registro -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Guardado</title>
    <!-- Favicon-->
    <link rel="icon" href="../../favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="../plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="../plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="../css/style.css" rel="stylesheet">
</head>

<body class="theme-<?php echo $body; ?>">    
    <div style="padding-top: 30px" class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
			<div style="padding: 20px; text-align: center" class="five-zero-zero-container card">
                <!-- Mensaje de confirmación de éxito -->
                <div><h1>Exito</h1></div>
                <div><h2>Se guardo correctamente la información</h2></div>
                <div style="text-align: center"> 
                    <div style="width: 90% !important; text-align: center">
						        	<b>Registro:</b> <?php echo $usuario_id; ?><br>
						        	<b>Nombre:</b> <?php echo $nombre; ?><br>
						        	<b>Correo Electronico:</b> <?php echo $usuario; ?><br>
						        	<b>Telefono:</b> <?php echo $telefono; ?><br>
									<b>Cedula Profesional:</b> <?php echo $cedula; ?><br><br>			        	 
							<a href="<?php echo $ruta; ?>menu.php" class="btn bg-green btn-lg waves-effect">CONTINUAR</a>     	      	
				    	</div>         		
						</div>                
                </div>
            </div>
        </div>
        <div class="col-md-4"></div>
    </div>            

    <!-- Jquery Core Js -->
    <script src="../../plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="../../plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="../../plugins/node-waves/waves.js"></script>
</body>
 
</html>   
		<?php
 
		
		break;

	case 'pwd':
		

		$update = "
		
		UPDATE admin
		SET
			admin.pwd ='$password'	
		WHERE
			admin.usuario_id = $usuario_idx";
			
		    // echo $update."<hr>";
		$result_insert = ejecutar($update);
		?>            
		<!-- HTML para mostrar el mensaje de éxito de registro -->
		<!DOCTYPE html>
		<html>

		<head>
			<meta charset="UTF-8">
			<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
			<title>Guardado</title>
			<!-- Favicon-->
			<link rel="icon" href="../../favicon.ico" type="image/x-icon">

			<!-- Google Fonts -->
			<link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
			<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

			<!-- Bootstrap Core Css -->
			<link href="../plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

			<!-- Waves Effect Css -->
			<link href="../plugins/node-waves/waves.css" rel="stylesheet" />

			<!-- Custom Css -->
			<link href="../css/style.css" rel="stylesheet">
		</head>

		<body class="theme-<?php echo $body; ?>">    
			<div style="padding-top: 30px" class="row">
				<div class="col-md-4"></div>
				<div class="col-md-4">
					<div style="text-align: center; padding: 20px;" class="five-zero-zero-container card">
						<!-- Mensaje de confirmación de éxito -->
						<div><h1>Exito</h1></div>
						<div><h2>Se guardo correctamente la información</h2></div>
						<div  style="text-align: center"> 
							<div style="width: 90% !important; text-align:left">
									<!-- Mensaje de confirmación de éxito -->
								<div> <h1>Exito</h1></div>
								<div> <h2>Se actualizo correctamente la contraseña</h2></div>
								<div style="text-align: center"> 
									<div  style="text-align: center" style="width: 90% !important; text-align: left" >		        	 
										<a href="<?php echo $ruta; ?>menu.php" class="btn bg-green btn-lg waves-effect">CONTINUAR</a>     	      	
									</div>         		
								</div>	
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4"></div>
			</div>            

			<!-- Jquery Core Js -->
			<script src="../../plugins/jquery/jquery.min.js"></script>

			<!-- Bootstrap Core Js -->
			<script src="../../plugins/bootstrap/js/bootstrap.js"></script>

			<!-- Waves Effect Plugin Js -->
			<script src="../../plugins/node-waves/waves.js"></script>
		</body>
		
		</html>    
		<?php		
		
		break;
	
	default:

		$update = "
		
		UPDATE admin
		SET
			admin.nombre ='$nombre',
			admin.usuario ='$usuario',
			admin.funcion ='$funcionx',
			admin.telefono ='$telefono'
		
		WHERE
			admin.usuario_id = $usuario_idx";
			
		     // echo "<hr>".$update."<hr>";
		$result_insert = ejecutar($update);

			// Verificar si existe el campo cedula para el usuario
			$check_query = "SELECT COUNT(*) as count FROM cedulas WHERE usuario_id = $usuario_idx and principal = 'si'";
			$result_check = ejecutar($check_query);
			$row = mysqli_fetch_assoc($result_check);

			if ($row['count'] > 0) {
				// Si existe, hacer update
				$update = "
				UPDATE cedulas
				SET
					cedulas.cedula ='$cedula',
					cedulas.principal = 'si'
				WHERE
					cedulas.usuario_id = $usuario_idx";
			} else {
				// Si no existe, hacer insert
				$update = "
				INSERT INTO cedulas (usuario_id, cedula, principal)
				VALUES ($usuario_idx, '$cedula', 'si')";
			}

			// echo $update."<hr>";
			$result_insert = ejecutar($update);		
		?>            
<!-- HTML para mostrar el mensaje de éxito de registro -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Guardado</title>
    <!-- Favicon-->
    <link rel="icon" href="../../favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="../plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="../plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="../css/style.css" rel="stylesheet">
</head>

<body class="theme-<?php echo $body; ?>">    
    <div style="padding-top: 30px" class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div  style="text-align: center; padding: 20px;" class="five-zero-zero-container card">
				<div >
					<!-- Mensaje de confirmación de éxito -->
					<div><h1>Exito</h1></div>
					<div><h2>Se guardo correctamente la información</h2></div>
					<div  style="text-align: center"> 
						<div style="width: 90% !important; text-align: left">
							<b>Registro:</b> <?php echo $usuario_id; ?><br>
							<b>Nombre:</b> <?php echo $nombre; ?><br>
							<b>Correo Electronico:</b> <?php echo $usuario; ?><br>
							<b>Telefono:</b> <?php echo $telefono; ?><br>
							<b>Cedula Profesional:</b> <?php echo $cedula; ?><br><br>			        	 
							<a href="<?php echo $ruta; ?>menu.php" class="btn bg-green btn-lg waves-effect">CONTINUAR</a>     	      	
						</div>                
					</div>
				</div>
            </div>
        </div>
        <div class="col-md-4"></div>
    </div>            

    <!-- Jquery Core Js -->
    <script src="../../plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="../../plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="../../plugins/node-waves/waves.js"></script>
</body>
 
</html>    
		<?php
 
		
		break;
}
