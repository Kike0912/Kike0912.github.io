<?php
$host = 'localhost';      // Servidor
$port = '3307';           // Puerto
$dbname = 'sis_capital';  // Nombre de la base de datos
$username = 'root';       // Usuario de la base de datos
$password = '';           // Contraseña de la base de datos, ajusta si tienes una

// Crear conexión
$conn = new mysqli($host, $username, $password, $dbname, $port);

// Revisar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}




if (isset($_POST['submit'])) {
    $pdfName = $_FILES['pdfFile']['name'];
    $pdfTmp = $_FILES['pdfFile']['tmp_name'];

    $pdfContent = file_get_contents($pdfTmp);

    $stmt = $conn->prepare("INSERT INTO pdf_files (name, pdf) VALUES (?, ?)");
    $stmt->bind_param("sb", $pdfName, $pdfContent);
    $stmt->send_long_data(1, $pdfContent);

    if ($stmt->execute()) {
        echo "El archivo PDF ha sido subido exitosamente.";
    } else {
        echo "Error subiendo el archivo: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
