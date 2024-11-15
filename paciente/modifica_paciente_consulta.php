<?php
// Incluye las funciones necesarias para el manejo de la base de datos y la API externa
include('../functions/funciones_mysql.php');
include('../api/funciones_api.php');

// Inicia la sesión para mantener las variables de sesión activas
session_start();

// Configura el nivel de reporte de errores para mostrar advertencias (E_WARNING)
error_reporting(7);

// Establece la codificación interna a UTF-8 para evitar problemas con caracteres especiales
iconv_set_encoding('internal_encoding', 'utf-8');

// Establece la cabecera HTTP para que el contenido se interprete como HTML con codificación UTF-8
header('Content-Type: text/html; charset=UTF-8');

// Configura la zona horaria predeterminada para la aplicación
date_default_timezone_set('America/Mazatlan');

// Establece la configuración regional para el manejo de fechas y tiempos en español (España)
setlocale(LC_TIME, 'es_ES.UTF-8');

// Guarda el tiempo actual en la sesión para su uso posterior
$_SESSION['time'] = mktime();

// Define la ruta base para las inclusiones de archivos
$ruta = "../";

// Extrae las variables de la sesión y las convierte en variables locales
extract($_SESSION);

// Extrae las variables enviadas por POST y las convierte en variables locales
extract($_POST);

// Variables para capturar la fecha y hora actuales
$f_captura = date("Y-m-d");
$h_captura = date("H:i:s");

// Si el tipo de operación es una consulta para obtener datos de un paciente específico
if ($tipo == 'consulta') {
    // Consulta SQL para obtener los datos del paciente basado en su ID de consulta
    $sql = "
    SELECT
        paciente_consultorio.paciente_id, 
        paciente_consultorio.paciente, 
        paciente_consultorio.apaterno, 
        paciente_consultorio.amaterno, 
        paciente_consultorio.celular, 
        paciente_consultorio.email,
        paciente_consultorio.id_bind
    FROM
        paciente_consultorio
    WHERE
        paciente_consultorio.paciente_cons_id = $paciente_cons_id";
        
    // Ejecuta la consulta y almacena el resultado
    $result_insert = ejecutar($sql);
    $row = mysqli_fetch_array($result_insert); // Obtiene los datos en un array asociativo
    extract($row); // Extrae los datos del array a variables individuales

    // Muestra un formulario pre-llenado con los datos del paciente
    ?>
    <div class="container" style="width: 95%;">
        <h2 class="mt-4">Registro de Paciente</h2>
        <form id="procesar_formulariox" method="POST">
            <div class="mb-3">
                <label for="paciente" class="form-label">Nombre del Paciente</label>
                <input type="text" class="form-control" id="pacientex" name="paciente" value="<?php echo isset($paciente) ? $paciente : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="apaterno" class="form-label">Apellido Paterno</label>
                <input type="text" class="form-control" id="apaternox" name="apaterno" value="<?php echo isset($apaterno) ? $apaterno : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="amaterno" class="form-label">Apellido Materno</label>
                <input type="text" class="form-control" id="amaternox" name="amaterno" value="<?php echo isset($amaterno) ? $amaterno : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="celular" class="form-label">Número de Celular</label>
                <input type="tel" class="form-control" id="celularx" name="celular" pattern="[0-9]{10}" placeholder="Ej: 5512345678" value="<?php echo isset($celular) ? $celular : ''; ?>">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="emailx" name="email" value="<?php echo isset($email) ? $email : ''; ?>" required>
            </div>
            <hr>
            <!-- Campos ocultos para enviar el ID del paciente y el tipo de operación -->
            <input type="hidden" id="paciente_cons_idx" name="paciente_cons_id" value="<?php echo isset($paciente_cons_id) ? $paciente_cons_id : ''; ?>"/>
            <input type="hidden" id="tipox" name="tipo" value="modifica"/>
            
            <button id="modal_boton" type="button" class="btn btn-primary">Registrar Paciente</button>
        </form>
        <script>
            // Maneja el evento de clic en el botón para registrar al paciente
            $('#modal_boton').click(function(){ 
                $('#contenedor').html(''); 
                
                // Imprime los valores antes de la serialización para depuración
                console.log("Nombre del Paciente:", $('#pacientex').val());
                console.log("Apellido Paterno:", $('#apaternox').val());
                console.log("Apellido Materno:", $('#amaternox').val());
                
                // Serializa el formulario en una cadena de consulta
                var datastring = $("#procesar_formulariox").serialize();
                alert(datastring);  // Para depuración, puedes eliminarlo después

                // Envío de los datos del formulario a través de AJAX
                $.ajax({
                    url: 'modifica_paciente_consulta.php',
                    type: 'POST',
                    data: datastring,
                    cache: false,
                    success:function(html){     
                        $('#contenedor').html(html); // Muestra el resultado en el contenedor
                    },
                    error: function(xhr, status, error) {
                        // Muestra un mensaje de error si la solicitud falla
                        $('#contenedor').html('<div class="alert alert-danger" role="alert">Hubo un error al procesar la solicitud.</div>');
                    }
                });
            });
        </script>
    </div>
    <?php
} else {
    // Si el tipo de operación es modificar un paciente existente, actualiza sus datos en la base de datos
    $update = "
    UPDATE paciente_consultorio
    SET
        paciente_consultorio.paciente = '$paciente',
        paciente_consultorio.apaterno = '$apaterno',
        paciente_consultorio.amaterno = '$amaterno',
        paciente_consultorio.celular = '$celular',
        paciente_consultorio.email = '$email'
    WHERE 
        paciente_consultorio.paciente_cons_id = $paciente_cons_id
    ";

    // Muestra la consulta de actualización para depuración
    echo "<hr>".$update."<hr>";

    // Ejecuta la consulta de actualización
    $result_insert = ejecutar($update);    
    
    // Llama a la función para modificar el cliente en el sistema externo "bind"
    modifica_cliente_bind_consulta($paciente_cons_id);            
} 
?>
