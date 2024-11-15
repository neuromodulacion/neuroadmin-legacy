<?php
include('../functions/funciones_mysql.php');
session_start();
error_reporting(7);
iconv_set_encoding('internal_encoding', 'utf-8'); 
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');
$_SESSION['time']=mktime();

$ruta = "../";
extract($_SESSION);
// print_r($_SESSION);

$ticket = mktime();	 
 
extract($_POST);
//print_r($_POST);

$sql ="
SELECT
	cobros.cobros_id, 
	cobros.usuario_id, 
	cobros.tipo, 
	cobros.doctor, 
	cobros.protocolo_ter_id, 
	cobros.f_pago, 
	cobros.importe, 
	cobros.f_captura, 
	cobros.h_captura, 
	cobros.otros, 
	cobros.empresa_id, 
	cobros.cantidad, 
	cobros.protocolo, 
	cobros.ticket, 
	cobros.facturado
FROM
	cobros
WHERE
	cobros.ticket = $ticket";
echo $sql."<br>";	
$result =ejecutar($sql); 
$cnt = mysqli_num_rows($result);
echo $cnt."<br>";
$row = mysqli_fetch_array($result);
extract($row);
print_r($row);
if ($cnt <> 0) { ?>
<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover dataTable">
		<tr>
			<th>Ticket</th>
			<th>Fecha</th>
			<th>Forma de pago</th>
			<th>Importe</th>
			<th>Facturado</th>
			<th></th>
		</tr>
		<tr>
			<td><?php echo $ticket; ?></td>
			<td><?php echo $f_captura; ?></td>
			<td><?php echo $f_pago; ?></td>
			<td>$ <?php echo number_format($importe); ?></td>
			<td><?php echo $facturado; ?></td>
			<td> 
				<?php if ($facturado == 'no') { ?>
				<button id="tx_fact" type="button" style="background: #0096AA; color: white" class="btn btn-lg m-l-15 waves-effect">FACTURAR</button>
	            <script>
					$('#tx_fact').click(function() {
						$('#b_rfc').show();
						$('#tx_fact').hide();
					});
	            </script> 				
				<?php } else { ?>
					FACTURADO
				<?php } ?>                                       
	
	        </td>
		</tr>
	</table>
</div>
<div style="display: none" id="b_rfc">
	<hr>
    <form>
        <div class="row clearfix">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" id="cRFCx" name="cRFC" class="form-control" placeholder="RFC">
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <button id="buscar_rfc" type="button" style="background: #0096AA; color: white" class="btn btn-lg m-l-15 waves-effect">BUSCAR</button>
                <script>
                    					$('#buscar_rfc').click(function(){ 
                    	//alert('Test'); 
                    	$('#contenido2').html(''); 
                        var cRFC = $('#cRFCx').val();
                        var ticket = '<?php echo $ticket; ?>
							';
							if (cRFC !==''){
							$('#load').show();
							$('#buscar_rfc').hide();

							var datastring = 'cRFC='+cRFC+'&ticket='+ticket;
							$.ajax({
							url: 'busca_rfc.php',
							type: 'POST',
							data: datastring,
							cache: false,
							success:function(html){
							//alert('Se modifico correctemente');
							$('#contenido2').html(html);
							$('#load').hide();
							$('#buscar_rfc').show();

							}
							});
							}else{
							alert('Debes ingresar el numero de RFC');
							}
							});
                </script>                                         
            </div>
        </div>
    </form>	
</div>
<?php
} else {
echo "<h1>El Ticket proporcionado no es valido</h1>";
}
