<?php
$ruta="../";
 
$hoy = date("Y-m-d");
$ahora = date("H:i:00");  
$anio = date("Y");
$mes_ahora = date("m");
$titulo ="Reporte de Ingesos y Egresos";
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
//print_r($_SESSION);
?>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>REPORTE DE INGRESOS Y EGRESOS</h2>
                <?php echo $ubicacion_url."<br>"; 
                //echo $ruta."proyecto_medico/menu.php"?>
            </div>
<!-- // ************** Contenido ************** // -->
            <!-- CKEditor -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div style="height: 95%"  class="header">
                        	<h1 align="center">Reporte de Ingesos y Egresos</h1>
        	                <!-- <div align="center" class="image">
			                    <img  src= "<?php echo $ruta.'images/menu.jpg'; ?>" style="max-width:100%;width:auto;height:auto;" />
			                </div> -->
			                
                        	<hr>
								<div class="row">
									<div class="col-xs-3"></div>
								  	<div class="col-xs-3">
										<div style="padding: 3px" >
											<select class="form-control" id="mes_nav" name="mes_nav">
												<option <?php if($mes_nav == "01"){ echo "selected";} ?> value="01">Enero</option>
												<option <?php if($mes_nav == "02"){ echo "selected";} ?> value="02">Febrero</option>
												<option <?php if($mes_nav == "03"){ echo "selected";} ?> value="03">Marzo</option>
												<option <?php if($mes_nav == "04"){ echo "selected";} ?> value="04">Abril</option>
												<option <?php if($mes_nav == "05"){ echo "selected";} ?> value="05">Mayo</option>
												<option <?php if($mes_nav == "06"){ echo "selected";} ?> value="06">Junio</option>
												<option <?php if($mes_nav == "07"){ echo "selected";} ?> value="07">Julio</option>
												<option <?php if($mes_nav == "08"){ echo "selected";} ?> value="08">Agosto</option>
												<option <?php if($mes_nav == "09"){ echo "selected";} ?> value="09">Septiembre</option>
												<option <?php if($mes_nav == "10"){ echo "selected";} ?> value="10">Octubre</option>
												<option <?php if($mes_nav == "11"){ echo "selected";} ?> value="11">Noviembre</option>
												<option <?php if($mes_nav == "12"){ echo "selected";} ?> value="12">Diciembre</option>
		
											</select>
											<script>
											  $('#mes_nav').change(function(){ 
											    //alert('test');
											    
												var mes_nav = $('#mes_nav').val();
												var anio_nav = $('#anio_nav').val();
											    // Asignar la URL de destino según el valor seleccionado en el <select>
												var newUrl = 'https://neuromodulaciongdl.com/reporte/ingresos.php?anio_nav='+anio_nav+'&mes_nav='+mes_nav; // Aquí debes colocar la URL de destino a la que deseas redireccionar
											
											    // Redireccionar a la nueva URL
											    window.location.href = newUrl;
											  });
											</script>											
										</div>								  	
								  	</div>
								  	<div class="col-xs-3">
										<div style="padding: 3px" id="anio_nav_">
											<select class="form-control" id="anio_nav" name="anio_nav">
												<?php
													$sql_anio ="
													SELECT
														year(fechas.fecha) as anio,
														COUNT(*) as cnt
													FROM
														fechas 
														GROUP BY 1;";
											        $result_anio=ejecutar($sql_anio); 
												    while($row_anio = mysqli_fetch_array($result_anio)){
												        extract($row_anio);																										
												?>
														<option <?php if($anio_nav == $anio){ echo "selected";} ?> value="<?php echo $anio; ?>"><?php echo $anio; ?></option>
												<?php } ?>
											</select>
											<script>
											  $('#anio_nav').change(function(){ 
											    //alert('test');
											    
												var mes_nav = $('#mes_nav').val();
												var anio_nav = $('#anio_nav').val();
											    // Asignar la URL de destino según el valor seleccionado en el <select>
												var newUrl = 'https://neuromodulaciongdl.com/reporte/ingresos.php?anio_nav='+anio_nav+'&mes_nav='+mes_nav; // Aquí debes colocar la URL de destino a la que deseas redireccionar
											
											    // Redireccionar a la nueva URL
											    window.location.href = newUrl;
											  });
											</script>
										</div>									  		
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