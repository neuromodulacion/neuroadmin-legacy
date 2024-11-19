<?php 
// Incluir archivos necesarios para funciones de base de datos, correo y API
include('../functions/funciones_mysql.php');
include('../functions/email.php');
include('../api/funciones_api.php');
$ruta = "../";
// Iniciar sesión para acceder a variables de sesión
session_start();

// Establecer el nivel de notificación de errores
error_reporting(E_ALL); // Reemplaza `7` por `E_ALL` para usar la constante más clara y recomendada

// Establecer la codificación interna a UTF-8 (ya no se utiliza `iconv_set_encoding`, sino `ini_set`)
ini_set('default_charset', 'UTF-8');

// Configurar la cabecera HTTP con codificación UTF-8
header('Content-Type: text/html; charset=UTF-8');

// Configurar la zona horaria
date_default_timezone_set('America/Monterrey');

// Configurar la localización para manejar fechas y horas en español
setlocale(LC_TIME, 'es_ES.UTF-8');

// Asignar el tiempo actual a la sesión en formato de timestamp
$_SESSION['time'] = time(); // `time()` es el equivalente moderno a `mktime()`


// Extraer variables de sesión y de $_POST para usarlas directamente
extract($_SESSION);
extract($_POST);

// Validar y limpiar los campos de email y celular eliminando espacios en blanco
$email = validarSinEspacio($email);
$celular = validarSinEspacio($celular);

$hoy = date("Y-m-d");
$ahora = date("H:i:00"); 
$anio = date("Y");
$mes_ahora = date("m");

// Establecer la fecha y hora de captura
$f_captura = date("Y-m-d");
$h_captura = date("H:i:s"); 


// Consulta de actualización para modificar la información del paciente en la base de datos
$update = "
UPDATE pacientes
SET
    pacientes.usuario_id = '$usuario_idm',
    pacientes.paciente = '$paciente',
    pacientes.apaterno = '$apaterno',
    pacientes.amaterno = '$amaterno',
    pacientes.email = '$email',
    pacientes.celular = '$celular',
    pacientes.f_nacimiento = '$f_nacimiento',
    pacientes.sexo = '$sexo',
    pacientes.contacto = '$contacto',
    pacientes.parentesco = '$parentesco',
    pacientes.tel1 = '$tel1',
    pacientes.tel2 = '$tel2',
    pacientes.resumen_caso = '$resumen_caso',
    pacientes.diagnostico = '$diagnostico',
    pacientes.diagnostico2 = '$diagnostico2',
    pacientes.diagnostico3 = '$diagnostico3',
    pacientes.medicamentos = '$medicamentos',
    pacientes.terapias = '$terapias',
    pacientes.f_captura = '$f_captura',
    pacientes.h_captura = '$h_captura',
    pacientes.estatus = '$estatus',
    pacientes.notificaciones = '$notificaciones',
    pacientes.tratamiento = '$tratamiento',
    pacientes.observaciones = '$observaciones'
WHERE
    pacientes.paciente_id = $paciente_id";
   
// Ejecutar la consulta de actualización
$result_insert = ejecutar($update);

// Llamar a una función externa para modificar el cliente en otro sistema (función en la API)
modifica_cliente_bind($paciente_id);

?>            

<!-- HTML para mostrar el mensaje de éxito de actualización -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Guardado</title>
    <!-- Favicon-->
    <link rel="icon" href="../../favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="../plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="../plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="../css/style.css" rel="stylesheet">
</head>

<body class="theme-<?php echo $body; ?>">    
    <div style="padding-top: 30px" class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div align="center" style="padding: 20px;" class="five-zero-zero-container card">
                <div><h1>Éxito</h1></div>
                <div><h2>Se actualizó correctamente la información</h2></div>
                <div align="center"> 
                    <div style="width: 90% !important;" align="left">
                        <!-- Botón para copiar la información al portapapeles -->
                        <button id="botonCopiar" class="btn bg-teal btn-lg waves-effect">Copiar Informe</button>
                        <div id="codigo">
                            <h2><?php echo $mensaje; ?></h2>
                            <!-- Información del paciente formateada para copiar al portapapeles -->
                            <b>*Registro:*</b> _<?php echo $paciente_id; ?>_<br>
                            <b>*Nombre:*</b> _<?php echo $paciente." ".$apaterno." ".$amaterno; ?>_<br>
                            <b>*Correo Electrónico:*</b> _<?php echo $email; ?>_<br>
                            <b>*Celular:*</b> _<?php echo $celular; ?>_<br>
                            <b>*Fecha de cumpleaños:*</b> _<?php echo $f_nacimiento; ?>_<br>
                            <b>*Sexo:*</b> _<?php echo $sexo; ?>_<br>
                            <b>*Contacto:*</b> _<?php echo $contacto; ?>_<br>
                            <b>*Parentesco:*</b> _<?php echo $parentesco; ?>_<br>
                            <b>*Teléfono 1:*</b> _<?php echo $tel1; ?>_<br>
                            <b>*Teléfono 2:*</b> _<?php echo $tel2; ?>_<br>
                            <b>*Resumen Caso:*</b> _<?php echo $resumen_caso; ?>_<br>
                            <b>*Diagnóstico 1:*</b> _<?php echo $diagnostico; ?>_<br>
                            <b>*Diagnóstico 2:*</b> _<?php echo $diagnostico2; ?>_<br>
                            <b>*Diagnóstico 3:*</b> _<?php echo $diagnostico3; ?>_<br>
                            <b>*Tratamiento farmacológico actual:*</b> _<?php echo $medicamentos; ?>_<br>
                            <b>*Tratamiento no farmacológico actual:*</b> _<?php echo $terapias; ?>_<br>
                            <b>*Fecha de registro:*</b> _<?php echo date("d/m/Y", strtotime($f_captura)); ?>_<br>
                            <b>*Hora de registro:*</b> _<?php echo $h_captura; ?>_<br>
                            <b>*Estatus:*</b> _<?php echo $estatus; ?>_<br>
                            <b>*Observaciones:*</b> _<?php echo $observaciones ; ?>_<br><br>
                            <b>*Protocolo que está Indicando:*</b> <h2>*_<?php echo $tratamiento; ?>_*<h2><br>    
                        </div>
                        <!-- Script para copiar el informe al portapapeles -->
                        <script>
                            document.getElementById('botonCopiar').addEventListener('click', function() {
                                var codigo = document.getElementById('codigo');
                                var rango = document.createRange();
                                rango.selectNode(codigo);
                                window.getSelection().removeAllRanges(); // Elimina rangos existentes
                                window.getSelection().addRange(rango); // Selecciona el texto del código
                                document.execCommand('copy'); // Ejecuta el comando de copia
                                window.getSelection().removeAllRanges(); // Elimina el rango seleccionado
                                alert('Información copiada al portapapeles'); // Alerta para indicar que se copió
                            });         
                        </script>                     
                        <!-- Botón para continuar al menú principal -->
                        <a href="<?php echo $ruta; ?>menu.php" class="btn bg-green btn-lg waves-effect">CONTINUAR</a>                
                    </div>                
                </div>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>            

    <!-- Jquery Core Js -->
    <script src="../../plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="../../plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="../../plugins/node-waves/waves.js"></script>
</body>

</html>
