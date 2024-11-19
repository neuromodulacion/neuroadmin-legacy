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
extract($_SESSION);
// print_r($_SESSION);
extract($_GET);
//print_r($_POST); 
extract($_POST);
//print_r($_POST);

//$usuario_idx = 10;
$tabla = "
	<input type='hidden' id='total' name='total' value='0' />
	<button style='display: none' id='boton' type='button' class='btn btn-primary'>Primary</button>
	
	<table style='width: 500px' class='table table-bordered'>
		<tr>
			<th>Fecha</th>
			<th>Sesiones</th>

			<th>Importe</th>
			<th>Total</th>
		</tr>";
//echo "hola mundo"			<th>Tipo</th>;
$script = "
    <script>
        $('#boton').click(function() {
			//alert('test');
";

$script1 ="";

// $sql = "
	// SELECT DISTINCT
		// admin.usuario_id,
		// admin.nombre,
		// historico_sesion.f_captura,
		// historico_sesion.pago,
		// protocolo_terapia.terapia,
		// costos_productos.pago AS apagar,
		// COUNT(*) AS sesiones	 
	// FROM
		// admin
		// INNER JOIN historico_sesion ON admin.usuario_id = historico_sesion.usuario_id
		// INNER JOIN protocolo_terapia ON historico_sesion.protocolo_ter_id = protocolo_terapia.protocolo_ter_id
		// INNER JOIN costos_productos ON protocolo_terapia.terapia = costos_productos.terapia 
	// WHERE
		// admin.funcion = 'TECNICO' AND
		// admin.estatus <> 'Inactivo' AND
		// ISNULL(historico_sesion.pago) AND
		// historico_sesion.usuario_id =  $usuario_idx
	// GROUP BY 1,2,3,4,5,6";
// echo $sql;



	// SELECT
		// admin.usuario_id,
		// admin.nombre,
		// historico_sesion.f_captura,
		// historico_sesion.pago,
		// COUNT(*) AS sesiones,
		// protocolo_terapia.terapia,
		// costos_productos.pago AS importe 
	// FROM
		// admin
		// INNER JOIN historico_sesion ON admin.usuario_id = historico_sesion.usuario_id
		// INNER JOIN protocolo_terapia ON historico_sesion.protocolo_ter_id = protocolo_terapia.protocolo_ter_id
		// INNER JOIN costos_productos ON protocolo_terapia.terapia = costos_productos.terapia 
	// WHERE
		// admin.funcion = 'TECNICO' 
		// AND admin.estatus <> 'Inactivo' 
		// AND ISNULL( historico_sesion.pago ) 
		// AND historico_sesion.usuario_id = $usuario_idx 
	// GROUP BY	1,2,3,4


$sql = "
SELECT
	historico_sesion.f_captura,
	COUNT(*) as sesiones,
	( SELECT DISTINCT costos_productos.pago FROM costos_productos WHERE costos_productos.terapia = protocolo_terapia.terapia ) AS importe 
FROM
	historico_sesion
	INNER JOIN protocolo_terapia ON historico_sesion.protocolo_ter_id = protocolo_terapia.protocolo_ter_id 
WHERE
	ISNULL( historico_sesion.pago ) 
	AND historico_sesion.usuario_id = $usuario_idx  
GROUP BY 1
";
//echo $sql;

$result = ejecutar($sql); 
     $cnt = 1;
while($row = mysqli_fetch_array($result)){ 
	extract($row);
	$f_captura1 = strftime("%e-%b-%Y<br>%A",strtotime($f_captura));
	$dia1 = strftime("%e-%b-%Y",strtotime($f_captura));
	$total= ($sesiones*$importe);
				//<td>".$terapia."</td>
	$tabla .= "
		<tr>
			<td>$f_captura1</td>
			<td>
			    <div class='checkbox'>
					<label>
						<input type='hidden' id='sesiones_val$cnt' name='sesiones_val$cnt' value='$sesiones' />
						<input type='hidden' id='importe_val$cnt' name='importe_val$cnt' value='$total' />
	                    <input type='checkbox' id='sesiones$cnt' name='sesiones[]' value='$f_captura' class='filled-in chk-col-<?php echo $body; ?>' />
	                    <label for='sesiones$cnt'>  $sesiones</label>
	                        <script>
	                            $('#sesiones$cnt').change(function(){
	                            		
									$('#boton').click(); 
									//alert('test');                         	
	                            });
	                        </script>                    
			      	</label>
			    </div>			
			</td>

			<td> $ ".number_format($importe)."</td>
			<td> $ ".number_format($total)."</td>
		</tr>";
	
		$script .= "
				if ($('#sesiones$cnt').is(':checked')) {
					var val_$cnt = parseInt($('#sesiones_val$cnt').val());
					var tot_$cnt = parseInt($('#importe_val$cnt').val());
			    } else {
			      	var val_$cnt = parseInt(0);
					var tot_$cnt = parseInt(0);
			    }  
				";
					
		$cnt ++;					
	}

	//$cnt ++;

	$tabla .= "</table>
	<h1>Total de Sesiones a pagar   <p id='total_sesiones'>0</p></h1>";

	$script .="
	 	var total = (val_1";
	 	
	//echo $cnt."<hr>";
		for ($i=2; $i < $cnt ; $i++) { 
		
			$script .= "+val_$i";
			//echo " + val_$i";
		}	
	$script .=");";
	
		$script .="
	 	var total_importe = (tot_1";
	 	
	//echo $cnt."<hr>";
		for ($i=2; $i < $cnt ; $i++) { 
		
			$script .= "+tot_$i";
			//echo " + val_$i";
		}	
	$script .=");
	
	
		$('#total').val(total);
		$('#total_sesiones').html(total);
		var costos = $('#costos').val();
		var gran_total = (total_importe);

		$('#importe').val(gran_total);";
		
	$script .= "	
        });
    </script> 
	
	";

	echo $tabla.$script;
	
	//echo "hola mundo";