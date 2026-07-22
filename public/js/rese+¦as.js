document.addEventListener('DOMContentLoaded', function() {
    const estrellas = document.querySelectorAll('.estrellas-interactivas i');
    const estrellasPromedio = document.querySelectorAll('.estrellas-promedio i');
    const cantidadResenas = document.getElementById('cantidad-resenas');
    const barraInteractiva = document.getElementById('estrellas-interactivas');
    const mensajeGracias = document.getElementById('mensaje-gracias');
    let totalResenas = window.totalResenas || 0;
    const productoId = window.productoId || null;

    function mostrarCalificacionUsuario(calificacion) {
        estrellasPromedio.forEach((s, i) => {
            s.className = (i < calificacion) ? 'fas fa-star' : 'far fa-star';
        });
        barraInteractiva.style.display = 'none';
        mensajeGracias.style.display = 'block';
    }

    const calificado = localStorage.getItem('calificado_' + productoId);
    if (calificado) {
        cantidadResenas.textContent = (totalResenas + 1) + ' reseña' + ((totalResenas + 1) === 1 ? '' : 's');
        mostrarCalificacionUsuario(parseInt(calificado));
    } else {
        barraInteractiva.style.display = 'flex';
        mensajeGracias.style.display = 'none';
        estrellas.forEach((star, idx) => {
            star.addEventListener('mouseover', () => {
                estrellas.forEach((s, i) => s.classList.toggle('inactivo', i > idx));
            });
            star.addEventListener('mouseout', () => {
                estrellas.forEach((s) => s.classList.add('inactivo'));
            });
            star.addEventListener('click', () => {
                // AJAX para guardar en la base de datos
                fetch('/velora-mvc/controllers/guardar_reseña.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'producto_id=' + encodeURIComponent(productoId) + '&estrellas=' + encodeURIComponent(idx + 1)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        localStorage.setItem('calificado_' + productoId, (idx + 1));
                        cantidadResenas.textContent = (totalResenas + 1) + ' reseña' + ((totalResenas + 1) === 1 ? '' : 's');
                        mostrarCalificacionUsuario(idx + 1);
                    } else {
                        alert('No se pudo registrar tu calificación. Intenta de nuevo.');
                    }
                })
                .catch(() => {
                    alert('Error de conexión. Intenta de nuevo.');
                });
            });
        });
    }
});