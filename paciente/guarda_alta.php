<?php
// Inclusión de archivos necesarios para las funciones del sistema
include('../functions/funciones_mysql.php');  // Funciones para trabajar con MySQL
include('../functions/email.php');  // Funciones para el envío de correos electrónicos
include('../api/funciones_api.php');  // Funciones adicionales de la API

// Inicia la sesión y configura la codificación y zona horaria
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

// Define la ruta base y extrae los datos de la sesión y el formulario POST
$ruta = "../";
extract($_SESSION);
extract($_POST);

// Establece las variables de fecha y hora actuales
$f_captura = date("Y-m-d");
$h_captura = date("H:i:s"); 
$mes =  substr($mes_ano, 5, 2);  // Extrae el mes de la variable mes_ano
$ano = substr($mes_ano, 0, 4);  // Extrae el año de la variable mes_ano

// Consulta para verificar si ya existe un paciente con el email proporcionado
$sql = "SELECT * FROM pacientes WHERE email ='$email' 
			and celular = '$celular' and paciente = '$paciente' 
			and apaterno ='$apaterno' and amaterno = '$amaterno'"; 
$result_insert = ejecutar($sql);
$cnt = mysqli_num_rows($result_insert);  // Cuenta cuántos registros coinciden
//$cnt =0;

if ($valmail == 'No') {
	$email = "remisiones_bind@neuromodulaciongdl.com";
}


