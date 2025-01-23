<?php
// Establece la ruta relativa al directorio principal
$ruta="../";

// Inicializa variables con la fecha y hora actuales
$hoy = date("Y-m-d");
$ahora = date("H:i:00"); 
$anio = date("Y");
$mes_ahora = date("m");
$titulo = "Directorio"; // Título de la página

// Función para verificar si $id_bind es null
function verificar_id_bind($id_bind) {
    // Retorna "no" si $id_bind es null, de lo contrario retorna "ok"
    return is_null($id_bind) ? "no" : "ok";
}

// Incluye el primer archivo de cabecera
include($ruta.'header1.php');
?>
    <!-- Incluye el estilo CSS para JQuery DataTable -->
    <link href="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

<?php
// Incluye el segundo archivo de cabecera
include($ruta.'header2.php');
	
	// Establece condiciones para filtrar la lista de pacientes dependiendo del rol del usuario
	if ($funcion == 'SISTEMAS' || $funcion == 'ADMINISTRADOR' || $funcion == 'TECNICO' || $funcion == 'COORDINADOR') {
	    $class = "js-exportable";    
	    $where = "AND pacientes.empresa_id=$empresa_id "; // Filtra por empresa para ciertos roles
	} else {
	    $class = "js-basic-example";
	    if ($funcion == 'MEDICO') {
	        // Filtra por empresa y usuario para el rol de médico
	        $where = " AND pacientes.empresa_id=$empresa_id AND pacientes.usuario_id = $usuario_id";
	    } else {
	        $where = "";
	    }
	}

?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>DIRECTORIO</h2> <!-- Título de la sección -->
            <?php echo $ubicacion_url."<br>"; ?> 
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div style="height: 95%" class="header">
                        <h1 align="center">Directorio Pacientes</h1>                           
                        <div class="body">
                            <div class="table-responsive">
                            <div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable <?php echo htmlspecialchars($class); ?>">
        <thead>
            <tr>
                <th style="display: none;"></th>
                <th style="max-width: 10px">ID</th>
                <th style="max-width: 10px">ID Bind</th>
                <th style="min-width: 140px">Nombre</th>
                <th style="min-width: 45px">Celular</th>
                <th style="min-width: 100px">Email</th>
                <th style="min-width: 80px">Medico</th>
                <th style="min-width: 20px">Bind</th>
                <th style="min-width: 20px">Accion</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th style="display: none;"></th>
                <th>ID</th>
                <th>ID Bind</th>
                <th>Nombre</th>
                <th>Celular</th>
                <th>Email</th>
                <th>Medico</th>
                <th>Bind</th>
                <th>Accion</th>
            </tr>
        </tfoot>
        <tbody>
        <?php

        // Consulta SQL utilizando parámetros seguros
        $query = "
            SELECT
                paciente_consultorio.paciente_cons_id,
                pacientes_bind.Number, 
                paciente_consultorio.paciente_id, 
                paciente_consultorio.paciente, 
                paciente_consultorio.apaterno, 
                paciente_consultorio.amaterno, 
                paciente_consultorio.celular, 
                paciente_consultorio.email, 
                paciente_consultorio.empresa_id, 
                paciente_consultorio.id_bind, 
                paciente_consultorio.f_alta, 
                paciente_consultorio.medico
            FROM
                paciente_consultorio
                INNER JOIN pacientes_bind ON paciente_consultorio.id_bind = pacientes_bind.ID
            WHERE
                paciente_consultorio.empresa_id = ?
            ORDER BY
                paciente_consultorio.paciente ASC, 
                paciente_consultorio.apaterno ASC
        ";

        // Ejecutar consulta con parámetros
        $params = [$empresa_id];
        $resultado = $mysql->consulta($query, $params);

        if ($resultado['numFilas'] > 0) {
            $cnt = 0;
            foreach ($resultado['resultado'] as $fila) {
                $cnt++;

                if (!empty($fila['f_alta'])) {
                    // Intenta formatear la fecha si no está vacía
                    $f_alta = DateTime::createFromFormat('Y-m-d', $fila['f_alta']);
                    if ($f_alta) {
                        // Si la conversión es exitosa, aplica el formato deseado
                        $today = $f_alta->format('d-M-Y');
                    } else {
                        // Si falla la conversión, define un valor predeterminado
                        $today = 'Fecha inválida';
                    }
                } else {
                    // Define un valor predeterminado si la fecha está vacía o nula
                    $today = 'Sin fecha';
                }
        ?>
                <tr>
                    <td style="display: none;"><?php echo htmlspecialchars($cnt); ?></td>
                    <td><?php echo htmlspecialchars($fila['paciente_cons_id']); ?></td>
                    <td><?php echo htmlspecialchars($fila['Number']); ?></td>
                    <td>
                        <b>
                            <?php echo codificacionUTF(htmlspecialchars(
                                $fila['paciente'] . " " . $fila['apaterno'] . " " . $fila['amaterno']
                            )); ?>
                        </b>
                    </td>
                    <td><?php echo htmlspecialchars($fila['celular']); ?></td>
                    <td><?php echo htmlspecialchars($fila['email']); ?></td>
                    <td><?php echo codificacionUTF(htmlspecialchars($fila['medico'])); ?></td>
                    <td><?php echo htmlspecialchars(verificar_id_bind($fila['id_bind'])); ?></td>
                    <td>
                        <!-- Botón de edición comentado; habilitar si es necesario -->
                        <!-- <button type="button" class="btn btn-info waves-effect m-r-20 edit-btn" data-paciente-id="<?php echo $fila['paciente_cons_id']; ?>"><i class="material-icons">edit</i> <b>Edit</b></button> -->
                    </td>
                </tr>
        <?php
            }
        } else {
            echo "<tr><td colspan='9'>No se encontraron resultados.</td></tr>";
        }

        $mysql->desconectarse();
        ?>
        </tbody>
    </table>
