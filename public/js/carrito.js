document.addEventListener('DOMContentLoaded', function() {
  // Abrir carrito al hacer click en el icono
  document.querySelectorAll('a[href$="carrito.php"], a[href="/carrito"]').forEach(function(btn) {
    btn.addEventListener('click', function(e) {
      e.preventDefault();
      document.getElementById('offcanvasCarrito').classList.add('abierto');
      document.body.style.overflow = 'hidden';
    });
  });

  // Cerrar carrito
  document.getElementById('cerrarCarrito').addEventListener('click', function() {
    document.getElementById('offcanvasCarrito').classList.remove('abierto');
    document.body.style.overflow = '';
  });
});