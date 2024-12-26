<?php

$ruta="../";
$titulo ="Clinimetria";
$genera ="";

extract($_POST);

include('../functions/funciones_mysql.php'); 
include('../paciente/fun_clinimetria.php'); 


$sql_sem1 = "
SELECT
    preguntas_encuestas.pregunta_id, 
    preguntas_encuestas.encuesta_id, 
    preguntas_encuestas.numero, 
    preguntas_encuestas.pregunta, 
    preguntas_encuestas.respuesta_1 as respuestax_1, 
    preguntas_encuestas.respuesta_2 as respuestax_2, 
    preguntas_encuestas.respuesta_3 as respuestax_3, 
    preguntas_encuestas.respuesta_4 as respuestax_4, 
    preguntas_encuestas.respuesta_5 as respuestax_5, 
    preguntas_encuestas.respuesta_6 as respuestax_6, 
    preguntas_encuestas.respuesta_7 as respuestax_7, 
    preguntas_encuestas.respuesta_8 as respuestax_8, 
    preguntas_encuestas.respuesta_9 as respuestax_9, 
    preguntas_encuestas.respuesta_10 as respuestax_10, 
    preguntas_encuestas.tipo
FROM
    preguntas_encuestas
WHERE
    preguntas_encuestas.encuesta_id =$encuesta_id	
ORDER BY pregunta_id ASC
";
//echo "<hr>".$sql_sem1."<hr>";

$result_sem1 = ejecutar($sql_sem1); 
$preguntas = "";
$preguntasx = "";
$cnt=0;

//	$preguntas .= "
//		<input  name='preg_$pregunta_id' type='hidden' id='list' name='list' value='$list' required />
//		<input  name='preg_$pregunta_id' type='hidden' id='encuestas' name='encuestas' value='$encuestas' required />"; 	

