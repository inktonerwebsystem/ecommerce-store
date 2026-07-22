<?php

require_once __DIR__ . '/../app/core/Database.php';

class AuthController {
    public function crear() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';
            $correo = isset($_POST['correo']) ? trim($_POST['correo']) : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';

            if ($usuario && $correo && $password) {
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $db = Database::conectar();

                // Verifica si el usuario o correo ya existen
                $stmt = $db->prepare("SELECT id FROM usuarios WHERE usuario = ? OR correo = ?");
                $stmt->execute([$usuario, $correo]);
                if ($stmt->fetch()) {
                    // Redirige usando el router y pasando el error por GET
                    header("Location: /velora-mvc/index.php?controller=auth&action=crear&error=existente");
                    exit();
                }

                // Inserta el nuevo usuario con rol 'usuario'
                $stmt = $db->prepare("INSERT INTO usuarios (usuario, correo, password, rol) VALUES (?, ?, ?, ?)");
                $stmt->execute([$usuario, $correo, $passwordHash, 'usuario']);

                // Inicia sesión automáticamente
                session_start();
                $_SESSION['usuario'] = $usuario;
                $_SESSION['correo'] = $correo;
                $_SESSION['rol'] = 'usuario';

                // Redirige al index después de registrar
                header("Location: /velora-mvc/index.php");
                exit();
            } else {
                // Redirige usando el router y pasando el error por GET
                header("Location: /velora-mvc/index.php?controller=auth&action=crear&error=datos");
                exit();
            }
        } else {
            // Muestra la vista a través del router
            require "views/c.cuenta.php";
        }
    }

    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header("Location: /velora-mvc/index.php");
        exit();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $correo = isset($_POST['email']) ? trim($_POST['email']) : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';

            if ($correo && $password) {
                $db = Database::conectar();
                $stmt = $db->prepare("SELECT * FROM usuarios WHERE correo = ?");
                $stmt->execute([$correo]);
                $usuario = $stmt->fetch();

                if ($usuario && password_verify($password, $usuario['password'])) {
                    session_start();
                    $_SESSION['usuario'] = $usuario['usuario'];
                    $_SESSION['correo'] = $usuario['correo'];
                    $_SESSION['rol'] = $usuario['rol'];
                    header("Location: /velora-mvc/index.php");
                    exit();
                } else {
                    header("Location: /velora-mvc/views/login.php?error=credenciales");
                    exit();
                }
            } else {
                header("Location: /velora-mvc/views/login.php?error=datos");
                exit();
            }
        } else {
            require "views/login.php";
        }
    }
}