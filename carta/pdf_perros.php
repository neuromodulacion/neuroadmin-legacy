<?php
session_start();

// Establecer el nivel de notificación de errores
error_reporting(E_ALL);

// Establecer la codificación interna a UTF-8
ini_set('default_charset', 'UTF-8');

// Configurar la cabecera HTTP con codificación UTF-8
header('Content-Type: text/html; charset=UTF-8');

// Configurar la zona horaria
date_default_timezone_set('America/Monterrey');

// Configurar la localización para manejar fechas y horas en español
setlocale(LC_TIME, 'es_ES.UTF-8');

// Asignar el tiempo actual a la sesión en formato de timestamp
$_SESSION['time'] = time();

extract($_SESSION);
extract($_GET);
extract($_POST);

include('../functions/funciones_mysql.php');
include('../functions/functions.php');
include('../paciente/calendario.php');
include('../paciente/fun_paciente.php');

function tildes($palabra) {
    //Rememplazamos caracteres especiales latinos
    $encuentra = array('&','<','>','¢','£','¥','€','©','®','™','§','†','‡','¶','•','…','±','¹','²','³','½','¼','¾','µ','°','√','∞','Ω','Σ','μ','←','→','↑','↓','↔','↵','⇐','⇒');
    $remplaza  = array('&amp;','&lt','&gt','&cent','&pound','&yen','&euro','&copy','&reg','&trade','&sect','&dagger','&Dagger','&para','&bull','&hellip','&plusmn','&sup1','&sup2','&sup3','&frac12','&frac14','&frac34','&micro','&deg','&radic','&infin','&ohm','&sigma','&mu','&larr','&rarr','&uarr','&darr','&harr','&crarr','&lArr','&rArr');
    $palabra   = str_replace($encuentra, $remplaza, $palabra);
    return $palabra;
}

// Formateo de fechas
$hoy  = date("d ")." de ".date("F")." del ".date("Y");
$hoy2 = date("F d, Y");

// Consulta a la base de datos
$sql = "
SELECT
    registros_carta_perro.id,
    registros_carta_perro.nombre,
    registros_carta_perro.sexo,
    registros_carta_perro.fecha_nacimiento,
    registros_carta_perro.padecimiento,
    registros_carta_perro.raza,
    registros_carta_perro.sexo_perro,
    registros_carta_perro.esterilizado,
    registros_carta_perro.nombre_mascota,
    registros_carta_perro.edad_perro,
    registros_carta_perro.fecha_captura
FROM
    registros_carta_perro
WHERE
    registros_carta_perro.id = $id
";

$result_insert = ejecutar($sql);
$row = mysqli_fetch_array($result_insert);
extract($row);

// Selecciona una versión aleatoria entre 1 y 6
$version = rand(1, 6);

// Obtener la edad de la persona
$anios = obtener_edad_segun_fecha($fecha_nacimiento);

// Array de meses en español (completo)
$meses_espanol = [
    'January'   => 'Enero',
    'February'  => 'Febrero',
    'March'     => 'Marzo',
    'April'     => 'Abril',
    'May'       => 'Mayo',
    'June'      => 'Junio',
    'July'      => 'Julio',
    'August'    => 'Agosto',
    'September' => 'Septiembre',
    'October'   => 'Octubre',
    'November'  => 'Noviembre',
    'December'  => 'Diciembre'
];

// Formatear la fecha de nacimiento
$date   = new DateTime($fecha_nacimiento);
$today  = $date->format('d-F-Y');   // Ej: 15-March-1983
$today2 = $date->format('F d, Y'); // Ej: March 15, 1983

// Reemplazar el mes en inglés por español en la fecha de nacimiento
$today  = strtr($today, $meses_espanol);
$hoy    = strtr($hoy,   $meses_espanol);

