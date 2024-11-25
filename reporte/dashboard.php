<?php
// dashboard.php

$ruta = "../";
$titulo = "Menú TMS";

// Iniciar sesión y configuración
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('default_charset', 'UTF-8');
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');


// Variables de fecha y hora
$hoy = date("Y-m-d");
$ahora = date("H:i:00");
$anio = date("Y");
$mes_ahora = date("m");

// Incluir headers y footer
include($ruta . 'header1.php');
include($ruta . 'header2.php');

// Variables de sesión
$sesion = $_SESSION['sesion'];
$usuario_id = $_SESSION['usuario_id'];
$empresa_id = $_SESSION['empresa_id'];
$body = $_SESSION['body'];
$emp_nombre = $_SESSION['emp_nombre'];
?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>DASHBOARD</h2>
        </div>
        <!-- Contenido -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div style="height: 95%" class="header">
                        <h3 align="center"><?php echo htmlspecialchars($emp_nombre); ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <?php
            // Consultas para obtener datos
            try {
                // Pacientes Activos
                $sql = "SELECT COUNT(*) AS pacientes FROM pacientes WHERE estatus = 'Activo'";
                $result = $mysql->consulta($sql);
                $pacientes_activos = $result['resultado'][0]['pacientes'] ?? 0;

                // Pacientes Nuevos
                $sql = "SELECT COUNT(*) AS pacientes FROM pacientes WHERE estatus = 'Activo' AND YEAR(f_captura) = ? AND MONTH(f_captura) = ?";
                $params = [$anio, $mes_ahora];
                $result = $mysql->consulta($sql, $params);
                $pacientes_nuevos = $result['resultado'][0]['pacientes'] ?? 0;

                // Pacientes Pendientes
                $sql = "SELECT COUNT(*) AS pacientes FROM pacientes WHERE estatus = 'Pendiente'";
                $result = $mysql->consulta($sql);
                $pacientes_pendientes = $result['resultado'][0]['pacientes'] ?? 0;

                // Pacientes Seguimiento
                $sql = "SELECT COUNT(*) AS pacientes FROM pacientes WHERE estatus = 'Seguimiento'";
                $result = $mysql->consulta($sql);
                $pacientes_seguimiento = $result['resultado'][0]['pacientes'] ?? 0;

                // Pacientes Confirmado
                $sql = "SELECT COUNT(*) AS pacientes FROM pacientes WHERE estatus = 'Confirmado'";
                $result = $mysql->consulta($sql);
                $pacientes_confirmado = $result['resultado'][0]['pacientes'] ?? 0;

                // Pacientes No Interesados
                $sql = "SELECT COUNT(*) AS pacientes FROM pacientes WHERE estatus = 'No interezado'";
                $result = $mysql->consulta($sql);
                $pacientes_no_interesados = $result['resultado'][0]['pacientes'] ?? 0;

                // Sesiones TMS Mes
                $sql = "SELECT COUNT(*) AS tms FROM historico_sesion INNER JOIN protocolo_terapia ON historico_sesion.protocolo_ter_id = protocolo_terapia.protocolo_ter_id WHERE terapia = 'TMS' AND YEAR(historico_sesion.f_captura) = ? AND MONTH(historico_sesion.f_captura) = ?";
                $params = [$anio, $mes_ahora];
                $result = $mysql->consulta($sql, $params);
                $tms_mes = $result['resultado'][0]['tms'] ?? 0;

                // Sesiones TMS Total
                $sql = "SELECT COUNT(*) AS tms FROM historico_sesion INNER JOIN protocolo_terapia ON historico_sesion.protocolo_ter_id = protocolo_terapia.protocolo_ter_id WHERE terapia = 'TMS'";
                $result = $mysql->consulta($sql);
                $tms_total = $result['resultado'][0]['tms'] ?? 0;

                // Sesiones tDCS Mes
                $sql = "SELECT COUNT(*) AS tdcs FROM historico_sesion INNER JOIN protocolo_terapia ON historico_sesion.protocolo_ter_id = protocolo_terapia.protocolo_ter_id WHERE terapia = 'tDCS' AND YEAR(historico_sesion.f_captura) = ? AND MONTH(historico_sesion.f_captura) = ?";
                $params = [$anio, $mes_ahora];
                $result = $mysql->consulta($sql, $params);
                $tdcs_mes = $result['resultado'][0]['tdcs'] ?? 0;

                // Sesiones tDCS Total
                $sql = "SELECT COUNT(*) AS tdcs FROM historico_sesion INNER JOIN protocolo_terapia ON historico_sesion.protocolo_ter_id = protocolo_terapia.protocolo_ter_id WHERE terapia = 'tDCS'";
                $result = $mysql->consulta($sql);
                $tdcs_total = $result['resultado'][0]['tdcs'] ?? 0;

                // Ingresos, Egresos y Diferencia Neuromodulación GDL
                $sql = "
                SELECT
                    (SELECT COALESCE(SUM(cobros.importe), 0) FROM cobros WHERE MONTH(cobros.f_captura) = ? AND YEAR(cobros.f_captura) = ? AND cobros.doctor = 'Neuromodulacion GDL') AS cobros,
                    (SELECT COALESCE(SUM(pagos.importe), 0) FROM pagos WHERE MONTH(pagos.f_captura) = ? AND YEAR(pagos.f_captura) = ? AND pagos.negocio = 'Neuromodulacion GDL') AS pagos
                ";
                $params = [$mes_ahora, $anio, $mes_ahora, $anio];
                $result = $mysql->consulta($sql, $params);
                $cobros = $result['resultado'][0]['cobros'] ?? 0;
                $pagos = $result['resultado'][0]['pagos'] ?? 0;
                $diferencia = $cobros - $pagos;

                // Otros cálculos pueden continuar de la misma manera...

            } catch (Exception $e) {
                echo "Error al obtener datos: " . $e->getMessage();
            }
            ?>

            <!-- Mostrar los datos en el dashboard -->
            <!-- Pacientes Activos -->
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box-4">
                    <div class="icon">
                        <i class="material-icons col-teal">person</i>
                    </div>
                    <div class="content">
                        <div class="text">PACIENTES</div>
                        <div class="number count-to" data-from="0" data-to="<?php echo htmlspecialchars($pacientes_activos); ?>" data-speed="1000" data-fresh-interval="20"></div>
                    </div>
                </div>
            </div>

            <!-- Pacientes Nuevos -->
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box-4">
                    <div class="icon">
                        <i class="material-icons col-teal">person_add</i>
                    </div>
                    <div class="content">
                        <div class="text">PACIENTES NUEVOS</div>
                        <div class="number count-to" data-from="0" data-to="<?php echo htmlspecialchars($pacientes_nuevos); ?>" data-speed="1000" data-fresh-interval="20"></div>
                    </div>
                </div>
            </div>

            <!-- Continuar con los demás bloques de información de la misma manera -->

            <!-- Ingresos Neuromodulación GDL -->
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box-4">
                    <div class="icon">
                        <i class="material-icons col-black">attach_money</i>
                    </div>
                    <div class="content">
                        <div class="text">INGRESOS</div>
                        <div class="number count-to" data-from="0" data-to="<?php echo htmlspecialchars($cobros); ?>" data-speed="1000" data-fresh-interval="20"></div>
                    </div>
                </div>
            </div>

            <!-- Egresos Neuromodulación GDL -->
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box-4">
                    <div class="icon">
                        <i class="material-icons col-red">attach_money</i>
                    </div>
                    <div class="content">
                        <div class="text">EGRESOS</div>
                        <div class="number count-to" data-from="0" data-to="<?php echo htmlspecialchars($pagos); ?>" data-speed="1000" data-fresh-interval="20"></div>
                    </div>
                </div>
            </div>

            <!-- Diferencia Neuromodulación GDL -->
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box-4">
                    <div class="icon">
                        <i class="material-icons col-blue">attach_money</i>
                    </div>
                    <div class="content">
                        <div class="text">DIFERENCIA</div>
                        <div class="number count-to" data-from="0" data-to="<?php echo htmlspecialchars($diferencia); ?>" data-speed="1000" data-fresh-interval="20"></div>
                    </div>
                </div>
            </div>

            <!-- Continúa con los demás bloques de información, asegurándote de usar htmlspecialchars y manejar excepciones -->

        </div>
    </div>
</section>

<?php include($ruta . 'footer.php'); ?>
