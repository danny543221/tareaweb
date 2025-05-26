-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS cocina_db CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Usar la base de datos
USE cocina_db;

-- Crear tabla de usuarios
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(100) NOT NULL UNIQUE,
    clave VARCHAR(255) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Crear tabla de cursos
CREATE TABLE IF NOT EXISTS cursos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    descripcion TEXT,
    fecha_inicio DATE NOT NULL,
    fecha_fin DATE NOT NULL,
    cupo INT NOT NULL DEFAULT 30,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Crear tabla de inscripciones
CREATE TABLE IF NOT EXISTS inscripciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    curso_id INT NOT NULL,
    fecha_inscripcion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    estado ENUM('pendiente', 'confirmado', 'cancelado') DEFAULT 'pendiente',
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (curso_id) REFERENCES cursos(id) ON DELETE CASCADE,
    UNIQUE KEY unico_usuario_curso (usuario_id, curso_id)
);

INSERT INTO cursos (titulo, descripcion, fecha_inicio, fecha_fin, cupo) VALUES
('Panadería Básica', 'Aprende las técnicas esenciales para elaborar pan casero delicioso.', '2025-06-01', '2025-07-01', 25),
('Cocina Vegana', 'Curso completo para preparar platos veganos nutritivos y sabrosos.', '2025-06-15', '2025-07-15', 20),
('Repostería Avanzada', 'Domina técnicas avanzadas para crear postres profesionales.', '2025-07-01', '2025-08-01', 15),
('Cocina Internacional', 'Explora recetas clásicas y modernas de diferentes partes del mundo.', '2025-07-10', '2025-08-10', 30),
('Taller de Salsas y Aderezos', 'Aprende a preparar salsas y aderezos para realzar tus platillos.', '2025-06-20', '2025-07-20', 20);