// Construimos el texto "nacido/nacida el ..."
switch ($sexo) {
    case 'Masculino':
        if ($anios <= 15) {
            $sexo = "el niño ";
            $sex  = "the boy ";
        } elseif ($anios >= 16 && $anios <= 21) {
            $sexo = "el joven ";
            $sex  = "the young man ";
        } elseif ($anios >= 22) {
            $sexo = "el Sr. ";
            $sex  = "Mr. ";
        }
        $pasajero  = "que el pasajero";
        $passenger = "that the male passenger";
        $nacimiento = "nacido el " . $today;   // Español
        $born       = "born on " . $today2;    // Inglés
        // Pronombres en inglés (masculino)
        $pronoun_es   = "él";     // Para español
        $pronoun_en   = "him";    // Para inglés
        $possess_en   = "his";    // Para inglés
        break;

    case 'Femenino':
        if ($anios <= 15) {
            $sexo = "la niña ";
            $sex  = "the girl ";
        } elseif ($anios >= 16 && $anios <= 21) {
            $sexo = "la Srta. ";
            $sex  = "Miss ";
        } elseif ($anios >= 22) {
            $sexo = "la Sra. ";
            $sex  = "Ms ";
        }
        $pasajero  = "que la pasajera";
        $passenger = "that the female passenger";
        $nacimiento = "nacida el " . $today;   // Español
        $born       = "born on " . $today2;    // Inglés
        // Pronombres en inglés (femenino)
        $pronoun_es   = "ella";   // Para español
        $pronoun_en   = "her";    // Para inglés
        $possess_en   = "her";    // Para inglés
        break;
}

// Manejo de la información del perro
if ($esterilizado == "Si") {
    if ($sexo_perro == "Macho") {
        $sex_dog = "Male";
        $esterilizado = " que se encuentra esterilizado";
    } else {
        $sex_dog = "Female";
        $esterilizado = " que se encuentra esterilizada";
    }
} else {
    $esterilizado = "";
}

$mascota = $nombre_mascota; // El texto final de la mascota

// Por simplicidad establezco la versión manualmente para que siempre use la misma en pruebas
 $version = 1;

