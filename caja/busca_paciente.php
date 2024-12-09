<?php
// Incluye el archivo con funciones generales de MySQL
include('../functions/funciones_mysql.php');

// Inicia la sesión del usuario
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


// Define la ruta base para las inclusiones de archivos
$ruta = "../";

// Extrae las variables de la sesión y las convierte en variables locales
extract($_SESSION);

// Genera un ticket basado en la marca de tiempo actual
$ticket = time();	 

// Extrae las variables enviadas por POST y las convierte en variables locales
extract($_POST);

// Función para reemplazar caracteres acentuados por el símbolo '%'
function acentos($acentos){
	$reemplazos = array(
	    'Á' => '%', 'É' => '%', 'Í' => '%', 'Ó' => '%', 'Ú' => '%',
	    'á' => '%', 'é' => '%', 'í' => '%', 'ó' => '%', 'ú' => '%',
	    'À' => '%', 'È' => '%', 'Ì' => '%', 'Ò' => '%', 'Ù' => '%',
	    'à' => '%', 'è' => '%', 'ì' => '%', 'ò' => '%', 'ù' => '%',
	    'A' => '%', 'E' => '%', 'I' => '%', 'O' => '%', 'U' => '%',
	    'a' => '%', 'e' => '%', 'i' => '%', 'o' => '%', 'u' => '%'
	);
	$texto_sin_acentos = strtr($acentos, $reemplazos);
	return $texto_sin_acentos;  
}

function validarSinEspacios($cadena) {
	$cadena = trim($cadena);
	$cadena = str_replace(' ', '', $cadena);
    return $cadena;
}

// Condiciones de búsqueda según los parámetros recibidos en POST
$conteo = 0;

if ($paciente) {
	// Condición para buscar por nombre del paciente
	$pacientesql = "AND UPPER(pacientes.paciente) LIKE UPPER('%" . strtoupper(acentos($paciente)) . "%')";
	$pacientesql1 = "AND UPPER(paciente_consultorio.paciente) LIKE UPPER('%" . strtoupper(acentos($paciente)) . "%')";
	$conteo++;
} else {
	$pacientesql = "";
	$pacientesql1 = "";
}

if ($apaterno) {
	// Condición para buscar por apellido paterno
	if ($conteo >= 1) {
		$apaternosql = "OR UPPER(pacientes.apaterno) LIKE UPPER('%" . strtoupper(acentos($apaterno)) . "%')";
		$apaternosql1 = "OR UPPER(paciente_consultorio.apaterno) LIKE UPPER('%" . strtoupper(acentos($apaterno)) . "%')";
	} else {
		$apaternosql = "AND UPPER(pacientes.apaterno) LIKE UPPER('%" . strtoupper(acentos($apaterno)) . "%')";
		$apaternosql1 = "AND UPPER(paciente_consultorio.apaterno) LIKE UPPER('%" . strtoupper(acentos($apaterno)) . "%')";
	}
	$conteo++;
} else {
	$apaternosql = "";
	$apaternosql1 = "";
}

if ($amaterno) {
	// Condición para buscar por apellido materno
	if ($conteo >= 1) {
		$amaternosql = "OR UPPER(pacientes.amaterno) LIKE UPPER('%" . strtoupper(acentos($amaterno)) . "%')";
		$amaternosql1 = "OR UPPER(paciente_consultorio.amaterno) LIKE UPPER('%" . strtoupper(acentos($amaterno)) . "%')";
	} else {
		$amaternosql = "AND UPPER(pacientes.amaterno) LIKE UPPER('%" . strtoupper(acentos($amaterno)) . "%')";
		$amaternosql1 = "AND UPPER(paciente_consultorio.amaterno) LIKE UPPER('%" . strtoupper(acentos($amaterno)) . "%')";
	}
	$conteo++;
} else {
	$amaternosql = "";
	$amaternosql1 = "";
}

