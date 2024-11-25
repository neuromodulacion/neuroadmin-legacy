<?php
//pdf_reporte.php
include('../functions/funciones_mysql.php');
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


$ruta = "../";
extract($_SESSION);
extract($_POST);

//phpinfo();

// Cargar la biblioteca mPDF
//require_once '../vendor/autoload.php';

// Crear un nuevo objeto mPDF
//$mpdf = new \Mpdf\Mpdf();

// Crear una imagen de la gráfica lineal con GD
$width = 500; // Ancho de la imagen
$height = 300; // Altura de la imagen
$image = imagecreate($width, $height);

// Establecer el color de fondo de la imagen
$backgroundColor = imagecolorallocate($image, 255, 255, 255);
imagefill($image, 0, 0, $backgroundColor);

// Establecer el color de la línea de la gráfica
$lineColor = imagecolorallocate($image, 0, 0, 0);

// Generar los datos de ejemplo para la gráfica lineal
$data = [10, 20, 30, 40, 50, 60, 70];

// Dibujar la gráfica lineal
$points = count($data);
$pointWidth = $width / ($points - 1);
for ($i = 0; $i < $points; $i++) {
    $x1 = $i * $pointWidth;
    $y1 = $height - ($data[$i] * $height / max($data));
    if ($i > 0) {
        imageline($image, $x0, $y0, $x1, $y1, $lineColor);
    }
    $x0 = $x1;
    $y0 = $y1;
}

// Guardar la imagen en un archivo temporal
$tempImageFile = tempnam(sys_get_temp_dir(), 'chart');
imagepng($image, $tempImageFile);

// Insertar la imagen en el archivo PDF
//$mpdf->Image($tempImageFile);

// Eliminar el archivo temporal de la imagen


// Generar el archivo PDF
//$mpdf->Output('grafica.pdf', 'D');


$html = $tempImageFile;

$hola = '

<pageheader name="myHeaderNoNum" content-left="My Book Title" content-center="myHeader1" content-right="" header-style="font-family:sans-serif; font-size:8pt; color:#880000;" header-style-right="font-size:12pt; font-weight:bold; font-style:italic; color:#088000;" line="on" />

<pageheader name="myHeaderNoNumEven" content-left="" content-center="myHeader1Even" content-right="{DATE j-m-Y}" header-style="font-family:sans-serif; font-size:8pt; color:#000088;" header-style-left="font-weight:bold; " line="on" />

<pageheader name="myHeader1" content-left="My Book Title" content-center="myHeader1" content-right="{PAGENO}" header-style="font-family:sans-serif; font-size:8pt; color:#880000;" header-style-right="font-size:12pt; font-weight:bold; font-style:italic; color:#088000;" line="on" />

<pageheader name="myHeader1Even" content-left="{PAGENO}" content-center="myHeader1Even" content-right="{DATE j-m-Y}" header-style="font-family:sans-serif; font-size:8pt; color:#000088;" header-style-left="font-weight:bold; " line="on" />


<htmlpageheader name="myHTMLHeader1" style="display:none">
<table width="100%" style="border-bottom: 1px solid #000000; vertical-align: bottom; font-family: serif; font-size: 9pt; color: #000088;"><tr>
<td width="33%">Left header p <span style="font-size:14pt;">{PAGENO}</span></td>
<td width="33%" align="center"><img src="sunset.jpg" width="126px" /></td>
<td width="33%" style="text-align: right;"><span style="font-weight: bold;">Right header</span></td>
</tr></table>
</htmlpageheader>

<htmlpageheader name="myHTMLHeader1Even" style="display:none">
<table width="100%" style="border-bottom: 1px solid #000000; vertical-align: bottom; font-family: serif; font-size: 9pt; color: #000088;"><tr>
<td width="33%"><span style="font-weight: bold;">Outer header</span></td>
<td width="33%" align="center"><img src="sunset.jpg" width="126px" /></td>
<td width="33%" style="text-align: right;">Inner header p <span style="font-size:14pt;">{PAGENO}</span></td>
</tr></table>
</htmlpageheader>

<pagefooter name="myFooter1" content-left="My Book Title" content-center="myFooter1" content-right="{PAGENO}" footer-style="font-family:sans-serif; font-size:8pt; font-weight:bold; color:#008800;" footer-style-left="" line="on" />

