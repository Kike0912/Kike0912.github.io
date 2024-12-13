<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="card">
            <h1 class="card-title">Iniciar sesión</h1>
            <p class="card-description">Ingresa tu correo electrónico a continuación para iniciar sesión en tu cuenta.</p>
            <form class="login-form">
                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input id="email" type="email" placeholder="ejemplo@dominio.com" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input id="password" type="password" required>
                </div>
                <button type="submit">Iniciar sesión</button>
            </form>
            <footer class="card-footer">
                <p>¿No tienes una cuenta? <a href="#" class="register-link">Regístrate aquí</a></p>
            </footer>
        </div>
    </div>
</body>
</html>
