<?php
include('../api/funciones_api.php');  // Funciones adicionales de la API

$ruta="../";

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

    <!-- 
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
//print_r($_SESSION)
?>


    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>DIRECTORIO</h2>
                <?php // echo $ubicacion_url."<br>"; 
                //echo $ruta."proyecto_medico/menu.php"?>
            </div>
<!-- // ************** Contenido ************** // -->
            <!-- CKEditor -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div style="height: 95%"  class="header">
                        	<h1 align="center">Directorio</h1>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Correo</th>
                                            <th>Tipo</th>
                                            <th>Estatus</th>
                                            <th>Edit</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Correo</th>
                                            <th>Tipo</th>
                                            <th>Estatus</th>
                                            <th>Edit</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php
                                    
									$sql_protocolo = "
										SELECT
											admin.usuario_id as usuario_idx, 
											admin.nombre, 
											admin.usuario, 
											admin.funcion as funcionx, 
											admin.estatus
										FROM
											admin	
										WHERE
											admin.empresa_id = $empresa_id
											and admin.estatus <>'Bloqueado'							
								        ";
										// echo $sql_protocolo;
								        $result_protocolo=ejecutar($sql_protocolo); 
								            //echo $cnt."<br>";  
								            //echo "<br>";    
								            $cnt=1;
								            $total = 0;
								            $ter="";
								        while($row_protocolo = mysqli_fetch_array($result_protocolo)){
								            extract($row_protocolo);

                                    ?>	
                                        <tr>
                                            <td style='!color: black'><?php echo $usuario_idx; ?></td>
                                            <td><?php echo ($nombre); ?></td>
                                            <td><?php echo $usuario; ?> </td>
                                            <td id='td_<?php echo $usuario_id; ?>' >
                                            	<select id="funcion<?php echo $usuario_idx; ?>" name="funcion<?php echo $usuario_idx; ?>" class="form-control show-tick" 
                                            		<?php if ($funcion <> 'SISTEMAS' && $funcion <> 'ADMINISTRADOR' && $funcion <> 'COORDINADOR ADMIN') { echo 'disabled'; } ?>>

												 	<?php
														$sql_funciones = "
															SELECT
																funciones.funcion as funciony 
															FROM
																funciones 
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
                                    														 
												  <option <?php if($funcionx == $funciony){ echo "selected";} ?> value="<?php echo $funciony; ?>" ><?php echo $funciony; ?></option>
											<?php } ?>	
												</select>
				                        <script>
				                            $('#funcion<?php echo $usuario_idx; ?>').change(function(){ 
				                            	//alert($('#funcion<?php echo $usuario_id; ?>').val()); 

				                                var funcionx = $('#funcion<?php echo $usuario_idx; ?>').val();
				                                var usuario_id = '<?php echo $usuario_idx; ?>';
				                                var accion = 'funcion';

				                                var datastring = 'funcionx='+funcionx+'&usuario_id='+usuario_id+'&accion='+accion;
				                                //alert(datastring);
			                                    $.ajax({
			                                        url: 'actualiza_direcctorio.php',
			                                        type: 'POST',
			                                        data: datastring,
			                                        cache: false,
			                                        success:function(html){
			                                        	alert('Se modifico correctemente'); 
			                                        	$('#td_<?php echo $usuario_idx; ?>').css("background-color", "#5cb85c");      
			                                            //$('#calendario').html(html); 
			                                            //$('#load1').hide();
			                                            //$('#muestra_asegurado').click();
			                                        }
			                                	});
				                            });
				                        </script>												
                                        	</td>
                                            <td id='td1_<?php echo $usuario_idx; ?>' >
                                            	<select id="estatus<?php echo $usuario_idx; ?>" name="estatus<?php echo $usuario_idx; ?>" class="form-control show-tick"
                                            		<?php if ($funcion == 'TECNICO') { echo 'disabled'; } ?>>
												  <option <?php if($estatus == 'Activo'){ echo "selected";} ?>  value="Activo" >Activo</option>
												  <option <?php if($estatus == 'Pendiente'){ echo "selected";} ?>  value="Pendiente" >Pendiente</option>
												  <option <?php if($estatus == 'Inactivo'){ echo "selected";} ?>  value="Inactivo" >Inactivo</option>
												  <option <?php if($estatus == 'Bloqueado'){ echo "selected";} ?>  value="Bloqueado" >Bloqueado</option>
												</select>
				                        <script>
				                            $('#estatus<?php echo $usuario_idx; ?>').change(function(){ 
				                            	//alert($('#estatus<?php echo $usuario_idx; ?>').val()); 

				                                var estatusx = $('#estatus<?php echo $usuario_idx; ?>').val();
				                                var usuario_id = '<?php echo $usuario_idx; ?>';
				                                var accion = 'estatus';

				                                var datastring = 'estatusx='+estatusx+'&usuario_id='+usuario_id+'&accion='+accion;
				                                //alert(datastring);
			                                    $.ajax({
			                                        url: 'actualiza_direcctorio.php',
			                                        type: 'POST',
			                                        data: datastring,
			                                        cache: false,
			                                        success:function(html){     
			                                            alert('Se modifico correctemente');
			                                            $('#td1_<?php echo $usuario_idx; ?>').css("background-color", "#5cb85c");
			                                            //$('#calendario').html(html); 
			                                            //$('#load1').hide();
			                                            //$('#muestra_asegurado').click();
			                                        }
			                                	});
				                            });
				                        </script>												
                                            </td>
                                            <td>
										         <a class="btn btn-info  btn-sm waves-effect" href="<?php echo $ruta; ?>usuarios/usuario_edit.php?usuario_idx=<?php echo $usuario_idx; ?>">
										             <i class="material-icons">edit</i> <B>Edit</B>
										         </a>
                                            </td>
                                        </tr>
                                     <?php } ?>   
                                        

                                    </tbody>
                                </table>
                    	</div>
                	</div>
            	</div>
        	</div>
              

        </div>
    </section>
<?php	include($ruta.'footer1.php');	?>

    <!-- Jquery DataTable Plugin Js -->
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




<?php	include($ruta.'footer2.php');	?>