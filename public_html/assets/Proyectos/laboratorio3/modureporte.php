
<?php
// Habilitar la visualización de todos los errores
error_reporting(E_ALL); // Muestra todos los errores, advertencias y notificaciones.
ini_set('display_errors', 1); // Muestra los errores directamente en la pantalla.

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Datos</title>
    <link rel='stylesheet' href='https://unicons.iconscout.com/release/v2.1.9/css/unicons.css'>
    <link rel="stylesheet" href="style.css">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;700;900&display=swap");

        /* General */
        body {
            background-color: #1f2029; /* Fondo de toda la página */
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        /* Tabla */
        #tablaRegistros {
            width: 100%;
            border-collapse: collapse;
            background-color: #2a2b38; /* Fondo oscuro */
            color: #c4c3ca; /* Gris claro */
            margin-top: 20px;
        }

        #tablaRegistros th, #tablaRegistros td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        #tablaRegistros th {
            background-color: #007bff; /* Fondo azul de cabecera */
            color: #ffffff; /* Letra blanca */
        }

        #tablaRegistros td {
            background-color: #2a2b38; /* Fondo oscuro en celdas */
            color: #c4c3ca; /* Letra gris claro */
        }

        #tablaRegistros td:hover {
            background-color: #ffeba7; /* Fondo amarillo claro al pasar el mouse */
            color: #181818; /* Letra gris oscuro cuando se pasa el mouse */
        }

        /* Header */
        .header-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            background-color: #2a2b38; /* Fondo oscuro */
            color: #c4c3ca; /* Gris claro */
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header-left h1 {
            font-size: 24px;
        }

        .header-right {
            display: flex;
            gap: 15px;
        }

        .header-button {
            background-color: #c4c3ca; /* Gris claro */
            color: #102770; /* Azul oscuro */
            border: none;
            border-radius: 4px;
            padding: 8px 15px;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: background-color 300ms;
        }

        .header-button:hover {
            background-color: #ffeba7; /* Amarillo claro */
        }

        /* Iconos */
        .header-button i {
            font-size: 18px;
        }

        /* Estilo para el formulario de búsqueda */
        .search-form {
            margin: 20px;
            text-align: center;
        }

        .search-form input {
            padding: 8px;
            font-size: 16px;
            border-radius: 4px;
            border: 1px solid #ddd;
            width: 200px;
        }

        .search-form button {
            padding: 8px 16px;
            margin-left: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .search-form button:hover {
            background-color: #0056b3;
        }
    </style>
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

<!-- Formulario de búsqueda -->
<div class="search-form" style="display: flex; justify-content: center; align-items: center; gap: 10px; margin-top: 20px;">
    <form method="GET" style="display: flex; gap: 10px; align-items: center;">
        <input type="text" name="search" placeholder="Buscar por nombre o apellido" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>" style="width: 350px; padding: 8px 12px; font-size: 16px;" />
        <button type="submit" class="header-button">Buscar</button>
        <!-- Botón Borrar -->
        <button type="button" class="header-button" id="borrarButton">
            <i class="fa fa-trash"></i> Borrar
        </button>
    </form>
</div>

    <table id="tablaRegistros">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Edad</th>
                <th>Sexo</th>
                <th>Nacionalidad</th>
                <th>Correo</th>
                <th>Celular</th>
                <th>Observaciones</th>
                <th>Fecha de Registro</th>
            </tr>
        </thead>
        <tbody>
 

            <?php
            // Conexión a la base de datos
            $host = 'localhost';
            $usuario = 'EnriqueAdmin';
            $password = '1234';
            $database = 'primer_formulario';
            $puerto = 3307;

            $conexion = new mysqli($host, $usuario, $password, $database, $puerto);

            if ($conexion->connect_error) {
                die("Error de conexión: " . $conexion->connect_error);
            }

            // Filtrar búsqueda por nombre o apellido
            $search = isset($_GET['search']) ? $conexion->real_escape_string($_GET['search']) : '';
            $query = "SELECT * FROM datos_inscriptor";
            if ($search) {
                $query .= " WHERE nombre LIKE '%$search%' OR apellido LIKE '%$search%'";
            }

            $resultado = $conexion->query($query);

            if ($resultado->num_rows > 0) {
                while ($row = $resultado->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['id'] . "</td>
                            <td>" . $row['nombre'] . "</td>
                            <td>" . $row['apellido'] . "</td>
                            <td>" . $row['edad'] . "</td>
                            <td>" . $row['sexo'] . "</td>
                            <td>" . $row['nacionalidad'] . "</td>
                            <td>" . $row['correo'] . "</td>
                            <td>" . $row['celular'] . "</td>
                            <td>" . $row['observaciones'] . "</td>
                            <td>" . $row['fecha_registro'] . "</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='10'>No se encontraron registros.</td></tr>";
            }

            // Cerrar la conexión
            $conexion->close();
            ?>
        </tbody>
    </table>
<!-- Botón para descargar los registros en Excel -->
<div class="download-button" style="display: flex; justify-content: center; align-items: center; margin-top: 20px;">
    <form method="POST" action="excel.php">
        <button type="submit" class="header-button">
            Descargar Excel
        </button>
       
    </form>
</div>

    <script>
        // Función para resetear la tabla al estado inicial (recarga la página)
        document.getElementById("borrarButton").addEventListener("click", function() {
            window.location.href = window.location.pathname; // Recarga solo la URL sin parámetros
        });
    </script>
</body>
</html>
