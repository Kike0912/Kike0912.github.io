<?php
require_once 'db.php';

class ColaboradorHandler
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function procesarFormulario($postData, $fileData)
    {
        $primer_nombre = $postData['primer_nombre'];
        $segundo_nombre = $postData['segundo_nombre'];
        $primer_apellido = $postData['primer_apellido'];
        $segundo_apellido = $postData['segundo_apellido'];
        $sexo = $postData['sexo'];
        $identificacion = $postData['identificacion'];
        $fecha_nacimiento = $postData['fecha_nacimiento'];
        $direccion = $postData['direccion'];
        $correo_personal = $postData['correo_personal'];
        $telefono = $postData['telefono'];
        $celular = $postData['celular'];

        // Manejo de la foto de perfil
        $foto_perfil_url = $this->manejarSubidaFoto($fileData['foto_perfil']);

        // Conexión a la base de datos
        $conn = $this->db->connect();

        try {
            $stmt = $conn->prepare("
                INSERT INTO colaboradores 
                (primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, sexo, identificacion, fecha_nacimiento, foto_perfil, direccion, correo_personal, telefono, celular) 
                VALUES 
                (:primer_nombre, :segundo_nombre, :primer_apellido, :segundo_apellido, :sexo, :identificacion, :fecha_nacimiento, :foto_perfil, :direccion, :correo_personal, :telefono, :celular)
            ");

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

            $stmt->execute();

            // Redirige al módulo de colaboradores después de agregar
            header("Location: modulocolaboradores.php");
        } catch (PDOException $e) {
            echo "Error al agregar colaborador: " . $e->getMessage();
        }
    }

    private function manejarSubidaFoto($foto_perfil)
    {
        $foto_perfil_url = '';
        if ($foto_perfil['error'] === UPLOAD_ERR_OK) {
            $upload_dir = 'uploads/';
            
            // Asegúrate de que la carpeta 'uploads' exista
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $foto_perfil_url = $upload_dir . basename($foto_perfil['name']);
            if (!move_uploaded_file($foto_perfil['tmp_name'], $foto_perfil_url)) {
                throw new Exception("Error al mover el archivo.");
            }
        } else {
            throw new Exception("Error al subir el archivo: " . $foto_perfil['error']);
        }

        return $foto_perfil_url;
    }
}

// Manejar la solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $colaboradorHandler = new ColaboradorHandler();
    $colaboradorHandler->procesarFormulario($_POST, $_FILES);
}
?>
