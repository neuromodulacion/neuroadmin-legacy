<?php
// Función para limpiar entradas de usuario de manera segura
function limpiarEntrada($entrada, $tipo) {
    $entrada = $entrada ?? ''; // Asignar cadena vacía si es null
    $entrada = trim($entrada); // Elimina espacios al inicio y al final

    if ($tipo === 'email') {
        // Sanitiza como correo electrónico
        return filter_var($entrada, FILTER_SANITIZE_EMAIL);
    } elseif ($tipo === 'telefono') {
        // Elimina todo excepto dígitos y el signo '+'
        return preg_replace('/[^\d\+]/', '', $entrada);
    } else {
        // Elimina espacios en blanco adicionales
        return preg_replace('/\s+/', ' ', $entrada);
    }
}


// Definición de variables
$ruta = "../";  // Definir la ruta base para incluir archivos comunes
$titulo = "Directorio";  // Título de la página
$genera = "";  // Variable auxiliar para manejo adicional si es necesario

// Incluir la primera parte del header de la página
include($ruta . 'header1.php');
?>

<!-- Estilos CSS para el uso de tablas de datos y selectores de fecha y hora -->
<link href="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
<link href="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />
<link href="<?php echo $ruta; ?>plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
<link href="<?php echo $ruta; ?>plugins/waitme/waitMe.css" rel="stylesheet" />
<link href="<?php echo $ruta; ?>plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

<?php  
// Incluir la segunda parte del header con el menú y configuraciones de usuario
include($ruta . 'header2.php'); 
?>

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
                        <h1 align="center">Directorio Posible Médico Referenciador</h1>
                        <div class="table-responsive">
                            <!-- Tabla que muestra el directorio médico con opciones de exportación -->
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th style="text-align: center">ID</th>
                                        <th style="text-align: center">Nombre</th>
                                        <th style="text-align: center">Correo</th>
                                        <th style="text-align: center">Teléfono</th>
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
                                        <th style="text-align: center">Estatus</th>
                                        <th style="text-align: center">Datos</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                <?php
                                // Asumiendo que $mysql es la instancia de la clase Mysql
                                // y que $empresa_id es una variable previamente definida y validada

                                // Consulta segura utilizando sentencias preparadas
                                $query = "
                                    SELECT
                                        admin_tem.medico_id AS usuario_idx,
                                        admin_tem.nombre AS nombrex,
                                        admin_tem.usuario AS usuariox,
                                        admin_tem.funcion AS funcionx,
                                        admin_tem.observaciones,
                                        admin_tem.estatus AS estatusx,
                                        admin_tem.telefono
                                    FROM
                                        admin_tem 
                                    WHERE
                                        admin_tem.empresa_id = ?
                                ";

                                // Parámetros de la consulta
                                $params = [ $empresa_id ];

                                // Ejecutar la consulta
                                $resultado = $mysql->consulta($query, $params);

                                // Verificar si hay resultados
                                if ($resultado['numFilas'] > 0) {
                                    foreach ($resultado['resultado'] as $row_protocolo) {
                                        // Sanitizar y asignar variables
                                        $usuario_idx = sanitizarValor($row_protocolo['usuario_idx']);
                                        $nombrex = sanitizarValor($row_protocolo['nombrex']);
                                        $usuariox = sanitizarValor($row_protocolo['usuariox']);
                                        $funcionx = sanitizarValor($row_protocolo['funcionx']);
                                        $observaciones = sanitizarValor($row_protocolo['observaciones']);
                                        $estatusx = sanitizarValor($row_protocolo['estatusx']);
                                        $telefono = limpiarEntrada($row_protocolo['telefono'] ?? '', 'telefono');

                                        // Validar número de teléfono
                                        $clase = (preg_match('/^\+?\d{10,15}$/', $telefono)) ? "success" : "danger";

                                        // Asignar clase según estatus
                                        switch ($estatusx) {
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
                                            default:
                                                $clasex = "";
                                                break;
                                        }

                                        // Preparar mensaje y URL de WhatsApp
                                        $whatsapp_message = 'Estimado(a) Dr. ' . $nombrex . ', estamos a su disposición.';
                                        $whatsapp_url = 'https://api.whatsapp.com/send?phone=52' . $telefono . '&text=' . urlencode($whatsapp_message);
                                ?>
                                        <!-- Fila de datos de cada médico -->
                                        <tr>
                                            <td style="color: black; text-align: center;"><?php echo $usuario_idx; ?></td>
                                            <td><?php echo $nombrex; ?></td>
                                            <td><?php echo $usuariox; ?></td>
                                            <td style="text-align: center;" class="<?php echo $clase; ?>">
                                                <?php echo sanitizarValor($telefono); ?>
                                                <?php if ($clase == "success"): ?>
                                                    <br>
                                                    <a class="btn bg-teal waves-effect" target="_blank" href="<?php echo sanitizarValor($whatsapp_url); ?>">
                                                        <img align="left" border="0" src="<?php echo htmlspecialchars($ruta . 'images/WhatsApp.png', ENT_QUOTES, 'UTF-8'); ?>" style="width: 25px;">
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                            <td style="text-align: center;" class="<?php echo $clasex; ?>"><?php echo $estatusx; ?></td>
                                            <td style="text-align: center;">
                                                <div style="width: 95%;" class="row">
                                                    <div class="col-md-6">
                                                        <a class="btn btn-info btn-sm waves-effect" href="<?php // echo htmlspecialchars($ruta . 'crm/info_usuario.php?usuario_idx=' . $usuario_idx, ENT_QUOTES, 'UTF-8'); ?>">
                                                            <i class="material-icons">assignment</i> <b>Transferir</b>
                                                        </a>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <a class="btn btn-danger btn-sm waves-effect" href="<?php // echo htmlspecialchars($ruta . 'crm/info_usuario.php?usuario_idx=' . $usuario_idx, ENT_QUOTES, 'UTF-8'); ?>">
                                                            <i class="material-icons">assignment</i> <b>Descartar</b>
                                                        </a>
                                                    </div>
                                                </div>
                                                
                                            </td>
                                        </tr>
                                <?php
                                    }
                                } else {
                                    // No hay resultados
                                    echo '<tr><td colspan="7" style="text-align: center;">No se encontraron registros.</td></tr>';
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ... Puedes agregar más contenido aquí ... -->

    </div>
</section>

<?php 
// Incluir las secciones de pie de página y scripts adicionales
include($ruta . 'footer1.php'); 
?>

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
include($ruta . 'footer2.php'); 
?>
