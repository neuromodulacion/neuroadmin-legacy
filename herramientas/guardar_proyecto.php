<?php
include('../functions/funciones_mysql.php'); 
//$obj=new Mysql;
session_start();
error_reporting(0);
iconv_set_encoding('internal_encoding', 'utf-8');
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');
extract($_SESSION);
extract($_POST);
print_r($_POST);

$descripcion = stripslashes($_POST['descripcion']); 

$f_captura = date("Y-m-d");
$h_captura = date("h:i:s"); 
$mes =  substr($mes_ano, 5, 2);
$ano = substr($mes_ano, 0, 4);
 
if ($accion == 'modifica') {
    $update ="
        UPDATE  proyectos
        SET
            proyectos.titulo  = '$titulo',
            proyectos.descripcion  = '$descripcion',
            proyectos.encargado  = '$encargado',
            proyectos.contacto  = '$contacto',
            proyectos.estatus  = '$estatus'
        WHERE
            proyectos.proyecto_id = $proyecto_id";
        echo $update."<br>";
    $result_update = ejecutar($update);
} else {
	    $insert1 ="INSERT IGNORE INTO  proyectos
        (titulo,descripcion,encargado,contacto,estatus,f_captura,h_captura,usuario_id)
        value
        ('$titulo','$descripcion','$encargado','$contacto','$estatus','$f_captura','$h_captura',$user_id)";
            echo $insert1."<br>";
        $result_insert = ejecutar($insert1);
        
       // header('Location: proyectos.php');
}
?>

<html>
<head>
<meta http-equiv="refresh" content="0; url=proyectos.php">
</head>
<body>
</body>
</html>