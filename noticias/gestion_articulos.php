<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Definir la ruta base para las inclusiones de archivos
$ruta = "../";

// Obtener la fecha actual en formato "YYYY-MM-DD"
$hoy = date("Y-m-d");
$ahora = date("H:i:00"); 
$anio = date("Y");
$mes_ahora = date("m");
$titulo = "News Edit";

// Incluir la primera parte del header
include($ruta.'header1.php');

// Variables para el formulario
$titulo = "";
$titulo_corto = "";
$descripcion = "";
$insert_multimedia = ""; // Radio para imagen o video
$multimedia = "";
$autor = "";
$titulo_autor = ""; 
$imagen_autor = ""; 
$estatus = ""; 
$imagen_chica = ""; 
$imagen_portada = ""; 
$contenido = "";
$articulo_id = "";

// Definir acciones (agregar, editar, eliminar)
$action = isset($_POST['action']) ? $_POST['action'] : '';
if ($action == 'guardar') {
    // Guardar cambios del formulario de edición
    $articulo_id = $_POST['articulo_id'];
    $titulo = $_POST['titulo'];
    $titulo_corto = $_POST['titulo_corto'];
    $descripcion = $_POST['descripcion'];
    $insert_multimedia = $_POST['insert_multimedia']; // Radio para imagen o video
    $multimedia = $_POST['multimedia'];
    $autor = $_POST['autor'];
    $titulo_autor = $_POST['titulo_autor'];
    $imagen_autor = $_POST['imagen_autor'];
    $estatus = $_POST['estatus'];
    $imagen_chica = $_POST['imagen_chica'];
    $imagen_portada = $_POST['imagen_portada'];
    $contenido = $_POST['contenido'];

    // Actualizar el artículo
    $query = "UPDATE articulo SET titulo = '$titulo', titulo_corto = '$titulo_corto', descripcion = '$descripcion', insert_multimedia = '$insert_multimedia', multimedia = '$multimedia', autor = '$autor', titulo_autor = '$titulo_autor', imagen_autor = '$imagen_autor', estatus = '$estatus', imagen_chica = '$imagen_chica', imagen_portada = '$imagen_portada', contenido = '$contenido', f_alta = NOW() WHERE articulo_id = $articulo_id";
    $resultado = ejecutar($query);

    if ($resultado) {
        echo "<p>Artículo actualizado con éxito.</p>";
    } else {
        echo "<p>Error al actualizar el artículo.</p>";
    }
} elseif ($action == 'agregar') {
    // Insertar nuevo artículo
    $titulo = $_POST['titulo'];
    $titulo_corto = $_POST['titulo_corto'];
    $descripcion = $_POST['descripcion'];
    $insert_multimedia = $_POST['insert_multimedia'];
    $multimedia = $_POST['multimedia'];
    $autor = $_POST['autor'];
    $titulo_autor = $_POST['titulo_autor'];
    $imagen_autor = $_POST['imagen_autor'];
    $estatus = $_POST['estatus'];
    $imagen_chica = $_POST['imagen_chica'];
    $imagen_portada = $_POST['imagen_portada'];
    $contenido = $_POST['contenido'];

    $query = "INSERT INTO articulo (titulo, titulo_corto, descripcion, insert_multimedia, multimedia, autor, titulo_autor, imagen_autor, estatus, imagen_chica, imagen_portada, contenido, f_alta, h_alta) 
              VALUES ('$titulo', '$titulo_corto', '$descripcion', '$insert_multimedia', '$multimedia', '$autor', '$titulo_autor', '$imagen_autor', '$estatus', '$imagen_chica', '$imagen_portada', '$contenido', NOW(), NOW())";
    $mysqli = ejecutar_id($query);
    
    if ($mysqli->insert_id) {
        echo "<p>Artículo agregado con éxito.</p>";
    } else {
        echo "<p>Error al agregar el artículo.</p>";
    }
    $mysqli->close();
} elseif ($action == 'editar') {
    // Cargar datos del artículo para editar
    $articulo_id = $_POST['articulo_id'];
    $query = "SELECT * FROM articulo WHERE articulo_id = $articulo_id";
    $resultado = ejecutar($query);

    if ($resultado->num_rows > 0) {
        $articulo = $resultado->fetch_assoc();
        $titulo = $articulo['titulo'];
        $titulo_corto = $articulo['titulo_corto'];
        $descripcion = $articulo['descripcion'];
        $insert_multimedia = $articulo['insert_multimedia']; // Asignamos el valor correcto
        $multimedia = $articulo['multimedia'];
        $autor = $articulo['autor'];
        $titulo_autor = $articulo['titulo_autor'];
        $imagen_autor = $articulo['imagen_autor'];
        $estatus = $articulo['estatus'];
        $imagen_chica = $articulo['imagen_chica'];
        $imagen_portada = $articulo['imagen_portada'];
        $contenido = $articulo['contenido'];
    }
} elseif ($action == 'eliminar') {
    // Eliminar artículo
    $articulo_id = $_POST['articulo_id'];
    $query = "DELETE FROM articulo WHERE articulo_id = $articulo_id";
    $resultado = ejecutar($query);

    if ($resultado) {
        echo "<p>Artículo eliminado con éxito.</p>";
    } else {
        echo "<p>Error al eliminar el artículo.</p>";
    }
}

