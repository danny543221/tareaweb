<?php
    // Definimos los parametros de mi servidor en MySQL para realizar la conexión
    $server = 'localhost:3307';
    $usuario = 'root';
    $contraseña = '';
    $baseDeDatos = 'cocina_db';
    // Manejamos los errores al conectar la base de datos 
    try {
        $conexion = new PDO("mysql:host=$server;dbname=$baseDeDatos;charset=utf8", $usuario, $contraseña);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die('Error en la conexión: ' . $e->getMessage());
    }
?>