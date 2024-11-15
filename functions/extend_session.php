<?php
// Inicia la sesión si no se ha iniciado ya
session_start();

// Verifica si la sesión tiene un tiempo de inicio registrado
if (isset($_SESSION['start_time'])) {
    // Si existe, actualiza el tiempo de inicio a la hora actual, extendiendo así la sesión
    $_SESSION['start_time'] = time();
    // Muestra un mensaje indicando que la sesión ha sido extendida
    echo 'Sesión extendida';
} else {
    // Si no hay una sesión activa, muestra un mensaje de error
    echo 'Error: No hay sesión activa';
}
?>
<!--
Explicación general:

session_start(): Asegura que la sesión está iniciada, lo que permite acceder y modificar las variables de sesión.

Verificación de la variable de sesión:

isset($_SESSION['start_time']): Comprueba si la variable start_time existe en la sesión actual. Esta variable normalmente se usa para registrar el momento en que la sesión comenzó o fue actualizada por última vez.

Extensión de la sesión:

Si la variable start_time existe, se actualiza con el tiempo actual (time()), lo que efectivamente extiende la duración de la sesión.
Se devuelve un mensaje indicando que la sesión ha sido extendida.

Manejo de errores:

Si no se encuentra la variable start_time, significa que no hay una sesión activa o que no se ha configurado adecuadamente, y se muestra un mensaje de error.
-->