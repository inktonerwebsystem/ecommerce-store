<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<?php
$rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : 'visitante';

$mensaje = '';
if ($rol === 'visitante') {
    $mensaje = 'Bienvenido a Velora, explora como visitante.';
} elseif ($rol === 'usuario') {
    $mensaje = 'Bienvenido a Velora, disfruta tu experiencia.';
} elseif ($rol === 'administrador') {
    $mensaje = 'Bienvenido a Velora, ahora tienes el control';
}

require_once __DIR__ . '/app/core/Router.php';

Router::run();
