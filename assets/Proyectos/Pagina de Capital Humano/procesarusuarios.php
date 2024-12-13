<?php
require_once 'db.php';

class UsuarioHandler
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function agregarUsuario($data)
    {
        $conn = $this->db->connect();

        $nombre = $data['nombre'];
        $correo = $data['correo'];
        $contrasena = password_hash($data['contrasena'], PASSWORD_BCRYPT);
        $fecha_ingreso = $data['fecha_ingreso'];
        $activo = 1; // Por defecto, los usuarios estarán activos

        try {
            $stmt = $conn->prepare("INSERT INTO usuarios (nombre, correo, contrasena, fecha_ingreso, activo) 
                                    VALUES (:nombre, :correo, :contrasena, :fecha_ingreso, :activo)");
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':correo', $correo);
            $stmt->bindParam(':contrasena', $contrasena);
            $stmt->bindParam(':fecha_ingreso', $fecha_ingreso);
            $stmt->bindParam(':activo', $activo);

            $stmt->execute();
            header("Location: modulousuario.php");
            exit();
        } catch (PDOException $e) {
            die("Error al agregar usuario: " . $e->getMessage());
        }
    }
}

// Manejo de solicitudes
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuarioHandler = new UsuarioHandler();
    $usuarioHandler->agregarUsuario($_POST);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Usuario</title>
</head>
<body>
    <h1>Agregar Usuario</h1>

    <form method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br>

        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" required><br>

        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required><br>

        <label for="fecha_ingreso">Fecha de Ingreso:</label>
        <input type="date" id="fecha_ingreso" name="fecha_ingreso" required><br>

        <button type="submit">Agregar Usuario</button>
    </form>
</body>
</html>
