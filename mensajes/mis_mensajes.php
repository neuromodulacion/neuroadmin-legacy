<?php
// mis_mensajes.php
$ruta = "../";
$titulo = "Mis Mensajes";

include($ruta.'header1.php'); 
include($ruta.'header2.php'); 

// Asumiendo que las variables $usuario_id, $empresa_id ya provienen de la sesión o de los archivos incluidos.
?>

<!-- Estilos CSS requeridos -->
<link href="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
<link href="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />
<link href="<?php echo $ruta; ?>plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
<link href="<?php echo $ruta; ?>plugins/waitme/waitMe.css" rel="stylesheet" />
<link href="<?php echo $ruta; ?>plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>MIS MENSAJES</h2>
            <?php echo $ubicacion_url."<br>"; ?>
        </div>
        
        <!-- Tabla para mostrar avisos específicos del usuario y generales -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Mis Avisos</h2>
                    </div>
                    <div class="body">
                        <table class="table table-striped" id="noticesTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
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
var currentUserId = <?php echo $usuario_id; ?>;
var currentEmpresaId = <?php echo $empresa_id; ?>;

$(document).ready(function() {
    loadNotices();
});

function loadNotices() {
    $.ajax({
        url: 'optiene_noticias.php',
        method: 'GET',
        data: { empresa_id: currentEmpresaId, usuario_id: currentUserId },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                var tbody = $('#noticesTable tbody');
                tbody.empty();
                response.data.forEach(function(notice) {
                    var isRead = (notice.is_read == 1);
                    var leidoTexto = isRead ? 'Sí' : 'No';
                    var actionBtn = '';
                    
                    if (!isRead) {
                        actionBtn = '<button class="btn btn-sm btn-success" onclick="markAsRead('+notice.id+')">Marcar como leído</button>';
                    }
                    
                    var row = '<tr>' +
                              '<td>' + notice.id + '</td>' +
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
