<?php
include('../functions/funciones_mysql.php');
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

$ticket = time();	 
 
extract($_POST);
//print_r($_POST);

$sqlx ="
SELECT
	CPdescarga.d_codigo,
	CPdescarga.D_mnpio,
	CPdescarga.d_estado as cEstado,
	CPdescarga.d_ciudad as cCiudad 
FROM
	CPdescarga 
WHERE
	CPdescarga.d_codigo = '$cCodigoPostal'";
	
$resultx =ejecutar($sqlx); 
$row = mysqli_fetch_array($resultx);
extract($row);
?>


    <label class="form-label">Colonia</label>

    <div class="form-group form-float">
        <select class='form-control show-tick' id="cColonia" name="cColonia" >
            <option value="">-- Selecciona la Colonia--</option>
			<?php
			$sql_table ="
			SELECT
				CPdescarga.d_asenta 
			FROM
				CPdescarga 
			WHERE
				CPdescarga.d_codigo = '$cCodigoPostal'	"; 
			
			//echo $sql_table."<hr>";	   
			           
			$result_sem2=ejecutar($sql_table); 
				
			while($row_sem2 = mysqli_fetch_array($result_sem2)){
			    extract($row_sem2);		
			?>
        	<option value="<?php echo $d_asenta; ?>"><?php echo $d_asenta; ?></option>
			<?php } ?>        
        
        </select>                	
    </div>

    <label class="form-label">Ciudad</label>
    <div class="form-group form-float">
        <div class="form-line">
            <input type="text" id="cCiudad" name="cCiudad" class="form-control" placeholder="Ciudad"  required value="<?php echo htmlspecialchars($cCiudad); ?>">
        </div>
    </div>

    <label class="form-label">Estado</label>
    <div class="form-group form-float">
        <div class="form-line">
            <input type="text" id="cEstado" name="cEstado" class="form-control" placeholder="Estado"  required value="<?php echo htmlspecialchars($cEstado); ?>">
        </div>
    </div>

    <label class="form-label">País</label>
    <div class="form-group form-float">
        <div class="form-line">
            <input type="text" id="cPais" name="cPais" class="form-control" placeholder="País" required value="México">
        </div>
    </div>
    