// Si ya existe un paciente con ese email
if ($cnt !== 0) {
    $row = mysqli_fetch_array($result_insert);  // Obtiene los datos del paciente
    extract($row);  // Extrae los datos del paciente a variables individuales
    
    // Muestra un mensaje de que el paciente ya está registrado
    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <title>Ya Capturado Anteriormente</title>
        <link rel="icon" href="<?php echo $ruta; ?>images/favicon.png" type="image/x-icon">
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
        <link href="<?php echo $ruta; ?>plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="<?php echo $ruta; ?>plugins/node-waves/waves.css" rel="stylesheet" />
        <link href="<?php echo $ruta; ?>css/style.css" rel="stylesheet">
    </head>

    <body class="theme-<?php echo $body; ?>">    
        <div class="container" style="padding-top: 50px">
            <div style="background: #FFFFFF" class="jumbotron" style="margin-top: 50px;">
                <h1 class="display-4">Ya Capturado Anteriormente</h1>
                <p class="lead">Paciente registrado</p>
                <hr class="my-4">
                <p>El paciente con los siguientes datos ya se encuentra registrado:</p>
                <ul>
                    <li><strong>Correo:</strong> <?php echo $email; ?></li>
                    <li><strong>Celular:</strong> <?php echo $celular; ?></li>
                    <li><strong>Nombre:</strong> <?php echo $paciente." ".$apaterno." ".$amaterno; ?></li>
                </ul>
                <a href="<?php echo $ruta; ?>menu.php" class="btn btn-primary btn-lg">Continuar</a>
            </div>
        </div>
                    
        <!-- Inclusión de scripts necesarios -->
        <script src="<?php echo $ruta; ?>plugins/jquery/jquery.min.js"></script>
        <script src="<?php echo $ruta; ?>plugins/bootstrap/js/bootstrap.js"></script>
        <script src="<?php echo $ruta; ?>plugins/node-waves/waves.js"></script>
    </body>

    </html>     
    <?php    
} else { 
    // Si no existe un paciente con ese email, proceder con el registro

    // Validación y limpieza de campos de email y celular
    if (empty($email)) {
        $email = "remisiones_bind@neuromodulaciongdl.com";
    } else {
        $email = validarSinEspacios($email);  // Elimina espacios del email
    }

    if (empty($celular)) {
        $celular = "";
    } else {
        $celular = validarSinEspacios($celular);  // Elimina espacios del celular
    }

    // Inserta los datos del nuevo paciente en la base de datos
    $insert1 = "
    INSERT IGNORE INTO pacientes 
        (
            usuario_id,
            paciente,
            apaterno,
            amaterno,
            email,
            celular,
            f_nacimiento,
            sexo,
            contacto,
            parentesco,
            tel1,
            tel2,
            resumen_caso,
            diagnostico,
            diagnostico2,
            diagnostico3,
            medicamentos,
            terapias,
            f_captura,
            h_captura,
            estatus,
            notificaciones,
            tratamiento,
            observaciones,
            empresa_id 
        ) 
    VALUE
        (
            $usuario_idm,
            '$paciente',
            '$apaterno',
            '$amaterno',
            '$email',
            '$celular',
            '$f_nacimiento',
            '$sexo',
            '$contacto',
            '$parentesco',
            '$tel1',
            '$tel2',
            '$resumen_caso',
            '$diagnostico',
            '$diagnostico2',
            '$diagnostico3',
            '$medicamentos',
            '$terapias',
            '$f_captura',
            '$h_captura',
            'Pendiente',
            '$notificaciones',
            '$tratamiento',
            '$observaciones',
            '$empresa_id' 
        ) ";
    // Ejecuta la inserción
    $result_insert = ejecutar($insert1);            

    // Obtiene el ID del nuevo paciente registrado
    $sql = "SELECT max(paciente_id) as paciente_id FROM pacientes"; 
    $result_insert = ejecutar($sql);
    $row1 = mysqli_fetch_array($result_insert);
    extract($row1);  // Extrae el ID del paciente

    // Verifica y extrae los datos del paciente recién insertado
    $sql = "SELECT * FROM pacientes WHERE paciente_id = $paciente_id"; 
    $result = ejecutar($sql);
    $row = mysqli_fetch_array($result);
    extract($row);

    // Si la empresa es la ID 1, agrega el paciente en bind
    if ($empresa_id == 1) {
        echo agrega_cliente_bind($paciente_id);     
    } 

    // Inserta la información de terapias para el nuevo paciente
    $insert_terapias = "
    INSERT IGNORE INTO terapias 
        (
            paciente_id,
            usuario_id,
            f_alta,
            h_alta,
            observaciones,
            estatus
        ) 
    VALUE
        (
            $paciente_id,
            $usuario_id,
            '$f_captura',
            '$h_captura',
            '$observaciones',
            'Pendiente' 
        ) 
    "; 
    //$result_insert = ejecutar($insert_terapias); 
    $terapia_id= ejecutar_id($insert_terapias);

    // Inserta las sesiones de terapia según el protocolo seleccionado
    $sql_protocolo = "
    SELECT
        protocolo_terapia.protocolo_ter_id, 
        protocolo_terapia.prot_terapia
    FROM
        protocolo_terapia
    ";
    $result_protocolo = ejecutar($sql_protocolo);  
    $cnt = 1;
    $total = 0;
    $ter = "";
    while ($row_protocolo = mysqli_fetch_array($result_protocolo)) {
        extract($row_protocolo);
        
        $protocolo_var = "protocolo".$protocolo_ter_id;
        $valor = $_POST[$protocolo_var];
        $total += $valor;
        if ($valor >= 1) {
            $ter .= $prot_terapia." <b>".$valor." Sesiones </b><br>"; 

            // Inserta las sesiones de la terapia en la base de datos
            $insert1 = "
            INSERT IGNORE INTO sesiones 
                (
                    terapia_id,
                    protocolo_ter_id,
                    paciente_id,
                    sesiones,
                    f_alta,
                    h_alta
                ) 
            VALUE
                (
                    $terapia_id,
                    $protocolo_ter_id,
                    $paciente_id,
                    $valor,
                    '$f_captura',
                    '$h_captura'
                ) ";
            $result_insert = ejecutar($insert1);
        }
        $cnt++;
    } 

    // Obtiene el nombre y usuario del médico tratante
    $sql = "
    SELECT 
        admin.nombre as nombre_m, 
        admin.usuario as usuario_m
    FROM
        admin
    WHERE
        admin.usuario_id = $usuario_idm"; 
    $result = ejecutar($sql);
    $row = mysqli_fetch_array($result);
    extract($row);

    // Prepara y envía un correo de confirmación al médico tratante
    $asunto = "Alta de Paciente No. $paciente_id $paciente $apaterno $amaterno" ; 
    $cuerpo_correo = ' 
    <h3>Buen día Dr/a. '.$nombre_m.':<br>
    Se notifica que se guardó correctamente la información de su paciente</h3>
    <div align="center"> 
        <div style="width: 90% ;!important;" align="left" >
            <b>Registro:</b> '.$paciente_id.'<br>
            <b>Nombre:</b> '.$paciente.' '.$apaterno.' '.$amaterno.'<br>
            <b>Correo Electrónico:</b> '.$email.'<br>
            <b>Celular:</b> '.$celular.'<br>
            <b>Fecha de cumpleaños:</b> '.$f_nacimiento.'<br>
            <b>Sexo:</b> '.$sexo.'<br>
            <b>Contacto:</b> '.$contacto.'<br>
            <b>Parentesco:</b> '.$parentesco.'<br>
            <b>Teléfono 1:</b> '.$tel1.'<br>
            <b>Teléfono 2:</b> '.$tel2.'<br>
            <b>Resumen Caso:</b> '.$resumen_caso.'<br>
            <b>Diagnóstico 1:</b> '.$diagnostico.'<br>
            <b>Diagnóstico 2:</b> '.$diagnostico2.'<br>
            <b>Diagnóstico 3:</b> '.$diagnostico3.'<br>
            <b>Tratamiento farmacológico actual:</b> '.$medicamentos.'<br>
            <b>Tratamiento no farmacológico actual:</b> '.$terapias.'<br>
            <b>Fecha de registro:</b> '.$f_captura.'<br>
            <b>Hora de registro:</b> '.$h_captura.'<br>
            <b>Estatus:</b> Pendiente<br>
            <b>Observaciones:</b> '.$observaciones.'<br>
            <b>Protocolo:</b> <h4>'.$tratamiento.'</h4><br> 
            Atte. '.$emp_nombre.'          
        </div> 
    </div> 
    '; 
    $accion =  "General";
    $mail = correo_electronico($usuario, $asunto, $cuerpo_correo, $nombre_m, $empresa_id, $accion);
    //echo $mail."<hr>";
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Éxito</title>
    <link rel="icon" href="<?php echo $ruta; ?>images/favicon.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <link href="<?php echo $ruta; ?>plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo $ruta; ?>plugins/node-waves/waves.css" rel="stylesheet" />
    <link href="<?php echo $ruta; ?>css/style.css" rel="stylesheet">
</head>

<body class="theme-<?php echo $body; ?>">    
    <div class="container" style="padding-top: 50px">
        <div style="background: #FFFFFF" class="jumbotron" style="margin-top: 50px;">
            <h1 class="display-4">Éxito</h1>
            <p class="lead">Se guardó correctamente la información</p>
            <hr class="my-4">
            <p>Los datos del paciente han sido registrados exitosamente.</p>
            <button id="botonCopiar" class="btn btn-info btn-lg">Copiar Informe</button>
            <div id="codigo">
				<h2><?php echo $mensaje; ?></h2>
			    	<b>*Registro:*</b> _<?php echo $paciente_id; ?>_<br>
			    	<b>*Nombre:*</b> _<?php echo $paciente." ".$apaterno." ".$amaterno; ?>_<br>
			    	<b>*Correo Electronico:*</b> _<?php echo $email; ?>_<br>
			    	<b>*Celular:*</b> _<?php echo $celular; ?>_<br>
			    	<b>*Fecha de cumpleaños:*</b> _<?php echo $f_nacimiento; ?>_<br>
			    	<b>*Sexo:*</b> _<?php echo $sexo; ?>_<br>
					<b>*Contacto:*</b> _<?php echo $contacto; ?>_<br>
					<b>*Parentesco:*</b> _<?php echo $parentesco; ?>_<br>
					<b>*Telefono 1:*</b> _<?php echo $tel1; ?>_<br>
					<b>*Telefono 2:*</b> _<?php echo $tel2; ?>_<br>
					<b>*Resumen Caso:*</b> _<?php echo $resumen_caso; ?>_<br>
					<b>*Diagnostico 1:*</b> _<?php echo $diagnostico; ?>_<br>
					<b>*Diagnostico 2:*</b> _<?php echo $diagnostico2; ?>_<br>
					<b>*Diagnostico 3:*</b> _<?php echo $diagnostico3; ?>_<br>
					<b>*Tratamiento farmacologico actual:*</b> _<?php echo $medicamentos; ?>_<br>
					<b>*Tratamiento no farmacologico actual:*</b> _<?php echo $terapias; ?>_<br>
					<b>*Fecha de registro:*</b> _<?php echo date("d/m/Y", strtotime($f_captura)); ?>_<br>
					<b>*Hora de registro:*</b> _<?php echo $h_captura; ?>_<br>
					<b>*Estatus:*</b> _Pendiente_<br>
					<b>*Observaciones:*</b> _<?php echo $observaciones ; ?>_<br><br>
			    	<b>*Protocolo que está Indicando:*</b> <h2>*_<?php echo $tratamiento; ?>_*<h2><br> 				    				
				</div>
            <br>
            <a href="<?php echo $ruta; ?>menu.php" class="btn btn-primary btn-lg">Continuar</a>
        </div>
    </div>
                
    <!-- Inclusión de scripts necesarios -->
    <script src="<?php echo $ruta; ?>plugins/jquery/jquery.min.js"></script>
    <script src="<?php echo $ruta; ?>plugins/bootstrap/js/bootstrap.js"></script>
    <script src="<?php echo $ruta; ?>plugins/node-waves/waves.js"></script>
    <script>
        // Función para copiar el informe al portapapeles
        document.getElementById('botonCopiar').addEventListener('click', function() {
            var codigo = document.getElementById('codigo');
            var selection = window.getSelection();
            var range = document.createRange();
            range.selectNodeContents(codigo);
            selection.removeAllRanges();
            selection.addRange(range);
            document.execCommand('copy');
            selection.removeAllRanges();
            alert('Información copiada al portapapeles');
        });
    </script>
</body>

</html>  
<?php } ?>
