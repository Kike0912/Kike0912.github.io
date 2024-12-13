<?php
session_start();
include 'db.php'; // Incluir la conexión a la base de datos

// Verificar si se enviaron los datos
if (isset($_POST['correoRegistro']) && isset($_POST['nombreCompletoRegistro']) && isset($_POST['nombreUsuarioRegistro']) && isset($_POST['contrasenaRegistro'])) {
    $correo = $_POST['correoRegistro'];
    $nombreCompleto = $_POST['nombreCompletoRegistro'];
    $nombreUsuario = $_POST['nombreUsuarioRegistro'];
    $contrasena = $_POST['contrasenaRegistro'];
    
    // Sanitizar las entradas para evitar inyecciones SQL
    $correo = $conexion->real_escape_string($correo);
    $nombreCompleto = $conexion->real_escape_string($nombreCompleto);
    $nombreUsuario = $conexion->real_escape_string($nombreUsuario);
    
    // Encriptar la contraseña antes de guardarla en la base de datos
    $contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);
    
    // Insertar el nuevo usuario en la base de datos
    $sql = "INSERT INTO usuarios (email, nombre_completo, usuario, contrasena)
            VALUES ('$correo', '$nombreCompleto', '$nombreUsuario', '$contrasenaHash')";
    
    if ($conexion->query($sql) === TRUE) {
        echo "Usuario registrado exitosamente.";
        header("Location: lobi.php"); // Redirigir a lobi.php después de un registro exitoso
        exit();
    } else {
        echo "Error al registrar el usuario: " . $conexion->error;
    }
}
?>
