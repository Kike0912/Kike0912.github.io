<?php
session_start();

error_reporting(E_ALL); // Muestra todos los errores, advertencias y notificaciones.
ini_set('display_errors', 1); // Muestra los errores directamente en la pantalla.

// Verificar si el usuario no está autenticado
if (!isset($_SESSION['usuario'])) {
    // Redirigir al login si no hay sesión activa
    header("Location: login.php");
    exit();
}

// Incluir archivo de conexión a la base de datos
include('db.php');  // Asumiendo que db.php está en el mismo directorio

// Obtener el nombre completo del usuario
$usuario = $_SESSION['usuario'];  // Asumiendo que el nombre de usuario está guardado en la sesión

// Consulta SQL para obtener el nombre completo
$sql = "SELECT nombre_completo FROM usuarios WHERE usuario = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $usuario);  // Usamos 's' para indicar que es una cadena (string)
$stmt->execute();
$stmt->bind_result($nombre_completo);  // Guardamos el valor del nombre completo en la variable
$stmt->fetch();
$stmt->close();
?>


<!doctype html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
    />
    <title>Página con Header y Tarjetas</title>
    <link rel="stylesheet" href="style.lobi.css" />
    <link rel='stylesheet' href='https://unicons.iconscout.com/release/v2.1.9/css/unicons.css'>
  </head>
  <body>
<!-- Header -->
<header class="header-bar">
  <div class="header-left">
  <h1>Bienvenido<h1>

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

    <!--   Tarjetas-->
    <div class="title-cards">
      <h2>Servicios que Ofrecemos</h2>
    </div>
    <div class="container-card">
      <!-- Primera fila -->
      <div class="card">
        <figure>
          <img src="https://media.istockphoto.com/id/1471444483/es/foto/concepto-de-encuesta-de-satisfacci%C3%B3n-del-cliente-los-usuarios-califican-las-experiencias-de.jpg?s=612x612&w=0&k=20&c=Bgf3bkIo4eIQDrC55iKezs-UbWzXuTB78Q-NjujIeIE=" />
        </figure>
        <div class="contenido-card">
          <h3>Modulo de Usuarios</h3>
          <p>
          En este módulo puedes visualizar, editar y gestionar 
          los datos de los usuarios registrados en el sistema.
          </p>
          <a href="moduusers.php">Leer Más</a>
        </div>
      </div>
      <div class="card">
        <figure>
          <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTBEjoCLHr_-pKvAoIEKfKND0YJKkB7G_IVHw&s" />
        </figure>
        <div class="contenido-card">
          <h3>Docentes </h3>
          <p>
          Aquí podrás acceder a la información detallada de los docentes,
          incluyendo su perfil y asignaturas a cargo.
          </p>
          <a href="#">Leer Más</a>
        </div>
      </div>
      <div class="card">
        <figure>
          <img src="https://wortev.com/wp-content/uploads/2023/04/consejos-para-estimular-la-capacitacion-laboral-WORTEV.jpg" />
        </figure>
        <div class="contenido-card">
          <h3>Guias de Capacitacion</h3>
          <p>
          Este módulo ofrece acceso a las guías de capacitación 
          para facilitar la formación y el desarrollo de los empleados.
          </p>
          <a href="#">Leer Más</a>
        </div>
      </div>
      <div class="card">
        <figure>
          <img src="https://media.istockphoto.com/id/1087123716/photo/log-out-finger-pressing-button.jpg?s=612x612&w=0&k=20&c=y8pgm_uJoZ1X2xSjYxTgXo_KgmGMNuCSEDlfuoUgI5I=" />
        </figure>
        <div class="contenido-card">
          <h3>Modulo de Salida </h3>
          <p>
          Permite eliminar y destruir sesiones
          activas creadas en el sistema, garantizando un cierre seguro.

          </p>
          <a href="modusalir.php">Leer Más</a>
        </div>
      </div>
    </div>

    <!-- Segunda fila -->
    <div class="container-card">
      <div class="card">
        <figure>
          <img src="https://blog.qwantec.com/hs-fs/hubfs/bloginterno.jpg?width=810&name=bloginterno.jpg" />
        </figure>
        <div class="contenido-card">
          <h3>Modulo de Reporte</h3>
          <p>
          Genera reportes en formato Excel con opciones avanzadas de 
          búsqueda y filtrado para análisis de datos.
          </p>
          <a href="modureporte.php">Leer Más</a>
        </div>
      </div>
      <div class="card">
        <figure>
          <img src="https://upinforma.com/nuevo/images/noticias/719876641Matricula_Primer_ingreso.jpg" />
        </figure>
        <div class="contenido-card">
          <h3>Matricula y Rehabilitacion</h3>
          <p>
          Gestiona el proceso de matrícula y la rehabilitación
           académica de los estudiantes dentro del sistema.
          </p>
          <a href="#">Leer Más</a>
        </div>
      </div>
      <div class="card">
        <figure>
          <img src="https://idc.brightspotcdn.com/dims4/default/ebc58ba/2147483647/resize/800x%3E/quality/90/?url=https%3A%2F%2Fidc.brightspotcdn.com%2Feinfluss%2Fmedia%2F2017%2F01%2F16%2F%2Ffiscal-rmisc.jpg" />
        </figure>
        <div class="contenido-card">
          <h3>Expediente de Estudiantes</h3>
          <p>
          Accede y administra el expediente completo de los estudiantes, 
          incluyendo su rendimiento académico y personal.
          </p>
          <a href="#">Leer Más</a>
        </div>
      </div>
      <div class="card">
        <figure>
          <img src="https://cdn.prod.website-files.com/60a37c162ae6652511906683/645d3184ebca468e1615c4a3_Open%20graph%20ajuste%20contable.png" />
        </figure>
        <div class="contenido-card">
          <h3>Ajuste de Expediente</h3>
          <p>
          Realiza modificaciones y configuraciones dentro del expediente académico 
          de los estudiantes según sea necesario.
          </p>
          <a href="#">Leer Más</a>
        </div>
      </div>
    </div>
    <!--Fin Tarjetas-->
  </body>
</html>
