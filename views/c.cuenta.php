<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Crear cuenta | Velora</title>
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

    <!-- 📝 Crear cuenta -->
    <div class="login-right">
      <a href="/velora-mvc/views/login.php" class="back-arrow"><i class="fas fa-arrow-left"></i></a>
      <div class="titulo-login">Crear cuenta</div>
      <form action="?controller=auth&action=crear" method="POST">
        <label for="usuario" class="label-box">Nombre de usuario</label>
        <input type="text" id="usuario" name="usuario" required>

        <label for="correo" class="label-box">Correo</label>
        <input type="email" id="correo" name="correo" required>

        <label for="password" class="label-box">Contraseña</label>
        <input type="password" id="password" name="password" required>

        <div style="display: flex; gap: 16px; justify-content: center; margin-top: 10px;">
          <button type="button" onclick="window.location.href='/velora-mvc/views/login.php'">Cancelar</button>
          <button type="submit" class="btn-continuar">Continuar</button>
        </div>
      </form>
    </div>
  </div>

  <?php if (isset($_GET['error']) && $_GET['error'] === 'existente'): ?>
  <div id="modal-error" class="modal-error">
    <div class="modal-content">
      <button class="close" onclick="document.getElementById('modal-error').style.display='none'">
        <i class="fas fa-times"></i>
      </button>
      <h2 style="color:#7c4dff; margin-bottom:10px;">¡Atención!</h2>
      <p style="color:#333; font-size:1.1em;">
        El usuario o correo ya existen.<br>
        Por favor, intenta con otros datos.
      </p>
    </div>
  </div>
  <style>
  .modal-error {
    display: flex;
    align-items: center;
    justify-content: center;
    position: fixed;
    z-index: 9999;
    left: 0; top: 0; width: 100vw; height: 100vh;
    background: rgba(124,77,255,0.10);
  }
  .modal-content {
    background: #fff;
    border: 2px solid #7c4dff;
    box-shadow: 0 4px 24px rgba(124,77,255,0.15);
    border-radius: 16px;
    padding: 32px 24px 24px 24px;
    width: 90%;
    max-width: 350px;
    text-align: center;
    position: relative;
    animation: modalIn 0.3s;
  }
  @keyframes modalIn {
    from { transform: scale(0.8); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
  }
  .close {
    position: absolute;
    right: 16px;
    top: 16px;
    background: none;
    border: none;
    font-size: 1.5em;
    color: #7c4dff;
    cursor: pointer;
    transition: color 0.2s;
  }
  .close:hover {
    color: #333;
  }
  </style>
  <?php endif; ?>

</body>
</html>