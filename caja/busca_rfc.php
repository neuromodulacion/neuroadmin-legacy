<?php
// Incluye las funciones necesarias para la conexión y manipulación de la base de datos
include('../functions/funciones_mysql.php');

// Inicia la sesión del usuario
session_start();

// Establece el nivel de reporte de errores y la codificación interna
error_reporting(7);
iconv_set_encoding('internal_encoding', 'utf-8');

// Establece la cabecera de contenido y la zona horaria
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');

// Configura las configuraciones locales para fechas en español
setlocale(LC_TIME, 'es_ES.UTF-8');

// Establece una variable de tiempo en la sesión
$_SESSION['time'] = mktime();

$ruta = "../"; // Define la ruta base
extract($_SESSION); // Extrae variables de sesión

//print_r($_SESSION); // Muestra las variables de sesión (comentado)

// Inicializa la variable $rutas
$rutas = '';
extract($_POST); // Extrae las variables enviadas por POST

// Convierte el RFC a mayúsculas
$cRFC = strtoupper($cRFC);

// Consulta SQL para obtener los datos del cliente basado en el RFC proporcionado
$sql = "
SELECT
	clientes_sat.cCodigoCliente, 
	clientes_sat.cRazonSocial, 
	clientes_sat.cRFC, 
	clientes_sat.cNombreCalle, 
	clientes_sat.cNumeroExterior, 
	clientes_sat.cNumeroInterior, 
	clientes_sat.cColonia, 
	clientes_sat.cCodigoPostal, 
	clientes_sat.cCiudad, 
	clientes_sat.cEstado, 
	clientes_sat.cPais, 
	clientes_sat.aRegimen, 
	clientes_sat.email_address
FROM
	clientes_sat
WHERE
	clientes_sat.cRFC = '$cRFC'";

// Ejecuta la consulta SQL y almacena los resultados
$result = ejecutar($sql); 
$cnt = mysqli_num_rows($result); // Cuenta el número de filas devueltas
$row = mysqli_fetch_array($result); // Obtiene la primera fila del resultado
extract($row); // Extrae las variables de la fila

//print_r($row); // Muestra los datos de la fila (comentado)

