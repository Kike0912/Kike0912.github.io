<?php

// Habilitar la visualización de todos los errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Conexión a la base de datos
$host = 'localhost';
$usuario = 'root';
$password = '';
$database = 'laboratorio_3';
$puerto = 3307;

$conexion = new mysqli($host, $usuario, $password, $database, $puerto);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Bloque para manejar la actualización de los datos
if (isset($_POST['update_user'])) {
    $id = $_POST['id'];
    $nombre_completo = $_POST['nombre_completo'];
    $usuario = $_POST['usuario'];
    $email = $_POST['email'];
    $fecha_registro = $_POST['fecha_registro'];
    $estado = $_POST['estado'];

    // Verifica si se ha proporcionado una nueva contraseña
    if (!empty($_POST['contrasena']) && !empty($_POST['confirmar_contrasena'])) {
        $contrasena = $_POST['contrasena'];
        $confirmar_contrasena = $_POST['confirmar_contrasena'];

        // Verifica si las contraseñas coinciden
        if ($contrasena === $confirmar_contrasena) {
            // Hashea la nueva contraseña
            $contrasena_hashed = password_hash($contrasena, PASSWORD_DEFAULT);

            // Actualiza los datos con la nueva contraseña
            $sql_update = "UPDATE usuarios SET 
                nombre_completo='$nombre_completo', 
                usuario='$usuario', 
                email='$email', 
                fecha_registro='$fecha_registro', 
                estado='$estado', 
                contrasena='$contrasena_hashed' 
                WHERE id=$id";
        } else {
            echo "<script>alert('Las contraseñas no coinciden.');</script>";
            exit;
        }
    } else {
        // Si no se proporciona una nueva contraseña, solo actualiza los otros campos
        $sql_update = "UPDATE usuarios SET 
            nombre_completo='$nombre_completo', 
            usuario='$usuario', 
            email='$email', 
            fecha_registro='$fecha_registro', 
            estado='$estado' 
            WHERE id=$id";
    }

    if ($conexion->query($sql_update) === TRUE) {
        echo "<script>alert('Datos actualizados correctamente.');</script>";
    } else {
        echo "<script>alert('Error al actualizar los datos: " . $conexion->error . "');</script>";
    }
}


// Consultar los usuarios
$query = "SELECT id, nombre_completo, usuario, email, fecha_registro, estado FROM usuarios";
$resultado = $conexion->query($query);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Usuarios</title>
    <link rel="stylesheet" href="moduuser.css">
    <link rel="stylesheet" href="style.lobi.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.9/css/unicons.css">
    <style>
        .hidden {
            display: none;
        }

        /* Tabla de usuarios */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #c4c3ca;
        }

        th {
            background-color: #2a2b38; /* Fondo oscuro */
            color: #ffeba7; /* Amarillo claro */
        }

        td {
            background-color: #2a2b38;
            color: #c4c3ca; /* Gris claro */
        }

        tr:nth-child(even) {
            background-color: #3b3c47; /* Gris oscuro alternado */
        }

        tr:hover {
            background-color: #4f4f61; /* Gris más claro para resaltar */
        }

        .btn-cambiar {
            background-color: #4CAF50; /* Color de fondo */
            color: white; /* Color del texto */
            border: none; /* Sin borde */
            padding: 10px 20px; /* Relleno */
            text-align: center; /* Centrado del texto */
            text-decoration: none; /* Sin subrayado */
            display: inline-block; /* Elemento en línea */
            font-size: 16px; /* Tamaño de fuente */
            margin: 4px 2px; /* Margen */
            cursor: pointer; /* Cursor de mano al pasar el ratón */
            border-radius: 5px; /* Esquinas redondeadas */
            transition: background-color 0.3s; /* Efecto de transición */
        }

        .btn-cambiar:hover {
            background-color: #45a049; /* Color de fondo al pasar el ratón */
        }

        /* Estilos para el formulario de cambiar contraseña */
        #formulario-cambiar form {
            background-color: #2a2b38;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
            width: 400px;
            margin: 0 auto;
        }

        #formulario-cambiar h3 {
            color: #ffeba7;
            text-align: center;
        }

        #formulario-cambiar label {
            display: block;
            margin: 10px 0 5px;
            color: #c4c3ca;
        }

        #formulario-cambiar input {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #c4c3ca;
            border-radius: 5px;
            background-color: #3b3c47;
            color: #c4c3ca;
        }

        #formulario-cambiar button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        #formulario-cambiar button:hover {
            background-color: #45a049;
        }
    </style>
    <script>
        function mostrarFormulario(id) {
            const formulario = document.getElementById('formulario-cambiar-' + id);
            formulario.classList.remove('hidden');
        }

        function cerrarFormulario(id) {
            const formulario = document.getElementById('formulario-cambiar-' + id);
            formulario.classList.add('hidden');
        }
    </script>
