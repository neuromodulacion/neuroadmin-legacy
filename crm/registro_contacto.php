<?php
$ruta = "../";
$titulo = "Registros Contacto";
include($ruta . 'header1.php');
?>
    <link href="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
    
     <!-- Bootstrap Material Datetime Picker Css -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

    <!-- Bootstrap DatePicker Css -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />

    <!-- Wait Me Css -->
    <link href="<?php echo $ruta; ?>plugins/waitme/waitMe.css" rel="stylesheet" />

    <!-- Bootstrap  Css -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />   
<?php
include($ruta.'header2.php'); 

// Nota include('conexion_mysqli.php'); y $mysql se cargan en header1.php
// Consultar los médicos disponibles en la tabla `admin_temp`
$query = "SELECT
	admin_tem.medico_id,
	admin_tem.nombre,
	admin_tem.telefono,
	admin_tem.domicilio 
FROM
	admin_tem 
WHERE
	admin_tem.empresa_id = ?";
$medicos = $mysql->consulta($query, [$_SESSION['empresa_id']]);
?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Registro de Contacto con Médicos</h2>
        </div>

        <div class="card">
            <div class="header">
                <h2>Registrar Contacto</h2>
            </div>
            <div class="body">
                <form id="registro_contacto" method="POST" action="guardar_contacto.php">
                    <!-- Enviar usuario_id y empresa_id como datos ocultos -->
                    <input type="hidden" name="usuario_id" value="<?php echo $_SESSION['usuario_id']; ?>">
                    <input type="hidden" name="empresa_id" value="<?php echo $_SESSION['empresa_id']; ?>">

                    <!-- Selección de médico -->
                    <div class="form-group">
                        <label for="medico">Seleccione un médico:</label>
                        <select id="medico" name="medico_id" class="form-control" required>
                            <option value="">Seleccione</option>
                            <?php if ($medicos['numFilas'] > 0): ?>
                                <?php foreach ($medicos['resultado'] as $medico): ?>
                                    <?php 
                                    $medico_id = htmlspecialchars($medico['medico_id'], ENT_QUOTES, 'UTF-8');
                                    $nombre = htmlspecialchars($medico['nombre'], ENT_QUOTES, 'UTF-8');
                                    $telefono = htmlspecialchars($medico['telefono'], ENT_QUOTES, 'UTF-8');
                                    $domicilio = htmlspecialchars($medico['domicilio'], ENT_QUOTES, 'UTF-8');
                                    ?>
                                    <option value="<?php echo $medico_id; ?>" 
                                            data-telefono="<?php echo $telefono; ?>" 
                                            data-domicilio="<?php echo $domicilio; ?>">
                                        <?php echo $nombre; ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="">No hay médicos disponibles</option>
                            <?php endif; ?>
                        </select>
                    </div>

                    <!-- Información del médico seleccionada dinámicamente -->
                    <div class="form-group">
                        <label for="telefono">Teléfono:</label>
                        <input type="text" id="telefono" name="telefono" class="form-control" readonly>
                    </div>

                    <div class="form-group">
                        <label for="domicilio">Domicilio:</label>
                        <textarea id="domicilio" name="domicilio" class="form-control" readonly></textarea>
                    </div>

                    <!-- Método de contacto -->
                    <div class="form-group">
                        <label for="metodo_contacto">Método de contacto:</label>
                        <select id="metodo_contacto" name="metodo_contacto" class="form-control" required>
                            <option value="correo">Correo Electrónico</option>
                            <option value="telefono">Teléfono</option>
                            <option value="visita">Visita</option>
                        </select>
                    </div>

                    <!-- Resultado del contacto -->
                    <div class="form-group">
                        <label for="exito">¿Contacto exitoso?</label>
                        <select id="exito" name="exito" class="form-control" required>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>

                    <!-- Observaciones -->
                    <div class="form-group">
                        <label for="observaciones">Observaciones:</label>
                        <textarea id="observaciones" name="observaciones" class="form-control"></textarea>
                    </div>

                    <!-- Botón de envío -->
                    <button type="submit" class="btn btn-primary">Guardar Contacto</button>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    // Script para actualizar dinámicamente teléfono y domicilio al seleccionar un médico
    $(document).ready(function() {
        $('#medico').change(function() {
            var selectedOption = $(this).find(':selected');
            $('#telefono').val(selectedOption.data('telefono'));
            $('#domicilio').val(selectedOption.data('domicilio'));
        });
    });
</script>

<?php	include($ruta.'footer1.php');	?>

    <!-- Moment Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/momentjs/moment.js"></script>

    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

    <!-- Bootstrap Datepicker Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

    <!-- Waves Effect Plugin Js -->
    <!-- Autosize Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/autosize/autosize.js"></script>

    <!-- Moment Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/momentjs/moment.js"></script>


<?php	include($ruta.'footer2.php');	?>
