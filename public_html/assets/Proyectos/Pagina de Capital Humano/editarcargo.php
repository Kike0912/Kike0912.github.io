<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener el cargo por ID
    $db = new Database();
    $conn = $db->connect();
    $stmt = $conn->prepare("SELECT * FROM cargo_movimiento WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $cargo = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$cargo) {
        die("Cargo no encontrado");
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $colaborador_id = $_POST['colaborador_id'];
    $sueldo = $_POST['sueldo'];
    $departamento = $_POST['departamento'];
    $fecha_contrato = $_POST['fecha_contrato'];
    $estado = $_POST['estado'];
    $estatus = $_POST['estatus'];
    $ocupacion = $_POST['ocupacion'];
    $posicion = $_POST['posicion'];
    $tipo_colaborador = $_POST['tipo_colaborador'];

    $db = new Database();
    $conn = $db->connect();

    try {
        $stmt = $conn->prepare("UPDATE cargo_movimiento SET 
                                colaborador_id = :colaborador_id, 
                                sueldo = :sueldo, 
                                departamento = :departamento, 
                                fecha_contrato = :fecha_contrato, 
                                estado = :estado, 
                                estatus = :estatus, 
                                ocupacion = :ocupacion, 
                                posicion = :posicion, 
                                tipo_colaborador = :tipo_colaborador 
                                WHERE id = :id");

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':colaborador_id', $colaborador_id);
        $stmt->bindParam(':sueldo', $sueldo);
        $stmt->bindParam(':departamento', $departamento);
        $stmt->bindParam(':fecha_contrato', $fecha_contrato);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':estatus', $estatus);
        $stmt->bindParam(':ocupacion', $ocupacion);
        $stmt->bindParam(':posicion', $posicion);
        $stmt->bindParam(':tipo_colaborador', $tipo_colaborador);
        $stmt->execute();

        header("Location: modulocargo.php");
        exit();
    } catch (PDOException $e) {
        die("Error al editar cargo: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Cargo y Movimiento</title>
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
        input[type="number"],
        input[type="date"],
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
    <h1>Editar Cargo y Movimiento</h1>

    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $cargo['id']; ?>">

        <label for="colaborador_id">Colaborador:</label>
        <input type="text" name="colaborador_id" value="<?php echo $cargo['colaborador_id']; ?>"><br>

        <label for="sueldo">Sueldo:</label>
        <input type="number" name="sueldo" value="<?php echo $cargo['sueldo']; ?>" step="0.01"><br>

        <label for="departamento">Departamento:</label>
        <input type="text" name="departamento" value="<?php echo $cargo['departamento']; ?>"><br>

        <label for="fecha_contrato">Fecha de Contrato:</label>
        <input type="date" name="fecha_contrato" value="<?php echo $cargo['fecha_contrato']; ?>"><br>

        <label for="estado">Estado:</label>
        <select name="estado">
            <option value="1" <?php if ($cargo['estado'] == 1) echo 'selected'; ?>>Activo</option>
            <option value="0" <?php if ($cargo['estado'] == 0) echo 'selected'; ?>>Inactivo</option>
        </select><br>

        <label for="estatus">Estatus:</label>
        <select name="estatus">
            <option value="Vacaciones" <?php if ($cargo['estatus'] == 'Vacaciones') echo 'selected'; ?>>Vacaciones</option>
            <option value="Licencia" <?php if ($cargo['estatus'] == 'Licencia') echo 'selected'; ?>>Licencia</option>
            <option value="Incapacitado" <?php if ($cargo['estatus'] == 'Incapacitado') echo 'selected'; ?>>Incapacitado</option>
        </select><br>

        <label for="ocupacion">Ocupación:</label>
        <input type="text" name="ocupacion" value="<?php echo $cargo['ocupacion']; ?>"><br>

        <label for="posicion">Posición:</label>
        <input type="text" name="posicion" value="<?php echo $cargo['posicion']; ?>"><br>

        <label for="tipo_colaborador">Tipo de Colaborador:</label>
        <select name="tipo_colaborador">
            <option value="Eventual" <?php if ($cargo['tipo_colaborador'] == 'Eventual') echo 'selected'; ?>>Eventual</option>
            <option value="Interino" <?php if ($cargo['tipo_colaborador'] == 'Interino') echo 'selected'; ?>>Interino</option>
            <option value="Permanente" <?php if ($cargo['tipo_colaborador'] == 'Permanente') echo 'selected'; ?>>Permanente</option>
        </select><br>

        <button type="submit">Guardar cambios</button>
    </form>
</body>
</html>
