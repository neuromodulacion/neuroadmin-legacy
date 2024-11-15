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
extract($_POST);
extract($_GET);
//print_r($_SESSION);

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
                        	<h1 align="center">Noticias</h1>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Noticia</th>
                                            <th>Fecha</th>
                                            <th>Estatus</th>
                                            <th>Ver</th>
                                            <th>Edit</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Noticia</th>
                                            <th>Fecha</th>
                                            <th>Estatus</th>
                                            <th>Ver</th>
                                            <th>Edit</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php
                                    
									$sql_protocolo = "
SELECT
	articulo.articulo_id as articulo_idx, 
	articulo.usuario_id, 
	articulo.titulo, 
	articulo.titulo_corto, 
	articulo.descripcion, 
	articulo.insert_multimedia,
	articulo.multimedia, 
	articulo.autor, 
	articulo.titulo_autor, 
	articulo.imagen_autor, 
	articulo.f_alta, 
	articulo.h_alta, 
	articulo.contenido,
	articulo.estatus
FROM
	articulo
										
								        ";
								        $result_protocolo=ejecutar($sql_protocolo); 
								            //echo $cnt."<br>";  
								            //echo "<br>";    
								            $cnt=1;
								            $total = 0;
								            $ter="";
								        while($row_protocolo = mysqli_fetch_array($result_protocolo)){
								            extract($row_protocolo);
                                    		
                                    		// if ($class == 'bg-yellow') {
												// $class = "class='$class' style='color: black !important;'";
											// } else {
												// $class = "class='$class'";
											// }
											
                                    		
                                    		//$class = "class='$class'";

                                    ?>	
                                        <tr>
                                            <td style='!color: black'><?php echo $articulo_idx; ?></td>
                                            <td><?php echo ($titulo); ?></td>
                                            <td><?php echo $f_alta; ?> </td>
                                            <td id='td1_<?php echo $usuario_idx; ?>' >
                                            	<select id="estatus<?php echo $articulo_idx; ?>" name="estatus<?php echo $articulo_idx; ?>" class="form-control show-tick">
												  <option <?php if($estatus == 'Activo'   ){ echo "selected";} ?>  value="Activo"    >Activo</option>
												  <option <?php if($estatus == 'Pendiente'){ echo "selected";} ?>  value="Pendiente" >Pendiente</option>
												  <option <?php if($estatus == 'Inactivo' ){ echo "selected";} ?>  value="Inactivo"  >Inactivo</option>
												  <option <?php if($estatus == 'Bloqueado'){ echo "selected";} ?>  value="Bloqueado" >Bloqueado</option>
												</select>
				                        <script>
				                            $('#estatus<?php echo $articulo_idx; ?>').change(function(){ 
				                            	//alert($('#estatus<?php echo $articulo_idx; ?>').val()); 

				                                var estatusx = $('#estatus<?php echo $articulo_idx; ?>').val();
				                                var articulo_id = '<?php echo $articulo_idx; ?>';
				                                var accion = 'estatus';

				                                var datastring = 'estatusx='+estatusx+'&articulo_id='+articulo_id+'&accion='+accion;
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
										         <a class="btn btn-info  btn-sm waves-effect" target="_blank" href="<?php echo $ruta; ?>noticias/test.php?articulo_id=<?php echo $articulo_idx; ?>">
										             <i class="material-icons">http</i> 
										         </a>
                                            </td>                                            
                                            <td>
										         <a class="btn btn-info  btn-sm waves-effect" href="<?php echo $ruta; ?>noticias/noticia_edit.php?articulo_id=<?php echo $articulo_idx; ?>">
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