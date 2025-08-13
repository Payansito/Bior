<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bior - Iniciar Sesión</title>
    <link rel="stylesheet" href="style.css?v=1.5"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
</head>
<body>

<script>
    function iniciarSesion() {
        var usuario = document.getElementById("usuario").value;
        var contrasena = document.getElementById("contrasena").value;

        // Verificar las credenciales en el servidor
        if (usuario === "Bior" && contrasena === "123123") {
            document.body.classList.add("authenticated");
            window.location.href = "index.php";
        } else {
            // Credenciales incorrectas, mostrar mensaje de error
            alert("Credenciales incorrectas. Inténtalo de nuevo.");
        }
    }
</script>

<!-- Formulario de inicio de sesión -->
<div id="loginForm">
    <form id="frmlg">
        <h2 id="singtittle">Iniciar Sesión</h2>
        <label for="usuario" id="singlbl">Usuario:</label>
        <input type="text" id="usuario" name="usuario" required><br>

        <label for="contrasena" id="">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required><br>

        <button type="button" id="singup" onclick="iniciarSesion()">Iniciar Sesión</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
