<?php
$ruta="../";
$title = 'INICIO';

$hoy = date("Y-m-d");
$ahora = date("H:i:00"); 
$anio = date("Y");
$mes_ahora = date("m");
$mes = strftime("%B");
$dia = date("N");
$semana = date("W");
$titulo ="Directorio";
$genera ="";

include($ruta.'header1.php');?>
    
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
  -->
<?php  include($ruta.'header2.php');  

// $articulo_id = 1;
// $sql ="
// SELECT
	// articulo.articulo_id, 
	// articulo.usuario_id, 
	// articulo.titulo, 
	// articulo.titulo_corto, 
	// articulo.descripcion, 
	// articulo.insert_multimedia, 
	// articulo.multimedia, 
	// articulo.autor, 
	// articulo.titulo_autor, 
	// articulo.imagen_autor, 
	// articulo.f_alta, 
	// articulo.h_alta, 
	// articulo.contenido, 
	// articulo.estatus, 
	// articulo.imagen_chica, 
	// articulo.imagen_portada
// FROM
	// articulo
// WHERE 
	// articulo.articulo_id = $articulo_id";    
//     
    // $result=ejecutar($sql); 
    // $row = mysqli_fetch_array($result);
    // extract($row);	
?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>ALTA</h2>
            <?php // echo $ubicacion_url."<br>"; 
            //echo $ruta."proyecto_medico/menu.php"?>
        </div>
