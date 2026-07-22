<?php
require_once __DIR__ . '/../models/Usuario.php';
$usuarioModel = new Usuario();

$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? null;

if ($action === 'edit' && $id) {
    // Aquí iría la lógica para mostrar el formulario de edición y guardar cambios
    // Ejemplo: $usuarioModel->editarUsuario($id, $_POST);
    header("Location: /velora-mvc/app/views/editar_usuario.php?id=$id");
    exit();
}

if ($action === 'delete' && $id) {
    $usuarioModel->eliminarUsuario($id);
    header("Location: /velora-mvc/views/p.administrador.php");
    exit();
}