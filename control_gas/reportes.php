<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

include 'conexion.php';

// Variables de sesión para pruebas
// if (!isset($_SESSION['usuario_id'])) {
    // $_SESSION['usuario_id'] = 5; // Reemplaza con un ID válido
// }
if (!isset($_SESSION['rol'])) {
    $_SESSION['funcion'] = 'SISTEMAS'; // O 'usuario' si no es administrador
}

$esAdmin = isset($_SESSION['funcion']) && $_SESSION['funcion'] == 'SISTEMAS';

// Obtener la lista de usuarios si es administrador
if ($esAdmin) {
    $sqlUsuarios = "SELECT usuario_id, nombre FROM admin";
    $resultUsuarios = $conn->query($sqlUsuarios);
    if (!$resultUsuarios) {
        die("Error al obtener usuarios: " . $conn->error);
    }
}

// Variables para almacenar los valores seleccionados previamente
$selectedMes = isset($_POST['mes']) ? $_POST['mes'] : '';
$selectedAno = isset($_POST['año']) ? $_POST['año'] : '';
$selectedUsuario = isset($_POST['usuario_id']) ? $_POST['usuario_id'] : '';

// Definir la ruta base para las inclusiones de archivos
$ruta = "../";

// Obtener la fecha actual en formato "YYYY-MM-DD"
$hoy = date("Y-m-d");

// Obtener la hora actual en formato "HH:MM:00"
$ahora = date("H:i:00"); 

// Obtener el año actual
$anio = date("Y");

// Obtener el mes actual en formato numérico "MM"
$mes_ahora = date("m");

// Definir el título de la página
$titulo = "Menú TMS";

// Incluir la primera parte del header que contiene configuraciones iniciales
include($ruta.'header1.php');
?>

<!-- Incluir la hoja de estilos de Leaflet en el header -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />

<!-- Estilos adicionales para la página de Registro de Kilometraje -->
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

<!-- Estilos personalizados para el mapa -->
<style>
    #map {
        height: 500px; /* Ajusta la altura según tus necesidades */
        width: 100%;
        margin-top: 20px;
    }
</style>

<?php  
// Incluir la segunda parte del header que contiene la barra de navegación y el menú
include($ruta.'header2.php'); 
?>

