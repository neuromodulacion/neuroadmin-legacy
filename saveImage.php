<?php
// Obtener la cadena de la imagen desde la solicitud POST
$img = $_POST['img'];

// Eliminar el prefijo "data:image/jpeg;base64," de la cadena
$img = str_replace('data:images/jpeg;base64,', '', $img);

// Decodificar la cadena en datos binarios
$data = base64_decode($img);

// Guardar los datos binarios como un archivo JPG
file_put_contents('myImagetest.jpg', $data);
?>