if ($email) {
	// Condición para buscar por correo electrónico
	if ($conteo >= 1) {
		$emailsql = "OR LOWER(pacientes.email) LIKE '%" . strtolower($email) . "%'";
		$emailsql1 = "OR LOWER(paciente_consultorio.email) LIKE '%" . strtolower($email) . "%'";
	} else {
		$emailsql = "AND LOWER(pacientes.email) LIKE '%" . strtolower($email) . "%'";
		$emailsql1 = "AND LOWER(paciente_consultorio.email) LIKE '%" . strtolower($email) . "%'";
	}
	$conteo++;
} else {
	$emailsql = "";
	$emailsql1 = "";
}

if ($celular) {
	// Condición para buscar por número de celular
	if ($conteo >= 1) {
		$celularsql = "OR REPLACE(pacientes.celular, ' ', '') LIKE '%" . validarSinEspacios($celular). "%'";
		$celularsql1 = "OR REPLACE(paciente_consultorio.celular, ' ', '') LIKE '%" . validarSinEspacios($celular). "%'";
	} else {
		$celularsql = "AND REPLACE(pacientes.celular, ' ', '') LIKE '%" . validarSinEspacios($celular) . "%'";
		$celularsql1 = "AND REPLACE(paciente_consultorio.celular, ' ', '') LIKE '%" . validarSinEspacios($celular). "%'";
	}
	$conteo++;
} else {
	$celularsql = "";
	$celularsql1 = "";
}
?>

