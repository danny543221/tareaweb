<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Iniciar Sesión - Cursos de Cocina</title>
  <link rel="stylesheet" href="./css/sesion.css">
</head>
<body>
  <div class="tarjeta">
    <h2>Iniciar Sesión</h2>
    <form action="./backend/validar_login.php" method="POST">
      <input type="email" name="correo" placeholder="Correo electrónico" required>
      <input type="password" name="clave" placeholder="Contraseña" required>
      <button type="submit" class="boton">Entrar</button>
    </form>
    <p><a href="registro.php">¿No tienes cuenta? Regístrate</a></p>
    <br>
    <a href="index.html"><button class="boton">Volver al inicio</button></a>
  </div>
</body>
</html>
