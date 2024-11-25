<?php
$ruta="../";

$hoy = date("Y-m-d");
$ahora = date("H:i:00"); 
$anio = date("Y");
$mes_ahora = date("m");
$titulo ="Pacientes Pendientes"; 


include($ruta.'header1.php');
//include($ruta.'header.php');
include('calendario.php');
include('fun_paciente.php');
if ($funcion == 'SISTEMAS' || $funcion == 'ADMINISTRADOR' ||  $funcion == 'COORDINADOR') {
	$class = "js-exportable";	
	$where = "AND pacientes.empresa_id = $empresa_id ";
}else{
	$class = "";
	
	if ($funcion == 'MEDICO'){$where = "AND pacientes.empresa_id = $empresa_id AND pacientes.usuario_id = $usuario_id";
	}else{
		$where = "AND pacientes.empresa_id = $empresa_id ";}
}

?>
    <!-- JQuery DataTable Css -->
    <link href="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

<?php
include($ruta.'header2.php');
//include($ruta.'header.php'); ?>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>PACIENTES</h2>
                 <?php //print_r($_SESSION);
                 //echo $ubicacion_url."<br>"; 
                // //echo $ruta."proyecto_medico/menu.php"?>
            </div>
<!-- // ************** Contenido ************** // -->
            <!-- CKEditor -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div style="height: 95%"  class="header">
                        	<h1 align="center">Pacientes Pendientes</h1>
                        	
							<div class="row clearfix">
				                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				                    <div class="card">
				                        <div class="header">
				                            <h2>
				                                PACIENTES PENDIENTES
				                            </h2>
				                            <!-- <ul class="header-dropdown m-r--5">
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
				                            </ul> -->
				                        </div>
				                        <div class="body">
				                            <div class="table-responsive">
				                                <table class="table table-bordered table-striped table-hover dataTable <?php echo $class; ?>">
				                                    <thead>
				                                        <tr>
				                                            <th style="max-width: 15px">ID</th>
				                                            <th style="min-width: 60px">Fecha</th>
				                                            <th style="min-width: 150px">Nombre</th>
				                                            <th style="min-width: 200px">Medico</th>
				                                            <th style="min-width: 100px">Celular</th>
				                                            <th>Estatus</th>
				                                            <th style="min-width: 320px">Accion</th>
				                                        </tr>
				                                    </thead>
				                                    <tfoot>
				                                        <tr>
				                                            <th>ID</th>
				                                            <th>Fecha</th>
				                                            <th>Nombre</th>
				                                            <th>Medico</th>
				                                            <th>Celular</th>
				                                            <th>Estatus</th>
				                                            <th>Accion</th>
				                                        </tr>
				                                    </tfoot>
				                                    <tbody>
				                                    <?php
				                                    
													$sql_protocolo = "
														SELECT
															pacientes.*,
															admin.nombre AS medico,
															estatus_paciente.color,
															estatus_paciente.rgb 
														FROM
															pacientes
															INNER JOIN admin ON pacientes.usuario_id = admin.usuario_id
															INNER JOIN estatus_paciente ON pacientes.estatus = estatus_paciente.estatus 
														WHERE
															pacientes.estatus = 'Pendiente'
															$where
												        ";
														// echo $sql_protocolo."<hr>";
												        $result_protocolo=ejecutar($sql_protocolo); 
												            //echo $cnt."<br>";  
												            //echo "<br>";    
												            $cnt=1;
												            $total = 0;
												            $ter="";
												        while($row_protocolo = mysqli_fetch_array($result_protocolo)){
												            extract($row_protocolo);
				                                    			$today = strftime( '%d-%b-%Y', strtotime( $f_captura) );
                                    							$edad = obtener_edad_segun_fecha($f_nacimiento);
					                                    		if ($class == 'bg-yellow') {
																	$class = "class='$class' style='color: black !important;'";
																} else {
																	$class = "class='$class'";
																}                                    							
				                                    ?>	
				                                        <tr>
				                                            <td><?php echo $paciente_id; ?></td>
				                                            <td><?php echo $today; ?></td>
				                                            <td><?php echo $paciente." ".$apaterno." ".$amaterno."<br><i>Edad: ".$edad; ?></td>
				                                            <td><?php echo $medico."<br><i>".$tratamiento."</i>"; ?></td>
				                                            <td><?php echo $celular."<br>".$tel1."<br>".$tel2; ?></td>
				                                            <td style="background: grey; color: #FFFFFF"><b><?php echo $estatus; ?></b></td>
				                                            <td>
				                                            	<?php if ($funcion == 'SISTEMAS' || $funcion == 'ADMINISTRADOR' || $funcion == 'TECNICO' || $funcion == 'COORDINADOR') { ?>
				
														         <a class="btn bg-cyan waves-effect" href="<?php echo $ruta; ?>agenda/agenda.php<?php echo "?paciente_id=$paciente_id&paciente=$paciente&apaterno=$apaterno&amaterno=$amaterno"; ?>">
														             <i class="material-icons">call_missed_outgoing</i> <B>Agenda</B>
														         </a>
														         <a class="btn bg-teal waves-effect"  target="_blank" href="https://api.whatsapp.com/send?phone=52<?php echo $celular; ?>&text=Buen día  <?php echo $paciente." ".$apaterno." ".$amaterno; ?> 
														         	recibímos una solicitud para una Terapia Electromagnetica Transcraneal Atte. <?php echo $nombre; ?> de Neuro Modulacion Gdl">
														             <img align="left" border="0" src="<?php echo $ruta; ?>images/WhatsApp.png"  style="width: 25px;  " >
														         </a>
														         <a class="btn bg-blue waves-effect" href="<?php echo $ruta; ?>paciente/registro_contacto.php<?php echo "?paciente_id=$paciente_id&paciente=$paciente&apaterno=$apaterno&amaterno=$amaterno"; ?>">
														             <i class="material-icons">assignment</i> <B>Registro</B>
														         </a>
														         <?php } ?>										         
														         <a class="btn bg-blue waves-effect" href="<?php echo $ruta; ?>paciente/info_paciente.php?paciente_id=<?php echo $paciente_id; ?>">
														             <i class="material-icons">chat</i> <B>Datos</B>
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