// Consultar los artículos existentes
$query = "SELECT articulo_id, titulo, descripcion, titulo_corto, estatus, f_alta FROM articulo";
$result = ejecutar($query);

$articulos = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $articulos[] = $row;
    }
}

// Incluir archivos CSS adicionales
?>
<link href="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
<link href="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />
<link href="<?php echo $ruta; ?>plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
<link href="<?php echo $ruta; ?>plugins/waitme/waitMe.css" rel="stylesheet" />
<link href="<?php echo $ruta; ?>plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

<style>
    /* Asegurar que los elementos dentro del contenedor no se desborden */
    .container form, .container .table-responsive {
        max-width: 100%;
        overflow: hidden;
    }
    .form-control {
        width: 100%;
    }
</style>

<?php  
include($ruta.'header2.php'); 
?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>INICIO</h2>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="body">
                            <h1>Gestión de Artículos</h1>
          					<div id="foto" >   
								<form id="uploadForm_zz" method="post" enctype="multipart/form-data">
									<div class="row">
									 	 <div class="col-md-6">							    
									    	<div class="thumbnail">
									      		<img width="200px" id="imagePreview_zz" src="../images/nofoto.png" alt="Tu imagen aparecerá aquí" />
									      		<div class="caption">
										        	<h3>Subir fotos</h3>
										        	<p>Es para subirfotos</p>
										        	<p><input class="btn btn-primary"  type="file" name="file" id="file_zz"></p> 
										        	<p><input class="btn btn-default" type="button" value="Subir Foto" id="btnUpload_zz"></p>
													<script>
														$(document).ready(function() {
														    $("#btnUpload_zz").click(function() {
														        var fileInput = $('#file_zz')[0];
														        var filePath = fileInput.value;
														        var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
														        $('#status_zz').html("Cargando...");
														        $('#inputRutaImagen_zz').val("");
														
														        if(!allowedExtensions.exec(filePath)){
														            alert('Por favor sube archivos con las extensiones .jpeg/.jpg/.png/.gif solamente.');
														            fileInput.value = '';
														            return false;
														        }
														
														        var formData = new FormData($("#uploadForm_zz")[0]);
														        $("#btnUpload_zz").prop('disabled', true);
																						
														        $.ajax({
														            url: '../upload.php',
														            type: 'POST',
														            data: formData,
														            contentType: false,
														            processData: false,
														            success: function(data) {
														                $('#status_zz').html("<?php echo $web; ?>/uploads/"+data);
														                $('#inputRutaImagen_zz').val("<?php echo $web; ?>/uploads/"+data);
														                $("#multimedia").val("<?php echo $web; ?>/uploads/"+data); 
														
														                var reader = new FileReader();
														                reader.onload = function (e) {
														                    $('#imagePreview_zz').attr('src', e.target.result).show();
														                };
														                reader.readAsDataURL($("#file_zz")[0].files[0]);
														                $("#btnUpload_zz").prop('disabled', false);
														            },
														            error: function() {
														                $('#status_zz').html('Ocurrió un error al subir la foto.');
														            }
														        });
														    });
														});
													</script>
	
													<div id="status_zz"></div>
													<input type="hidden" id="inputRutaImagen_zz" name="multimedia" value="" >									        
											      	</div>
										    	</div>
										  	</div>	
										</div>
											
										</form>                            
	                           		</div>
                           		<hr>                   
                            <form action="gestion_articulos.php" method="POST">
                                <input type="hidden" name="action" value="<?php echo $articulo_id ? 'guardar' : 'agregar'; ?>">
                                <input type="hidden" name="articulo_id" value="<?php echo $articulo_id; ?>">

                                <h3>Título</h3>(Max 120 Caracteres)
                                <div class="form-line">
                                    <input type="text" id="titulo" name="titulo"  maxlength="120" class="form-control" value="<?php echo $titulo; ?>" required>
                                </div>

                                <h3>Título Corto</h3>(Max 50 Caracteres)
                                <div class="form-line">
                                    <input type="text" id="titulo_corto" name="titulo_corto" maxlength="50" class="form-control" value="<?php echo $titulo_corto; ?>" required>
                                </div>

                                <h3>Descripción</h3>
                                <div class="form-line">
                                    <textarea rows="4" name="descripcion" class="form-control" required><?php echo $descripcion; ?></textarea>
                                </div>

                                <h3>Tipo de Multimedia</h3>
                                <div class="form-line">
                                    <input type="radio" id="radio_imagen" name="insert_multimedia" value="Foto" <?php if ($insert_multimedia == 'Foto') { echo 'checked'; } ?>>
                                    <label for="radio_imagen">Imagen</label>

                                    <input type="radio" id="radio_video" name="insert_multimedia" value="Video" <?php if ($insert_multimedia == 'Video') { echo 'checked'; } ?>>
                                    <label for="radio_video">Video</label>
                                </div>

                                <h3>Ruta Multimedia (Imagen/Video)</h3>
                                <div class="form-line">
                                    <textarea name="multimedia" class="form-control"  rows="3" required><?php echo $multimedia; ?></textarea>
                                </div>

                                <h3>Autor</h3>
                                <div class="form-line">
                                    <input type="text" id="autor" name="autor" class="form-control" value="<?php echo $autor; ?>" required>
                                </div>

                                <h3>Título del Autor</h3>
                                <div class="form-line">
                                    <input type="text" id="titulo_autor" name="titulo_autor" class="form-control" value="<?php echo $titulo_autor; ?>" required>
                                </div>

                                <h3>Imagen del Autor</h3>
                                <div class="form-line">
                                    <input type="text" id="imagen_autor" name="imagen_autor" class="form-control" value="<?php echo $imagen_autor; ?>" required>
                                </div>

                                <h3>Estatus</h3>
                                <div class="form-line">
                                    <select name="estatus" class="form-control">
                                        <option value="Activo" <?php echo $estatus == 'Activo' ? 'selected' : ''; ?>>Activo</option>
                                        <option value="Inactivo" <?php echo $estatus == 'Inactivo' ? 'selected' : ''; ?>>Inactivo</option>
                                        <option value="Pendiente" <?php echo $estatus == 'Pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                                        <option value="Bloqueado" <?php echo $estatus == 'Bloqueado' ? 'selected' : ''; ?>>Bloqueado</option>
                                    </select>
                                </div>

                                <h3>Imagen Chica</h3>
                                <div class="form-line">
                                    <input type="text" id="imagen_chica" name="imagen_chica" class="form-control" value="<?php echo $imagen_chica; ?>" required>
                                </div>

                                <h3>Imagen Portada</h3>
                                <div class="form-line">
                                    <input type="text" id="imagen_portada" name="imagen_portada" class="form-control" value="<?php echo $imagen_portada; ?>" required>
                                </div>

                                <h3>Contenido</h3>
                                <div class="form-line">
                                    <textarea class="ckeditor form-control" name="contenido" id="contenido"><?php echo $contenido; ?></textarea>
                                </div>

                                <br>
                                <button type="submit" class="btn btn-primary"><?php echo $articulo_id ? 'Guardar cambios' : 'Agregar Artículo'; ?></button>
                            </form>

                            <hr>
                            <h2>Artículos Existentes</h2>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Título</th>
                                            <th>Título Corto</th>
                                            <th>Estatus</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($articulos)) { ?>
                                            <?php foreach ($articulos as $articulo) { 
                                            	
												switch ($articulo['estatus']) {
													case 'Activo':
														$class = 'class="success"';
														break;
													
													case 'Inactivo':
														$class = 'class="warning"';
														break;
														
													case 'Pendiente':
														$class = 'class="info"';
														break;
														
													case 'Bloqueado':
														$class = 'class="danger"';
														break;
																																							
												}
                                            	
                                            	?>
                                            <tr>
                                                <td><?php echo $articulo['articulo_id']; ?></td>
                                                <td><?php echo $articulo['titulo']; ?></td>
                                                <td><?php echo $articulo['titulo_corto']; ?></td>
                                                <td <?php echo $class; ?>><?php echo $articulo['estatus']; ?></td>
                                                <td>
                                                    <form action="gestion_articulos.php" method="POST" style="display:inline-block;">
                                                        <input type="hidden" name="articulo_id" value="<?php echo $articulo['articulo_id']; ?>">
                                                        <input type="hidden" name="action" value="editar">
                                                        <button type="submit" class="btn btn-warning">Editar</button>
                                                    </form>
                                                    <form action="gestion_articulos.php" method="POST" style="display:inline-block;">
                                                        <input type="hidden" name="articulo_id" value="<?php echo $articulo['articulo_id']; ?>">
                                                        <input type="hidden" name="action" value="eliminar">
                                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                                    </form>
                                                    	<a target="_blank" class="btn btn-info" href="../news.php?articulo_id=<?php echo $articulo['articulo_id']; ?>" role="button">Ver</a>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <tr>
                                                <td colspan="5">No se encontraron artículos.</td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div> <!-- Fin de table-responsive -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php 
// Incluir la primera parte del footer que contiene scripts y configuraciones iniciales del pie de página
include($ruta.'footer1.php'); 
?>

    
   <!-- JQuery DataTable Css -->
<link href="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
<!-- Bootstrap Material Datetime Picker Css -->
<link href="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />
<!-- Bootstrap DatePicker Css -->
<link href="<?php echo $ruta; ?>plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
<!-- Wait Me Css -->
<link href="<?php echo $ruta; ?>plugins/waitme/waitMe.css" rel="stylesheet" />
<!-- Bootstrap Select Css -->
<link href="<?php echo $ruta; ?>plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" /> 
<!-- Ckeditor -->
<script src="<?php echo $ruta; ?>plugins/ckeditor/ckeditor.js"></script>
  -->
<?php 
include($ruta.'footer2.php'); 
?>

