<?php
include('../functions/funciones_mysql.php');
session_start();
error_reporting(7);
iconv_set_encoding('internal_encoding', 'utf-8'); 
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');
$_SESSION['time']=mktime();


extract($_POST);


echo $comentarios_reporte."<hr>";
// $comentarios_reporte = stripslashes($_POST["comentarios_reporte"]);
// 
// $comentarios_reporte = tildes($comentarios_reporte);
// 
// 
// function tildes($palabra) {
    // //Rememplazamos caracteres especiales latinos minusculas
    // $encuentra = array('&','<','>','¢','£','¥','€','©','®','™','§','†','‡','¶','•','…','±','¹','²','³','½','¼','¾','µ','°','√','∞','Ω','Σ','μ','←','→','↑','↓','↔','↵','⇐','⇒'
// );
     // $remplaza = array('&amp;','&lt','&gt','&cent','&pound','&yen','&euro','&copy','&reg','&trade','&sect','&dagger','&Dagger','&para','&bull','&hellip','&plusmn','&sup1','&sup2','&sup3','&frac12','&frac14','&frac34','&micro','&deg','&radic','&infin','&ohm','&sigma','&mu','&larr','&rarr','&uarr','&darr','&harr','&crarr','&lArr','&rArr'
// 
// );
    // $palabra = str_replace($encuentra, $remplaza, $palabra);
// return $palabra;
// }



$update = "
UPDATE pacientes
SET
pacientes.comentarios_reporte = '$comentarios_reporte'
WHERE pacientes.paciente_id = $paciente_id";

echo $update;
$result_update = ejecutar($update);
