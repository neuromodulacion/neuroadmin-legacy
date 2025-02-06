<?php
session_start();

if (isset($_POST['timezone'])) {
    $_SESSION['timezone'] = $_POST['timezone'];
    echo "Timezone guardado: " . $_SESSION['timezone'];
} else {
    echo "No se recibió la zona horaria.";
}
?>
