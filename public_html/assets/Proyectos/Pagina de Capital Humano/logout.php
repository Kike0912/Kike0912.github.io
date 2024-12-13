<?php
// Iniciar la sesión
session_start();

// Destruir todas las sesiones
session_unset(); // Eliminar todas las variables de sesión
session_destroy(); // Destruir la sesión actual

// Redirigir al login
header("Location: login.php");
exit();
?>
