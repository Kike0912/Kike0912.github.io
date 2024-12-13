<?php

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sis_capital";
$port = 3307; // El puerto va aquí como entero, no como cadena

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname, $port);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}


class Estadisticas {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function obtenerEstadisticas() {
        try {
            $estadisticas = [
                'sexo' => $this->obtenerEstadisticasPorSexo(),
                'contrato' => $this->obtenerEstadisticasPorContrato(),
                'estado' => $this->obtenerEstadisticasPorEstado(),
            ];

            return json_encode($estadisticas);
        } catch (Exception $e) {
            return json_encode(['error' => $e->getMessage()]);
        }
    }

    private function obtenerEstadisticasPorSexo() {
        $query = "SELECT sexo, COUNT(*) AS total FROM colaboradores GROUP BY sexo";
        $result = $this->conn->query($query);

        $estadisticas = [];
        while ($row = $result->fetch_assoc()) {
            $estadisticas[$row['sexo']] = $row['total'];
        }
        return $estadisticas;
    }

    private function obtenerEstadisticasPorContrato() {
        $query = "SELECT tipo_colaborador, COUNT(*) AS total FROM cargo_movimiento GROUP BY tipo_colaborador";
        $result = $this->conn->query($query);

        $estadisticas = [];
        while ($row = $result->fetch_assoc()) {
            $estadisticas[$row['tipo_colaborador']] = $row['total'];
        }
        return $estadisticas;
    }

    private function obtenerEstadisticasPorEstado() {
        $query = "SELECT estatus, COUNT(*) AS total FROM cargo_movimiento GROUP BY estatus";
        $result = $this->conn->query($query);

        $estadisticas = [];
        while ($row = $result->fetch_assoc()) {
            $estadisticas[$row['estatus']] = $row['total'];
        }
        return $estadisticas;
    }
}

$estadisticas = new Estadisticas($conn);
echo $estadisticas->obtenerEstadisticas();
?>