<?php
require_once __DIR__ . '/../models/Producto.php';

class IndexController {
  public function index() {
    $model = new Producto();
    $productos = $model->obtenerProductos();
    include "views/index.php";
  }
}

$conexion = Database::conectar();