<!-- Tabla para mostrar los resultados de búsqueda -->
<table style="width: 100%" class="table table-bordered table-responsive">
	<tr>
		<th style="text-align: center">Nombre</th>
		<th style="width: 100px;text-align: center">Apellido Paterno</th>
		<th style="width: 100px;text-align: center">Apellido Materno</th>
		<th style="text-align: center">Celular</th>
		<th style="text-align: center">Correo Electronico</th>
		<th style="text-align: center">Doctor</th>
		<th style="width: 240px;text-align: center">Selecciona</th>
	</tr>
	<?php
	// Si el tipo de consulta es 'Consulta Medica'
	if ($tipo_c == 'Consulta Medica') {	
		// Consulta SQL para obtener los pacientes que coinciden con los criterios de búsqueda
		$sql1 ="
			SELECT DISTINCT
				paciente_consultorio.paciente_cons_id, 
				paciente_consultorio.paciente_id,
				paciente_consultorio.paciente, 
				paciente_consultorio.apaterno, 
				paciente_consultorio.amaterno, 
				REPLACE(paciente_consultorio.celular, ' ', '') AS celular,
				paciente_consultorio.email,
				paciente_consultorio.medico,
				paciente_consultorio.id_bind
			FROM
				paciente_consultorio
			WHERE
				paciente_consultorio.empresa_id = $empresa_id 
				$pacientesql1  
				$apaternosql1 
				$amaternosql1  
				$emailsql1 
				$celularsql1
			ORDER BY 3 ASC, 4 ASC, 5 ASC";
		// echo $sql1."<hr>";		
		$result1 = ejecutar($sql1); 
		$cnt1 = mysqli_num_rows($result1);
		// Itera sobre los resultados obtenidos y los muestra en la tabla
		while($row1 = mysqli_fetch_array($result1)){ 
		    extract($row1);	
			?>
		<tr style="background-color: #F2F2F2" id="tr_<?php echo $paciente_cons_id ; ?>">
			<!-- Muestra los detalles del paciente -->
			<td>
				<div class="form-line">
		            <input type="text" id="paciente_<?php echo $paciente_cons_id ; ?>" name="paciente" class="form-control" value="<?php echo $paciente ; ?>" disabled>
		        </div>
	        </td>
			<td>
				<div class="form-line">
		            <input type="text" id="apaterno_<?php echo $paciente_cons_id ; ?>" name="apaterno" class="form-control" value="<?php echo $apaterno ; ?>" disabled>
		        </div>			
			</td>
			<td>
				<div class="form-line">
		            <input type="text" id="amaterno_<?php echo $paciente_cons_id ; ?>" name="amaterno" class="form-control" value="<?php echo $amaterno ; ?>" disabled>
		        </div>				
			</td>
			<td>
				<div class="form-line">
		            <input type="text" id="celular_<?php echo $paciente_cons_id ; ?>" name="celular" class="form-control" value="<?php echo $celular ; ?>" disabled>
		        </div>				
			</td>
			<td>
				<div class="form-line">
		            <input type="text" id="email_<?php echo $paciente_cons_id ; ?>" name="email" class="form-control" value="<?php echo $email ; ?>" disabled>
		        </div>				
			</td>
			<td>
				<div class="form-line">
		            <input type="text" id="doctor_<?php echo $paciente_cons_id ; ?>" name="medico" class="form-control" value="<?php echo $doctor ; ?>" disabled>
		        </div>				
			</td>			
			<td>
				<!-- Botón para seleccionar el paciente -->
				<button type="button" id="selecciona_<?php echo $paciente_cons_id ; ?>_consul" class="btn bg-green waves-effect" data-toggle="modal" data-target="#Modal_busca">
					<i class="material-icons">check_circle</i> Selecciona
				</button>	
				<script>
					$('#selecciona_<?php echo $paciente_cons_id ; ?>_consul').click(function() {
						// Al hacer clic, se llenan los campos del formulario con los datos del paciente seleccionado
						var paciente_id = "<?php echo $paciente_id ; ?>";
						var paciente = $('#paciente_<?php echo $paciente_cons_id ; ?>').val();
						var apaterno = $('#apaterno_<?php echo $paciente_cons_id ; ?>').val();
						var amaterno = $('#amaterno_<?php echo $paciente_cons_id ; ?>').val();
						var celular = $('#celular_<?php echo $paciente_cons_id ; ?>').val();
						var email = $('#email_<?php echo $paciente_cons_id ; ?>').val();
						var paciente_cons_id = "<?php echo $paciente_cons_id ; ?>";
						
						$('#paciente_consulta').val(paciente+' '+apaterno+' '+amaterno);
						$('#paciente_consultax').val(paciente+' '+apaterno+' '+amaterno);
						
						$('#mail').val(email);
						$('#email').val(email);
						$('#paciente_cons_id').val(paciente_cons_id);
						$('#paciente_id').val(paciente_id);
						$( "#info_cliente" ).show();
						$( "#info_busca" ).hide();
						$('#paciente_c').val(paciente);
						$('#apaterno').val(apaterno);
						$('#amaterno').val(amaterno);
						$('#celular').val(celular);
						$('#mail').val(email);							
					});
				</script>		
				<!-- Botón para editar los detalles del paciente -->
				<button type="button" id="edit_<?php echo $paciente_cons_id ; ?>_consul" class="btn bg-blue waves-effect" data-target="#editModal">
					<i class="material-icons">mode_edit</i> Edita
				</button>
				<script>
					$('#edit_<?php echo $paciente_cons_id ; ?>_consul').click(function() {
						// Habilita los campos para edición
						$( "#paciente_<?php echo $paciente_cons_id ; ?>" ).prop( "disabled", false );
						$( "#apaterno_<?php echo $paciente_cons_id ; ?>" ).prop( "disabled", false );
						$( "#amaterno_<?php echo $paciente_cons_id ; ?>" ).prop( "disabled", false );
						$( "#email_<?php echo $paciente_cons_id ; ?>" ).prop( "disabled", false );
						$( "#celular_<?php echo $paciente_cons_id ; ?>" ).prop( "disabled", false );	
						$( "#edit_<?php echo $paciente_cons_id ; ?>_consul" ).hide();
						$( "#guarda_<?php echo $paciente_cons_id ; ?>_consul" ).show();
					});
				</script>
				<!-- Botón para guardar los cambios después de la edición -->
				<button style="display: none" type="button" id="guarda_<?php echo $paciente_cons_id ; ?>_consul" class="btn bg-light-green waves-effect" data-target="#editModal">
					<i class="material-icons">save</i> Guarda
				</button>	
				<script>
					$('#guarda_<?php echo $paciente_cons_id ; ?>_consul').click(function() {
						// Deshabilita los campos nuevamente y guarda los cambios en la base de datos
						$( "#paciente_<?php echo $paciente_cons_id ; ?>" ).prop( "disabled", true );
						$( "#apaterno_<?php echo $paciente_cons_id ; ?>" ).prop( "disabled", true );
						$( "#amaterno_<?php echo $paciente_cons_id ; ?>" ).prop( "disabled", true );
						$( "#email_<?php echo $paciente_cons_id ; ?>" ).prop( "disabled", true );
						$( "#celular_<?php echo $paciente_cons_id ; ?>" ).prop( "disabled", true );	
						$( "#edit_<?php echo $paciente_cons_id ; ?>_consul" ).show();
						$( "#guarda_<?php echo $paciente_cons_id ; ?>_consul" ).hide();
						

						var paciente_cons_id = '<?php echo $paciente_cons_id ; ?>';
						var paciente = $( "#paciente_<?php echo $paciente_cons_id ; ?>" ).val();
						var apaterno = $( "#apaterno_<?php echo $paciente_cons_id ; ?>" ).val();
						var amaterno =$( "#amaterno_<?php echo $paciente_cons_id ; ?>" ).val();
						var email = $( "#email_<?php echo $paciente_cons_id ; ?>" ).val();
						var celular = $( "#celular_<?php echo $paciente_cons_id ; ?>" ).val();	
						var tipo_mod = 'paciente_cons_id';
						// Envía los datos editados a través de una solicitud AJAX
						var datastring = 'paciente=' + paciente + '&paciente_cons_id=' + paciente_cons_id + '&apaterno=' + apaterno + '&amaterno=' + amaterno + '&celular=' + celular + '&email=' + email + '&tipo_mod=' + tipo_mod;
						$.ajax({
							url : 'modifica_paciente.php',
							type : 'POST',
							data : datastring,
							cache : false,
							success : function(html) {								
								$('#tr_<?php echo $paciente_cons_id; ?>').css("background-color", "#eee");

							}
						});						
					});
				</script>													
			</td>
		</tr>

	<?php } 
	}

