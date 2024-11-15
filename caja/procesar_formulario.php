
<?php
include($ruta.'functions/fun_inicio.php');
// archivos para correos
print_r($_POST);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $sexo = $_POST['sexo'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $padecimiento = $_POST['padecimiento'];
    $raza = $_POST['raza'];
    $sexo_perro = $_POST['sexo_perro'];
    $esterilizado = $_POST['esterilizado'];
    $nombre_mascota = $_POST['nombre_mascota'];
    $edad_perro = $_POST['edad_perro'];


    $sql = "INSERT INTO registros_carta_perro (nombre, sexo, fecha_nacimiento, padecimiento, raza, sexo_perro, esterilizado, nombre_mascota, edad_perro)
            VALUES ('$nombre', '$sexo', '$fecha_nacimiento', '$padecimiento', '$raza', '$sexo_perro', '$esterilizado', '$nombre_mascota', '$edad_perro')";
	echo $sql;
    if (ejecutar($sql)) {
        echo "Registro guardado exitosamente.";
    } else {
        echo "Error al guardar el registro.";
    }
}
?>
