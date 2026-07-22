<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$rol = $_SESSION['rol'] ?? 'visitante';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Club | Velora</title>
  <link rel="stylesheet" href="/velora-mvc/public/css/nuevo.css">
  <link rel="stylesheet" href="/velora-mvc/public/css/navbar.css">
  <link rel="stylesheet" href="/velora-mvc/public/css/footer.css">
  <link rel="stylesheet" href="/velora-mvc/public/css/mantenimiento.css">
  <link rel="stylesheet" href="/velora-mvc/public/css/carrito.css">
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

  <!-- 🌸 Sección de mensaje -->
  <section class="mantenimiento">
    <img src="/velora-mvc/public/img/404.png.webp" alt="Club en construcción">
    <h2>Parece que este pétalo se ha perdido...</h2>
    <p>La página que buscas no está disponible o ha cambiado de lugar.<br>
    Pero no te preocupes, aún puedes encontrar belleza, calma y cuidado en el resto de nuestro jardín.</p>
    <a href="/velora-mvc/index.php" class="volver-btn">VOLVER AL INICIO</a>
  </section>

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
</body>
</html>
