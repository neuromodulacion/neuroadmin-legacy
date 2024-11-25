
<?php
session_start();

// Establecer el nivel de notificación de errores
error_reporting(E_ALL); // Reemplaza `7` por `E_ALL` para usar la constante más clara y recomendada

// Establecer la codificación interna a UTF-8 (ya no se utiliza `iconv_set_encoding`, sino `ini_set`)
ini_set('default_charset', 'UTF-8');

// Configurar la cabecera HTTP con codificación UTF-8
header('Content-Type: text/html; charset=UTF-8');

// Configurar la zona horaria
date_default_timezone_set('America/Monterrey');

// Configurar la localización para manejar fechas y horas en español
setlocale(LC_TIME, 'es_ES.UTF-8');

// Asignar el tiempo actual a la sesión en formato de timestamp
$_SESSION['time'] = time(); // `time()` es el equivalente moderno a `mktime()`

//echo "<hr>$paciente_id hola<hr>";
extract($_GET);
extract($_POST);



include('../functions/funciones_mysql.php');

include('../paciente/calendario.php');

include('../paciente/fun_paciente.php');

function tildes($palabra) {
    //Rememplazamos caracteres especiales latinos minusculas
    $encuentra = array('&','<','>','¢','£','¥','€','©','®','™','§','†','‡','¶','•','…','±','¹','²','³','½','¼','¾','µ','°','√','∞','Ω','Σ','μ','←','→','↑','↓','↔','↵','⇐','⇒'
);
     $remplaza = array('&amp;','&lt','&gt','&cent','&pound','&yen','&euro','&copy','&reg','&trade','&sect','&dagger','&Dagger','&para','&bull','&hellip','&plusmn','&sup1','&sup2','&sup3','&frac12','&frac14','&frac34','&micro','&deg','&radic','&infin','&ohm','&sigma','&mu','&larr','&rarr','&uarr','&darr','&harr','&crarr','&lArr','&rArr'

);
    $palabra = str_replace($encuentra, $remplaza, $palabra);
return $palabra;
}
// $hoy = date("d-m-Y");
$hoy = strftime("%e de %B del %Y");


// Selecciona una versión aleatoria entre 1 y 6
$version = rand(1, 6);

$nombre = "Livier Elvira Barbara Ornelas Barajas";
$sexo = "la Sra. ";
$nacimiento =" nacida el 3 de diciembre de 1987";
$raza = "Border Collie";
$mascota = "Mila";


switch ($version) {
    case 1:
        $resultado = "<b>A quien corresponda:</b><br><br>
        <p>Por medio de la presente, certifico que $sexo $nombre,$nacimiento, se encuentra bajo mi tratamiento por una condición de discapacidad emocional denominada Trastorno de Angustia, la cual está reconocida en el Manual Diagnóstico y Estadístico de los Trastornos Mentales (DSM-5).</p><br>
        <p>Es fundamental que la pasajera cuente con el acompañamiento de su mascota, un $raza de nombre $mascota, como animal de apoyo emocional, tanto durante el viaje como en las actividades que realice en su destino.</p><br>
        <p>Agradezco de antemano la atención prestada a esta solicitud y me mantengo disponible para cualquier aclaración o duda adicional.</p>";
        break;
    
    case 2:
        $resultado = "<b>A quien corresponda:</b><br><br>
        <p>Por la presente, hago constar que $sexo $nombre,$nacimiento, se encuentra bajo mi tratamiento debido a un Trastorno de Angustia, reconocido en el Manual Diagnóstico y Estadístico de los Trastornos Mentales (DSM-5).</p><br>
        <p>La paciente requiere el apoyo y compañía de su mascota, un $raza llamado $mascota, como animal de apoyo emocional, durante el viaje y para las actividades en su lugar de destino.</p><br>
        <p>Quedo agradecido por su atención a esta carta y me mantengo a disposición para cualquier aclaración que sea necesaria.</p>";
        break;
    
    case 3:
        $resultado = "<b>A quien corresponda:</b><br><br>
        <p>Por medio de la presente, certifico que $sexo $nombre,$nacimiento, está recibiendo tratamiento bajo mi supervisión por una condición emocional denominada Trastorno de Angustia, reconocida en el DSM-5.</p><br>
        <p>Es necesario que la paciente cuente con la compañía de su mascota, un $raza de nombre $mascota, como animal de apoyo emocional durante su viaje y en las actividades en su destino.</p><br>
        <p>Agradezco la atención prestada a esta solicitud y quedo a su disposición para cualquier duda o aclaración que pueda surgir.</p>";
        break;
    
    case 4:
        $resultado = "<b>A quien corresponda:</b><br><br>
        <p>Certifico mediante la presente que $sexo $nombre,$nacimiento, está bajo tratamiento médico por una discapacidad emocional conocida como Trastorno de Angustia, tal como se describe en el DSM-5.</p><br>
        <p>La paciente necesita el apoyo y la compañía de su mascota, un $raza de nombre $mascota, como animal de apoyo emocional tanto durante el viaje como en las actividades en su destino.</p><br>
        <p>Agradezco de antemano su atención a esta comunicación y quedo disponible para cualquier consulta o aclaración adicional.</p>";
        break;
    
    case 5:
        $resultado = "<b>A quien corresponda:</b><br><br>
        <p>Por la presente, certifico que $sexo $nombre,$nacimiento, se encuentra bajo mi tratamiento debido a un Trastorno de Angustia, una discapacidad emocional reconocida en el Manual Diagnóstico y Estadístico de los Trastornos Mentales (DSM-5).</p><br>
        <p>Es imprescindible que la pasajera cuente con la compañía de su mascota, un $raza llamado $mascota, como animal de apoyo emocional durante su viaje y en las actividades que realice en su destino.</p><br>
        <p>Agradezco su atención a la presente y quedo a su disposición para cualquier aclaración o información adicional que sea requerida.</p>";
        break;
    
    case 6:
        $resultado = "<b>A quien corresponda:</b><br><br>
        <p>Por la presente hago constar que actualmente estoy tratando a Livier Elvira Barbara Ornelas Barajas, con fecha de $nacimiento, por una discapacidad emocional llamada Trastorno de Angustia, la cual es reconocida en el Manual de Diagnóstico y Estadística de los Trastornos Mentales (DSM 5).</p><br>
        <p>La persona pasajera necesita apoyo emocional y acompañamiento por su mascota de raza $raza de nombre $mascota, como animal de apoyo emocional, durante el viaje y/o para actividades en su destino.</p><br>
        <p>Agradecido por la atención brindada a la presente, y sin otro particular, quedo atento a cualquier duda o aclaración.</p>";
        break;

    default:
        $resultado = "Versión no válida. Por favor, selecciona un valor entre 1 y 6.";
        break;
}