<pagefooter name="myFooter1Even" content-left="{PAGENO}" content-center="myFooter1Even" content-right="{DATE j-m-Y}" footer-style="font-family:sans-serif; font-size:10pt; color:#000880;" footer-style-left="font-weight:bold; " line="on" />


<setpageheader name="myHeaderNoNum" page="O" value="on" show-this-page="1" />
<setpageheader name="myHeaderNoNumEven" page="E" value="on" />

<h1 style="margin-collapse: none; margin-top: 35mm">Introduction</h1>
<div>Introduction</div>
<p>Integer feugiat venenatis metus. Integer lacinia ultrices ipsum. Proin et arcu. Quisque varius libero. Nullam id arcu. Aenean justo quam, accumsan nec, luctus id, pellentesque molestie, mi. Aliquam sollicitudin feugiat eros. Nunc nisi turpis, consequat id, aliquet et, semper a, augue. Integer nisl ipsum, blandit et, lobortis a, egestas nec, odio. Nulla dolor ligula, nonummy ac, vulputate a, sollicitudin id, orci. <!--Donec laoreet nisl id magna. Curabitur mollis, quam eget fermentum malesuada, risus tortor ullamcorper dolor, nec placerat nisi urna non pede. Aliquam pretium, leo in interdum interdum, ipsum neque accumsan lectus, ac fringilla dui ipsum sed justo. In tincidunt risus convallis odio egestas luctus. Integer volutpat. Donec ultricies, leo in congue iaculis, dolor neque imperdiet nibh, vitae feugiat mi enim nec sapien. -->Aenean turpis lorem, consequat quis, varius in, posuere vel, eros. Nulla facilisi.</p>

<tocpagebreak toc-orientation="landscape" font="mono" font-size="12" indent="5" paging="on" links="on" resetpagenum="1" suppress="off" pagenumstyle="1" orientation="portrait" margin-top="55mm" odd-header-name="myHeader1" odd-header-value="1" even-header-name="html_myHTMLHeader1Even" even-header-value="1" odd-footer-name="myFooter1" odd-footer-value="1" even-footer-name="myFooter1Even" even-footer-value="1"  toc-odd-header-name="myHeaderNoNum" toc-odd-header-value="1" toc-even-header-name="myHeaderNoNumEven" toc-even-header-value="1" toc-odd-footer-name="" toc-odd-footer-value="-1" toc-even-footer-name="" toc-even-footer-value="-1" />

<h1>Section 2<tocentry content="Section 2" /></h1>
<div>Section 2</div>
<p>Integer feugiat venenatis metus. Integer lacinia ultrices ipsum. Proin et arcu. Quisque varius libero. Nullam id arcu. Aenean justo quam, accumsan nec, luctus id, pellentesque molestie, mi. Aliquam sollicitudin feugiat eros. Nunc nisi turpis, consequat id, aliquet et, semper a, augue. Integer nisl ipsum, blandit et, lobortis a, egestas nec, odio. Nulla dolor ligula, nonummy ac, vulputate a, sollicitudin id, orci. Donec laoreet nisl id magna. Curabitur mollis, quam eget fermentum malesuada, risus tortor ullamcorper dolor, nec placerat nisi urna non pede. Aliquam pretium, leo in interdum interdum, ipsum neque accumsan lectus, ac fringilla dui ipsum sed justo. In tincidunt risus convallis odio egestas luctus. Integer volutpat. Donec ultricies, leo in congue iaculis, dolor neque imperdiet nibh, vitae feugiat mi enim nec sapien. Aenean turpis lorem, consequat quis, varius in, posuere vel, eros. Nulla facilisi.</p>

<pagebreak type="NEXT-ODD" margin-left="60mm" margin-right="40mm" margin-top="55mm" margin-bottom="30mm" margin-header="12mm" margin-footer="12mm" odd-header-name="html_myHTMLHeader1" odd-header-value="1" even-header-name="myHeader1Even" even-header-value="1" odd-footer-name="myFooter1" odd-footer-value="1" even-footer-name="myFooter1Even" even-footer-value="1" />

