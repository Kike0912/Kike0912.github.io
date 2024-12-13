<?php
// Incluir la conexión a la base de datos
require_once 'db.php';

// Iniciar sesión si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = trim($_POST['correo']);
    $contrasena = trim($_POST['contrasena']);

    // Conexión a la base de datos
    $db = new Database();
    $conn = $db->connect();

    try {
        // Verificar si el usuario existe
        $stmt = $conn->prepare("SELECT id, nombre, correo, contrasena FROM usuarios WHERE correo = :correo");
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Verificar contraseña
            if (password_verify($contrasena, $user['contrasena'])) {
                // Inicio de sesión exitoso
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['nombre'] = $user['nombre'];
                $_SESSION['correo'] = $user['correo'];

                header("Location: index.html"); // Cambiar a tu página protegida
                exit();
            } else {
                $error = "Contraseña incorrecta.";
            }
        } else {
            $error = "Usuario no encontrado.";
        }
    } catch (PDOException $e) {
        $error = "Error al iniciar sesión: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Login Form</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
  <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900|RobotoDraft:400,100,300,500,700,900'>
  <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>
  <style>
    body {
      background: #333333; /* Gris oscuro */
      color: #e9e9e9; /* Gris claro */
      font-family: "RobotoDraft", "Roboto", sans-serif;
      font-size: 14px;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
    }

    /* Pen Title */
    .pen-title {
      padding: 50px 0;
      text-align: center;
      letter-spacing: 2px;
    }
    .pen-title h1 {
      margin: 0 0 20px;
      font-size: 48px;
      font-weight: 300;
      color: #ec8626; /* Anaranjado */
    }
    .pen-title span {
      font-size: 12px;
    }
    .pen-title span .fa {
      color: #ec8626; /* Anaranjado */
    }
    .pen-title span a {
      color: #ec8626; /* Anaranjado */
      font-weight: 600;
      text-decoration: none;
    }

    /* Form Module */
    .form-module {
      position: relative;
      background: #555555; /* Gris oscuro */
      max-width: 320px;
      width: 100%;
      border-top: 5px solid #ec8626; /* Anaranjado */
      box-shadow: 0 0 3px rgba(0, 0, 0, 0.1);
      margin: 0 auto;
    }
    .form-module .toggle {
      cursor: pointer;
      position: absolute;
      top: 0;
      right: 0;
      background: #ec8626; /* Anaranjado */
      width: 30px;
      height: 30px;
      margin: -5px 0 0;
      color: #000;
      font-size: 12px;
      line-height: 30px;
      text-align: center;
    }
    .form-module .toggle .tooltip {
      position: absolute;
      top: 5px;
      right: -65px;
      display: block;
      background: rgba(0, 0, 0, 0.006);
      width: auto;
      padding: 5px;
      font-size: 10px;
      line-height: 1;
      text-transform: uppercase;
    }
    .form-module .toggle .tooltip:before {
      content: "";
      position: absolute;
      top: 5px;
      left: -5px;
      display: block;
      border-top: 5px solid transparent;
      border-bottom: 5px solid transparent;
      border-right: 5px solid rgba(0, 0, 0, 0.6);
    }
    .form-module .form {
      display: none;
      padding: 40px;
    }
    .form-module .form:nth-child(2) {
      display: block;
    }
    .form-module h2 {
      margin: 0 0 20px;
      color: #ec8626; /* Anaranjado */
      font-size: 18px;
      font-weight: 400;
      line-height: 1;
    }
    .form-module input {
  outline: none;
  display: block;
  width: 100%;
  border: 1px solid #666666; /* Gris oscuro */
  margin: 0 0 20px;
  padding: 10px 15px;
  box-sizing: border-box;
  font-weight: 700; /* Negrita */
  color: #000; /* Negro */
  transition: 0.3s ease;
  background-color: #fff; /* Fondo blanco */
}

    .form-module input:focus {
      border: 1px solid #ec8626; /* Anaranjado */
      color: #000; /* Blanco */
    }
    .form-module button {
      cursor: pointer;
      background: #ec8626; /* Anaranjado */
      width: 100%;
      border: 0;
      padding: 10px 15px;
      color: #000; /* Blanco */
      transition: 0.3s ease;
    }
    .form-module button:hover {
      background: #ff7b3a; /* Anaranjado más claro */
    }
    .form-module .cta {
      background: #444444; /* Gris más oscuro */
      width: 100%;
      padding: 15px 40px;
      box-sizing: border-box;
      color: #e9e9e9; /* Gris claro */
      font-size: 12px;
      text-align: center;
    }
    .form-module .cta a {
      color: #e9e9e9; /* Gris claro */
      text-decoration: none;
    }
  </style>
</head>
<body>
  <!-- Formulario de inicio de sesión -->
  <div class="pen-title">
    <h1>Inicio de Sesión </h1><span>Bienvenido a HumanityQ</span>
  </div>
  <div class="module form-module">
    <div class="toggle"><i class="fa fa-times fa-pencil"></i>
      <div class="tooltip"></div>
    </div>
    <div class="form">
      <h2>Inicia sesión con tu cuenta</h2>
      <!-- Formulario que ahora usa los valores de la base de datos -->
      <form method="POST" action="">
        <input type="email" name="correo" placeholder="Correo" value="<?php echo isset($correo) ? htmlspecialchars($correo) : ''; ?>" required />
        <input type="password" name="contrasena" placeholder="Contraseña" required />
        <button type="submit">Iniciar sesión</button>
      </form>
      <!-- Mensaje de error -->
      <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
      <?php endif; ?>
    </div>
    <div class="cta"><a href="http://andytran.me">¿Olvidaste tu contraseña?</a></div>
  </div>

  <script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <script src='https://codepen.io/andytran/pen/vLmRVp.js'></script>
  <script  src="./scriptlogin.js"></script>
</body>
</html>
