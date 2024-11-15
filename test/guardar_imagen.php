<?php
//$time = mktime();
//$paciente_id = 68;
//extract($_POST);

if (isset($_POST['image'])) {
    $imgData = $_POST['image'];
	
	// Recuperar la información adicional
	$paciente_id = $_POST['paciente_id'];
	
    // Elimina el prefijo de "data:image/png;base64,"
    $imgData = str_replace('data:image/png;base64,', '', $imgData);

    // Decodifica el base64 en un archivo de imagen
    $imgData = base64_decode($imgData);

    // Ruta donde se guardará la imagen
    $rutaImagen = 'image/imagen_'.$paciente_id.'.png';

    // Guarda la imagen en el servidor
    file_put_contents($rutaImagen, $imgData);
}


?>

