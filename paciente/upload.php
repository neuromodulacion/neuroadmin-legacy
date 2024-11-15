<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $paciente_id = $_POST['paciente_id'] ?? null;
    if (!$paciente_id) {
        echo json_encode(['error' => 'ID de paciente no especificado.']);
        exit;
    }

    $base_dir = "uploads/archivos/paciente_" . $paciente_id . "/";
    if (!is_dir($base_dir)) {
        mkdir($base_dir, 0777, true);
    }

    $target_file = $base_dir . basename($_FILES["file"]["name"]);
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowedTypes = array('jpg', 'jpeg', 'png', 'gif', 'pdf');

    if (!in_array($fileType, $allowedTypes)) {
        echo json_encode(['error' => 'Solo se permiten archivos JPG, JPEG, PNG, GIF y PDF.']);
        exit;
    }

    if ($_FILES["file"]["size"] > 3 * 1024 * 1024) {
        echo json_encode(['error' => 'El archivo es demasiado grande. Tamaño máximo permitido: 3 MB.']);
        exit;
    }

    if (in_array($fileType, ['jpg', 'jpeg', 'png', 'gif']) && getimagesize($_FILES["file"]["tmp_name"]) === false) {
        echo json_encode(['error' => 'El archivo no es una imagen válida.']);
        exit;
    }

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        $fileTypeLabel = in_array($fileType, ['jpg', 'jpeg', 'png', 'gif']) ? 'Imagen' : 'PDF';
        echo json_encode([
            'name' => basename($target_file),
            'type' => $fileTypeLabel,
            'path' => $target_file
        ]);
    } else {
        echo json_encode(['error' => 'Hubo un error al subir el archivo.']);
    }
} else {
    echo json_encode(['error' => 'Método de solicitud no permitido.']);
}
?>
