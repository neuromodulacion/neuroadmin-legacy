<?php
$ruta="../";

$hoy = date("Y-m-d");
$ahora = date("H:i:00"); 
$anio = date("Y");
$mes_ahora = date("m");
//$mes = strftime("%B");
$dia = date("N");
$semana = date("W");
$titulo ="Alta de Medico o Usuario";

include($ruta.'header1.php');

	switch ($funcion) {
		case 'SISTEMAS':
			$where = "";
			break;
		
		case 'ADMINISTRADOR':
			$where = "";
			break;
		
		case 'COORDINADOR':
			$where = "
				WHERE
					funciones.funcion in('MEDICO','TECNICO')
						";
			break;
		
		case 'COORDINADOR ADMIN':
			$where = "
				WHERE
					funciones.funcion in('MEDICO','TECNICO', 'COORDINADOR', 'REPRESENTANTE','RECEPCION')
						";
			break;
		
		case 'TECNICO':
			$where = "
				WHERE
					funciones.funcion in('MEDICO')
						";
			break;
		
		case 'REPRESENTANTE':
			$where = "
				WHERE
					funciones.funcion in('MEDICO')
						";
			break;
														
	}
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
                <h2>ALTA DE USUARIOS</h2>
            </div>
            
<!-- // ************** Contenido ************** // -->
            <!-- CKEditor -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div style="height: 95%"  class="header">
                        	<h1 align="center">Alta de Medico o Usuario</h1>
	                        <div class="body">
	                            <form id="wizard_with_validation" method="POST" action="guarda_alta.php" >                            	
	                               <h3>Nombre del Medico</h3>
	                                <fieldset>
	                                    <div class="form-group form-float">
	                                        <div class="form-line">
	                                            <input type="text" id="nombre" name="nombre" class="form-control" required>
	                                            <label class="form-label">Nombre/s*</label>
	                                        </div>
	                                    </div>
	                                    <div class="form-group form-float">
	                                        <div class="form-line">
	                                            <input type="email" id="usuario"  name="usuario" class="form-control" required>
	                                            <label class="form-label">Correo Electronico*</label>
	                                        </div>
	                                    </div>
	                                    <div class="form-group form-float">
	                                        <div class="form-line">
	                                            <input type="tel" id="celular" name="celular" class="form-control" required>
	                                            <label max="10" class="form-label">Celular*</label>
	                                        </div>
	                                    </div>
										<!-- Campo de Cedula Profesional -->
										<div class="form-group form-float">
											<div class="form-line">
												<input type="tel" id="cedula" name="cedula" class="form-control"  >
												<label max="10" class="form-label">Cedula Profesional</label>
											</div>
										</div>
                                    
		                                <div class="form-group form-float">
                                        	<select id="funcion" name="funcion" class="form-control show-tick">

												 	<?php
														$sql_funciones = "
															SELECT
																funciones.funcion as funciony 
															FROM
																funciones 
															$where
															ORDER BY
																1 ASC							
													        ";
													        $result_funciones=ejecutar($sql_funciones); 
													            //echo $cnt."<br>";  
													            //echo "<br>";    
													            $cnt=1;
													            $total = 0;
													            $ter="";
													        while($row_funciones = mysqli_fetch_array($result_funciones)){
													            extract($row_funciones); ?>
                                    														 
												  <option value="<?php echo $funciony; ?>" ><?php echo $funciony; ?></option>
											<?php } ?>	
											</select>
		                                    <label class="form-label">Tipo de Usuario</label>               	
		                                </div>	                                    	                                    
                                    </fieldset>
	                                <hr>                               
	                                <div class="row clearfix demo-button-sizes">
	                                	<div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
	                                		<button type="submit" class="btn bg-green btn-block btn-lg waves-effect">GUARDAR</button>
	                            		</div>
	                        		</div>                                     
                                </form>                       	
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