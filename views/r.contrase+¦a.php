<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Restaurar contraseña | Velora</title>
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

    <!-- 🔐 Restaurar contraseña -->
    <div class="login-right">
      <a href="/velora-mvc/views/login.php" class="back-arrow"><i class="fas fa-arrow-left"></i></a>
      <div class="titulo-login">Restaurar contraseña</div>
      <div class="subtitulo-restaurar" style="margin-bottom:28px;text-align:center;">
        Enviaremos un código al correo registrado
      </div>
      <form action="?controller=auth&action=restaurar" method="POST">
        <label for="email" class="label-box" style="color:inherit;">Correo electrónico</label>
        <input type="email" id="email" name="email" required>

        <label for="codigo" class="label-box" style="color:inherit;">Código</label>
        <input type="text" id="codigo" name="codigo" required>

        <button type="submit">Continuar</button>
      </form>
    </div>
  </div>

</body>
</html>