// Generar el texto en base al switch
switch ($version) {
case 1:
    // Versión 1 en ESPAÑOL (con cambio solicitado)
    $resultado = "
	    <b>A quien corresponda:</b><br><br>
	    <p>
	        Por medio de la presente, certifico que $sexo $nombre, $nacimiento, 
	        se encuentra bajo mi tratamiento por una <strong>condición emocional</strong> 
	        denominada Trastorno de Ansiedad, la cual está reconocida en el 
	        Manual Diagnóstico y Estadístico de los Trastornos Mentales (DSM-5).
	    </p><br>
	    <p>
	        Es fundamental $pasajero cuente con el acompañamiento de su mascota, 
	        un $raza de nombre $mascota, quien está entrenado como perro de servicio 
	        de apoyo para estrés postraumático. Este deberá permanecer con $pronoun_es 
	        tanto durante el viaje como en las actividades que realice en su destino.
	    </p><br>
	    <p>
	        Agradezco de antemano la atención prestada a esta solicitud 
	        y me mantengo disponible para cualquier aclaración o duda adicional.
	    </p>";
	
	    // Versión 1 en INGLÉS (con cambio solicitado)
	    $result = "
	    <b>To Whom It May Concern:</b><br><br>
	    <p>
	        I hereby certify that $sex $nombre, $born, is under my treatment 
	        for an <strong>emotional condition</strong> known as Anxiety Disorder, 
	        which is recognized in the Diagnostic and Statistical Manual of Mental Disorders (DSM-5).
	    </p><br>
	    <p>
	        It is essential $passenger be accompanied by $possess_en pet, 
	        a $raza named $mascota, who is trained as a service dog to provide support 
	        for post-traumatic stress. This dog must remain with $pronoun_en 
	        throughout the journey and during any activities at $possess_en destination.
	    </p><br>
	    <p>
	        Thank you in advance for your attention to this request. 
	        Please feel free to contact me for any additional information or clarification.
	    </p>";
	    break;


    case 2:
        // ---------- Versión 2 en ESPAÑOL ----------
        $resultado = "
        <b>A quien corresponda:</b><br><br>
        <p>
            Por la presente, hago constar que $sexo $nombre, $nacimiento, 
            se encuentra bajo mi tratamiento debido a un Trastorno de Angustia, 
            reconocido en el Manual Diagnóstico y Estadístico de los Trastornos Mentales (DSM-5).
        </p><br>
        <p>
            Es imprescindible que $pronoun_es cuente con el apoyo y la compañía de su mascota, 
            un $raza llamado $mascota, como animal de apoyo emocional, durante el viaje 
            y en las actividades que realice en su lugar de destino.
        </p><br>
        <p>
            Quedo agradecido por su atención a esta carta y me mantengo 
            a disposición para cualquier aclaración que sea necesaria.
        </p>";

        // ---------- Versión 2 en INGLÉS ----------
        $result = "
        <b>To Whom It May Concern:</b><br><br>
        <p>
            I hereby state that $sex $nombre, $born, is under my treatment 
            for a condition known as Panic Disorder, recognized in the 
            Diagnostic and Statistical Manual of Mental Disorders (DSM-5).
        </p><br>
        <p>
            It is crucial for $possess_en well-being that $pronoun_en be accompanied 
            by a $raza named $mascota as an emotional support animal, both during travel 
            and while engaging in activities at $possess_en destination.
        </p><br>
        <p>
            Thank you for your attention to this matter. I remain available 
            for any further clarification you may require.
        </p>";
        break;

    case 3:
        // ---------- Versión 3 en ESPAÑOL ----------
        $resultado = "
        <b>A quien corresponda:</b><br><br>
        <p>
            Por medio de la presente, certifico que $sexo $nombre, $nacimiento, 
            está recibiendo tratamiento bajo mi supervisión por una condición emocional 
            denominada Trastorno de Angustia, reconocida en el DSM-5.
        </p><br>
        <p>
            Es necesario que $pronoun_es cuente con la compañía de su mascota, 
            un $raza de nombre $mascota, como animal de apoyo emocional durante su viaje 
            y en las actividades que realice en su destino.
        </p><br>
        <p>
            Agradezco la atención prestada a esta solicitud y quedo a su disposición 
            para cualquier duda o aclaración que pueda surgir.
        </p>";

        // ---------- Versión 3 en INGLÉS ----------
        $result = "
        <b>To Whom It May Concern:</b><br><br>
        <p>
            I hereby certify that $sex $nombre, $born, is receiving treatment 
            under my supervision for an emotional condition called Panic Disorder, 
            recognized in the DSM-5.
        </p><br>
        <p>
            It is necessary for $pronoun_en to be accompanied by a $raza named $mascota, 
            serving as an emotional support animal throughout the trip 
            and during any activities at $possess_en destination.
        </p><br>
        <p>
            Thank you for your attention to this request. I remain at your disposal 
            for any questions or clarifications you may have.
        </p>";
        break;

    case 4:
        // ---------- Versión 4 en ESPAÑOL ----------
        $resultado = "
        <b>A quien corresponda:</b><br><br>
        <p>
            Certifico mediante la presente que $sexo $nombre, $nacimiento, 
            está bajo tratamiento médico por una discapacidad emocional 
            conocida como Trastorno de Angustia, tal como se describe en el DSM-5.
        </p><br>
        <p>
            Es indispensable que $pronoun_es cuente con el apoyo y la compañía de su mascota, 
            un $raza de nombre $mascota, como animal de apoyo emocional, 
            tanto durante el viaje como en las actividades en su destino.
        </p><br>
        <p>
            Agradezco de antemano su atención a esta comunicación y quedo disponible 
            para cualquier consulta o aclaración adicional.
        </p>";

        // ---------- Versión 4 en INGLÉS ----------
        $result = "
        <b>To Whom It May Concern:</b><br><br>
        <p>
            I hereby certify that $sex $nombre, $born, is under medical treatment 
            for an emotional disability known as Panic Disorder, as described in the DSM-5.
        </p><br>
        <p>
            It is essential for $pronoun_en to have the support and company of a $raza 
            named $mascota, serving as an emotional support animal, 
            both during travel and throughout $possess_en stay at the destination.
        </p><br>
        <p>
            Thank you in advance for your attention to this communication. 
            I remain available for any additional questions or clarifications.
        </p>";
        break;

    case 5:
        // ---------- Versión 5 en ESPAÑOL ----------
        $resultado = "
        <b>A quien corresponda:</b><br><br>
        <p>
            Por la presente, certifico que $sexo $nombre, $nacimiento, 
            se encuentra bajo mi tratamiento debido a un Trastorno de Angustia, 
            una discapacidad emocional reconocida en el Manual Diagnóstico y Estadístico 
            de los Trastornos Mentales (DSM-5).
        </p><br>
        <p>
            Es imprescindible que $pronoun_es cuente con la compañía de su mascota, 
            un $raza llamado $mascota, como animal de apoyo emocional durante el viaje 
            y en las actividades que realice en su destino.
        </p><br>
        <p>
            Agradezco su atención a la presente y quedo a su disposición 
            para cualquier aclaración o información adicional que sea requerida.
        </p>";

        // ---------- Versión 5 en INGLÉS ----------
        $result = "
        <b>To Whom It May Concern:</b><br><br>
        <p>
            I hereby certify that $sex $nombre, $born, is under my treatment 
            for a Panic Disorder, an emotional disability recognized in the 
            Diagnostic and Statistical Manual of Mental Disorders (DSM-5).
        </p><br>
        <p>
            It is imperative for $pronoun_en to be accompanied by a $raza named $mascota, 
            serving as an emotional support animal, throughout the trip 
            and during any activities at $possess_en destination.
        </p><br>
        <p>
            Thank you for your attention to this matter. I remain available 
            for any additional clarification or information required.
        </p>";
        break;

    case 6:
        // ---------- Versión 6 en ESPAÑOL ----------
        $resultado = "
        <b>A quien corresponda:</b><br><br>
        <p>
            Por la presente hago constar que actualmente estoy tratando a $sexo $nombre, 
            $nacimiento, por una discapacidad emocional llamada Trastorno de Angustia, 
            la cual es reconocida en el Manual de Diagnóstico y Estadística 
            de los Trastornos Mentales (DSM-5).
        </p><br>
        <p>
            Es necesario el apoyo emocional y acompañamiento de su mascota, 
            un $raza de nombre $mascota, como animal de apoyo emocional, 
            tanto durante el viaje como en las actividades que realice en su destino.
        </p><br>
        <p>
            Agradecido por la atención brindada a la presente, quedo atento 
            a cualquier duda o aclaración.
        </p>";

        // ---------- Versión 6 en INGLÉS ----------
        $result = "
        <b>To Whom It May Concern:</b><br><br>
        <p>
            I hereby attest that I am currently treating $sex $nombre, $born, 
            for an emotional disability called Panic Disorder, 
            which is recognized in the Diagnostic and Statistical Manual of Mental Disorders (DSM-5).
        </p><br>
        <p>
            Emotional support and accompaniment by $possess_en pet, 
            a $raza named $mascota, is necessary throughout the trip 
            and for activities at $possess_en destination, as an emotional support animal.
        </p><br>
        <p>
            Thank you for your attention to this matter. I remain available 
            for any questions or clarifications.
        </p>";
        break;

    default:
        $resultado = "Versión no válida. Por favor, selecciona un valor entre 1 y 6.";
        $result    = "Invalid version. Please select a value between 1 and 6.";
        break;
}

