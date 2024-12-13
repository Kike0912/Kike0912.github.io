<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@ page import="java.sql.*" %>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Mecánico</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body id="home">

<%!
    // Funciones auxiliares (adaptadas para MECANICO)
    private int obtenerIdProvincia(Connection conn, String nombreProvincia) throws SQLException {
        String sql = "SELECT ID_PROVINCIA FROM PROVINCIA WHERE NOMBRE = ?";
        try (PreparedStatement stmt = conn.prepareStatement(sql)) {
            stmt.setString(1, nombreProvincia);
            try (ResultSet rs = stmt.executeQuery()) {
                if (rs.next()) {
                    return rs.getInt("ID_PROVINCIA");
                } else {
                    throw new SQLException("Provincia no encontrada: " + nombreProvincia);
                }
            }
        }
    }

    private int obtenerIdTipoTelefono(Connection conn) throws SQLException {
        return 10001; // Asumiendo "Celular" como tipo por defecto
    }

    private int obtenerIdTipoEmail(Connection conn) throws SQLException {
        return 10001; // Asumiendo "Personal" como tipo por defecto
    }
%>

<header>
    <div class="dropdown">
        <button class="dropbtn">&#9776;</button>
        <div class="dropdown-content">
            <a href="Index Juan.html">Inicio</a>
            <a href="registrocliente.html">Registrar Cliente</a>
            <a href="clientes.html">Lista de Clientes</a>
            <a href="registromecanico.html">Registrar Mecánico</a>
            <a href="mecanicos.html">Lista de Mecánicos</a>
            </div>
    </div>
    <div class="header-content">
        <img src="images/con_fondo-removebg-preview (2).png" alt="Logo Juan Mecanico" class="logo">
    </div>
</header>

<main>
    <section class="form-content">
        <h2>Resultado del Registro</h2>
        <%
            if (request.getMethod().equalsIgnoreCase("POST")) {
                request.setCharacterEncoding("UTF-8");

                String nombre = request.getParameter("nombre");
                String apellido = request.getParameter("apellido");
                String cedula = request.getParameter("cedula");
                String email = request.getParameter("email");
                String provincia = request.getParameter("provincia");
                String ciudad = request.getParameter("ciudad");
                String barrio = request.getParameter("barrio");
                String telefono = request.getParameter("telefono"); 

                try {
                    // Conexión a la base de datos
                    Connection conn = DriverManager.getConnection("jdbc:oracle:thin:@localhost:1521:XE", "pro10", "123");
                    conn.createStatement().execute("ALTER SESSION SET NLS_LANGUAGE='SPANISH'");

                    // Llamada al procedimiento almacenado para registrar mecánico (REGISTRAR_MECANICO)
                    String sql = "CALL REGISTRAR_MECANICO(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    CallableStatement stmt = conn.prepareCall(sql);

                    // Establecer los parámetros (similar a AGREGAR_CLIENTE, pero para MECANICO)
                    stmt.setString(1, nombre);
                    stmt.setString(2, apellido);
                    stmt.setString(3, cedula);
                    stmt.setString(4, barrio); 
                    stmt.setString(5, ciudad);
                    stmt.setInt(6, obtenerIdProvincia(conn, provincia));
                    stmt.setString(7, telefono);
                    stmt.setString(8, email);
                    stmt.setInt(9, obtenerIdTipoTelefono(conn));
                    stmt.setInt(10, obtenerIdTipoEmail(conn));

                    // Ejecutar la consulta
                    stmt.executeUpdate();

                    // Cerrar la conexión
                    stmt.close();
                    conn.close();

                    out.println("<p style='color:green;'>Mecánico registrado exitosamente</p>");
                    out.println("<button onclick=\"window.location.href='Index Juan.html'\">Ir a Inicio</button>");

                } catch (SQLException e) {
                    out.println("<p style='color:red;'>Error al registrar el mecánico: " + e.getMessage() + "</p>");
                    out.println("<button onclick=\"window.location.href='registromecanico.html'\">Volver al Formulario</button>");
                }
            }
        %>

    </section>
</main>
<footer>
    </footer>

</body>
</html>