if ($tipo_c == 'Consulta Medica') {
	$filtro = 'AND pacientes.paciente_id NOT IN ( 
	SELECT DISTINCT paciente_consultorio.paciente_id FROM paciente_consultorio WHERE paciente_consultorio.paciente_id IS NOT NULL )';
} else {
	$filtro = '';
}
	
// Consulta SQL para obtener pacientes que no están en paciente_consultorio (si el filtro aplica)
$sqlx ="
	SELECT DISTINCT
		pacientes.paciente_id,
		pacientes.paciente,
		pacientes.apaterno,
		pacientes.amaterno,
		pacientes.email,
		REPLACE(pacientes.celular, ' ', '') AS celular,
		pacientes.empresa_id 
	FROM
		pacientes 
	WHERE
		pacientes.empresa_id = 1 
		$filtro
		$pacientesql  
		$apaternosql 
		$amaternosql  
		$emailsql 
		$celularsql
	ORDER BY 3 ASC, 4 ASC, 5 ASC";
// echo $sqlx;		
$resultx = ejecutar($sqlx); 
$cnt = mysqli_num_rows($resultx);

// Itera sobre los resultados obtenidos y los muestra en la tabla
while($row = mysqli_fetch_array($resultx)){ 
    extract($row);	
	?>
	<tr style="background-color: #F2F2F2" id="tr_<?php echo $paciente_id ; ?>">
		<td><?php echo $paciente ; ?></td>
		<td><?php echo $apaterno ; ?></td>
		<td><?php echo $amaterno ; ?></td>
		<td>
	        <div class="form-line">
	            <input type="text" id="celular_<?php echo $paciente_id ; ?>" name="celular" class="form-control" placeholder="Correo" value="<?php echo $celular ; ?>" disabled>
	        </div>			
		</td>
		<td>	
	        <div class="form-line">
	            <input type="email" id="mail_<?php echo $paciente_id ; ?>" name="email" class="form-control" placeholder="Correo" value="<?php echo $email ; ?>" disabled>
	        </div>
		</td>
		<td class="info">
			<!-- Botón para seleccionar el paciente -->
			<button type="button" id="selecciona_<?php echo $paciente_id ; ?>" class="btn bg-green waves-effect" data-toggle="modal" data-target="#Modal_busca">
				<i class="material-icons">check_circle</i> Selecciona
			</button>
<script>
    $(document).ready(function() {
        $('#selecciona_<?php echo $paciente_id; ?>').click(function() {
            // Al hacer clic, se llenan los campos del formulario con los datos del paciente seleccionado
            var medico = "<?php echo $medico; ?>";
            var paciente_id = "<?php echo $paciente_id; ?>";
            var paciente = "<?php echo $paciente; ?>";
            var apaterno = "<?php echo $apaterno; ?>";
            var amaterno = "<?php echo $amaterno; ?>";

            // Corregir los selectores jQuery para obtener el valor de los campos de texto
            var celular = $('#celular_<?php echo $paciente_id; ?>').val(); 
            var email = $('#mail_<?php echo $paciente_id; ?>').val(); 
            var tipo_c = $('#tipo_c').val();

            // Actualizar los campos del formulario
            $('#paciente_consulta').val(paciente + ' ' + apaterno + ' ' + amaterno);
            $('#paciente_consultax').val(paciente + ' ' + apaterno + ' ' + amaterno);                
            $('#email').val(email);
            $("#info_cliente").show();
            $("#info_busca").hide();        
            
            $('#paciente_id').val(paciente_id);
            $('#paciente_c').val(paciente);
            $('#apaterno').val(apaterno);
            $('#amaterno').val(amaterno);
            $('#celular').val(celular);
            $('#mail').val(email);            

            // Preparar la cadena de datos para enviar por AJAX
            var datastring = 'paciente=' + paciente + '&paciente_id=' + paciente_id + '&apaterno=' + apaterno + '&amaterno=' + amaterno + '&celular=' + celular + '&email=' + email + '&tipo_c=' + tipo_c + '&medico=' + medico;

            // Si es una consulta médica, se envía la información a través de AJAX
            if(tipo_c === 'Consulta Medica'){
                $.ajax({
                    url: 'agrega_paciente.php',
                    type: 'POST',
                    data: datastring,
                    cache: false,
                    success: function(html) {
                        console.log('Respuesta del servidor:', html); // Esto es útil para depuración
                        $('#paciente_cons_id').val(html);
                    }
                });                        
            }
        });
    });
</script>
			
	
			<!-- Botón para editar los detalles del paciente -->
			<button type="button" id="edit_<?php echo $paciente_id ; ?>_consul" class="btn bg-blue waves-effect" >
				<i class="material-icons">mode_edit</i> Edita
			</button>
			<script>
				$('#edit_<?php echo $paciente_id ; ?>_consul').click(function() {
					// Habilita los campos para edición
					$( "#mail_<?php echo $paciente_id ; ?>" ).prop( "disabled", false );
					$( "#celular_<?php echo $paciente_id ; ?>" ).prop( "disabled", false );	
					$( "#edit_<?php echo $paciente_id ; ?>_consul" ).hide();
					$( "#guarda_<?php echo $paciente_id ; ?>_consul" ).show();
				});
			</script>
			<!-- Botón para guardar los cambios después de la edición -->
			<button style="display: none" type="button" id="guarda_<?php echo $paciente_id ; ?>_consul" class="btn bg-light-green waves-effect">
				<i class="material-icons">save</i> Guarda
			</button>	
			<script>
				$('#guarda_<?php echo $paciente_id ; ?>_consul').click(function() {
					alert('test');
					// Deshabilita los campos nuevamente y guarda los cambios en la base de datos
					$( "#mail_<?php echo $paciente_id ; ?>" ).prop( "disabled", true );
					$( "#celular_<?php echo $paciente_id ; ?>" ).prop( "disabled", true );	
					$( "#edit_<?php echo $paciente_id ; ?>_consul" ).show();
					$( "#guarda_<?php echo $paciente_id ; ?>_consul" ).hide();
					$('#tr_<?php echo $paciente_id; ?>').css("background-color", "#eee");

					var paciente_cons_id = '<?php echo $paciente_cons_id ; ?>';
					var email = $( "#email_<?php echo $paciente_cons_id ; ?>" ).val();
					var celular = $( "#celular_<?php echo $paciente_cons_id ; ?>" ).val();	
					var tipo_mod = 'paciente_id';
					// Envía los datos editados a través de una solicitud AJAX
					var datastring = 'paciente_id=' + paciente_id + '&celular=' + celular + '&email=' + email + '&tipo_mod=' + tipo_mod;
					$.ajax({
						url : 'modifica_paciente.php',
						type : 'POST',
						data : datastring,
						cache : false,
						success : function(html) {
							alert(html);
							$('#tr_<?php echo $paciente_cons_id; ?>').css("background-color", "#eee");

						}
					});											
				});
			</script>										
		</td>
	</tr>

	<?php } ?>
