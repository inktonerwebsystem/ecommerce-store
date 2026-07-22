<?php
// filepath: c:\xampp1\htdocs\velora-mvc\controllers\guardar_reseña.php
session_start();
require_once __DIR__ . '/../app/core/Database.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $producto_id = intval($_POST['producto_id'] ?? 0);
    $estrellas = intval($_POST['estrellas'] ?? 0);

    if ($producto_id > 0 && $estrellas >= 1 && $estrellas <= 5) {
        $conexion = Database::conectar();
        // Puedes ajustar el usuario según tu sistema de login
        $usuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : 'Invitado';
        $stmt = $conexion->prepare("INSERT INTO reseñas (producto_id, usuario, estrellas, comentario) VALUES (?, ?, ?, '')");
        $stmt->execute([$producto_id, $usuario, $estrellas]);
        echo json_encode(['success' => true]);
        exit;
    }
}
echo json_encode(['success' => false]);
exit;