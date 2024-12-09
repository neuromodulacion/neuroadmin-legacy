<?php

$titulo = "Directorio";
$genera = "";
$ruta = "../";

include($ruta . 'header1.php');

$where = "";
switch ($funcion_id) {
    case 1:
        // Sin filtro específico
        $where = "";
    case 5:
        // Sin filtro específico
        $where = "";
        break;

    case 8:
        $where = "WHERE funciones.funcion IN ('MEDICO', 'TECNICO')";
        break;

    case 7:
        $where = "WHERE funciones.funcion IN ('MEDICO', 'TECNICO', 'COORDINADOR', 'REPRESENTANTE', 'RECEPCION')";
        break;

    case 2:
    case 6:
        $where = "WHERE funciones.funcion IN ('MEDICO')";
        break;

    default:
        die("Función no válida.");
}

?>
<link href="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
<link href="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />
<link href="<?php echo $ruta; ?>plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
<link href="<?php echo $ruta; ?>plugins/waitme/waitMe.css" rel="stylesheet" />
<link href="<?php echo $ruta; ?>plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" /> 

<?php  
include($ruta . 'header2.php'); 
?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>INVITACIÓN USUARIOS</h2>
            <?php echo htmlspecialchars($ubicacion_url, ENT_QUOTES, 'UTF-8'); ?>
        </div>

        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div style="height: 95%" class="header">
                        <form id="wizard_with_validation">
                            <h1 align="center">Invitación Usuarios</h1>
                            <fieldset>
                                <?php
                                try {
                                    $sql_funciones = "
                                        SELECT funciones.funcion_id, funciones.funcion AS funciony
                                        FROM funciones
                                        $where
                                        ORDER BY 2 ASC";
                                    //echo $sql_funciones."<hr>";
                                    $result_funciones = $mysql->consulta($sql_funciones);
                                    ?>
                               <div class="form-group form-float">
                                    <hr>
                                    <h2>Selecciona el perfil del usuario a invitar</h2>
                                    <br>
                                    <select id="funcion" name="funcion" class="form-control show-tick">
                                        <?php
                                            if ($result_funciones['numFilas'] > 0) {
                                                foreach ($result_funciones['resultado'] as $row_funciones) {
                                                    $funciony = htmlspecialchars($row_funciones['funciony'], ENT_QUOTES, 'UTF-8');
                                                    echo "<option value='$funciony'>$funciony</option>";
                                                }
                                            } else {
                                                echo "<option value=''>No se encontraron perfiles</option>";
                                            }
                                        } catch (Exception $e) {
                                            error_log("Error en la consulta: " . $e->getMessage());
                                            echo "<option value=''>Error al cargar los perfiles</option>";
                                        }
                                        ?>
                                    </select>
                                    <label class="form-label">Tipo de Usuario</label>                
                                </div>

                                <div class="demo-switch">
                                    <input type="hidden" id="uso" name="uso" value="multiple" />
                                    <div class="switch">
                                        <label>Uso Unico<input id="uso_b" name="uso_b" type="checkbox" checked><span class="lever"></span>Multiple</label>
                                    </div>
                                    <script>
                                        $('#uso_b').click(function(){ 
                                            var uso = $('#uso').val();
                                            $('#uso').val(uso === "multiple" ? "unico" : "multiple");
                                        });
                                    </script>
                                </div>
                            </fieldset>
                            <hr>

                            <div class="row clearfix demo-button-sizes">
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                    <button id="boton" type="button" class="btn bg-green btn-block btn-lg waves-effect">GENERA INVITACIÓN</button>
                                </div>
                            </div>
                        </form>
                        <hr>

                        <div id="contenido" class="form-group form-float" style="max-height: 300px;"></div>

                        <script>
                            $('#boton').click(function(event){ 
                                event.preventDefault();
                                var funcion = $('#funcion').val();
                                var uso = $('#uso').val();
                                var usuario_id = '<?php echo htmlspecialchars($usuario_id, ENT_QUOTES, 'UTF-8'); ?>';
                                var empresa_id = '<?php echo htmlspecialchars($empresa_id, ENT_QUOTES, 'UTF-8'); ?>';
                                var time = '<?php echo htmlspecialchars($time, ENT_QUOTES, 'UTF-8'); ?>';

                                $.ajax({
                                    url: 'genera_liga.php',
                                    type: 'POST',
                                    data: { funcion, usuario_id, empresa_id, uso, time },
                                    cache: false,
                                    success:function(html){     
                                        $('#contenido').html(html);
                                    }
                                });
                            });

                            $('#copiar-contenido').click(function(event) {
                                event.preventDefault();
                                var contenido = $('#contenido').text();
                                var textarea = $('<textarea>').val(contenido).appendTo('body').select();
                                document.execCommand('copy');
                                textarea.remove();
                                alert('Contenido copiado al portapapeles.');
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php  
include($ruta . 'footer1.php'); 
?>

<script src="<?php echo $ruta; ?>plugins/jquery-datatable/jquery.dataTables.js"></script>
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>

<script src="<?php echo $ruta; ?>js/pages/tables/jquery-datatable.js"></script>

<?php  
include($ruta . 'footer2.php'); 
?>
