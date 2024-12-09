<?php //mensajes.php
//mensajes.php
// Definir la ruta base para las inclusiones de archivos
$ruta = "../";
$titulo = "Menú TMS";

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
// Ejemplo de integración (adaptar rutas y variables según tu entorno)

// Variables de ejemplo (reemplazar con variables de sesión o lo que uses)

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
                                // Antes de la sección HTML, ejecutas la consulta para obtener los usuarios:
                                $queryAdmin = "SELECT usuario_id, nombre 
                                            FROM admin 
                                            WHERE empresa_id = ? 
                                            ORDER BY nombre ASC";
                                $paramsAdmin = [$empresa_id];
                                $resultAdmin = $mysql->consulta($queryAdmin, $paramsAdmin);

                                // Ahora en el HTML del formulario:
                            ?>
                            <div class="form-group form-float">
                                <label for="usuario_id_input">Usuario (opcional, dejar vacío para todos)</label>
                                <select name="usuario_id" id="usuario_id_input" class="form-control">
                                    <option value="">Todos</option>
                                    <?php
                                    if ($resultAdmin['numFilas'] > 0) {
                                        foreach ($resultAdmin['resultado'] as $adminUser) {

                                           /* if (!mb_check_encoding($adminUser['nombre'], 'UTF-8')) {
                                                $nombre = mb_convert_encoding($adminUser['nombre'], 'UTF-8', 'ISO-8859-1');
                                            } else {
                                                $nombre = $adminUser['nombre'];
                                            } */
                                            

                                            if (mb_check_encoding($adminUser['nombre'], 'UTF-8')) {
                                                $nombre = mb_convert_encoding($adminUser['nombre'], 'ISO-8859-1', 'UTF-8');
                                            } else {
                                                $nombre = $adminUser['nombre']; // Ya está en ISO-8859-1 o es inválida
                                            }
                                            
                                            

                                            // El valor será el usuario_id y el texto será el nombre del usuario
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
// usuario_id del usuario actual (ajusta según tu lógica)
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
                    
                    // Si usuario_id es NULL, es para todos
                    var usuarioAsignado = (notice.usuario_id === null) ? 'Todos' : notice.usuario_id;
                    var nombreUsuario = (notice.nombre === null) ? 'Todos' : notice.nombre;

                    // Determinar si se muestra el botón de "Marcar como leído"
                    // Debe ser: no leído y (mensaje para todos o mensaje del usuario actual)
                    var belongsToUser = (notice.usuario_id === null || notice.usuario_id == usuario_id);
                    var actionBtn = '';
                    if (!isRead && belongsToUser) {
                        actionBtn = '<button class="btn btn-sm btn-success" onclick="markAsRead('+notice.id+')">Marcar como leído</button>';
                    }

                    var row = '<tr>' +
                              '<td>' + notice.id + '</td>' +
                              '<td>' + notice.usuario_id + '</td>' +
                              '<td>' + nombre_usuario + '</td>' +
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
// Incluir la primera parte del footer que contiene scripts y configuraciones iniciales del pie de página
include($ruta.'footer1.php'); 
?>

    <!-- Scripts adicionales necesarios para la funcionalidad de la página -->

    <!-- Plugin Moment para manejar fechas y horas -->
    <script src="<?php echo $ruta; ?>plugins/momentjs/moment.js"></script>

    <!-- Plugin para el selector de fecha y hora con Bootstrap Material -->
    <script src="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

    <!-- Plugin para el selector de fecha de Bootstrap -->
    <script src="<?php echo $ruta; ?>plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

    <!-- Plugin para efecto de ondas en los botones -->
    <script src="<?php echo $ruta; ?>plugins/node-waves/waves.js"></script>

    <!-- Plugin Autosize para ajustar automáticamente el tamaño de los campos de texto -->
    <script src="<?php echo $ruta; ?>plugins/autosize/autosize.js"></script>

    <!-- Repetición del plugin Moment para garantizar su disponibilidad -->
    <script src="<?php echo $ruta; ?>plugins/momentjs/moment.js"></script>

<?php 
// Incluir la segunda parte del footer que finaliza la estructura del pie de página
include($ruta.'footer2.php'); 
?>
