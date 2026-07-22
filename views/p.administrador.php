<?php
if (!isset($_SESSION)) session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
    header("Location: /velora-mvc/app/views/login.php?error=acceso_denegado");
    exit();
}

require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Producto.php';

$usuarioModel = new Usuario();
$productoModel = new Producto();

$usuarios = $usuarioModel->obtenerTodosLosUsuarios();
$productos = $productoModel->obtenerProductos();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/velora-mvc/public/css/p.administrador.css">
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid p-0">
            <span class="navbar-brand mb-0 h1">Panel de administrador</span>
            <div class="icons-navbar">
                <a href="/velora-mvc/index.php" title="Inicio"><i class="bi bi-house"></i></a>
                <a href="/velora-mvc/app/controllers/LogoutController.php" title="Salir"><i class="bi bi-box-arrow-right"></i></a>
            </div>
        </div>
    </nav>

    <div class="container-admin">

        <h2 class="mt-4 mb-1 text-center">Productos</h2>
        <p class="mb-4 text-muted text-center">Aquí podrás ver, editar, eliminar y agregar productos</p>
        <div class="d-flex justify-content-center align-items-center mb-3">
            <button type="button" class="btn btn-blue" data-bs-toggle="modal" data-bs-target="#modalAgregarProducto">
              <i class="bi bi-plus-circle"></i> Agregar producto
            </button>
        </div>
        <table class="table table-bordered table-hover">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Ubicación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($productos)): ?>
                    <?php foreach ($productos as $producto): ?>
                        <tr id="producto-row-<?= $producto['id'] ?>"<?= (!empty($producto['promocion']) && $producto['promocion'] == 1) ? ' class="promocion"' : '' ?>>
                            <td><?= htmlspecialchars($producto['id']) ?></td>
                            <td><?= htmlspecialchars($producto['nombre']) ?></td>
                            <td>
                                <?php if (!empty($producto['descuento']) && $producto['descuento'] > 0): ?>
                                    <span class="text-muted text-decoration-line-through">
                                        $<?= number_format($producto['precio'], 2) ?>
                                    </span>
                                    <span class="fw-bold ms-2 text-success">
                                        $<?= number_format($producto['precio'] * (1 - $producto['descuento']/100), 2) ?>
                                    </span>
                                    <span class="badge bg-success"><?= $producto['descuento'] ?>% OFF</span>
                                <?php else: ?>
                                    $<?= number_format($producto['precio'], 2) ?>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($producto['stock'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($producto['ubicacion']) ?></td>
                            <td>
                                <a href="#"
                                   class="btn btn-sm btn-primary editar-producto-btn"
                                   data-id="<?= $producto['id'] ?>"
                                   data-nombre="<?= htmlspecialchars($producto['nombre']) ?>"
                                   data-precio="<?= htmlspecialchars($producto['precio']) ?>"
                                   data-stock="<?= htmlspecialchars($producto['stock']) ?>"
                                   data-ubicacion="<?= htmlspecialchars($producto['ubicacion']) ?>"
                                   data-descuento="<?= htmlspecialchars($producto['descuento'] ?? 0) ?>"
                                   data-bs-toggle="modal"
                                   data-bs-target="#modalEditarProducto"
                                >Editar</a>
                                <a href="#" 
                                   class="btn btn-sm btn-primary descuento-producto-btn" 
                                   data-id="<?= $producto['id'] ?>">
                                   <i class="bi bi-percent"></i> Descuento
                                </a>
                                <a href="/velora-mvc/index.php?controller=admin&action=eliminarProducto&id=<?= $producto['id'] ?>"
                                   class="btn btn-sm btn-danger eliminar-producto-btn">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="text-center">No hay productos registrados.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <h2 class="mt-5 mb-1 text-center">Gestión de usuarios</h2>
        <p class="mb-4 text-muted text-center">Aquí podrás ver, editar y eliminar usuarios</p>
        <table class="table table-bordered table-hover">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Correo</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($usuarios)): ?>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?= htmlspecialchars($usuario['id']) ?></td>
                            <td><?= htmlspecialchars($usuario['usuario']) ?></td>
                            <td><?= htmlspecialchars($usuario['correo']) ?></td>
                            <td><?= htmlspecialchars($usuario['rol']) ?></td>
                            <td>
                                <a href="#" 
                                   class="btn btn-sm btn-primary editar-usuario-btn"
                                   data-id="<?= $usuario['id'] ?>"
                                   data-nombre="<?= htmlspecialchars($usuario['usuario']) ?>"
                                   data-correo="<?= htmlspecialchars($usuario['correo']) ?>"
                                   data-rol="<?= htmlspecialchars($usuario['rol']) ?>"
                                   data-bs-toggle="modal"
                                   data-bs-target="#modalEditarUsuario"
                                >Editar</a>
                                <a href="/velora-mvc/index.php?controller=admin&action=eliminarUsuario&id=<?= $usuario['id'] ?>" 
                                   class="btn btn-sm btn-danger" 
                                   onclick="return confirm('¿Seguro que deseas eliminar este usuario?')">
                                   Eliminar
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5" class="text-center">No hay usuarios registrados.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal de edición de usuario -->
    <div class="modal fade" id="modalEditarUsuario" tabindex="-1" aria-labelledby="modalEditarUsuarioLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form class="modal-content" id="formEditarUsuario" method="POST" action="/velora-mvc/index.php?controller=admin&action=editarUsuario">
          <div class="modal-header">
            <h5 class="modal-title" id="modalEditarUsuarioLabel">Editar Usuario</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="id" id="editUsuarioId">
            <div class="mb-3">
              <label for="editUsuarioNombre" class="form-label">Nombre</label>
              <input type="text" class="form-control" id="editUsuarioNombre" name="nombre" required>
            </div>
            <div class="mb-3">
              <label for="editUsuarioCorreo" class="form-label">Correo</label>
              <input type="email" class="form-control" id="editUsuarioCorreo" name="correo" required>
            </div>
            <div class="mb-3">
              <label for="editUsuarioRol" class="form-label">Rol</label>
              <select class="form-select" id="editUsuarioRol" name="rol" required>
                <option value="usuario">Usuario</option>
                <option value="administrador">Administrador</option> 
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar cambios</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Modal de edición de producto simplificado -->
    <div class="modal fade" id="modalEditarProducto" tabindex="-1" aria-labelledby="modalEditarProductoLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form class="modal-content" id="formEditarProducto" method="POST" action="/velora-mvc/index.php?controller=admin&action=editarProducto" enctype="multipart/form-data">
          <div class="modal-header">
            <h5 class="modal-title" id="modalEditarProductoLabel">Editar Producto</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="id" id="editProductoId">
            <div class="mb-3">
              <label for="editProductoNombre" class="form-label">Nombre</label>
              <input type="text" class="form-control" id="editProductoNombre" name="nombre" required>
            </div>
            <div class="mb-3">
              <label for="editProductoPrecio" class="form-label">Precio</label>
              <input type="number" step="0.01" class="form-control" id="editProductoPrecio" name="precio" required>
            </div>
            <div class="mb-3">
              <label for="editProductoStock" class="form-label">Stock</label>
              <input type="number" class="form-control" id="editProductoStock" name="stock" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Ubicación</label><br>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="ubicacionNuevos" name="ubicacion[]" value="nuevos">
                <label class="form-check-label" for="ubicacionNuevos">Nuevos</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="ubicacionNotables" name="ubicacion[]" value="notables">
                <label class="form-check-label" for="ubicacionNotables">Notables</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="ubicacionProductos" name="ubicacion[]" value="productos">
                <label class="form-check-label" for="ubicacionProductos">Productos</label>
              </div>
            </div>
            <div class="mb-3">
              <label for="editProductoImagen" class="form-label">Imagen</label>
              <input type="file" class="form-control" id="editProductoImagen" name="imagen">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar cambios</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Modal de aplicar descuento con opciones de 5 en 5 hasta 70% -->
    <div class="modal fade" id="modalDescuentoProducto" tabindex="-1" aria-labelledby="modalDescuentoProductoLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form class="modal-content" id="formDescuentoProducto" method="POST" action="/velora-mvc/index.php?controller=admin&action=aplicarDescuento">
          <div class="modal-header">
            <h5 class="modal-title" id="modalDescuentoProductoLabel">Aplicar Descuento</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="id" id="descuentoProductoId">
            <div class="mb-3">
              <label for="descuentoPorcentaje" class="form-label">Porcentaje de descuento (%)</label>
              <select class="form-select" id="descuentoPorcentaje" name="descuento" required>
                <?php for ($i = 0; $i <= 70; $i += 5): ?>
                  <option value="<?= $i ?>"><?= $i ?>%</option>
                <?php endfor; ?>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button class="btn btn-aplicar-descuento">Aplicar descuento</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Modal Agregar Producto -->
    <div class="modal fade" id="modalAgregarProducto" tabindex="-1" aria-labelledby="modalAgregarProductoLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form class="modal-content" id="formAgregarProducto" method="POST" action="/velora-mvc/index.php?controller=admin&action=agregarProducto" enctype="multipart/form-data">
          <div class="modal-header">
            <h5 class="modal-title" id="modalAgregarProductoLabel">Agregar Producto</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="nombre" class="form-label">Nombre</label>
              <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="mb-3">
              <label for="precio" class="form-label">Precio</label>
              <input type="number" class="form-control" id="precio" name="precio" step="0.01" required>
            </div>
            <div class="mb-3">
              <label for="stock" class="form-label">Stock</label>
              <input type="number" class="form-control" id="stock" name="stock" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Ubicación</label><br>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="ubicacion[]" id="nuevo" value="nuevos">
                <label class="form-check-label" for="nuevo">Nuevos</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="ubicacion[]" id="notable" value="notables">
                <label class="form-check-label" for="notable">Notables</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="ubicacion[]" id="producto" value="productos">
                <label class="form-check-label" for="producto">Productos</label>
              </div>
            </div>
            <div class="mb-3">
              <label for="imagen" class="form-label">Imagen</label>
              <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*" required>
            </div>
            <div class="mb-3">
              <label for="descripcion" class="form-label">Descripción</label>
              <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-blue">Agregar producto</button>
          </div>
        </form>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/velora-mvc/public/js/editarusuario.js"></script>
    <script src="/velora-mvc/public/js/editarproducto.js"></script>
</body>
</html>
