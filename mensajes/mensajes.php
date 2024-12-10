<?php
//mensajes.php
$ruta = "../";
$titulo = "Menú TMS";

// Se asume que en header1.php se definen o se obtienen las variables $empresa_id, $usuario_id, $ubicacion_url, $emp_nombre, etc.
include($ruta.'header1.php');
?>

    <!-- Estilos CSS requeridos -->
    <link href="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
    <link href="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />
    <link href="<?php echo $ruta; ?>plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
    <link href="<?php echo $ruta; ?>plugins/waitme/waitMe.css" rel="stylesheet" />
    <link href="<?php echo $ruta; ?>plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

<?php
include($ruta.'header2.php'); 
?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>MENSAJES</h2>
            <?php echo $ubicacion_url."<br>"; ?>
        </div>
        <!-- Formulario para enviar avisos -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Enviar Aviso</h2>
                    </div>
                    <div class="body">
                        <form id="sendNoticeForm">
                            <div class="form-group">
                                <label for="empresa_id">ID de la Empresa</label>
                                <p><b><?php echo $empresa_id." - ".$emp_nombre; ?></b></p>
                                <input type="hidden" name="empresa_id" id="empresa_id" class="form-control" value="<?php echo $empresa_id; ?>" required>
                            </div>
                            <?php
                                // Se asume que $mysql es la instancia de Mysql ya creada y conectada en header1.php
                                $queryAdmin = "SELECT usuario_id, nombre 
                                               FROM admin 
                                               WHERE empresa_id = ? 
                                               ORDER BY nombre ASC";
                                $paramsAdmin = [$empresa_id];
                                $resultAdmin = $mysql->consulta($queryAdmin, $paramsAdmin);
                            ?>
                            <div class="form-group form-float">
                                <label for="usuario_id_input">Usuario (opcional, dejar vacío para todos)</label>
                                <select name="usuario_id" id="usuario_id_input" class="form-control">
                                    <option value="">Todos</option>
                                    <?php
                                    if ($resultAdmin['numFilas'] > 0) {
                                        foreach ($resultAdmin['resultado'] as $adminUser) {
                                            // Ajuste de codificación si es necesario
                                            if (mb_check_encoding($adminUser['nombre'], 'UTF-8')) {
                                                $nombre = mb_convert_encoding($adminUser['nombre'], 'ISO-8859-1', 'UTF-8');
                                            } else {
                                                $nombre = $adminUser['nombre'];
                                            }
                                            echo '<option value="' . $adminUser['usuario_id'] . '">' . $nombre . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <label for="message">Mensaje</label>
                                    <textarea name="message" id="message" class="form-control" required></textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Enviar Aviso</button>
                        </form>
                        <div id="sendNoticeResult"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Tabla para mostrar avisos -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Avisos Recientes</h2>
                    </div>
                    <div class="body">
                        <table class="table table-striped" id="noticesTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Usuario ID</th>
                                    <th>Nombre</th>
                                    <th>Mensaje</th>
                                    <th>Fecha</th>
                                    <th>Leído</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Filas generadas vía AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</section>

<script>
// usuario_id del usuario actual
var currentUserId = <?php echo $usuario_id; ?>;

$(document).ready(function() {
    loadNotices();

    $('#sendNoticeForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: 'envia_noticias.php',
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                $('#sendNoticeResult').text(response.message);
                if (response.success) {
                    $('#usuario_id_input').val('');
                    $('#message').val('');
                    loadNotices();
                }
            },
            error: function() {
                $('#sendNoticeResult').text('Error al enviar el aviso.');
            }
        });
    });
});

function loadNotices() {
    var empresa_id = $('#empresa_id').val();
    var usuario_id = currentUserId;
    
    $.ajax({
        url: 'optiene_noticias.php',
        method: 'GET',
        data: { empresa_id: empresa_id, usuario_id: usuario_id },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                var tbody = $('#noticesTable tbody');
                tbody.empty();
                
                response.data.forEach(function(notice) {
                    var isRead = (notice.is_read == 1);
                    var leidoTexto = isRead ? 'Sí' : 'No';
                    var usuarioAsignado = (notice.usuario_id === null) ? 'Todos' : notice.usuario_id;
                    var nombreUsuario = (notice.nombre_usuario === null) ? 'Todos' : notice.nombre_usuario;

                    var belongsToUser = (notice.usuario_id === null || notice.usuario_id == currentUserId);
                    var actionBtn = '';
                    if (!isRead && belongsToUser) {
                        actionBtn = '<button class="btn btn-sm btn-success" onclick="markAsRead('+notice.id+')">Marcar como leído</button>';
                    }

                    var row = '<tr>' +
                              '<td>' + notice.id + '</td>' +
                              '<td>' + usuarioAsignado + '</td>' +
                              '<td>' + nombreUsuario + '</td>' +
                              '<td>' + notice.message + '</td>' +
                              '<td>' + notice.created_at + '</td>' +
                              '<td>' + leidoTexto + '</td>' +
                              '<td>' + actionBtn + '</td>' +
                              '</tr>';
                    tbody.append(row);
                });
            } else {
                console.log(response.message);
            }
        },
        error: function() {
            console.log('Error al cargar avisos.');
        }
    });
}

function markAsRead(notice_id) {
    $.ajax({
        url: 'marca_noticias.php',
        method: 'POST',
        data: { usuario_id: currentUserId, notice_id: notice_id },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                loadNotices();
            } else {
                alert(response.message);
            }
        },
        error: function() {
            alert('Error al marcar el aviso como leído.');
        }
    });
}
</script> 

<?php 
include($ruta.'footer1.php'); 
?>

    <script src="<?php echo $ruta; ?>plugins/momentjs/moment.js"></script>
    <script src="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    <script src="<?php echo $ruta; ?>plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="<?php echo $ruta; ?>plugins/node-waves/waves.js"></script>
    <script src="<?php echo $ruta; ?>plugins/autosize/autosize.js"></script>
    <script src="<?php echo $ruta; ?>plugins/momentjs/moment.js"></script>

<?php 
include($ruta.'footer2.php'); 
?>
