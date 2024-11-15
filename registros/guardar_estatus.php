<?php
$ruta = '../';
include '../functions/funciones_mysql.php';

extract($_POST);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $estatus = $_POST['estatus'];
    $observaciones = $_POST['observaciones'];
	$participante_id = $_POST['id'];

    // Ajusta el ID del participante según tu lógica
    //$participante_id = $id; // Por ejemplo

    $sql = "INSERT INTO participantes_validacion (id, estatus, observaciones) VALUES ('$participante_id', '$estatus', '$observaciones')";
    
    if (ejecutar($sql)) {
        echo "Estatus y observaciones guardados exitosamente.";
    } else {
        echo "Error al guardar el estatus y las observaciones.";
    }
	
	$sql ="
		UPDATE participantes 
		SET estatus = '$estatus' 
		WHERE
			id = $participante_id
		";
	ejecutar($sql);
	
}

 header("Location: ver_registrados.php");
// header("Location: test.php");

?>
