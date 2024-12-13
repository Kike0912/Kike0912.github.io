<?php
// Evitar que la página se guarde en la caché del navegador
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Expiración en 0.
session_start(); // Iniciar sesión si es que no se ha iniciado.
?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css'>
  <link rel='stylesheet' href='https://unicons.iconscout.com/release/v2.1.9/css/unicons.css'>
  <link rel="stylesheet" href="Style.login.css">
</head>
<body>
<!-- partial:index.partial.html -->

  <div class="section">
    <div class="container">
      <div class="row full-height justify-content-center">
        <div class="col-12 text-center align-self-center py-5">
          <div class="section pb-5 pt-5 pt-sm-2 text-center">
            <h6 class="mb-0 pb-3"><span>Iniciar Sesión</span><span>Registrarse</span></h6>
            <input class="checkbox" type="checkbox" id="reg-log" name="reg-log"/>
            <label for="reg-log"></label>
            <div class="card-3d-wrap mx-auto">
              <div class="card-3d-wrapper">
                <div class="card-front">
                  <div class="center-wrap">
                    <div class="section text-center">
                      <h4 class="mb-4 pb-3">Iniciar Sesión</h4>
                      <form action="procesar_login.php" method="POST"> <!-- Aquí va la acción para login -->
                        <div class="form-group">
                          <input type="text" name="usuarioInicio" class="form-style" placeholder="Nombre de Usuario" id="usuarioInicio" autocomplete="off">
                          <i class="input-icon uil uil-user"></i>
                        </div>  
                        <div class="form-group mt-2">
                          <input type="password" name="contrasenaInicio" class="form-style" placeholder="Contraseña" id="contrasenaInicio" autocomplete="off">
                          <i class="input-icon uil uil-lock-alt"></i>
                        </div>
                        <button type="submit" class="btn mt-4">Enviar</button> <!-- Cambié el enlace a un botón -->
                      </form>
                      <p class="mb-0 mt-4 text-center"><a href="#0" class="link">¿Olvidaste tu contraseña?</a></p>
                    </div>
                  </div>
                </div>
                <div class="card-back">
                  <div class="center-wrap">
                    <div class="section text-center">
                      <h4 class="mb-4 pb-3">Registrarse</h4>
                      <form action="procesar_registro.php" method="POST"> <!-- Aquí va la acción para registro -->
                        <div class="form-group">
                          <input type="email" name="correoRegistro" class="form-style" placeholder="Correo Electrónico" id="correoRegistro" autocomplete="off">
                          <i class="input-icon uil uil-at"></i>
                        </div>  
                        <div class="form-group mt-2">
                          <input type="text" name="nombreCompletoRegistro" class="form-style" placeholder="Nombre Completo" id="nombreCompletoRegistro" autocomplete="off">
                          <i class="input-icon uil uil-user"></i>
                        </div>
                        <div class="form-group mt-2">
                          <input type="text" name="nombreUsuarioRegistro" class="form-style" placeholder="Nombre de Usuario" id="nombreUsuarioRegistro" autocomplete="off">
                          <i class="input-icon uil uil-user-circle"></i>
                        </div>
                        <div class="form-group mt-2">
                          <input type="password" name="contrasenaRegistro" class="form-style" placeholder="Contraseña" id="contrasenaRegistro" autocomplete="off">
                          <i class="input-icon uil uil-lock-alt"></i>
                        </div>
                        <button type="submit" class="btn mt-4">Enviar</button> <!-- Cambié el enlace a un botón -->
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<!-- partial -->
  <script src="./script.js"></script>

</body>
</html>
