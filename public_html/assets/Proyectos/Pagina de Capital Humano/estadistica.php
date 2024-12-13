<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <title>HumanityQ</title>
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
    <title>Estadísticas</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        h1{
            text-align: center;
            color: #343a40;
        }
        /* Contenedor principal */
        .chart-container {
            display: flex;            /* Usamos flexbox para alinearlos */
            justify-content: space-around; /* Espacio uniforme entre los gráficos */
            align-items: flex-start;  /* Alineamos los gráficos en la parte superior */
            width: 100%;
            margin: 0 auto;
            flex-wrap: wrap;          /* Permite que los gráficos se ajusten si la pantalla es pequeña */
        }

        /* Estilo de los gráficos */
        .chart-container canvas {
            width:120% !important;    /* Reducimos el tamaño de los gráficos */
            height: 250px !important; /* Reducimos la altura de los gráficos */
            margin: 10px 0;           /* Espaciado vertical entre los gráficos */
        }

        h2 {
            text-align: center;
            font-size: 30px;  /* Aumentamos el tamaño del título principal */
            margin-bottom: 20px;
        }

        /* Estilo del título de cada gráfico */
        .chart-title {
            font-size: 22px; /* Aumentamos el tamaño de los títulos de cada gráfico */
            font-weight: bold;
            margin-bottom: 10px;
        }

        /* Reducir el tamaño de la leyenda de las estadísticas */
        .chart-container .chart-legend {
            font-size: 12px; /* Tamaño de la letra de las leyendas */
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
    <h1>Estadisticas de Colaboradores</h1>
    <div class="chart-container">
        <div class="chart-item">
            <h3 class="chart-title"></h3>
            <canvas id="sexoChart"></canvas>
        </div>
        <div class="chart-item">
            <h3 class="chart-title"></h3>
            <canvas id="contratoChart"></canvas>
        </div>
        <div class="chart-item">
            <h3 class="chart-title"></h3>
            <canvas id="estadoChart"></canvas>
        </div>
    </div>

    <script>
        // Fetch statistics from the backend
        fetch('generar_estadisticas.php')
            .then(response => response.json())
            .then(data => {
                // Procesar estadísticas por sexo
                const sexoLabels = Object.keys(data.sexo);
                const sexoData = Object.values(data.sexo);
                renderChart('sexoChart', 'doughnut', sexoLabels, sexoData, 'Distribución por Sexo');

                // Procesar estadísticas por contrato
                const contratoLabels = Object.keys(data.contrato);
                const contratoData = Object.values(data.contrato);
                renderChart('contratoChart', 'bar', contratoLabels, contratoData, 'Distribución por Tipo de Contrato');

                // Procesar estadísticas por estado
                const estadoLabels = Object.keys(data.estado);
                const estadoData = Object.values(data.estado);
                renderChart('estadoChart', 'pie', estadoLabels, estadoData, 'Distribución por Estado');
            })
            .catch(error => console.error('Error al obtener estadísticas:', error));

        // Render a Chart.js chart
        function renderChart(chartId, type, labels, data, title) {
            const ctx = document.getElementById(chartId).getContext('2d');
            new Chart(ctx, {
                type: type,
                data: {
                    labels: labels,
                    datasets: [{
                        label: title,
                        data: data,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.6)',
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(255, 206, 86, 0.6)',
                            'rgba(75, 192, 192, 0.6)',
                            'rgba(153, 102, 255, 0.6)',
                            'rgba(255, 159, 64, 0.6)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                font: {
                                    size: 12 // Reducir el tamaño de las leyendas dentro del gráfico
                                }
                            }
                        },
                        title: {
                            display: true,
                            text: title,
                            font: {
                                size: 18 // Aumentar el tamaño del título del gráfico
                            }
                        }
                    }
                }
            });
        }
    </script>
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
