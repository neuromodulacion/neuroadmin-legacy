<?php
include('../functions/funciones_mysql.php');
//$obj=new Mysql;
session_start();
error_reporting(0);
iconv_set_encoding('internal_encoding', 'utf-8');
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');
extract($_POST);
//print_r($_POST);
extract($_SESSION);


        $update ="
UPDATE  admin
INNER JOIN casas ON admin.casa_id = casas.casas_id
SET
    admin.nombre = '$nombre',
    admin.funcion = '$funcionx',
    admin.observaciones = '$observaciones',
    casas.telefono_fijo = '$telefono_fijo',
    casas.celular = '$celular',
    casas.tel_oficina = '$tel_oficina',
    casas.mail = '$mail', 
    casas.remoto = '$remoto',
    casas.tipo = '$tipo',
    casas.nom_adic = '$nom_adic',
    casas.tel_adic = '$tel_adic',
    casas.nombre = '$nombre'
WHERE
    admin.casa_id = $casa_id";
    echo $update."<br>";
        $result_update = ejecutar($update);

?>
