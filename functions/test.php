<?php
$ruta = "../";
session_start();

// Duración de la sesión en segundos (por ejemplo, 90 minutos)
$session_duration = 5 * 60;

// Configurar el tiempo máximo de vida de la sesión
ini_set('session.gc_maxlifetime', $session_duration);
ini_set('session.cookie_lifetime', $session_duration);

// Inicializar o reiniciar la sesión
if (!isset($_SESSION['start_time'])) {
    $_SESSION['start_time'] = time();
}

// Incluir tus funciones de MySQL
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="<?php echo $ruta; ?>images/logo_aldana_tc.png" type="image/png">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


</head>
<body>
    <div class="container">
        <!-- Contenido de tu aplicación -->
    </div>

    <!-- Modal -->
    <div class="modal fade" id="sessionModal" tabindex="-1" role="dialog" aria-labelledby="sessionModalLabel" 
    aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sessionModalLabel">Sesión por expirar</h5>
                </div>
                <div class="modal-body">
                    Tu sesión está a punto de expirar. ¿Deseas continuar?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="continueSession">Continuar sesión</button>
                    <button type="button" class="btn btn-danger" id="endSession">Terminar sesión</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Alerta sonora -->
    <audio id="alertSound" src="<?php echo $ruta; ?>functions/Public-announcement-bell-sound-effect.mp3" preload="auto"></audio>

    <script>
	    $(document).ready(function() {
	        var sessionDuration = <?php echo $session_duration; ?>; // 90 minutos en segundos
	        var alertTime = sessionDuration - 60; // 1 minuto antes de expirar
	
	        setTimeout(function() {
	            console.log("Mostrando modal de sesión por expirar");
	            // Mostrar el modal
	            $('#sessionModal').modal('show');
	            console.log("Reproduciendo sonido de alerta");
	            // Reproducir sonido de alerta
	            var alertSound = $('#alertSound')[0];
	            alertSound.play().then(function() {
	                console.log("El sonido de alerta está reproduciéndose");
	            }).catch(function(error) {
	                console.error("Error al reproducir el sonido de alerta:", error);
	            });
	        }, alertTime * 1000);
	
	        $('#continueSession').click(function() {
	            // Llamada AJAX para extender la sesión
	            $.ajax({
	                url: '<?php echo $ruta; ?>functions/extend_session.php', // Crea un archivo PHP para extender la sesión
	                success: function(response) {
	                    location.reload(); // Recargar la página para reiniciar el temporizador
	                }
	            });
	        });
	
	        $('#endSession').click(function() {
	            // Redirigir al inicio de sesión o página de inicio
	            window.location.href = '<?php echo $ruta; ?>cerrar_sesion.php';
	        });
	
	        setTimeout(function() {
	            // Redirigir al inicio de sesión si no hay respuesta después de 1 minuto
	            window.location.href = '<?php echo $ruta; ?>cerrar_sesion.php';
	        }, sessionDuration * 1000);
	        
	        // Función para comprobar el estado de la sesión cada minuto
	        function comprobarEstadoSesion() {
	            console.log("Comprobando el estado de la sesión");
	            $.ajax({
	                url: '<?php echo $ruta; ?>functions/valida_uso.php',
	                method: 'POST',
	                data: { usuario_id: 5 },
	                success: function(response) {
	                	//alert(response);
	                    console.log("Respuesta del servidor:", response);
	                    if (response === 'Caduco') {
	                        console.log("La sesión ha caducado. Redirigiendo...");
	                        window.location.href = '<?php echo $ruta; ?>cerrar_sesion.php';
	                    } else {
	                        console.log("La sesión está activa.");
	                    }
	                },
	                error: function(xhr, status, error) {
	                    console.error("Error en la solicitud AJAX:", status, error);
	                }
	            });
	        }
	
	        // Comprobar la caducidad cada minuto
	        setInterval(comprobarEstadoSesion, 60000);        
    });
    </script>
</body>
</html>
