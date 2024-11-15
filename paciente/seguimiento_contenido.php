<?php // seguimiento_contenido.php
include('../functions/funciones_mysql.php');
session_start();
error_reporting(7);
iconv_set_encoding('internal_encoding', 'utf-8'); 
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');
$_SESSION['time']=mktime();

$ruta = "../";
extract($_SESSION);
extract($_POST);
//print_r($_POST);
//$paciente_id=189;


$sql_protocolo = "
	SELECT DISTINCT
		registro_llamadas.paciente_id,
		registro_llamadas.empresa_id,
		registro_llamadas.contacto,
		registro_llamadas.no_contacto,
		registro_llamadas.beneficios,
		registro_llamadas.costo,
		registro_llamadas.f_pago,
		registro_llamadas.ini_tratamiento,
		registro_llamadas.forma_pago,
		registro_llamadas.no_tratamiento,
		registro_llamadas.otros,
		registro_llamadas.new_contacto,
		registro_llamadas.f_contacto_prox,
		registro_llamadas.observaciones,
		registro_llamadas.f_registro,
		registro_llamadas.h_registro,
		registro_llamadas.usuario_id,
		registro_llamadas.registro_id 
	FROM
		registro_llamadas
	where
		registro_llamadas.paciente_id = $paciente_id
    ";
	//echo $sql_protocolo."<hr>";
    $result_protocolo=ejecutar($sql_protocolo); 

	$cnt = mysqli_num_rows($result_protocolo);
	
	if ($cnt > 0) {
	    while($row_protocolo = mysqli_fetch_array($result_protocolo)){
	        extract($row_protocolo);
			//print_r($row_protocolo); ?>
			
<body>
    <h1>Detalle del Paciente</h1>
    <ul>
        <li>ID del Paciente: <?php echo '<b>'.$paciente_id.'</b>'; ?></li>
        <li>ID de la Empresa: <?php echo '<b>'.$empresa_id.'</b>'; ?></li>
        <li>Contacto: <?php echo '<b>'.$contacto.'</b>'; ?></li>
        <li>No Contacto: <?php echo '<b>'.$no_contacto.'</b>'; ?></li>
        <li>Beneficios: <?php echo '<b>'.$beneficios.'</b>'; ?></li>
        <li>Costo: <?php echo '<b>'.$costo.'</b>'; ?></li>
        <li>Forma de Pago: <?php echo '<b>'.$f_pago.'</b>'; ?></li>
        <li>Inicio del Tratamiento: <?php echo '<b>'.$ini_tratamiento.'</b>'; ?></li>
        <li>Forma de Pago Detallada: <?php echo '<b>'.$forma_pago.'</b>'; ?></li>
        <li>Fecha de Contacto Próximo: <?php echo '<b>'.$f_contacto_prox.'</b>'; ?></li>
        <li>Observaciones: <?php echo '<b>'.$observaciones.'</b>'; ?></li>
        <li>Fecha de Registro: <?php echo '<b>'.$f_registro.'</b>'; ?></li>
        <li>Hora de Registro: <?php echo '<b>'.$h_registro.'</b>'; ?></li>
        <li>ID del Usuario: <?php echo '<b>'.$usuario_id.'</b>'; ?></li>
        <li>ID de Registro: <?php echo '<b>'.$registro_id.'</b>'; ?></li>
    </ul>
</body>		
			      
	<?php	}		
	} else {
		echo "<h1>No hay registos</h1>";
	}
	

