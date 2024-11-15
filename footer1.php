<!-- Modal -->
<!-- Definición del modal que aparece cuando la sesión está por expirar -->
<div class="modal fade" id="sessionModal" tabindex="-1" role="dialog" aria-labelledby="sessionModalLabel" 
    aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <!-- Contenedor del modal -->
    <div class="modal-dialog" role="document">
        <!-- Contenido del modal -->
        <div class="modal-content">
            <!-- Encabezado del modal -->
            <div class="modal-header">
                <h5 class="modal-title" id="sessionModalLabel">Sesión por expirar</h5>
            </div>
            <!-- Cuerpo del modal -->
            <div class="modal-body">
                Tu sesión está a punto de expirar. ¿Deseas continuar?
            </div>
            <!-- Pie del modal con botones -->
            <div class="modal-footer">
                <!-- Botón para continuar la sesión -->
                <button type="button" class="btn btn-success" id="continueSession">Continuar sesión</button>
                <!-- Botón para terminar la sesión -->
                <button type="button" class="btn btn-danger" id="endSession">Terminar sesión</button>
            </div>
        </div>
    </div>
</div>

<!-- Elemento de audio para reproducir un sonido de alerta cuando la sesión esté por expirar -->
<audio id="alertSound" src="<?php echo $ruta; ?>functions/Public-announcement-bell-sound-effect.mp3" preload="auto"></audio>

<script>
$(document).ready(function() {
    // Duración de la sesión en segundos
    var sessionDuration = <?php echo $session_duration; ?>; // 90 minutos en segundos
    // Tiempo en segundos antes de que la sesión expire para mostrar la alerta (1 minuto antes)
    var alertTime = sessionDuration - 60;

    // Temporizador para mostrar el modal y reproducir el sonido de alerta
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

    // Evento para el botón de "Continuar sesión"
    $('#continueSession').click(function() {
        // Llamada AJAX para extender la sesión
        $.ajax({
            url: '<?php echo $ruta; ?>functions/extend_session.php',
            success: function(response) {
                // Recargar la página para reiniciar el temporizador
                location.reload();
            }
        });
    });

    // Evento para el botón de "Terminar sesión"
    $('#endSession').click(function() {
        // Redirigir al inicio de sesión o página de cierre de sesión
        window.location.href = '<?php echo $ruta; ?>cerrar_sesion.php';
    });

    // Temporizador para redirigir al inicio de sesión si no hay respuesta después de que la sesión expire
    setTimeout(function() {
        window.location.href = '<?php echo $ruta; ?>cerrar_sesion.php';
    }, sessionDuration * 1000);

    // Función para comprobar el estado de la sesión cada minuto
    function comprobarEstadoSesion() {
        console.log("Comprobando el estado de la sesión");
        $.ajax({
            url: '<?php echo $ruta; ?>functions/valida_uso.php',
            method: 'POST',
            data: { usuario_id: <?php echo $_SESSION['usuario_id']; ?> },
            success: function(response) {
                console.log("Respuesta del servidor:", response);
                if (response === 'Caduco') {
                    console.log("La sesión ha caducado. Redirigiendo...");
                    // Redirigir al inicio de sesión si la sesión ha caducado
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

    // Comprobar la caducidad de la sesión cada minuto
    setInterval(comprobarEstadoSesion, 60000);          
});
</script>       

<!-- Inclusión de scripts para jQuery, Bootstrap y otros plugins -->
<!-- Jquery Core Js -->
<script src="<?php echo $ruta; ?>plugins/jquery/jquery.min.js"></script>

<!-- Bootstrap Core Js -->
<script src="<?php echo $ruta; ?>plugins/bootstrap/js/bootstrap.js"></script>

<!-- Select Plugin Js -->
<script src="<?php echo $ruta; ?>plugins/bootstrap-select/js/bootstrap-select.js"></script>

<!-- Slimscroll Plugin Js -->
<script src="<?php echo $ruta; ?>plugins/jquery-slimscroll/jquery.slimscroll.js"></script>