</head>
<body>
<!-- Header -->
<header class="header-bar">
  <div class="header-left">
    <h1>Modulo de Reporte</h1>
  </div>
  <div class="header-right">
    <!-- Enlace al Inicio -->
    <a href="lobi.php">
      <button class="header-button">
        <i class="uil uil-home"></i> Inicio
      </button>
    </a>

    <!-- Enlace al Perfil -->
    <a href="lobi.php">
      <button class="header-button">
        <i class="uil uil-user"></i> Perfil
      </button>
    </a>

    <!-- Enlace para Cerrar Sesión -->
    <a href="modusalir.php">
      <button class="header-button">
        <i class="uil uil-sign-out-alt"></i> Cerrar Sesión
      </button>
    </a>
  </div>
</header>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre Completo</th>
                <th>Usuario</th>
                <th>Email</th>
                <th>Fecha de Registro</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($usuario = $resultado->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $usuario['id']; ?></td>
                <td><?php echo $usuario['nombre_completo']; ?></td>
                <td><?php echo $usuario['usuario']; ?></td>
                <td><?php echo $usuario['email']; ?></td>
                <td><?php echo $usuario['fecha_registro']; ?></td>
                <td><?php echo $usuario['estado']; ?></td>
                <td>
                    <button class="btn-cambiar" onclick="mostrarFormulario(<?php echo $usuario['id']; ?>)">Editar</button>
                </td>
            </tr>

            <!-- Formulario para actualizar datos -->
            <tr id="formulario-cambiar-<?php echo $usuario['id']; ?>" class="hidden">
                <td colspan="7">
                    <div id="formulario-cambiar">
                        <button type="button" onclick="cerrarFormulario(<?php echo $usuario['id']; ?>)" style="font-size: 32px; float: right; background: none; border: none; color: #c4c3ca; cursor: pointer;">
                            <i class="uil uil-times"></i>
                        </button>
                        <form method="POST" action="moduusers.php">
                            <h3>Editar Usuario</h3>
                            <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
                            <label for="nombre_completo">Nombre Completo</label>
                            <input type="text" name="nombre_completo" value="<?php echo $usuario['nombre_completo']; ?>" required>
                            
                            <label for="usuario">Usuario</label>
                            <input type="text" name="usuario" value="<?php echo $usuario['usuario']; ?>" required>
                            <label for="email">Email</label>
                            <input type="email" name="email" value="<?php echo $usuario['email']; ?>" required>
                            <label for="contrasena">Contraseña</label>
                            <input type="password" name="contrasena" placeholder="Dejar vacío si no desea cambiarla">
    

                            <label for="fecha_registro">Fecha de Registro</label>
                            <input type="date" name="fecha_registro" value="<?php echo $usuario['fecha_registro']; ?>" required>
                            <label for="estado">Estado</label>
                            <input type="text" name="estado" value="<?php echo $usuario['estado']; ?>" required>
                            <button type="submit" name="update_user">Actualizar Datos</button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
