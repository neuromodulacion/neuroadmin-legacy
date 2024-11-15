<?php

include('../functions/funciones_mysql.php');
include('../functions/email.php');
include('../api/funciones_api.php');

$paciente_id =213;

$paciente_cons_id =514;


// 514

// echo agrega_cliente_bind($paciente_id);
// 
// echo "<hr>";

echo agrega_cliente_bind_consulta($paciente_cons_id);

echo "<hr>".$paciente_cons_id;

// function validarSinEspacios($cadena) {
	// $cadena = trim($cadena);
	// $cadena = str_replace(' ', '', $cadena);
    // return $cadena;
// }
// 
// $email = validarSinEspacios($email);
// $celular = validarSinEspacios($celular);
// 
// 
// 
// $email = " ejemplo@correo.com ";
// $celular = " 123 456 7890 ";
// 
// // Eliminar espacios al principio y al final
// // $email = trim($email);
// // $celular = trim($celular);
// // 
// // // Eliminar espacios en blanco en toda la cadena
// // $email_sin_espacios = str_replace(' ', '', $email);
// // $celular_sin_espacios = str_replace(' ', '', $celular);
// 
// 
// 
// echo "<hr>Email sin espacios: ".$email;
// echo "<hr>Celular sin espacios: ".$celular;


// $email = " ejemplo@correo.co m";
// $celular = " 1234 567 890 ";
// 
// // Eliminar espacios al principio y al final
// $email = trim($email);
// $celular = trim($celular);
// 
// // Validar que no tengan espacios intermedios
// function validarSinEspaciosIntermedios($cadena) {
    // return !preg_match('/\s/', $cadena);
// }
// 
// if (validarSinEspaciosIntermedios($email) && validarSinEspaciosIntermedios($celular)) {
    // echo "El email y el celular son válidos.".$email." ".$celular;
// } else {
    // echo "El email o el celular contienen espacios intermedios.".$email." ".$celular;
// }
?>
