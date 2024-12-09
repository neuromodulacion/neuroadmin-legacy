<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['image'])) {
    $imgData = $_POST['image'];

	// Recuperar la información adicional
	$paciente_id = $_POST['paciente_id'];
	//$encuesta_id = $_POST['encuesta_id'];
	
	//$paciente_id = $paciente_id."_".$encuesta_id;
	
    // Elimina el prefijo de "data:image/png;base64,"
    $imgData = str_replace('data:image/png;base64,', '', $imgData);

    // Decodifica el base64 en un archivo de imagen
    $imgData = base64_decode($imgData);

    // Ruta donde se guardará la imagen
    $rutaImagen = 'image/imagen_'.$paciente_id.'.png';
	//$rutaImagen = '../uplpads/imagen_'.$paciente_id.'.png';
    // Guarda la imagen en el servidor
    file_put_contents($rutaImagen, $imgData);
}


/*

// Validar si se recibió la imagen
if (isset($_POST['image']) && isset($_POST['paciente_id'])) {
    $imgData = $_POST['image'];
    $paciente_id = intval($_POST['paciente_id']); // Convertir a entero para mayor seguridad

    // Elimina el prefijo de la imagen base64
    $imgData = str_replace('data:image/png;base64,', '', $imgData);
    $imgData = base64_decode($imgData, true); // Decodifica y verifica si es válido

    // Verificar que la decodificación fue exitosa
    if ($imgData === false) {
        http_response_code(400);
        echo json_encode(['error' => 'Formato de imagen inválido']);
        exit;
    }

    // Ruta absoluta para guardar la imagen
    $rutaImagen = __DIR__ . '/image/imagen_' . $paciente_id . '.png';

    // Guardar la imagen en el servidor
    if (file_put_contents($rutaImagen, $imgData) !== false) {
        echo json_encode(['success' => 'Imagen guardada correctamente', 'path' => $rutaImagen]);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'No se pudo guardar la imagen']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Datos incompletos']);
}*/
?>

