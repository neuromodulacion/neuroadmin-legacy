<?php
include('../api/funciones_api.php'); // Funciones adicionales de la API

$ruta="../";

$titulo ="Directorio de Contactos";

include($ruta.'header1.php'); 
?>

<!-- JQuery DataTable Css -->
<link href="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

<!-- Bootstrap Material Datetime Picker Css -->
<link href="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

<!-- Bootstrap DatePicker Css -->
<link href="<?php echo $ruta; ?>plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />

<!-- Wait Me Css -->
<link href="<?php echo $ruta; ?>plugins/waitme/waitMe.css" rel="stylesheet" />

<!-- Bootstrap Select Css -->
<link href="<?php echo $ruta; ?>plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

<?php include($ruta.'header2.php'); ?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>DIRECTORIO DE CONTACTOS</h2>
        </div>
        <!-- Contenido -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div style="height: 95%" class="header">
                        <h1 align="center">Historial de Contactos</h1>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Representante</th>
                                        <th>Médico</th>
                                        <th>Teléfono</th>
                                        <th>Método de Contacto</th>
                                        <th>Éxito</th>
                                        <th>Observaciones</th>
                                        <th>Fecha de Contacto</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Representante</th>
                                        <th>Médico</th>
                                        <th>Teléfono</th>
                                        <th>Método de Contacto</th>
                                        <th>Éxito</th>
                                        <th>Observaciones</th>
                                        <th>Fecha de Contacto</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    // Consulta para obtener los datos de la tabla
                                    $sql_contactos = "
                                        SELECT
                                            c.id,
                                            c.telefono,
                                            c.domicilio,
                                            c.metodo_contacto,
                                            c.exito,
                                            c.observaciones,
                                            c.fecha_contacto,
                                            a.nombre AS medico,
                                            c.usuario_id,
                                            admin.nombre 
                                        FROM
                                            contactos AS c
                                            JOIN admin_tem AS a ON c.medico_id = a.medico_id
                                            INNER JOIN admin ON c.usuario_id = admin.usuario_id 
                                        WHERE
                                            c.empresa_id = ?";

                                    // Ejecutar la consulta
                                    $contactos = $mysql->consulta($sql_contactos, [$_SESSION['empresa_id']]);

                                    if ($contactos['numFilas'] > 0) {
                                        foreach ($contactos['resultado'] as $contacto) {
                                            ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($contacto['nombre'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td><?php echo htmlspecialchars($contacto['medico'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td><?php echo htmlspecialchars($contacto['telefono'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td><?php echo htmlspecialchars($contacto['metodo_contacto'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td><?php echo isset($contacto['exito']) && $contacto['exito'] ? 'Sí' : 'No'; ?></td>
                                                <td><?php echo htmlspecialchars($contacto['observaciones'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td><?php echo htmlspecialchars($contacto['fecha_contacto'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        echo "<tr><td colspan='8' align='center'>No se encontraron registros</td></tr>";
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

<?php include($ruta.'footer1.php'); ?>

<!-- Jquery DataTable Plugin Js -->
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

<?php include($ruta.'footer2.php'); ?>
