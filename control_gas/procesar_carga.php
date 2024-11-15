<?php
session_start();
include 'conexion.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    die("Debe iniciar sesión para realizar esta acción.");
}

$f_captura = date('Y-m-d H:i:s');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Kilometraje</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style='background-color: #BDBDBD'>
    <div class="container mt-5">
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $usuario_id = $_SESSION['usuario_id'];
            $kilometraje = $_POST['kilometraje'];

            // Validar el kilometraje
            if (!is_numeric($kilometraje) || $kilometraje < 0) {
                echo "<div class='alert alert-danger'>El kilometraje debe ser un número positivo.</div>";
                die();
            }

            // Manejo del archivo
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
                $foto = $_FILES['foto'];
                $extensionesPermitidas = ['jpg', 'jpeg', 'png'];
                $extension = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));

                if (!in_array($extension, $extensionesPermitidas)) {
                    echo "<div class='alert alert-danger'>Formato de imagen no permitido. Solo se permiten JPG y PNG.</div>";
                    die();
                }

                // Crear un nombre único para la foto
                $nombreFoto = uniqid('foto_') . '.' . $extension;
                $rutaDestino = 'uploads/' . $nombreFoto;

                // Mover el archivo a la carpeta de destino
                if (move_uploaded_file($foto['tmp_name'], $rutaDestino)) {
                    // Extraer metadatos EXIF
                    $exif = exif_read_data($rutaDestino, 0, true);

                    // Obtener la fecha de creación
                    if (isset($exif['EXIF']['DateTimeOriginal'])) {
                        $fecha = date('Y-m-d H:i:s', strtotime($exif['EXIF']['DateTimeOriginal']));
                    } else {
                        $fecha = date('Y-m-d H:i:s');
                    }

                    // Obtener coordenadas GPS
                    if (isset($exif['GPS']['GPSLatitude']) && isset($exif['GPS']['GPSLongitude'])) {
                        $latitud = getGPS($exif['GPS']['GPSLatitude'], $exif['GPS']['GPSLatitudeRef']);
                        $longitud = getGPS($exif['GPS']['GPSLongitude'], $exif['GPS']['GPSLongitudeRef']);
                    } else {
                        $latitud = null;
                        $longitud = null;
                    }

                    // Insertar en la base de datos
                    $sql = "INSERT INTO kilometraje_registros (usuario_id, kilometraje, fecha, latitud, longitud, foto , f_captura) VALUES (?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("idsddss", $usuario_id, $kilometraje, $fecha, $latitud, $longitud, $nombreFoto, $f_captura);

                    if ($stmt->execute()) {
                        echo "<div  class='jumbotron bg-light p-5 rounded'>";
                        echo "<h1 class='display-6'>Registro guardado exitosamente</h1>";
                        echo "<p class='lead'>El registro de kilometraje ha sido guardado correctamente.</p>";
                        echo "<hr class='my-4'>";
                        echo "<p>Fecha de registro: <strong>$fecha</strong></p>";
                        if ($latitud && $longitud) {
                            echo "<p>Ubicación GPS: Latitud: <strong>$latitud</strong>, Longitud: <strong>$longitud</strong></p>";
                        } else {
                            echo "<p>Ubicación GPS no disponible</p>";
                        }
                        echo "<p><a class='btn btn-primary' href='index.php'>Volver</a> <a class='btn btn-success' href='reportes.php'>Ver Reportes</a></p>";
                        echo "</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Error al guardar el registro: " . $stmt->error . "</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger'>Error al subir la foto.</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Error al subir el archivo: " . $_FILES['foto']['error'] . "</div>";
            }
        } else {
            echo "<div class='alert alert-warning'>Acceso no válido.</div>";
        }

        // Función para convertir coordenadas GPS
        function getGPS($exifCoord, $hemi) {
            $degrees = count($exifCoord) > 0 ? gps2Num($exifCoord[0]) : 0;
            $minutes = count($exifCoord) > 1 ? gps2Num($exifCoord[1]) : 0;
            $seconds = count($exifCoord) > 2 ? gps2Num($exifCoord[2]) : 0;

            $flip = ($hemi == 'W' or $hemi == 'S') ? -1 : 1;

            return $flip * ($degrees + ($minutes / 60) + ($seconds / 3600));
        }

        function gps2Num($coordPart) {
            $parts = explode('/', $coordPart);

            if (count($parts) <= 0)
                return 0;

            if (count($parts) == 1)
                return $parts[0];

            return floatval($parts[0]) / floatval($parts[1]);
        }
        ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
