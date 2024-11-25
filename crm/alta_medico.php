<?php
$ruta="../";
$titulo ="Alta de Referenciador";
include($ruta.'header1.php'); 
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
                        	<h1 align="center">Alta de Medico Posible Referenciador</h1>
	                        <div class="body">
	                            <form id="wizard_with_validation" method="POST" action="guarda_medico.php" >                            	
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
	                                            <input type="email" id="usuario"  name="usuario" class="form-control" >
	                                            <label class="form-label">Correo Electronico</label>
	                                        </div>
	                                    </div>
	                                    <div class="form-group form-float">
	                                        <div class="form-line">
	                                            <input type="tel" id="celular" name="celular" class="form-control" required>
	                                            <label max="10" class="form-label">Celular*</label>
	                                        </div>
	                                    </div>
	                                    <div class="form-group form-float">
	                                        <div class="form-line">
                                                <textarea id="domicilio" name="domicilio" class="form-control" ></textarea>
	                                            <label max="10" class="form-label">Domicilio</label>
	                                        </div>
	                                    </div> 
	                                    <div class="form-group form-float">
	                                        <div class="form-line">
	                                            <input type="text" id="horarios" name="horarios" class="form-control" required>
	                                            <label max="10" class="form-label">Horarios</label>
	                                        </div>
	                                    </div>    
	                                    <div class="form-group form-float">
	                                        <div class="form-line">
	                                            <input type="text" id="especialidad" name="especialidad" class="form-control" required>
	                                            <label max="10" class="form-label">Especialidad</label>
	                                        </div>
	                                    </div>                                                                                                                   
		                                <div class="form-group form-float">
                                        <input type="tel" id="funcion" name="funcion" class="form-control" value="MEDICO" readonly>
		                                    <label class="form-label">Tipo de Usuario</label>               	
		                                </div>	
	                                    <div class="form-group form-float">
	                                        <div class="form-line">
                                                <textarea id="observaciones" name="observaciones" class="form-control" ></textarea>
	                                            <label max="10" class="form-label">Observaciones</label>
	                                        </div>
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