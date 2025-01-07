<?php
$ruta = "../../";
$titulo = "Gestión de Módulos";
include($ruta . 'header1.php'); ?>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<!-- JQuery DataTable Css -->
<link href="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
<!-- Bootstrap Material Datetime Picker Css -->
<link href="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />
<!-- Bootstrap DatePicker Css -->
<link href="<?php echo $ruta; ?>plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
<!-- Wait Me Css -->
<link href="<?php echo $ruta; ?>plugins/waitme/waitMe.css" rel="stylesheet" />
<!-- Bootstrap Css -->
<link href="<?php echo $ruta; ?>plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" /> 

<?php include($ruta . 'header2.php'); ?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Gestión de Menús</h2>
        </div>
        <div class="row clearfix">
            <!-- Formulario para agregar/editar menús -->
            <div style="padding: 15px"  class="col-lg-6">
                <div class="card">
                    <div style="padding: 10px" class="header">
                        <h2>Registrar / Editar Menú</h2>
                    </div>
                    <div style="width: auto; padding: 10px" class="container">
                        <form id="form-menu" action="guardar_menu.php" method="POST">

							<div class="form-group form-float">
								<div class="form-line">			
									<label for="tipo_menu">Tipo de Menú:</label>
									<select class="form-control" name="tipo_menu" id="tipo_m" required>
										<option value="">Selecciona tipo de Menú</option>	
										<option value="principal">Menú Principal</option>
										<option value="submenu">Sub Menú</option>
									</select>
								</div>
							</div>
							<div class="form-group form-float">
								<div class="form-line">
									<label for="nombre_m">Nombre del Menú:</label>
									<input type="text" class="form-control" name="nombre_m" id="nombre_m" placeholder="Nombre del menú" required>
								</div>
							</div>	
							<div class="form-group form-float">
								<div class="form-line">
									<label for="ruta_menu">Ruta del Menú:</label>
									<input type="text" class="form-control" name="ruta_menu" id="ruta_menu" placeholder="menu/ejemplo.php" required>
								</div>
							</div>
							<div class="form-group form-float">
								<div class="form-line">
									<label for="categoria">Categoría:</label>
									<select class="form-control" name="categoria" id="categoria">
										<option value="">Seleccione una categoría</option>
										<?php
										// Consulta para obtener las categorías distintas
										$query = "SELECT DISTINCT categoria FROM iconos";
										$resultado = $mysql->consulta($query);
										if ($resultado['numFilas'] > 0) {
											foreach ($resultado['resultado'] as $fila) {
												$categoria = htmlspecialchars($fila['categoria']);
												echo "<option value='{$categoria}'>{$categoria}</option>";
											}
										}
										?>
									</select>
								</div>
							</div>
							
							<div id="iconos-contenedor"></div>
							
							<!--<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>-->
							<script>
							    $(document).ready(function () {
							        $("#categoria").change(function () {
							            const categoria = $(this).val();
							            if (categoria) {							            	
							                $.ajax({
							                    url: 'get_iconos.php',
							                    type: 'POST',
							                    data: { categoria },
							                    type: 'POST',
							                    success: function (html) {
							                    	$("#contenedor_iconos").html(html);  
							                    },
							                    error: function () {
							                        alert("Error al obtener los íconos.");
							                    }
							                });
							            } else {
							                $("#iconos-contenedor").empty();
							            }
							        });
							    });
							</script>
							<div class="form-group form-float">
								<div class="form-line">
									<label for="icono_menu">Ícono:</label>
									<input type="text" class="form-control" name="icono_menu" id="icono_menu" required>
								</div>
							</div>
							<div class="form-group form-float">
								<div class="form-line">
									<label for="tipo_m">Tipo de Liga:</label>
									<select class="form-control" name="tipo_m" id="tipo_m" required>
										<option value="liga">Liga</option>
										<option value="principal">Principal</option>
									</select>
								</div>
							</div>
							<div class="form-group form-float">
								<div class="form-line">
									<label for="nivel">Nivel:</label>                      
									<input type="number" class="form-control" name="nivel" id="nivel" required>
								</div>
							</div>
							<div class="form-group form-float">
								<div class="form-line">
                            		<label for="modulo_id">Módulo:</label>
									<select class="form-control" name="modulo_id" id="modulo_id">
									<?php
										// Consulta para obtener las categorías distintas
										$query = "SELECT DISTINCT * FROM modulos";				    
										// Ejecutar la consulta
										$resultado = $mysql->consulta($query);
									
										// Construir el <select> con las categorías
										echo '<option value="">Seleccione una categoría</option>'; // Opción predeterminada
									
										if ($resultado['numFilas'] > 0) {
											foreach ($resultado['resultado'] as $fila) {
												$nombre_modulo = htmlspecialchars($fila['nombre_modulo']);
												$modulo_id = htmlspecialchars($fila['modulo_id']);
												echo '<option value="' . $modulo_id . '">' . $nombre_modulo . '</option>';
											}
										} else {
											echo '<option value="">No hay categorías disponibles</option>';
										}
									?>
									</select>
								</div>
							</div>
							<div class="form-group form-float">
								<div class="form-line">
                            		<label for="autorizacion">Autorización:</label>
                            		<input type="text" class="form-control" name="autorizacion" id="autorizacion" placeholder="Ejemplo: 1,2,3,4" required>
								</div>
							</div>
                            <hr>
                            <button type="submit" class="btn btn-primary m-t-15">Guardar</button>
                        	
                        </form>
                    </div>
                </div>
            </div>
            
            <div style="padding: 15px" class="col-lg-6">
                <div class="card">
                    <div style="padding: 10px" class="header">
                        <h2>Selecciona el Icono a usar</h2>
                    </div>
                    <div id="contenedor_iconos" style="width: auto; padding: 10px" class="container"> 
                    </div> 
                </div> 
            </div> 
            <?php
			    // Consulta para obtener los datos de la tabla funciones
			    $query = "SELECT funcion_id, funcion, descripcion FROM funciones";
			    $result = $mysql->consulta($query);
			
			    // Verifica si hay resultados
			    if ($result['numFilas'] > 0) {
			        $datos = $result['resultado'];
			    } else {
			        $datos = [];
			    }
			?>
            <div style="padding: 15px" class="col-lg-12">
                <div class="card">
                    <div style="padding: 10px" class="header">
                        <h2>Funciones de usuarios</h2>
                    </div>
                    <div id="contenedor_users" style="width: auto; padding: 10px" class="container"> 
						<h1 class="text-center">Nivel de autorizacion</h1>
				        <table class="table table-bordered table-striped">
				            <thead class="thead-dark">
				                <tr>
				                    <th>ID</th>
				                    <th>Función</th>
				                    <th>Descripción</th>
				                </tr>
				            </thead>
				            <tbody>
				                <?php if (!empty($datos)): ?>
				                    <?php foreach ($datos as $fila): ?>
				                        <tr>
				                            <td><?php echo htmlspecialchars($fila['funcion_id']); ?></td>
				                            <td><?php echo htmlspecialchars($fila['funcion']); ?></td>
				                            <td><?php echo nl2br(htmlspecialchars($fila['descripcion'])); ?></td>
				                        </tr>
				                    <?php endforeach; ?>
				                <?php else: ?>
				                    <tr>
				                        <td colspan="3" class="text-center">No hay datos disponibles.</td>
				                    </tr>
				                <?php endif; ?>
				            </tbody>
				        </table>
                    </div> 
                </div> 
            </div>
            <?php
			    // Consulta para obtener los datos de la tabla menus
			    $query = "SELECT menu_id, nombre_m, autorizacion, icono_menu, modulo_id, nivel, paquetes, ruta_menu, tema_id, tipo_m FROM menus";
			    $result = $mysql->consulta($query);
			
			    // Verifica si hay resultados
			    if ($result['numFilas'] > 0) {
			        $datos = $result['resultado'];
			    } else {
			        $datos = [];
			    }
            ?>
            <div style="padding: 15px" class="col-lg-12">
                <div class="card">
                    <div style="padding: 10px" class="header">
                        <h2>Registros de Menu</h2>
                    </div>
                    <div id="reg_iconos" style="padding: 10px; text-align: center; width: auto;" class="container table-responsive"> 
				        <h1 class="text-center">Tabla de Menús</h1>
				        <table style="width: 95%" class="table table-bordered table-striped">
				            <thead class="thead-dark">
				                <tr>
				                    <th>Menu ID</th>
				                    <th>Icono</th>
				                    <th>Nombre</th>
				                    <th>Autorización</th>				                    
				                    <th>Módulo ID</th>
				                    <th>Nivel</th>
				                    <th>Ruta</th>
				                    <th>Tipo</th>
				                </tr>
				            </thead>
				            <tbody>
				                <?php if (!empty($datos)): ?>
				                    <?php foreach ($datos as $fila): ?>
				                        <tr>
				                            <td><?php echo htmlspecialchars($fila['menu_id']); ?></td>
				                            <td><?php echo ($fila['icono_menu']); ?></td>
				                            <td><?php echo htmlspecialchars($fila['nombre_m']); ?></td>
				                            <td><?php echo htmlspecialchars($fila['autorizacion']); ?></td>
				                            <td><?php echo htmlspecialchars($fila['modulo_id']); ?></td>
				                            <td><?php echo htmlspecialchars($fila['nivel']); ?></td>
				                            <td><?php echo ($fila['ruta_menu']); ?></td>
				                            <td><?php echo htmlspecialchars($fila['tipo_m']); ?></td>
				                        </tr>
				                    <?php endforeach; ?>
				                <?php else: ?>
				                    <tr>
				                        <td colspan="10" class="text-center">No hay datos disponibles.</td>
				                    </tr>
				                <?php endif; ?>
				            </tbody>
				        </table>
                    </div> 
                </div> 
            </div> 
        </div>
    </div>
</section>


<?php include($ruta . 'footer1.php'); ?>
<!-- Incluir scripts necesarios -->
<!-- Moment Plugin Js -->
<script src="<?php echo $ruta; ?>plugins/momentjs/moment.js"></script>
<!-- Bootstrap Material Datetime Picker Plugin Js -->
<script src="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
<!-- Bootstrap Datepicker Plugin Js -->
<script src="<?php echo $ruta; ?>plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<!-- Autosize Plugin Js -->
<script src="<?php echo $ruta; ?>plugins/autosize/autosize.js"></script>

<?php include($ruta . 'footer2.php'); ?>