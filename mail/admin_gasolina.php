<?php error_reporting(7); 
    iconv_set_encoding('internal_encoding', 'utf-8'); 
    header('Content-Type: text/html; charset=UTF-8');
    date_default_timezone_set('America/Monterrey');
	
    include ("../funciones/funciones_mysql.php");
    include ("../funciones/funciones.php");     
    
    $conexion = conectar("dish_calidad"); 
	$usuario = $_POST["usuario"];
	$tabla = $_POST["tabla"];
	$sesion = $_POST["sesion"];	
	$bandera = 0;
	$completar = $_POST["completar"];
	if($completar == 1){
		$bandera = $_POST["bandera"];
		$num_eco = $_POST["num_eco"];		
		$f_carga = $_POST["f_carga"];
		$estado = $_POST["estado"];
		$importe = $_POST["importe"];
		$kilometraje = $_POST["kilometraje"];
		$litros = $_POST["litros"];
	} else{
		$num_eco = 0;		
		$f_carga = date('Y-m-d');
		$importe = 0.0;
		$kilometraje = 0.0;
		$litros = 0.0;
	}
		
	if($sesion <> 'On'){ header('Location: ../prueba/index.php'); } else{
/*********************************************************************************************************************************************************************************************************************************/ ?>
<!DOCTYPE html> 
<html> 
	<head> 
		<title>Control de combustible</title> 
		
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1" > 
		
		<link rel="stylesheet" href="../css/jquery.mobile-1.2.0.min.css" />
		<link rel="stylesheet" href="../css/dish_mobile.min.css" /> 
		
		<script src="../js/jquery-1.8.2.min.js"></script>
		<script src="../js/jquery.mobile-1.2.0.min.js"></script>
		
		<script type="text/javascript">
			var x = document.getElementById("demo");
			function getLocation(){
			  if (navigator.geolocation){ navigator.geolocation.watchPosition(showPosition,showError); }
			  else{ x.innerHTML="Este navegador no soporta la Geolocalización."; }
		  	}
			
			function showPosition(position){
		  		var latlon=position.coords.latitude+","+position.coords.longitude;
		  		
		  		var latitud = position.coords.latitude;
			  	var longitud = position.coords.longitude;
			  	var precision = position.coords.accuracy;
			  	
			  	$("#latitud").val(latitud);
			  	$("#longitud").val(longitud);
			  	$("#precision").val(precision);
			
			  	var img_url="http://maps.googleapis.com/maps/api/staticmap?markers="
			  	+latlon+"&zoom=16&size=300x200&sensor=false";
				document.getElementById("mapholder").innerHTML="<img src='"+img_url+"'>";
		  	}
			
			function showError(error){
				switch(error.code){
		    		case error.PERMISSION_DENIED:
			      		x.innerHTML="El usuario denegó la solicitud para la geolocalización.";
			      		break;
			    	case error.POSITION_UNAVAILABLE:
				      	x.innerHTML="La información de la locación no está disponible.";
				      	break;
			    	case error.TIMEOUT:
			      		x.innerHTML="La solicitud para obtener la localización excedió el tiempo de espera.";
			      		break;
			    	case error.UNKNOWN_ERROR:
			      		x.innerHTML="Ocurrió un error desconocido.";
			      		break;
		    	}
		  	}
		</script>
	</head> 

	<body onload="getLocation()"> 
<!--************************************************************************ Inicio de Gasolina **********************************************************************************-->
		<div data-role="page" id="gasolina">
			<div data-role="header" >
				<a href="menu.php" data-icon="home" data-iconpos="notext">Gasolina</a>
				<h1>Control de combustible</h1>
				<a id="back" data-icon="back" data-iconpos="notext">Volver</a>
			</div><!-- /header -->
				
        <!-- Home -->
			<div data-role="content">
				<div id="x"></div>
				<form action="admin_guardar_gasolina.php" method="post" id="guardar_gasolina" enctype="multipart/form-data" data-ajax="false">
		    <? if($bandera == 0){?>  
		    		<input type="hidden" name="usuario" id="usuario" value="<? echo $usuario; ?>" />
    		<?	} else{ ?>
	    			<ul data-role="listview" data-inset="true">
	    				<li><strong>Por favor, capture su usuario.</strong></li>
		    			<li data-role="fieldcontain">
		    				<label for="usuario">Usuario:</label>
							<input type="text" name="usuario" id="usuario" placeholder="Usuario" value="" />
						</li>
					</ul>
    		<?	} ?>
					<input type="hidden" name="tabla" id="tabla" value="<? echo $cartera; ?>" />
					<input type="hidden" name="sesion" id="sesion" value="On" />
					<input type="hidden" name="latitud" id="latitud" value="0.0" />
					<input type="hidden" name="longitud" id="longitud" value="0.0" />
					<input type="hidden" name="precision" id="precision" value="0.0" />
		    		
		    		<ul data-role="listview" data-inset="true">
		    			<li data-role="fieldcontain">
		    				<div data-role="collapsible-set">   	
					            <div data-role="collapsible" data-collapsed="true">
					                <h3>Ubicación registrada</h3>  										
									<div data-role="fieldcontain">			
										<label style=" text-align:center"><h3>Ubicación registrada</h3></label>	
										<div data-role="content">
											<div id="mapholder" style=" text-align:center"></div>
										</div>
									</div>
								</div>	
							</div>
		    			</li>
		    			<li data-role="fieldcontain">
			    			<label for="f_carga">Fecha de la carga:</label>
			                <input type="date" name="f_carga" id="f_carga" style="text-align: right" placeholder="dd/mm/aaaa" value="">
			    		</li>
			    		<li data-role="fieldcontain">
			                <label for="estado">Estado</label>
			                <select id="estado" name="estado" data-native-menu="false">
		               	<? if($completar == 1){ ?> 	
			                	<option value="" disabled="disabled">SELECCIONE EL ESTADO...</option>
	                	<? } else{ ?>
	                			<option value="" disabled="disabled" selected="selected">SELECCIONE EL ESTADO...</option>
	                	<? } $i = 0;
							$sql_estados="SELECT DISTINCT d_estado FROM region_dis WHERE d_estado <> 'SIN IDENTIFICAR' ORDER BY 1 ASC; ";
				   			$result_estados = ejecutar($sql_estados,$conexion);	
							 while($row_edos = mysql_fetch_array($result_estados)){
							 	$i++;
								$xestado = $row_edos["d_estado"];
								if($completar == 1){
									if($xestado == $estado){ ?>
										<option selected="selected"><? echo $xestado; ?></option>
						<?			} else{ ?>
										<option><? echo $xestado; ?></option>
						<?			}
								} else{ ?>
									<option><? echo $xestado; ?></option>
						<?		} ?>
				    			
		    			<? } ?>
			                </select>			                	
			            </li>
		    			<li data-role="fieldcontain">
		    				<label for="num_eco">Num. Economico:</label>
			                <input type="number" name="num_eco" id="num_eco" style=" text-align:right" placeholder="0" value="<? echo $num_eco; ?>" />
		    			</li>
		    			<li data-role="fieldcontain">
		    				<label for="importe">Importe:</label>
			                <input type="text" name="importe" id="importe" style=" text-align:right" placeholder="0.0" value="<? echo $importe; ?>" />
		    			</li>
		    			<li data-role="fieldcontain">
		    				<label for="kilometraje">Kilometraje:</label>
			                <input type="text" name="kilometraje" id="kilometraje" style=" text-align:right" placeholder="0" value="<? echo $kilometraje; ?>" />
		    			</li>
		    			<li data-role="fieldcontain">
		    				<label for="litros">Litros:</label>
		                	<input type="text" name="litros" id="litros" style=" text-align:right" placeholder="0" value="<? echo $litros; ?>" />
		    			</li>
		    			<li data-role="fieldcontain">
		    				<label for="pic_1">Foto de Km. antes:</label>
		    				<input type="file" id="pic_1" name="pic_1" />
		    			</li>
		    			<li data-role="fieldcontain">
		    				<label for="pic_2">Foto de Km. despues:</label>
		    				<input type="file" id="pic_2" name="pic_2" />
		    			</li>
		    			<li data-role="fieldcontain">
		    				<label for="pic_3">Foto de Ticket:</label>
		    				<input type="file" id="pic_3" name="pic_3" />
		    			</li>
		    			<li data-role="fieldcontain">
		    				<input type="submit" data-icon="check" data-iconpos="left" value="Guardar" />
		    			</li>
	    			</ul>
    			</form>
			</div>
 			<div data-role="footer">
				<h5>C.B.D. - Calidad - Dish México 2012</h5>
			</div><!-- /footer -->
        </div>
	</body>
</html>
<? } mysql_close($conexion); ?>