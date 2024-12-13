<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@ page import="java.sql.*" %>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Auto</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body id="home">

<%!
    // Función auxiliar para obtener el ID del cliente por su cédula
    private int obtenerIdCliente(Connection conn, String cip) throws SQLException {
        String sql = "SELECT ID_CLIENTE FROM CLIENTE WHERE CIP = ?";
        try (PreparedStatement stmt = conn.prepareStatement(sql)) {
            stmt.setString(1, cip);
            try (ResultSet rs = stmt.executeQuery()) {
                if (rs.next()) {
                    return rs.getInt("ID_CLIENTE");
                } else {
                    throw new SQLException("Cliente no encontrado con cédula: " + cip);
                }
            }
        }
    }
%>

<header>
    <div class="dropdown">
        <button class="dropbtn">&#9776;</button>
        <div class="dropdown-content">
            <a href="Index Juan.html">Inicio</a>
            <a href="registrocliente.html">Registrar Cliente</a>
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

                String propietario = request.getParameter("propietario");
                String modelo = request.getParameter("modelo");
                String marca = request.getParameter("marca");
                String color = request.getParameter("color");
                String matricula = request.getParameter("matricula");

                try {
                    // Conexión a la base de datos
                    Connection conn = DriverManager.getConnection("jdbc:oracle:thin:@localhost:1521:XE", "pro10", "123");
                    conn.createStatement().execute("ALTER SESSION SET NLS_LANGUAGE='SPANISH'"); 

                    // Obtener el ID del cliente
                    int idCliente = obtenerIdCliente(conn, propietario);

                    // Llamada al procedimiento almacenado para registrar el auto
                    String sql = "CALL REGISTRAR_AUTOMOVIL(?, ?, ?, ?, ?)";
                    CallableStatement stmt = conn.prepareCall(sql);

                    // Establecer los parámetros
                    stmt.setInt(1, idCliente);
                    stmt.setString(2, modelo);
                    stmt.setString(3, matricula);
                    stmt.setString(4, marca);
                    stmt.setString(5, color);

                    // Ejecutar la consulta
                    stmt.executeUpdate();

                    // Cerrar la conexión
                    stmt.close();
                    conn.close();

                    out.println("<p style='color:green;'>Auto registrado exitosamente</p>");
                    out.println("<button onclick=\"window.location.href='Index Juan.html'\">Ir a Inicio</button>");

                } catch (SQLException e) {
                    out.println("<p style='color:red;'>Error al registrar el auto: " + e.getMessage() + "</p>");
                    out.println("<button onclick=\"window.location.href='registroauto.html'\">Volver al Formulario</button>");
                }
            }
        %>
    </section>
</main>

<footer>
    </footer>

</body>
</html>
