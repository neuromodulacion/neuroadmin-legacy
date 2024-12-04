<?php
include('../functions/funciones_mysql.php'); // Asegurarnos de que esta ruta sea correcta

// Obtener los datos enviados por POST
$paciente_id = $_POST['paciente_id'];

$recomendacion_gpt = htmlspecialchars(trim($_POST['recomendacion_gpt']), ENT_QUOTES, 'UTF-8');
$informe_gpt = htmlspecialchars(trim($_POST['informe_gpt']), ENT_QUOTES, 'UTF-8');


// Verificar que los datos están definidos y no están vacíos
if (isset($paciente_id) && !empty($paciente_id)) {
    // Preparar la consulta de actualización
    $sql = "UPDATE pacientes SET 
            recomendacion_gpt = '$recomendacion_gpt', 
            informe_gpt = '$informe_gpt' 
            WHERE paciente_id = $paciente_id";
    
    // Ejecutar la consulta
    $result = ejecutar($sql); // Función para ejecutar la consulta (asumida como definida)

    // Verificar si la actualización fue exitosa
    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No se pudo actualizar la información en la base de datos.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Datos inválidos.']);
}
?>
