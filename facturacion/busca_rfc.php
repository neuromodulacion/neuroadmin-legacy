<?php
include('../functions/funciones_mysql.php');
include('../functions/functions.php');
session_start();
error_reporting(7);
iconv_set_encoding('internal_encoding', 'utf-8'); 
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');
$_SESSION['time']=time();

$ruta = "../";
extract($_SESSION);
// print_r($_SESSION);

//$ticket = time();	 
 $rutas = '';
extract($_POST);
//print_r($_POST);

$cRFC = strtoupper($cRFC);

$sql ="
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

//echo $sql."<hr>";	
$result =ejecutar($sql); 
$cnt = mysqli_num_rows($result);
$row = mysqli_fetch_array($result);
 extract($row);
//print_r($row);

//if ($cnt <> 0) { $disabled = "disabled";} else {$disabled = "";}


?>
<hr>
<div align="left">
<form id="guarda_datos" action="genera_factura.php" method="post">
	<input type="hidden" id="ticketx" name="ticket" value="<?php echo $ticket; ?>"/>
    <label class="form-label">Razón Social</label>
    <div class="form-group form-float"> 
        <div class="form-line">
            <input type="text" id="cRazonSocial" name="cRazonSocial" class="form-control" placeholder="Razón Social"  required value="<?php echo codificacionUTF($cRazonSocial); ?>">
        </div>
    </div>

    <label class="form-label">RFC</label>
    <div class="form-group form-float">
        <div class="form-line">
            <input type="text" id="cRFC" name="cRFC" class="form-control" placeholder="RFC"  required value="<?php echo ($cRFC); ?>">
        </div>
    </div>

    <label class="form-label">Régimen</label>

    <div class="form-group form-float">
        <select class='form-control show-tick' id="aRegimen" name="aRegimen" >
            <option value="">-- Selecciona la Régimen--</option>
			<?php
			$sql_table ="
				SELECT
					regimen_sat.aRegimen as aRegimenx, 
					regimen_sat.descripcion
				FROM
					regimen_sat"; 
			
			//echo $sql_table."<hr>";	   
			           
			$result_sem2=ejecutar($sql_table); 
				
			while($row_sem2 = mysqli_fetch_array($result_sem2)){
			    extract($row_sem2);		
			?>
        	<option <?php if($aRegimenx == $aRegimen){ echo "selected";} ?> value="<?php echo $aRegimenx; ?>"><?php echo $aRegimen." - ".$descripcion; ?></option>
			<?php } ?>        
        
        </select>                	
    </div>


    <label class="form-label">Nombre Calle</label>
    <div class="form-group form-float">
        <div class="form-line">
            <input type="text" id="cNombreCalle" name="cNombreCalle" class="form-control" placeholder="Nombre Calle"  required value="<?php echo codificacionUTF($cNombreCalle); ?>">
        </div>
    </div>

    <label class="form-label">Número Exterior</label>
    <div class="form-group form-float">
        <div class="form-line">
            <input type="text" id="cNumeroExterior" name="cNumeroExterior" class="form-control" placeholder="Numero Exterior"  required value="<?php echo codificacionUTF($cNumeroExterior); ?>">
        </div>
    </div>

    <label class="form-label">Número Interior</label>
    <div class="form-group form-float">
        <div class="form-line">
            <input type="text" id="cNumeroInterior" name="cNumeroInterior" class="form-control" placeholder="Numero Interior"  required value="<?php echo codificacionUTF($cNumeroInterior); ?>">
        </div>
    </div>


