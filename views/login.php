<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Iniciar sesión | Velora</title>
  <link rel="stylesheet" href="/velora-mvc/public/css/login.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

  <div class="login-container">
    <!-- 🌿 Ilustración y branding -->
    <div class="login-left">
      <img src="/velora-mvc/public/img/login.png" alt="Ilustración Velora">
      <h1 class="logo">Velora</h1>
    </div>

    <!-- 🔐 Formulario de acceso -->
    <div class="login-right">
      <a href="/velora-mvc/index.php" class="back-arrow"><i class="fas fa-arrow-left"></i></a>
      <div class="titulo-login">Iniciar Sesión</div>
      <form action="/velora-mvc/index.php?controller=auth&action=login" method="POST">
        <label for="email">Correo electrónico</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" required>

        <a href="/velora-mvc/views/r.contraseña.php" class="forgot">¿Olvidaste tu contraseña?</a>

        <button type="submit" class="btn-continuar">Continuar</button>
      </form>

      <p class="register">
        ¿Aún no tienes cuenta?
        <a href="/velora-mvc/index.php?controller=auth&action=crear">Crear cuenta</a>
      </p>
    </div>
  </div>

  <?php if (isset($_GET['error']) && $_GET['error'] === 'credenciales'): ?>
  <div id="modal-error" class="modal-error">
    <div class="modal-content">
      <button class="close" onclick="document.getElementById('modal-error').style.display='none'">
        <i class="fas fa-times"></i>
      </button>
      <h2 style="color:#7c4dff; margin-bottom:10px;">Error de inicio de sesión</h2>
      <p style="color:#333; font-size:1.1em;">
        Correo o contraseña incorrectos.<br>
        Por favor, verifica tus datos e intenta de nuevo.
      </p>
    </div>
  </div>
  <?php endif; ?>

</body>
</html>
