<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../models/Producto.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Velora</title>
  <link rel="stylesheet" href="/velora-mvc/public/css/index.css">
  <link rel="stylesheet" href="/velora-mvc/public/css/navbar.css">
  <link rel="stylesheet" href="/velora-mvc/public/css/footer.css">
  <link rel="stylesheet" href="/velora-mvc/public/css/carrito.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="/velora-mvc/public/js/slider.js" defer></script>
</head>
<body>

 <header style="text-align: center; padding: 20px 0;">
  <img src="/velora-mvc/public/img/logo.png" alt="Velora" style="height: 70px;">
  </header>

  <?php
  // NO pongas session_start() aquí
  $rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : 'visitante';

  // Detecta si está en el index o en otra pestaña
  $esIndex = basename($_SERVER['PHP_SELF']) === 'index.php';

  $mensaje = '';
  if ($rol === 'visitante') {
      $mensaje = 'Bienvenido a Velora, explora como visitante.';
  } elseif ($rol === 'usuario') {
      $mensaje = 'Bienvenido a Velora, disfruta tu experiencia.';
  } elseif ($rol === 'administrador') {
      $mensaje = 'Bienvenido a Velora, ahora tienes el mando';
  }
  ?>

  <nav class="navbar">
    <ul class="menu">
      <?php if ($rol === 'usuario' || $rol === 'administrador'): ?>
        <?php if (!$esIndex): ?>
          <li><a href="/velora-mvc/index.php">Inicio</a></li>
        <?php endif; ?>
        <li><a href="/velora-mvc/views/nuevos.php">Nuevos</a></li>
        <li><a href="/velora-mvc/views/notables.php">Notables</a></li>
        <li><a href="/velora-mvc/views/productos.php">Productos</a></li>
        <li><a href="/velora-mvc/views/tiendas.php">Tiendas</a></li>
        <li><a href="/velora-mvc/views/club.php">Club</a></li>
      <?php else: ?>
        <!-- Visitante: navbar completa -->
        <li><a href="/velora-mvc/views/nuevos.php">Nuevos</a></li>
        <li><a href="/velora-mvc/views/notables.php">Notables</a></li>
        <li><a href="/velora-mvc/views/productos.php">Productos</a></li>
        <li><a href="/velora-mvc/views/tiendas.php">Tiendas</a></li>
        <li><a href="/velora-mvc/views/club.php">Club</a></li>
      <?php endif; ?>
    </ul>
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
          <a href="/velora-mvc/views/login.php" title="Carrito (registrarse primero)">
            <img src="/velora-mvc/public/iconos/carrito.svg" alt="Carrito" />
          </a>
        </li>
      <?php endif; ?>
    </ul>
  </nav> 

  <?php if ($mensaje): ?>
    <div style="color:#622C69; text-align:center; font-size:1.1em; font-weight:500; margin: 18px 0 10px 0;">
      <?php echo $mensaje; ?>
    </div>
  <?php endif; ?>

  <section class="slider">
    <div class="slide-container">
      <img src="/velora-mvc/public/img/banner1.png" alt="Banner 1">
      <img src="/velora-mvc/public/img/banner2.png" alt="Banner 2">
      <img src="/velora-mvc/public/img/banner3.png" alt="Banner 3">
    </div>
  </section>

<section class="mas-vendidos">
  <h2>Más Vendidos</h2>
  <div class="productos" style="display:flex; gap:28px; justify-content:center; align-items:center; margin-bottom:18px; background:none; box-shadow:none;">
    <img src="/velora-mvc/public/img/1.png" alt="Producto 1" style="width:200px; border-radius:18px; background:none; box-shadow:none;">
    <img src="/velora-mvc/public/img/2.png" alt="Producto 2" style="width:200px; border-radius:18px; background:none; box-shadow:none;">
    <img src="/velora-mvc/public/img/3.png" alt="Producto 3" style="width:200px; border-radius:18px; background:none; box-shadow:none;">
    <img src="/velora-mvc/public/img/bolsa.png" alt="Producto 4" style="width:200px; border-radius:18px; background:none; box-shadow:none;">
  </div>

<button class="ver-mas" onclick="window.location.href='/velora-mvc/views/notables.php'">Ver más</button>
</section>

  <section class="explora">
    <div class="explora-item">
      <img src="/velora-mvc/public/img/blog.jpg" alt="Blog">
      <div class="overlay">
        <h3>Nuestro Blog</h3>
        <a href="/velora-mvc/views/club.php">
          <button>Explorar</button>
        </a>
      </div>
    </div>
    <div class="explora-item">
      <img src="/velora-mvc/public/img/historia.jpg" alt="Historia">
      <div class="overlay">
        <h3>Nuestra Historia</h3>
        <a href="/velora-mvc/views/historia.php">
          <button>Explorar</button>
        </a>
      </div>
    </div>
    <div class="explora-item">
      <img src="/velora-mvc/public/img/proximamente.jpg" alt="Próximamente">
      <div class="overlay">
        <h3>Próximamente</h3>
        <a href="/velora-mvc/views/club.php">
          <button>Explorar</button>
        </a>
      </div>
    </div>
  </section>

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

  <!-- Carrito Offcanvas -->
  <div class="offcanvas-carrito" id="offcanvasCarrito">
    <div class="offcanvas-header">
      <span class="offcanvas-title">Tu carrito</span>
      <button type="button" class="offcanvas-close" id="cerrarCarrito">&times;</button>
    </div>
    <div class="offcanvas-envio">Tu envío es gratis a partir de $600</div>
    <div class="offcanvas-body">
      <div class="carrito-vacio">
        <p>¡Tu carrito está vacío!</p>
        <p>Agrega tus productos favoritos a tu carrito.</p>
        <button class="btn-comprar">COMPRAR AHORA</button>
      </div>
      <div class="carrito-sugerencias">
        <h4>También te pueden gustar</h4>
        <div class="sugerencia-producto">
          <img src="/velora-mvc/public/img/shampoo-lavanda.png" alt="Shampoo de Lavanda" />
          <div>
            <span>Shampoo de Lavanda</span>
            <div class="sugerencia-estrellas">
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <span style="font-size:13px; color:#6d3b6d;">1 reseña</span>
            </div>
            <span class="sugerencia-precio">$120</span>
            <button class="btn-agregar">AGREGAR</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="/velora-mvc/public/js/carrito.js"></script>

</body>
</html>
