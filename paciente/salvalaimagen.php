<?php
// error_log('Ocurrió un error al procesar la solicitud');
// //extract($_POST);
// // Obtener la cadena de la imagen desde la solicitud POST
// 
// 
 // $img = $_POST['img'];
// 
// 
// // Eliminar el prefijo "data:image/jpeg;base64," de la cadena
// $img = str_replace('data:image/jpeg;base64,', '', $img);
// 
// // Decodificar la cadena en datos binarios
// $data = base64_decode($img);
// 
// // Guardar los datos binarios como un archivo JPG
// file_put_contents('myImagetest.jpg', $data);


?>

<?php
$img = $_POST['base64'];
$img2 = str_replace('data:image/png;base64,', '', $img);
$fileData = base64_decode($img2);
$fileName = uniqid().'.png';
file_put_contents($fileName, $fileData);
header("Location: test.php")
?>  