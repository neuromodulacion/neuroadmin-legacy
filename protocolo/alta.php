<?php


$ruta="../";
;
$hoy = date("Y-m-d");
$ahora = date("H:i:00"); 
$anio = date("Y");
$mes_ahora = date("m");
$titulo ="Altas Protocolo";

include($ruta.'header1.php');

include('calendario.php');


?>
    <!-- Bootstrap Material Datetime Picker Css -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

    <!-- Bootstrap DatePicker Css -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />

    <!-- Wait Me Css -->
    <link href="<?php echo $ruta; ?>plugins/waitme/waitMe.css" rel="stylesheet" />

    <!-- Bootstrap Select Css -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

<?php
include($ruta.'header2.php');

//include($ruta.'header.php'); ?>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>ALTAS PROTOCOLO</h2>
                <?php //echo $ubicacion_url."<br>"; 
                //echo $ruta."proyecto_medico/menu.php"?>
            </div>
<!-- // ************** Contenido ************** // -->
            <!-- CKEditor -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div style="height: 95%"  class="header">
                        	<h1 align="center">Altas Protocolos</h1>
        	                <div align="left" class="image">
                				<p><h2><button id="crear" name="crear" type="button" class="btn bg-<?php echo $body; ?> waves-effect">
                                    <i class="material-icons">create_new_folder</i>
                                	</button>
				                        <script>
				                            $('#crear').click(function(){ 
				                            	//alert($('#dia_busca').val()); 
				                                $('#contenido').html(''); 
				                                $('#load_modal').show(); 
				                                $( "#crear" ).prop( "disabled", true );
				                                //alert("test");
				                                var body = '<?php echo $body; ?>';
				                                var inicio = 'protocolo';
				                                var datastring = 'inicio='+inicio+'&body='+body;
			                                    $.ajax({
			                                        url: 'genera_cuestionario.php',
			                                        type: 'POST',
			                                        data: datastring,
			                                        cache: false,
			                                        success:function(html){   
			                                        	//alert("test2");  
			                                            $('#contenido').html(html); 
			                                            $('#load_modal').hide();
			                                        }
			                                	});
				                            });
				                        </script>                                
                                Crear nuevo protocolo</h2></p>
			                </div>
			                <div id="contenido">
			                	
			                </div> 
		            		<div id="cont_preguntas">
		
			                </div>
		            		<div id="cont_guardado">
		
			                </div>	
                         	<div style="display: none" align="center" id="load_modal">
                                <div class="preloader pl-size-xl">
                                    <div class="spinner-layer pl-<?php echo $body; ?>">
                                        <div class="circle-clipper left">
                                            <div class="circle"></div>
                                        </div>
                                        <div class="circle-clipper right">
                                            <div class="circle"></div>
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
<?php	include($ruta.'footer1.php');	?>

    <!-- Autosize Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/autosize/autosize.js"></script>

    <!-- Moment Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/momentjs/moment.js"></script>

    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

    <!-- Bootstrap Datepicker Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>




<?php	include($ruta.'footer2.php');	?>