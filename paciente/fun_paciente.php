<?php


$ruta="../";

extract($_SESSION);

function medicion_protocolo($paciente_id){

	$drop = "DROP TABLE IF EXISTS tabla_temporal_$paciente_id";
	$result = ejecutar($drop);	
	
	$create = "
		CREATE  TABLE tabla_temporal_$paciente_id  
		(
		  `paciente_id` int NOT NULL,
		  `f_captura` date NULL,
		  `PHQ9` int NULL,
		  `GAD7` int NULL,
		  `TINITUS` int NULL,
		  `CPFDL` int NULL
		)";
	$result = ejecutar($create);

	
		$sql_valida ="
			SELECT
				sesiones.sesion_id, 
				sesiones.terapia_id, 
				sesiones.protocolo_ter_id, 
				sesiones.paciente_id, 
				sesiones.sesiones, 
				sesiones.total_sesion, 
				sesiones.f_alta, 
				sesiones.h_alta, 
				protocolo_terapia.prot_terapia
			FROM
				sesiones
				INNER JOIN
				protocolo_terapia
				ON 
					sesiones.protocolo_ter_id = protocolo_terapia.protocolo_ter_id
			WHERE
				sesiones.paciente_id = $paciente_id
		";
		//echo $sql_valida."<hr>";
		$resultado ='';
		$resultado .='[';
		$result_valida = ejecutar($sql_valida);	
		//echo "VALIDA ".$result_valida;
		while($row_valida = mysqli_fetch_array($result_valida)){
	        extract($row_valida);
			// print_r($row_valida);
			// echo "protocolo_ter_id ".$protocolo_ter_id."<br>";
			
			switch ($protocolo_ter_id) {
				case 1:
					$sql_base ="
						SELECT
							base_protocolo_1.base_id, 
							base_protocolo_1.paciente_id, 
							base_protocolo_1.usuario_id, 
							base_protocolo_1.f_captura, 
							base_protocolo_1.h_captura,
							CONCAT(pacientes.paciente,' ',pacientes.apaterno,' ',pacientes.amaterno) as paciente,
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_1.respuesta_24 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_1.respuesta_25 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_1.respuesta_26 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_1.respuesta_27 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_1.respuesta_28 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_1.respuesta_29 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_1.respuesta_30 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_1.respuesta_31 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_1.respuesta_32 ) as PHQ9,			
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_1.respuesta_34 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_1.respuesta_35 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_1.respuesta_36 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_1.respuesta_37 )+			
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_1.respuesta_38 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_1.respuesta_39 )+		
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_1.respuesta_40 ) as GAD7,
							0 as TINITUS,
							0 as CPFDL
						FROM
							base_protocolo_1
							INNER JOIN
							pacientes
							ON 
								base_protocolo_1.paciente_id = pacientes.paciente_id
						WHERE
							base_protocolo_1.paciente_id = $paciente_id";					
					break;
					
				case 2:
					$sql_base ="
						SELECT
							base_protocolo_2.base_id, 
							base_protocolo_2.paciente_id, 
							base_protocolo_2.usuario_id, 
							base_protocolo_2.f_captura, 
							base_protocolo_2.h_captura,
							CONCAT(pacientes.paciente,' ',pacientes.apaterno,' ',pacientes.amaterno) as paciente,
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_2.respuesta_42 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_2.respuesta_43 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_2.respuesta_44 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_2.respuesta_45 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_2.respuesta_46 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_2.respuesta_47 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_2.respuesta_48 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_2.respuesta_49 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_2.respuesta_50 ) as PHQ9,			
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_2.respuesta_52 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_2.respuesta_53 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_2.respuesta_54 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_2.respuesta_55 )+			
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_2.respuesta_56 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_2.respuesta_57 )+		
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_2.respuesta_58 ) as GAD7,
							0 as TINITUS,
							0 as CPFDL
						FROM
							base_protocolo_2
							INNER JOIN
							pacientes
							ON 
								base_protocolo_2.paciente_id = pacientes.paciente_id
						WHERE
							base_protocolo_2.paciente_id = $paciente_id";					
					break;
					
				case 3:
					$sql_base ="
						SELECT
							base_protocolo_3.base_id, 
							base_protocolo_3.paciente_id, 
							base_protocolo_3.usuario_id, 
							base_protocolo_3.f_captura, 
							base_protocolo_3.h_captura,
							CONCAT(pacientes.paciente,' ',pacientes.apaterno,' ',pacientes.amaterno) as paciente,
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_3.respuesta_60 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_3.respuesta_61 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_3.respuesta_62 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_3.respuesta_63 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_3.respuesta_64 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_3.respuesta_65 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_3.respuesta_66 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_3.respuesta_67 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_3.respuesta_68 ) as PHQ9,			
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_3.respuesta_70 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_3.respuesta_71 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_3.respuesta_72 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_3.respuesta_73 )+			
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_3.respuesta_74 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_3.respuesta_75 )+		
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_3.respuesta_76 ) as GAD7,
							0 as TINITUS,
							0 as CPFDL
						FROM
							base_protocolo_3
							INNER JOIN
							pacientes
							ON 
								base_protocolo_3.paciente_id = pacientes.paciente_id
						WHERE
							base_protocolo_3.paciente_id = $paciente_id";	

