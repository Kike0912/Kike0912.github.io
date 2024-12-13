<?php
// Incluir la clase Database
require_once 'db.php';

// Crear una instancia de la clase Database
$db = new Database();
$conn = $db->connect(); // Conectar a la base de datos



// Procesar búsqueda
$searchQuery = '';
if (!empty($_GET['search'])) {
    $searchQuery = $_GET['search'];
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE nombre LIKE :nombre");
    $stmt->bindValue(':nombre', "%$searchQuery%");
} else {
    $stmt = $conn->prepare("SELECT * FROM usuarios");
}
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Procesar eliminación
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'])) {
    $id = $_POST['id'];

    try {
        $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        header("Location: modulousuario.php");
        exit();
    } catch (PDOException $e) {
        die("Error al eliminar usuario: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Usuarios</title>
    <link href="css/style.css" rel="stylesheet">
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
    </style>
</head>
    <script>
        // Función para mostrar el formulario emergente
        
    // Función para mostrar el formulario modal
    function mostrarFormulario() {
        document.getElementById('modalFormulario').style.display = 'block';
    }

    // Función para ocultar el formulario modal
    function ocultarFormulario() {
        document.getElementById('modalFormulario').style.display = 'none';
    }


    // Función para cancelar y ocultar el formulario emergente
    function cancelarFormulario() {
        document.getElementById('formularioAgregar').style.display = 'none';
    }

        // Limpiar la búsqueda
        function limpiarBusqueda() {
            const searchInput = document.querySelector('input[name="search"]');
            searchInput.value = ''; // Limpiar el campo de búsqueda
            window.location.href = 'modulousuario.php'; // Recargar la página
        }
    </script>
<head>
    <meta charset="utf-8">
    <title>Modulo de Usuarios</title>
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
        <h1>Gestión de Usuarios</h1>

        <!-- Formulario de búsqueda -->
        <form method="GET" style="padding-bottom: 20px; display: flex; justify-content: center; align-items: center; gap: 10px; width: 100%; max-width: 800px; margin: 0 auto;">
            <input type="text" name="search" placeholder="Buscar por nombre" value="<?php echo htmlspecialchars($searchQuery); ?>" 
                style="width: 70%; height: 35px; padding: 5px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px;">
            <button type="submit" style="padding: 10px 20px; background-color: #ff6700; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 14px;">Buscar</button>
            <button type="button" onclick="limpiarBusqueda()" style="padding: 10px 20px; background-color: #ff6700; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 14px;">Borrar</button>
        </form>

        <!-- Botón para agregar nuevo usuario con ícono -->
        <div style="margin-top: 20px; text-align: center;">
            <button onclick="mostrarFormulario()" style="padding: 10px 20px; background-color: #ff6700; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">
                <i class="fas fa-user-plus" style="margin-right: 8px;"></i> Agregar Usuario
            </button>
        </div>

        <!-- Tabla de usuarios con scroll horizontal -->
        <div style="padding-top: 30px; text-align: center; overflow-x: auto; max-width: 100%; border: 1px solid #ddd; margin-top: 20px;">
            <table class="table-usuarios" style="min-width: 800px; border-collapse: collapse; width: 70%; margin: 0 auto; text-align: left; border: 1px solid #ddd;">
                <thead>
                    <tr style="background-color: #f8f8f8; border-bottom: 2px solid #ddd;">
                        <th style="padding: 10px; border: 1px solid #ddd;">ID</th>
                        <th style="padding: 10px; border: 1px solid #ddd;">Nombre</th>
                        <th style="padding: 10px; border: 1px solid #ddd;">Correo</th>
                        <th style="padding: 10px; border: 1px solid #ddd;">Fecha de Ingreso</th>
                        <th style="padding: 10px; border: 1px solid #ddd;">Activo</th>
                        <th style="padding: 10px; border: 1px solid #ddd;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (count($usuarios) > 0): ?>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?php echo $usuario['id']; ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?php echo htmlspecialchars($usuario['correo']); ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?php echo $usuario['fecha_ingreso']; ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?php echo $usuario['activo'] == 1 ? 'Activo' : 'Inactivo'; ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd; text-align: center;">
                                <!-- Botón de editar -->
                                <form method="GET" action="editarusuario.php" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
                                    <button type="submit" style="padding: 5px 15px; background-color: #ff6700; color: white; border: none; border-radius: 3px; cursor: pointer;">Editar</button>
                                </form>

                                <!-- Botón de eliminar -->
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
                                    <button type="submit" name="eliminar" onclick="return confirm('¿Estás seguro de eliminar este usuario?')" 
                                            style="padding: 5px 15px; background-color: #ff6700; color: white; border: none; border-radius: 3px; cursor: pointer;">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="padding: 10px; border: 1px solid #ddd; text-align: center;">No se encontraron usuarios.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    

    <!-- Formulario modal flotante -->
<div id="modalFormulario" style="display: none;">
    <div class="modal-content">
        <h2>Agregar Usuario</h2>
        <form method="POST" action="procesarusuarios.php">
            <label for="nombre">Nombre:</label><br>
            <input type="text" id="nombre" name="nombre" required 
                style="width: 90%; height: 40px; margin-bottom: 10px; font-size: 16px; padding: 5px; border: 1px solid #ccc; border-radius: 5px;"><br>

            <label for="correo">Correo:</label><br>
            <input type="email" id="correo" name="correo" required 
                style="width: 90%; height: 40px; margin-bottom: 10px; font-size: 16px; padding: 5px; border: 1px solid #ccc; border-radius: 5px;"><br>

            <label for="contrasena">Contraseña:</label><br>
            <input type="password" id="contrasena" name="contrasena" required 
                style="width: 90%; height: 40px; margin-bottom: 10px; font-size: 16px; padding: 5px; border: 1px solid #ccc; border-radius: 5px;"><br>

            <label for="fecha_ingreso">Fecha de Ingreso:</label><br>
            <input type="date" id="fecha_ingreso" name="fecha_ingreso" required 
                style="width: 90%; height: 40px; margin-bottom: 10px; font-size: 16px; padding: 5px; border: 1px solid #ccc; border-radius: 5px;"><br>

            <button type="submit" 
                style="padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; margin-right: 10px;">
                Guardar Usuario
            </button>
            <button type="button" onclick="ocultarFormulario()" 
                style="padding: 10px 20px; background-color: #dc3545; color: white; border: none; border-radius: 5px; cursor: pointer;">
                Cancelar
            </button>
        </form>
    </div>
</div>

<style>
    /* Estilos ajustados solo para este formulario */
    #modalFormulario {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
    }

    .modal-content {
        background-color: white;
        padding: 30px;
        margin: 5% auto;
        width: 90%;
        max-width: 10000px; /* Ajuste del contenedor */
        border-radius: 8px;
        text-align: center;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); /* Sombra para mejor visibilidad */
    }
</style>




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

    <!--Javascript -->
    <script src="js/main.js"></script>
</body>

</html>