<!-- Inicio del contenido principal de la página -->
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Registro de Kilometraje</h2>
        </div>
        <!-- Contenido principal de la página -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Formulario de Kilometraje</h2>
                    </div>
                    <div class="body">
                        <!-- Formulario de selección de usuario, mes y año -->
                        <form method="POST" class="mb-4">
                            <div class="row">
                                <?php if ($esAdmin): ?>
                                    <div class="col-md-6">
                                        <label for="usuario_id" class="form-label">Seleccionar Usuario</label>
                                        <select name="usuario_id" class="form-control">
                                            <?php while ($usuario = $resultUsuarios->fetch_assoc()): ?>
                                                <option value="<?= $usuario['usuario_id'] ?>" <?= $selectedUsuario == $usuario['usuario_id'] ? 'selected' : '' ?>><?= $usuario['nombre'] ?></option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                <?php endif; ?>

                                <div class="col-md-3">
                                    <label for="mes" class="form-label">Mes</label>
                                    <select name="mes" class="form-control" required>
                                        <?php 
                                        $meses = [
                                            '01' => 'Enero',
                                            '02' => 'Febrero',
                                            '03' => 'Marzo',
                                            '04' => 'Abril',
                                            '05' => 'Mayo',
                                            '06' => 'Junio',
                                            '07' => 'Julio',
                                            '08' => 'Agosto',
                                            '09' => 'Septiembre',
                                            '10' => 'Octubre',
                                            '11' => 'Noviembre',
                                            '12' => 'Diciembre'
                                        ];

                                        foreach ($meses as $numeroMes => $nombreMes): ?>
                                            <option value="<?= $numeroMes ?>" <?= $selectedMes == $numeroMes ? 'selected' : '' ?>>
                                                <?= $nombreMes ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="año" class="form-label">Año</label>
                                    <select name="año" class="form-control" required>
                                        <?php for ($i = date('Y'); $i >= date('Y') - 10; $i--): ?>
                                            <option value="<?= $i ?>" <?= $selectedAno == $i ? 'selected' : '' ?>><?= $i ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">Consultar Kilometraje</button>
                            </div>
                        </form>

                        <?php
                        $ubicaciones = []; // Definimos un array vacío por defecto
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            if ($esAdmin && isset($_POST['usuario_id'])) {
                                $usuario_id = $_POST['usuario_id'];
                            } else {
                                $usuario_id = $_SESSION['usuario_id'];
                            }

                            $mes = $_POST['mes'];
                            $año = $_POST['año'];

                            $fecha_inicio = "$año-$mes-01";
                            $fecha_fin = date("Y-m-t", strtotime($fecha_inicio));

                            $sql = "SELECT fecha, kilometraje, latitud, longitud, foto FROM kilometraje_registros WHERE usuario_id = ? AND fecha BETWEEN ? AND ? ORDER BY fecha ASC";
                            $stmt = $conn->prepare($sql);

                            if (!$stmt) {
                                die("Error en la preparación de la consulta: " . $conn->error);
                            }

                            $stmt->bind_param("iss", $usuario_id, $fecha_inicio, $fecha_fin);

                            if (!$stmt->execute()) {
                                die("Error en la ejecución de la consulta: " . $stmt->error);
                            }

                            $stmt->bind_result($fecha, $kilometraje, $latitud, $longitud, $foto);
                            $kilometraje_total = 0;
                            $kilometraje_anterior = null;
                            $rows_count = 0;

                            echo '<table class="table table-responsive table-striped table-bordered">';
                            echo '<thead class="table-dark">';
                            echo '<tr>';
                            echo '<th scope="col">Fecha</th>';
                            echo '<th scope="col">Kilometraje</th>';
                            echo '<th scope="col">Latitud</th>';
                            echo '<th scope="col">Longitud</th>';
                            echo '<th scope="col">Acciones</th>'; // Nueva columna para el botón de imagen
                            echo '</tr>';
                            echo '</thead>';
                            echo '<tbody>';

                            while ($stmt->fetch()) {
                                $rows_count++;
                                echo '<tr>';
                                echo "<td>$fecha</td>";
                                echo "<td>$kilometraje</td>";
                                echo "<td>$latitud</td>";
                                echo "<td>$longitud</td>";
                                echo "<td><button class='btn btn-info' data-toggle='modal' data-target='#imageModal' data-img-url='uploads/$foto'>Ver Imagen</button></td>";
                                echo '</tr>';

                                if ($kilometraje_anterior !== null) {
                                    $kilometraje_total += $kilometraje - $kilometraje_anterior;
                                }
                                $kilometraje_anterior = $kilometraje;

                                if (!empty($latitud) && !empty($longitud)) {
                                    $ubicaciones[] = [
                                        'latitud' => $latitud,
                                        'longitud' => $longitud,
                                        'fecha' => $fecha
                                    ];
                                }
                            }

                            echo '</tbody>';
                            echo '</table>';

                            if ($rows_count == 0) {
                                echo '<div class="alert alert-warning">No se encontraron registros para los criterios seleccionados.</div>';
                            } else if ($kilometraje_total > 0) {
                                echo '<div class="alert alert-success mt-3">';
                                echo "Kilometraje total recorrido: $kilometraje_total km.";
                                echo '</div>';
                            }

                            $stmt->close();
                        }
                        ?>

                        <!-- Contenedor para el mapa -->
                        <div id="map"></div>
                        <br>
                        <hr>

                        <!-- Modal para mostrar la imagen -->
                        <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="imageModalLabel">Imagen del Registro</h4>
                                    </div>
                                    <div class="modal-body">
                                        <img id="modalImage" src="" alt="Imagen del Registro" class="img-responsive">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div> <!-- Fin de body -->
                </div> <!-- Fin de card -->
            </div> <!-- Fin de col -->
        </div> <!-- Fin de row -->
    </div> <!-- Fin de container-fluid -->
</section>

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
<script src="<?php echo $ruta; ?>plugins/waves/waves.js"></script>

<!-- Plugin Autosize para ajustar automáticamente el tamaño de los campos de texto -->
<script src="<?php echo $ruta; ?>plugins/autosize/autosize.js"></script>

<!-- Leaflet JS para el mapa -->
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

<!-- Inicializar el mapa si hay ubicaciones -->
<?php if (!empty($ubicaciones)): ?>
    <script>
        $(document).ready(function() {
            // Inicializar el mapa centrado en la primera ubicación
            var map = L.map('map').setView([<?= $ubicaciones[0]['latitud'] ?>, <?= $ubicaciones[0]['longitud'] ?>], 13);

            // Añadir el mapa de OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 18,
                attribution: '© OpenStreetMap'
            }).addTo(map);

            // Añadir marcadores para cada ubicación
            <?php foreach ($ubicaciones as $ubicacion): ?>
                L.marker([<?= $ubicacion['latitud'] ?>, <?= $ubicacion['longitud'] ?>]).addTo(map)
                    .bindPopup('Fecha: <?= $ubicacion['fecha'] ?>');
            <?php endforeach; ?>
        });
    </script>
<?php endif; ?>

<!-- Script para manejar el modal de la imagen -->
<script>
    $('#imageModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var imageUrl = button.data('img-url');
        var modalImage = $('#modalImage');
        modalImage.attr('src', imageUrl);
    });
</script>

<?php 
// Incluir la segunda parte del footer que finaliza la estructura del pie de página
include($ruta.'footer2.php'); 
?>