// Construir el cuerpo del PDF (ejemplo)
$cuerpo_pdf = "

<html>
<head>
    <title></title>
    <meta charset='UTF-8'>
</head>
<body style='font-family: Arial, sans-serif;'>
    <div style='margin: 20px; padding: 20px;'>
    <table style='width: 100%' >
        <tr>
            <td align='center' style='background: #fff; width: 50%'>
                <img style='width: auto; height: 180px;' src='../images/logo_psiquiatria.png' alt='grafica'>
            </td>
            <td align='right' style='background: #fff; width: 50%; font-family: Times'>
                <p>
                    Av. de los Arcos 876, Jardines del Bosque.<br>
                    Guadalajara, Jalisco. CP. 44520<br>
                    dr.alejandro.aldana@hotmail.com<br>
                    3312613701
                </p><br>
                <b>$hoy</b>
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td colspan='2' style='padding: 8px; font-family: Times'>
                $resultado
            </td>
        </tr>
        <tr>
            <td align='center' style='background: #fff; width: 60%; height: 550px;'>
            </td>
            <td align='left' style='background: #fff; width: 40%; padding-top: 300px'>
                <img style='width: auto; height: 150px;' src='../images/firma.png' alt='grafica'>
            </td>
        </tr>
        <tr>
            <td colspan='2' align='right' style='font-family: Times'>
                <p>
                    <b>DR JESÚS ALEJANDRO ALDANA LÓPEZ</b><br><br>
                    Universidad de Guadalajara - Médico Cirujano y Partero 8465806; Especialista en Psiquiatría 14058107<br>
                    Universidad del Valle de México - Maestro en Educación con Orientación en Innovación y Tecnologías 13061936
                </p>
            </td>
        </tr>
    </table>
    </div>
    
    <pagebreak />
    
    <div style='margin: 20px; padding: 20px;'>
        <table style='width: 100%;'>
            <tr>
                <td align='center' style='background: #fff; width: 50%;'>
                    <img style='width: auto; height: 180px;' src='../images/logo_psiquiatria.png' alt='image'>
                </td>
                <td align='right' style='background: #fff; width: 50%; font-family: Times;'>
                    <p>
                        Av. de los Arcos 876, Jardines del Bosque.<br>
                        Guadalajara, Jalisco. Zip Code 44520<br>
                        dr.alejandro.aldana@hotmail.com<br>
                        3312613701
                    </p><br>
                    <b>$hoy2</b>
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td colspan='2' style='padding: 8px; font-family: Times;'>
                    $result
                </td>
            </tr>
            <tr>
                <td align='center' style='background: #fff; width: 60%; height: 550px;'>
                </td>
                <td align='left' style='background: #fff; width: 40%; padding-top: 300px;'>
                    <img style='width: auto; height: 150px;' src='../images/firma.png' alt='image'>
                </td>
            </tr>
            <tr>
                <td colspan='2' align='right' style='font-family: Times;'>
                    <p>
                        <b>DR. JESÚS ALEJANDRO ALDANA LÓPEZ</b><br><br>
                        Universidad de Guadalajaradri – General Physician and Midwife 8465806; Psychiatry Specialist 14058107<br>
                        Universidad del Valle de México – Master’s in Education with a Focus on Innovation and Technologies 13061936
                    </p>
                </td>
            </tr>
        </table>
    </div>
    
    <pagebreak />
    
    <div style='margin: 0; padding: 0;'>
        <img style='width: 100%; height: 140%;' src='../images/cedula_aldana.jpg' alt='grafica'>
    </div>

</body>
</html>
";

// Cargar la librería mPDF
require_once __DIR__ . '/../vendor/autoload.php';

// Crear instancia de mPDF
$mpdf = new \Mpdf\Mpdf([
    'margin_top'    => 0,
    'margin_bottom' => 0,
    'margin_left'   => 0,
    'margin_right'  => 0
]);

// Escribir el HTML en el PDF
$mpdf->WriteHTML($cuerpo_pdf);

// Mostrar el PDF en el navegador
$mpdf->Output('Carta_Paciente_'.$id.'.pdf','I');
