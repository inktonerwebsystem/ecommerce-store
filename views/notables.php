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
  <title>Notables | Velora</title>
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
          <a href="/velora-mvc/views/login.php" title="Carrito (registrarse primero)">
            <img src="/velora-mvc/public/iconos/carrito.svg" alt="Carrito" />
          </a>
        </li>
      <?php endif; ?>
    </ul>
  </nav>

  <main>
    <section class="mas-vendidos">
      <h2>Notables</h2>
      <?php
      $hayNotables = false;
      if (!empty($productos) && is_array($productos)): ?>
        <div class="productos">
          <?php foreach ($productos as $producto): ?>
            <?php if (tieneUbicacion($producto, 'notables')): ?>
              <?php $hayNotables = true; ?>
              <?php
              require_once __DIR__ . '/../app/core/Database.php';
              $conexion = Database::conectar();
              $stmt = $conexion->prepare("SELECT AVG(estrellas) as promedio, COUNT(*) as total FROM reseñas WHERE producto_id = ?");
              $stmt->execute([$producto['id']]);
              $data = $stmt->fetch(PDO::FETCH_ASSOC);
              $promedio = $data['promedio'] ?? 0;
              $totalResenas = $data['total'] ?? 0;
              $estrellas = round($promedio);
              ?>
              <div class="producto-card">
                <a href="/velora-mvc/views/detalle_producto.php?id=<?= $producto['id'] ?>">
                  <img class="img-producto-destacada" src="/velora-mvc/public/img/<?= htmlspecialchars($producto['imagen']) ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>">
                </a>
                <h3 class="nombre-producto">
                  
                    <?= htmlspecialchars($producto['nombre']) ?>
                  </a>
                </h3>
                <div class="fila-resenas">
                  <span class="estrellas-promedio">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                      <i class="<?= $i <= $estrellas ? 'fas' : 'far' ?> fa-star"></i>
                    <?php endfor; ?>
                  </span>
                  <span class="cantidad-resenas">
                    <?= $totalResenas ?> reseña<?= $totalResenas == 1 ? '' : 's' ?>
                  </span>
                </div>
                <!-- Botón agregar al carrito aquí -->
              </div>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>
        <?php if (!$hayNotables): ?>
          <p>Por el momento no hay notables.</p>
        <?php endif; ?>
      <?php else: ?>
        <p>Por el momento no hay notables.</p>
      <?php endif; ?>
    </section>
  </main>

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
