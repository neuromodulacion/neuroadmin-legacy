<?php


$ruta="../";

extract($_SESSION);
//include($ruta.'functions/funciones_mysql.php');

function OptieneMesCorto($mes){
	if ($mes == 1  || $mes == '1' || $mes == '01') { $xmes = 'Ene'; }
	if ($mes == 2  || $mes == '2' || $mes == '02') { $xmes = 'Feb'; }	
	if ($mes == 3  || $mes == '3' || $mes == '03') { $xmes = 'Mar'; }	
	if ($mes == 4  || $mes == '4' || $mes == '04') { $xmes = 'Abr'; }	
	if ($mes == 5  || $mes == '5' || $mes == '05') { $xmes = 'May'; }	
	if ($mes == 6  || $mes == '6' || $mes == '06') { $xmes = 'Jun'; }	
	if ($mes == 7  || $mes == '7' || $mes == '07') { $xmes = 'Jul'; }	
	if ($mes == 8  || $mes == '8' || $mes == '08') { $xmes = 'Ago'; }	
	if ($mes == 9  || $mes == '9' || $mes == '09') { $xmes = 'Sep'; }	
	if ($mes == 10 || $mes == '10' ){ $xmes = 'Oct'; }	
	if ($mes == 11 || $mes == '11' ){ $xmes = 'Nov'; }	
	if ($mes == 12 || $mes == '12' ){ $xmes = 'Dic'; }  
return $xmes;     	
} 

function OptieneMesLargo($mes){
	if ($mes == 1  || $mes == '1' || $mes == '01') { $xmes = 'Enero'; }
	if ($mes == 2  || $mes == '2' || $mes == '02') { $xmes = 'Febrero'; }	
	if ($mes == 3  || $mes == '3' || $mes == '03') { $xmes = 'Marzo'; }	
	if ($mes == 4  || $mes == '4' || $mes == '04') { $xmes = 'Abril'; }	
	if ($mes == 5  || $mes == '5' || $mes == '05') { $xmes = 'Mayo'; }	
	if ($mes == 6  || $mes == '6' || $mes == '06') { $xmes = 'Junio'; }	
	if ($mes == 7  || $mes == '7' || $mes == '07') { $xmes = 'Julio'; }	
	if ($mes == 8  || $mes == '8' || $mes == '08') { $xmes = 'Agosto'; }	
	if ($mes == 9  || $mes == '9' || $mes == '09') { $xmes = 'Septiembre'; }	
	if ($mes == 10 || $mes == '10' ){ $xmes = 'Octubre'; }	
	if ($mes == 11 || $mes == '11' ){ $xmes = 'Noviembre'; }	
	if ($mes == 12 || $mes == '12' ){ $xmes = 'Diciembre'; }  
return $xmes;     	
}  

function OptieneNumeroMes($mes){   
	if ($mes == 1  || $mes == '1' || $mes == 01  || $mes == 'Enero'  || $mes == 'Ene') { $xmes ='01'; }
	if ($mes == 2  || $mes == '2' || $mes == '02'  || $mes == 'Febrero'  || $mes == 'Feb') { $xmes = '02'; }	
	if ($mes == 3  || $mes == '3' || $mes == '03'  || $mes == 'Marzo'  || $mes == 'Marz') { $xmes = '03'; }	
	if ($mes == 4  || $mes == '4' || $mes == '04'  || $mes == 'Abril'  || $mes == 'Abr') { $xmes = '04'; }	
	if ($mes == 5  || $mes == '5' || $mes == '05'  || $mes == 'Mayo'  || $mes == 'May') { $xmes = '05'; }	
	if ($mes == 6  || $mes == '6' || $mes == '06'  || $mes == 'Junio'  || $mes == 'Jun') { $xmes = '06'; }	
	if ($mes == 7  || $mes == '7' || $mes == '07'  || $mes == 'Julio'  || $mes == 'Jul') { $xmes = '07'; }	
	if ($mes == 8  || $mes == '8' || $mes == '08'  || $mes == 'Agosto'  || $mes == 'Ago') { $xmes = '08'; }	
	if ($mes == 9  || $mes == '9' || $mes == '09'  || $mes == 'Septiembre'  || $mes == 'Sep') { $xmes = '09'; }	
	if ($mes == 10 || $mes == '10' || $mes == 'Octubre'  || $mes == 'Oct'){ $xmes = '10'; }	
	if ($mes == 11 || $mes == '11' || $mes == 'Noviembre'  || $mes == 'Nov'){ $xmes = '11'; }	
	if ($mes == 12 || $mes == '12' || $mes == 'Diciembre'  || $mes == 'Diciembre'){ $xmes = '12'; }
return $xmes;
}

