<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../app/core/Database.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$productoModel = new Producto();
$producto = $productoModel->obtenerProductoPorId($id);

if (!$producto) {
    echo "Producto no encontrado.";
    exit;
}

$conexion = Database::conectar();
$stmt = $conexion->prepare("SELECT AVG(estrellas) as promedio, COUNT(*) as total FROM reseñas WHERE producto_id = ?");
$stmt->execute([$producto['id']]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);
$promedio = $data['promedio'] ?? 0;
$totalResenas = $data['total'] ?? 0;
$estrellas = round($promedio);

// Nuevos, Notables y Productos
$nuevos = $productoModel->obtenerProductosPorSeccion('nuevos');
$notables = $productoModel->obtenerProductosPorSeccion('notables');
$productos = $productoModel->obtenerProductosPorSeccion('productos');

// Filtra para evitar el producto actual y duplicados
function filtrar($lista, $actualId) {
    return array_filter($lista, function($p) use ($actualId) {
        return $p['id'] != $actualId;
    });
}
$nuevos = filtrar($nuevos, $producto['id']);
$notables = filtrar($notables, $producto['id']);
$productos = filtrar($productos, $producto['id']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($producto['nombre']) ?> | Velora</title>
  <link rel="stylesheet" href="/velora-mvc/public/css/nuevo.css">
  <link rel="stylesheet" href="/velora-mvc/public/css/navbar.css">
  <link rel="stylesheet" href="/velora-mvc/public/css/footer.css">
  <link rel="stylesheet" href="/velora-mvc/public/css/reseñas.css">
  <link rel="stylesheet" href="/velora-mvc/public/css/carrito.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
 
</head>
<body>
  <!-- Logo principal -->
  <header style="text-align: center; padding: 20px 0;">
  <a href="/velora-mvc/views/index.php" style="display: inline-block;">
    <img src="/velora-mvc/public/img/logo.png" alt="Velora" style="height: 70px; display: block; margin: 0 auto;">
  </a>
</header>
  <!-- Navbar -->
  <nav class="navbar">
<ul class="menu" style="display:flex; justify-content:center; width:100%; padding:0; margin:0;">
  <li><a href="/velora-mvc/views/nuevos.php">Nuevos</a></li>
  <li><a href="/velora-mvc/views/notables.php">Notables</a></li>
  <li><a href="/velora-mvc/views/productos.php">Productos</a></li>
  <li><a href="/velora-mvc/views/tiendas.php">Tiendas</a></li>
  <li><a href="/velora-mvc/views/club.php">Club</a></li>
</ul>
    <?php
    $rol = $_SESSION['rol'] ?? 'visitante';
    ?>
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
          <a href="/velora-mvc/views/carrito.php" title="Carrito" style="position:relative;">
            <img src="/velora-mvc/public/iconos/carrito.svg" alt="Carrito" />
            <span id="contador-carrito-navbar" style="background:#6d3b6d;color:#fff;border-radius:50%;padding:2px 7px;font-size:13px;position:absolute;top:-8px;right:-8px;">0</span>
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
  <!-- Contenido principal -->
 <div class="detalle-container" style="display: flex; background: #fcfaf0; padding: 20px; border-radius: 12px;">
    <div class="detalle-img" style="flex: 0 0 320px; display: flex; justify-content: center; align-items: center;">
        <div class="zoom-img-container">
          <img
            src="/velora-mvc/public/img/<?= htmlspecialchars($producto['imagen']) ?>"
            alt="<?= htmlspecialchars($producto['nombre']) ?>"
            class="zoom-img"
            style="width: 90%; max-width: 300px; object-fit: contain; border-radius: 24px;"
          >
          <span class="lupa-icon"><i class="fas fa-search-plus"></i></span>
        </div>
    </div>
    <div class="detalle-info" style="flex: 1; display: flex; flex-direction: column; align-items: center; text-align: center; gap: 18px; padding-left: 20px;">
        <h2><?= htmlspecialchars($producto['nombre']) ?></h2>
        <div class="seccion-resenas">
            <div>
                <span class="estrellas-promedio" id="estrellas-promedio">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <i class="<?= $i <= $estrellas ? 'fas' : 'far' ?> fa-star"></i>
                    <?php endfor; ?>
                </span>
                <span class="cantidad-resenas" id="cantidad-resenas"><?= $totalResenas ?> reseña<?= $totalResenas == 1 ? '' : 's' ?></span>
            </div>
            <div class="estrellas-interactivas" id="estrellas-interactivas">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <i class="fa-star far inactivo"></i>
                <?php endfor; ?>
            </div>
            <div id="mensaje-gracias" style="display: none; color: #6d3b6d; font-size: 16px; margin-top: 10px; font-family: 'Montserrat', Arial, sans-serif;">
                ¡Gracias por tu calificación!
            </div>
        </div>
        <div class="descripcion">
            <?= nl2br(htmlspecialchars($producto['descripcion'])) ?>
        </div>
        <div class="precio" style="color:#6d3b6d; font-weight:bold; font-size:1.3rem; margin-bottom:10px; text-align:center;">
            <?php if (!empty($producto['descuento']) && $producto['descuento'] > 0): ?>
                <span class="text-muted text-decoration-line-through" style="color:#888; font-weight:normal;">
                    $<?= number_format($producto['precio'], 2) ?>
                </span>
                <span class="fw-bold ms-2 text-success" style="color:#6d3b6d; font-weight:bold;">
                    $<?= number_format($producto['precio'] * (1 - $producto['descuento'] / 100), 2) ?>
                </span>
                <span class="badge bg-success"><?= $producto['descuento'] ?>% OFF</span>
            <?php else: ?>
                $<?= number_format($producto['precio'], 2) ?>
            <?php endif; ?>
        </div>
        <button class="btn-agregar-carrito" 
            data-id="<?= $producto['id'] ?>" 
            data-nombre="<?= htmlspecialchars($producto['nombre']) ?>" 
            data-precio="<?= $producto['precio'] ?>" 
            data-imagen="<?= htmlspecialchars($producto['imagen']) ?>">
            Agregar al carrito
        </button>
    </div>
</div>
    <script>
        window.productoId = <?= $producto['id'] ?>;
        window.totalResenas = <?= $totalResenas ?>;
    </script>
    <script src="/velora-mvc/public/js/reseñas.js"></script>

<!-- Carrito Offcanvas -->
<div class="offcanvas-carrito" id="offcanvasCarrito" style="display:none;">
  <div class="offcanvas-header">
    <span class="offcanvas-title">Tu carrito</span>
    <button type="button" class="offcanvas-close" id="cerrarCarrito">&times;</button>
  </div>
  <div class="offcanvas-envio">Tu envío es gratis a partir de $600</div>
  <div class="offcanvas-body">
    <div id="carrito-lista"></div>
    <button id="btn-pagar" style="margin:15px 0;background:#6d3b6d;color:#fff;padding:10px 20px;border:none;border-radius:5px;cursor:pointer;">Pagar</button>
    
    <!-- Sugerencias de productos -->
    <div class="carrito-sugerencias">
      <h4 style="color:#6d3b6d;">También te pueden gustar</h4>
      <div id="sugerencias-lista">
        <?php 
        // Selecciona 2 aleatorios y únicos
        $todos = array_merge($nuevos, $notables, $productos);
        $unicos = [];
        $ids = [];
        foreach ($todos as $p) {
          if (!in_array($p['id'], $ids)) {
            $unicos[] = $p;
            $ids[] = $p['id'];
          }
        }
        shuffle($unicos);
        $seleccionadas = array_slice($unicos, 0, 2);
        foreach ($seleccionadas as $s): ?>
          <div class="sugerencia-producto sombra-negra" style="background:#e9d6ee; border-radius:18px; padding:18px 22px; display:flex; align-items:center; gap:18px; margin-bottom:18px;">
            <img src="/velora-mvc/public/img/<?= htmlspecialchars($s['imagen']) ?>" alt="<?= htmlspecialchars($s['nombre']) ?>" style="width:70px; height:70px; object-fit:contain; border-radius:10px; background:#fff; padding:6px;">
            <div style="display:flex; flex-direction:column; gap:6px; flex:1;">
              <span class="sug-nombre" style="font-size:1.1rem; font-weight:bold;"><?= htmlspecialchars($s['nombre']) ?></span>
              <div class="sugerencia-estrellas" style="display:flex; align-items:center; gap:2px; margin-bottom:2px;">
                <?php if (!empty($s['estrellas'])): ?>
                  <?php for ($i = 1; $i <= 5; $i++): ?>
                    <i class="fa-solid fa-star<?= $i > $s['estrellas'] ? '-o' : '' ?>" style="color:#b97cb7; font-size:1rem;"></i>
                  <?php endfor; ?>
                  <span style="font-size:13px; color:#6d3b6d;">
                    <?= $s['totalResenas'] ?? 0 ?> reseña<?= ($s['totalResenas'] ?? 0) == 1 ? '' : 's' ?>
                  </span>
                <?php else: ?>
                  <span style="font-size:13px; color:#6d3b6d;">Sin reseñas</span>
                <?php endif; ?>
              </div>
              <span class="sugerencia-precio" style="font-size:1.1rem; font-weight:bold; color:#6d3b6d; margin-bottom:6px;">
                $<?= number_format($s['precio'], 2) ?>
              </span>
              <button class="btn-agregar" style="background:#b97cb7; color:#fff; border:none; border-radius:10px; padding:8px 18px; font-weight:bold; font-size:1rem; cursor:pointer; transition:background 0.2s; display:flex; align-items:center; gap:8px; margin-top:6px;"
                onclick="agregarSugerido('<?= $s['id'] ?>', '<?= htmlspecialchars($s['nombre']) ?>', '<?= htmlspecialchars($s['imagen']) ?>', <?= $s['precio'] ?>)">
                <i class="fas fa-cart-plus"></i> AGREGAR
              </button>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
    <!-- Fin sugerencias -->
  </div>
</div>


<!-- Modal de agradecimiento -->
<div id="modal-gracias" style="display:none;position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(3, 3, 3, 0.5);z-index:9999;justify-content:center;align-items:center;">
  <div style="background:#fff;padding:30px 40px;border-radius:10px;text-align:center;">
    <h2 style="color:#6d3b6d;">¡Gracias por tu compra!</h2>
    <p style="color:#6d3b6d;">Tu pedido ha sido recibido.</p>
    <button id="btn-volver-inicio" style="background:#6d3b6d;color:#fff;padding:10px 20px;border:none;border-radius:5px;cursor:pointer;">Volver al inicio</button>
  </div>
</div>
  <!-- Fin de tu contenido principal -->
    <!-- Carrito Offcanvas -->
    <div class="offcanvas-carrito" id="offcanvasCarrito" style="display:none;">
      <div class="offcanvas-header">
        <span class="offcanvas-title">Tu carrito</span>
        <button type="button" class="offcanvas-close" id="cerrarCarrito">&times;</button>
      </div>
      <div class="offcanvas-envio">Tu envío es gratis a partir de $600</div>
      <div class="offcanvas-body">
        <div id="carrito-lista"></div>
        <div class="carrito-sugerencias">
          <h4>También te pueden gustar</h4>
          <div id="sugerencias-lista"></div>
        </div>
      </div>
    </div>
    
    <!-- Footer -->
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
  <script>
function getCarrito() {
    return JSON.parse(localStorage.getItem('carrito')) || {};
}
function setCarrito(carrito) {
    localStorage.setItem('carrito', JSON.stringify(carrito));
}
function actualizarContadorNavbar() {
    const carrito = getCarrito();
    let total = 0;
    for (const id in carrito) {
        total += carrito[id].cantidad;
    }
    const span = document.getElementById('contador-carrito-navbar');
    if (span) span.textContent = total;
}
function mostrarCarrito() {
    const carrito = getCarrito();
    const lista = document.getElementById('carrito-lista');
    lista.innerHTML = '';
    let hayProductos = false;
    let total = 0;
    let cantidadTotal = 0;
    for (const id in carrito) {
        hayProductos = true;
        const prod = carrito[id];
        const subtotal = prod.precio * prod.cantidad;
        total += subtotal;
        cantidadTotal += prod.cantidad;
        lista.innerHTML += `
            <div class="carrito-item" style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
                <img src="/velora-mvc/public/img/${prod.imagen}" style="width:40px;">
                <span>${prod.nombre}</span>
                <span>x${prod.cantidad}</span>
                <span>$${prod.precio} c/u</span>
                <span style="font-weight:bold;">Subtotal: $${subtotal}</span>
            </div>
        `;
    }
    if (hayProductos) {
        lista.innerHTML += `
            <div style="margin-top:15px;font-weight:bold;">
                Total productos: ${cantidadTotal}<br>
                Total a pagar: $${total}
            </div>
        `;
    } else {
        lista.innerHTML = '<p>¡Tu carrito está vacío!</p>';
    }
}
function mostrarSugerencias() {
    const lista = document.getElementById('sugerencias-lista');
    lista.innerHTML = '';
    let todos = [
        ...sugerenciasPorSeccion.nuevos,
        ...sugerenciasPorSeccion.notables,
        ...sugerenciasPorSeccion.productos
    ];
    // Elimina duplicados por id
    const unicos = [];
    const ids = new Set();
    todos.forEach(p => {
        if (!ids.has(p.id)) {
            unicos.push(p);
            ids.add(p.id);
        }
    });
    // Selecciona 2 aleatorios
    const seleccionadas = unicos.sort(() => 0.5 - Math.random()).slice(0, 2);

    seleccionadas.forEach(s => {
        let resenaHtml = '';
        if (s.estrellas) {
            resenaHtml = `<span class="sug-resena">`;
            for (let i = 1; i <= 5; i++) {
                resenaHtml += `<i class="${i <= s.estrellas ? 'fas' : 'far'} fa-star" style="color:#b97cb7; font-size:1rem;"></i>`;
            }
            resenaHtml += ` (${s.totalResenas || 0} reseñas)</span>`;
        } else {
            resenaHtml = `<span class="sug-resena">Sin reseñas</span>`;
        }

        lista.innerHTML += `
        <div class="sugerencia-producto sombra-negra" style="background:#e9d6ee; border-radius:18px; padding:18px 22px; display:flex; align-items:center; gap:18px; margin-bottom:18px;">
            <img src="/velora-mvc/public/img/${s.imagen}" alt="${s.nombre}" style="width:70px; height:70px; object-fit:contain; border-radius:10px; background:#fff; padding:6px;">
            <div style="display:flex; flex-direction:column; gap:6px; flex:1;">
                <span class="sug-nombre" style="font-size:1.1rem; font-weight:bold;">${s.nombre}</span>
                <div class="sugerencia-estrellas" style="display:flex; align-items:center; gap:2px; margin-bottom:2px;">
                    ${resenaHtml}
                </div>
                <span class="sugerencia-precio" style="font-size:1.1rem; font-weight:bold; color:#6d3b6d; margin-bottom:6px;">
                    $${s.precio}
                </span>
                <button class="btn-agregar" style="background:#b97cb7; color:#fff; border:none; border-radius:10px; padding:8px 18px; font-weight:bold; font-size:1rem; cursor:pointer; transition:background 0.2s; display:flex; align-items:center; gap:8px; margin-top:6px;"
                    onclick="agregarSugerido('${s.id}','${s.nombre}','${s.imagen}',${s.precio})">
                    <i class="fas fa-cart-plus"></i> AGREGAR
                </button>
            </div>
        </div>
        `;
    });
}

function agregarSugerido(id, nombre, imagen, precio) {
    let carrito = getCarrito();
    if (!carrito[id]) carrito[id] = {nombre, imagen, precio, cantidad:0};
    carrito[id].cantidad += 1;
    setCarrito(carrito);
    actualizarContadorNavbar();
    mostrarCarrito();
    mostrarSugerencias();
}
actualizarContadorNavbar();

document.querySelector('.btn-agregar-carrito').addEventListener('click', function() {
    const id = this.dataset.id;
    const nombre = this.dataset.nombre;
    const precio = this.dataset.precio;
    const imagen = this.dataset.imagen;
    let carrito = getCarrito();
    if (!carrito[id]) {
        carrito[id] = { nombre, precio, imagen, cantidad: 0 };
    }
    carrito[id].cantidad += 1;
    setCarrito(carrito);
    actualizarContadorNavbar();
    mostrarCarrito();
    mostrarSugerencias();
    document.getElementById('offcanvasCarrito').style.display = 'block';
});

document.addEventListener('DOMContentLoaded', function() {
    const iconoCarrito = document.querySelector('a[title="Carrito"]');
    if (iconoCarrito) {
        iconoCarrito.addEventListener('click', function(e) {
            e.preventDefault();
            mostrarCarrito();
            mostrarSugerencias();
            document.getElementById('offcanvasCarrito').style.display = 'block';
        });
    }
});

document.getElementById('cerrarCarrito').onclick = function() {
    document.getElementById('offcanvasCarrito').style.display = 'none';
};

// Botón pagar
document.getElementById('btn-pagar').onclick = function() {
    document.getElementById('offcanvasCarrito').style.display = 'none';
    document.getElementById('modal-gracias').style.display = 'flex';
    localStorage.removeItem('carrito');
    actualizarContadorNavbar();
    mostrarCarrito();
};

// Botón volver al inicio
document.getElementById('btn-volver-inicio').onclick = function() {
    window.location.href = '/velora-mvc/views/index.php';
};
</script>
<script>
const sugerenciasPorSeccion = {
    nuevos: <?php echo json_encode(array_values($nuevos)); ?>,
    notables: <?php echo json_encode(array_values($notables)); ?>,
    productos: <?php echo json_encode(array_values($productos)); ?>
};
</script>
</body>
</html>