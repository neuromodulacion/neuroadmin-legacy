<!-- HTML para mostrar el mensaje de éxito de registro -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Guardado</title>
    <!-- Favicon de la página -->
    <link rel="icon" href="<?php echo $ruta; ?>images/logo_aldana_tc.png" type="image/png">

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
                <!-- Mensaje de confirmación de éxito -->
                <div><h1><?php echo $accion; ?></h1></div>
                <div><h3><?php echo $mensaje; ?></h3></div>
                <div align="center"> 
                    <div style="width: 90% !important;" align="left">
                        <!-- Mostrar información del usuario registrado -->
                        Nombre: <?php echo $nombre; ?><br>
                        Correo Electrónico: <?php echo $usuario; ?><br>
                        Teléfono: <?php echo $celular; ?><br><br>               
                        <!-- Botón para continuar al menú principal -->
                        <a href="guarda_medico.php" class="btn bg-green btn-lg waves-effect"><i class="material-icons">add_box</i> DAR DE ALTA UNO NUEVO </a>
                        <a href="posible_referenciador.php" class="btn bg-blue btn-lg waves-effect"><i class="material-icons">assignment</i> VER LISTADO</a>                
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