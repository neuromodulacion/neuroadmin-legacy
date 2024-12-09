<?php // medicos.php 
$ruta = "../"; // Ajustar según tu estructura
$titulo = "Administrar Médicos";
include($ruta.'header1.php');

// Opcionalmente incluye estilos adicionales si los requieres
?>
<!-- Aquí podrían ir CSS extras -->
<?php
include($ruta.'header2.php');

// Asumimos que tienes el $empresa_id del usuario logueado:
//$empresa_id = 1; // Ajustar según tu lógica real, por ejemplo, obtener del usuario logueado
?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>MÉDICOS CONSULTORIO</h2>
        </div>
        <?php echo htmlspecialchars($ubicacion_url, ENT_QUOTES, 'UTF-8')."<br>"; ?>
        <!-- Formulario para dar de alta un médico -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Dar de Alta un Médico</h2>
                    </div>
                    <div class="body">
                        <form id="formAltaMedico">
                            <input type="hidden" name="empresa_id" value="<?php echo htmlspecialchars($empresa_id, ENT_QUOTES, 'UTF-8'); ?>">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <label for="medico">Nombre del Médico</label>
                                    <input type="text" name="medico" id="medico" class="form-control" placeholder="Ej: Dr. Juan Pérez" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </form>
                        <div id="resultadoAlta"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla para mostrar médicos existentes -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Listado de Médicos</h2>
                    </div>
                    <div class="body">
                        <table class="table table-striped" id="tablaMedicos">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Médico</th>
                                    <th>Empresa ID</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Filas generadas vía AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    cargarMedicos();

    $('#formAltaMedico').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: 'medicos_alta.php',
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(resp) {
                $('#resultadoAlta').text(resp.message);
                if(resp.success) {
                    $('#formAltaMedico')[0].reset();
                    cargarMedicos();
                }
            },
            error: function() {
                $('#resultadoAlta').text('Error al guardar el médico.');
            }
        });
    });
});

function cargarMedicos() {
    var empresa_id = $('input[name="empresa_id"]').val(); // Obtener el valor de empresa_id desde el formulario
    console.log("empresa_id:", empresa_id); // Para depuración

    $.ajax({
        url: 'medicos_listado.php',
        method: 'POST', // Cambiado a POST
        data: { empresa_id: empresa_id }, // Enviar empresa_id
        dataType: 'json',
        success: function(resp) {
            console.log("Respuesta:", resp); // Para depuración
            if(resp.success) {
                var tbody = $('#tablaMedicos tbody');
                tbody.empty();
                resp.data.forEach(function(medico) {
                    var row = '<tr>' +
                                '<td>' + medico.medico_id + '</td>' +
                                '<td>' + (medico.medico ? medico.medico : '') + '</td>' +
                                '<td>' + medico.empresa_id + '</td>' +
                                '<td>' +
                                    '<button class="btn btn-sm btn-danger" onclick="eliminarMedico('+medico.medico_id+')">Eliminar</button>' +
                                '</td>' +
                              '</tr>';
                    tbody.append(row);
                });
            } else {
                console.log(resp.message);
            }
        },
        error: function() {
            console.log('Error al cargar la lista de médicos.');
        }
    });
}

function eliminarMedico(medico_id) {
    if(confirm('¿Seguro que desea eliminar este médico?')) {
        $.ajax({
            url: 'medicos_eliminar.php',
            method: 'POST',
            data: { medico_id: medico_id },
            dataType: 'json',
            success: function(resp) {
                if(resp.success) {
                    cargarMedicos();
                } else {
                    alert(resp.message);
                }
            },
            error: function() {
                alert('Error al eliminar el médico.');
            }
        });
    }
}
</script>

<?php 
include($ruta.'footer1.php'); 
?>
<!-- Scripts adicionales (si los requieres) -->
<?php 
include($ruta.'footer2.php'); 
?>
