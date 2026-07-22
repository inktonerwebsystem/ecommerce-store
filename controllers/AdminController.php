<?php
require_once __DIR__ . '/../app/core/Database.php'; 
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Producto.php';

class AdminController {
    private function requireAdmin() {
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
            header("Location: /velora-mvc/index.php");
            exit();
        }
    }

    public function dashboard() {
        $this->requireAdmin();
        $usuarioModel = new Usuario();
        $productoModel = new Producto();
        $usuarios = $usuarioModel->obtenerTodosLosUsuarios();
        $productos = $productoModel->obtenerProductos();
        require "views/p.administrador.php";
    }

    public function eliminarUsuario() {
        $this->requireAdmin();
        if (isset($_GET['id'])) {
            $usuarioModel = new Usuario();
            $usuarioModel->eliminarUsuario($_GET['id']);
        }
        header("Location: /velora-mvc/index.php?controller=admin&action=dashboard");
        exit();
    }

    public function eliminarProducto() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            require_once __DIR__ . '/../models/Producto.php';
            $productoModel = new Producto();
            $productoModel->eliminarProducto($id);
        }
        // Redirige a la vista principal del panel de administrador
        header('Location: /velora-mvc/views/p.administrador.php');
        exit();
    }

    public function editarProducto() {
        $this->requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $precio = $_POST['precio'];
            $stock = $_POST['stock'];
            $ubicacion = isset($_POST['ubicacion']) ? implode(',', $_POST['ubicacion']) : '';
            // Si tienes imagen, agrégala aquí

            $productoModel = new Producto();
            $productoModel->actualizarProducto($id, $nombre, $precio, $stock, $ubicacion /*, $imagen */);

            // Redirige al dashboard
            header("Location: /velora-mvc/index.php?controller=admin&action=dashboard");
            exit();
        }
        // No cargues ninguna vista aquí, porque usas modal
    }

    public function editarUsuario() {
        $this->requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $correo = $_POST['correo'];
            $rol = $_POST['rol'];
            $usuarioModel = new Usuario();
            $usuarioModel->actualizarUsuario($id, $nombre, $correo, $rol);
            header("Location: /velora-mvc/index.php?controller=admin&action=dashboard");
            exit();
        }
    }

    public function descuentos() {
        $this->requireAdmin();
        require "views/admin/descuentos.php";
    }

    public function agregarProducto() {
        $this->requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $precio = $_POST['precio'];
            $stock = $_POST['stock'];
            $ubicacion = isset($_POST['ubicacion']) ? implode(',', $_POST['ubicacion']) : '';
            $descripcion = $_POST['descripcion'];
            // Manejo de imagen
            $imagen = '';
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $nombreImagen = uniqid() . '_' . $_FILES['imagen']['name'];
                move_uploaded_file($_FILES['imagen']['tmp_name'], __DIR__ . '/../public/img/' . $nombreImagen);
                $imagen = $nombreImagen;
            }
            $productoModel = new Producto();
            // LLAMA CON TODOS LOS CAMPOS
            $productoModel->agregarProducto($nombre, $precio, $stock, $ubicacion, $imagen, $descripcion);

            header("Location: /velora-mvc/index.php?controller=admin&action=dashboard");
            exit();
        }
        // No cargar ninguna vista aquí, porque usas modal
    }

    public function aplicarDescuento() {
        $id = $_POST['id'] ?? null;
        $descuento = $_POST['descuento'] ?? 0;
        if ($id !== null) {
            require_once __DIR__ . '/../models/Producto.php';
            $productoModel = new Producto();
            $productoModel->aplicarDescuento($id, $descuento);
        }
        header('Location: /velora-mvc/views/p.administrador.php');
        exit();
    }
}
?>
<form class="modal-content" id="formEditarProducto" method="POST" action="/velora-mvc/index.php?controller=admin&action=editarProducto">
    <!-- campos del formulario -->
</form>