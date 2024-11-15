<?php
include('../functions/funciones_mysql.php');
session_start();
error_reporting(7);
iconv_set_encoding('internal_encoding', 'utf-8'); 
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');
$_SESSION['time']=mktime();

$ruta = "../";
extract($_POST);
print_r($_POST);
// echo "<hr>";
extract($_SESSION);
// print_r($_SESSION);
// echo "<hr>";
//$aviso = stripslashes($_POST['aviso']); 
//include('fun_cuestionario.php'); 

//	$imagenFirma = $_POST['imagenFirma'];
	
//	echo $imagenFirma;
	
	// $imagenFirma = str_replace('data:image/png;base64,', '', $imagenFirma);
	// $imagenFirma = str_replace(' ', '+', $imagenFirma);
	// $data = base64_decode($imagenFirma);
	// $archivo = 'firma_' . uniqid() . '.png';
	// file_put_contents($archivo, $data);


// Aquí también puedes insertar la cadena base64 en MySQL.

if (isset($_FILES['file'])) {
    $file = $_FILES['file'];

    // Puedes agregar más validaciones aquí (por ejemplo, verificar el tipo de archivo)

    $destinationPath = 'firmas/' . $file['name'];
    if (move_uploaded_file($file['tmp_name'], $destinationPath)) {
        echo 'Firma guardada correctamente';
    } else {
        echo 'Error al guardar el archivo';
    }
	
} else {
    echo 'No se recibió ningún archivo';
}



?>
