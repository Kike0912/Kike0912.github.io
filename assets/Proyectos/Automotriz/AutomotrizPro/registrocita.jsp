<%@ page import="java.sql.*" %>
<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>


<%
    // 1. Obtener los datos del formulario
    String nombre = request.getParameter("nombre");
    String apellido = request.getParameter("apellido");
    String cedula = request.getParameter("cedula");
    String email = request.getParameter("email");
    String fechaCita = request.getParameter("fecha-cita");

    try {
        // 2. Conexión a la base de datos
        Class.forName("oracle.jdbc.driver.OracleDriver"); 
        Connection conn = DriverManager.getConnection("jdbc:oracle:thin:@localhost:1521:XE", "pro10", "123");

        // 3. Preparar la consulta SQL
        String sql = "INSERT INTO cita (id_cita, id_cliente, fecha_solicitud, fecha_asignacion) VALUES (seq_cita.NEXTVAL, ?, ?, ?)";
        PreparedStatement pstmt = conn.prepareStatement(sql);

        // 3.1. Obtener el ID del cliente a partir de la cédula
        int idCliente = -1; // Valor por defecto si no se encuentra el cliente
        String sqlCliente = "SELECT id_cliente FROM cliente WHERE cip = ?";
        PreparedStatement pstmtCliente = conn.prepareStatement(sqlCliente);
        pstmtCliente.setString(1, cedula);
        ResultSet rsCliente = pstmtCliente.executeQuery();
        if (rsCliente.next()) {
            idCliente = rsCliente.getInt("id_cliente");
        }
        rsCliente.close();
        pstmtCliente.close();

        // 3.2. Si el cliente no existe, mostrar un mensaje de error
        if (idCliente == -1) {
            out.println("<script>alert('Cliente no encontrado. Por favor, verifique su cédula.'); window.location.href = 'registrocitas.html';</script>");
            return;
        }

        // 4. Establecer los valores de los parámetros
        pstmt.setInt(1, idCliente);
        pstmt.setDate(2, Date.valueOf(fechaCita)); // Convertir a java.sql.Date
        pstmt.setDate(3, Date.valueOf(fechaCita));

        // 5. Ejecutar la consulta
        pstmt.executeUpdate();

        // 6. Cerrar recursos
        pstmt.close();
        conn.close();

        // 7. Mostrar mensaje de éxito y redireccionar
        out.println("<script>alert('Cita registrada exitosamente.'); window.location.href = 'registrocitas.html';</script>");

    } catch (Exception e) {
        // 8. Manejo de errores
        out.println("Error al registrar la cita: " + e.getMessage());
    }
%>