// PHQ9							
// El PHQ-9 utiliza como recomendación original un puntaje de 10 para detectar un trastorno depresivo en pacientes de APS. 
// Sin embargo, evidencia reciente relativa al puntaje de corte óptimo del PHQ-9 para 
// tamizar depresión encontró los puntajes entre 8 y 11 con propiedades satisfactorias16.													
	// GAD7	
	// 0–4	No se aprecia ansiedad
	// 5–9	Se aprecian síntomas de ansiedad leves
	// 10–14	Se aprecian síntomas de ansiedad moderados
	// 15–21	Se aprecian síntomas de ansiedad severos	
											
					break;

				case 4:
				
					$sql_base ="					
						SELECT
							base_protocolo_4.base_id, 
							base_protocolo_4.paciente_id, 
							base_protocolo_4.usuario_id, 
							base_protocolo_4.f_captura, 
							base_protocolo_4.h_captura,
							CONCAT(pacientes.paciente,' ',pacientes.apaterno,' ',pacientes.amaterno) as paciente,
							0 as PHQ9,
							0 as GAD7,
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_4.respuesta_80 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_4.respuesta_81 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_4.respuesta_82 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_4.respuesta_83 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_4.respuesta_84 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_4.respuesta_85 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_4.respuesta_86 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_4.respuesta_87 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_4.respuesta_88 )+			
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_4.respuesta_89 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_4.respuesta_90 )+	
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_4.respuesta_91 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_4.respuesta_92 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_4.respuesta_93 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_4.respuesta_94 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_4.respuesta_95 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_4.respuesta_96 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_4.respuesta_97 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_4.respuesta_98 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_4.respuesta_99 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_4.respuesta_100 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_4.respuesta_101 )+			
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_4.respuesta_102 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_4.respuesta_103 )+	
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_4.respuesta_104 ) as TINITUS,
							0 as CPFDL
						FROM
							base_protocolo_4
							INNER JOIN
							pacientes
							ON 
								base_protocolo_4.paciente_id = pacientes.paciente_id
						WHERE
							base_protocolo_4.paciente_id = $paciente_id";	
							
