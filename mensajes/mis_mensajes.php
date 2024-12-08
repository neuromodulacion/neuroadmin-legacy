<?php
//mensajes_usuario_especifico.php
// Definir la ruta base para las inclusiones de archivos
$ruta = "../";
$titulo = "Mis Mensajes";

// Incluir la primera parte del header que contiene configuraciones iniciales
include($ruta.'header1.php');

// Incluir archivos CSS adicionales necesarios para el funcionamiento de la página
?>
    <!-- Estilos para la tabla de datos de JQuery DataTable -->
    <link href="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
    
    <!-- Estilos para el selector de fecha y hora con Bootstrap Material -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

    <!-- Estilos para el selector de fecha de Bootstrap -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />

    <!-- Estilos para el plugin "Wait Me" que muestra un indicador de carga -->
    <link href="<?php echo $ruta; ?>plugins/waitme/waitMe.css" rel="stylesheet" />

    <!-- Estilos para el select de Bootstrap -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />   

<?php  
// Incluir la segunda parte del header que contiene la barra de navegación y el menú
include($ruta.'header2.php'); ?>

<?php
// Variables de ejemplo (reemplazar con variables de sesión o lo que uses)
$empresa_id = 1; 
$usuario_id = 5; 
?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>MIS MENSAJES</h2>
            <?php echo $ubicacion_url."<br>"; ?>
        </div>
        
        <!-- Tabla para mostrar avisos específicos del usuario -->
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
// usuario_id actual (ajusta según tu lógica)
var currentUserId = <?php echo $usuario_id; ?>;
var currentEmpresaId = <?php echo $empresa_id; ?>;

$(document).ready(function() {
    loadNotices();
});

function loadNotices() {
    var empresa_id = currentEmpresaId;
    var usuario_id = currentUserId;
    
    $.ajax({
        url: 'optiene_noticias.php', // Ajustar el nombre del archivo si difiere
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
        url: 'marca_noticias.php', // Ajustar el nombre del archivo si difiere
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
// Incluir la primera parte del footer que contiene scripts y configuraciones iniciales del pie de página
include($ruta.'footer1.php'); 
?>

    <!-- Scripts adicionales necesarios para la funcionalidad de la página -->
    <script src="<?php echo $ruta; ?>plugins/momentjs/moment.js"></script>
    <script src="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    <script src="<?php echo $ruta; ?>plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="<?php echo $ruta; ?>plugins/node-waves/waves.js"></script>
    <script src="<?php echo $ruta; ?>plugins/autosize/autosize.js"></script>
    <script src="<?php echo $ruta; ?>plugins/momentjs/moment.js"></script>

<?php 
// Incluir la segunda parte del footer que finaliza la estructura del pie de página
include($ruta.'footer2.php'); 
?>
