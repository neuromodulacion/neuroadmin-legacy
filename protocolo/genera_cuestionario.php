<?php
include('../functions/funciones_mysql.php');
session_start();

// Establecer el nivel de notificación de errores
error_reporting(E_ALL); // Reemplaza `7` por `E_ALL` para usar la constante más clara y recomendada

// Establecer la codificación interna a UTF-8 (ya no se utiliza `iconv_set_encoding`, sino `ini_set`)
ini_set('default_charset', 'UTF-8');

// Configurar la cabecera HTTP con codificación UTF-8
header('Content-Type: text/html; charset=UTF-8');

// Configurar la zona horaria
date_default_timezone_set('America/Monterrey');

// Configurar la localización para manejar fechas y horas en español
setlocale(LC_TIME, 'es_ES.UTF-8');

// Asignar el tiempo actual a la sesión en formato de timestamp
$_SESSION['time'] = time(); // `time()` es el equivalente moderno a `mktime()`


$ruta = "../";
extract($_POST);
print_r($_POST);
// echo "<hr>";
extract($_SESSION);
// print_r($_SESSION);
// echo "<hr>";
//$aviso = stripslashes($_POST['aviso']); 
include('fun_cuestionario.php');

$f_captura = date("Y-m-d");
$h_captura = date("H:i:s"); 
$mes =  substr($mes_ano, 5, 2);
$ano = substr($mes_ano, 0, 4);

//echo "<hr>".$inicio."<hr>";

