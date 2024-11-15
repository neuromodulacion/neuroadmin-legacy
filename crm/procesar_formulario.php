<?php
include('../functions/funciones_mysql.php'); // Incluir el archivo con la función ejecutar

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir y limpiar datos del formulario
    $usuario_id = $_POST['usuario_id'];
    $domicilio = $_POST['domicilio'];
    $latitud = $_POST['latitud'];
    $longitud = $_POST['longitud'];
    $telefono = $_POST['telefono'];
    $extension = $_POST['extension'];
    $observaciones = $_POST['observaciones'];
print_r($_POST);
    // Consulta para verificar si ya existe un registro para el usuario_id
    $sql_check = "SELECT * FROM ubicacion_medico WHERE usuario_id = $usuario_id";
	//echo $sql_check;
    $resultado_check = ejecutar($sql_check);

    if ($resultado_check && mysqli_num_rows($resultado_check) > 0) {
        // Si existe el registro, actualizamos
        $sql_update = "UPDATE ubicacion_medico 
                       SET domicilio = '$domicilio', latitud = '$latitud', longitud = '$longitud', 
                           telefono = '$telefono', extension = '$extension', observaciones = '$observaciones'
                       WHERE usuario_id = $usuario_id";
        $resultado_update = ejecutar($sql_update);

        if ($resultado_update) {
            echo "Registro actualizado con éxito.";
			echo $sql_check."<br>".$sql_update;
        } else {
            echo "Hubo un error al actualizar los datos.";
			echo $sql_check."<br>".$sql_update;
        }
    } else {
        // Si no existe el registro, insertamos uno nuevo
        $sql_insert = "INSERT INTO ubicacion_medico (usuario_id, domicilio, latitud, longitud, telefono, extension, observaciones) 
                       VALUES ($usuario_id, '$domicilio', '$latitud', '$longitud', '$telefono', '$extension', '$observaciones')";
        $resultado_insert = ejecutar($sql_insert);

        if ($resultado_insert) {
            echo "Registro guardado con éxito.";
			echo $sql_check."<br>".$sql_insert;
        } else {
            echo "Hubo un error al guardar los datos.";
            echo $sql_check."<br>".$sql_insert;
        }
    }
}
?>
