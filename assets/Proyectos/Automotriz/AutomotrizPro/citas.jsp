<%@ page import="java.sql.*" %>
<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juan Mecanico - Calendario</title>
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
    <div class="calendar-container">
        <div id="calendar"></div>
    </div>
</main>

<footer>
    <nav class="main-nav">
        <ul>
            <li><a href="Index Juan.html">Inicio</a></li>
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

<script src="js/calendario.js"></script>

<%
    try {
        // Conexión a la base de datos
        Class.forName("oracle.jdbc.driver.OracleDriver"); 
        Connection conn = DriverManager.getConnection("jdbc:oracle:thin:@localhost:1521:XE", "pro10", "123");

        // Consulta para obtener las citas
        String sql = "SELECT c.fecha_asignacion AS fecha, cl.nombre || ' ' || cl.apellido AS cliente, 'Servicio' AS servicio, '10:00' AS hora " +
                     "FROM cita c " +
                     "JOIN cliente cl ON c.id_cliente = cl.id_cliente";
        PreparedStatement pstmt = conn.prepareStatement(sql);
        ResultSet rs = pstmt.executeQuery();

        // Construir un JSON con las citas
        StringBuilder citasJson = new StringBuilder();
        citasJson.append("[");
        boolean first = true;
        while (rs.next()) {
            if (!first) {
                citasJson.append(",");
            }
            citasJson.append("{");
            citasJson.append("\"date\":\"").append(rs.getDate("fecha")).append("\",");
            citasJson.append("\"time\":\"").append(rs.getString("hora")).append("\",");
            citasJson.append("\"client\":\"").append(rs.getString("cliente")).append("\",");
            citasJson.append("\"service\":\"").append(rs.getString("servicio")).append("\"");
            citasJson.append("}");
            first = false;
        }
        citasJson.append("]");

        rs.close();
        pstmt.close();
        conn.close();
 %>
    <script>
        var citas = <%= citasJson.toString() %>;
        cargarCitas(citas);
    </script>
<%
    } catch (Exception e) {
        out.println("Error al obtener las citas: " + e.getMessage());
    }
%>

</body>
</html>