<label class="form-label">Código Postal</label>
<div class="form-group form-float">
    <div class="form-line">
        <input maxlength="6" type="text" id="cCodigoPostal" name="cCodigoPostal" class="form-control" placeholder="Codigo Postal" required value="<?php echo ($cCodigoPostal); ?>">
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#cCodigoPostal').change(function(){ 
            //alert('Test'); 
            
            var cCodigoPostal = $(this).val();
            if(cCodigoPostal.length >= 5){
                $('#contenido_postal').html(''); 
                $('#load').show();
                // $('#buscar_rfc').hide();

                var datastring = 'cCodigoPostal=' + cCodigoPostal;
                $.ajax({
                    url: '<?php echo $rutas; ?>busca_cp.php',
                    type: 'POST',
                    data: datastring,
                    cache: false,
                    success:function(html){
                        //alert('Se modifico correctamente');       
                        $('#contenido_postal').html(html); 
                        $('#buscar_rfc').show(); // Asegúrate de que este elemento exista

                        $('#load').hide();
                    }
                });
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#cCodigoPostal').click(function(){ 
            //alert('Test'); 
            
            var cCodigoPostal = $(this).val();
            if(cCodigoPostal.length >= 5){
                $('#contenido_postal').html(''); 
                $('#load').show();
                // $('#buscar_rfc').hide();

                var datastring = 'cCodigoPostal=' + cCodigoPostal;
                $.ajax({
                    url: '<?php echo $rutas; ?>busca_cp.php',
                    type: 'POST',
                    data: datastring,
                    cache: false,
                    success:function(html){
                        //alert('Se modifico correctamente');       
                        $('#contenido_postal').html(html); 
                        $('#buscar_rfc').show(); // Asegúrate de que este elemento exista

                        $('#load').hide();
                    }
                });
            }
        });
    });
</script>


<div id="contenido_postal">

    <label class="form-label">Colonia</label>
    <div class="form-group form-float">
        <div class="form-line">
            <input type="text" id="cColonia" name="cColonia" class="form-control" placeholder="Colonia"  required value="<?php echo codificacionUTF($cColonia); ?>">
        </div>
    </div>

    <label class="form-label">Ciudad</label>
    <div class="form-group form-float">
        <div class="form-line">
            <input type="text" id="cCiudad" name="cCiudad" class="form-control" placeholder="Ciudad"  required value="<?php echo codificacionUTF($cCiudad); ?>">
        </div>
    </div>

    <label class="form-label">Estado</label>
    <div class="form-group form-float">
        <div class="form-line">
            <input type="text" id="cEstado" name="cEstado" class="form-control" placeholder="Estado"  required value="<?php echo codificacionUTF($cEstado); ?>">
        </div>
    </div>

    <label class="form-label">País</label>
    <div class="form-group form-float">
        <div class="form-line">
            <input type="text" id="cPais" name="cPais" class="form-control" placeholder="País" required value="<?php echo codificacionUTF($cPais); ?>">
        </div>
    </div>
</div>
    <label for="email_address">Correo Electronico</label>
    <div class="form-group">
        <div class="form-line">
            <input type="text" id="email_address" name="email_address" class="form-control" placeholder="Ingresa el correo electronica"  required value="<?php echo ($email_address); ?>" >
        </div>
    </div>
    <?php if ($accion <> "cobro") { ?>       
	<div align="center">
	    <input style="background: #0096AA; color: white" class="btn btn-lg m-l-15 waves-effect" type="submit" value="Enviar">
	</div>
    <?php }else{ ?>
	<div align="center">
	    <input id="guarda_rfcx" style="background: #0096AA; color: white" class="btn btn-lg m-l-15 waves-effect" type="button" value="Guardar">
	</div>
	<script>
	    $(document).ready(function() {
	        $('#guarda_rfcx').click(function(){ 
				var datastring = $("#guarda_datos").serialize();

				//alert(datastring);
                $.ajax({
                    url: '../caja/guarda_rfc.php',
                    type: 'POST',
                    data: datastring,
                    cache: false,
                    success:function(html){
                        //alert('Se modifico correctamente');       
                        $('#contenido2').html(html); 
                        //$('#buscar_rfc').show(); // Asegúrate de que este elemento exista
                        //$('#load').hide();
                    }
                });
            });
	    });
	</script>	    			
    <?php } ?>	
</form>
</div>
<hr>