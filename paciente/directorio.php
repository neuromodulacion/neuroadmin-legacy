<?php
// ------------------------------------------------
// EJEMPLO: directorio.php
// ------------------------------------------------

// 1) Definir la ruta base para incluir archivos (ajusta según tu proyecto)
$ruta = "../";
$titulo = "Directorio";

// 2) Incluir header1.php u otras inicializaciones
include($ruta . 'header1.php');

// ------------------------------------------------
// OBTENER LISTA DE ESTATUS DESDE LA BD
// ------------------------------------------------
// (Incluir “Eliminado” para que pueda ser seleccionado si se desea)
$estatus_disponibles = [];
$sql_estatus = "SELECT DISTINCT estatus FROM estatus_paciente";
$result_estatus = ejecutar($sql_estatus);
while ($row = mysqli_fetch_assoc($result_estatus)) {
    $estatus_disponibles[] = $row['estatus'];
}

// ------------------------------------------------
// RECIBIR SELECCIONES DEL USUARIO (POST) Y CONSTRUIR FILTRO
// ------------------------------------------------
$selectedStatuses = [];
if (isset($_POST['estatus'])) {
    $selectedStatuses = $_POST['estatus'];  // array con los estatus seleccionados
}

// Si el usuario no selecciona nada, consideraremos “mostrar todos”
$where = " AND 1=1 ";
if (!empty($selectedStatuses)) {
    $arr = array_map(function($item) use ($mysql) {
        return $mysql->escape($item);
    }, $selectedStatuses);

    $estatus_string = "'" . implode("','", $arr) . "'";
    // En lugar de "=", aquí haces ".=" para concatenar
    $where .= " AND pacientes.estatus IN ($estatus_string)";
}


// ------------------------------------------------
// Variables comunes, fecha, etc.
// ------------------------------------------------

if (in_array((string)$funcion_id, ['1','2','5','6','8'], true)) {
    $class = "js-exportable";
    $where .= " AND pacientes.empresa_id = $empresa_id"; // <--- usar .=
    $app ="min-width: 320px";
} else {
    $class = "";
    if (in_array((string)$funcion_id, ['4'], true)) {
        $app ="min-width: 100px";
        $where .= " AND pacientes.empresa_id = $empresa_id AND pacientes.usuario_id = $usuario_id";
    } else {
        $app ="min-width: 100px";
        $where .= " AND pacientes.empresa_id = $empresa_id";
    }
}



?>
    <!-- Enlace al archivo CSS para los estilos de DataTables -->
    <link href="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
    
    <!-- Enlace al archivo CSS para el selector de fechas en Material Design -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

    <!-- Enlace al archivo CSS para el selector de fechas en Bootstrap -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />

    <!-- Enlace al archivo CSS para el efecto de espera "Wait Me" -->
    <link href="<?php echo $ruta; ?>plugins/waitme/waitMe.css" rel="stylesheet" />

    <!-- Enlace al archivo CSS para el selector de opciones en Bootstrap -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" /> 


