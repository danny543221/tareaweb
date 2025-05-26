<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit();
}

// Incluir conexión a la base de datos
require_once './backend/conexion.php';

try {
    // Consultar cursos disponibles
    $stmt = $conexion->prepare("SELECT * FROM cursos ORDER BY fecha_inicio ASC");
    $stmt->execute();
    $cursos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener cursos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Cursos Disponibles</title>
    <link rel="stylesheet" href="./css/cursos.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />
</head>
<body>
    <header class="encabezado">
        <h1>Bienvenido/a, <?php echo htmlspecialchars($_SESSION["nombre"]); ?> 👩‍🍳</h1>
        <a href="./backend/logout.php" class="boton-cerrar">Cerrar sesión</a>
    </header>

    <main class="cursos-contenedor">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2>Cursos Disponibles</h2>
            <a href="mis_cursos.php" class="boton-inscribirse" style="padding: 10px 20px; font-size: 1em;">Mis Cursos</a>
        </div>

        <div class="cursos-grid">
            <?php if (count($cursos) > 0): ?>
                <?php foreach ($cursos as $curso): ?>
                    <div class="curso-card">
                        <h3><?php echo htmlspecialchars($curso['titulo']); ?></h3>
                        <p><?php echo htmlspecialchars($curso['descripcion']); ?></p>
                        <p><strong>Inicio:</strong> <?php echo date('d M Y', strtotime($curso['fecha_inicio'])); ?></p>
                        <p><strong>Fin:</strong> <?php echo date('d M Y', strtotime($curso['fecha_fin'])); ?></p>
                        <p><strong>Cupo:</strong> <?php echo intval($curso['cupo']); ?></p>
                        <form method="post" action="./backend/inscribir.php">
                            <input type="hidden" name="curso_id" value="<?php echo intval($curso['id']); ?>" />
                            <button type="submit" class="boton-inscribirse">Inscribirse</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No hay cursos disponibles en este momento.</p>
            <?php endif; ?>
        </div>
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
<?php if (isset($_SESSION['mensaje'])): ?>
    <div class="mensaje">
        <?php 
            echo htmlspecialchars($_SESSION['mensaje']);
            unset($_SESSION['mensaje']);
        ?>
    </div>
<?php endif; ?>

</html>
