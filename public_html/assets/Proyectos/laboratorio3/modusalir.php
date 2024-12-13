
<?php
session_start();  // Asegúrate de que se llama a session_start() al inicio

// Habilitar la visualización de todos los errores
error_reporting(E_ALL); // Muestra todos los errores, advertencias y notificaciones.
ini_set('display_errors', 1); // Muestra los errores directamente en la pantalla.



// Evitar que la página se almacene en caché
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

// Destruir todas las variables de sesión y la sesión
session_unset();  // Elimina todas las variables de sesión
session_destroy();  // Destruye la sesión

// Redirigir al usuario a la página de login
header("Location: login.php");
exit();  // Termina la ejecución del script
?>