// GRADO 1: (0-16) MUY LEVE: Solo percibido en ambiente silencioso y fácilmente enmascarable, casi nunca perturba al paciente.
// 
// GRADO 2: (18-36) LEVE: Enmascarable por el ruido ambiente y olvidado por la actividad diaria.
// 
// GRADO 3: (38-56) MODERADO: Percibido a pesar del ruido ambiente, si bien no dificulta las actividades diarias; sin embargo molesta en reposo y a veces dificulta la conciliación del sueño.
// 
// GRADO 4: (58-76) SEVERO: Siempre percibido, interfiere con las actividades diarias, dificultando siempre el reposo y el sueño; paciente que acude al especialista.
// 
// GRADO 5: (78-100) CATASTRÓFICO: Todos los síntomas peor que el grado 4, especialmente el insomnio, posible patología psiquiátrica asociada.											
										
					break;					

				case 5:	

					$sql_base ="					
						SELECT
							base_protocolo_5.base_id, 
							base_protocolo_5.paciente_id, 
							base_protocolo_5.usuario_id, 
							base_protocolo_5.f_captura, 
							base_protocolo_5.h_captura,
							CONCAT(pacientes.paciente,' ',pacientes.apaterno,' ',pacientes.amaterno) as paciente,
							0 as PHQ9,
							0 as GAD7,
							0 as TINITUS,
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_5.respuesta_105 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_5.respuesta_106 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_5.respuesta_107 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_5.respuesta_108 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_5.respuesta_109 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_5.respuesta_110 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_5.respuesta_111 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_5.respuesta_112 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_5.respuesta_113 )+
							( SELECT respuestas.valor FROM respuestas WHERE respuestas.respuesta = base_protocolo_5.respuesta_114 ) as CPFDL
						FROM
							base_protocolo_5
							INNER JOIN
							pacientes
							ON 
								base_protocolo_5.paciente_id = pacientes.paciente_id
						WHERE
							base_protocolo_5.paciente_id = $paciente_id";				
														
					break;	
																																					
				default:
					
					break;
			}
		
			//echo $sql_base."<hr>";
			
			$cnt_j = 1;
						
			$result_base = ejecutar($sql_base);	
			$cnt_t = mysqli_num_rows($result_base);
			while($row_base = mysqli_fetch_array($result_base)){
		        extract($row_base);
		        //print_r($row_base);
		        //echo "base_id ".$base_id."<br>";
		        //$f_captura = strftime("%e-%b-%Y",strtotime($f_captura));
		       //$f_captura = date("d-m-Y",strtotime($f_captura));
		       
		       // $PHQ9x = PHQ9($PHQ9);
			   // $GAD7x = GAD7($GAD7);
			   // $TINITUSx = tinitus($TINITUS);
			   
			   
		    $insert = "
				INSERT INTO tabla_temporal_$paciente_id
				(paciente_id,f_captura,PHQ9,GAD7,TINITUS,CPFDL)
				VALUES
				($paciente_id,'$f_captura',$PHQ9,$GAD7,$TINITUS,$CPFDL)"; 
				//echo $insert;
		    $result = ejecutar($insert);  
			
			
			$resultado .= '{"y": "'.$f_captura.'", "PHQ9": '.$PHQ9.', "GAD7": '.$GAD7.', "TINITUS": '.$TINITUS.', "CPFDL": '.$CPFDL.'},';
			
		        // switch ($protocolo_ter_id) {
					// case 1:
					// case 2:
					// case 3:
						// $resultado .= '{"y": "'.$f_captura.'", "PHQ9": '.$PHQ9.', "GAD7": '.$GAD7.', "TINITUS": '.$TINITUS.'},';
// 
						// break;
// 					
					// case 4:
// 						
						// $resultado .= '{"y": "'.$f_captura.'", "PHQ9": '.$PHQ9.', "GAD7": '.$GAD7.', "TINITUS": '.$TINITUS.'},';
// 						
						// break;
// 					
					// default:
// 						
						// break;
				// }
				$cnt_j++;			        
	        }
			
			
		}
	$resultado .='];';
	
// $resultado = "[{'y': '2023-03-06', 'PHQ9': 12, 'GAD7': 12},{'y': '2023-04-03', 'PHQ9': 12, 'GAD7': 12},{'y': '2023-05-25', 'PHQ9': 16, 'GAD7': 14},{'y': '2023-05-01', 'PHQ9': 27, 'GAD7': 21},{'y': '2023-05-09', 'PHQ9': 12, 'GAD7': 12},{'y': '2023-05-09', 'PHQ9': 7, 'GAD7': 2},{'y': '2023-05-09', 'PHQ9': 5, 'GAD7': 4},];";
		
return $resultado;
}	

function medicion_tabla($paciente_id){
	
	
return $resultado;
}	


	// verde #39F905 verde claro #A8F905 amarillo #EAF905 naranja #F9B605 rojo #F91B05				

function PHQ9($PHQ9){
		
	if ($PHQ9 <= 4) {
		$color = '#39F905';
		$calificacion = 'Sin síntomas';
	}elseif($PHQ9 >= 5 && $PHQ9 <= 9) {
		$color = '#A8F905';
		$calificacion = 'Leve';		
	}elseif($PHQ9 >= 10 && $PHQ9 <= 14) {
		$color = '#EAF905';
		$calificacion = 'Moderado';		
	}elseif($PHQ9 >= 15 && $PHQ9 <= 18) {
		$color = '#F9B605';
		$calificacion = 'Moderadamente severo';		
	}elseif($PHQ9 >= 19 && $PHQ9 <= 30) {
		$color = '#F91B05';
		$calificacion = 'Grave';		
	}	
		
	if ($PHQ9 == 0) {
		$PHQ9 = 0;
	} else {
		$PHQ9 = round(($PHQ9/27)*100,0);
	}
		

	
	$resultado = $color;
	
	// $resultado ="
    	// <label class='form-label'>PHQ9</label>
        // <input type='text' class='knob' value='$PHQ9' data-width='125' data-height='125' data-thickness='0.25' data-fgColor='$color'
               // data-anglearc='250' data-angleoffset='-125' readonly>
       	// <label class='form-label'>$calificacion</label>	
	// ";
	
return $resultado;
}

