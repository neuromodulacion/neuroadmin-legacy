<?php
$ruta = '../';
include '../functions/funciones_mysql.php';

extract($_POST);

$sql_protocolo = "
	SELECT
		participantes_validacion.validacion_id, 
		participantes_validacion.id, 
		participantes_validacion.estatus, 
		participantes_validacion.observaciones, 
		participantes_validacion.fecha_registro
	FROM
		participantes_validacion
	WHERE
		participantes_validacion.id = $id							
    ";
    $result_protocolo=ejecutar($sql_protocolo); 
    $cnt= mysqli_num_rows($result_protocolo);

	if ($cnt >= 1) {		
	
?>		
<table style="width: 550px" class="table table-bordered">
	<tr>
		<th>Estatus</th>
		<th>Obserbaciones</th>
		<th>Fecha</th>
	</tr>
<?php		
    while($row_protocolo = mysqli_fetch_array($result_protocolo)){
        extract($row_protocolo); 
        $today = strftime( '%d-%b-%Y', strtotime( $fecha_registro) );
        ?>
     <tr>
     	<td><?php echo $estatus; ?></td>
     	<td><?php echo $observaciones; ?></td>
     	<td><?php echo $today; ?></td>
     </tr>   

		
<?php		
		}	
	}
?>
</table>