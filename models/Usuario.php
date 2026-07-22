<?php
require_once __DIR__ . '/../app/core/Database.php';

class Usuario {
    public function obtenerTodosLosUsuarios() {
        $conexion = Database::conectar();
        $stmt = $conexion->query("SELECT * FROM usuarios");
        return $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    }

    public function eliminarUsuario($id) {
        $conexion = Database::conectar();
        $stmt = $conexion->prepare("DELETE FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function actualizarUsuario($id, $nombre, $correo, $rol) {
        $conexion = Database::conectar();
        $stmt = $conexion->prepare("UPDATE usuarios SET usuario = ?, correo = ?, rol = ? WHERE id = ?");
        $stmt->execute([$nombre, $correo, $rol, $id]);
    }
}