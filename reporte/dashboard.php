<?php
// Iniciar la sesión del usuario
session_start();

// Configurar el nivel de reporte de errores (7 muestra errores y advertencias)
error_reporting(7);

// Establecer la codificación interna a UTF-8 para las funciones de conversión de cadenas
iconv_set_encoding('internal_encoding', 'utf-8');

// Enviar cabecera HTTP para especificar que el contenido es HTML con codificación UTF-8
header('Content-Type: text/html; charset=UTF-8');

// Establecer la zona horaria predeterminada
date_default_timezone_set('America/Monterrey');

// Configurar la localización en español para fechas y horas
setlocale(LC_TIME, 'es_ES.UTF-8');

// Guardar la hora actual en la sesión
$_SESSION['time'] = time();

$ruta="../";
$title = 'INICIO';
$sesion ="Off";
extract($_SESSION);
//print_r($_SESSION);
$hoy = date("Y-m-d");
$ahora = date("H:i:00"); 
$anio = date("Y");
$mes_ahora = date("m");
$titulo ="Menú TMS";
include($ruta.'header1.php');
include($ruta.'header2.php'); ?>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>DASHBOARD</h2>
                <!-- <?php echo $ubicacion_url; 
                echo "<br> $ruta.'/proyecto_medico/menu.php'"?> -->
            </div>
