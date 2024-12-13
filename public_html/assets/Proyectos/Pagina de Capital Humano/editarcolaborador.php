<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener usuario por ID
    $db = new Database();
    $conn = $db->connect();
    $stmt = $conn->prepare("SELECT * FROM colaboradores WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $colaborador = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$colaborador) {
        die("Colaborador no encontrado");
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $primer_nombre = $_POST['primer_nombre'];
    $segundo_nombre = $_POST['segundo_nombre'];
    $primer_apellido = $_POST['primer_apellido'];
    $segundo_apellido = $_POST['segundo_apellido'];
    $sexo = $_POST['sexo'];
    $identificacion = $_POST['identificacion'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $foto_perfil = $_FILES['foto_perfil'];
    $direccion = $_POST['direccion'];
    $correo_personal = $_POST['correo_personal'];
    $telefono = $_POST['telefono'];
    $celular = $_POST['celular'];
    $fecha_ingreso = $_POST['fecha_ingreso'];
    $activo = $_POST['activo'];

    $foto_perfil_url = $colaborador['foto_perfil']; // Usamos la foto existente si no se sube una nueva
    if ($foto_perfil['error'] == 0) {
        // Si se sube una nueva foto
        $foto_perfil_url = 'uploads/' . basename($foto_perfil['name']);
        move_uploaded_file($foto_perfil['tmp_name'], $foto_perfil_url);
    }

    $db = new Database();
    $conn = $db->connect();

    try {
        $stmt = $conn->prepare("UPDATE colaboradores SET 
            primer_nombre = :primer_nombre, 
            segundo_nombre = :segundo_nombre, 
            primer_apellido = :primer_apellido, 
            segundo_apellido = :segundo_apellido, 
            sexo = :sexo, 
            identificacion = :identificacion, 
            fecha_nacimiento = :fecha_nacimiento, 
            foto_perfil = :foto_perfil, 
            direccion = :direccion, 
            correo_personal = :correo_personal, 
            telefono = :telefono, 
            celular = :celular,
            fecha_ingreso = :fecha_ingreso,
            activo = :activo
            WHERE id = :id");

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':primer_nombre', $primer_nombre);
        $stmt->bindParam(':segundo_nombre', $segundo_nombre);
        $stmt->bindParam(':primer_apellido', $primer_apellido);
        $stmt->bindParam(':segundo_apellido', $segundo_apellido);
        $stmt->bindParam(':sexo', $sexo);
        $stmt->bindParam(':identificacion', $identificacion);
        $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);
        $stmt->bindParam(':foto_perfil', $foto_perfil_url);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':correo_personal', $correo_personal);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':celular', $celular);
        $stmt->bindParam(':fecha_ingreso', $fecha_ingreso);
        $stmt->bindParam(':activo', $activo);

        $stmt->execute();

        header("Location: modulocolaboradores.php");
        exit();
    } catch (PDOException $e) {
        die("Error al actualizar colaborador: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Colaborador</title>
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1 {
            color: #fff;
            background-color: #ff6700;
            text-align: center;
            padding: 20px;
            margin-bottom: 40px;
        }

        form {
            width: 60%;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            font-size: 16px;
            margin-bottom: 8px;
            color: #333;
        }

        input[type="text"],
        input[type="email"],
        input[type="date"],
        input[type="file"],
        input[type="text"],
        select,
        textarea {
            width: 100%;
            padding: 12px;
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
    <h1>Editar Colaborador</h1>
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $colaborador['id']; ?>">

        <label for="primer_nombre">Primer Nombre:</label>
        <input type="text" id="primer_nombre" name="primer_nombre" value="<?php echo htmlspecialchars($colaborador['primer_nombre']); ?>" required>

        <label for="segundo_nombre">Segundo Nombre:</label>
        <input type="text" id="segundo_nombre" name="segundo_nombre" value="<?php echo htmlspecialchars($colaborador['segundo_nombre']); ?>">

        <label for="primer_apellido">Primer Apellido:</label>
        <input type="text" id="primer_apellido" name="primer_apellido" value="<?php echo htmlspecialchars($colaborador['primer_apellido']); ?>" required>

        <label for="segundo_apellido">Segundo Apellido:</label>
        <input type="text" id="segundo_apellido" name="segundo_apellido" value="<?php echo htmlspecialchars($colaborador['segundo_apellido']); ?>">

        <label for="sexo">Sexo:</label>
        <select id="sexo" name="sexo" required>
            <option value="Masculino" <?php echo $colaborador['sexo'] == 'Masculino' ? 'selected' : ''; ?>>Masculino</option>
            <option value="Femenino" <?php echo $colaborador['sexo'] == 'Femenino' ? 'selected' : ''; ?>>Femenino</option>
        </select>

        <label for="identificacion">Identificación:</label>
        <input type="text" id="identificacion" name="identificacion" value="<?php echo htmlspecialchars($colaborador['identificacion']); ?>" required>

        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo $colaborador['fecha_nacimiento']; ?>" required>

        <label for="foto_perfil">Foto de Perfil:</label>
        <input type="file" id="foto_perfil" name="foto_perfil">
        <?php if (!empty($colaborador['foto_perfil'])): ?>
            <img src="<?php echo $colaborador['foto_perfil']; ?>" alt="Foto de perfil" width="50"><br>
        <?php endif; ?>

        <label for="direccion">Dirección:</label>
        <textarea id="direccion" name="direccion" required><?php echo htmlspecialchars($colaborador['direccion']); ?></textarea>

        <label for="correo_personal">Correo Personal:</label>
        <input type="email" id="correo_personal" name="correo_personal" value="<?php echo htmlspecialchars($colaborador['correo_personal']); ?>" required>

        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($colaborador['telefono']); ?>">

        <label for="celular">Celular:</label>
        <input type="text" id="celular" name="celular" value="<?php echo htmlspecialchars($colaborador['celular']); ?>">

        <label for="fecha_ingreso">Fecha de Ingreso:</label>
        <input type="date" id="fecha_ingreso" name="fecha_ingreso" value="<?php echo $colaborador['fecha_ingreso']; ?>" required>

        <label for="activo">Estado:</label>
        <select id="activo" name="activo" required>
            <option value="1" <?php echo $colaborador['activo'] == 1 ? 'selected' : ''; ?>>Activo</option>
            <option value="0" <?php echo $colaborador['activo'] == 0 ? 'selected' : ''; ?>>Inactivo</option>
        </select>

        <button type="submit">Actualizar Colaborador</button>
    </form>
</body>
</html>