<!-- // ************** Contenido ************** // -->
        <!-- CKEditor -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div style="height: 95%"  class="header">
                    	<h1 align="center">Alta de Noticias</h1>                       		
						<div class="body"><!-- target="_blank" --> 
						
                            <h3>Multimedia Principal</h3>
                            <input name="insert_multimedia" type="hidden" id="insert_multimedia" value="Foto" />	  
                            
                            <?php
                            	if ($insert_multimedia == 'Multimedia') {
									$checked ="checked";
									$displayx ="";
									$display ="style='display: none'";
								} else {
									$checked ="";
									$displayx ="style='display: none'";
									$display ="";											
								}
								
                            ?>                              	
                            <div class="switch">
                                <label>Imagen<input id="multi" name="multi" type="checkbox" <?php echo $checked; ?>><span class="lever"></span>Multimedia</label>
                            </div>                              
                            <input style='height: 0px; width: 0px' name="val_obser" type="text" id="val_obser_enc" value="ok" required/>
					        <script type='text/javascript'>
					            $('#multi').click(function(){
								    if ($("#multi").prop("checked")) {
								      $('#video').show();
								      $('#foto4').hide();
								      $('#insert_multimedia').val('Multimedia');
								      $('#val_obser').val('');
								    } else {
								      $('#video').hide();
								      $('#foto4').show();
								      $('#insert_multimedia').val('Foto');
								      $('#val_obser').val('ok');
								    }	                    
					            });
					        </script> 
					        <!-- para insertar el video -->	                                
							<div <?php echo $displayx; ?> id="video">
								<h3>Multimedia</h3>
	                            <div id="contenidoMultimedia"><?php echo $multimedia; ?></div><br>
	                            <textarea class="form-control" name="multimedia" id="multimedia1" rows="7">
									<?php echo $multimedia; ?> 
	                            </textarea><br> 
								<p><button  class="btn btn-default" type="button"  id="actualizarDiv">Insertar</button></p>
								
								<script>
								$(document).ready(function() {
								    // Evento al hacer clic en el botón
								    $("#actualizarDiv").click(function() {
								        var contenido = $("#multimedia1").val(); // Obtener el valor del textarea
								        $("#multimedia").val(contenido);  
								        $("#contenidoMultimedia").html(contenido); // Actualizar el div
								    });
								});
								</script>
	                                                           	                              		                                 
                       		</div>
                       		<!-- para insertar la imagen -->	
							<div id="foto" style="display: none">   
								<form id="uploadForm_zz" method="post" enctype="multipart/form-data">
									<div class="row">
									 	 <div class="col-md-6">									    
									    	<div class="thumbnail">
									      		<img width="300px" id="imagePreview_zz" src="../images/nofoto.png" alt="Tu imagen aparecerá aquí" />
									      		<div class="caption">
										        	<h3>Foto Principal</h3>
										        	<p>Es la foto que va en la cabecera de la noticia</p>
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
									<!-- para insertar la imagen -->	
									<div <?php $$displayx; ?> id="foto4" >
									<h3>Foto Principal</h3>	 <!--  -->
									<form id="uploadForm4" method="post" enctype="multipart/form-data">
										<div class="row">
										 	 <div class="col-md-6">									    
										    	<div class="thumbnail">
										      		<img width="300px" id="imagePreview4" src="../images/nofoto.png" alt="Tu imagen aparecerá aquí" />
										      		<div class="caption">
											        	<h3>Foto Principal</h3>
											        	<p>Es la foto que va en la cabecera de la noticia</p>
											        	<p><input class="btn btn-primary"  type="file" name="file" id="file4"></p> 
											        	<p><input class="btn btn-default" type="button" value="Subir Foto" id="btnUpload4"></p>
													<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
														<script>
															$(document).ready(function() {
															    $("#btnUpload4").click(function() {
															        var fileInput = $('#file4')[0];
															        var filePath = fileInput.value;
															        var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
															        $('#status4').html("Cargando...");
															        $('#inputRutaImagen4').val("");
															
															        if(!allowedExtensions.exec(filePath)){
															            alert('Por favor sube archivos con las extensiones .jpeg/.jpg/.png/.gif solamente.');
															            fileInput.value = '';
															            return false;
															        }
															
															        var formData = new FormData($("#uploadForm4")[0]);
															        $("#btnUpload4").prop('disabled', true);
																							
															        $.ajax({
															            url: '../upload.php',
															            type: 'POST',
															            data: formData,
															            contentType: false,
															            processData: false,
															            success: function(data) {
															                $('#status4').html("<?php echo $ruta; ?>uploads/"+data);
															                $('#inputRutaImagen4').val("<?php echo $ruta; ?>uploads/"+data);
															
															                var reader = new FileReader();
															                reader.onload = function (e) {
															                    $('#imagePreview4').attr('src', e.target.result).show();
															                };
															                reader.readAsDataURL($("#file4")[0].files[0]);
															                $("#btnUpload4").prop('disabled', false);
															            },
															            error: function() {
															                $('#status4').html('Ocurrió un error al subir la foto.');
															            }
															        });
															    });
															});
															</script>

														<div id="status4"></div>
																							        
												      	</div>
											    	</div>
											  	</div>	
											</div>
										
										</form> 
										<input type="hidden" id="inputRutaImagen4" name="multimedia" value="" >                           
	                           		</div>	                           		
	
                            <div class="form-group form-float">
                             	<h3>Titulo</h3>
                                <div class="form-line">                                      
									<input type="text" id="titulo" name="titulo" class="form-control" value="" required>
                                </div>
                             	<h3>Titulo Corto</h3>
                                <div class="form-line">                                      
									<input type="text" id="titulo_corto" name="titulo_corto" class="form-control" value="<?php echo $titulo_corto; ?>" required>
                                </div>  
                             	<h3>Descripción</h3>
                                <div class="form-line">                                      
									<input type="text" id="descripcion" name="descripcion" class="form-control" value="<?php echo $descripcion; ?>" required>
                                </div>	
                             	<h3>Foto Portada</h3>

                           		<!-- para insertar la imagen -->	
								<div id="foto2"> <!--  -->
									<form id="uploadForm2" method="post" enctype="multipart/form-data">
										<div class="row">
										 	 <div class="col-md-6">									    
										    	<div class="thumbnail">
										    		<?php 
										    		if ($imagen_portada == '') {
															$foto_2="../images/nofoto.png"; 
													} else {
															$foto_2=$imagen_portada;
													}
													?>
										      		<img width="300px" id="imagePreview2" src="<?php echo $foto_2; ?>" alt="Tu imagen aparecerá aquí" />
										      		<div class="caption">
											        	<h3>Foto Portada</h3>
											        	<p>Es la foto que va en la cabecera de la noticia</p>
											        	<p><input class="btn btn-primary"  type="file" name="file" id="file2"></p> 
											        	<p><input class="btn btn-default" type="button" value="Subir Foto" id="btnUpload2"></p>
													<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
														<script>
														$(document).ready(function() {
														    $("#btnUpload2").click(function() {
														        var fileInput = $('#file2')[0];
														        var filePath = fileInput.value;
														        var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;															
												                $('#status2').html("Cargando...");											
																$('#inputRutaImagen2').val("");
														        
														        if(!allowedExtensions.exec(filePath)){
														            alert('Por favor sube archivos con las extensiones .jpeg/.jpg/.png/.gif solamente.');
														            fileInput.value = '';
														            return false;
														        }
														
														        var formData = new FormData($("#uploadForm2")[0]);
																$("#btnUpload2").prop('disabled', true);
																
														        $.ajax({
														            url: '../upload.php',
														            type: 'POST',
														            data: formData,
														            contentType: false,
														            processData: false,
														            success: function(data) {
														                $('#status2').html("<?php echo $ruta; ?>uploads/"+data);										
																		$('#inputRutaImagen2').val("<?php echo $ruta; ?>uploads/"+data); 
																		$('#inputRutaImagen3').val("<?php echo $ruta; ?>uploads/"+data); 
														                
														                var reader = new FileReader();
														                reader.onload = function (e) {
														                    $('#imagePreview2').attr('src', e.target.result);												                        
														                    $('#imagePreview3').attr('src', e.target.result);																			
														                    // Aquí se asume que data es un objeto con una propiedad rutaImagen
														                    // $('#inputRutaImagen').val(nombreArchivo);                       
														                };
														                reader.readAsDataURL($("#file2")[0].files[0]);
																		$("#btnUpload2").prop('disabled', false);
																		
																		$('#inputRutaImagen3').val("<?php echo $ruta; ?>uploads/"+data);  
														            },
														            error: function() {
														                $('#status2').html('Ocurrió un error al subir la foto.');
														            }
														        });
														        
														    });
														});
														</script>
														<div id="status2"></div>
														<input type="hidden" id="inputRutaImagen2" name="imagen_portada" value="<?php echo $imagen_portada; ?>" >									        
												      	</div>
											    	</div>
											  	</div>	
											</div>
										
									</form>                            
                           		</div><hr> 
                                  
                             	<h3>Foto Miniatura</h3>

                                <div class="media">
                                     <div class="media-object pull-left">
                                          <img id="imagePreview3" width="100px" src="<?php echo $imagen_chica; ?>"  class="thumbnail"  alt="">
                                     </div>	                                     	
                         		</div>
                                <div class="form-line">  	                                        	                                    
									<input type="hidden" id="inputRutaImagen3" name="imagen_chica" class="form-control" value="<?php echo $imagen_chica; ?>" required>
                                </div> 		                                                                                                                                                           
                            </div> 	                               		
                                    <hr>
                                     <div class="form-group form-float">
                                     	<h3>Autor</h3>
                                        <div class="form-line">                                      
     										<input type="text" id="autor" name="autor" class="form-control" value="<?php echo $autor; ?>" required>
                                        </div>
                                     	<h3>Titulo Autor</h3>
                                        <div class="form-line">                                      
     										<input type="text" id="titulo_autor" name="titulo_autor" class="form-control" value="<?php echo $titulo_autor; ?>" required>
                                        </div>  
                                     	<h3>Foto Autor</h3>
										<!-- para insertar la imagen -->	
										<div id="foto3"> <!--  -->
										<form id="uploadFormy" method="post" enctype="multipart/form-data">
											<div class="row">
											 	 <div class="col-md-6">									    
											    	<div class="thumbnail">
											      		<img width="300px" id="imagePreviewy" src="../images/nofoto.png" alt="Tu imagen aparecerá aquí" />
											      		<div class="caption">
												        	<h3>Foto Autor</h3>
												        	<p>Es la foto que va en la cabecera de la noticia</p>
												        	<p><input class="btn btn-primary"  type="file" name="file" id="filey"></p> 
												        	<p><input class="btn btn-default" type="button" value="Subir Foto" id="btnUploady"></p>
														<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
															<script>
																$(document).ready(function() {
																    $("#btnUploady").click(function() {
																        var fileInput = $('#filey')[0];
																        var filePath = fileInput.value;
																        var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
																        $('#statusy').html("Cargando...");
																        $('#inputRutaImageny').val("");
																
																        if(!allowedExtensions.exec(filePath)){
																            alert('Por favor sube archivos con las extensiones .jpeg/.jpg/.png/.gif solamente.');
																            fileInput.value = '';
																            return false;
																        }
																
																        var formData = new FormData($("#uploadFormy")[0]);
																        $("#btnUploady").prop('disabled', true);
																								
																        $.ajax({
																            url: '../upload.php',
																            type: 'POST',
																            data: formData,
																            contentType: false,
																            processData: false,
																            success: function(data) {
																                $('#statusy').html("<?php echo $ruta; ?>uploads/"+data);
																                $('#inputRutaImageny').val("<?php echo $ruta; ?>uploads/"+data);
																
																                var reader = new FileReader();
																                reader.onload = function (e) {
																                    $('#imagePreviewy').attr('src', e.target.result).show();
																                };
																                reader.readAsDataURL($("#filey")[0].files[0]);
																                $("#btnUploady").prop('disabled', false);
																            },
																            error: function() {
																                $('#statusy').html('Ocurrió un error al subir la foto.');
																            }
																        });
																    });
																});
																</script>
	
															<div id="statusy"></div>
															<!-- <input type="hidden" id="inputRutaImageny" name="imagen_autor" value="" >									         -->
													      	</div>
												    	</div>
												  	</div>	
												</div>
											<input type="hidden" id="inputRutaImageny" name="imagen_autor" value="" >
										</form>                            
	                           		</div>
	                           		<hr>                                              
                                         
                                     	
	                           		<hr>                                          
                                         	                                     	
                                        <div class="form-line">  	                                        	                                    
     										<input type="text" id="titulo_autor" name="titulo_autor" class="form-control" value="<?php echo $titulo_autor; ?>" required>
                                        </div>  	                                        
                                     	<h3>Fecha</h3>
                                        <div class="form-line">                                      
     										<input type="date" id="f_alta" name="f_alta" class="form-control" value="<?php echo $hoy; ?>" required>
                                        </div>  
                                    <hr>                            
			                        <div>
			                        	<!-- <h3>Contenido</h3>
			                            <textarea  class="ckeditor"  name="contenido" id="contenido">

			                            </textarea>			                            
			                        </div>
                                                             
                                    </div>                                     
                                           <button id="miBotonSubmit" type="submit" class="btn bg-green btn-block btn-lg waves-effect">GUARDAR</button>  -->                     
                                </fieldset> 
                                <hr>                               
                                <div class="row clearfix demo-button-sizes">
                                	<div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
                                		
										<script>
											$(document).ready(function() {
											    // Suponiendo que tienes un botón con id 'miBotonSubmit'
											    $('#miBotonSubmit').click(function() {
													var titulo = $('#titulo').val();
													$('#titulo_1').val(titulo);
													
													//var multimedia = $('#imagePreview_zz').val();
													
													var multimedia =$("#contenidoMultimedia").html();
													$('#multimedia').val(multimedia);
																									
													var multimediax = $('#inputRutaImagen4').val();
													$('#multimediax').val(multimediax);
																																												
													var titulo_corto = $('#titulo_corto').val();
													$('#titulo_corto_1').val(titulo_corto);
													var descripcion = $('#descripcion').val();
													$('#descripcion_1').val(descripcion);
													var insert_multimedia = $('#insert_multimedia').val();
													$('#insert_multimedia_1').val(insert_multimedia);
													var autor = $('#autor').val();
													$('#autor_1').val(autor);
													var titulo_autor = $('#titulo_autor').val();
													$('#titulo_autor_1').val(titulo_autor);
													var imagen_autor = $('#inputRutaImageny').val();
													var contenido = $('#contenido').html();
													$('#contenido_1').val(contenido);
													var imagen_chica = $('#inputRutaImagen3').val();
													$('#imagen_chica_1').val(imagen_chica);
													var imagen_portada = $('#inputRutaImagen2').val();
													$('#imagen_portada_1').val(imagen_portada);
													var f_alta = $('#f_alta').val();
													$('#f_alta_1').val(f_alta);
													
													var datos_completos = "titulo="+titulo+"&titulo_corto="+titulo_corto+"&descripcion="+descripcion+"&insert_multimedia="+insert_multimedia+"&autor="+autor+"&titulo_autor="+titulo_autor+"&imagen_autor="+imagen_autor+"&contenido="+contenido+"&imagen_chica="+imagen_chica+"&imagen_portada="+imagen_portada+"&f_alta="+f_alta;
													alert(datos_completos);
										    	
											        $('#wizard_with_validation').submit();
											    });
											});
										</script>                                		
                            		</div>
                        		</div><!-- target="_blank" -->
                            <form id="wizard_with_validation"  method="POST" action="guarda_alta.php" >  
			                        <div>
			                        	<h3>Contenido</h3>
			                            <textarea  class="ckeditor"  name="contenido" id="contenido">

			                            </textarea>			                            
			                        </div>
                                                             
                                    </div>                                     
                                           <button id="miBotonSubmit" type="submit" class="btn bg-green btn-block btn-lg waves-effect">GUARDAR</button>                              	                     	
                            	<input type="hidden" id="titulo_1" name="titulo" >
                            	<input type="hidden" id="multimedia" name="multimedia" >
                            	<input type="hidden" id="multimediax" name="multimedia1" >
                            	<!-- <input type="hidden" id="contenido_1" name="contenido" > -->
                            	<input type="hidden" id="titulo_corto_1" name="titulo_corto" >
                            	<input type="hidden" id="descripcion_1" name="descripcion" >
                            	<input type="hidden" id="insert_multimedia_1" name="insert_multimedia" >
                            	<input type="hidden" id="autor_1" name="autor" >
                            	<input type="hidden" id="titulo_autor_1" name="titulo_autor" >
                            	<input type="hidden" id="imagen_chica_1" name="imagen_chica" >
                            	<input type="hidden" id="imagen_portada_1" name="imagen_portada" >
                            	<input type="hidden" id="f_alta_1" name="f_alta" >
                            </form>
                            
						</div>										
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php	include($ruta.'footer1.php');	?>


<?php	include($ruta.'footer2.php');	?>

    <!-- Ckeditor -->
    <script src="<?php echo $ruta; ?>plugins/ckeditor/ckeditor.js"></script>
    
    <script src="<?php echo $ruta; ?>js/pages/forms/editors.js"></script>