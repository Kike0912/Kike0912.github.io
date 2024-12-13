<?php
// Iniciar la sesión
session_start();

// Destruir todas las sesiones
session_unset(); // Destruye las variables de la sesión actual
session_destroy(); // Destruye la sesión

// Redirigir al login
header("Location: login.php"); // Cambia "login.php" si el archivo del formulario tiene otro nombre
exit();
?>
