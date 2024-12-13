<?php
// Mostrar todos los errores
error_reporting(E_ALL);

// Incluir la biblioteca SimpleXLSXGen
require 'SimpleXLSXGen.php';
use Shuchkin\SimpleXLSXGen;


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

// Variables para filtros
$edad = isset($_GET['edad']) ? $_GET['edad'] : '';
$sexo = isset($_GET['sexo']) ? $_GET['sexo'] : '';
$primer_nombre = isset($_GET['primer_nombre']) ? $_GET['primer_nombre'] : '';
$primer_apellido = isset($_GET['primer_apellido']) ? $_GET['primer_apellido'] : '';

// Variables para paginación
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$resultados_por_pagina = 5; // Número de resultados por página
$inicio = ($pagina_actual - 1) * $resultados_por_pagina;

// Consulta SQL con filtros y paginación
$sql = "SELECT c.id, c.primer_nombre, c.segundo_nombre, c.primer_apellido, c.segundo_apellido, c.sexo, c.identificacion, c.fecha_nacimiento, c.correo_personal, c.telefono, c.celular, c.fecha_ingreso, c.activo, cm.sueldo, cm.fecha_contrato 
        FROM colaboradores c
        JOIN cargo_movimiento cm ON c.id = cm.colaborador_id 
        WHERE 1=1";

if (!empty($edad)) {
    $sql .= " AND TIMESTAMPDIFF(YEAR, c.fecha_nacimiento, CURDATE()) = $edad";
}

if (!empty($sexo)) {
    $sql .= " AND c.sexo = '" . $conn->real_escape_string($sexo) . "'";
}

if (!empty($primer_nombre)) {
    $sql .= " AND c.primer_nombre LIKE '%" . $conn->real_escape_string($primer_nombre) . "%'";
}

if (!empty($primer_apellido)) {
    $sql .= " AND c.primer_apellido LIKE '%" . $conn->real_escape_string($primer_apellido) . "%'";
}

// Agregar paginación
$sql .= " LIMIT $inicio, $resultados_por_pagina";

$result = $conn->query($sql);

// Contar el total de registros (para calcular el número de páginas)
$sql_contar = "SELECT COUNT(*) as total 
               FROM colaboradores c
               JOIN cargo_movimiento cm ON c.id = cm.colaborador_id 
               WHERE 1=1";

if (!empty($edad)) {
    $sql_contar .= " AND TIMESTAMPDIFF(YEAR, c.fecha_nacimiento, CURDATE()) = $edad";
}

if (!empty($sexo)) {
    $sql_contar .= " AND c.sexo = '" . $conn->real_escape_string($sexo) . "'";
}

if (!empty($primer_nombre)) {
    $sql_contar .= " AND c.primer_nombre LIKE '%" . $conn->real_escape_string($primer_nombre) . "%'";
}

if (!empty($primer_apellido)) {
    $sql_contar .= " AND c.primer_apellido LIKE '%" . $conn->real_escape_string($primer_apellido) . "%'";
}

$result_contar = $conn->query($sql_contar);
$total_registros = $result_contar->fetch_assoc()['total'];
$total_paginas = ceil($total_registros / $resultados_por_pagina);