echo $resultado;


$cuerpo_pdf = "

<html>
<head>
    <title></title>
	<meta charset='UTF-8'>
</head>
<body style='font-family: Arial, sans-serif;'>
	<table style='width: 100%' >
		<tr>
			<td align='center'  style='background: #fff; width: 50%'>
				<img style='width: auto; height: 180px;' src='../images/logo_psiquiatria.png' alt='grafica'>
			</td>		
			<td align='right' style='background: #fff; width: 50%; font-family: Times'>
					<p>Av. de los Arcos 876, Jardines del Bosque.<br>
					Guadalajara, Jalisco. CP. 44520<br>
					dr.alejandro.aldana@hotmail.com<br>
					3312613701</p><br>
					<b>$hoy</b>
					
			</td>

		</tr>
	</table>
	<table>
		<tr>
			<td  colspan='2'   style=' padding: 8px;; font-family: Times'>
				$resultado
			</td>
		</tr>
		<tr>
			<td align='center'  style='background: #fff; width: 60%'>
				<img style='width: auto; height: 450px;' src='../images/cedula.png' alt='grafica'>
			</td>
			<td align='left'  style='background: #fff; width: 40%; padding-top: 300px'>
				<img style='width: auto; height: 150px;' src='../images/firma.png' alt='grafica'>
			</td>			
		</tr>
		<tr>
			<td colspan='2'  align='right' style=' font-family: Times'><p><b>DR JESÚS ALEJANDRO ALDANA LÓPEZ</b><br><br>
Universidad de Guadalajara - Médico Cirujano y Partero 8465806; Especialista en Psiquiatría 14058107
Universidad del Valle de México - Maestro en Educación con Orientación en Innovación y Tecnologías 13061936</p></td>
		</tr>					
	</table>
";
																			


///////////////////////////////////////////////////////////////// termina nuevo																			

		$cuerpo_pdf .=" 	
		
</body>
";
switch (variable) {
	case 'value':
		
		break;
	
	default:
		
		break;
}
// echo $cuerpo_pdf;
 

 
// //Require composer autoload
require_once __DIR__ . '/../vendor/autoload.php';


 

// Create an instance of the class:
$mpdf = new \Mpdf\Mpdf();

// Write some HTML code:
$mpdf->WriteHTML($cuerpo_pdf);

// D descarga
// F guarda
// I imprime

// Output a PDF file directly to the browser
$mpdf->Output('Carta_Paciente_'.$paciente_id.'.pdf','I');
