<?php
require_once __DIR__ . '/../models/Producto.php';
$productoModel = new Producto();

$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? null;

if ($action === 'edit' && $id) {
    // Aquí iría la lógica para mostrar el formulario de edición y guardar cambios
    // Ejemplo: $productoModel->editarProducto($id, $_POST);
    header("Location: /velora-mvc/app/views/editar_producto.php?id=$id");
    exit();
}

if ($action === 'delete' && $id) {
    $productoModel->eliminarProducto($id);
    header("Location: /velora-mvc/views/p.administrador.php");
    exit();
}