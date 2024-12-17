<?php
// Inclusión de archivos necesarios
include('../functions/funciones_mysql.php');
include('../functions/email.php');
include('../api/funciones_api.php');

session_start();

// Mostrar todos los errores
error_reporting(E_ALL);

// Ajustar charset y zona horaria
ini_set('default_charset', 'UTF-8');
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');

// Establecer tiempo en sesión
$_SESSION['time'] = time();

// Ruta base
$ruta = "../";

extract($_SESSION);
extract($_POST);

// ===================
// Variables desde $_SESSION (si las necesitas) 
// Ajusta estos nombres según las variables que realmente existan en tu sesión

$usuario_id = isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : 0;
$usuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : '';
$body = isset($_SESSION['body']) ? $_SESSION['body'] : '';
$emp_nombre = isset($_SESSION['emp_nombre']) ? $_SESSION['emp_nombre'] : '';

// ===================
// Variables desde $_POST
// Asignar valores por defecto si no existen
$usuario_idm = isset($_POST['usuario_idm']) ? $_POST['usuario_idm'] : 0;
$paciente = isset($_POST['paciente']) ? $_POST['paciente'] : '';
$apaterno = isset($_POST['apaterno']) ? $_POST['apaterno'] : '';
$amaterno = isset($_POST['amaterno']) ? $_POST['amaterno'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$celular = isset($_POST['celular']) ? $_POST['celular'] : '';
$valmail = isset($_POST['valmail']) ? $_POST['valmail'] : '';
$f_nacimiento = isset($_POST['f_nacimiento']) ? $_POST['f_nacimiento'] : '';
$sexo = isset($_POST['sexo']) ? $_POST['sexo'] : '';
$contacto = isset($_POST['contacto']) ? $_POST['contacto'] : '';
$parentesco = isset($_POST['parentesco']) ? $_POST['parentesco'] : '';
$tel1 = isset($_POST['tel1']) ? $_POST['tel1'] : '';
$tel2 = isset($_POST['tel2']) ? $_POST['tel2'] : '';
$resumen_caso = isset($_POST['resumen_caso']) ? $_POST['resumen_caso'] : '';
$diagnostico = isset($_POST['diagnostico']) ? $_POST['diagnostico'] : '';
$diagnostico2 = isset($_POST['diagnostico2']) ? $_POST['diagnostico2'] : '';
$diagnostico3 = isset($_POST['diagnostico3']) ? $_POST['diagnostico3'] : '';
$medicamentos = isset($_POST['medicamentos']) ? $_POST['medicamentos'] : '';
$terapias = isset($_POST['terapias']) ? $_POST['terapias'] : '';
$notificaciones = isset($_POST['notificaciones']) ? $_POST['notificaciones'] : '';
$tratamiento = isset($_POST['tratamiento']) ? $_POST['tratamiento'] : '';
$observaciones = isset($_POST['observaciones']) ? $_POST['observaciones'] : '';
//$empresa_id = isset($_POST['empresa_id']) ? $_POST['empresa_id'] : '';
$bind = isset($_POST['bind']) ? $_POST['bind'] : 'no';
$mensaje = isset($_POST['mensaje']) ? $_POST['mensaje'] : '';

// Variables adicionales usadas por funciones_api.php (si las necesitas):
$Phone = isset($_POST['Phone']) ? $_POST['Phone'] : '';
$NextContactDate = isset($_POST['NextContactDate']) ? $_POST['NextContactDate'] : '';
$LocationID = isset($_POST['LocationID']) ? $_POST['LocationID'] : '';

// Variables de fecha y hora actuales
$f_captura = date("Y-m-d");
$h_captura = date("H:i:s");

// Si valmail es No, forzar email
if ($valmail == 'No') {
    $email = "remisiones_bind@neuromodulaciongdl.com";
}

// Verifica si el paciente ya existe
$sql = "SELECT * FROM pacientes WHERE email ='$email' 
            AND celular = '$celular' 
            AND paciente = '$paciente' 
            AND apaterno ='$apaterno' 
            AND amaterno = '$amaterno'"; 
$result_insert = ejecutar($sql);
$cnt = mysqli_num_rows($result_insert);

if ($cnt !== 0) {
    // Paciente ya existe
    $row = mysqli_fetch_array($result_insert);
    // extraer datos del paciente si fuera necesario
    // Mostrar HTML de paciente ya registrado
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Ya Capturado Anteriormente</title>
        <link rel="icon" href="<?php echo $ruta; ?>images/favicon.png" type="image/x-icon">
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
        <link href="<?php echo $ruta; ?>plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="<?php echo $ruta; ?>plugins/node-waves/waves.css" rel="stylesheet" />
        <link href="<?php echo $ruta; ?>css/style.css" rel="stylesheet">
    </head>
    <body class="theme-<?php echo $body; ?>">    
        <div class="container" style="padding-top: 10px">
            <div style="background: #FFFFFF" class="jumbotron">
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
        <script src="<?php echo $ruta; ?>plugins/jquery/jquery.min.js"></script>
        <script src="<?php echo $ruta; ?>plugins/bootstrap/js/bootstrap.js"></script>
        <script src="<?php echo $ruta; ?>plugins/node-waves/waves.js"></script>
    </body>
    </html>     
    <?php    
} else { 
    // Paciente no existe, registrar

    // Validación y limpieza de email y celular
    if (empty($email)) {
        $email = "remisiones_bind@neuromodulaciongdl.com";
    } else {
        $email = validarSinEspacios($email);
    }

    if (empty($celular)) {
        $celular = "";
    } else {
        $celular = validarSinEspacios($celular);
    }

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
    VALUES
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
    $result_insert = ejecutar($insert1);

    // Obtener ID del nuevo paciente
    $sql = "SELECT max(paciente_id) as paciente_id FROM pacientes"; 
    $result_insert = ejecutar($sql);
    $row1 = mysqli_fetch_array($result_insert);
    $paciente_id = isset($row1['paciente_id']) ? $row1['paciente_id'] : 0;

    // Obtener datos del paciente
    $sql = "SELECT * FROM pacientes WHERE paciente_id = $paciente_id"; 
    $result = ejecutar($sql);
    $row = mysqli_fetch_array($result);
    // Extrae datos del paciente
    $paciente     = $row['paciente'];
    $apaterno     = $row['apaterno'];
    $amaterno     = $row['amaterno'];
    $email        = $row['email'];
    $celular      = $row['celular'];
    $f_nacimiento = $row['f_nacimiento'];
    $sexo         = $row['sexo'];
    $contacto     = $row['contacto'];
    $parentesco   = $row['parentesco'];
    $tel1         = $row['tel1'];
    $tel2         = $row['tel2'];
    $resumen_caso = $row['resumen_caso'];
    $diagnostico  = $row['diagnostico'];
    $diagnostico2 = $row['diagnostico2'];
    $diagnostico3 = $row['diagnostico3'];
    $medicamentos = $row['medicamentos'];
    $terapias     = $row['terapias'];
    $f_captura    = $row['f_captura'];
    $h_captura    = $row['h_captura'];
    $estatus      = $row['estatus'];
    $notificaciones = $row['notificaciones'];
    $tratamiento  = $row['tratamiento'];
    $observaciones= $row['observaciones'];
    $empresa_id   = $row['empresa_id'];

    // Si bind es si, agrega cliente a bind
    if($bind == 'si'){
        echo agrega_cliente_bind($paciente_id);     
    } 

    // Insertar terapias
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
    VALUES
        (
            $paciente_id,
            $usuario_id,
            '$f_captura',
            '$h_captura',
            '$observaciones',
            'Pendiente' 
        ) 
    "; 
    $terapia_id = ejecutar_id($insert_terapias);

    // Procesar protocolos
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
        $protocolo_ter_id = $row_protocolo['protocolo_ter_id'];
        $prot_terapia = $row_protocolo['prot_terapia'];

        // Verificar si existe en $_POST protocoloX
        $campo_protocolo = 'protocolo'.$protocolo_ter_id;
        $valor = isset($_POST[$campo_protocolo]) ? intval($_POST[$campo_protocolo]) : 0;

        $total += $valor;
        if ($valor >= 1) {
            $ter .= $prot_terapia." <b>".$valor." Sesiones </b><br>";

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
            VALUES
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

    // Obtener médico tratante
    $sql = "
    SELECT 
        admin.nombre as nombre_m, 
        admin.usuario as usuario_m
    FROM
        admin
    WHERE
        admin.usuario_id = $usuario_idm"; 
     //   echo $sql."<hr>";
    $result = ejecutar($sql);
    $row = mysqli_fetch_array($result);
    $nombre_m = $row['nombre_m'];
    $usuario_m = $row['usuario_m'];

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
    $accion = "General";
    $mail = correo_electronico($usuario_m, $asunto, $cuerpo_correo, $nombre_m, $empresa_id, $accion);

    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Éxito</title>
        <link rel="icon" href="<?php echo $ruta; ?>images/favicon.png" type="image/x-icon">
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
        <link href="<?php echo $ruta; ?>plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="<?php echo $ruta; ?>plugins/node-waves/waves.css" rel="stylesheet" />
        <link href="<?php echo $ruta; ?>css/style.css" rel="stylesheet">
    </head>
    <body class="theme-<?php echo $body; ?>">
        <div class="container" style="padding-top: 10px">
            <div style="background: #FFFFFF" class="jumbotron">
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
                    <b>*Protocolo que está Indicando:*</b> <h2>*_<?php echo $tratamiento; ?>_*</h2><br>  
                </div>
                <br>
                <a href="<?php echo $ruta; ?>menu.php" class="btn btn-primary btn-lg">Continuar</a>
            </div>
        </div>
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
    <?php
} 
