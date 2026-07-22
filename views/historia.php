<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../models/Producto.php';
$productoModel = new Producto();
$productos = $productoModel->obtenerProductos();

function tieneUbicacion($producto, $ubicacionBuscada) {
    $ubicaciones = array_map('trim', explode(',', $producto['ubicacion']));
    return in_array($ubicacionBuscada, $ubicaciones);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Historia | Velora</title>
  <link rel="stylesheet" href="/velora-mvc/public/css/nuevo.css">
  <link rel="stylesheet" href="/velora-mvc/public/css/navbar.css">
  <link rel="stylesheet" href="/velora-mvc/public/css/footer.css">
  <link rel="stylesheet" href="/velora-mvc/public/css/carrito.css">
  <link rel="stylesheet" href="/velora-mvc/public/css/reseñas.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<header style="text-align: center; padding: 20px 0;">
  <a href="/velora-mvc/views/index.php" style="display: inline-block;">
    <img src="/velora-mvc/public/img/logo.png" alt="Velora" style="height: 70px; display: block; margin: 0 auto;">
  </a>
</header>
  
  <nav class="navbar">
<ul class="menu" style="display:flex; justify-content:center; width:100%; padding:0; margin:0;">
  <li><a href="/velora-mvc/views/nuevos.php">Nuevos</a></li>
  <li><a href="/velora-mvc/views/notables.php">Notables</a></li>
  <li><a href="/velora-mvc/views/productos.php">Productos</a></li>
  <li><a href="/velora-mvc/views/tiendas.php">Tiendas</a></li>
  <li><a href="/velora-mvc/views/club.php">Club</a></li>
</ul>
    <?php $rol = $_SESSION['rol'] ?? 'visitante'; ?>
    <ul class="iconos">
      <?php if ($rol === 'administrador'): ?>
        <li>
          <a href="/velora-mvc/views/p.administrador.php" title="Administrador">
            <img src="/velora-mvc/public/iconos/user.svg" alt="Administrador" />
          </a>
        </li>
        <li>
          <a href="/velora-mvc/index.php?controller=auth&action=logout" title="Cerrar sesión">
            <img src="/velora-mvc/public/img/logout.png" alt="Logout" />
          </a>
        </li>
      <?php elseif ($rol === 'usuario'): ?>
        <li>
          <a href="/velora-mvc/views/busqueda.php" title="Buscar">
            <img src="/velora-mvc/public/iconos/busqueda.svg" alt="Buscar" />
          </a>
        </li>
        <li>
          <a href="/velora-mvc/views/carrito.php" title="Carrito">
            <img src="/velora-mvc/public/iconos/carrito.svg" alt="Carrito" />
          </a>
        </li>
        <li>
          <a href="/velora-mvc/index.php?controller=auth&action=logout" title="Cerrar sesión">
            <img src="/velora-mvc/public/img/logout.png" alt="Logout" />
          </a>
        </li>
      <?php else: // visitante ?>
        <li>
          <a href="/velora-mvc/views/login.php" title="Usuario">
            <img src="/velora-mvc/public/iconos/user.svg" alt="Usuario" />
          </a>
        </li>
        <li>
          <a href="/velora-mvc/views/busqueda.php" title="Buscar">
            <img src="/velora-mvc/public/iconos/busqueda.svg" alt="Buscar" />
          </a>
        </li>
        <li>
         <a href="#" title="Carrito" id="icono-carrito" style="position:relative;">
    <img src="/velora-mvc/public/iconos/carrito.svg" alt="Carrito" />
    <span id="contador-carrito-navbar" ...></span>
</a>
        </li>
      <?php endif; ?>
    </ul>
  </nav>
</div>

<!-- Imagen historia principal a ancho completo -->
<div class="historia-img" style="width:100vw; max-width:100%; overflow:hidden; margin: 0 auto 40px auto;">
  <img src="/velora-mvc/public/img/historia.jpg" alt="Nuestra historia" style="width:100%; height:450px; object-fit:cover; border-radius:0;">
</div>
<!-- ¿Qué es Velora? -->
<div style="text-align:center; max-width: 800px; margin: 0 auto 60px auto; font-size: 1.22rem; line-height: 1.6;">
  <h2 style="font-size: 2.6rem; margin-bottom: 15px; color:#6d3b6d;">¿Qué es Velora?</h2>
  <p>
    Somos más que una marca de cuidado personal.<br>
    Es un espacio donde la piel, la emoción y la naturaleza se encuentran.<br>
    Nace del deseo de transformar el autocuidado en un ritual que conecte con lo más profundo de ti: tu tiempo, tu esencia, tu valor.
  </p>
</div>

<!-- Sección historia con texto a la izquierda e imagen a la derecha -->
<div style="display:flex; justify-content:center; align-items:stretch; max-width:1100px; margin:0 auto 80px auto; gap:60px;">
  <!-- Texto a la izquierda -->
  <div style="flex:1; font-size:1.18rem; line-height:1.7; text-align:left; display:flex; flex-direction:column; justify-content:center;">
    <h2 style="font-size:2.3rem; margin-bottom:15px; color:#6d3b6d;">Nuestra historia</h2>
    <p>
      Velora nació en Puebla, en medio de la búsqueda por una forma más consciente, cercana y natural de cuidar de nosotros mismos. 
      Lo que empezó como una idea universitaria, creció con intención y propósito: llevar el autocuidado emocional a quienes quieren 
      reconectar con su cuerpo sin dejar de lado lo artesanal, lo suave y lo auténtico.
    </p></br>
    <p>
      Detrás de cada producto hay ingredientes locales, fórmulas limpias y mucho amor. 
      Pero también hay historias, como la tuya, que merecen sentirse vistas y valoradas.
    </p></br>
    <p>
      Somos un equipo joven que cree que la belleza no está en ocultarse, sino en valorarse.<br>
      Por eso, cada aroma, cada textura y cada símbolo de Velora representa eso: la mezcla entre lo emocional y lo natural.
    </p></br>
  </div>
  <!-- Imagen a la derecha -->
  <div style="flex:1; display:flex; align-items:center; justify-content:center;">
    <img src="/velora-mvc/public/img/historia2.jpg" alt="Historia Velora" style="max-width:70%; width:100%; min-width:220px; max-height:700px; object-fit:cover; border-radius:18px;">
  </div>
</div>

  <footer>
    <h2>Velora</h2>
    <ul class="footer-links">
      <li><a href="#">Acerca de</a></li>
      <li><a href="#">Ayuda</a></li>
      <li><a href="#">Soporte</a></li>
    </ul>
    <div class="redes">
      <a href="#"><i class="fab fa-whatsapp"></i></a>
      <a href="#"><i class="fab fa-facebook-f"></i></a>
      <a href="https://www.instagram.com/veloracare.mx?igsh=MWpyYW5naHBvcTYyag==" target="_blank"><i class="fab fa-instagram"></i></a>
      <a href="https://www.tiktok.com/@velora.care3?_t=ZS-8yEIcCi1ZWE&_r=1" target="_blank"><i class="fab fa-tiktok"></i></a>
    </div>
  </footer>
  <script src="/velora-mvc/public/js/carrito.js"></script>
  <script src="/velora-mvc/public/js/editarproducto.js"></script>
</body>
</html>
