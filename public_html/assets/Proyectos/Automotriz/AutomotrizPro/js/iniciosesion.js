// Obtener el formulario
const form = document.getElementById('inicio-sesion');

// Agregar un evento de escucha para el envío del formulario
form.addEventListener('submit', function(event) {
    event.preventDefault(); // Prevenir el envío por defecto

    // Obtener los valores de usuario y contraseña
    const usuario = document.getElementById('usuario').value;
    const contrasena = document.getElementById('contrasena').value;

    // Validar las credenciales (aquí puedes agregar tu lógica de validación)
    // Por ejemplo, podrías hacer una solicitud a un servidor para verificar las credenciales.

    // Ejemplo básico de validación (debes implementar la validación real)
    if (usuario === 'admin' && contrasena === '123') {
        // Redireccionar a index Juan.html
        window.location.href = 'Index Juan.html';
    } else {
        alert('Usuario o contraseña incorrectos. Por favor, intenta nuevamente.');
    }
});
