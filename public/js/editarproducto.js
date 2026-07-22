document.addEventListener('DOMContentLoaded', function() {
    // Botón editar producto
    const editarProductoButtons = document.querySelectorAll('.editar-producto-btn');
    editarProductoButtons.forEach(button => {
        button.addEventListener('click', () => {
            const id = button.getAttribute('data-id');
            const nombre = button.getAttribute('data-nombre');
            const precio = button.getAttribute('data-precio');
            const stock = button.getAttribute('data-stock');
            const ubicacion = button.getAttribute('data-ubicacion');

            document.getElementById('editProductoId').value = id;
            document.getElementById('editProductoNombre').value = nombre;
            document.getElementById('editProductoPrecio').value = precio;
            document.getElementById('editProductoStock').value = stock;

            // Marcar las ubicaciones correspondientes
            document.querySelectorAll('input[name="ubicacion[]"]').forEach(function(input) {
                input.checked = false;
            });
            if (ubicacion) {
                ubicacion.split(',').forEach(function(ubi) {
                    var idCheck = 'ubicacion' + ubi.trim().charAt(0).toUpperCase() + ubi.trim().slice(1);
                    var check = document.getElementById(idCheck);
                    if (check) check.checked = true;
                });
            }
        });
    });

    // Botón eliminar producto
    const eliminarProductoButtons = document.querySelectorAll('a.eliminar-producto-btn');
    eliminarProductoButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirm('¿Seguro que deseas eliminar este producto?')) {
                e.preventDefault();
            }
        });
    });

    // Botón aplicar descuento
    const descuentoProductoButtons = document.querySelectorAll('.descuento-producto-btn');
    descuentoProductoButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const id = button.getAttribute('data-id');
            document.getElementById('descuentoProductoId').value = id;
            const modal = new bootstrap.Modal(document.getElementById('modalDescuentoProducto'));
            modal.show();
        });
    });
});