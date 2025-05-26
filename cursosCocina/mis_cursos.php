<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit();
}

require_once './backend/conexion.php';

try {
    // Obtener los cursos a los que el usuario está inscrito
    $stmt = $conexion->prepare("
        SELECT c.*
        FROM cursos c
        INNER JOIN inscripciones i ON c.id = i.curso_id
        WHERE i.usuario_id = :usuario_id
        ORDER BY c.fecha_inicio ASC
    ");
    $stmt->bindParam(':usuario_id', $_SESSION['usuario_id'], PDO::PARAM_INT);
    $stmt->execute();
    $cursos_inscritos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener cursos inscritos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Mis Cursos</title>
    <link rel="stylesheet" href="./css/cursos.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />
</head>
<body>
    <header class="encabezado">
        <h1>Mis Cursos, <?php echo htmlspecialchars($_SESSION["nombre"]); ?> 👩‍🍳</h1>
        <a href="./backend/logout.php" class="boton-cerrar">Cerrar sesión</a>
    </header>

    <main class="cursos-contenedor">
        <div style="margin-bottom: 20px;">
            <a href="cursos.php" class="boton-inscribirse" style="padding: 10px 20px; font-size: 1em;">Volver a Cursos</a>
        </div>

        <?php if (count($cursos_inscritos) > 0): ?>
            <div class="cursos-grid">
                <?php foreach ($cursos_inscritos as $curso): ?>
                    <div class="curso-card">
                        <h3><?php echo htmlspecialchars($curso['titulo']); ?></h3>
                        <p><?php echo htmlspecialchars($curso['descripcion']); ?></p>
                        <p><strong>Inicio:</strong> <?php echo date('d M Y', strtotime($curso['fecha_inicio'])); ?></p>
                        <p><strong>Fin:</strong> <?php echo date('d M Y', strtotime($curso['fecha_fin'])); ?></p>
                        <p><strong>Cupo:</strong> <?php echo intval($curso['cupo']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>No estás inscrito en ningún curso aún.</p>
        <?php endif; ?>
    </main>
    <script>
        window.addEventListener('pageshow', function(event) {
        if (event.persisted) {
            // Si la página se carga desde la caché (por ejemplo al dar atrás),
            // forzamos una recarga suave para evitar problemas.
            window.location.reload();
            }
        });
    </script>
</body>
</html>
