<?php
include('../functions/funciones_mysql.php');
include('../functions/email.php');
session_start();
error_reporting(7);
ini_set('default_charset', 'UTF-8'); 
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');
$_SESSION['time']=mktime();

$ruta = "../";
extract($_SESSION);
//extract($_POST);

$f_registro = date("Y-m-d");
$h_registro = date("H:i:s");

 
$id = $_POST['id'];
$prioridad = $_POST['prioridad'];
$estado = $_POST['estado'];

$sql = "
	UPDATE solicitudes 
	SET 
		prioridad='$prioridad', 
		estado='$estado', 
		observaciones_cierre='$observaciones_cierre' 
	WHERE id=$id";
$result_insert = ejecutar($sql);
	
$sql = "
	SELECT
		solicitudes.*, 
		admin.nombre
	FROM
		solicitudes
		INNER JOIN
		admin
		ON 
			solicitudes.usuario_id = admin.usuario_id
	WHERE
		solicitudes.id=$id		
	ORDER BY
		solicitudes.prioridad DESC, 
		solicitudes.fecha_creacion ASC"; 
		$result_sql = ejecutar($sql);	
		$row = mysqli_fetch_array($result_sql);
    	extract($row);

$asunto = "Segimiento de ".$titulo;
$cuerpo_correo = "
	Se seguimiento a la siguiente solicitud y cambio de estatus:<br>".$descripcion."<br><br><br>
	Tipo: <b>".$tipo."</b><br>
	Prioridad: <b>".$prioridad."</b><br> 
	Estatus: <b>".$estado."</b><br>
	Observaciones de Cierre: <b>".$observaciones_cierre."</b><br>";
	$accion = "correo simple";

echo correo_electronico_sitema($asunto,$cuerpo_correo,$usuario_id,$accion);
	
if (!headers_sent()) {
    // Redirigir a seguimientos.php
    header('Location: seguimientos.php');
    exit(); // Terminar el script después de la redirección
} else {
    echo '<script type="text/javascript">';
    echo 'window.location.href="seguimientos.php";';
    echo '</script>';
    echo '<noscript>';
    echo '<meta http-equiv="refresh" content="0;url=seguimientos.php" />';
    echo '</noscript>';
    exit();
}
	