</div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Botón oculto para abrir el modal de edición -->
    <button style="display: none" id="modal" type="button" class="btn btn-info waves-effect m-r-20" data-toggle="modal" data-target="#ModalEdit"><i class="material-icons">edit</i> <B>Edit</B></button>

    <!-- Modal para editar información del paciente -->
    <div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="ModalEditLabel">Actualiza Paciente</h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor"></div> <!-- Contenedor para el contenido del modal -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect">GUARDAR</button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
                </div>
            </div>
        </div>
    </div>

<?php
// Incluye el primer pie de página
include($ruta.'footer1.php'); 
?>

<!-- Incluye los scripts JS para los diferentes plugins de DataTables -->
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/jquery.dataTables.js"></script>
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>

<!-- Inicializa DataTables -->
<script src="<?php echo $ruta; ?>js/pages/tables/jquery-datatable.js"></script>

<!-- Script para manejar la apertura del modal y la carga de los datos -->
<script>
    $(document).ready(function(){
        $('.edit-btn').on('click', function(){
            $('#contenedor').html(''); // Limpia el contenido del contenedor del modal
            var paciente_cons_id = $(this).data('paciente-id'); // Obtiene el ID del paciente
            var tipo = 'consulta';
            var datastring = 'paciente_cons_id=' + paciente_cons_id + '&tipo=' + tipo;

            $('#modal').click(); // Abre el modal

            // Envía una solicitud AJAX para obtener los datos del paciente y mostrarlos en el modal
            $.ajax({
                url: 'modifica_paciente_consulta.php',
                type: 'POST',
                data: datastring,
                cache: false,
                success:function(html){     
                    $('#contenedor').html(html); // Inserta el contenido en el modal
                },
                error: function(xhr, status, error) {
                    $('#contenedor').html('<div class="alert alert-danger" role="alert">Hubo un error al procesar la solicitud.</div>'); // Muestra un mensaje de error en caso de fallo
                }
            });
        });
    });
</script>

<?php 
// Incluye el segundo pie de página
include($ruta.'footer2.php'); 
?>