function dia_semana($dia){
	if ($dia == 0 ) { $xdia ='Domingo'; }	   
	if ($dia == 1 ) { $xdia ='Lunes'; }
	if ($dia == 2 ) { $xdia = 'Martes'; }	
	if ($dia == 3 ) { $xdia = 'Miercoles'; }	
	if ($dia == 4 ) { $xdia = 'Jueves'; }	
	if ($dia == 5 ) { $xdia = 'Viernes'; }	
	if ($dia == 6 ) { $xdia = 'Sabado'; }	
	if ($dia == 7 ) { $xdia = 'Domingo'; }	
return $xdia;
}

function calendario($semana,$anio,$mes_largo,$genera,$body,$accion,$dia_ini,$dia_fin){

//echo $semana." ".$anio." ".$mes_largo." ".$genera." ".$body." ".$accion." ".$dia_ini." ".$dia_fin."<hr>";
	
	if ($genera == "remoto") {
		include('../functions/funciones_mysql.php');
		
	}else{
		$semana = date("W");
	}
	
	if ($accion == "busca") {
			
		$semana = date("W",strtotime($dia_fin));
		$anio = date("Y",strtotime($dia_fin));
		
		$sql_sem1 = "
			SELECT
				*
			FROM
				fechas
			WHERE
				year(fecha) = '$anio'
				and week(fecha) = '$semana'
		    ";
			echo $sql_sem1."<hr>";
			$result_sem1=ejecutar($sql_sem1); 
	        $cnt=1;
	        $total = 0;
	        $ter="";
	    while($row_sem1 = mysqli_fetch_array($result_sem1)){
	        extract($row_sem1);
			if ($cnt == 1) { $dia_ini = $fecha; } 
			if ($cnt == 7) { $dia_fin = $fecha; } 
			$cnt++;
		}			
			
	}	
	
//echo $body;
$sem_hoy = date("W");	
$hoy = date("Y-m-d");

	$sql_sem1 = "
	SELECT
		*
	FROM
		fechas
	WHERE
		fecha BETWEEN '$dia_ini' AND '$dia_fin'
    ";
	//	echo "$sql_sem1 <br>";
    $result_sem1=ejecutar($sql_sem1); 
   
        $cnt=1;
        $total = 0;
        $ter="";
    while($row_sem1 = mysqli_fetch_array($result_sem1)){
        extract($row_sem1);
		if ($cnt == 1) { $dia_ini = $fecha; } 
		if ($cnt == 7) { $dia_fin = $fecha; } 
		
		switch ($cnt) {
			case 1:
				$dom = $fecha;
				break;

			case 2:
				$lun = $fecha;
				break;
				
			case 3:
				$mar = $fecha;
				break;
				
			case 4:
				$mier = $fecha;
				break;
				
			case 5:
				$jue = $fecha;
				break;
				
			case 6:
				$vier = $fecha;
				break;
				
			case 7:
				$sab = $fecha;
				break;										
		}
		$cnt++;	
	}

	
// echo $dia_ini."<br>";
// echo $dia_fin."<br>";

// echo date("d-m-Y",strtotime($dia_fin."+ 1 days"))."<br>"; 
// echo date("d-m-Y",strtotime($dia_fin."+ 7 days"))."<br>"; 
// echo date("d-m-Y",strtotime($dia_ini."- 1 days"))."<br>"; 
// echo date("d-m-Y",strtotime($dia_ini."- 7 days"))."<br>"; 

$dia_ini_atras = date("Y-m-d",strtotime($dia_ini."- 7 days"));
$dia_fin_atras = date("Y-m-d",strtotime($dia_ini."- 1 days"));
$dia_ini_adelante = date("Y-m-d",strtotime($dia_fin."+ 1 days"));
$dia_fin_adelante = date("Y-m-d",strtotime($dia_fin."+ 7 days"));

$semana = date("W",strtotime($dia_fin));
$sem_ant = date("W",strtotime($dia_ini_atras));
$sem_pos = date("W",strtotime($dia_fin_adelante));

$anio_atras = date("Y",strtotime($dia_ini_atras));
$anio_adel = date("Y",strtotime($dia_fin_adelante));	
$anio_hoy = date("Y");

//$mes = date("m",strtotime($dia_fin."+ 7 days"));

// echo $dia_ini_atras."<br>";
// echo $dia_fin_atras."<br>";
// echo $dia_ini_adelante."<br>";
// echo $dia_fin_adelante."<br>";

//if ($semana == 1) { $sem_ant = 52; } else { $sem_ant = ($semana-1); };
//if ($semana == 52) { $sem_pos = 1; } else { $sem_pos = ($semana+1); };	

	if ($genera == "remoto") {
		switch ($accion) {
			case 'anterior':
				$anio = date("Y",strtotime($dia_ini));
				$semana = date("W",strtotime($dia_ini));			
				break;
				
			case 'hoy':
				$semana = date("W");
				$anio = date("Y");		
				break;
			case 'siguiente':
				$anio = date("Y",strtotime($dia_fin));	
				$semana = date("W",strtotime($dia_fin));							
				break;				
			case 'buscar':
				$anio = date("Y",strtotime($dia_fin));	
				$semana = date("W",strtotime($dia_fin));							
				break;							
			default:
				$semana = date("W");
				$anio = date("Y");						
				break;
		}	
	}

	//echo "año ".$anio."<hr>";

	$table ="<table class='table table-bordered table-striped table-hover dataTable'>
				<tr style='text-align: center; width: 9%;' >
					<th>Horario</th>";

			$div ="	
                	<div style='text-align: center'>
                        <div  class='btn-group' role='group'>
                            <button id='anterior' name='anterior' type='button' class='btn bg-$body waves-effect'><< Anterior</button>
	                        <script>
	                            $('#anterior').click(function(){ 
	                            	//alert('test');  
	                                $('#calendario').html(''); 
	                                var semana = '".($sem_ant)."';
	                                var anio = '$anio_atras';
	                                var mes_largo = '$mes_largo'; 
	                                var body = '$body';
	                                var accion = 'anterior';
	                                var dia_ini = '$dia_ini_atras';
	                                var dia_fin = '$dia_fin_atras';
	                                var datastring = 'semana='+semana+'&anio='+anio+'&mes_largo='+mes_largo+'&body='+body+'&accion='+accion+'&dia_ini='+dia_ini+'&dia_fin='+dia_fin;
	                                
                                    $.ajax({
                                        url: 'genera_calendario.php',
                                        type: 'POST',
                                        data: datastring,
                                        cache: false,
                                        success:function(html){     
                                            $('#calendario').html(html); 
                                            //$('#load1').hide();
                                            //$('#muestra_asegurado').click();
                                        }
                                	});
	                            });
	                        </script> 
                            <button id='hoy' type='button' class='btn bg-$body waves-effect'>Hoy</button>
	                        <script>
	                            $('#hoy').click(function(){ 
	                            	//alert('test');  
	                                $('#calendario').html(''); 
	                                var semana = '".($sem_hoy)."';
	                                var anio = '$anio';
	                                var mes_largo = '$mes_largo'; 
									var body = '$body';
									var accion = 'hoy';
	                                var dia_ini = '$dia_ini';
	                                var dia_fin = '$dia_fin';
	                                var datastring = 'semana='+semana+'&anio='+anio+'&mes_largo='+mes_largo+'&body='+body+'&accion='+accion+'&dia_ini='+dia_ini+'&dia_fin='+dia_fin;
	                                
                                    $.ajax({
                                        url: 'genera_calendario.php',
                                        type: 'POST',
                                        data: datastring,
                                        cache: false,
                                        success:function(html){     
                                            $('#calendario').html(html); 
                                            //$('#load1').hide();
                                            //$('#muestra_asegurado').click();
                                        }
                                	});
	                            });
	                        </script>
                            <button id='siguiente' type='button' class='btn bg-$body  waves-effect'>Siguiente >></button>
	                        <script>
	                            $('#siguiente').click(function(){ 
	                            	//alert('test');  
	                                $('#calendario').html(''); 									
	                                var semana = '".($sem_pos)."';
	                                var anio = '$anio_adel';
	                                var mes_largo = '$mes_largo'; 
									var body = '$body';
									var accion = 'siguiente';
	                                var dia_ini = '$dia_ini_adelante';
	                                var dia_fin = '$dia_fin_adelante';
	                                var datastring = 'semana='+semana+'&anio='+anio+'&mes_largo='+mes_largo+'&body='+body+'&accion='+accion+'&dia_ini='+dia_ini+'&dia_fin='+dia_fin;
	                                
                                    $.ajax({
                                        url: 'genera_calendario.php',
                                        type: 'POST',
                                        data: datastring,
                                        cache: false,
                                        success:function(html){     
                                            $('#calendario').html(html); 
                                            //$('#load1').hide();
                                            //$('#muestra_asegurado').click();
                                        }
                                	});
	                            });
	                        </script> 
                        </div>
                    </div><hr>	
	
	";

    
		$sql_sem = "
		SELECT
			*
		FROM
			fechas
		WHERE
			fecha BETWEEN '$dia_ini' AND '$dia_fin'
	    ";	   
    	//echo "<hr>$anio <hr>";
		//echo "sql $sql_sem <hr>";
    $result_sem=ejecutar($sql_sem); 
   
        $cnt=1;
        $total = 0;
        $ter="";
    while($row_sem = mysqli_fetch_array($result_sem)){
        extract($row_sem);
		$anio = date("Y",strtotime($fecha));
		if ($hoy == $fecha) { $class = "class='success'"; }else{ $class = ""; }
		$dia_semana = dia_semana(date("N",strtotime($fecha)))."<br>".date("d",strtotime($fecha));
		$mes_corto = OptieneMesCorto(date("m",strtotime($fecha)));
		$table.="<th $class align='center'  style='width: 13%;' >$dia_semana $mes_corto $anio</th>";
		$cnt++;
	};			                	
	$table.="</tr>";		                	
			                	
	$inicio = date("H:i:s",strtotime('08:00:00'));
	$fin = date("H:i:s",strtotime('20:00:00'));
	$ahora = date("H:i:s");
	
	$sql_sem = "
	SELECT
		horas.id,
		horas.hora,
		(SELECT 
		agenda.agenda_id
	FROM
		agenda
	WHERE
		agenda.f_ini = '$dom'
	AND agenda.h_ini <= horas.hora 
	and agenda.h_fin > horas.hora
	LIMIT 1) as domingo, 
		(SELECT 
		agenda.agenda_id
	FROM
		agenda
	WHERE
		agenda.f_ini = '$lun'
	AND agenda.h_ini <= horas.hora 
	and agenda.h_fin > horas.hora
	LIMIT 1) as lunes,
		(SELECT 
		agenda.agenda_id
	FROM
		agenda
	WHERE
		agenda.f_ini = '$mar'
	AND agenda.h_ini <= horas.hora 
	and agenda.h_fin > horas.hora
	LIMIT 1)as martes,
		(SELECT 
		agenda.agenda_id
	FROM
		agenda
	WHERE
		agenda.f_ini = '$mier'
	AND agenda.h_ini <= horas.hora 
	and agenda.h_fin > horas.hora
	LIMIT 1)as miercoles,
		(SELECT 
		agenda.agenda_id
	FROM
		agenda
	WHERE
		agenda.f_ini = '$jue'
	AND agenda.h_ini <= horas.hora 
	and agenda.h_fin > horas.hora
	LIMIT 1)as jueves,
		(SELECT 
		agenda.agenda_id
	FROM
		agenda
	WHERE
		agenda.f_ini = '$vier'
	AND agenda.h_ini <= horas.hora 
	and agenda.h_fin > horas.hora
	LIMIT 1)as viernes,
		(SELECT 
		agenda.agenda_id
	FROM
		agenda
	WHERE
		agenda.f_ini = '$sab'
	AND agenda.h_ini <= horas.hora 
	and agenda.h_fin > horas.hora
	LIMIT 1)as sabado
	FROM
		horas 
	WHERE
		hora >= '$inicio' 
		AND hora <= '$fin'	
	";
	
	
	// $sql_sem = "
		// SELECT
			// *
		// FROM
			// horas
		// WHERE
			// hora >= '$inicio' and hora <= '$fin'
        // ";
		//echo "$sql_sem <br>";
        $result_sem=ejecutar($sql_sem); 
   //&& $hora >= $ahora
            $cnt=1;
            $total = 0;
            $ter="";
        while($row_sem = mysqli_fetch_array($result_sem)){
            extract($row_sem);
            $hora = date("H:i",strtotime($hora));
			$rango = date("H:i",strtotime($hora."+ 15 minute"));
			$ahora = date("H:i",strtotime($ahora));
			$n_dia = date("N");
			
			if ($rango >= $ahora && $hora <= $ahora ) { $class = "class='success'"; $ok ="ok";}else{ $class = ""; $ok ="";}
            

            
            if ($n_dia == 1 && $ok =="ok") {$class1 = "class='success'"; }else{$class1 = "";}
            if ($n_dia == 2 && $ok =="ok") {$class2= "class='success'"; }else{$class2 = "";}
			if ($n_dia == 3 && $ok =="ok") {$class3 = "class='success'"; }else{$class3 = "";}
			if ($n_dia == 4 && $ok =="ok") {$class4 = "class='success'"; }else{$class4 = "";}
			if ($n_dia == 5 && $ok =="ok") {$class5 = "class='success'"; }else{$class5 = "";}
			if ($n_dia == 6 && $ok =="ok") {$class6 = "class='success'"; }else{$class6 = "";}
			if ($n_dia == 7 && $ok =="ok") {$class7 = "class='success'"; }else{$class7 = "";}
            
			if ($domingo > 0 ) {$class7 = "class='info'"; $domingo = agenda_reg($domingo); }else{$class7 = "";}
			if ($lunes > 0 ) {$class1 = "class='info'"; $lunes = agenda_reg($lunes); }else{$class1 = "";}
			if ($martes > 0 ) { $class2 = "class='info'"; $martes = agenda_reg($martes); }else{$class2 = "";}
			if ($miercoles > 0 ) { $class3 = "class='info'"; $miercoles = agenda_reg($miercoles); }else{$class3 = "";}
			if ($jueves > 0 ) { $class4 = "class='info'"; $jueves = agenda_reg($jueves); }else{$class4 = "";}
			if ($viernes > 0 ) { $class5 = "class='info'"; $viernes = agenda_reg($viernes); }else{$class5 = "";}
			if ($sabado > 0 ) { $class6 = "class='info'"; $sabado = agenda_reg($sabado); }else{$class6 = "";}
			
            $table.="         				                	
        	<tr>
        		<td $class >$hora</td>
        		<td $class7 >$domingo</td>
        		<td $class1 >$lunes</td>
        		<td $class2 >$martes</td>
        		<td $class3 >$miercoles</td>
        		<td $class4 >$jueves</td>
        		<td $class5 >$viernes</td>
        		<td $class6 >$sabado</td>
        	</tr>";
			
			
			
			

		}		                			                			                	
        $table.="</table>";

      
                
        $table = $div.$table;
return $table;
}