function GAD7($GAD7){

	if ($GAD7 <= 4) {
		$color = '#39F905';
		$calificacion = 'Sin síntomas';
	}elseif($GAD7 >= 5 && $GAD7 <= 9) {
		$color = '#A8F905';
		$calificacion = 'Leve';		
	}elseif($GAD7 >= 10 && $GAD7 <= 14) {
		$color = '#EAF905';
		$calificacion = 'Moderado';			
	}elseif($GAD7 >= 15 && $GAD7 <= 30) {
		$color = '#F91B05';
		$calificacion = 'Grave';		
	}

	if ($GAD7 == 0) {
		$GAD7 = 0;
	} else {
		$GAD7 = round(($GAD7/21)*100,0);
	}	
	
	$resultado = $color;
	// $resultado ="
    	// <label class='form-label'>GAD7</label>
        // <input type='text' class='knob' value='$GAD7' data-width='125' data-height='125' data-thickness='0.25' data-fgColor='$color'
               // data-anglearc='250' data-angleoffset='-125' readonly>
       	// <label class='form-label'>$calificacion</label>	
	// ";
	
return $resultado;;
}

function TINITUS($TINITUS){
		
// GRADO 1: (0-16) MUY LEVE: Solo percibido en ambiente silencioso y fácilmente enmascarable, casi nunca perturba al paciente.
// GRADO 2: (18-36) LEVE: Enmascarable por el ruido ambiente y olvidado por la actividad diaria.
// GRADO 3: (38-56) MODERADO: Percibido a pesar del ruido ambiente, si bien no dificulta las actividades diarias; sin embargo molesta en reposo y a veces dificulta la conciliación del sueño.
// GRADO 4: (58-76) SEVERO: Siempre percibido, interfiere con las actividades diarias, dificultando siempre el reposo y el sueño; paciente que acude al especialista.
// GRADO 5: (78-100) CATASTRÓFICO: Todos los síntomas peor que el grado 4, especialmente el insomnio, posible patología psiquiátrica asociada.		
	
	if ($TINITUS <= 16) {
		$color = '#39F905';
		$calificacion = 'Muy leve';
	}elseif($TINITUS >= 17 && $TINITUS <= 36) {
		$color = '#FFEB3B';
		$calificacion = 'Leve';		
	}elseif($TINITUS >= 37 && $TINITUS <= 56) {
		$color = '#FFC107';
		$calificacion = 'Moderado';			
	}elseif($TINITUS >= 57 && $TINITUS <= 76) {
		$color = '#FF9800';
		$calificacion = 'Severo';		
	}elseif($TINITUS >= 77 && $TINITUS <= 100) {
		$color = '#FF5722';
		$calificacion = 'Catastrófico';		
	}

	if ($GAD7 == 0) {
		$GAD7 = 0;
	} else {
		$GAD7 = round(($GAD7/21)*100,0);
	}	

	$resultado = $color;
	
	return $resultado;
}

function CPFDL($CPFDL){
		
	if ($CPFDL <= 7) {
		$color = '#39F905';
		$calificacion = 'Sin síntomas';
	}elseif($CPFDL >= 8 && $CPFDL <= 15) {
		$color = '#A8F905';
		$calificacion = 'Leve';		
	}elseif($CPFDL >= 16 && $CPFDL <= 23) {
		$color = '#EAF905';
		$calificacion = 'Moderado';		
	}elseif($CPFDL >= 24 && $CPFDL <= 31) {
		$color = '#F9B605';
		$calificacion = 'Moderadamente severo';		
	}elseif($CPFDL >= 32 && $CPFDL <= 40) {
		$color = '#F91B05';
		$calificacion = 'Grave';		
	}	
		
	if ($CPFDL == 0) {
		$CPFDL = 0;
	} else {
		$CPFDL = round(($PHQ9/27)*100,0);
	}
		

	
	$resultado = $color;
	
	// $resultado ="
    	// <label class='form-label'>PHQ9</label>
        // <input type='text' class='knob' value='$PHQ9' data-width='125' data-height='125' data-thickness='0.25' data-fgColor='$color'
               // data-anglearc='250' data-angleoffset='-125' readonly>
       	// <label class='form-label'>$calificacion</label>	
	// ";
	
return $resultado;
}


function remision($remision){
		
	if ($remision <= 49) {
		$color = '#F91B05';
	}elseif($remision >= 50 && $remision <= 75) {
		$color = '#EAF905';
	}elseif($remision >= 76 && $remision <= 100) {
		$color = '#39F905';
	}
		
	
	$resultado = $color;
	
	// $resultado ="
    	// <label class='form-label'>PHQ9</label>
        // <input type='text' class='knob' value='$PHQ9' data-width='125' data-height='125' data-thickness='0.25' data-fgColor='$color'
               // data-anglearc='250' data-angleoffset='-125' readonly>
       	// <label class='form-label'>$calificacion</label>	
	// ";
	
return $resultado;
}