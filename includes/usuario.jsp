<%@page import="clases.Usuarios" %>
      <%
      	//get attributes from the session
                Usuarios usuario = (Usuarios) session.getAttribute("usuario");

                // handle null values
                if (usuario == null) {
      %>
          	<jsp:forward page="index.jsp" />
        <%  }
      %>