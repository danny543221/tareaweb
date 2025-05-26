<?php
// Conexión a la base de datos
require_once 'conexion.php';

// Verificar que se enviaron todos los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nombre"], $_POST["correo"], $_POST["clave"])) {
    $nombre = trim($_POST["nombre"]);
    $correo = trim($_POST["correo"]);
    $clave = password_hash($_POST["clave"], PASSWORD_DEFAULT); // Encriptar la contraseña

    try {
        // Preparar la inserción
        $sql = "INSERT INTO usuarios (nombre, correo, clave) VALUES (:nombre, :correo, :clave)";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':clave', $clave);
        $stmt->execute();

        // Redirigir con mensaje de éxito
        header("Location: ../login.php?registro=exitoso");
        exit();
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo "<p style='color: red;'>El correo ya está registrado. <a href='registro.php'>Volver</a></p>";
        } else {
            echo "Error al registrar usuario: " . $e->getMessage();
        }
    }
} else {
    echo "<p style='color: red;'>Datos incompletos. <a href='registro.php'>Volver</a></p>";
}
?>
