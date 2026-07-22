<?php
require_once __DIR__ . '/../app/core/Database.php';
class UsuariosController {
    public function perfil() {
        // Mostrar perfil del usuario
        require "views/usuario/perfil.php";
    }
    // Agrega más métodos según lo que necesites
}