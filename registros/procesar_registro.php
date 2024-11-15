<?php
// Definimos la ruta base
$ruta = '../';

// Incluimos el archivo que contiene las funciones MySQL
include '../functions/funciones_mysql.php';

// Verificamos si la solicitud fue enviada por método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Obtenemos los datos enviados por el formulario y los asignamos a variables
    $nombre_completo = $_POST['nombre_completo'];
    $profesion = $_POST['profesion'];
    $celular = $_POST['celular'];
    $correo = $_POST['correo'];
    // Convertimos la fecha del seminario a un formato adecuado para la base de datos
    $seminario = date('Y-m-d', strtotime($_POST['seminario']));

    // Construimos la consulta SQL para verificar si ya existe un participante con el mismo correo
    $sql = "SELECT * FROM participantes WHERE correo = '$correo'";
    // Ejecutamos la consulta y obtenemos el resultado
    $result_protocolo = ejecutar($sql);
    // Contamos el número de filas en el resultado, lo que indica si el correo ya está registrado
    $cnt = mysqli_num_rows($result_protocolo);

    // Si el participante ya está registrado (el correo ya existe en la base de datos)
    if ($cnt >= 1) {
        // Asignamos un mensaje indicando que ya estaba registrado anteriormente
        $titulo = "Ya estaba registrado anteriormente";
    } else {
        // Si no está registrado, construimos la consulta SQL para insertar el nuevo participante
        $sql = "
        INSERT INTO participantes 
            (nombre_completo, profesion, celular, correo, estatus, seminario) 
        VALUES 
            ('$nombre_completo', '$profesion', '$celular', '$correo', 'Registrado', '$seminario')";
        
        // Ejecutamos la consulta SQL de inserción
        if (ejecutar($sql)) {
            // Si la inserción es exitosa, mostramos un mensaje de éxito
            $titulo = "Registro exitoso.";
        } else {
            // Si ocurre un error al registrar, mostramos un mensaje de error
            $titulo = "Error al registrar el participante.";
        }       
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Guardado</title>
    <!-- Favicon-->
    <link rel="icon" href="<?php echo $ruta; ?>images/favicon.png" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="<?php echo $ruta; ?>plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="<?php echo $ruta; ?>css/style.css" rel="stylesheet">
</head>

<body class="theme-teal">
    <div style="padding: 30px" class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div align="center" class="card">
                <div style="padding: 15px" align="center" class="five-zero-zero-container">
                    <!-- Mostramos el título con el resultado de la operación -->
                    <div> <h1><?php echo $titulo; ?></h1></div>
                    <div align="center"> 
                        <div style="width: 90% ;!important;" align="left">
                            <!-- Mostramos la información del participante registrado -->
                            <h2><?php echo $mensaje; ?></h2>
                            Nombre: <?php echo $nombre_completo; ?><br>
                            Profesión: <?php echo $profesion; ?><br>
                            Correo Electronico: <?php echo $correo; ?><br>
                            Celular: <?php echo $celular; ?><br><br>
                            <!-- Botón para continuar y regresar a la página de inicio -->
                            <a href="../index.html" class="btn bg-green btn-lg waves-effect">CONTINUAR</a> 
                            <hr>                   
                        </div>               
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4"></div>
    </div>
                
    <!-- Jquery Core Js -->
    <script src="<?php echo $ruta; ?>plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="<?php echo $ruta; ?>plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/node-waves/waves.js"></script>
</body>

</html>
