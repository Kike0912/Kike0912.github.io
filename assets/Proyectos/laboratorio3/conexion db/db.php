<?php
// db.php
$host = 'localhost';
$usuario = 'EnriqueAdmin';
$password = '1234';
$database = 'laboratorio_3';
$puerto = 3307; // Puerto de conexión MySQL

// Crear conexión
$conexion = new mysqli($host, $usuario, $password, $database, $puerto);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
} else {
    echo "Conexión exitosa a la base de datos: " . $database;
}
?>
