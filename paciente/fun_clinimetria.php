<?php

$ruta="../";

//extract($_SESSION);
//include($ruta.'functions/funciones_mysql.php');

function tipo_elemento($tipo,$cnt_radio,$pregunta,$respuestas,$pregunta_id,$body,$protocolo_ter_id){

//$res = $tipo." ".$cnt_resp." ".$pregunta." ".$respuestas." ".$pregunta_id." ".$body."<hr>";

if ($cnt_radio < 2) {
	$cnt_radio = 2;
}
//target='_blank' action='guarda_preguntas.php'
$resultado ="<form  id='form_preguntas' method='post' >
	<input min='2' max='10' align='center' name='tipo' type='hidden' id='tipo' value='$tipo'/>
	<input name='pregunta' type='hidden' id='pregunta' value='$pregunta'/>
	<input name='protocolo_ter_id' type='hidden' id='protocolo_ter_id' value='$protocolo_ter_id'/>
	<input name='body' type='hidden' id='body' value='$body'/>
	<input name='cnt_radio' type='hidden' id='cnt_radio' value='$cnt_radio'/>";
	
switch ($tipo) {
	case 'radio': 
		$resultado .="
		<hr>
        <h1>Pregunta :<h1>
        <h3>$pregunta</h3>
        <h2 class='card-inside-title'>Respuestas</h2>
        <input min='2' max='10' align='center' name='cnt_radio' type='number' id='cnt_radio' value='$cnt_radio'/>
        <div class='' demo-radio-button'>
            <input name='radio' type='radio' id='radio_1' class='radio-col-$body'  checked />
            <label id='lradio_1' for='radio_1'>Respuesta - 1</label>
            <input name='radio' type='radio' id='radio_2' class='radio-col-$body' />
            <label id='lradio_2' for='radio_2'>Respuesta - 2</label>
        ";
		
		$extas = "";
		$resp ="";	
		if ($cnt_radio >= 2) {
			for ($i=2; $i < $cnt_radio; ) { 
			$i++;
			$extas .="
            <input name='radio' type='radio' id='radio_$i' class='radio-col-$body' />
            <label id='lradio_$i' for='radio_$i'>Respuesta - $i</label>";			
			$resp .="
	        <div class='form-line'>
				<div class='row'>
				  <div class='col-xs-1'><p><h2> $i.</h2></p></div>
				  <div class='col-xs-11'><input id='respuesta_$i' name='respuesta_$i' type='text' class='form-control' placeholder='Respuesta $i' /></div>
				</div> 	        
	        </div>	
        	<script type='text/javascript'>
                $('#respuesta_$i').change(function(){
                	//alert($('#respuesta_$i').val());
					var respuesta_$i = $('#respuesta_$i').val();
                    $('#lradio_$i').text('$i. '+respuesta_$i);
                });
            </script>         		
			";	
			}			
		}

		$resultado .= $extas;
		
		$resultado .="
        <div class='form-line'>
			<div class='row'>
			  <div class='col-xs-1'><p><h2> 1.</h2></p></div>
			  <div class='col-xs-11'><input id='respuesta_1' name='respuesta_1' type='text' class='form-control' placeholder='Respuesta 1' /></div>
			</div>        
        </div>
        	<script type='text/javascript'>
                $('#respuesta_1').change(function(){
                	//alert($('#respuesta_1').val());
					var respuesta_1 = $('#respuesta_1').val();
                    $('#lradio_1').text('1. '+respuesta_1);
                });
            </script>		
        <div class='form-line'>
			<div class='row'>
			  <div class='col-xs-1'><p><h2> 2.</h2></p></div>
			  <div class='col-xs-11'><input id='respuesta_2' name='respuesta_2' type='text' class='form-control' placeholder='Respuesta 2' /></div>
			</div> 
        </div>	
        	<script type='text/javascript'>
                $('#respuesta_2').change(function(){
                	//alert($('#respuesta_2').val());
					var respuesta_2 = $('#respuesta_2').val();
                    $('#lradio_2').text('2. '+respuesta_2);
                });
            </script>       
		</div>
			<script type='text/javascript'>
                $('#cnt_radio').change(function(){ 
					alert($('#cnt_radio').val());  
                    var cnt_radio = $('#cnt_radio').val();
					var tipo = $('#tipo').val();
                    var pregunta = '$pregunta'; 
                    //$('#n_protocolo').val();
                    var body = '$body';
					var protocolo_ter_id = '$protocolo_ter_id';
                    var inicio = 'elementos';
                    var datastring = 'inicio='+inicio+'&body='+body+'&pregunta='+pregunta+'&tipo='+tipo+'&cnt_radio='+cnt_radio+'&protocolo_ter_id='+protocolo_ter_id;
                    $('#cont_preguntas').html(''); 
                    $('#load_modal').show();
				    //alert(datastring);
                    $.ajax({
                        url: 'genera_cuestionario.php',
                        type: 'POST',
                        data: datastring,
                        cache: false,
                        success:function(html){   
                        	//alert('test2');  
                            $('#cont_preguntas').html(html); 
                            $('#load_modal').hide();
                        }
                	});
                });
            </script>
		";
		$resultado.= $resp;
		break;

	case 'select': 
		$resultado .="
		<hr>
        <h1>Pregunta :<h1>
        <h3>$pregunta</h3>
        <h2 class='card-inside-title'>Respuestas</h2>
        <input min='2' max='10' align='center' name='cnt_radio' type='number' id='cnt_radio' value='$cnt_radio'/>

                                    <select id='select' name='select' class='form-control show-tick'>
                                        <option value=''>-- Seleciona tipo de Respuesta --</option>
                                        <option value='resp_1'>Respuesta 1</option>
                                        <option value='resp_2'>Respuesta 2</option>
    
                                      
        ";
		
		$extas = "";
		$resp ="";	
		if ($cnt_radio >= 2) {
			for ($i=2; $i < $cnt_radio; ) { 
			$i++;
			$extas .="
            <option value='resp_$1'>Respuesta $i</option>";			
			$resp .="
	        <div class='form-line'>
				<div class='row'>
				  <div class='col-xs-1'><p><h2> $i.</h2></p></div>
				  <div class='col-xs-11'><input id='respuesta_$i' name='respuesta_$i' type='text' class='form-control' placeholder='Respuesta $i' /></div>
				</div> 	        
	        </div>	
        	<script type='text/javascript'>
                $('#respuesta_$i').change(function(){
                	//alert($('#respuesta_$i').val());
					var respuesta_$i = $('#respuesta_$i').val();
					$('#select option[value= $i]').html(respuesta_$i);
                    //$('#lradio_$i').text('$i. '+respuesta_$i);
                });
            </script>         		
			";	
			}			
		}

		$resultado .= $extas;
		
		$resultado .="
		</select> 
        <div class='form-line'>
			<div class='row'>
			  <div class='col-xs-1'><p><h2> 1.</h2></p></div>
			  <div class='col-xs-11'><input id='respuesta_1' name='respuesta_1' type='text' class='form-control' placeholder='Respuesta 1' /></div>
			</div>        
        </div>
        	<script type='text/javascript'>
                $('#respuesta_1').change(function(){
                	//alert($('#respuesta_1').val());
					var respuesta_1 = $('#respuesta_1').val();
					$('#select option[value= 1]').html(respuesta_1);
                    //$('#lradio_1').text('1. '+respuesta_1);
                });
            </script>		
        <div class='form-line'>
			<div class='row'>
			  <div class='col-xs-1'><p><h2> 2.</h2></p></div>
			  <div class='col-xs-11'><input id='respuesta_2' name='respuesta_2' type='text' class='form-control' placeholder='Respuesta 2' /></div>
			</div> 
        </div>	
        	<script type='text/javascript'>
                $('#respuesta_2').change(function(){
                	//alert($('#respuesta_2').val());
					var respuesta_2 = $('#respuesta_2').val();
					$('#select option[value= 2]').html(respuesta_2);
                    //$('#lradio_2').text('2. '+respuesta_2);
                });
            </script>       
		</div>
			<script type='text/javascript'>
                $('#cnt_radio').change(function(){ 
					alert($('#cnt_radio').val());  
                    // var cnt_radio = $('#cnt_radio').val();
					// var tipo = $('#tipo').val();
                    // var pregunta = $('#n_protocolo').val();
                    // var body = '$body';
					// var protocolo_ter_id = '$protocolo_ter_id';
                    // var inicio = 'elementos';
                    // var datastring = 'inicio='+inicio+'&body='+body+'&pregunta='+pregunta+'&tipo='+tipo+'&cnt_radio='+cnt_radio+'&protocolo_ter_id='+protocolo_ter_id;
                    // $('#cont_preguntas').html(''); 
                    // $('#load_modal').show();
				    // alert(datastring);
                    // $.ajax({
                        // url: 'genera_cuestionario.php',
                        // type: 'POST',
                        // data: datastring,
                        // cache: false,
                        // success:function(html){   
                        	// //alert('test2');  
                            // $('#cont_preguntas').html(html); 
                            // $('#load_modal').hide();
                        // }
                	// });
                });
            </script>
		";
		$resultado.= $resp;
		break;
						
	case 'text':
		$resultado .="
		<hr>
        <h1>Pregunta :<h1>
        <h3>$pregunta</h3>
        <h2 class='card-inside-title'>Respuesta</h2>
        <div class='form-line'>
			  <input id='respuesta_1' name='respuesta_1' type='text' class='form-control' placeholder='Respuesta 1' />
			</div>        
        </div>        
        ";		
		break;	
		
	case 'textarea':
		$resultado .="
		<hr>
        <h1>Pregunta :<h1>
        <h3>$pregunta</h3>
        <h2 class='card-inside-title'>Respuesta</h2>
        <div class='form-line'>
            <div class='form-line'>
                <textarea rows='4'  id='respuesta_1' name='respuesta_1'  class='form-control no-resize' placeholder='Por favor responda la pregunta'></textarea>
            </div>       
        </div>        
        ";		
		break;	
				
	case 'date':
		$resultado .="
		<hr>
        <h1>Pregunta :<h1>
        <h3>$pregunta</h3>
        <h2 class='card-inside-title'>Respuesta</h2>
        <div class='form-line'>
			<div class='row'>
			  <div class='col-xs-1'><p><h2> 1.</h2></p></div>
			  <div class='col-xs-11'><input id='respuesta_1' name='respuesta_1' type='date' class='form-control' placeholder='Respuesta 1' /></div>
			</div>        
        </div>        
        ";		
		break;	
			
	case 'number':
		$resultado .="
		<hr>
        <h1>Pregunta :<h1>
        <h3>$pregunta</h3>
        <h2 class='card-inside-title'>Respuesta</h2>
        <div class='form-line'>
			<div class='row'>
			  <div class='col-xs-1'><p><h2> 1.</h2></p></div>
			  <div class='col-xs-11'><input id='respuesta_1' name='respuesta_1' type='number' class='form-control' placeholder='Respuesta 1' /></div>
			</div>        
        </div>        
        ";		
		break;

	case 'titulo':
	
		$resultado .="
		<hr>
        <h1>Pregunta :<h1>
        <h3>$pregunta</h3>
        <h2 class='card-inside-title'>Respuesta</h2>
        <div class='form-line'>
			  <input id='respuesta_1' name='respuesta_1' type='text' class='form-control' placeholder='Respuesta 1' />
			</div>        
        </div>        
        ";	
		break;
		
	case 'instrucciones':
	
		$resultado .="
		<hr>
        <h1>Instrucciones :<h1>
        <h2 class='card-inside-title'>Respuesta</h2>
        <div class='row clearfix'>
            <div class='col-sm-12'>
                <div class='form-group'>
                    <div class='form-line'>
                        <textarea max='254'  id='respuesta_1' name='respuesta_1' rows='4' class='form-control no-resize' placeholder='Describe las intrucciones o comentarios'></textarea>
                    </div>
                </div>
            </div>
        </div>";
				
		break;								

	default:
		$resultado = "<hr>Sin resultados";
		break;
}

$resultado .= "<div><br><button type='button' id='boton_pregunta' class='btn bg-$body waves-effect'>Guardar Pregunta</button></div></form>
			<script type='text/javascript'>
                $('#boton_pregunta').click(function(){ 
                    var datastring = $( '#form_preguntas').serialize();
					alert(datastring);
					$('#cont_guardado').html(''); 
                    $('#load_modal').show();
                    $.ajax({
                        url: 'guarda_preguntas.php',
                        type: 'POST',
                        data: datastring,
                        cache: false,
                        success:function(html){   
                        	//alert('test2');  
                            $('#cont_guardado').html(html); 
                            $('#load_modal').hide();
                        }
                	});
                });
            </script>";

return $resultado;     	
} 


