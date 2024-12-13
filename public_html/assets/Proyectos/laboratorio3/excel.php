<?php
// Incluir autoload de Composer
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Conexión a la base de datos
$host = 'localhost';
$usuario = 'root';
$password = '';
$database = 'primer_formulario';
$puerto = 3307;

$conexion = new mysqli($host, $usuario, $password, $database, $puerto);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Crear un nuevo objeto Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Establecer los encabezados de las columnas
$sheet->setCellValue('A1', 'Id');
$sheet->setCellValue('B1', 'Nombre');
$sheet->setCellValue('C1', 'Apellido');
$sheet->setCellValue('D1', 'Edad');
$sheet->setCellValue('E1', 'Sexo');
$sheet->setCellValue('F1', 'Nacionalidad');
$sheet->setCellValue('G1', 'Correo');
$sheet->setCellValue('H1', 'Celular');
$sheet->setCellValue('I1', 'Observaciones');
$sheet->setCellValue('J1', 'Fecha de Registro');

// Consultar los registros de la base de datos
$query = "SELECT * FROM datos_inscriptor";
$resultado = $conexion->query($query);

if ($resultado->num_rows > 0) {
    $rowNum = 2; // Empezar desde la fila 2 (porque la fila 1 tiene los encabezados)
    while ($row = $resultado->fetch_assoc()) {
        $sheet->setCellValue('A' . $rowNum, $row['id']);
        $sheet->setCellValue('B' . $rowNum, $row['nombre']);
        $sheet->setCellValue('C' . $rowNum, $row['apellido']);
        $sheet->setCellValue('D' . $rowNum, $row['edad']);
        $sheet->setCellValue('E' . $rowNum, $row['sexo']);
        $sheet->setCellValue('F' . $rowNum, $row['nacionalidad']);
        $sheet->setCellValue('G' . $rowNum, $row['correo']);
        $sheet->setCellValue('H' . $rowNum, $row['celular']);
        $sheet->setCellValue('I' . $rowNum, $row['observaciones']);
        $sheet->setCellValue('J' . $rowNum, $row['fecha_registro']);
        $rowNum++;
    }
} else {
    // Si no hay registros
    echo "No se encontraron registros.";
    exit;
}

// Cerrar la conexión a la base de datos
$conexion->close();

// Crear un objeto Writer para guardar el archivo Excel
$writer = new Xlsx($spreadsheet);

// Enviar las cabeceras adecuadas para la descarga del archivo
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="registros.xlsx"');
header('Cache-Control: max-age=0');

// Guardar el archivo Excel en la salida estándar (es decir, en el navegador)
$writer->save('php://output');
?>