<?php
// Incluir header2.php
include($ruta . 'header2.php');
?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>DIRECTORIO</h2>
        </div>

        <!-- Formulario para seleccionar uno o varios estatus (incluyendo "Eliminado") -->
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h3>Filtrar por Estatus</h3>
                    </div>
                    <div class="body">
                        <form method="POST" action="">
                            <p>Selecciona uno o más estatus y haz clic en <strong>"Filtrar"</strong>:</p>
                            <?php 
                            // Usamos un contador para asignar IDs únicos
                            $i = 1;
                            foreach ($estatus_disponibles as $est) {
                                $checked = in_array($est, $selectedStatuses) ? 'checked' : '';
                                // Creamos un ID único, por ejemplo "md_checkbox_1"
                                $checkboxId = 'md_checkbox_' . $i;
                                ?>
                                <div style="display:inline-block; margin-right:15px;">
                                    <!-- Checkbox con la clase y el ID que deseas -->
                                    <input 
                                        type="checkbox"
                                        id="<?php echo $checkboxId; ?>"
                                        name="estatus[]"
                                        value="<?php echo $est; ?>"
                                        class="filled-in chk-col-teal"
                                        <?php echo $checked; ?>
                                    />
                                    <!-- El label referencia a ese mismo ID -->
                                    <label for="<?php echo $checkboxId; ?>">
                                        <?php echo codificacionUTF($est); ?>
                                    </label>
                                </div>
                                <?php
                                $i++;
                            }
                            ?>
                            <br><br>
                            <button type="submit" class="btn btn-primary">Filtrar</button>
                            <!-- Un botón opcional para quitar el filtro y ver todos -->
                            <a href="directorio.php" class="btn btn-default">Quitar filtro</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mostramos la tabla de resultados filtrados -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div style="height: 95%" class="header">
                        <h1 align="center">Directorio Pacientes</h1>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable <?php echo $class; ?>">
                                    <thead>
                                        <tr>
                                            <th style="display: none"></th>
                                            <th>ID</th>
                                            <th style="min-width: 60px;">Fecha</th>
                                            <th style="min-width: 150px">Nombre</th>
                                            <th>TMS</th>
                                            <th>tDCS</th>
                                            <th>Celular</th>
                                            <th>Estatus</th>
                                            <th style="min-width: 230px;">Acción</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th style="display: none"></th>
                                            <th>ID</th>
                                            <th>Fecha</th>
                                            <th>Nombre</th>
                                            <th>TMS</th>
                                            <th>tDCS</th>
                                            <th>Celular</th>
                                            <th>Estatus</th>
                                            <th>Acción</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php
                                    // ------------------------------------------------
                                    // 4) CONSULTA CON FILTRO DE ESTATUS
                                    // ------------------------------------------------
                                    // Ajusta según tu proyecto:
                                    $empresa_id = 1;  // Ejemplo

                                    $sql_protocolo = "
                                        SELECT DISTINCT
                                            pacientes.*,
                                            estatus_paciente.color,
                                            estatus_paciente.rgb,
                                            estatus_paciente.class,
                                            ( SELECT DISTINCT COUNT(*) FROM historico_sesion WHERE historico_sesion.paciente_id = pacientes.paciente_id and historico_sesion.f_captura >='2024-04-01' ) AS total_sesion,
                                            (
                                            SELECT DISTINCT
                                                COUNT(*) 
                                            FROM
                                                historico_sesion
                                                INNER JOIN protocolo_terapia ON historico_sesion.protocolo_ter_id = protocolo_terapia.protocolo_ter_id 
                                            WHERE
                                                historico_sesion.paciente_id = pacientes.paciente_id 
                                                AND protocolo_terapia.terapia = 'TMS' and historico_sesion.f_captura >='2024-04-01' 
                                            ) AS total_TMS,
                                            (
                                            SELECT DISTINCT
                                                COUNT(*) 
                                            FROM
                                                historico_sesion
                                                INNER JOIN protocolo_terapia ON historico_sesion.protocolo_ter_id = protocolo_terapia.protocolo_ter_id 
                                            WHERE
                                                historico_sesion.paciente_id = pacientes.paciente_id 
                                                AND protocolo_terapia.terapia = 'tDCS'  and historico_sesion.f_captura >='2024-04-01' 
                                            ) AS total_tDCS,
                                            (
                                            SELECT
                                                SUM( cobros.cantidad ) 
                                            FROM
                                                cobros 
                                            WHERE
                                                cobros.empresa_id = pacientes.empresa_id 
                                                AND cobros.paciente_id = pacientes.paciente_id and cobros.f_captura >='2024-04-01'
                                            ORDER BY
                                                cobros.f_captura ASC 
                                            ) AS cnt_pagos,
                                            (
                                            SELECT
                                                SUM( cobros.importe ) 
                                            FROM
                                                cobros 
                                            WHERE
                                                cobros.empresa_id = pacientes.empresa_id 
                                                AND cobros.paciente_id = pacientes.paciente_id  and cobros.f_captura >='2024-04-01'
                                            ORDER BY
                                                cobros.f_captura ASC 
                                            ) AS pago,
                                            admin.nombre AS medico 
                                        FROM
                                            pacientes
                                            INNER JOIN estatus_paciente ON pacientes.estatus = estatus_paciente.estatus
                                            INNER JOIN admin ON pacientes.usuario_id = admin.usuario_id 
                                        WHERE  1=1 
                                            $where
                                        ORDER BY f_captura DESC
                                    ";
                                    // echo $sql_protocolo;
                                    $result_protocolo = ejecutar($sql_protocolo); 
                                    $cnt = 0;

                                    while ($row_protocolo = mysqli_fetch_array($result_protocolo)) {
                                        extract($row_protocolo);

                                        // Ajustar color/clase
                                        if ($class == 'bg-yellow') {
                                            $classHTML = "class='$class' style='color: black !important;'";
                                        } else {
                                            $classHTML = "class='$class'";
                                        }

                                        // Manejo de null
                                        $pago      = is_null($pago) ? 0 : $pago;
                                        $cnt_pagos = is_null($cnt_pagos) ? 0 : $cnt_pagos;

                                        // Fecha
                                        $date  = new DateTime($f_captura);
                                        $today = $date->format('d-M-y');
                                        $today = format_fecha_esp_dmy($today);

                                        // Lógica simple para mostrar un span (solo como ejemplo)
                                        $terapias = $total_TMS + $total_tDCS;
                                        $span = "";
                                        if ($terapias > 0 && $pago == 0 || ($terapias > $cnt_pagos)) {
                                            $falta_pago = $terapias - $cnt_pagos;
                                            $span = '<span class="label label-danger">Faltan '.$falta_pago.' pagos</span>';
                                        } else {
                                            $span = '<span class="label label-success">OK</span>';
                                        }

                                        $cnt++;
                                        ?>
                                        <tr>
                                            <td style="display: none"><?php echo $cnt; ?></td>
                                            <td><?php echo $paciente_id; ?></td>
                                            <td><?php echo $today; ?></td>
                                            <td>
                                                <b><?php echo codificacionUTF($paciente . " " . $apaterno . " " . $amaterno); ?></b><br>
                                                <i><?php echo codificacionUTF($medico); ?></i>
                                            </td>
                                            <td><?php echo $total_TMS; ?></td>
                                            <td><?php echo $total_tDCS; ?></td>
                                            <td><?php echo $celular; ?></td>
                                            <td <?php echo $classHTML; ?>>
                                                <?php echo codificacionUTF($estatus); ?><br>
                                                <?php echo $span; ?>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a class="btn bg-cyan waves-effect" href="<?php echo $ruta; ?>agenda/agenda.php?paciente_id=<?php echo $paciente_id; ?>">
                                                        <i class="material-icons">call_missed_outgoing</i> <b>Agenda</b>
                                                    </a>
                                                    <a class="btn bg-blue waves-effect" href="<?php echo $ruta; ?>paciente/info_paciente.php?paciente_id=<?php echo $paciente_id; ?>">
                                                        <i class="material-icons">chat</i> <b>Datos</b>
                                                    </a>
                                                    <a class="btn btn-info waves-effect" href="<?php echo $ruta; ?>paciente/paciente_edit.php?paciente_id=<?php echo $paciente_id; ?>">
                                                        <i class="material-icons">edit</i> <b>Edit</b>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div> <!-- table-responsive -->
                        </div> <!-- body -->
                    </div> <!-- header -->
                </div> <!-- card -->
            </div> <!-- col -->
        </div> <!-- row -->
    </div> <!-- container -->
</section>

<!-- Incluimos footer1.php y scripts requeridos para DataTables -->
<?php 
include($ruta.'footer1.php'); 
?>

<!-- Estilos y Scripts de DataTable (ajusta según tu estructura) -->
<link href="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
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
include($ruta.'footer2.php');
?>
