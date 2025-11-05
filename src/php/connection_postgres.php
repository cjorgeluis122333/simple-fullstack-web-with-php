<?php

$host = "localhost";
$port = "9091";
$dbname = "shool_db";
$user = "jcvidal"; // cámbialo si tienes otro usuario
$password = "123456"; // cámbialo

try {
    // Conexión mediante PDO
    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);

    // Activar modo de errores
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Forzar UTF-8
    $conn->exec("SET NAMES 'utf8'");

} catch (PDOException $e) {
    die("Error al conectar con PostgreSQL: " . $e->getMessage());
}

