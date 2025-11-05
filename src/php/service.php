<?php
require_once "connection_postgres.php";

// 🔹 Insertar usuario
function insertarUsuario($nombre, $correo, $rol) {
    global $conn;
    $sql = "INSERT INTO usuarios (nombre, correo, rol) VALUES (:nombre, :correo, :rol)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':rol', $rol);
    return $stmt->execute();
}

// 🔹 Obtener todos los usuarios
function obtenerUsuarios() {
    global $conn;
    $stmt = $conn->query("SELECT * FROM usuarios ORDER BY id");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// 🔹 Eliminar usuario por ID
function eliminarUsuario($id) {
    global $conn;
    $sql = "DELETE FROM usuarios WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
}

