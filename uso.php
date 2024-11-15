<?php
$autoload_path = $ruta . "vendor/autoload.php";

if (file_exists($autoload_path)) {
    require_once $autoload_path;
} else {
    die("Error: No se pudo cargar el autoload de Composer.");
}
use UAParser\Parser;

# Podría venir de otro lado
$agenteDeUsuario = $_SERVER["HTTP_USER_AGENT"];
$parseador = Parser::create();
$resultado = $parseador->parse($agenteDeUsuario);

$sistema = $resultado->os->toString();
$navegador = $resultado->ua->toString();
$dispositivo = $resultado->device->family;
$ip = $_SERVER['REMOTE_ADDR'];
$rutas = $_SERVER['SCRIPT_URL'];

$f_captura = date("Y-m-d");
$h_captura = date("H:i:s");
$data_time = date("Y-m-d H:i:s");
$timestamp = time(); // Actualiza esta línea para eliminar el aviso

$sql_insert ="
	INSERT IGNORE INTO historico_uso 
	( 	
		historico_uso.usuario_id, 
		historico_uso.ip, 
		historico_uso.ruta, 
		historico_uso.navegador, 
		historico_uso.sistema_operativo, 
		historico_uso.dispositivo, 
		historico_uso.f_movimiento, 
		historico_uso.h_movimiento
	)
		values
	( 
		$usuario_id,
		'$ip',
		'$rutas',
		'$navegador',
		'$sistema',	
		'$dispositivo',						
		'$f_captura',
		'$h_captura'
	)
";
$result_insert = ejecutar($sql_insert);

$update = "
		UPDATE admin
		SET
			admin.time = $time,
			admin.actividad = 'Activo',
			admin.hora = '$data_time'
		WHERE
			admin.usuario_id = $usuario_id";
$result_update = ejecutar($update);
?>