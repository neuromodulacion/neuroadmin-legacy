<?php
include('../api/funciones_api.php'); // Funciones adicionales de la API

$ruta="../";

$titulo ="Registro de Visitas";

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
            <h2>REGISTRO DE VISITAS</h2>
        </div>
        <!-- Contenido -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div style="height: 95%" class="header">
                        <h1 align="center">Historial de Visitas</h1>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Representante</th>
                                        <th>Médico</th>
                                        <th>Fecha</th>
                                        <th>Duración (min)</th>
                                        <th>Objetivo</th>
                                        <th>Resultados</th>
                                        <th>Observaciones</th>
                                        <th>Prox. Visita</th>
                                        <th>Fecha Visita</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Representante</th>
                                        <th>Médico</th>
                                        <th>Fecha</th>
                                        <th>Duración (min)</th>
                                        <th>Objetivo</th>
                                        <th>Resultados</th>
                                        <th>Observaciones</th>
                                        <th>Prox. Visita</th>
                                        <th>Fecha Visita</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    // Consulta para obtener los datos de la tabla
                                    $sql_visitas = "
                                        SELECT
                                            v.visita_id, 
                                            v.fecha, 
                                            v.hora, 
                                            v.duracion, 
                                            v.objetivo, 
                                            v.resultados, 
                                            v.observaciones, 
                                            v.pagado, 
                                            v.p_visita, 
                                            v.f_visita, 
                                            v.medico_id, 
                                            v.usuario_id, 
                                            m.nombre AS medico, 
                                            r.nombre AS representante
                                        FROM
                                            registro_visitas AS v
                                        INNER JOIN
                                            admin AS m
                                            ON v.medico_id = m.usuario_id
                                        INNER JOIN
                                            admin AS r
                                            ON v.usuario_id = r.usuario_id
                                        WHERE v.empresa_id = ?";

                                    // Ejecutar la consulta
                                    $visitas = $mysql->consulta($sql_visitas, [$_SESSION['empresa_id']]);

                                    if ($visitas['numFilas'] > 0) {
                                        foreach ($visitas['resultado'] as $visita) {
                                            ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($visita['representante'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td><?php echo htmlspecialchars($visita['medico'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td><?php echo htmlspecialchars($visita['fecha'] ?? '', ENT_QUOTES, 'UTF-8'); ?><br><?php echo htmlspecialchars($visita['hora'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td><?php echo htmlspecialchars($visita['duracion'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td><?php echo htmlspecialchars($visita['objetivo'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td><?php echo htmlspecialchars($visita['resultados'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td><?php echo htmlspecialchars($visita['observaciones'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td><?php echo htmlspecialchars($visita['p_visita'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td><?php echo htmlspecialchars($visita['f_visita'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        echo "<tr><td colspan='11' align='center'>No se encontraron registros</td></tr>";
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