<!-- // ************** Contenido ************** // -->
            <!-- CKEditor -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div style="height: 95%"  class="header">
                        	<h3 align="center"><?php echo $emp_nombre; ?></h3>
                    	</div>
                	</div>
            	</div>
        	</div>    

			<div class="row">
        	<?php  
        	//echo $sesion."<hr>";
        	//print_r($_SESSION);
			      	
	        	$sql ="
	        	SELECT
					COUNT(*) AS pacientes 
				FROM
					pacientes 
				WHERE
					estatus = 'Activo'
					AND empresa_id = $empresa_id";
		        $result=ejecutar($sql); 
		        $row_protocolo = mysqli_fetch_array($result);
		            extract($row_protocolo);   	
        	?>				
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-4">
                        <div class="icon">
                            <i class="material-icons col-teal">person</i>
                        </div>
                        <div class="content">
                            <div class="text">PACIENTES</div>
                            <div class="number count-to" data-from="0" data-to="<?php echo $pacientes; ?>" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
        	<?php        	
	        	$sql ="
				SELECT
					COUNT(*) AS pacientes 
				FROM
					pacientes 
				WHERE
					estatus = 'Activo' 
					AND YEAR ( f_captura ) >= $anio 
					AND MONTH ( f_captura ) = $mes_ahora
					AND empresa_id = $empresa_id";
		        $result=ejecutar($sql); 
		        $row_protocolo = mysqli_fetch_array($result);
		            extract($row_protocolo);   	
        	?>                
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-4">
                        <div class="icon">
                            <i class="material-icons col-teal">person_add</i>
                        </div>
                        <div class="content">
                            <div class="text">PACIENTES NUEVOS</div>
                            <div class="number count-to" data-from="0" data-to="<?php echo $pacientes; ?>" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
        	<?php        	
	        	$sql ="
	        	SELECT
					COUNT(*) AS pacientes 
				FROM
					pacientes 
				WHERE
					estatus = 'Pendiente'
					AND empresa_id = $empresa_id";
		        $result=ejecutar($sql); 
		        $row_protocolo = mysqli_fetch_array($result);
		            extract($row_protocolo);   	
        	?>	                      
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-4">
                        <div class="icon">
                            <i class="material-icons col-blue">person_outline</i>
                        </div>
                        <div class="content">
                            <div class="text">PACIENTES PENDIENTES</div>
                            <div class="number count-to" data-from="0" data-to="<?php echo $pacientes; ?>" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
        	<?php        	
	        	$sql ="
	        	SELECT
					COUNT(*) AS pacientes 
				FROM
					pacientes 
				WHERE
					estatus = 'Seguimiento'
					AND empresa_id = $empresa_id";
		        $result=ejecutar($sql); 
		        $row_protocolo = mysqli_fetch_array($result);
		            extract($row_protocolo);   	
        	?>	                         
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-4">
                        <div class="icon">
                            <i class="material-icons col-yellow">person_outline</i>
                        </div>
                        <div class="content">
                            <div class="text">PACIENTES SEGUIMIENTO</div>
                            <div class="number count-to" data-from="0" data-to="<?php echo $pacientes; ?>" data-speed="1500" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
                
        	<?php        	
	        	$sql ="
	        	SELECT
					COUNT(*) AS pacientes 
				FROM
					pacientes 
				WHERE
					estatus = 'Confirmado'
					AND empresa_id = $empresa_id";
		        $result=ejecutar($sql); 
		        $row_protocolo = mysqli_fetch_array($result);
		            extract($row_protocolo);   	
        	?>				
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-4">
                        <div class="icon">
                            <i class="material-icons col-green">person_outline</i>
                        </div>
                        <div class="content">
                            <div class="text">PACIENTES CONFIRMADO</div>
                            <div class="number count-to" data-from="0" data-to="<?php echo $pacientes; ?>" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
        	<?php        	
	        	$sql ="
				SELECT
					COUNT(*) AS pacientes 
				FROM
					pacientes 
				WHERE
					estatus = 'No interezado'
					AND empresa_id = $empresa_id";
		        $result=ejecutar($sql); 
		        $row_protocolo = mysqli_fetch_array($result);
		            extract($row_protocolo);   	
        	?>                
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-4">
                        <div class="icon">
                            <i class="material-icons col-red">person_pin</i>
                        </div>
                        <div class="content">
                            <div class="text">PACIENTES NO INTEREZADOS</div>
                            <div class="number count-to" data-from="0" data-to="<?php echo $pacientes; ?>" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
                
        	<?php        	
	        	$sql ="
					SELECT
						COUNT(*) AS tms 
					FROM
						historico_sesion
						INNER JOIN protocolo_terapia ON historico_sesion.protocolo_ter_id = protocolo_terapia.protocolo_ter_id 
					WHERE
						terapia = 'TMS' 
					AND YEAR ( historico_sesion.f_captura ) >= $anio 
					AND MONTH ( historico_sesion.f_captura ) = $mes_ahora
					AND historico_sesion.empresa_id = $empresa_id";
					
		        $result=ejecutar($sql); 
		        $row_protocolo = mysqli_fetch_array($result);
		            extract($row_protocolo);   	
        	?>                         
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-4">
                        <div class="icon">
                            <i class="material-icons col-purple">settings_input_antenna</i>
                        </div>
                        <div class="content">
                            <div class="text">SESIONES TMS MES</div>
                            <div class="number count-to" data-from="0" data-to="<?php echo $tms; ?>" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
       	<?php        	
	        	$sql ="
					SELECT
						COUNT(*) AS tms 
					FROM
						historico_sesion
						INNER JOIN protocolo_terapia ON historico_sesion.protocolo_ter_id = protocolo_terapia.protocolo_ter_id 
					WHERE
						terapia = 'TMS'
						AND historico_sesion.empresa_id = $empresa_id";
		        $result=ejecutar($sql); 
		        $row_protocolo = mysqli_fetch_array($result);
		            extract($row_protocolo);   	
        	?>                         
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-4">
                        <div class="icon">
                            <i class="material-icons col-purple">settings_input_antenna</i>
                        </div>
                        <div class="content">
                            <div class="text">SESIONES TMS TOTAL</div>
                            <div class="number count-to" data-from="0" data-to="<?php echo $tms; ?>" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>                
        	<?php        	
	        	$sql ="
				SELECT
					COUNT(*) AS tdcs 
				FROM
					historico_sesion
					INNER JOIN protocolo_terapia ON historico_sesion.protocolo_ter_id = protocolo_terapia.protocolo_ter_id 
				WHERE
					terapia = 'tDCS'
				AND YEAR ( historico_sesion.f_captura ) >= $anio 
				AND MONTH ( historico_sesion.f_captura ) = $mes_ahora
				AND historico_sesion.empresa_id = $empresa_id";
					
		        $result=ejecutar($sql); 
		        $row_protocolo = mysqli_fetch_array($result);
		            extract($row_protocolo);   	
        	?>                         
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-4">
                        <div class="icon">
                            <i class="material-icons col-deep-purple">settings_input_component</i>
                        </div>
                        <div class="content">
                            <div class="text">SESIONES tDSC DEL MES</div>
                            <div class="number count-to" data-from="0" data-to="<?php echo $tdcs; ?>" data-speed="1500" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>                
        	<?php        	
	        	$sql ="
				SELECT
					COUNT(*) AS tdcs 
				FROM
					historico_sesion
					INNER JOIN protocolo_terapia ON historico_sesion.protocolo_ter_id = protocolo_terapia.protocolo_ter_id 
				WHERE
					terapia = 'tDCS'
					AND historico_sesion.empresa_id = $empresa_id";
					
		        $result=ejecutar($sql); 
		        $row_protocolo = mysqli_fetch_array($result);
		            extract($row_protocolo);   	
        	?>                         
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-4">
                        <div class="icon">
                            <i class="material-icons col-deep-purple">settings_input_component</i>
                        </div>
                        <div class="content">
                            <div class="text">SESIONES tDSC TOTAL</div>
                            <div class="number count-to" data-from="0" data-to="<?php echo $tdcs; ?>" data-speed="1500" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div> 
        	<?php        	
	        	$sql ="
			SELECT 
			    (SELECT COALESCE(SUM(cobros.importe), 0) 
			     FROM cobros 
			     WHERE MONTH(cobros.f_captura) = $mes_ahora 
			     AND YEAR(cobros.f_captura) = $anio 
			     AND cobros.doctor = 'Neuromodulacion GDL'
			     AND cobros.empresa_id = $empresa_id) AS cobros,
					 
			    (SELECT COALESCE(SUM(pagos.importe), 0) 
			     FROM pagos 
			     WHERE MONTH(pagos.f_captura) = $mes_ahora 
			     AND YEAR(pagos.f_captura) = $anio 
			     AND pagos.negocio = 'Neuromodulacion GDL'
			     AND pagos.empresa_id = $empresa_id) AS pagos,
					 
			    (SELECT COALESCE(SUM(cobros.importe), 0) 
			     FROM cobros 
			     WHERE MONTH(cobros.f_captura) = $mes_ahora 
			     AND YEAR(cobros.f_captura) = $anio 
			     AND cobros.doctor = 'Neuromodulacion GDL'
			     AND cobros.empresa_id = $empresa_id)
			    - 
			    (SELECT COALESCE(SUM(pagos.importe), 0) 
			     FROM pagos 
			     WHERE MONTH(pagos.f_captura) = $mes_ahora 
			     AND YEAR(pagos.f_captura) = $anio 
			     AND pagos.negocio = 'Neuromodulacion GDL'
				 AND pagos.empresa_id = $empresa_id) AS diferencia";
				 //echo "$sql";
				$result=ejecutar($sql); 
		        $row_protocolo = mysqli_fetch_array($result);
		            extract($row_protocolo);   	
        	?>				
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-4">
                        <div class="icon">
                            <i class="material-icons col-black">attach_money</i>
                        </div>
                        <div class="content">
                            <div class="text">INGRESOS</div>
                            <div class="number count-to" data-from="0" data-to="<?php echo $cobros; ?>" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
               
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-4">
                        <div class="icon">
                            <i class="material-icons col-red">attach_money</i>
                        </div>
                        <div class="content">
                            <div class="text">EGRESOS</div>
                            <div class="number count-to" data-from="0" data-to="<?php echo $pagos; ?>" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
                        
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-4">
                        <div class="icon">
                            <i class="material-icons col-blue">attach_money</i>
                        </div>
                        <div class="content">
                            <div class="text">DIFERENCIA</div>
                            <div class="number count-to" data-from="0" data-to="<?php echo ($diferencia); ?>" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
        	<?php        	
	        	$sql ="
					SELECT
						min( historico_sesion.tms_d ) AS tms_cnt 
					FROM
						historico_sesion
					WHERE
						historico_sesion.tms_d > 5000
						AND historico_sesion.empresa_id = $empresa_id";
		        $result=ejecutar($sql); 
		        $row_protocolo = mysqli_fetch_array($result);
		            extract($row_protocolo);   	
        	?>                         
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-4">
                        <div class="icon">
                            <i class="material-icons col-black">hourglass_full</i>
                        </div>
                        <div class="content">
                            <div class="text">CONTADOR TMS</div>
                            <div class="number count-to" data-from="0" data-to="<?php echo ($tms_cnt); ?>" data-speed="1500" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>  
        	<?php        	
	        	$sql ="
				SELECT 
				    AVG(difference) AS avg_difference
				FROM (
				    SELECT 
				        tms_d,
				        @prev_value - tms_d AS difference,
				        @prev_value := tms_d AS previous_value
				    FROM 
				        (SELECT tms_d FROM historico_sesion WHERE tms_d >= 21140429 and tms_d <= 24054977  AND empresa_id = $empresa_id ORDER BY tms_d DESC) AS ordered_sessions,
				        (SELECT @prev_value := NULL) AS vars
				) AS differences
				WHERE difference != 0";
				//echo $sql."<hr>";
		        $result=ejecutar($sql); 
		        $row_protocolo = mysqli_fetch_array($result);
		            extract($row_protocolo);   	
        	?>                         
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-4">
                        <div class="icon">
                            <i class="material-icons col-black">hourglass_full</i>
                        </div>
                        <div class="content">
                            <div class="text">PROMEDIO DE PULSOS X SESIÓN</div>
                            <div class="number count-to" data-from="0" data-to="<?php echo ($avg_difference); ?>" data-speed="1500" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>                 
        	<?php        	
	        	$sql ="
					SELECT 
					    AVG(tms) AS avg_monthly_tms
					FROM (
					    SELECT
					        YEAR(historico_sesion.f_captura) AS year,
					        MONTH(historico_sesion.f_captura) AS month,
					        COUNT(*) AS tms
					    FROM
					        historico_sesion
					        INNER JOIN protocolo_terapia ON historico_sesion.protocolo_ter_id = protocolo_terapia.protocolo_ter_id 
					    WHERE
					        terapia = 'TMS' 
					        AND YEAR(historico_sesion.f_captura) >= 2023
					        AND historico_sesion.empresa_id=$empresa_id
					    GROUP BY
					        YEAR(historico_sesion.f_captura),
					        MONTH(historico_sesion.f_captura)
					) AS monthly_counts";
					//echo $sql."<hr>";
		        $result=ejecutar($sql); 
		        $row_protocolo = mysqli_fetch_array($result);
		            extract($row_protocolo);   	
        	?>                         
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-4">
                        <div class="icon">
                            <i class="material-icons col-purple">date_range</i>
                        </div>
                        <div class="content">
                            <div class="text">PROMEDIO MES TMS</div>
                            <div class="number count-to" data-from="0" data-to="<?php echo $avg_monthly_tms; ?>" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
        	<?php        	
  				$sesiones_restantes = $tms_cnt/$avg_difference;
				$mes_restante = $sesiones_restantes/$avg_monthly_tms;
				
        	?>                         
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-4">
                        <div class="icon">
                            <i class="material-icons col-purple">date_range</i>
                        </div>
                        <div class="content">
                            <div class="text">MES RESTANTES</div>
                            <div class="number count-to" data-from="0" data-to="<?php echo $mes_restante; ?>" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
                
            </div>                 
            
             <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div style="height: 95%"  class="header">
                        	<h3 align="center">Dr Aldana</h3>
                    	</div>
                	</div>
            	</div>
        	</div>           

			<div class="row">
        	<?php        	
	        	$sql ="
			SELECT 
			    (SELECT COALESCE(SUM(cobros.importe), 0) 
			     FROM cobros 
			     WHERE MONTH(cobros.f_captura) = $mes_ahora 
			     AND YEAR(cobros.f_captura) = $anio 
			     AND cobros.doctor = 'Dr. Alejandro Aldana'
			     AND cobros.empresa_id = $empresa_id) AS cobros,
					 
			    (SELECT COALESCE(SUM(pagos.importe), 0) 
			     FROM pagos 
			     WHERE MONTH(pagos.f_captura) = $mes_ahora 
			     AND YEAR(pagos.f_captura) = $anio 
			     AND pagos.negocio = 'Dr. Alejandro Aldana'
			     AND pagos.empresa_id = $empresa_id) AS pagos,
					 
			    (SELECT COALESCE(SUM(cobros.importe), 0) 
			     FROM cobros 
			     WHERE MONTH(cobros.f_captura) = $mes_ahora 
			     AND YEAR(cobros.f_captura) = $anio 
			     AND cobros.doctor = 'Dr. Alejandro Aldana'
			     AND cobros.empresa_id = $empresa_id)
			    - 
			    (SELECT COALESCE(SUM(pagos.importe), 0) 
			     FROM pagos 
			     WHERE MONTH(pagos.f_captura) = $mes_ahora 
			     AND YEAR(pagos.f_captura) = $anio 
			     AND pagos.negocio = 'Dr. Alejandro Aldana'
				 AND pagos.empresa_id = $empresa_id) AS diferencia";
				 //echo $sql;
				$result=ejecutar($sql); 
		        $row_protocolo = mysqli_fetch_array($result);
		            extract($row_protocolo);   	
        	?>				
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-4">
                        <div class="icon">
                            <i class="material-icons col-black">attach_money</i>
                        </div>
                        <div class="content">
                            <div class="text">INGRESOS</div>
                            <div class="number count-to" data-from="0" data-to="<?php echo $cobros; ?>" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
               
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-4">
                        <div class="icon">
                            <i class="material-icons col-red">attach_money</i>
                        </div>
                        <div class="content">
                            <div class="text">EGRESOS</div>
                            <div class="number count-to" data-from="0" data-to="<?php echo $pagos; ?>" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
                        
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-4">
                        <div class="icon">
                            <i class="material-icons col-blue">attach_money</i>
                        </div>
                        <div class="content">
                            <div class="text">DIFERENCIA</div>
                            <div class="number count-to" data-from="0" data-to="<?php echo ($diferencia); ?>" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
			</div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div style="height: 95%"  class="header">
                        	<h3 align="center">Dra. Eleonora</h3>
                    	</div>
                	</div>
            	</div>
        	</div>           

			<div class="row">
        	<?php        	
	        	$sql ="
			SELECT 
			    (SELECT COALESCE(SUM(cobros.importe), 0) 
			     FROM cobros 
			     WHERE MONTH(cobros.f_captura) = $mes_ahora 
			     AND YEAR(cobros.f_captura) = $anio 
			     AND cobros.doctor = 'Dra. Eleonora Ocampo'
			     AND cobros.empresa_id = $empresa_id) AS cobros,
					 
			    (SELECT COALESCE(SUM(pagos.importe), 0) 
			     FROM pagos 
			     WHERE MONTH(pagos.f_captura) = $mes_ahora 
			     AND YEAR(pagos.f_captura) = $anio 
			     AND pagos.negocio = 'Dra. Eleonora Ocampo'
			     AND pagos.empresa_id = $empresa_id) AS pagos,
					 
			    (SELECT COALESCE(SUM(cobros.importe), 0) 
			     FROM cobros 
			     WHERE MONTH(cobros.f_captura) = $mes_ahora 
			     AND YEAR(cobros.f_captura) = $anio 
			     AND cobros.doctor = 'Dra. Eleonora Ocampo'
			     AND cobros.empresa_id = $empresa_id)
			    - 
			    (SELECT COALESCE(SUM(pagos.importe), 0) 
			     FROM pagos 
			     WHERE MONTH(pagos.f_captura) = $mes_ahora 
			     AND YEAR(pagos.f_captura) = $anio 
			     AND pagos.negocio = 'Dra. Eleonora Ocampo'
			     AND pagos.empresa_id = $empresa_id) AS diferencia";
				 
				$result=ejecutar($sql); 
		        $row_protocolo = mysqli_fetch_array($result);
		            extract($row_protocolo);   	
        	?>				
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-4">
                        <div class="icon">
                            <i class="material-icons col-black">attach_money</i>
                        </div>
                        <div class="content">
                            <div class="text">INGRESOS</div>
                            <div class="number count-to" data-from="0" data-to="<?php echo $cobros; ?>" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
               
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-4">
                        <div class="icon">
                            <i class="material-icons col-red">attach_money</i>
                        </div>
                        <div class="content">
                            <div class="text">EGRESOS</div>
                            <div class="number count-to" data-from="0" data-to="<?php echo $pagos; ?>" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
                        
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-4">
                        <div class="icon">
                            <i class="material-icons col-blue">attach_money</i>
                        </div>
                        <div class="content">
                            <div class="text">DIFERENCIA</div>
                            <div class="number count-to" data-from="0" data-to="<?php echo ($diferencia); ?>" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
			</div>			
             <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div style="height: 95%"  class="header">
                        	<h3 align="center">Sistemas</h3>
                    	</div>
                	</div>
            	</div>
        	</div>             
			<div class="row">
        	<?php        	
	        	$sql ="
				SELECT
					COUNT(*) as usuarios
				FROM
					admin 
				WHERE
					admin.actividad = 'Activo'
					AND admin.empresa_id = $empresa_id";
		        $result=ejecutar($sql); 
		        $row_protocolo = mysqli_fetch_array($result);
		            extract($row_protocolo);   	
        	?>                
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-4">
                        <div class="icon">
                            <i class="material-icons col-green">person</i>
                        </div>
                        <div class="content">
                            <div class="text">USUARIOS EN LINEA</div>
                            <div class="number count-to" data-from="0" data-to="<?php echo $usuarios; ?>" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>				
        	<?php        	
	        	$sql ="
				SELECT
					COUNT(*) as usuarios
				FROM
					admin 
				WHERE
					admin.estatus = 'Activo'
					AND admin.empresa_id = $empresa_id";
		        $result=ejecutar($sql); 
		        $row_protocolo = mysqli_fetch_array($result);
		            extract($row_protocolo);   	
        	?>				
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-4">
                        <div class="icon">
                            <i class="material-icons col-teal">person_outline</i>
                        </div>
                        <div class="content">
                            <div class="text">USUARIOS ACTIVOS</div>
                            <div class="number count-to" data-from="0" data-to="<?php echo $usuarios; ?>" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>

        	<?php        	
	        	$sql ="
				SELECT
					COUNT(*) as usuarios 
				FROM
					admin 
				WHERE
					admin.estatus = 'Pendiente'	
					AND admin.empresa_id = $empresa_id";
		        $result=ejecutar($sql); 
		        $row_protocolo = mysqli_fetch_array($result);
		            extract($row_protocolo);   	
        	?>	                      
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-4">
                        <div class="icon">
                            <i class="material-icons col-yellow">person_outline</i>
                        </div>
                        <div class="content">
                            <div class="text">SOLICITUDES PENDIENTES</div>
                            <div class="number count-to" data-from="0" data-to="<?php echo $usuarios; ?>" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
        	<?php        	
	        	$sql ="
				SELECT
					COUNT(*) as solicitudes
				FROM
					solicitudes
					WHERE
					estado in('Pendiente','En Proceso')
					AND solicitudes.empresa_id = $empresa_id";
		        $result=ejecutar($sql); 
		        $row_protocolo = mysqli_fetch_array($result);
		            extract($row_protocolo);   	
        	?>	                         
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-4">
                        <div class="icon">
                            <i class="material-icons col-orange">build</i>
                        </div>
                        <div class="content">
                            <div class="text">SOLICITUDES PENDIENTES</div>
                            <div class="number count-to" data-from="0" data-to="<?php echo $solicitudes; ?>" data-speed="1500" data-fresh-interval="20"></div>
                        </div>
                    </div>
            </div>
            </div> 
                
        </div>
    </section>
<?php	include($ruta.'footer.php');	?>