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
                <?php echo $ubicacion_url."<br>"; ?>
            </div>
<!-- // ************** Contenido ************** // -->
            <!-- CKEditor -->
            <divclass="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div style="height: 95%"  class="header">
                        	<h1 align="center">Clinimetrias</h1>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Clinimetria</th>
                                            <th>Descripción</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Clinimetria</th>
                                            <th>Descripción</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php
                                    
									$sql_protocolo = "
										SELECT
											encuestas.encuesta_id, 
											encuestas.encuesta, 
											encuestas.descripcion
										FROM
											encuestas
								        ";
								        $result_protocolo=ejecutar($sql_protocolo); 
								            //echo $cnt."<br>";  
								            //echo "<br>";    
								            $cnt=1;
								            $total = 0;
								            $ter="";
                                            $class = "";
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
                                            <td style='!color: black'><?php echo $encuesta_id; ?></td>
                                            <td><?php echo codificacionUTF($encuesta); ?></td>
                                            <td><?php echo $descripcion; ?></td>
                                            <td><button class="btn btn-default" id="btn_<?php echo $encuesta_id; ?>" type="button">Ver</button>
                                            <script>
                                                $('#btn_<?php echo $encuesta_id; ?>').click(function(){ 

                                                    var encuesta_id = '<?php echo $encuesta_id; ?>';
                                                    var accion = 'ver';
                                                    var datastring = 'encuesta_id='+encuesta_id+'&accion='+accion;
                                                    $('#modalcli').click();
                                                    //alert(datastring);
                                                    $.ajax({
                                                        url: 'muestra_clinimetria.php',
                                                        type: 'POST',
                                                        data: datastring,
                                                        cache: false,
                                                        success:function(html){
                                                            //alert('Se modifico correctemente');   
                                                            $('#contenido').html(html); 
                                                            //$('#load1').hide();
                                                            //$('#muestra_asegurado').click();
                                                        }
                                                    });
                                                });
                                            </script>
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
        	</div>
            <button id="modalcli" type="button" class="btn btn-default waves-effect m-r-20" data-toggle="modal" data-target="#clinimetriaModal">MODAL - LARGE SIZE</button>
    <!-- Large Size -->
    <div class="modal fade" id="clinimetriaModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="clinimetriaModalLabel">Clinimetria</h4>
                </div>
                <div id="contenido" class="modal-body">
 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
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