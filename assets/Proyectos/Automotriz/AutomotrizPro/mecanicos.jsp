<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@ page import="java.sql.*" %>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Información</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body id="home">
    <header>
        <div class="header-content">
            <img src="images/con_fondo-removebg-preview (1).png" alt="Logo Juan Mecanico" class="logo">
            <div class="contact-info">Contactanos: 1234-5678  /  5678-1234</div>
            <div class="hours">Horario de atención: lunes a sábado de 8:00 am a 6:00 pm</div>
        </div>
        <div class="dropdown">
            <button class="dropbtn">&#9776; Opciones</button>
            <div class="dropdown-content">
                <a href="Index Juan.html">Inicio</a>
                <a href="clientes.jsp">Lista de Clientes</a>
                <a href="mecanicos.jsp">Lista de Mecánicos</a>
                <a href="registroauto.html">Registrar Nuevo Auto</a>
                <a href="autos.jsp">Consultar Lista de Autos</a>
                <a href="citas.jsp">Consultar Calendario de Citas</a>
                <a href="asignaciones.jsp">Asignaciones por Mecánico</a>
                <a href="ordenes.jsp">Órdenes de Trabajo</a>
                <a href="home.html">Cerrar Sesión</a>
            </div>
        </div>
    </header>

<main>
    <a href="javascript:history.back()" class="back-arrow">< Volver</a>
    <h1>Mecanicos</h1>
    <button class="Agregar" onclick="window.location.href = 'registromecanico.html';">
        Agregar Mecanico <!-- Botón para agregar un nuevo cliente -->
    </button>
    <hr>
    <table class="info-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Cédula</th>
                <th>Correo</th>
                <th>Número de Teléfono</th>
                <th>Provincia</th>
                <th>Ciudad</th>
                <th>Barrio</th>
            </tr>
        </thead>
        <tbody>
        <%
            try (Connection conn = DriverManager.getConnection("jdbc:oracle:thin:@localhost:1521:XE", "pro10", "123")) {
                conn.createStatement().execute("ALTER SESSION SET NLS_LANGUAGE='SPANISH'");

                String sql = "SELECT M.*, P.NOMBRE AS NOMBRE_PROVINCIA, MT.NUM_TELEFONO, ME.EMAIL " +
                             "FROM MECANICO M " +
                             "LEFT JOIN PROVINCIA P ON M.ID_PROVINCIA = P.ID_PROVINCIA " +
                             "LEFT JOIN MECANICO_TEL MT ON M.ID_MECANICO = MT.ID_MECANICO " +
                             "LEFT JOIN MECANICO_EMAIL ME ON M.ID_MECANICO = ME.ID_MECANICO";

                try (PreparedStatement stmt = conn.prepareStatement(sql);
                     ResultSet rs = stmt.executeQuery()) {

                    while (rs.next()) {
        %>
                        <tr>
                            <td><%= rs.getInt("ID_MECANICO") %></td>
                            <td><%= rs.getString("NOMBRE") %></td>
                            <td><%= rs.getString("APELLIDO") %></td>
                            <td><%= rs.getString("CIP") %></td>
                            <td><%= rs.getString("EMAIL") %></td>
                            <td><%= rs.getString("NUM_TELEFONO") %></td>
                            <td><%= rs.getString("NOMBRE_PROVINCIA") %></td>
                            <td><%= rs.getString("CIUDAD") %></td>
                            <td><%= rs.getString("BARRIADA") %></td>
                        </tr>
        <%
                    }
                }
            } catch (SQLException e) {
                out.println("<p style='color:red;'>Error al obtener los mecánicos: " + e.getMessage() + "</p>");
            }
        %>
        </tbody>
    </table>
</main>
<footer>
    <nav class="main-nav">
        <ul>
            <li><a href="Index Juan.html">inicio</a></li>
            <li><a href="citas.html">Citas</a></li>
            <li><a href="clientes.html">Clientes</a></li>
            <li><a href="mecanicos.html">Mecanicos</a></li>
            <li><a href="registromecanico.html">Registro Mecanico</a></li>
            <li><a href="registrocliente.html">Registro de Cliente</a></li>
            <li><a href="registroauto.html">Registro de Auto</a></li>
            <li><a href="soporte.html">Soporte</a></li>
        </ul>
    </nav>
    <p>Todos los derechos reservados © Universidad Tecnologica de Panama 2024</p>
</footer>
</body>
</html>