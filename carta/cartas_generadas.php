<?php
// Definir la ruta base para incluir archivos
$ruta="../";
$titulo = "Cartas"; 

// Incluir la primera parte del header que contiene configuraciones iniciales
include($ruta.'header1.php');
//include($ruta.'header.php'); // Este es un include comentado que podrías utilizar si decides cambiar el header
?>
    <!-- Inclusión de los estilos para DataTable de JQuery -->
    <link href="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

<?php
// Incluir la segunda parte del header con la barra de navegación y el menú
include($ruta.'header2.php');

?>

<!-- Inicio de la sección de contenido principal -->
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <!-- Título de la página -->
            <h2>PACIENTES</h2>
            <?php echo $ubicacion_url; ?>
            <!-- Depuración opcional para imprimir los datos de la sesión -->
            <?php //print_r($_SESSION); ?>
        </div>

        <!-- Contenedor del contenido principal -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div style="height: 95%" class="header">
                        <!-- Título de la sección -->
                        <h1 align="center">Pacientes</h1>                        
                        <div class="body">
                            <div class="table-responsive">
                                <!-- Tabla de pacientes, con opciones de exportación si están habilitadas -->
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <!-- Columnas de la tabla -->
                                            <th style="max-width: 10px">ID</th>
                                            <th style="min-width: 35px">Fecha</th>
                                            <th style="min-width: 120px">Nombre</th>
                                            <th style="max-width: 15px">Correo</th> 
                                            <th style="max-width: 15px">Carta</th>                                          
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>                                          
                                            <!-- Filtros o pie de tabla -->
                                            <th style="max-width: 10px">ID</th>
                                            <th style="min-width: 35px">Fecha</th>
                                            <th style="min-width: 120px">Nombre</th>
                                            <th style="max-width: 15px">Correo</th> 
                                            <th style="max-width: 15px">Carta</th>   
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php
                                    // Consulta SQL para obtener la información de los pacientes
                                    $sql_protocolo = "
										SELECT
											registros_carta_perro.id,
											registros_carta_perro.nombre,
											registros_carta_perro.fecha_captura,
											registros_carta_perro.email 
										FROM
											registros_carta_perro 
										WHERE
											registros_carta_perro.empresa_id = $empresa_id
                                    ";
                                    // Mostrar la consulta SQL (opcional para depuración)
                                    //echo $sql_protocolo."<br>";                                  

                                    // Ejecutar la consulta y almacenar el resultado
                                    $result_protocolo = ejecutar($sql_protocolo); 
									
                                    // Iterar sobre los resultados de la consulta y construir las filas de la tabla
                                    while ($row_protocolo = mysqli_fetch_array($result_protocolo)) {
                                        extract($row_protocolo);

                                    ?>  
                                        <!-- Renderizar la fila de la tabla con los datos del paciente -->
                                        <tr>
                                            <td><?php echo $id; ?></td>
                                            <td><?php echo $fecha_captura; ?></td>
                                            <td><?php echo $nombre; ?></td>
                                            <td><?php echo $email; ?></td>
                                            <td>
                                                <!-- Botones de acción para cada paciente -->
                                                <div class="btn-group" role="group">
                                                    <!-- Botón para ver la agenda del paciente -->
                                                    <a class="btn bg-cyan waves-effect" href="Carta_Paciente_<?php echo $id; ?>.pdf">
                                                        <i class="material-icons">get_app</i> <B>Carta Generada</B>
                                                    </a>                                      
                                                </div>                                       
                                            </td>
                                        </tr>
                                    <?php 
                                        // Reiniciar el mensaje de alerta de pago
                                        $span = ''; 
                                    } 
                                    ?>     
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php 
// Incluir la primera parte del footer que contiene scripts iniciales
include($ruta.'footer1.php'); 
?>

<!-- Incluir los scripts necesarios para el funcionamiento de DataTable -->
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/jquery.dataTables.js"></script>
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>

<!-- Inicializar el DataTable para la tabla -->
<script src="<?php echo $ruta; ?>js/pages/tables/jquery-datatable.js"></script>

<?php 
// Incluir la segunda parte del footer que finaliza la estructura HTML
include($ruta.'footer2.php'); 
?>
                                                            