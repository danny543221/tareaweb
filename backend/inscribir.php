<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit();
}

// Verificar que el curso_id venga por POST
if (!isset($_POST['curso_id']) || empty($_POST['curso_id'])) {
    die("ID de curso inválido.");
}

require_once 'conexion.php';

$usuario_id = $_SESSION["usuario_id"];
$curso_id = intval($_POST['curso_id']);

try {
    // Verificar si ya está inscrito
    $stmt = $conexion->prepare("SELECT COUNT(*) FROM inscripciones WHERE usuario_id = :usuario_id AND curso_id = :curso_id");
    $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
    $stmt->bindParam(':curso_id', $curso_id, PDO::PARAM_INT);
    $stmt->execute();
    $ya_inscrito = $stmt->fetchColumn();

    if ($ya_inscrito) {
        $_SESSION['mensaje'] = "Ya estás inscrito en este curso.";
        header("Location: ../cursos.php");
        exit();
    }

    // Insertar inscripción
    $stmt = $conexion->prepare("INSERT INTO inscripciones (usuario_id, curso_id, fecha_inscripcion) VALUES (:usuario_id, :curso_id, NOW())");
    $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
    $stmt->bindParam(':curso_id', $curso_id, PDO::PARAM_INT);
    $stmt->execute();

    $_SESSION['mensaje'] = "Inscripción exitosa.";
    header("Location: ../cursos.php");
    exit();

} catch (PDOException $e) {
    die("Error en la inscripción: " . $e->getMessage());
}
