<?php

$ruta = "../";

// Incluir el archivo de funciones MySQL para interactuar con la base de datos
include($ruta.'functions/funciones_mysql.php');

// Obtener los datos codificados de la URL
$datos_codificados = $_GET['datos'];

// Decodificar los datos
$datos_decodificados = base64_decode($datos_codificados);

// Separar los valores en un arreglo asociativo
$datos_array = [];
parse_str($datos_decodificados, $datos_array);

// Extraer los valores del arreglo
$uso = $datos_array['uso'];
$timex = $datos_array['time'];
$generador = $datos_array['generador'];
$vigencia = $datos_array['vigencia'];
$usuario_id = $datos_array['usuario_id'];
$empresa_id = $datos_array['empresa_id'];
$funcion = $datos_array['funcion'];

// Verificar si la invitación ha caducado comparando la fecha de hoy con la vigencia
$hoy = date('Y-m-d');     

// Consultar el estado de la invitación en la base de datos
$sql = "
SELECT
	invitaciones.time,
	invitaciones.estatus AS estatus_liga, 
	invitaciones.uso, 
	invitaciones.funcion, 
	invitaciones.vigencia
FROM
	invitaciones
WHERE
	time = $timex"; 

// Ejecutar la consulta SQL
$result_insert = ejecutar($sql);

// Obtener los resultados de la consulta
$row = mysqli_fetch_array($result_insert);
extract($row);

// Consultar información adicional de la empresa y administrador
$sql_protocolo = "
	SELECT
		admin.nombre
	FROM
		admin
	WHERE
		admin.usuario_id = $usuario_id";

// Ejecutar la consulta SQL
$result_protocolo = ejecutar($sql_protocolo);

// Obtener los resultados de la consulta
$row_protocolo = mysqli_fetch_array($result_protocolo);
extract($row_protocolo);




?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formato para carta de perro apoyo emocional</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

 <body style="background: #ffffff;" >    <!--class="theme-teal" -->
    
	<nav style="background: #0096AA" class="navbar navbar-default">
	  <div class="container-fluid">
	    <!-- Brand and toggle get grouped for better mobile display -->
	    <div class="navbar-header">
	      <!-- <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button> -->
	      <a href="../index.html" style=" color: white" class="navbar-brand">Neuromodulaci&oacute;n Gdl</a>
	      <!-- <a style=" color: white" class="navbar-brand" href="#">Neuromodulacion Gdl</a> -->
	    </div>
	
	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	     
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>
	
	<?php
	// Verificar si la invitación ha caducado o si ya ha sido usada en caso de ser de uso único
	if ($vigencia < $hoy || ($estatus_liga == 'usado')) { ?>
		<div align="center" class="container">
			<br>
	    	<h1>La invitación ha caducado o ya se uso.</h1>
	    	<br>
	    	<h3>Solicita una nueva invitación</h3>
    	</div>
	<?php } else {
	    echo "<h4>Invitación válida generada por: $nombre </h4>";
	    // Si la invitación es válida, mostrar el formulario de alta de usuario
	?>	
    <div class="container">
        <h2>Formulario de Captura</h2>
        <form action="procesar_formulario.php" method="post">
        	<input type="hidden" id="time" name="time" value="<?php echo $time; ?>"/>
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="nombre">Correo electronico</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>            
            <div class="form-group">
                <label for="sexo">Sexo</label>
                <select class="form-control" id="sexo" name="sexo" required>
                    <option value="">--Selecciona--</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                </select>
            </div>
            <div class="form-group">
                <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
            </div>
            <div class="form-group">
                <label for="padecimiento">Padecimiento</label>
                <input type="text" class="form-control" id="padecimiento" name="padecimiento" required>
            </div>
            <div class="form-group">
                <label for="raza">Raza del Perro</label>
                <input type="text" class="form-control" id="raza" name="raza" required>
            </div>
            <div class="form-group">
                <label for="sexo_perro">Sexo del Perro</label>
                <select class="form-control" id="sexo_perro" name="sexo_perro" required>
                    <option value="">--Selecciona--</option>
                    <option value="Hembra">Hembra</option>
                    <option value="Macho">Macho</option>
                </select>
            </div>
            <div class="form-group">
                <label for="esterilizado">Esterilizado</label>
                <select class="form-control" id="esterilizado" name="esterilizado" required>
                    <option value="">--Selecciona--</option>
                    <option value="Si">Sí</option>
                    <option value="No">No</option>
                </select>
            </div>
            <div class="form-group">
                <label for="nombre_mascota">Nombre de la Mascota</label>
                <input type="text" class="form-control" id="nombre_mascota" name="nombre_mascota" required>
            </div>
            <div class="form-group">
                <label for="edad_perro">Edad del Perro en años</label>
                <input type="number" class="form-control" id="edad_perro" name="edad_perro" required>
            </div>
            <button type="submit" style="background: #0096AA" class="btn btn-primary">Enviar</button>
            <hr>
        </form>
    </div>
    <?php
    	}
    ?>
</body>
</html>
