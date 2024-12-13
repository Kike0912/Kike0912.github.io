<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <title>Header</title>
  
  <!-- Vinculación a Bootstrap 4 y Font Awesome -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.css">
  <link rel="stylesheet" href="style.css">
  
  <style>
    .menu-container {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin: 20px;
      justify-content: space-between;
    }

    .menu-item {
      flex: 1 1 23%; /* Tamaño relativo para 4 elementos por fila */
      height: 150px;
      background-color: #3498db;
      display: flex;
      justify-content: center;
      align-items: center;
      color: white;
      font-size: 24px;
      cursor: pointer;
      border-radius: 8px;
      transition: background-color 0.3s;
    }

    .menu-item:hover {
      background-color: #2980b9;
    }
  </style>
</head>
<body>
  <!-- Header -->
  <header>
    <nav class="navbar navbar-expand-custom navbar-mainbg">
      <a class="navbar-brand navbar-logo" href="#">Bienvenido, [Nombre]</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars text-white"></i>
      </button>
      
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
          <div class="hori-selector">
            <div class="left"></div>
            <div class="right"></div>
          </div>
          
          <!-- Opciones del menú -->
          <li class="nav-item active">
            <a class="nav-link" href="javascript:void(0);"><i class="fas fa-home"></i>Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="javascript:void(0);"><i class="fas fa-user"></i>Perfil</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="javascript:void(0);"><i class="fas fa-sign-out-alt"></i>Cerrar sesión</a>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- Menú de cuadrados -->
  <div class="menu-container">
    <div class="menu-item">1</div>
    <div class="menu-item">2</div>
    <div class="menu-item">3</div>
    <div class="menu-item">4</div>
    <div class="menu-item">5</div>
    <div class="menu-item">6</div>
    <div class="menu-item">7</div>
    <div class="menu-item">8</div>
  </div>

  <!-- Scripts para Bootstrap -->
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js"></script>
  <script src="./script.js"></script>
</body>
</html>
