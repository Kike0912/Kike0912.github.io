<?php
require_once 'db.php';

class UsuarioSesion
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * Verifica si las credenciales son válidas y retorna el rol del usuario.
     * 
     * @param string $correo
     * @param string $contrasena
     * @return array|null
     */
    public function verificarCredenciales($correo, $contrasena)
    {
        $conn = $this->db->connect();
        try {
            $stmt = $conn->prepare("SELECT id, nombre, rol, contrasena FROM usuarios WHERE correo = :correo AND activo = 1");
            $stmt->bindParam(':correo', $correo);
            $stmt->execute();

            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {
                return [
                    'id' => $usuario['id'],
                    'nombre' => $usuario['nombre'],
                    'rol' => $usuario['rol']
                ];
            }
        } catch (PDOException $e) {
            die("Error en la base de datos: " . $e->getMessage());
        }

        return null;
    }

    /**
     * Inicia la sesión del usuario.
     * 
     * @param array $usuario
     */
    public function iniciarSesion($usuario)
    {
        session_start();
        $_SESSION['usuario'] = $usuario;
    }

    /**
     * Verifica si hay una sesión activa.
     * 
     * @return bool
     */
    public function sesionActiva()
    {
        session_start();
        return isset($_SESSION['usuario']);
    }

    /**
     * Retorna los datos del usuario en sesión.
     * 
     * @return array|null
     */
    public function obtenerUsuario()
    {
        session_start();
        return $_SESSION['usuario'] ?? null;
    }

    /**
     * Cierra la sesión.
     */
    public function cerrarSesion()
    {
        session_start();
        session_destroy();
    }
}
?>
