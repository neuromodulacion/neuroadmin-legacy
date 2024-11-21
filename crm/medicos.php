<?php

function limpiarEntrada($entrada, $tipo) {
    $entrada = trim($entrada); // Elimina espacios al inicio y al final

    if ($tipo === 'email') {
        // Sanitiza como correo electrónico
        return filter_var($entrada, FILTER_SANITIZE_EMAIL);
    } elseif ($tipo === 'telefono') {
        // Elimina todo excepto dígitos, '+' y '-'
        return preg_replace('/[^\d\+\-]/', '', $entrada);
    } else {
        // Elimina todos los espacios como un caso general
        return str_replace(' ', '', $entrada);
    }
}

/* // Ejemplo de uso
$correo = " usuario @ ejemplo . com ";
$telefono = " +52 33 1234 5678 ";

echo limpiarEntrada($correo, 'email');   // Resultado: "usuario@ejemplo.com"
echo limpiarEntrada($telefono, 'telefono'); // Resultado: "+523312345678" */


$ruta="../";  // Definir la ruta base para incluir archivos comunes
$titulo ="Directorio";  // Título de la página
$genera = "";  // Variable auxiliar para manejo adicional si es necesario

// Incluir la primera parte del header de la página
include($ruta.'header1.php');?>

<!-- Estilos CSS para el uso de tablas de datos y selectores de fecha y hora -->
<link href="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
<link href="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />
<link href="<?php echo $ruta; ?>plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
<link href="<?php echo $ruta; ?>plugins/waitme/waitMe.css" rel="stylesheet" />
<link href="<?php echo $ruta; ?>plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

<?php  
// Incluir la segunda parte del header con el menú y configuraciones de usuario
include($ruta.'header2.php'); ?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>DIRECTORIO</h2>
        </div>

        <!-- Contenedor de la tabla de directorio médico -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div style="height: 95%" class="header">
                        <h1 align="center">Directorio Médico</h1>
                        <div class="table-responsive">
                            <!-- Tabla que muestra el directorio médico con opciones de exportación -->
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th style="text-align: center">ID</th>
                                        <th style="text-align: center">Nombre</th>
                                        <th style="text-align: center">Correo</th>
                                        <th style="text-align: center">Teléfono</th>
                                        <th style="text-align: center">Pacientes</th>
                                        <th style="text-align: center">Estatus</th>
                                        <th style="text-align: center">Datos</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th style="text-align: center">ID</th>
                                        <th style="text-align: center">Nombre</th>
                                        <th style="text-align: center">Correo</th>
                                        <th style="text-align: center">Teléfono</th>
                                        <th style="text-align: center">Pacientes</th>
                                        <th style="text-align: center">Estatus</th>
                                        <th style="text-align: center">Datos</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                <?php
                                // Consulta SQL para obtener datos del directorio médico
                                $sql_protocolo = "
                                    SELECT
                                        admin.usuario_id as usuario_idx,
                                        admin.nombre as nombrex,
                                        admin.usuario as usuariox,
                                        admin.funcion as funcionx,
                                        admin.observaciones,
                                        admin.estatus as estatusx,
                                        admin.telefono,
                                        (SELECT COUNT(*) FROM pacientes WHERE pacientes.usuario_id = admin.usuario_id) as pacientes
                                    FROM
                                        admin 
                                    WHERE
                                        admin.empresa_id = $empresa_id
                                        AND (admin.funcion = 'MEDICO' OR usuario_id = 11)
                                ";
                                $result_protocolo = ejecutar($sql_protocolo);  // Ejecutar la consulta SQL
                                $cnt = 1;  // Contador de filas
                                while($row_protocolo = mysqli_fetch_array($result_protocolo)){
                                    extract($row_protocolo);

                                    // Validar el número de teléfono y asignar clase CSS según longitud
                                    //$telefono = validarSinEspacios($telefono);
                                    $telefono = limpiarEntrada($telefono, 'telefono');

                                    $clase = (strlen($telefono) !== 10) ? "danger" : "success";

                                    // Asignar clase CSS según el estatus del médico
                                    switch ($estatus) {
                                        case 'Activo':
                                            $clasex = "success";
                                            break;
                                        case 'Pendiente':
                                            $clasex = "info";
                                            break;
                                        case 'Inactivo':
                                            $clasex = "warning";
                                            break;
                                        case 'Bloqueado':
                                            $clasex = "danger";
                                            break;
                                        case 'Prospecto':
                                            $clasex = "active";
                                            break;											
                                    }  
                                ?>
                                    <!-- Fila de datos de cada médico -->
                                    <tr>
                                        <td style='color: black'><?php echo $usuario_idx; ?></td>
                                        <td><?php echo $nombrex; ?></td>
                                        <td><?php echo $usuariox; ?></td>
                                        <td style="text-align: center" class="<?php echo $clase; ?>">
                                            <?php echo $telefono;
                                            // Mostrar botón de contacto por WhatsApp si el teléfono es válido
                                            if ($clase == "success") {
                                                echo "<br> <a class='btn bg-teal waves-effect' target='_blank' href='https://api.whatsapp.com/send?phone=52".$telefono."&text=Estimado(a) Dr.".$nombrex.", estamos a su disposición.'>
                                                <img align='left' border='0' src='".$ruta."images/WhatsApp.png' style='width: 25px;' ></a>";
                                            } ?>
                                        </td>
                                        <td style="text-align: center"><?php echo $pacientes; ?></td>
                                        <td style="text-align: center" class="<?php echo $clasex; ?>"><?php echo $estatusx; ?></td>
                                        <td>
                                            <a class="btn btn-info btn-sm waves-effect" href="<?php echo $ruta; ?>crm/info_usuario.php?usuario_idx=<?php echo $usuario_idx; ?>">
                                                <i class="material-icons">assignment</i> <b>Datos</b>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>   
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
// Incluir las secciones de pie de página y scripts adicionales
include($ruta.'footer1.php'); ?>

<!-- Scripts necesarios para DataTables y exportación de datos -->
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/jquery.dataTables.js"></script>
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>
<script src="<?php echo $ruta; ?>js/pages/tables/jquery-datatable.js"></script>

<?php 
// Incluir la segunda parte del footer que cierra la estructura de la página
include($ruta.'footer2.php'); ?>
