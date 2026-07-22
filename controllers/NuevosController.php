<?php
$conexion = Database::conectar();

class NuevosController {
  public function index() {
    $productos = [
      ['imagen' => 'nuevo1.jpg', 'nombre' => 'Shampoo de Lavanda', 'reseñas' => 3, 'estrellas' => '★★★★☆'],
      ['imagen' => 'nuevo2.jpg', 'nombre' => 'Crema para Manos', 'reseñas' => 5, 'estrellas' => '★★★★★'],
      ['imagen' => 'nuevo3.jpg', 'nombre' => 'Mascarilla Rosa', 'reseñas' => 2, 'estrellas' => '★★★☆☆'],
      ['imagen' => 'nuevo4.jpg', 'nombre' => 'Bálsamo Miel', 'reseñas' => 7, 'estrellas' => '★★★★★']
    ];

    require "views/nuevos.php";
  }
}