<h1>Section 3<tocentry content="Section 3" /></h1>
<div>Section 3</div>
<p>Integer feugiat venenatis metus. Integer lacinia ultrices ipsum. Proin et arcu. Quisque varius libero. Nullam id arcu. Aenean justo quam, accumsan nec, luctus id, pellentesque molestie, mi. Aliquam sollicitudin feugiat eros. Nunc nisi turpis, consequat id, aliquet et, semper a, augue. Integer nisl ipsum, blandit et, lobortis a, egestas nec, odio. Nulla dolor ligula, nonummy ac, vulputate a, sollicitudin id, orci. Donec laoreet nisl id magna. Curabitur mollis, quam eget fermentum malesuada, risus tortor ullamcorper dolor, nec placerat nisi urna non pede. Aliquam pretium, leo in interdum interdum, ipsum neque accumsan lectus, ac fringilla dui ipsum sed justo. In tincidunt risus convallis odio egestas luctus. Integer volutpat. Donec ultricies, leo in congue iaculis, dolor neque imperdiet nibh, vitae feugiat mi enim nec sapien. Aenean turpis lorem, consequat quis, varius in, posuere vel, eros. Nulla facilisi.</p>

<pagebreak orientation="landscape" type="NEXT-ODD" margin-left="60mm" margin-right="40mm" margin-top="55mm" margin-bottom="30mm" margin-header="12mm" margin-footer="12mm" />

<h1>Section 4<tocentry content="Section 4" /></h1>
<div>Section 4</div>
<p>Integer feugiat venenatis metus. Integer lacinia ultrices ipsum. Proin et arcu. Quisque varius libero. Nullam id arcu. Aenean justo quam, accumsan nec, luctus id, pellentesque molestie, mi. Aliquam sollicitudin feugiat eros. Nunc nisi turpis, consequat id, aliquet et, semper a, augue. Integer nisl ipsum, blandit et, lobortis a, egestas nec, odio. Nulla dolor ligula, nonummy ac, vulputate a, sollicitudin id, orci. Donec laoreet nisl id magna. Curabitur mollis, quam eget fermentum malesuada, risus tortor ullamcorper dolor, nec placerat nisi urna non pede. Aliquam pretium, leo in interdum interdum, ipsum neque accumsan lectus, ac fringilla dui ipsum sed justo. In tincidunt risus convallis odio egestas luctus. Integer volutpat. Donec ultricies, leo in congue iaculis, dolor neque imperdiet nibh, vitae feugiat mi enim nec sapien. Aenean turpis lorem, consequat quis, varius in, posuere vel, eros. Nulla facilisi.</p>


<pagebreak orientation="portrait" type="NEXT-ODD" margin-left="40mm" margin-right="20mm" odd-header-name="myHeader1" odd-header-value="1" even-header-name="myHeader1Even" even-header-value="1" odd-footer-name="myFooter1" odd-footer-value="1" even-footer-name="myFooter1Even" even-footer-value="1" suppress="off" />


<h1>Section 5<tocentry content="Section 5" /></h1>
<div>Section 5</div>
<p>Integer feugiat venenatis metus. Integer lacinia ultrices ipsum. Proin et arcu. Quisque varius libero. Nullam id arcu. Aenean justo quam, accumsan nec, luctus id, pellentesque molestie, mi. Aliquam sollicitudin feugiat eros. Nunc nisi turpis, consequat id, aliquet et, semper a, augue. Integer nisl ipsum, blandit et, lobortis a, egestas nec, odio. Nulla dolor ligula, nonummy ac, vulputate a, sollicitudin id, orci. Donec laoreet nisl id magna. Curabitur mollis, quam eget fermentum malesuada, risus tortor ullamcorper dolor, nec placerat nisi urna non pede. Aliquam pretium, leo in interdum interdum, ipsum neque accumsan lectus, ac fringilla dui ipsum sed justo. In tincidunt risus convallis odio egestas luctus. Integer volutpat. Donec ultricies, leo in congue iaculis, dolor neque imperdiet nibh, vitae feugiat mi enim nec sapien. Aenean turpis lorem, consequat quis, varius in, posuere vel, eros. Nulla facilisi.</p>

';

//==============================================================
//==============================================================
//==============================================================
include("$ruta/mpdf60/mpdf.php");
$mpdf=new mPDF('c'); 

$mpdf->mirrorMargins = true;

$mpdf->SetDisplayMode('fullpage','two');

$mpdf->WriteHTML($html);

$mpdf->Output();

unlink($tempImageFile);
exit;
//==============================================================
//==============================================================
//==============================================================
//==============================================================
//==============================================================


?>