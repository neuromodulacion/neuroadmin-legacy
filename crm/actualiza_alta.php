<?php
include('../functions/funciones_mysql.php'); // Incluir el archivo con la función ejecutar

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Imprimir datos recibidos para depuración
    print_r($_POST);

    // Recibir y limpiar datos del formulario
    $usuario_id = $_POST['usuario_id'];
    $nombre = $_POST['nombre'];
    $usuario = validarSinEspacio($_POST['usuario']);
    $telefono = validarSinEspacio($_POST['telefono']);
    $observaciones = $_POST['observaciones'];
    $especialidad = $_POST['especialidad'];
    $horarios = $_POST['horarios'];
    $estatus = $_POST['estatus'];

    // Verificar si ya existe un registro con el usuario_id
    $sql_check = "SELECT * FROM admin WHERE usuario_id = $usuario_id";
    $resultado_check = ejecutar($sql_check);

    $sql_update = "
		UPDATE admin 
		SET 
			nombre = '$nombre',
			usuario = '$usuario',
			telefono = '$telefono',
			observaciones = '$observaciones',
			especialidad = '$especialidad',
			horarios = '$horarios',
			estatus = '$estatus' 
		WHERE
			usuario_id = $usuario_id";
    $resultado_update = ejecutar($sql_update);
	echo $sql_update;
    
	
    if ($resultado_update) {
        echo "Registro actualizado con éxito.";
    } else {
        echo "Hubo un error al actualizar los datos.";
    }
}
?>
