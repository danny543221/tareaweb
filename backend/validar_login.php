<?php
session_start(); // <-- NECESARIO para usar $_SESSION

require_once 'conexion.php';

// Verificar que llegaron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["correo"], $_POST["clave"])) {
    $correo = trim($_POST["correo"]);
    $clave = $_POST["clave"];

    try {
        // Buscar el usuario por correo
        $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE correo = :correo");
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verificar la contraseña
            if (password_verify($clave, $usuario['clave'])) {
                // Inicio de sesión exitoso
                $_SESSION["usuario_id"] = $usuario["id"];
                $_SESSION["nombre"] = $usuario["nombre"];
                
                // Redirigir a cursos.php
                header("Location: ../cursos.php");
                exit();
            } else {
                echo "<p style='color: red;'>Contraseña incorrecta. <a href='login.php'>Intentar de nuevo</a></p>";
            }
        } else {
            echo "<p style='color: red;'>Correo no registrado. <a href='login.php'>Intentar de nuevo</a></p>";
        }
    } catch (PDOException $e) {
        echo "Error al iniciar sesión: " . $e->getMessage();
    }
} else {
    echo "<p style='color: red;'>Por favor completa todos los campos. <a href='login.php'>Volver</a></p>";
}
?>
