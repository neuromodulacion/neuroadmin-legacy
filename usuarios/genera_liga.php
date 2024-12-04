<?php
// Incluir archivo de funciones MySQL necesarias para interactuar con la base de datos
include('../functions/funciones_mysql.php');

// Iniciar la sesión para manejar variables de sesión
session_start();

// Configurar los niveles de reporte de errores
error_reporting(7);

// Configurar la codificación interna a UTF-8
iconv_set_encoding('internal_encoding', 'utf-8'); 

// Establecer el encabezado del contenido como HTML con codificación UTF-8
header('Content-Type: text/html; charset=UTF-8');

// Configurar la zona horaria a Monterrey
date_default_timezone_set('America/Monterrey');

// Configurar la localización para fechas en español
setlocale(LC_TIME, 'es_ES.UTF-8');

// Guardar la hora actual en la sesión
$_SESSION['time'] = time();

// Obtener el dominio actual del servidor
$dominio = $_SERVER['HTTP_HOST'];

// Extraer variables del formulario POST para su uso en el script
extract($_POST);

// Consulta SQL para obtener información de la empresa y del administrador asociado
$sql = "
SELECT
	empresas.emp_nombre, 
	empresas.body_principal, 
	empresas.icono, 
	empresas.logo, 
	empresas.web, 
	empresas.e_mail, 
	empresas.pdw, 
	empresas.tipo_email, 
	empresas.puerto, 
	empresas.`host`, 
	admin.nombre, 
	admin.usuario_id, 
	empresas.empresa_id
FROM
	empresas
	INNER JOIN
	admin
	ON 
		empresas.empresa_id = admin.empresa_id
WHERE
	admin.usuario_id = $usuario_id"; 

// Ejecutar la consulta SQL
$result_insert = ejecutar($sql);

// Obtener los resultados de la consulta
$row = mysqli_fetch_array($result_insert);

// Calcular la fecha de expiración de la invitación (15 días desde hoy)
$fecha_expiracion = date('Y-m-d', strtotime('+15 days'));
$fecha_vig = date('d/m/Y', strtotime('+15 days'));

// Insertar una nueva invitación en la base de datos
$insert1 ="
	INSERT IGNORE INTO invitaciones 
		(
			time,
			uso,
			vigencia,
			usuario_id,
			empresa_id,
			funcion,
			estatus
		) 
	VALUES
		(
			$time,
			'$uso',
			'$fecha_expiracion',
			$usuario_id,
			$empresa_id,
			'$funcion',
			'pendiente'
		) ";

// Ejecutar la inserción en la base de datos
$result_insert = ejecutar($insert1);

// Codificar los datos de la invitación en base64 para incluirlos en la URL
$datos_codificados = base64_encode("usuario_id=$usuario_id&vigencia=$fecha_expiracion&empresa_id=$empresa_id&funcion=$funcion&time=$time&uso=$uso");

// Definir la URL base para la invitación
$url_base = "https://".$dominio."/usuarios/invitacion.php";

// Construir la URL completa con los datos codificados
$enlace_invitacion = "$url_base?datos=$datos_codificados";

// Imprimir la URL de la invitación con la fecha de vigencia
echo "Este enlace tiene vigencia al: <b>$fecha_vig</b><br><br> <a target='_blank' href='$enlace_invitacion'>$enlace_invitacion</a>";
?>