// Generar reporte en Excel si se solicita
if (isset($_GET['generar_reporte'])) {
    // Consulta sin paginación para el reporte
    $sql_reporte = "SELECT c.id, c.primer_nombre, c.segundo_nombre, c.primer_apellido, c.segundo_apellido, c.sexo, c.identificacion, c.fecha_nacimiento, c.correo_personal, c.telefono, c.celular, c.fecha_ingreso, c.activo, cm.sueldo, cm.fecha_contrato 
                    FROM colaboradores c
                    JOIN cargo_movimiento cm ON c.id = cm.colaborador_id 
                    WHERE 1=1";

    if (!empty($edad)) {
        $sql_reporte .= " AND TIMESTAMPDIFF(YEAR, c.fecha_nacimiento, CURDATE()) = $edad";
    }

    if (!empty($sexo)) {
        $sql_reporte .= " AND c.sexo = '" . $conn->real_escape_string($sexo) . "'";
    }

    if (!empty($primer_nombre)) {
        $sql_reporte .= " AND c.primer_nombre LIKE '%" . $conn->real_escape_string($primer_nombre) . "%'";
    }

    if (!empty($primer_apellido)) {
        $sql_reporte .= " AND c.primer_apellido LIKE '%" . $conn->real_escape_string($primer_apellido) . "%'";
    }

    $result_reporte = $conn->query($sql_reporte);

    if ($result_reporte->num_rows > 0) {
        $rows = [['ID', 'Primer Nombre', 'Segundo Nombre', 'Primer Apellido', 'Segundo Apellido', 'Sexo', 'Identificación', 'Fecha de Nacimiento', 'Correo Personal', 'Teléfono', 'Celular', 'Fecha de Ingreso', 'Activo', 'Sueldo', 'Fecha de Contrato']];
        
        while ($row = $result_reporte->fetch_assoc()) {
            $rows[] = [
                $row['id'],
                $row['primer_nombre'],
                $row['segundo_nombre'],
                $row['primer_apellido'],
                $row['segundo_apellido'],
                $row['sexo'],
                $row['identificacion'],
                $row['fecha_nacimiento'],
                $row['correo_personal'],
                $row['telefono'],
                $row['celular'],
                $row['fecha_ingreso'],
                $row['activo'],
                $row['sueldo'],
                $row['fecha_contrato']
            ];
        }

        // Crear una instancia de SimpleXLSXGen
        $xlsx = SimpleXLSXGen::fromArray($rows);
        
        // Configurar las cabeceras HTTP
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename=\"reporte_colaboradores.xlsx\"');
        header('Cache-Control: max-age=0');

        // Descargar el archivo
        $xlsx->downloadAs('reporte_colaboradores.xlsx');
        exit;
    } else {
        echo "No se encontraron colaboradores para el reporte.";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
    <title>Reporte de colaboradores </title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet"> 

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="stylepdf.css">
    <link rel="stylesheet" href="stylepdf.css">
    <style>
        form {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
        }

        form input[type="text"] {
            width: 300px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #ff6600;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin-bottom: 20px;
            transition: background-color 0.3s ease;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #f8f9fa;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #343a40;
        }
        .paginacion {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .paginacion a {
            padding: 10px 20px;
            margin: 0 5px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }
        .paginacion a:hover {
            background-color: #45a049;
        }
        .paginacion .activo {
            background-color: #3e8e41;
        }
    </style>
</head>
<body>

<!-- Topbar Start -->
<div class="container-fluid d-none d-lg-block">
    <div class="row align-items-center py-4 px-xl-5">
        <div class="col-lg-3">
            <!-- Imagen al lado del texto -->
        
            <a href="" class="text-decoration-none">
                
                <h1 class="m-0"><span class="text-primary">HUMANITY</span>Q</h1>
            </a>
        </div>
        <div class="col-lg-3 text-right">
            <div class="d-inline-flex align-items-center">
                <i class="fa fa-2x fa-map-marker-alt text-primary mr-3"></i>
                <div class="text-left">
                    <h6 class="font-weight-semi-bold mb-1">Nuestra Oficina</h6>
                    <small>UTP, Tumba Muerto, PANAMA</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 text-right">
            <div class="d-inline-flex align-items-center">
                <i class="fa fa-2x fa-envelope text-primary mr-3"></i>
                <div class="text-left">
                    <h6 class="font-weight-semi-bold mb-1">Contactanos</h6>
                    <small>info@HumanityQ.com</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 text-right">
            <div class="d-inline-flex align-items-center">
                <i class="fa fa-2x fa-phone text-primary mr-3"></i>
                <div class="text-left">
                    <h6 class="font-weight-semi-bold mb-1">Llamanos</h6>
                    <small>+012 345 6789</small>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Topbar End -->


<!-- Navbar Start -->
<div class="container-fluid">
    <div class="row border-top px-xl-5">
        <div class="col-lg-3 d-none d-lg-block">
            <a class="d-flex align-items-center justify-content-between bg-secondary w-100 text-decoration-none" data-toggle="collapse" href="#navbar-vertical" style="height: 67px; padding: 0 30px;">
                <h5 class="text-primary m-0"><i class="fa fa-book-open mr-2"></i>Modulos</h5>
                <i class="fa fa-angle-down text-primary"></i>
            </a>
            <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0 bg-light" id="navbar-vertical" style="width: calc(100% - 30px); z-index: 9;">
                <div class="navbar-nav w-100">
                    <a href="login.php" class="nav-item nav-link">Iniciar Sesion</a>
                    <a href="modulousuario.php" class="nav-item nav-link">Modulo de Usuarios</a>
                    <a href="modulocolaboradores.php" class="nav-item nav-link">Modulo de Colaboradores</a>
                    <a href="modulocargo.php" class="nav-item nav-link">Modulo de Cargos y Movimiento</a>
                    <a href="subirpdf.html" class="nav-item nav-link">Subir Historial Academico</a>
                    <a href="reportecolaboradores.php" class="nav-item nav-link">Reporte de Colaboradores</a>
                    <a href="Estadistica.php" class="nav-item nav-link">Estadistica de Colaboradores </a>
                    <a href="cerrarsesion.php" class="nav-item nav-link">Cerrar Sesion</a>
                    
                    
                </div>
            </nav>
        </div>
        <div class="col-lg-9">
            <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                <a href="" class="text-decoration-none d-block d-lg-none">
                    <h1 class="m-0"><span class="text-primary">A</span>COURSES</h1>
                </a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav py-0">
                        <a href="index.html" class="nav-item nav-link active">Inicio</a>
                        <a href="about.html" class="nav-item nav-link">Sobre nosotros</a>
                    </div>
                    <a class="btn btn-primary py-2 px-4 ml-auto d-none d-lg-block" href="">Iniciar Sesion</a>
                </div>
            </nav>
        </div>
    </div>
</div>
<!-- Navbar End -->

<h1>Reporte de colaboradores</h1>
<div class="listado-usuarios">
    <form method="GET" action="" style="display: flex; flex-wrap: wrap; gap: 10px; justify-content: space-between; align-items: center; max-width: 1000px;">
        <div style="flex: 1; min-width: 200px;">
            <label for="primer_nombre">Primer Nombre:</label>
            <input type="text" name="primer_nombre" id="primer_nombre" value="<?php echo $primer_nombre; ?>" style="width: 100%; padding: 5px;">
        </div>
        
        <div style="flex: 1; min-width: 200px;">
            <label for="primer_apellido">Primer Apellido:</label>
            <input type="text" name="primer_apellido" id="primer_apellido" value="<?php echo $primer_apellido; ?>" style="width: 100%; padding: 5px;">
        </div>

        <div style="flex: 1; min-width: 150px;">
            <label for="edad">Edad:</label>
            <input type="number" name="edad" id="edad" value="<?php echo $edad; ?>" style="width: 100%; padding: 5px;">
        </div>

        <div style="flex: 1; min-width: 150px;">
            <label for="sexo">Sexo:</label>
            <select name="sexo" id="sexo" style="width: 100%; padding: 5px;">
                <option value="">Todos</option>
                <option value="Masculino" <?php if ($sexo == 'Masculino') echo 'selected'; ?>>Masculino</option>
                <option value="Femenino" <?php if ($sexo == 'Femenino') echo 'selected'; ?>>Femenino</option>
            </select>
        </div>

        <div style="flex: 1; min-width: 100px; display: flex; align-items: center;">
            <input type="submit" value="Filtrar" style="padding: 5px 10px; margin-right: 10px; background-color: #f8f8f8; border: 1px solid #ddd;">
            <button type="submit" name="generar_reporte" style="padding: 5px 10px; background-color: orange; color: white; border: none;">Generar Reporte</button>
        </div>
    </form>
</div>


        <div style="padding-top: 30px; text-align: center; overflow-x: auto; max-width: 100%; border: 1px solid #ddd; margin-top: 20px;">
    <table class="table-usuarios" style="min-width: 1000px; border-collapse: collapse; width: 90%; margin: 0 auto; text-align: left; border: 1px solid #ddd;">
        <thead>
            <tr style="background-color: #f8f8f8; border-bottom: 2px solid #ddd;">
                <th style="padding: 10px; border: 1px solid #ddd;">ID</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Primer Nombre</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Segundo Nombre</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Primer Apellido</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Segundo Apellido</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Sexo</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Identificación</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Fecha de Nacimiento</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Correo Personal</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Teléfono</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Celular</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Fecha de Ingreso</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Activo</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Sueldo</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Fecha de Contrato</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td style='padding: 10px; border: 1px solid #ddd;'>{$row['id']}</td>";
                    echo "<td style='padding: 10px; border: 1px solid #ddd;'>{$row['primer_nombre']}</td>";
                    echo "<td style='padding: 10px; border: 1px solid #ddd;'>{$row['segundo_nombre']}</td>";
                    echo "<td style='padding: 10px; border: 1px solid #ddd;'>{$row['primer_apellido']}</td>";
                    echo "<td style='padding: 10px; border: 1px solid #ddd;'>{$row['segundo_apellido']}</td>";
                    echo "<td style='padding: 10px; border: 1px solid #ddd;'>{$row['sexo']}</td>";
                    echo "<td style='padding: 10px; border: 1px solid #ddd;'>{$row['identificacion']}</td>";
                    echo "<td style='padding: 10px; border: 1px solid #ddd;'>{$row['fecha_nacimiento']}</td>";
                    echo "<td style='padding: 10px; border: 1px solid #ddd;'>{$row['correo_personal']}</td>";
                    echo "<td style='padding: 10px; border: 1px solid #ddd;'>{$row['telefono']}</td>";
                    echo "<td style='padding: 10px; border: 1px solid #ddd;'>{$row['celular']}</td>";
                    echo "<td style='padding: 10px; border: 1px solid #ddd;'>{$row['fecha_ingreso']}</td>";
                    echo "<td style='padding: 10px; border: 1px solid #ddd;'>{$row['activo']}</td>";
                    echo "<td style='padding: 10px; border: 1px solid #ddd;'>{$row['sueldo']}</td>";
                    echo "<td style='padding: 10px; border: 1px solid #ddd;'>{$row['fecha_contrato']}</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='15' style='padding: 10px; text-align: center;'>No se encontraron resultados</td></tr>";
            }
            $conn->close();
            ?>
        </tbody>
    </table>
</div>

        <div class="paginacion">
            <!-- Botón Anterior -->
            <?php if ($pagina_actual > 1): ?>
                <a href="?pagina=<?php echo $pagina_actual - 1; ?>&primer_nombre=<?php echo urlencode($primer_nombre); ?>&primer_apellido=<?php echo urlencode($primer_apellido); ?>&edad=<?php echo urlencode($edad); ?>&sexo=<?php echo urlencode($sexo); ?>">Anterior</a>
            <?php else: ?>
                <span style="padding: 10px 20px; margin: 0 5px; background-color: #ddd;" class="disabled">Anterior</span>
            <?php endif; ?>

            <!-- Páginas -->
            <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                <a href="?pagina=<?php echo $i; ?>&primer_nombre=<?php echo urlencode($primer_nombre); ?>&primer_apellido=<?php echo urlencode($primer_apellido); ?>&edad=<?php echo urlencode($edad); ?>&sexo=<?php echo urlencode($sexo); ?>" <?php if ($i == $pagina_actual) echo 'class="activo"'; ?>>
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>

            <!-- Botón Siguiente -->
            <?php if ($pagina_actual < $total_paginas): ?>
                <a href="?pagina=<?php echo $pagina_actual + 1; ?>&primer_nombre=<?php echo urlencode($primer_nombre); ?>&primer_apellido=<?php echo urlencode($primer_apellido); ?>&edad=<?php echo urlencode($edad); ?>&sexo=<?php echo urlencode($sexo); ?>">Siguiente</a>
            <?php else: ?>
                <span style="padding: 10px 20px; margin: 0 5px; background-color: #ddd;" class="disabled">Siguiente</span>
            <?php endif; ?>
        </div>
    </div>





    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-white py-5 px-sm-3 px-lg-5" style="margin-top: 90px;">
        <div class="row pt-5">
            <div class="col-lg-7 col-md-12">
                <div class="row">
                    <div class="col-md-6 mb-5">
                        <h5 class="text-primary text-uppercase mb-4" style="letter-spacing: 5px;">Ponte en Contacto</h5>
                        <p><i class="fa fa-map-marker-alt mr-2"></i>UTP, Tumba Muerto, PANAMA</p>
                        <p><i class="fa fa-phone-alt mr-2"></i>+012 345 67890</p>
                        <p><i class="fa fa-envelope mr-2"></i>info@HumanityQ.com</p>
                        <div class="d-flex justify-content-start mt-4">
                            <a class="btn btn-outline-light btn-square mr-2" href="#"><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-outline-light btn-square mr-2" href="#"><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-light btn-square mr-2" href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a class="btn btn-outline-light btn-square" href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                    <div class="col-md-6 mb-5">
                        <h5 class="text-primary text-uppercase mb-4" style="letter-spacing: 5px;">Nuetros Modulos</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-white mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Modulo de colaboradores</a>
                            <a class="text-white mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Modulo de Usuarios</a>
                            <a class="text-white mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Modulo de Login</a>
                            <a class="text-white mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Modulo de Cargos</a>
                            <a class="text-white" href="#"><i class="fa fa-angle-right mr-2"></i>SEO</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-12 mb-5">
                <h5 class="text-primary text-uppercase mb-4" style="letter-spacing: 5px;">Aclara tus dudas </h5>
                <p>En HUMANITY Q, valoramos tus preguntas, sugerencias e ideas. Estamos aquí para ayudarte en todo lo relacionado con nuestros servicios de capital humano.</p>
                <div class="w-100">
                    <div class="input-group">
                        <input type="text" class="form-control border-light" style="padding: 30px;" placeholder="Tu direccion de correo">
                        <div class="input-group-append">
                            <button class="btn btn-primary px-4">Registrate</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid bg-dark text-white border-top py-4 px-sm-3 px-md-5" style="border-color: rgba(256, 256, 256, .1) !important;">
        <div class="row">
            <div class="col-lg-6 text-center text-md-left mb-3 mb-md-0">
                <p class="m-0 text-white">&copy; <a>. Derechos reservados para curso de ing web<a>
                </p>
            </div>
            <div class="col-lg-6 text-center text-md-right">
                <ul class="nav d-inline-flex">
                    <li class="nav-item">
                        <a class="nav-link text-white py-0" href="#">Seguridad </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white py-0" href="#">Terminos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white py-0" href="#">Preguntas </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white py-0" href="#">Ayuda </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!--  Javascript -->
    <script src="js/main.js"></script>
</body>

</html>


