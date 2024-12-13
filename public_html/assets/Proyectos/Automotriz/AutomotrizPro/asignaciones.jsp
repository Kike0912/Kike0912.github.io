<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@ page import="java.sql.*" %>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignaciones por Mecánico</title>
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
        <h1>Lista de Asignaciones</h1>
        <hr>
    <table class="info-table">
        <thead>
            <tr>
                <th>ID Asignación</th> 
                <th>Mecánico</th>
                <th>Orden de Trabajo</th>
                <th>Cliente</th>
                <th>Automóvil</th>
                <th>Fecha de Asignación</th>
            </tr>
        </thead>
        <tbody>
        <%
            try (Connection conn = DriverManager.getConnection("jdbc:oracle:thin:@localhost:1521:XE", "pro10", "123")) {
                conn.createStatement().execute("ALTER SESSION SET NLS_LANGUAGE='SPANISH'");

                // Consulta SQL para obtener las asignaciones
                String sql = "SELECT ASIG.ID_MECANICO || '-' || ASIG.ID_ORDEN AS ID_ASIGNACION, " +
                             "M.NOMBRE || ' ' || M.APELLIDO AS NOMBRE_MECANICO, " +
                             "OT.ID_ORDEN, C.NOMBRE || ' ' || C.APELLIDO AS NOMBRE_CLIENTE, " +
                             "AU.MODELO, ASIG.FECHA_ASIGNACION " +
                             "FROM ASIGNACIONES ASIG " +
                             "INNER JOIN MECANICO M ON ASIG.ID_MECANICO = M.ID_MECANICO " +
                             "INNER JOIN ORDEN_TRABAJO OT ON ASIG.ID_ORDEN = OT.ID_ORDEN " +
                             "INNER JOIN CLIENTE C ON OT.ID_CLIENTE = C.ID_CLIENTE " +
                             "INNER JOIN AUTOMOVIL AU ON OT.ID_AUTOMOVIL = AU.ID_AUTOMOVIL"; 

                try (PreparedStatement stmt = conn.prepareStatement(sql);
                     ResultSet rs = stmt.executeQuery()) {

                    while (rs.next()) {
        %>
                        <tr>
                            <td><%= rs.getString("ID_ASIGNACION") %></td> 
                            <td><%= rs.getString("NOMBRE_MECANICO") %></td>
                            <td><%= rs.getInt("ID_ORDEN") %></td>
                            <td><%= rs.getString("NOMBRE_CLIENTE") %></td>
                            <td><%= rs.getString("MODELO") %></td>
                            <td><%= rs.getDate("FECHA_ASIGNACION") %></td>
                        </tr>
        <%
                    } 
                } 
            } catch (SQLException e) {
                out.println("<p style='color:red;'>Error al obtener las asignaciones: " + e.getMessage() + "</p>");
            } 
        %>
        </tbody>
    </table>
</main>

<footer>
    <nav class="main-nav">
        <ul>
            <li><a href="Index Juan.html">Inicio</a></li>
            <li><a href="citas.html">Citas</a></li>
            <li><a href="clientes.html">Clientes</a></li>
            <li><a href="mecanicos.html">Mecánicos</a></li>
            <li><a href="registromecanico.html">Registro de Mecánico</a></li>
            <li><a href="registrocliente.html">Registro de Cliente</a></li>
            <li><a href="registroauto.html">Registro de Auto</a></li>
            <li><a href="soporte.html">Soporte</a></li>
        </ul>
    </nav>
    <p>Todos los derechos reservados © Universidad Tecnológica de Panamá 2024</p>
</footer>
</body>
</html>
