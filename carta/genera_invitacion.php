<?php

// Obtener la fecha y hora actuales para uso en el script
$hoy = date("Y-m-d");
$ahora = date("H:i:00"); 
$anio = date("Y");
$mes_ahora = date("m");
$mes = strftime("%B"); // Nombre del mes en español
$dia = date("N"); // Día de la semana (1-7, donde 1 es lunes)
$semana = date("W"); // Número de la semana del año

$titulo = "Directorio"; // Título de la página
$genera = ""; // Variable para posibles usos adicionales

$ruta = "../"; // Ruta base para incluir archivos y recursos

// Incluir el primer encabezado (header1.php)
include($ruta.'header1.php');
?>

<!-- Enlace a los archivos CSS para tablas y selectores de fechas y tiempo -->
<link href="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
<link href="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />
<link href="<?php echo $ruta; ?>plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
<link href="<?php echo $ruta; ?>plugins/waitme/waitMe.css" rel="stylesheet" />
<link href="<?php echo $ruta; ?>plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" /> 

<?php  
// Incluir el segundo encabezado (header2.php)
include($ruta.'header2.php'); 
?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>INVITACIÓN CARTA PERRO</h2>
        </div>

        <!-- Contenedor principal del formulario para generar invitaciones a usuarios -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div style="height: 95%" class="header">

                        <!-- Formulario para generar la invitación -->
                        <form id="wizard_with_validation">                            
                            <h1 align="center">Invitación Carta Perro Soporte Emocional</h1>
                            <fieldset>
                            	<div align="center">
                            		<a style="width: 400px" href="#" class="thumbnail"><img src="../images/perro_servicio.jpg" alt="Perro de servicio"></a>
                            	</div>
                                <!-- Selección del perfil del usuario a invitar -->
                                <!-- <div class="form-group form-float">
                                    <hr>
                                    <h2>Selecciona el perfil del usuario a invitar</h2><br>
                                    <select id="funcion" name="funcion" class="form-control show-tick">
                                        <?php if ($funcion == 'ADMINISTRADOR' || $funcion == 'SISTEMAS' ) { ?>
                                            <option value="ADMINISTRADOR">ADMINISTRADOR</option>    
                                        <?php } ?>    
                                        <option value="COORDINADOR" selected>COORDINADOR</option>                                                
                                        <option value="MEDICO" selected>MEDICO</option>
                                        <option value="RECEPCION">RECEPCION</option>
                                        <option value="TECNICO">TECNICO</option>
                                    </select>
                                    <label class="form-label">Tipo de Usuario</label>                
                                </div> -->
                                
                                <!-- Opción para seleccionar si el uso de la invitación es único o múltiple -->
                                <div class="demo-switch">
                                    <input type="hidden" id="uso" name="uso" value="unico" />                                    
                                </div>
                            </fieldset>
                            <hr>
                            
                            <!-- Botón para generar la invitación -->
                            <div class="row clearfix demo-button-sizes">
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                    <button id="boton" type="button" class="btn bg-green btn-block btn-lg waves-effect">GENERA INVITACIÓN</button>
                                </div>
                            </div>
                        </form> 
                        <hr>
                        
                        <!-- Contenedor donde se mostrará el contenido generado -->
                        <div id="contenido" class="form-group form-float" style="max-height: 300px;"></div>
                        
                        <script>
                            // Enviar solicitud AJAX para generar la invitación al hacer clic en el botón
                            $('#boton').click(function(){ 
                                event.preventDefault();
                                var funcion = $('#funcion').val();
                                var uso = $('#uso').val();
                                var usuario_id = '<?php echo $usuario_id; ?>';
                                var empresa_id = '<?php echo $empresa_id; ?>';
                                var time = '<?php echo $time; ?>';
                                var datastring = 'funcion='+funcion+'&usuario_id='+usuario_id+'&empresa_id='+empresa_id+'&uso='+uso+'&time='+time;
                                $.ajax({
                                    url: 'genera_liga.php',
                                    type: 'POST',
                                    data: datastring,
                                    cache: false,
                                    success:function(html){     
                                        $('#contenido').html(html); // Mostrar el contenido generado en el div "contenido"
                                    }
                                });
                            });
                        </script>

                        <!-- Botón para copiar el contenido generado al portapapeles -->
                        <button id="copiar-contenido" type="button" class="btn btn-primary">Copiar Contenido</button>

                        <script>
                            // Función para copiar el contenido del div "contenido" al portapapeles
                            $(document).ready(function() {
                                $('#copiar-contenido').click(function() {
                                    event.preventDefault();
                                    var contenido = $('#contenido').text(); // Obtener solo el texto sin HTML
                                    var textarea = document.createElement("textarea");
                                    textarea.value = contenido;
                                    document.body.appendChild(textarea);
                                    textarea.select();
                                    document.execCommand('copy');
                                    document.body.removeChild(textarea);
                                    alert('El contenido de texto ha sido copiado al portapapeles.');
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php  
// Incluir el primer pie de página (footer1.php)
include($ruta.'footer1.php'); 
?>

<!-- Enlace a los scripts necesarios para las tablas y otros componentes -->
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
// Incluir el segundo pie de página (footer2.php)
include($ruta.'footer2.php'); 
?>