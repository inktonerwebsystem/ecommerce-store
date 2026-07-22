<?php
require_once __DIR__ . '/../app/core/Database.php';

class Producto {
    public function obtenerProductos() {
        $conexion = Database::conectar();
        $stmt = $conexion->query("SELECT * FROM productos");
        return $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    }

    public function eliminarProducto($id) {
        $conexion = Database::conectar();
        // Elimina reseñas asociadas
        $stmt = $conexion->prepare("DELETE FROM reseñas WHERE producto_id = ?");
        $stmt->execute([$id]);
        // Ahora elimina el producto
        $stmt = $conexion->prepare("DELETE FROM productos WHERE id = ?");
        $stmt->execute([$id]);
    }

    // CORREGIDO: ahora incluye descripción
    public function agregarProducto($nombre, $precio, $stock, $ubicacion, $imagen, $descripcion) {
        $conexion = Database::conectar();
        $stmt = $conexion->prepare("INSERT INTO productos (nombre, precio, stock, ubicacion, imagen, descripcion) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nombre, $precio, $stock, $ubicacion, $imagen, $descripcion]);
    }

    public function obtenerProductoPorId($id) {
        $conexion = Database::conectar();
        $stmt = $conexion->prepare("SELECT * FROM productos WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function aplicarDescuento($id, $descuento) {
        $conexion = Database::conectar();
        $promocion = ($descuento > 0) ? 1 : 0;
        $stmt = $conexion->prepare("UPDATE productos SET descuento = ?, promocion = ? WHERE id = ?");
        $stmt->execute([$descuento, $promocion, $id]);
    }

    public function actualizarProducto($id, $nombre, $precio, $stock, $ubicacion) {
        $conexion = Database::conectar();
        $stmt = $conexion->prepare("UPDATE productos SET nombre = ?, precio = ?, stock = ?, ubicacion = ? WHERE id = ?");
        $stmt->execute([$nombre, $precio, $stock, $ubicacion, $id]);
    }

    public function obtenerProductosPorSeccion($seccion) {
        $db = Database::conectar();
        $stmt = $db->prepare("SELECT * FROM productos WHERE ubicacion LIKE ?");
        $like = "%$seccion%";
        $stmt->execute([$like]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
