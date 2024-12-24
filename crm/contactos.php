<?php
include('../api/funciones_api.php'); // Funciones adicionales de la API

$ruta="../";

$titulo ="Directorio de Contactos";

include($ruta.'header1.php'); 
?>

<!-- Inclusión de los estilos para DataTable de JQuery -->
<link href="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

<?php include($ruta.'header2.php'); 


?>

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
                        <h1 style="text-align: center;" >Historial de Contactos</h1>
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
                                            contactos.id,
                                            contactos.usuario_id,
                                            contactos.medico_id,
                                            contactos.telefono,
                                            contactos.domicilio,
                                            contactos.metodo_contacto,
                                            contactos.exito,
                                            contactos.observaciones,
                                            contactos.f_visita,
                                            contactos.fecha_registro,
                                            admin.nombre AS representante,
                                            admin_tem.nombre AS medico 
                                        FROM
                                            contactos
                                            INNER JOIN admin ON contactos.usuario_id = admin.usuario_id
                                            INNER JOIN admin_tem ON contactos.medico_id = admin_tem.medico_id 
                                        WHERE
                                            contactos.empresa_id = ?";

                                    // Ejecutar la consulta
                                    $contactos = $mysql->consulta($sql_contactos, [$_SESSION['empresa_id']]);

                                    if ($contactos['numFilas'] > 0) {
                                        foreach ($contactos['resultado'] as $contacto) {
                                            ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($contacto['representante'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td><?php echo htmlspecialchars($contacto['medico'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td><?php echo htmlspecialchars($contacto['telefono'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td><?php echo htmlspecialchars($contacto['metodo_contacto'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td><?php echo isset($contacto['exito']) && $contacto['exito'] ? 'Sí' : 'No'; ?></td>
                                                <td><?php echo htmlspecialchars($contacto['observaciones'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td><?php echo htmlspecialchars($contacto['f_visita'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        echo "<tr><td colspan='7' align='center'>No se encontraron registros</td></tr>";
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


<?php include($ruta.'footer2.php'); ?>
