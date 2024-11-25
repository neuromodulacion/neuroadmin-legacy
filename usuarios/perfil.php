<?php
$ruta="../";
$title = 'INICIO';


$titulo ="Perfil";

include($ruta.'header1.php');


$sql ="
SELECT
	admin.usuario_id as usuario_idx, 
	admin.nombre, 
	admin.usuario, 
	admin.telefono,
	admin.pwd
FROM
	admin
WHERE
	admin.usuario_id = $usuario_id";
	//echo $sql;	
    $result=ejecutar($sql); 
    $row = mysqli_fetch_array($result);
    extract($row);


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
?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>PERFIL</h2>
        </div>           
<!-- // ************** Contenido ************** // -->
	    <!-- CKEditor -->
	    <div class="row clearfix">
	        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	            <div class="card">
	                <div style="height: 95%"  class="header">
	                	<h1 align="center">Perfil</h1>
	                    <div class="body">                             	
							
	                   		<fieldset> 
                   			<div class="row">                               
								<div class="col-md-6">
									<form id="wizard_with_usuario" method="POST" action="actualiza_alta.php" >
										<input type="hidden" id="usuario_id" name="usuario_idx" value="<?php echo $usuario_idx; ?>" />
										<input type="hidden" id="option" name="option" value="perfil" />
										<h3>Nombre del Usuario</h3>	                                
		                                <div class="form-group form-float">
		                                    <div class="form-line">
		                                        <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" class="form-control" required>
		                                        <label class="form-label">Nombre/s*</label>
		                                    </div>
		                                </div>
		                                <div class="form-group form-float">
		                                    <div class="form-line">
		                                        <input type="email" id="usuario"  name="usuario" class="form-control" value="<?php echo $usuario; ?>" required>
		                                        <label class="form-label">Correo Electronico*</label>
		                                    </div>
		                                </div>
		                                <div class="form-group form-float">
		                                    <div class="form-line">
		                                        <input type="tel" id="telefono" name="telefono" class="form-control" value="<?php echo $telefono; ?>" required>
		                                        <label max="10" class="form-label">Celular*</label>
		                                    </div>
		                                </div>
		                                <div class="row clearfix demo-button-sizes">
		                                	<div class="col-xs-12">
		                                		<button type="submit" class="btn bg-green btn-block btn-lg waves-effect">MODIFICAR</button>
		                            		</div>
		                        		</div> 
	                        		</form> 									  	
								</div>
								<div class="col-md-6">									
									<form id="wizard_with_contra" method="POST" action="actualiza_alta.php" >
										<input type="hidden" id="usuario_idxx" name="usuario_idx" value="<?php echo $usuario_idx; ?>" />
										<input type="hidden" id="option" name="option" value="pwd" />
										<h3>Cambio de Contraseña</h3>
					                    <div class="input-group">
					                        <span class="input-group-addon">
					                            <i class="material-icons">lock</i>
					                        </span>
					                        <div class="form-line">
					                            <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Contraseña Anterior" required autofocus>
					                            <!-- <label max="10" class="form-label">Contraseña Anterior*</label> -->
					                        </div>
					                    </div>
					                    <div class="input-group">
					                        <span class="input-group-addon">
					                            <i class="material-icons">lock</i>
					                        </span>
					                        <div class="form-line">
					                            <input type="password" class="form-control" id="password_val" name="password_val" placeholder="Contraseña Nueva*" required>
					                            <!-- <label max="10" class="form-label">Contraseña Nueva*</label> -->
					                        </div>
					                    </div>
					                    <div class="input-group">
					                        <span class="input-group-addon">
					                            <i class="material-icons">lock</i>
					                        </span>
					                        <div class="form-line">
					                            <input type="password" class="form-control" id="password" name="password" placeholder="Repite Contraseña Nueva*" required>
					                            <!-- <label max="10" class="form-label">Repite Contraseña Nueva*</label> -->
					                        </div>
					                    </div>						                    
					                    <div class="row">
					                        <div class="col-xs-12">
					                            <button id="boton_pwd" class="btn btn-block  btn-lg bg-pink waves-effect" type="button">CAMBIAR</button>
										         <script type='text/javascript'>
									                $('#boton_pwd').click(function(){	
									                	var pwd = $("#pwd").val();
									                	var password_val = $("#password_val").val(); 
									                	var password = $("#password").val();
									                	var pwdx = "<?php echo $pwd; ?>";
									                	if (pwd == pwdx) {
									                		if (password == password_val) {
									                			$("#btn").click();
									                		} else{
									                			alert('Tu contraseña nueva es incorrecta');
									                		};
									                	} else{
									                		alert('Tu contraseña es incorrecta');
									                	};

									                });
									            </script>					                            
					                            <button style="display: none" id="btn" class="btn btn-block  btn-lg bg-pink waves-effect" type="submit">CAMBIAR</button>
					                        </div>
							            </div>                      	                                    
									</form> 							  	
								</div>
							</div>
								<?php if ($acceso == 1) { 
									
								$sql_protocolo = "
									SELECT
										empresas.emp_nombre,
										empresas.body_principal,
										empresas.icono,
										empresas.logo,
										empresas.web,
										empresas.e_mail,
										empresas.pdw,
										empresas.tipo_email,
										empresas.puerto,
										empresas.`host` as e_host
									FROM
										empresas 
									WHERE
										empresas.empresa_id = $empresa_id 									
								    ";
									
								//echo $sql_protocolo;
								$result_protocolo=ejecutar($sql_protocolo); 
								
								$row_protocolo = mysqli_fetch_array($result_protocolo);
								extract($row_protocolo);
								//print_r($row_protocolo);									
									?>
																	
								<div class="col-md-12">
									<h1>Perfil de Empresa</h1>
									<?php // print_r($_SESSION); ?>
								</div> 
								<div class="col-md-6">
									<div id="foto4" >
										<h3>Logotipo Principal</h3>	 <!--  -->
										<form id="uploadForm4" method="post" enctype="multipart/form-data">
											<div class="row">
											 	 <div class="col-md-12">									    
											    	<div class="thumbnail">
											    		<?php echo $logo; ?>
											    		<!-- <img width="300px" id="imagePreview4" src="../images/nofoto.png" alt="Tu imagen aparecerá aquí" /> -->
											      		<img width="300px" id="imagePreview4" src="<?php echo valida_fotos($ruta.$logo); ?>" alt="Tu imagen aparecerá aquí" />
											      		<div class="caption">
												        	<h3>Logo Principal</h3>
												        	<p>Es el logo que va en los Reportes</p>
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
																                $('#status4').html("uploads/"+data);
																                $('#inputRutaImagen4').val("https://neuromodulaciongdl.com/uploads/"+data);
																
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
	                           		
								</div>
								<div class="col-md-6">
									<div id="foto3" >
										<h3>Logotipo Pestañas</h3>	 <!--  -->
										<form id="uploadForm3" method="post" enctype="multipart/form-data">
											<div class="row">
											 	 <div class="col-md-12">									    
											    	<div class="thumbnail">
											    		<?php echo $icono; ?>
											      		<img id="imagePreview3" src="<?php echo valida_fotos($ruta.$icono); ?>" alt="Tu imagen aparecerá aquí" />
											      		<div class="caption">
												        	<h3>Logo pestañas</h3>
												        	<p>Es el logo que va en las pestañas</p>
												        	<p><input class="btn btn-primary"  type="file" name="file" id="file3"></p> 
												        	<p><input class="btn btn-default" type="button" value="Subir Foto" id="btnUpload3"></p>
														<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
															<script>
																$(document).ready(function() {
																    $("#btnUpload3").click(function() {
																        var fileInput = $('#file3')[0];
																        var filePath = fileInput.value;
																        var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
																        $('#status3').html("Cargando...");
																        $('#inputRutaImagen3').val("");
																
																        if(!allowedExtensions.exec(filePath)){
																            alert('Por favor sube archivos con las extensiones .jpeg/.jpg/.png/.gif solamente.');
																            fileInput.value = '';
																            return false;
																        }
																
																        var formData = new FormData($("#uploadForm3")[0]);
																        $("#btnUpload3").prop('disabled', true);
																								
																        $.ajax({
																            url: '../upload.php',
																            type: 'POST',
																            data: formData,
																            contentType: false,
																            processData: false,
																            success: function(data) {
																                $('#status3').html("https://neuromodulaciongdl.com/uploads/"+data);
																                $('#inputRutaImagen3').val("https://neuromodulaciongdl.com/uploads/"+data);
																
																                var reader = new FileReader();
																                reader.onload = function (e) {
																                    $('#imagePreview3').attr('src', e.target.result).show();
																                };
																                reader.readAsDataURL($("#file3")[0].files[0]);
																                $("#btnUpload3").prop('disabled', false);
																            },
																            error: function() {
																                $('#status3').html('Ocurrió un error al subir la foto.');
																            }
																        });
																    });
																});
																</script>
	
															<div id="status3"></div>
																								        
													      	</div>
												    	</div>
												  	</div>	
												</div>
											
											</form> 
											<input type="hidden" id="inputRutaImagen3" name="multimedia" value="" >                           
		                           		</div>	
								</div>
								<div class="col-md-6">
								    <input type="hidden" name="empresa_id" value="<?php echo $empresa_id; ?>">
								    <div class="form-group form-float">
								        <div class="form-line">
								            <input type="text" id="nombre" name="nombre" value="<?php echo $emp_nombre; ?>" class="form-control" required>
								            <label class="form-label">Nombre/s*</label>
								        </div>
								    </div>
								    <div class="form-group form-float">
								        <div class="form-line">
								            <input type="text" id="icono" name="icono" value="<?php echo $icono; ?>" class="form-control" required>
								            <label class="form-label">Icono*</label>
								        </div>
								    </div>
								    <div class="form-group form-float">
								        <div class="form-line">
								            <input type="text" id="logo" name="logo" value="<?php echo $logo; ?>" class="form-control" required>
								            <label class="form-label">Logo*</label>
								        </div>
								    </div>
								    <div class="form-group form-float">
								        <div class="form-line">
								            <input type="text" id="web" name="web" value="<?php echo $web; ?>" class="form-control" required>
								            <label class="form-label">Sitio Web*</label>
								        </div>
								    </div>
								    <div class="form-group form-float">
								        <div class="form-line">
								            <input type="text" id="usuario_id" name="usuario_id" value="<?php echo $usuario_id; ?>" class="form-control" required>
								            <label class="form-label">ID de Usuario*</label>
								        </div>
								    </div>
							    
								    <div class="form-group form-float">
								        <div class="form-line">
											<div role="tabpanel" class="tab-pane fade in active in active" id="skins">
											    <select id="themeSelect" class="form-control">
											        <option <?php if($body == "aldana"){ echo "selected";} ?> value="red" selected>Aldana</option>
											        <option value="red">Red</option>
													<option value="pink">Pink</option>
											        <option value="purple">Purple</option>
											        <option value="deep-purple">Deep Purple</option>
											        <option value="indigo">Indigo</option>
											        <option value="blue">Blue</option>
											        <option value="light-blue">Light Blue</option>
											        <option value="cyan">Cyan</option>
											        <option value="teal">Teal</option>
											        <option value="green">Green</option>
											        <option value="light-green">Light Green</option>
											        <option value="lime">Lime</option>
											        <option value="yellow">Yellow</option>
											        <option value="amber">Amber</option>
											        <option value="orange">Orange</option>
											        <option value="deep-orange">Deep Orange</option>
											        <option value="brown">Brown</option>
											        <option value="grey">Grey</option>
											        <option value="blue-grey">Blue Grey</option>
											        <option value="black">Black</option>
											    </select>
											</div>
								            <label class="form-label">Cuerpo Principal*</label>
								        </div>
								    </div>
								</div>
								<div class="col-md-6">									    
								    <div class="form-group form-float">
								        <div class="form-line">
								            <input type="email" id="e_mail" name="e_mail" value="<?php echo $e_mail; ?>" class="form-control" required>
								            <label class="form-label">Correo Electrónico*</label>
								        </div>
								    </div>
								    <div class="form-group form-float">
								        <div class="form-line">
								            <input type="password" id="pdw" name="pdw" value="<?php echo $pdw; ?>" class="form-control" required>
								            <label class="form-label">Contraseña*</label>
								        </div>
								    </div>
								    <div class="form-group form-float">
								        <div class="form-line">
								            <input type="text" id="tipo_email" name="tipo_email" value="<?php echo $tipo_email; ?>" class="form-control" required>
								            <label class="form-label">Tipo de Correo Electrónico*</label>
								        </div>
								    </div>
								    <div class="form-group form-float">
								        <div class="form-line">
								            <input type="text" id="puerto" name="puerto" value="<?php echo $puerto; ?>" class="form-control" required>
								            <label class="form-label">Puerto*</label>
								        </div>
								    </div>
								    <div class="form-group form-float">
								        <div class="form-line">
								            <input type="text" id="host" name="host" value="<?php echo $e_host; ?>" class="form-control" required>
								            <label class="form-label">Host*</label>
								        </div>
								    </div>
								    <!-- Agrega otros campos de la tabla 'empresas' aquí -->
								</div>
								<div align="center" class="col-md-12">	
								    <div class="row clearfix demo-button-sizes">
								        <div class="col-xs-6">
								            <button type="submit" class="btn bg-green btn-block btn-lg waves-effect">MODIFICAR</button>
								        </div>
								    </div>
									
								</div>															
								<?php }	 ?>                               
                        	</fieldset>	                                            	
		                </div>
                	</div>
            	</div>
        	</div>
    	</div>
    </div>
</section>
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