<tr id="contenido_tabla_nuevo">
	<td align="center" colspan="6">
		<?php if ($tipo_c == 'Consulta Medica') { ?>				
		<h1>No hay más registros</h1>
		<!-- Botón para agregar un nuevo paciente -->
		<button class="btn bg-cyan waves-effect m-b-15" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false"
		aria-controls="collapseExample">
			<i class="material-icons">person_add</i> AGREGA UN PACIENTE NUEVO
		</button>
		<?php } ?>
		<!-- Formulario colapsable para agregar un nuevo paciente -->
		<div class="collapse" id="collapseExample">
			<div class="well">
				<h2><b>Paciente</b></h2>
				<div class="row">
					<!-- Campos del formulario para el nuevo paciente -->
					<div align="left" class="col-md-12">
						<label for="nombre_search">Nombre</label>
						<div class="form-group">
							<div class="form-line">
								<input type="text" id="paciente_c2" name="paciente" class="form-control">
							</div>
						</div>
					</div>
					<div align="left" class="col-md-12">
						<label for="apaterno_search">Apellido Paterno</label>
						<div class="form-group">
							<div class="form-line">
								<input type="text" id="apaterno2" name="apaterno" class="form-control">
							</div>
						</div>
					</div>
					<div align="left" class="col-md-12">
						<label for="amaterno_search">Apellido Materno</label>
						<div class="form-group">
							<div class="form-line">
								<input type="text" id="amaterno2" name="amaterno" class="form-control">
							</div>
						</div>
					</div>
					<div align="left" class="col-md-12">
						<label for="email_search">Teléfono</label>
						<div class="form-group">
							<div class="form-line">
								<input type="text" id="celular2" name="celular" class="form-control">
							</div>
						</div>
					</div>
					<div align="left" class="col-md-12">
						<label for="email_search">Correo</label>
						<div class="form-group">
							<div class="form-line">
								<input type="email" id="mail2" name="email" class="form-control">
							</div>
						</div>
					</div>
					<!-- Campo oculto para el médico -->
					<input type="hidden" id="medico2" name="medico" value="<?php echo $doctor; ?>" />
					<div align="right" class="col-md-12">
						<!-- Botón para guardar el nuevo paciente -->
						<button type="button" id="buscar_paciente2" class="btn bg-purple waves-effect">
							<i class="material-icons">search</i>GUARDA PACIENTE
						</button>
						<script>
							$('#buscar_paciente2').click(function() {
								// Al hacer clic, se guarda el nuevo paciente en la base de datos
								$("#buscar_paciente2").hide();
								var paciente_id = "0";
								var paciente = $('#paciente_c2').val();
								var apaterno = $('#apaterno2').val();
								var amaterno = $('#amaterno2').val();
								var celular = $('#celular2').val();
								var email = $('#mail2').val();
								var medico = $('#medico2').val();
								var datastring = 'paciente=' + paciente + '&paciente_id=' + paciente_id + '&apaterno=' + apaterno + '&amaterno=' + amaterno + '&celular=' + celular + '&email=' + email + '&medico=' + medico;
								$.ajax({
									url : 'agrega_paciente.php',
									type : 'POST',
									data : datastring,
									cache : false,
									success : function(html) {
										$('#contenido_tabla_nuevo').html('');
										$('#contenido_tabla_nuevo').html(html);
									}
								});
							});
						</script>
					</div>
				</div>
			</div>
		</div>
	</td>
</tr>	
</table>
