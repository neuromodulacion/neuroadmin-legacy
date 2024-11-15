<?php
$ruta="../";
$title = 'INICIO';

extract($_SESSION);
//print_r($_SESSION);
$hoy = date("Y-m-d");
$ahora = date("H:i:00"); 
$anio = date("Y");
$mes_ahora = date("m");
$titulo ="Directorio"; 


include($ruta.'header1.php');
//include($ruta.'header.php');
?>
    <!-- JQuery DataTable Css -->
    <link href="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

<?php
include($ruta.'header2.php');
//include($ruta.'header.php'); ?>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>DIRECTORIO</h2>
                 <?php //echo $ubicacion_url."<br>"; 
                // //echo $ruta."proyecto_medico/menu.php"?>
            </div>
<!-- // ************** Contenido ************** // -->
            <!-- CKEditor -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div style="height: 95%"  class="header">
                        	<h1 align="center">Directorio Pacientes</h1>                        	
		                        <div class="body">
		                            <div class="table-responsive">
		                                <table class="table table-bordered table-striped table-hover "><!-- dataTable js-exportable -->
		                                    <thead>
		                                        <tr>
		                                            <th>Nombre</th>
		                                            <th>bind ID</th>
		                                            <th>TMS ID</th>
		                                            <th>Cons ID</th>
		                                            <th>Bind</th>	                                     
		                                            <th>Estatus</th>
		                                            <th>Vta</th>
		                                            <th>Ubicación</th>
		                                            <th>Acciones</th>
		                                        </tr>
		                                    </thead>
		                                    <tfoot>
		                                        <tr>
		                                            <th>Nombre</th>
		                                            <th>bind ID</th>
		                                            <th>TMS ID</th>
		                                            <th>Cons ID</th>
		                                            <th>Bind</th>	                                     
		                                            <th>Estatus</th>
		                                            <th>Vta</th>
		                                            <th>Ubicación</th>
		                                            <th>Acciones</th>
		                                        </tr>
		                                    </tfoot>
		                                    <tbody>
		                                    <?php
		                                    
											$sql_protocolo = "
												SELECT
													pacientes_bind.ID, 
													pacientes_bind.paciente_id, 
													pacientes_bind.paciente_cons_id, 
													pacientes_bind.Number, 
													pacientes_bind.LegalName, 
													pacientes_bind.`STATUS`, 
													pacientes_bind.ventas, 
													pacientes_bind.Loctaion
												FROM
													pacientes_bind
												WHERE
													pacientes_bind.`STATUS` <> 'Eliminado'
												ORDER BY
													pacientes_bind.LegalName ASC, 
													pacientes_bind.Number ASC							
										        ";
												// echo $sql_protocolo."<br>";
										        $result_protocolo=ejecutar($sql_protocolo); 
										            //echo $cnt."<br>";  
										            //echo "<br>";    
										            $cnt=0;
										            $total = 0;
										            $ter="";
										        while($row_protocolo = mysqli_fetch_array($result_protocolo)){
										            extract($row_protocolo);
		                                    		
		                                    		if ($ventas >= 1) {
														$class = 'class="success"';
													}else{
														$class = '';
													}
		                                    		
													$cnt++;
		                                    ?>	
		                                        <tr id="tr_<?php echo $cnt; ?>">
		                                            <td><?php echo $LegalName; ?></td>
		                                            <td><?php echo $ID; ?></td>
		                                            <td><?php echo $paciente_id; ?></td>
		                                            <td><?php echo $paciente_cons_id; ?></td>
		                                            <td><?php echo $Number; ?></td>
		                                            
		                                            <td><?php echo $STATUS; ?></td>
		                                            <td  <?php echo $class; ?>><?php echo $ventas; ?></td>
		                                            <td><?php echo $Loctaion; ?></td>
		                                            
		                                            <td>
		                                    	 		<div class="btn-group" role="group">
															<?php // if ($funcion == 'SISTEMAS' || $funcion == 'ADMINISTRADOR' || $funcion == 'TECNICO') { ?>
													         <a id="elimina_bind<?php echo $cnt; ?>" target="_blank" class="btn bg-red waves-effect" href="elimina_cliente.php?ID=<?php echo $ID; ?>&paciente_id=<?php echo $paciente_id; ?>&paciente_cons_id=<?php echo $paciente_cons_id; ?>">
													             <i class="material-icons">delete_forever</i> <B>Del All</B>
													         </a>	
									                        <script>
									                            $('#elimina_bind<?php echo $cnt; ?>').click(function(){ 				                            	 
																	$("#tr_<?php echo $cnt; ?>").hide();
									                            });
									                        </script>	
									                        												         											         <!-- 
													         <a class="btn bg-blue waves-effect"  href="actializa_cliente_bind.php?paciente_id=<?php echo $paciente_id; ?>">
													             <i class="material-icons">chat</i> <B>Usar TMS</B>
													         </a>
													         <input type="text" id="paciente_id" name="paciente_id" value="">
													         <a class="btn btn-info waves-effect" href="actializa_cliente_bind.php?paciente_id=<?php echo $paciente_id; ?>">
													             <i class="material-icons">edit</i> <B>Usar Cons</B>
													         </a>
													         <input type="text" id="paciente_cons_id" name="paciente_cons_id" value="">	 -->										         	
												         </div>									         
		                                            </td>
		                                        </tr>
		                                     <?php $span=''; } ?>     
	                                    </tbody>
	                                </table>
	                            </div>
	                        </div>
	                    </div>
	                </div>
				</div>
			</div>
    </section>
<?php	

//include($ruta.'footer.php');

include($ruta.'footer1.php'); ?>


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



<?php include($ruta.'footer2.php');?>