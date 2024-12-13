<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener usuario por ID
    $db = new Database();
    $conn = $db->connect();
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        die("Usuario no encontrado");
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $fecha_ingreso = $_POST['fecha_ingreso'];
    $activo = $_POST['activo'];
    $password = $_POST['password']; // Captura de la nueva contraseña

    $db = new Database();
    $conn = $db->connect();

    try {
        // Si se ha ingresado una nueva contraseña, la ciframos
        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE usuarios SET nombre = :nombre, correo = :correo, fecha_ingreso = :fecha_ingreso, activo = :activo, password = :password WHERE id = :id");
            $stmt->bindParam(':password', $hashedPassword); // Insertamos la contraseña cifrada
        } else {
            // Si no se ha ingresado una nueva contraseña, simplemente actualizamos los demás campos
            $stmt = $conn->prepare("UPDATE usuarios SET nombre = :nombre, correo = :correo, fecha_ingreso = :fecha_ingreso, activo = :activo WHERE id = :id");
        }

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':fecha_ingreso', $fecha_ingreso);
        $stmt->bindParam(':activo', $activo);
        $stmt->execute();

        header("Location: modulousuario.php");
        exit();
    } catch (PDOException $e) {
        die("Error al actualizar usuario: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 0;
        }
        h1 {
            color: #333;
            text-align: center;
            padding: 20px;
            background-color: #ff6700;
            color: white;
        }
        form {
            width: 50%;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            font-size: 14px;
            margin-bottom: 8px;
            color: #333;
        }
        input[type="text"],
        input[type="email"],
        input[type="date"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }
        button {
            padding: 10px 20px;
            background-color: #ff6700;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #e65c00;
        }
    </style>
</head>
<body>
    <h1>Editar Usuario</h1>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>

        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" value="<?php echo htmlspecialchars($usuario['correo']); ?>" required>

        <label for="fecha_ingreso">Fecha de Ingreso:</label>
        <input type="date" id="fecha_ingreso" name="fecha_ingreso" value="<?php echo $usuario['fecha_ingreso']; ?>" required>

        <label for="activo">Estado:</label>
        <select id="activo" name="activo" required>
            <option value="1" <?php echo $usuario['activo'] == 1 ? 'selected' : ''; ?>>Activo</option>
            <option value="0" <?php echo $usuario['activo'] == 0 ? 'selected' : ''; ?>>Inactivo</option>
        </select>

        <label for="password">Nueva Contraseña (Dejar en blanco si no desea cambiarla):</label>
        <input type="password" id="password" name="password" placeholder="Ingrese nueva contraseña">

        <button type="submit">Actualizar Usuario</button>
    </form>
</body>
</html>
