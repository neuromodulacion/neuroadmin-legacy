<?php
session_start();
extract($_POST);

include('../functions/funciones_mysql.php');

//$obj=new Mysql;

$update ="
UPDATE herramientas_sistema
SET herramientas_sistema.body = '$color_body'
WHERE
    herramientas_sistema.usuario_id = $usuario_id";

echo $update;
$result_update = ejecutar($update);

$_SESSION['body'] = $color_body; 