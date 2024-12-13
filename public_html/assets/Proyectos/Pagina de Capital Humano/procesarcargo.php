<?php
require_once 'db.php';

class CargoHandler
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function guardarCargo($data)
    {
        $conn = $this->db->connect();

        $colaborador_id = $data['colaborador_id'];
        $sueldo = $data['sueldo'];
        $departamento = $data['departamento'];
        $fecha_contrato = $data['fecha_contrato'];
        $estado = $data['estado'];
        $estatus = $data['estatus'];
        $ocupacion = $data['ocupacion'];
        $posicion = $data['posicion'];
        $tipo_colaborador = $data['tipo_colaborador'];

        if (isset($data['id']) && !empty($data['id'])) {
            // Actualizar un cargo existente
            $id = $data['id'];
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
        } else {
            // Crear un nuevo cargo
            $stmt = $conn->prepare("INSERT INTO cargo_movimiento 
                                    (colaborador_id, sueldo, departamento, fecha_contrato, estado, estatus, ocupacion, posicion, tipo_colaborador) 
                                    VALUES 
                                    (:colaborador_id, :sueldo, :departamento, :fecha_contrato, :estado, :estatus, :ocupacion, :posicion, :tipo_colaborador)");
        }

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
    }

    public function eliminarCargo($id)
    {
        $conn = $this->db->connect();
        $stmt = $conn->prepare("DELETE FROM cargo_movimiento WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        header("Location: modulocargo.php");
        exit();
    }

    public function obtenerColaboradores()
    {
        $conn = $this->db->connect();
        $stmt = $conn->prepare("SELECT id, CONCAT(primer_nombre, ' ', segundo_nombre, ' ', primer_apellido, ' ', segundo_apellido) AS nombre FROM colaboradores");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

// Instanciar la clase y manejar solicitudes
$cargoHandler = new CargoHandler();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['eliminar'])) {
        $cargoHandler->eliminarCargo($_POST['id']);
    } else {
        $cargoHandler->guardarCargo($_POST);
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Cargo y Movimiento</title>
</head>
<body>
    <h1>Gestionar Cargo y Movimiento</h1>
    
    <form method="POST">
        <!-- Si hay un ID, significa que estamos editando un cargo existente -->
        <?php if (isset($_GET['id']) && !empty($_GET['id'])): ?>
            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
        <?php endif; ?>

        <label for="colaborador_id">Colaborador:</label>
        <select name="colaborador_id">
            <option value="">Seleccionar Colaborador</option>
            <?php
            $colaboradores = $cargoHandler->obtenerColaboradores();
            foreach ($colaboradores as $colaborador) {
                echo "<option value='{$colaborador['id']}'>{$colaborador['nombre']}</option>";
            }
            ?>
        </select><br>

        <label for="sueldo">Sueldo:</label>
        <input type="number" name="sueldo" step="0.01" required><br>

        <label for="departamento">Departamento:</label>
        <input type="text" name="departamento" required><br>

        <label for="fecha_contrato">Fecha de Contrato:</label>
        <input type="date" name="fecha_contrato" required><br>

        <label for="estado">Estado:</label>
        <select name="estado" required>
            <option value="1">Activo</option>
            <option value="0">Inactivo</option>
        </select><br>

        <label for="estatus">Estatus:</label>
        <input type="text" name="estatus" required><br>

        <label for="ocupacion">Ocupación:</label>
        <input type="text" name="ocupacion" required><br>

        <label for="posicion">Posición:</label>
        <input type="text" name="posicion" required><br>

        <label for="tipo_colaborador">Tipo de Colaborador:</label>
        <select name="tipo_colaborador" required>
            <option value="Eventual">Eventual</option>
            <option value="Interino">Interino</option>
            <option value="Permanente">Permanente</option>
        </select><br>

        <button type="submit">Guardar</button>
    </form>
</body>
</html>
