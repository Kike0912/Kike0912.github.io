<?php
require_once 'db.php';

$db = new Database();
$conn = $db->connect();

// Procesar búsqueda de cargos
$searchQuery = '';
if (!empty($_GET['search'])) {
    $searchQuery = $_GET['search'];
    $stmt = $conn->prepare("SELECT cm.*, c.primer_nombre, c.segundo_nombre, c.primer_apellido, c.segundo_apellido FROM cargo_movimiento cm
                            JOIN colaboradores c ON cm.colaborador_id = c.id
                            WHERE c.primer_nombre LIKE :search OR c.segundo_nombre LIKE :search OR c.primer_apellido LIKE :search");
    $stmt->bindValue(':search', "%$searchQuery%");
} else {
    $stmt = $conn->prepare("SELECT cm.*, c.primer_nombre, c.segundo_nombre, c.primer_apellido, c.segundo_apellido FROM cargo_movimiento cm
                            JOIN colaboradores c ON cm.colaborador_id = c.id");
}
$stmt->execute();
$cargos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Procesar eliminación de cargo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'])) {
    $id = $_POST['id'];

    try {
        $stmt = $conn->prepare("DELETE FROM cargo_movimiento WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        header("Location: modulocargo.php");
        exit();
    } catch (PDOException $e) {
        die("Error al eliminar cargo: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Cargos y Movimientos</title>
    <script>
        function limpiarBusqueda() {
            const searchInput = document.querySelector('input[name="search"]');
            searchInput.value = '';
            window.location.href = 'modulocargo.php';
        }
    </script>
<head>
    <meta charset="utf-8">
    <title>Cargo y Movimiento</title>
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
    <style>
        /* Incluye aquí el CSS personalizado */
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

    <body>
<div style="padding-top: 30px; text-align: center;">
    <h1>Gestión de Cargos y Movimientos</h1>

     <!-- Formulario de búsqueda -->
     <form method="GET" style="padding-bottom: 20px; display: flex; justify-content: center; align-items: center; gap: 10px; width: 100%; max-width: 800px; margin: 0 auto;">
            <input type="text" name="search" placeholder="Buscar por nombre" value="<?php echo htmlspecialchars($searchQuery); ?>" 
                style="width: 70%; height: 35px; padding: 5px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px;">
            <button type="submit" style="padding: 10px 20px; background-color: #ff6700; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 14px;">Buscar</button>
            <button type="button" onclick="limpiarBusqueda()" style="padding: 10px 20px; background-color: #ff6700; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 14px;">Borrar</button>
        </form>

    <!-- Tabla de cargos con scroll horizontal -->
    <div style="padding-top: 30px; text-align: center; overflow-x: auto; max-width: 100%; border: 1px solid #ddd; margin-top: 20px;">
        <table class="table-usuarios" style="min-width: 1000px; border-collapse: collapse; width: 90%; margin: 0 auto; text-align: left; border: 1px solid #ddd;">
            <thead>
                <tr style="background-color: #f8f8f8; border-bottom: 2px solid #ddd;">
                    <th style="padding: 10px; border: 1px solid #ddd;">ID</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Colaborador</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Sueldo</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Departamento</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Fecha de Contrato</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Estado</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Estatus</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Ocupación</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Posición</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Tipo de Colaborador</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($cargos) > 0): ?>
                    <?php foreach ($cargos as $cargo): ?>
                        <tr>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?php echo $cargo['id']; ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?php echo htmlspecialchars($cargo['primer_nombre'] . ' ' . $cargo['primer_apellido']); ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?php echo $cargo['sueldo']; ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?php echo $cargo['departamento']; ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?php echo $cargo['fecha_contrato']; ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?php echo $cargo['estado'] == 1 ? 'Activo' : 'Inactivo'; ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?php echo $cargo['estatus']; ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?php echo $cargo['ocupacion']; ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?php echo $cargo['posicion']; ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?php echo $cargo['tipo_colaborador']; ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd; text-align: center;">
                                <!-- Botón de editar -->
                                <form method="GET" action="editarcargo.php" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $cargo['id']; ?>">
                                    <button type="submit" style="padding: 5px 15px; background-color: #ff6700; color: white; border: none; border-radius: 3px; cursor: pointer;">Editar</button>
                                </form>

                                <!-- Botón de eliminar -->
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $cargo['id']; ?>">
                                    <button type="submit" name="eliminar" onclick="return confirm('¿Estás seguro de eliminar este cargo?')" 
                                            style="padding: 5px 15px; background-color: #ff6700; color: white; border: none; border-radius: 3px; cursor: pointer;">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="11" style="padding: 10px; border: 1px solid #ddd; text-align: center;">No se encontraron cargos.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    




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

    <!-- Javascript -->
    <script src="js/main.js"></script>
</body>

</html>