while($row_sem1 = mysqli_fetch_array($result_sem1)){
extract($row_sem1);
// print_r($row_sem1);
//echo "<hr>";
$cnt++;
//echo $tipo."<hr>";
// echo 'respuesta_'.$pregunta_id.'<br>';

 // echo $respuestax_1.'<br>';
 // echo $$respuestax.'<hr>';

switch ($tipo) {
    case 'radio': 
                                     
    
        $preguntas .= "<hr>
            <h4>$numero.- $pregunta</h4><br>								
            <div class='demo-radio-button'>
                <input style='height: 0px; width: 0px' name='preg_$pregunta_id' type='text' id='preg_$pregunta_id' value='' required />  
                <input name='pregunta_$pregunta_id' type='radio' id='respuestax_1$pregunta_id' value='$respuestax_1'   />		            
                <label for='respuestax_1$pregunta_id'>$respuestax_1</label>   
                <script type='text/javascript'>
                        $('#respuestax_1$pregunta_id').click(function(){ $('#preg_$pregunta_id').val('ok'); });										
                </script>
                <input name='pregunta_$pregunta_id' type='radio' id='respuestax_2$pregunta_id' value='$respuestax_2'   />		            
                <label for='respuestax_2$pregunta_id'>$respuestax_2</label>   
                <script type='text/javascript'>
                        $('#respuestax_2$pregunta_id').click(function(){ $('#preg_$pregunta_id').val('ok'); });										
              </script>";
         if ($respuestax_3 <> "" ) {
            $preguntas .= "
                 <input name='pregunta_$pregunta_id' type='radio' id='respuestax_3$pregunta_id' value='$respuestax_3'   />		            
                <label for='respuestax_3$pregunta_id'>$respuestax_3</label>   
                <script type='text/javascript'>
                        $('#respuestax_3$pregunta_id').click(function(){ $('#preg_$pregunta_id').val('ok'); });										
                </script>";										 
         }
         if ($respuestax_4 <> "" ) {
            $preguntas .= "
                 <input name='pregunta_$pregunta_id' type='radio' id='respuestax_4$pregunta_id' value='$respuestax_4'   />		            
                <label for='respuestax_4$pregunta_id'>$respuestax_4</label>   
                <script type='text/javascript'>
                        $('#respuestax_4$pregunta_id').click(function(){ $('#preg_$pregunta_id').val('ok'); });										
                </script>";										 
         }                  
         if ($respuestax_5 <> "" ) {
            $preguntas .= "
                 <input name='pregunta_$pregunta_id' type='radio' id='respuestax_5$pregunta_id' value='$respuestax_5'   />		            
                <label for='respuestax_5$pregunta_id'>$respuestax_5</label>   
                <script type='text/javascript'>
                        $('#respuestax_5$pregunta_id').click(function(){ $('#preg_$pregunta_id').val('ok'); });										
                </script>";										 
         }
         if ($respuestax_6 <> "" ) {
            $preguntas .= "
                 <input name='pregunta_$pregunta_id' type='radio' id='respuestax_6$pregunta_id' value='$respuestax_6'   />		            
                <label for='respuestax_6$pregunta_id'>$respuestax_6</label>   
                <script type='text/javascript'>
                        $('#respuestax_6$pregunta_id').click(function(){ $('#preg_$pregunta_id').val('ok'); });										
                </script>";										 
         }				 
         if ($respuestax_7 <> "" ) {
            $preguntas .= "
                 <input name='pregunta_$pregunta_id' type='radio' id='respuestax_7$pregunta_id' value='$respuestax_7'   />		            
                <label for='respuestax_7$pregunta_id'>$respuestax_7</label>   
                <script type='text/javascript'>
                        $('#respuestax_7$pregunta_id').click(function(){ $('#preg_$pregunta_id').val('ok'); });										
                </script>";										 
         }
         if ($respuestax_8 <> "" ) {
            $preguntas .= "
                 <input name='pregunta_$pregunta_id' type='radio' id='respuestax_8$pregunta_id' value='$respuestax_8'   />		            
                <label for='respuestax_8$pregunta_id'>$respuestax_8</label>   
                <script type='text/javascript'>
                        $('#respuestax_8$pregunta_id').click(function(){ $('#preg_$pregunta_id').val('ok'); });										
                </script>";										 
         }
         if ($respuestax_9 <> "" ) {
            $preguntas .= "
                 <input name='pregunta_$pregunta_id' type='radio' id='respuestax_9$pregunta_id' value='$respuestax_9'   />		            
                <label for='respuestax_9$pregunta_id'>$respuestax_9</label>   
                <script type='text/javascript'>
                        $('#respuestax_9$pregunta_id').click(function(){ $('#preg_$pregunta_id').val('ok'); });										
                </script>";										 
         }				 
         if ($respuestax_10 <> "" ) {
            $preguntas .= "
                 <input name='pregunta_$pregunta_id' type='radio' id='respuestax_10$pregunta_id' value='$respuestax_10'   />		            
                <label for='respuestax_10$pregunta_id'>$respuestax_10</label>   
                <script type='text/javascript'>
                        $('#respuestax_10$pregunta_id').click(function(){ $('#preg_$pregunta_id').val('ok'); });										
                </script>";										 
         }				 				                     
        $preguntas .= "</div>";

        
        break;
    case 'select':
    $preguntas .= "<hr>
            <div>
                <h4>$numero.- $pregunta</h4><br>								
                <div class='form-group form-float'>
                    
                    <select id='pregunta_$pregunta_id' name='pregunta_$pregunta_id' class='form-control show-tick'>
                        <option value=''>-- Seleciona tipo de Respuesta --</option>
                        <option value='$respuestax_1'>$respuestax_1</option>
                        <option value='$respuestax_2'>$respuestax_2</option>";
                         if ($respuestax_3 <> "" ) { $preguntas .= "<option value='$respuestax_3'>$respuestax_3</option>"; }			                    
                        if ($respuestax_4 <> "" ) { $preguntas .= "<option value='$respuestax_4'>$respuestax_3</option>"; }
                        if ($respuestax_5 <> "" ) { $preguntas .= "<option value='$respuestax_5'>$respuestax_3</option>"; }
                        if ($respuestax_6 <> "" ) { $preguntas .= "<option value='$respuestax_6'>$respuestax_3</option>"; }
                        if ($respuestax_7 <> "" ) { $preguntas .= "<option value='$respuestax_7'>$respuestax_3</option>"; }
                        if ($respuestax_8 <> "" ) { $preguntas .= "<option value='$respuestax_8'>$respuestax_3</option>"; }
                        if ($respuestax_9 <> "" ) { $preguntas .= "<option value='$respuestax_9'>$respuestax_3</option>"; }
                        if ($respuestax_10 <> "" ) { $preguntas .= "<option value='$respuestax_10'>$respuestax_3</option>"; }                			                    			      
          $preguntas .= "              
                    </select> 
                </div> 
            </div>";			
        
        break;

    case 'text':
    $preguntas .= "<hr>
            <div>
                <h4>$numero.- $pregunta</h4><br>								
                <div class='form-group form-float'>
                   
                    <input class='form-control' name='pregunta_$pregunta_id' type='text' id='pregunta_$pregunta_id' placeholder='$pregunta'   value='' />
                     
                </div> 
            </div>";				
        break;
    case 'textarea':
    $preguntas .= "<hr>			
        <div class='form-group form-float'>
            <div class='form-line'>
                <textarea class='form-control' id='observaciones$pregunta_id' name='observaciones$pregunta_id' rows='3' required></textarea>
                <label class='form-label'>Observaciones</label>
            </div>
        </div>";
        break;

    case 'date':
    $preguntas .= "<hr>
            <div>
                <h4>$numero.- $pregunta</h4><br>								
                <div class='form-group form-float'>
                    <input class='form-control' name='pregunta_$pregunta_id' type='date' id='pregunta_$pregunta_id' placeholder='$pregunta'  value='' />
                     
                </div> 
            </div>";				
        break;
    case 'number':
    $preguntas .= "<hr>
            <div>
                <h4>$numero.- $pregunta</h4><br>								
                <div class='form-group form-float'>
                    <input class='form-control' name='pregunta_$pregunta_id' type='number' id='pregunta_$pregunta_id' placeholder='$pregunta'  value='' />
                     
                </div> 
            </div>";				
        break;

    case 'titulo':
        
    $preguntas .= "<hr>
            <div>
                <h1>$pregunta</h1><br>								
            </div>";				
        break;
    case 'instrucciones':
        
    $preguntas .= "<hr>
            <div>
                <h4>$pregunta</h4><br>
                <p>$respuestax_1</p><br>								
            </div>";				
        break;
                            
    default:
        
        break;
}

    // echo $pregunta;
}	
echo $preguntas."<hr><h1>Tabla de valores</h1>";

    $sql_calificacion = "
        SELECT
            calificaciones.min, 
            calificaciones.max, 
            calificaciones.valor, 
            calificaciones.color
        FROM
            calificaciones
        WHERE
        calificaciones.encuesta_id = $encuesta_id";
        //echo "<hr>".$sql_calificacion."<hr>";
        $result = ejecutar($sql_calificacion); 
        ?>
        <table style="width: 400px;" class='table table-bordered'>
            <tr>
                <th style="text-align: center;">Valor</th>
                <th style="text-align: center;">Min</th>
                <th style="text-align: center;">Max</th>
            </tr>
        <?php

        while($row = mysqli_fetch_array($result)){
            extract($row);
            echo "
            <tr>
                <td style='background-color:$color; text-align: center;'><b>$valor</b></td>
                <td style='text-align: center;'>$min</td>
                <td style='text-align: center;'>$max</td>
            </tr>";
        }

        echo "</table>";
?>                        	      
<hr>    
