<!-- HTML para mostrar el mensaje de éxito de registro -->
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
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div align="center" style="padding: 20px;" class="five-zero-zero-container card">
                <!-- Mensaje de confirmación de éxito -->
                <div><h1>Exito</h1></div>
                <div><h2>Se guardo correctamente la información</h2></div>
                <div align="center"> 
                    <div style="width: 90% !important;" align="left">
                        <h2><?php echo $mensaje; ?></h2>
                        <!-- Mostrar información del usuario registrado -->
                        Registro: <?php echo $usuario_id; ?><br>
                        Nombre: <?php echo $nombre; ?><br>
                        Correo Electrónico: <?php echo $usuario; ?><br>
                        Teléfono: <?php echo $celular; ?><br><br>               
                        <!-- Botón para continuar al menú principal -->
                        <a href="<?php echo $ruta; ?>menu.php" class="btn bg-green btn-lg waves-effect">CONTINUAR</a>                
                    </div>                
                </div>
            </div>
        </div>
        <div class="col-md-4"></div>
    </div>            

    <!-- Jquery Core Js -->
    <script src="../../plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="../../plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="../../plugins/node-waves/waves.js"></script>
</body>
 
</html>    