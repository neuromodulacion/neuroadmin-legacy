<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

extract($_GET);
extract($_POST);

// if ($php = 'I') {
	// include('../functions/funciones_mysql.php');
// }else{
	// $php = 'F';
// }


$sql ="
SELECT
	id,
	nombre_completo,
	profesion,
	celular,
	correo,
	fecha_registro,
	estatus 
FROM
	participantes 
WHERE
	id = $id";
	//echo $sql;	
    $result=ejecutar($sql); 
    $row = mysqli_fetch_array($result);
    extract($row);	


require_once __DIR__ . '/../vendor/autoload.php';

use Mpdf\Mpdf;

// Inicializa mPDF con la orientación horizontal
//$mpdf = new Mpdf(['orientation' => 'L']);
// Inicializa mPDF con tamaño de página específico
//'format' => [444, 250]
$mpdf = new Mpdf([
    'format' => [356, 200]
]);
// Define la ruta de la imagen de fondo
$backgroundImage = '../images/reconocimiento_seminario.jpg'; // Ajusta esta ruta según sea necesario

// Establece la imagen de fondo
$mpdf->SetDefaultBodyCSS('background', "url('{$backgroundImage}')");
$mpdf->SetDefaultBodyCSS('background-image-resize', 6);

// Añade contenido HTML con estilos
$html = '
<!DOCTYPE html>
<html>
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mukta+Mahee:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: \'Mukta Mahee\', sans-serif;
            text-align: center;
            padding: 50px; /* Ajusta según sea necesario */
        }
        .diploma-header {
            font-size: 38px;
            font-weight: bold;
            margin-bottom: 20px;
			color: #005157;
			padding-right: 17%;
        }
        .recipient-name {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
			padding-right: 17%;
        }
        .description {
            font-size: 22px;
            margin-bottom: 20px;
            width: 80%;
            padding-right: 17%;
        }
        .footer {
            font-size: 24px;
            margin-top: 20px;
			padding-right: 17%;
        }
        .signature {
            position: absolute;
            width: 170px;
            top: -60px; /* Ajusta esta posición según sea necesario */
            left: 50%;
            transform: translateX(-50%);
			padding-right: -25%;
        }
    </style>
</head>
<body>
    <div class="diploma-header">NEUROMODULACIÓN <b>GDL</b></div>
    <div class="description"><b>CONSTANCIA DE ASISTENCIA</b></div>
    <div class="description">Por medio de la presente, se hace constar que:</div>
    <div class="recipient-name">Dr. '.$nombre_completo.'</div>
    <div class="description">
        ha asistido y participado en el:<br>
        "Seminario Especializado en Neuromodulación Clínica: Innovación y Tecnología en Salud Mental",<br>
        llevado a cabo el día 13 Julio 2024, en Guadalajara,
    </div>
    <div class="description">
        Durante el seminario se impartieron conocimientos avanzados sobre las técnicas de neuromodulación, incluyendo la estimulación magnética transcraneal (TMS) y la estimulación transcraneal por corriente directa (tDCS), así como su aplicación práctica y basada en evidencia en el tratamiento de trastornos mentales y neurológicos, con una duración de 3 horas.
    </div>
    <div class="footer">
    	<img class="signature" src="../images/firma.png" alt="Firma">
        Dr. Jesús Alejandro Aldana López<br>     
        <b style="color: #0096AA">Director de Neuromodulación GDL</b>      
    </div>  
</body>
</html>
';
//echo $html;
//Escribe el contenido HTML en el PDF
$mpdf->WriteHTML($html);


	$pdf = 'F';



// Guarda el PDF en un archivo
$mpdf->Output('constancias/diploma_'.$id.'.pdf', $pdf);
?>