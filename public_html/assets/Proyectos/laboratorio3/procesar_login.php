<?php
session_start();
include 'db.php'; // Incluir la conexión a la base de datos

// Clase para manejar la encriptación de contraseñas
class Encriptacion {

    // Método para encriptar la contraseña
    public static function encriptarContrasena($contrasena) {
        return password_hash($contrasena, PASSWORD_DEFAULT);
    }

    // Método para verificar la contraseña
    public static function verificarContrasena($contrasena, $contrasenaHash) {
        return password_verify($contrasena, $contrasenaHash);
    }
}

// Función para eliminar caracteres potencialmente peligrosos
function sanitize_input($input) {
    $input = stripslashes($input); // Elimina barras invertidas
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8'); // Convierte caracteres especiales en entidades HTML
    $input = filter_var($input, FILTER_SANITIZE_STRING); // Elimina caracteres no deseados
    return $input;
}

// Verificar si se enviaron los datos del formulario
if (isset($_POST['usuarioInicio']) && isset($_POST['contrasenaInicio'])) {
    // Obtener y sanitizar los datos del formulario
    $usuario = sanitize_input(trim($_POST['usuarioInicio']));
    $contrasena = sanitize_input(trim($_POST['contrasenaInicio']));

    // Consulta parametrizada para buscar el usuario en la base de datos
    $sql = "SELECT id, usuario, contrasena, nombre_completo FROM usuarios WHERE usuario = ?"; // Consulta preparada

    // Preparar la consulta SQL para evitar inyecciones SQL
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $usuario); // "s" indica que el parámetro es una cadena (string)
    $stmt->execute();

    // Obtener el resultado de la consulta
    $resultado = $stmt->get_result();

    // Verificar si el usuario existe en la base de datos
    if ($resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc(); // Obtener los datos del usuario encontrado

        // Obtener el hash de la contraseña almacenada
        $contrasenaHash = $row['contrasena'];

        // Verificar la contraseña utilizando el método de la clase Encriptacion
        if (Encriptacion::verificarContrasena($contrasena, $contrasenaHash)) {
            // Si la contraseña es correcta, iniciar sesión y redirigir
            $_SESSION['usuario'] = $usuario;
            $_SESSION['id'] = $row['id']; // Guardar el ID del usuario en la sesión
            $_SESSION['nombre_completo'] = $row['nombre_completo']; // Guardar el nombre completo
            header("Location: lobi.php"); // Redirige al usuario a la página de bienvenida
            exit();
        } else {
            // Si la contraseña no es correcta
            echo "Usuario o contraseña incorrectos.";
        }
    } else {
        // Si el usuario no existe en la base de datos
        echo "Usuario o contraseña incorrectos.";
    }

    // Cerrar la sentencia preparada
    $stmt->close();
}
?>
