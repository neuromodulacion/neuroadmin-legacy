<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $target_dir = "uploads/"; // Directorio donde se guardará el archivo
    $target_file = $target_dir . basename($_FILES["file"]["name"]);

    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Verificar si el archivo tiene una extensión permitida
    $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
    if (!in_array($imageFileType, $allowedTypes)) {
        echo json_encode(['error' => 'Solo se permiten archivos JPG, JPEG, PNG y GIF. Tipo de archivo subido: ' . strtoupper($imageFileType) . '.']);
        exit;
    }

    // Verificar si el archivo es realmente una imagen
    if (getimagesize($_FILES["file"]["tmp_name"]) === false) {
        echo json_encode(['error' => 'El archivo no es una imagen.']);
        exit;
    }

    // Intenta mover el archivo subido al directorio objetivo
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        $nombreArchivo = basename($_FILES["file"]["name"]); // Obtener solo el nombre del archivo
        echo $nombreArchivo;
    } else {
        echo json_encode(['error' => 'Hubo un error subiendo el archivo.']);
    }
} else {
    echo json_encode(['error' => 'Método de solicitud no permitido.']);
}
?>



