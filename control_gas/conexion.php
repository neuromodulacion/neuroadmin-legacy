<?php

// $servername = "174.136.25.64";
// $usuario = "lamanad1_conexion";
// $password = "7)8S!K{%NBoL";
// $dbname = "lamanad1_medico";
// 
// $mysqli = new mysqli("174.136.25.64","lamanad1_conexion","7)8S!K{%NBoL", "lamanad1_medico");

$conn = new mysqli("174.136.25.64","lamanad1_conexion","7)8S!K{%NBoL", "lamanad1_medico");

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

?>
