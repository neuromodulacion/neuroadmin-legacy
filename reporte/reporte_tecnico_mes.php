<?php
session_start();
error_reporting(7);
iconv_set_encoding('internal_encoding', 'utf-8');
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');

$_SESSION['time'] = time();
$ruta = "../";

extract($_SESSION);
extract($_POST);

$titulo ="Reporte";

$hoy = date("Y-m-d");
$ahora = date("H:i:00");
$anio_actual = date("Y");

// Si no se ha enviado el año por POST, se usa el año actual
if (empty($anioInput)) {
    $anio_sel = $anio_actual;
} else {
    $anio_sel = $anioInput;
}

include($ruta.'header1.php');
?>
<link href="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
<link href="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />
<link href="<?php echo $ruta; ?>plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
<link href="<?php echo $ruta; ?>plugins/waitme/waitMe.css" rel="stylesheet" />
<link href="<?php echo $ruta; ?>plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />   

<script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.0/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.2/raphael-min.js"></script>
<script src="../morris.js-master/morris.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prettify/r224/prettify.min.js"></script>
<script src="../morris.js-master/examples/lib/example.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prettify/r224/prettify.min.css">
<link rel="stylesheet" href="../morris.js-master/morris.css">

<?php include($ruta.'header2.php'); ?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>REPORTE DE TÉCNICOS</h2>
            <?php echo $ubicacion_url;?>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div style="height: 95%" class="header">
                        <h1 align="center">Reporte de Técnicos (por Mes - Año <?php echo $anio_sel; ?>)</h1>
                        <hr>
                        <div align="right">
                        <form action="reporte_tecnico_mes.php" method="post" class="form-inline" style="display:inline-block;">
                            <?php 
                            $currentYear = date("Y");
                            $startYear = 2023; 
                            ?>
                            <select name="anioInput" class="form-control" style="width: 100px; display:inline-block;" onchange="this.form.submit()">
                                <?php 
                                for ($y = $startYear; $y <= $currentYear; $y++) {
                                    $selected = ($y == $anio_sel) ? 'selected' : '';
                                    echo "<option value=\"$y\" $selected>$y</option>";
                                }
                                ?>
                            </select>
                            <input id="us" name="us" type="hidden" class="form-control" value="<?php echo $us; ?>"/>
                        </form>

                        </div>
                        <hr>

                        <?php
                        // Obtenemos todos los técnicos
                        $sql_user = "
                            SELECT
                                admin.usuario_id,
                                admin.nombre
                            FROM
                                admin
                            WHERE
                                admin.funcion IN('TECNICO')
                                AND admin.estatus = 'Activo'
                                AND admin.empresa_id = $empresa_id
                            ORDER BY
                                admin.nombre ASC
                        ";
                        $result_user = ejecutar($sql_user);

                        // Meses del año (1 a 12)
                        $months = array(
                            '01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril',
                            '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto',
                            '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'
                        );

                        // Construcción de la query dinámica para obtener conteos por mes
                        // Ejemplo de subselect:
                        // (SELECT COUNT(*) FROM historico_sesion WHERE YEAR(f_captura) = $anio_sel AND MONTH(f_captura)=1 AND usuario_id = admin.usuario_id) AS mes1
                        $sql_counts = "SELECT admin.usuario_id, admin.nombre,";
                        $mes_keys = [];
                        $i = 1;
                        foreach ($months as $m => $mn) {
                            if ($i == 12) {
                                $sql_counts .= "
                                (SELECT COUNT(*) FROM historico_sesion 
                                 WHERE YEAR(f_captura) = $anio_sel AND MONTH(f_captura) = $m AND usuario_id = admin.usuario_id) AS mes$m ";
                            } else {
                                $sql_counts .= "
                                (SELECT COUNT(*) FROM historico_sesion 
                                 WHERE YEAR(f_captura) = $anio_sel AND MONTH(f_captura) = $m AND usuario_id = admin.usuario_id) AS mes$m,";
                            }
                            $mes_keys[] = "mes$m";
                            $i++;
                        }

                        $sql_counts .= "FROM admin 
                                        WHERE 
                                            admin.funcion IN('TECNICO')
                                            AND admin.estatus = 'Activo'
                                            AND admin.empresa_id = $empresa_id
                                        ORDER BY admin.nombre ASC";

                        $result_counts = ejecutar($sql_counts);

                        $table = "<div class='table-responsive'>
                        <table style='width: 100%; font-size: 12px' class='table table-bordered js-exportable'>
                            <thead>
                                <tr>
                                    <th>Nombre</th>";
                        foreach ($months as $m => $mn) {
                            $table .= "<th>$mn</th>";
                        }
                        $table .= "</tr>
                            </thead>
                            <tbody>";

                        // Para la gráfica
                        // Generamos data mensual agregando todos los usuarios
                        // Primero: totales por mes para fila final
                        $totales_mensuales = array();
                        foreach ($months as $m => $mn) {
                            $sql_tot = "
                                SELECT COUNT(*) AS total
                                FROM historico_sesion
                                WHERE YEAR(f_captura) = $anio_sel
                                AND MONTH(f_captura) = $m
                            ";
                            $res_tot = ejecutar($sql_tot);
                            $row_tot = mysqli_fetch_assoc($res_tot);
                            $totales_mensuales[$m] = $row_tot['total'];
                        }

                        while($row = mysqli_fetch_assoc($result_counts)) {
                            $table .= "<tr>";
                            $table .= "<td>{$row['nombre']}</td>";
                            foreach ($months as $m => $mn) {
                                $mes_col = "mes$m";
                                $count_val = $row[$mes_col];
                                if ($count_val > 0) {
                                    $class_tx = "success";
                                } else {
                                    $class_tx = "default";
                                }

                                // Botón modal (opcional, similar a lo que tenías antes)
                                $script_tx = "
                                <script>
                                    $('#boton_".$row['usuario_id']."_".$m."').click(function() {
                                        var fecha = '".$anio_sel."-".$m."';
                                        var usuario_idx = '".$row['usuario_id']."';
                                        var tipo_consulta = 'mensual';
                                        var medico = '".$row['nombre']."';
                                        var datastring = 'fecha='+fecha+'&tipo_consulta='+tipo_consulta+'&usuario_idx='+usuario_idx+'&medico='+medico;
                                        $('#contenido_modal').html('');
                                        $.ajax({
                                            url: 'genera_tecnicos.php',
                                            type: 'POST',
                                            data: datastring,
                                            cache: false,
                                            success:function(html){   
                                                $('#contenido_modal').html(html);
                                                $('#modal_grafica').click(); 
                                            }
                                        });                                                                             
                                    });
                                </script>";
                                $table .= "<td><button id='boton_".$row['usuario_id']."_".$m."' type='button' class='btn btn-".$class_tx." waves-effect'>".$count_val."</button>".$script_tx."</td>";
                            }

                            $table .= "</tr>";
                        }

                        $table .= "</tbody>";
                        // Agregamos la fila de totales
                        $table .= "<tfoot><tr><th>Total</th>";
                        foreach ($months as $m => $mn) {
                            $total_val = $totales_mensuales[$m];
                            if ($total_val > 0) {
                                $class_t = "info";
                            } else {
                                $class_t = "default";
                            }
                            $script_t = "
                            <script>
                                $('#boton_tot_".$m."').click(function() {
                                    var fecha = '".$anio_sel."-".$m."';
                                    var tipo_consulta = 'total_mensual';
                                    var datastring = 'fecha='+fecha+'&tipo_consulta='+tipo_consulta;
                                    $('#contenido_modal').html('');
                                    $.ajax({
                                        url: 'genera_tecnicos.php',
                                        type: 'POST',
                                        data: datastring,
                                        cache: false,
                                        success:function(html){   
                                            $('#contenido_modal').html(html);
                                            $('#modal_grafica').click(); 
                                        }
                                    });
                                });
                            </script>";
                            $table .= "<th><button id='boton_tot_".$m."' type='button' class='btn btn-".$class_t." waves-effect'>".$total_val."</button>".$script_t."</th>";
                        }
                        $table .= "</tr></tfoot>";

                        $table .= "</table></div>";

                        echo $table;

                        // Generación de datos para la gráfica por mes
                        // Cada punto representará un mes en el año seleccionado.
                        // Para la gráfica, sumamos todos los usuarios por mes (ya lo tenemos en $totales_mensuales)
                        // Por ejemplo, week_data será monthly_data.
                        $grafica = "[";
                        foreach ($months as $m => $mn) {
                            $fecha_str = $anio_sel."-".$m;
                            $grafica .= "{ y: '$fecha_str', total: ".$totales_mensuales[$m]." },";
                        }
                        $grafica .= "]";

                        ?>

                    </div>
                    <hr>
                    <h1 align="center">Gráfica Mensual</h1>
                    <div style='width: 100%' id='graph'></div>                         
                    <script> 
                        var monthly_data = <?php echo $grafica; ?>;
                        // Solo un conjunto de datos "total" para simplificar la gráfica.
                        Morris.Line({
                          element: 'graph',
                          data: monthly_data,
                          xkey: 'y',
                          ykeys: ['total'],
                          labels: ['Total Sesiones'],
                          lineColors: ['#0b62a4'],
                          xLabelFormat: function (d) {
                            var month = d.getMonth()+1;
                            return month;
                          },
                          dateFormat: function (x) {
                            var d = new Date(x);
                            return d.getFullYear() + '-' + (d.getMonth()+1);
                          }
                        }); 
                    </script>
                </div>
            </div>
        </div>
    </div>

    <button style="display: none" id="modal_grafica" type="button" class="btn btn-default waves-effect m-r-20" data-toggle="modal" data-target="#largeModal">MODAL - LARGE SIZE</button>
    <!-- Large Size -->
    <div class="modal fade" id="largeModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="largeModalLabel">Detalle</h4>
                </div>
                <div id="contenido_modal" class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include($ruta.'footer1.php'); ?>

<script src="<?php echo $ruta; ?>plugins/momentjs/moment.js"></script>
<script src="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
<script src="<?php echo $ruta; ?>plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo $ruta; ?>plugins/autosize/autosize.js"></script>
<script src="<?php echo $ruta; ?>plugins/jquery-knob/jquery.knob.min.js"></script>
<script src="<?php echo $ruta; ?>js/pages/charts/jquery-knob.js"></script>   

<?php include($ruta.'footer2.php'); ?>