?>
<hr>
<div align="left">
<form id="guarda_datos" action="genera_factura.php" method="post">
	<input type="hidden" id="ticketx" name="ticket" value="<?php echo $ticket; ?>"/>
    
    <!-- Campo para la Razón Social -->
    <label class="form-label">Razón Social</label>
    <div class="form-group form-float"> 
        <div class="form-line">
            <input type="text" id="cRazonSocial" name="cRazonSocial" class="form-control" placeholder="Razón Social"  required value="<?php echo utf8_decode($cRazonSocial); ?>">
        </div>
    </div>

    <!-- Campo para el RFC -->
    <label class="form-label">RFC</label>
    <div class="form-group form-float">
        <div class="form-line">
            <input type="text" id="cRFC" name="cRFC" class="form-control" placeholder="RFC"  required value="<?php echo ($cRFC); ?>">
        </div>
    </div>

    <!-- Selector de Régimen Fiscal -->
    <label class="form-label">Régimen</label>
    <div class="form-group form-float">
        <select class='form-control show-tick' id="aRegimen" name="aRegimen">
            <option value="">-- Selecciona la Régimen--</option>
			<?php
			// Consulta para obtener los diferentes regímenes fiscales
			$sql_table ="
				SELECT
					regimen_sat.aRegimen as aRegimenx, 
					regimen_sat.descripcion
				FROM
					regimen_sat"; 
			
			$result_sem2 = ejecutar($sql_table); 
				
			while($row_sem2 = mysqli_fetch_array($result_sem2)){
			    extract($row_sem2);		
			?>
        	<option <?php if($aRegimenx == $aRegimen){ echo "selected";} ?> value="<?php echo $aRegimenx; ?>"><?php echo $aRegimen." - ".$descripcion; ?></option>
			<?php } ?>        
        </select>                	
    </div>

    <!-- Campo para el Nombre de la Calle -->
    <label class="form-label">Nombre Calle</label>
    <div class="form-group form-float">
        <div class="form-line">
            <input type="text" id="cNombreCalle" name="cNombreCalle" class="form-control" placeholder="Nombre Calle" required value="<?php echo utf8_decode($cNombreCalle); ?>">
        </div>
    </div>

    <!-- Campo para el Número Exterior -->
    <label class="form-label">Número Exterior</label>
    <div class="form-group form-float">
        <div class="form-line">
            <input type="text" id="cNumeroExterior" name="cNumeroExterior" class="form-control" placeholder="Numero Exterior" required value="<?php echo utf8_decode($cNumeroExterior); ?>">
        </div>
    </div>

    <!-- Campo para el Número Interior -->
    <label class="form-label">Número Interior</label>
    <div class="form-group form-float">
        <div class="form-line">
            <input type="text" id="cNumeroInterior" name="cNumeroInterior" class="form-control" placeholder="Numero Interior" required value="<?php echo utf8_decode($cNumeroInterior); ?>">
        </div>
    </div>

    <!-- Campo para el Código Postal -->
    <label class="form-label">Código Postal</label>
    <div class="form-group form-float">
        <div class="form-line">
            <input maxlength="6" type="text" id="cCodigoPostal" name="cCodigoPostal" class="form-control" placeholder="Codigo Postal" required value="<?php echo ($cCodigoPostal); ?>">
        </div>
    </div>

    <!-- Scripts para manejar cambios en el campo de Código Postal -->
    <script>
        $(document).ready(function() {
            // Cuando cambia el valor del Código Postal
            $('#cCodigoPostal').change(function(){ 
                var cCodigoPostal = $(this).val();
                if(cCodigoPostal.length >= 5){
                    $('#contenido_postal').html(''); 
                    $('#load').show();
                    var datastring = 'cCodigoPostal=' + cCodigoPostal;
                    $.ajax({
                        url: '<?php echo $rutas; ?>busca_cp.php',
                        type: 'POST',
                        data: datastring,
                        cache: false,
                        success:function(html){
                            $('#contenido_postal').html(html); 
                            $('#load').hide();
                        }
                    });
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Cuando se hace clic en el campo de Código Postal
            $('#cCodigoPostal').click(function(){ 
                var cCodigoPostal = $(this).val();
                if(cCodigoPostal.length >= 5){
                    $('#contenido_postal').html(''); 
                    $('#load').show();
                    var datastring = 'cCodigoPostal=' + cCodigoPostal;
                    $.ajax({
                        url: '<?php echo $rutas; ?>busca_cp.php',
                        type: 'POST',
                        data: datastring,
                        cache: false,
                        success:function(html){
                            $('#contenido_postal').html(html); 
                            $('#load').hide();
                        }
                    });
                }
            });
        });
    </script>

    <div id="contenido_postal">
        <!-- Campos para la Colonia, Ciudad, Estado y País que se actualizarán con el resultado de la búsqueda por Código Postal -->
        <label class="form-label">Colonia</label>
        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" id="cColonia" name="cColonia" class="form-control" placeholder="Colonia" required value="<?php echo utf8_decode($cColonia); ?>">
            </div>
        </div>

        <label class="form-label">Ciudad</label>
        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" id="cCiudad" name="cCiudad" class="form-control" placeholder="Ciudad" required value="<?php echo utf8_decode($cCiudad); ?>">
            </div>
        </div>

        <label class="form-label">Estado</label>
        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" id="cEstado" name="cEstado" class="form-control" placeholder="Estado" required value="<?php echo utf8_decode($cEstado); ?>">
            </div>
        </div>

        <label class="form-label">País</label>
        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" id="cPais" name="cPais" class="form-control" placeholder="País" required value="<?php echo utf8_decode($cPais); ?>">
            </div>
        </div>
    </div>

    <!-- Campo para el correo electrónico -->
    <label for="email_address">Correo Electronico</label>
    <div class="form-group">
        <div class="form-line">
            <input type="text" id="email_address" name="email_address" class="form-control" placeholder="Ingresa el correo electronica"  required value="<?php echo ($email_address); ?>" >
        </div>
    </div>

    <!-- Botón para enviar el formulario -->
    <?php if ($accion <> "cobro") { ?>       
	<div align="center">
	    <input style="background: #0096AA; color: white" class="btn btn-lg m-l-15 waves-effect" type="submit" value="Enviar">
	</div>
    <?php } else { ?>
	<div align="center">
	    <input id="guarda_rfcx" style="background: #0096AA; color: white" class="btn btn-lg m-l-15 waves-effect" type="button" value="Guardar">
	</div>
	<script>
	    $(document).ready(function() {
	        // Maneja el clic en el botón "Guardar" para enviar los datos por AJAX
	        $('#guarda_rfcx').click(function(){ 
				var datastring = $("#guarda_datos").serialize();

				alert(datastring); // Muestra los datos que serán enviados
                $.ajax({
                    url: '../caja/guarda_rfc.php',
                    type: 'POST',
                    data: datastring,
                    cache: false,
                    success:function(html){
                        $('#contenido2').html(html); 
                    }
                });
            });
	    });
	</script>	    			
    <?php } ?>	
</form>
</div>
<hr>
