<?php
$ruta="../";

$hoy = date("Y-m-d");
$ahora = date("H:i:00"); 
$anio = date("Y");
$mes_ahora = date("m");
$titulo ="Estatus Protocolos"; 

include($ruta.'header1.php');
//include($ruta.'header.php');
?>
    <!-- JQuery DataTable Css -->
    <link href="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

<?php
include($ruta.'header2.php');
//include($ruta.'header.php'); ?>

    <section  style="padding: 2px !important"  class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>ESTATUS PROTOCOLOS</h2>
                <?php echo $ubicacion_url."<br>"; 
                //echo $ruta."proyecto_medico/menu.php"?>
            </div>
<!-- // ************** Contenido ************** // -->
            <!-- CKEditor -->
            <divclass="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div style="height: 95%"  class="header">
                        	<h1 align="center">Estatus</h1>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Modelo</th>
                                            <th>Terapia</th>
                                            <th>Estatus</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Modelo</th>
                                            <th>Terapia</th>
                                            <th>Estatus</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php
                                    
									$sql_protocolo = "
										SELECT
											protocolo_terapia.protocolo_ter_id,
											protocolo_terapia.prot_terapia,
											protocolo_terapia.estatus,
											protocolo_terapia.usuario_id,
											estatus_paciente.class,
											protocolo_terapia.equipo_id,
											equipos.modelo, 
											equipos.siglas
										FROM
											protocolo_terapia
											INNER JOIN estatus_paciente ON protocolo_terapia.estatus = estatus_paciente.estatus
											INNER JOIN equipos ON protocolo_terapia.equipo_id = equipos.equipo_id
								        ";
								        $result_protocolo=ejecutar($sql_protocolo); 
								            //echo $cnt."<br>";  
								            //echo "<br>";    
								            $cnt=1;
								            $total = 0;
								            $ter="";
								        while($row_protocolo = mysqli_fetch_array($result_protocolo)){
								            extract($row_protocolo);
                                    		
                                    		if ($class == 'bg-yellow') {
												$class = "class='$class' style='color: black !important;'";
											} else {
												$class = "class='$class'";
											}
											
                                    		
                                    		//$class = "class='$class'";

                                    ?>	
                                        <tr>
                                            <td style='!color: black'><?php echo $protocolo_ter_id; ?></td>
                                            <td><?php echo $prot_terapia; ?></td>
                                            <td><?php echo $modelo; ?></td>
                                            <td><?php echo $siglas; ?></td>
                                            <td  <?php echo $class; ?>><?php echo $estatus; ?></td>
                                        </tr>
                                     <?php } ?>   
                                        

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    	</div>
                	</div>
            	</div>
        	</div>
              

        </div>
    </section>

<?php

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



<?php include($ruta.'footer2.php');?>