<?php
class Database {
    private $host = 'localhost';      // Servidor
    private $port = '3307';           // Puerto de la base de datos
    private $dbname = 'sis_capital';  // Nombre de la base de datos
    private $username = 'root';       // Usuario de la base de datos
    private $password = '';           // Contraseña
    private $conn = null;

    // Método para establecer la conexión a la base de datos
    public function connect() {
        if ($this->conn === null) {
            try {
                // Especificar el puerto en la cadena de conexión
                $this->conn = new PDO("mysql:host={$this->host};port={$this->port};dbname={$this->dbname}", $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Error al conectar a la base de datos: " . $e->getMessage());
            }
        }
        return $this->conn;
    }

    // Método para cerrar la conexión (opcional)
    public function disconnect() {
        if ($this->conn !== null) {
            $this->conn = null;
        }
    }
}
?>