switch ($inicio) {
	case 'protocolo':
	?>
            <hr>
            <form id="formn_protocolo">
            <div class="form-group form-group-lg">
                <div class="form-line">
                	<div class="row clearfix">
						<div class="col-sm-7">
	                        <div class="form-group">
	                            <div class="form-line">
	                                <input id="n_protocolo" name="n_protocolo" type="text" class="form-control" placeholder="Nombre de Protocolo" required/>
	                                <input id="body" name="body" type="hidden" value="<?php echo $body; ?>" />
	                                <input id="inicio" name="inicio" type="hidden" value="preguntas" />
	                            </div>
	                        </div>
	                    </div>
	                    <div class="col-sm-5">
	                        <div class="form-group">
	                            <div >
				        				<p><h2><button id="guarda_pro" name="guarda_pro" type="button" class="btn bg-<?php echo $body; ?> waves-effect">
				                            <i class="material-icons">note_add</i>
				            				</button> Guarda Nombre, Inicia Preguntas</h2></p>
				            				<button id="submit_test" type="submit" style="display: none" class="btn bg-<?php echo $body; ?> btn-block btn-lg waves-effect"></button>
									        <script>
										        $('#guarda_pro').click(function(){ 
										        	//alert("test");
												        var emptyFields = $('#formn_protocolo').find('input[required], select[required], textarea[required]').filter(function() {
												            return this.value === '';
												        });
												        if (emptyFields.length > 0) {
												            emptyFields.each(function() {
												            $('#submit_test').click();
												                //alert('El campo ' + this.name + ' está vacío.');
												            });
												        }else{ 				        	
												        	var datastring = $('#formn_protocolo').serialize();
						                                	$('#contenido_preguntas').html(''); 
							                                $('#load_modal').show(); 
							                                $( "#guarda_pro" ).prop( "disabled", true );
							                                $( "#n_protocolo" ).prop( "disabled", true );	
							                                
															$.ajax({
											                    url: 'genera_cuestionario.php',
											                    type: 'POST',
											                    data: datastring,
											                    cache: false,
											                    success:function(html){	                    	     
											                        $('#load_modal').hide();
											                        $('#contenido_preguntas').html(html); 
											                         
											                    }
											            	});		                	
											        	}	        
										        
										        });  
								        	</script>		
								        		                        		
			                        		<!-- <script type='text/javascript'>

						                            $('#guarda_pro').click(function(){ 
						                            	// alert('dia_busca'); 
	
						                                
						                                var n_protocolo = $("#n_protocolo").val();
						                                //alert(n_protocolo);
						                                var body = '<?php echo $body; ?>';
						                                var inicio = 'preguntas';
						                                if (n_protocolo !== "") {
						                                	$('#contenido_preguntas').html(''); 
							                                $('#load_modal').show(); 
							                                $( "#guarda_pro" ).prop( "disabled", true );
							                                $( "#n_protocolo" ).prop( "disabled", true );						                                	
						                                	var datastring = 'inicio='+inicio+'&body='+body+'&n_protocolo='+n_protocolo;
						                                     alert(datastring);
						                                    $.ajax({
						                                        url: 'genera_cuestionario.php',
						                                        type: 'POST',
						                                        data: datastring,
						                                        cache: false,
						                                        success:function(html){   
						                                        	//alert("test2");  
						                                            $('#contenido_preguntas').html(html); 
						                                            $('#load_modal').hide();
							                                        }
							                                	});
						                                }else{ alert('Tienes que ingresar un nombre')};	
					                            	});
												
					                        </script> -->  
		                        </div>
		                    </div>
		                </div>    						  
	                </div>
            		<div id="contenido_preguntas">

	                </div>
            		<div id="cont_preguntas">

	                </div>
            		<div id="cont_guardado">

	                </div>		                
	            </div>
            </div>	
            </form>
	<?php	
		break;
	
	case 'preguntas': 
	
		$sql = "SELECT
					prot_terapia 
				FROM
					protocolo_terapia
				WHERE
					prot_terapia = $n_protocolo"; 
		//echo $sql;			
		$result_sql = ejecutar($sql);				
		$cnt = mysqli_num_fields($result_sql);	
	
	
		if ($cnt == 0 ) {			
			$insert1 ="
				INSERT IGNORE INTO protocolo_terapia 
					( prot_terapia,estatus ) 
				VALUE
					( '$n_protocolo','Pendiente' ) ";
				//echo "<hr>".$insert1."<hr>";
				$result_insert = ejecutar($insert1);
				//echo $result_insert."<hr>";

	 
			$sql = "SELECT
						max(protocolo_ter_id)  as protocolo_ter_id 
					FROM
						protocolo_terapia"; 
						
			$result_sql = ejecutar($sql);				
			$row = mysqli_fetch_array($result_sql);
			extract($row);			
			echo "<h1>Se agrego correctamente</h1>";				
			
		} 
	
	
	?>
        <hr>
        <form id="form_preguntas_1" >
        <div class="row clearfix">
			<div class="col-sm-6">
                <div class="form-group">
                    <div class="form-line">
                        <input id="pregunta" name="pregunta" type="text" class="form-control" placeholder="Pregunta * debes ingresar primero este campo" />
                        <input id="protocolo_ter_id" name="protocolo_ter_id" type="hidden" value="<?php echo $protocolo_ter_id; ?>" />
                        <input id="body" name="body" type="hidden" value="<?php echo $body; ?>" />
                        <input id="inicio" name="inicio" type="hidden" value="elementos" />
                    	<!-- <button id="submit_test" type="submit" style="display: none" ></button> -->
                    </div>
                </div>
            </div>                            	
            <div class="col-sm-6">
                <select id="tipo" name="tipo" class="form-control show-tick" disabled>
                    <option value="">-- Seleciona tipo de Respuesta --</option>
                    <option value="textarea">Area texto</option>
                    <option value="date">Fecha</option>
                    <option value="instrucciones">Instrucciones</option> 
                    <option value="number">Numero</option>
                    <option value="radio">Radio</option>
                    <option value="titulo">Titulo</option>
                    <option value="text">Texto</option>
                    <option value="select">Select</option>                     
                </select>
                
		        <script type='text/javascript'>
			        //$('#pregunta').change((function(){ 
			        $('#pregunta').on('keyup', function() {
			        	//alert("test");
	        			var pregunta = $("#pregunta").val().length;
	        			if (pregunta > 0) {
	        				//alert(pregunta);
	        				$( "#tipo" ).prop( "disabled", false );
	        			} else{
	        				//alert('Vacio');
	        				$( "#tipo" ).prop( "disabled", true );
	        			};
	        			
			        	
			        });  
	        	</script>               
        		<script type='text/javascript'>
                    $('#tipo').change(function(){ 
                    	alert($('#tipo').val());                   	 
                        $('#cont_preguntas').html(''); 
                        $('#load_modal').show(); 
                        // var tipo = $("#tipo").val();
                        // var pregunta = $("#pregunta").val();
                        // var protocolo_ter_id = '<?php echo $protocolo_ter_id; ?>';
                        // // //$( "#crear" ).prop( "disabled", true );
                        // // //alert("test");
                        // var body = '<?php echo $body; ?>';
                        // var inicio = 'elementos';
                        // var datastring = 'inicio='+inicio+'&body='+body+'&pregunta='+pregunta+"&tipo="+tipo+'&protocolo_ter_id='+protocolo_ter_id;

                    	var datastring = $('#form_preguntas_1').serialize();
                        alert(datastring);
                        $.ajax({
                            url: 'genera_cuestionario.php',
                            type: 'POST',
                            data: datastring,
                            cache: false,
                            success:function(html){   
                            	//alert("test2");  
                                $('#cont_preguntas').html(html); 
                                $('#load_modal').hide();
                            }
                    	});
	
                    });
                </script>                                     
                
            </div>
        </div>
        </form>
		<?php	
		break;
	
	case 'elementos': 
		
	$pregunta_id = 0;
	if ($cnt_resp <= 2) { $cnt_resp = 2; } 
	$respuestas = '';		
	echo tipo_elemento($tipo,$cnt_radio,$pregunta,$respuestas,$pregunta_id,$body,$protocolo_ter_id);

}

?>
