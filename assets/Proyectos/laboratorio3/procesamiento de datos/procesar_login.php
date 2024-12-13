<?php
session_start();
include 'db.php'; // Incluir la conexión a la base de datos

// Verificar si se enviaron los datos
if (isset($_POST['usuarioInicio']) && isset($_POST['contrasenaInicio'])) {
    $usuario = $_POST['usuarioInicio'];
    $contrasena = $_POST['contrasenaInicio'];

    // Sanitizar las entradas para evitar inyecciones SQL
    $usuario = $conexion->real_escape_string($usuario);

    // Verificar si el usuario existe en la base de datos
    $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {
        // Usuario encontrado, obtener datos
        $row = $resultado->fetch_assoc();
        $contrasenaHash = $row['contrasena']; // Obtener la contraseña cifrada de la base de datos

        // Verificar si la contraseña ingresada coincide con la cifrada
        if (password_verify($contrasena, $contrasenaHash)) {
            // Contraseña correcta, iniciar sesión
            $_SESSION['usuario'] = $usuario;
            // Redirigir a lobi.php después de iniciar sesión correctamente
            header("Location: lobi.php");
            exit(); // Asegurarse de que el script termine después de la redirección
        } else {
            // Contraseña incorrecta
            echo "Usuario o contraseña incorrectos.";
        }
    } else {
        // Usuario no encontrado
        echo "Usuario o contraseña incorrectos.";
    }
}
?>
