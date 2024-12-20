$(document).ready(function() {
    // Guardar Empresa
    $('#empresa-form').submit(function(e) {
        e.preventDefault();
        const formData = $(this).serialize();
        $.post('controlador.php?action=guardar_empresa', formData, function(response) {
            alert(response.message);
            location.reload();
        }, 'json');
    });

    // Eliminar Empresa
    $('.btn-delete').click(function() {
        const id = $(this).closest('tr').data('id');
        if (confirm('¿Seguro que deseas eliminar esta empresa?')) {
            $.post('controlador.php?action=eliminar_empresa', { id }, function(response) {
                alert(response.message);
                location.reload();
            }, 'json');
        }
    });

    // Similar para sucursales...
});
