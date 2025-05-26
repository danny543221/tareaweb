<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registrarse - Cursos de Cocina</title>
  <link rel="stylesheet" href="./css/sesion.css">
</head>
<body>
  <div class="tarjeta">
    <h2>Registrarse</h2>
    <form action="./backend/validar_registro.php" method="POST">
      <input type="text" name="nombre" placeholder="Nombre completo" required>
      <input type="email" name="correo" placeholder="Correo electrónico" required>
      <input type="password" name="clave" placeholder="Contraseña" required>
      <button type="submit" class="boton">Crear cuenta</button>
    </form>
    <p><a href="login.php">¿Ya tienes una cuenta? Inicia sesión</a></p>
    <br>
    <a href="index.html"><button class="boton">Volver al inicio</button></a>
  </div>
</body>
</html>
