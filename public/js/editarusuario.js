document.addEventListener('DOMContentLoaded', function() {
  const editarUsuarioButtons = document.querySelectorAll('a.editar-usuario-btn');
  editarUsuarioButtons.forEach(button => {
    button.addEventListener('click', () => {
      document.getElementById('editUsuarioId').value = button.getAttribute('data-id');
      document.getElementById('editUsuarioNombre').value = button.getAttribute('data-nombre');
      document.getElementById('editUsuarioCorreo').value = button.getAttribute('data-correo');
      document.getElementById('editUsuarioRol').value = button.getAttribute('data-rol');
    });
  });
});