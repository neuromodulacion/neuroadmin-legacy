<?php

session_start();
error_reporting(7);
iconv_set_encoding('internal_encoding', 'utf-8'); 
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');
$_SESSION['time']=mktime();

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
    <link href="../../plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

<?php
include($ruta.'header2.php');
//include($ruta.'header.php'); ?>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>SOLICITUD DE PROTOCOLO</h2>
                 <?php //echo $ubicacion_url."<br>"; 
                // //echo $ruta."proyecto_medico/menu.php"?>
            </div>
<!-- // ************** Contenido ************** // -->
            <!-- CKEditor -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div style="height: 95%"  class="header">
                        	<h1 align="center">Solicitud de Protocolo</h1>
                        	
<div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                SOLICITUD DE PROTOCOLO
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="javascript:void(0);">Action</a></li>
                                        <li><a href="javascript:void(0);">Another action</a></li>
                                        <li><a href="javascript:void(0);">Something else here</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Correo</th>
                                            <th>Celular</th>
                                            <th>Estatus</th>
                                            <th>Accion</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Correo</th>
                                            <th>Celular</th>
                                            <th>Estatus</th>
                                            <th>Accion</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php
                                    
									$sql_protocolo = "
										SELECT
											*
										FROM
											pacientes
										WHERE
											estatus='Concluido'											
								        ";
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
                                            <td><?php echo $paciente_id; ?></td>
                                            <td><?php echo $paciente." ".$apaterno." ".$amaterno; ?></td>
                                            <td><?php echo $email; ?></td>
                                            <td><?php echo $celular; ?></td>
                                            <td><?php echo $estatus; ?></td>
                                            <td>
										         <a class="btn bg-teal waves-effect" href="<?php echo $ruta; ?>paciente/agenda.php?paciente_id=<?php echo $paciente_id; ?>">
										             <i class="material-icons">assignment</i> <B>Inicia nuevo protocolo</B>
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
                        	
                        	
        	                <!-- <div align="center" class="image">
			                    <img  src= "<?php echo $ruta.'images/menu.jpg'; ?>" style="max-width:100%;width:auto;height:auto;" />
			                </div> -->
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



<?php include($ruta.'footer2.php');?>