function busca_agenda($paciente_id,$paciente,$apaterno,$amaterno,$body,$genera){
	
	if ($genera == "busqueda") {
		include('../functions/funciones_mysql.php');
		$checked = "checked";
	}

	$h_ini = date("H:i",strtotime(date("H:00")."+ 60 minute"));
	$h_fin = date("H:i",strtotime($h_ini."+ 30 minute"));
	$hoy = date("Y-m-d");
	//echo strtoupper($busca_paciente);
	
	if ($paciente_id == '') {
		$paciente_id = 0;
	}
	
	if ($paciente_id >=1) {
		$info = "paciente_id = $paciente_id";
	} elseif ($paciente !=='' || $apaterno !=='' || $amaterno !==''){
		$info = "
			UPPER(pacientes.paciente) LIKE '%$paciente%' OR
			UPPER(pacientes.apaterno) LIKE '%$apaterno%' OR
			UPPER(pacientes.amaterno) LIKE '%$amaterno%'";
	} else {
		$info = "paciente_id = 0";
	}


	$table ="
	<input type='hidden' id='pacienteid' name='pacienteid' value='0'/>
	<table class='table table-bordered table-striped table-hover dataTable'>
		<tr>
			<th>#</th>
			<th>Paciente</th>
			<th>Estatus</th>
			<th>Cumpleaños</th>
			<th>Selecciona</th>
		<tr>";
	
	
		$sql_sem2 = "
			SELECT
				pacientes.paciente_id, 
				pacientes.paciente, 
				pacientes.apaterno, 
				pacientes.amaterno, 
				pacientes.f_nacimiento, 
				pacientes.estatus
			FROM
				pacientes
			WHERE
				$info
	    ";
		echo "$sql_sem1 <br>";
     $result_sem2=ejecutar($sql_sem2); 

    while($row_sem2 = mysqli_fetch_array($result_sem2)){
        extract($row_sem2);
		//print_r($row_sem2);
		$table.="
		<tr>
			<td>$paciente_id</td>
			<td>$paciente $apaterno $amaterno</td>
			<td>$f_nacimiento</td>
			<td>$estatus</td>
			<td>
                <input name='group5' type='radio' id='radio_$paciente_id' class='with-gap radio-col-$body' $checked  value='$paciente_id'/>
                <label for='radio_$paciente_id'>Selec.</label>
				<script type='text/javascript'>
				$(document).ready(function()
					{
					$('#radio_$paciente_id').click(function () {
					var paciente = $('#radio_$paciente_id').val();
					$('#pacienteid').val($('#radio_$paciente_id').val());
					});
				});
				</script>                
			</td>
		<tr>";
	} 

$table.="</table>";

echo $table;

$paciente = "
	<form>	                             	
		<div class='row'>													
			<div class='form-group'>
			    <div class='col-sm-4'>
			    	<label for='fecha' class='control-label' >Fecha</label>
			      	<input type='date' class='form-control' id='fecha' name='fecha' value='$hoy'>
			    </div>
			    
			</div>
			<div class='form-group'>    
			    <div class='col-sm-4'>
					<label for='h_ini' class='control-label'>Hora inicial</label>
			      	<input type='time' class='form-control' id='h_ini' name='h_ini' value='$h_ini'>
			    </div>
			</div>
			<div class='form-group'>
			    <div class='col-sm-4'>
			    	<label for='h_fin' class='control-label'>Hora Final</label>
			      	<input type='time' class='form-control' id='h_fin' name='h_fin' value='$h_fin'>
			    </div>
			</div>
		</div>

	<div class='modal-footer'>
	    <button id='buscar3x' type='button' class='btn btn-link waves-effect'>GUARDAR</button>       
    		<script type='text/javascript'>
                $('#buscar3x').click(function(){ 
                    //alert('test');	
					var fecha = $('#fecha').val();	
		            var h_ini = $('#h_ini').val();
		            var h_fin = $('#h_fin').val();	
		            var paciente_id = $('input[type=radio][name=group5]:checked').val();	
		            var body = 'teal';
		            
		            if(paciente_id){
		            	var datastring = 'paciente_id='+paciente_id+'&fecha='+fecha+'&h_ini='+h_ini+'&h_fin='+h_fin+'&body='+body;
		            	alert(paciente_id);	
		                $.ajax({
		                    url: 'guarda_agenda.php',
		                    type: 'POST',
		                    data: datastring,
		                    cache: false,
		                    success:function(html){     
		                        $('#contenido2').html(html); 
		                        $('#load_modal').hide();
		                        //$('#muestra_asegurado').click();
		                    }
		            	});			            	
	            	}else{
		            	alert('Debes de selecionar un paciente');
		            }
		            			                    			                                  
            	});
            </script>	   
							                            
	    <button type='button' class='btn btn-link waves-effect' data-dismiss='modal'>CERRAR</button>
	    
	</div>	    
<form>	
";
	
	
	
return $paciente;
}

function agenda_reg($agenda_id){
		
$sql ="
SELECT
	agenda.agenda_id,
	pacientes.paciente_id,
	pacientes.paciente, 
	pacientes.apaterno, 
	pacientes.amaterno
FROM
	agenda
	INNER JOIN
	pacientes
	ON 
		agenda.paciente_id = pacientes.paciente_id
	WHERE
		agenda.agenda_id = $agenda_id";
    $result=ejecutar($sql); 
    $row = mysqli_fetch_array($result);
    extract($row);
    
    $dia = $paciente." ".$apaterno." ".$amaterno;
   
	$num = strlen($dia); 
	$quit = 15 - $n_lun;  
	$dia = substr($dia, 0, $quit)."..."; 
  	$dia = "<a style='width: 100px' class='btn btn-default;' href='info_paciente.php?agenda_id=$agenda_id&paciente_id=$paciente_id&origen=agenda' role='button'>$dia</a>";
    	
return $dia;
}

function obtener_edad_segun_fecha($fecha_nacimiento)
{
    $nacimiento = new DateTime($fecha_nacimiento);
    $ahora = new DateTime(date("Y-m-d"));
    $diferencia = $ahora->diff($nacimiento);
    return $diferencia->format("%y");
}