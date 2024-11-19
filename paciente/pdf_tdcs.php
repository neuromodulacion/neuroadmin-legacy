<?php
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

extract($_SESSION);
extract($_GET);
extract($_POST);

include('../functions/funciones_mysql.php');

include('../paciente/calendario.php');

include('../paciente/fun_paciente.php');

//$paciente_id=26;

$sql ="
SELECT
	pacientes.paciente_id, 
	pacientes.usuario_id, 
	CONCAT(pacientes.paciente,' ',pacientes.apaterno,' ',pacientes.amaterno) as paciente, 
	pacientes.email, 
	pacientes.celular, 
	pacientes.f_nacimiento, 
	pacientes.sexo, 
	pacientes.contacto, 
	pacientes.parentesco, 
	pacientes.tel1, 
	pacientes.tel2, 
	pacientes.resumen_caso, 
	pacientes.diagnostico, 
	pacientes.diagnostico2, 
	pacientes.diagnostico3, 
	pacientes.medicamentos, 
	pacientes.f_captura, 
	pacientes.h_captura, 
	pacientes.estatus, 
	pacientes.observaciones, 
	pacientes.notificaciones, 
	pacientes.comentarios_reporte,
	pacientes.tratamiento,
	admin.nombre as medico
FROM
	pacientes
	INNER JOIN
	admin
	ON 
		pacientes.usuario_id = admin.usuario_id
WHERE
		pacientes.paciente_id = $paciente_id";
	//echo $sql;	
    $result=ejecutar($sql); 
    $row = mysqli_fetch_array($result);
    extract($row);	
	//print_r($row);

$terapia = substr($tratamiento, 0, 4);
// echo $terapia."<br>";	
$terapia == "TdCS";

$tabla_lineas ="";
$tabla_header ="";

	if ($terapia == "TDCs ") {
		$tabla_header.="
		<tr>
			<td width='10px'></td>
			<td width='70px'></td>
			<td width='10px'></td>
			<td width='120px' align='center'>FIRMA</td>
			<td width='10px'></td>
			<td width='80px' align='center'>FECHA</td>
			<td width='10px'></td>
			<td width='10px'></td>
			<td width='120px' align='center'>FIRMA</td>
			<td width='10px'></td>
			<td width='80px' align='center'>FECHA</td>
			<td width='10px'></td>	
		</tr>	
		";

	} else {
		$tabla_header.="
		<tr>
			<td width='10px'></td>
			<td width='120px'></td>
			<td width='10px'></td>
			<td width='120px' align='center'>FIRMA</td>
			<td width='10px'></td>
			<td width='80px' align='center'>FECHA</td>
			<td  colspan='6'></td>	
		</tr>	
		";				
	}



for ($i=1; $i <16 ; $i++) { 

$e = $i+15;

	if ($terapia == "TDCs ") {
		$tabla_lineas.="
			<tr>		
				<td width='10px'></td>
				<td>Sesion No. $i</td>
				<td width='10px'></td>
				<td  align='center'><hr></td>
				<td width='10px'></td>
				<td  align='center'><hr></td>			
				<td width='10px'></td>
				<td>Sesíon No.$e</td>
				<td  align='center'><hr></td>
				<td width='10px'></td>
				<td  align='center'><hr></td>
				<td width='10px'></td>																											
			</tr>";	
	} else {	
		$tabla_lineas.="
			<tr>		
				<td width='10px'></td>
				<td>Sesion No. $i</td>
				<td width='10px'></td>
				<td  align='center'><hr></td>
				<td width='10px'></td>
				<td  align='center'><hr></td>			
				<td  colspan='6'></td>																										
			</tr>";			
	}



	
}	
		
$dia = date("d");
$mes = strftime("%B");
$anio = date("Y");    

$header1="
	<table style='width: 100%' >
		<tr>
			<td align='center' style='background: #fff; width: 20%'>
				<img style='width: auto; height: 80px;' src='../$logo' alt='grafica'>					
			</td>
			<td style='background: #fff; width: 65%'>
			<h2 align='center'><strong>NEUROMODULACI&Oacute;N GDL S.A. DE C.V.</strong></h2>	
			</td>
			<td align='center' style='background: #fff; width: 15%'>

			</td>			
		</tr>
	</table>";
$header="
	<table style='width: 100%' >
		<tr>
			<td align='center' style='background: #fff; width: 20%'>
				<img style='width: auto; height: 80px;' src='../$logo' alt='grafica'>					
			</td>
			<td align='center'  style='background: #fff; width: 60%'>
	
			</td>
			<td align='center' style='background: #fff; width: 20%'>

			</td>			
		</tr>
	</table>";	

$footer ="<hr>
	<table style='width: 100%' >
		<tbody>
			<tr>
				<td align='center' style='background: #fff; width: 70%'>
					
				</td>
				<td align='right'  style='background: #fff; width: 30%'>
					<h5 style='color: #005157; '>
					        Tel. 33 3995 9901<br>   
				                 33 3995 9904<br>
				                 33 3470 2176<br>
				      Av. De los Arcos N. 876<br>
				     Col. Jardines del Bosque<br>
				neuromodulacion.gdl@gmail.com<br>
				   www.neuromodulaciongdl.com<br>
					</h5>
				</td>			
			</tr>
		</tbody>
	</table>
";

//$mpdf->SetHTMLHeader($header);
    
$cuerpo_pdf="
<html>
<head>
    <title></title>

</head>
<body style='font-family: Arial, sans-serif; text-align: justify'>
	$header1

<br>
<p><strong>Guadalajara, Jalisco a $dia de $mes del $anio.</strong></p>
<br>
<p><strong>Nombre del paciente:</strong>  $paciente</p>
<br>
<h2  align='center'> <strong>Terapia de Estimulaci&oacute;n Transcraneal de Corriente Directa</strong></h2>
<br>
<p>La TDCs es un procedimiento m&eacute;dico no invasivo y autorizado en varios pa&iacute;ses, incluyendo su aprobaci&oacute;n en Estados Unidos por la FDA (Food and Drug Agency) para el tratamiento de diversos padecimientos. La TDCs es una t&eacute;cnica de estimulaci&oacute;n cerebral que se basa en la generaci&oacute;n de campos magn&eacute;ticos breves por medio de una espiral recubierta por un aislante que se coloca sobre el cuero cabelludo.</p>

<p>Estos campos magn&eacute;ticos son del mismo tipo y potencia que los empleados en las m&aacute;quinas de imagenolog&iacute;a por resonancia magn&eacute;tica (IRM). Los pulsos magn&eacute;ticos generan una corriente el&eacute;ctrica d&eacute;bil en el cerebro que activa en forma breve los circuitos neuronales en el sitio de estimulaci&oacute;n. Se ha demostrado que la TDCs es un procedimiento seguro y bien tolerado que puede ser un tratamiento eficaz para los pacientes.</p>

<p>El beneficio potencial de la TDCs es que puede conducir a mejor&iacute;as en los s&iacute;ntomas de mi condici&oacute;n psiqui&aacute;trica. Comprendo que no todos los pacientes responden igualmente bien a la TDCs. Lo mismo que todas las formas de tratamiento m&eacute;dico, algunos pacientes se recuperan con rapidez, otros se recuperan por un tiempo corto y luego recaen, mientras que otros no logran tener respuesta alguna a la terapia por TDCs.</p>
<br>
<h2>Cl&aacute;usulas</h2>

<p><strong>Primera.</strong> NEUROMODULACI&Oacute;N GDL, S.A. DE C.V. se compromete a brindar el servicio de la(s) sesi&oacute;n(es) de Terapia de Estimulaci&oacute;n Transcraneal de Corriente Directa (TDCs) en el centro destinado para tal fin en un horario de lunes a viernes de 9:00 am a 8:00 pm y s&aacute;bados de 10:00 am a 2:00 pm con previa cita y confirmaci&oacute;n de la disponibilidad para el uso del equipo.</p>

$footer
<pagebreak />
$header
<br>
<p><strong>Segunda. </strong>NEUROMODULACI&Oacute;N GDL, S.A. DE C.V. y EL PACIENTE acuerdan que el precio de la sesi&oacute;n de Terapia de Estimulaci&oacute;n Transcraneal de Corriente Directa (TDCs) se estipulara en la consulta &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;de evaluaci&oacute;n del paciente.</p>

<p><strong>Tercera. </strong>Las partes acuerdan que solo el titular del presente acuerdo podr&aacute; recibir el servicio antes descrito.</p>

<p><strong>Cuarta</strong>. EL PACIENTE comprende y acepta el &ldquo;Consentimiento Informado previo a la Terapia de Estimulación Transcraneal de Corriente Directa (TDCs)&rdquo; que se le entreg&oacute; por el m&eacute;dico explic&aacute;ndole el alcance del tratamiento y posibles efectos secundarios.</p>

<p><strong>Quinta. </strong>EL PACIENTE reconoce y acepta que su inasistencia a la sesi&oacute;n de Terapia de Estimulaci&oacute;n Transcraneal de Corriente Directa (TDCs) no lo exime de las obligaciones contra&iacute;das, adem&aacute;s que se considerar&aacute; c&oacute;mo sesi&oacute;n otorgada.</p>

<p><strong>Sexta. </strong>El PACIENTE acepta que s&oacute;lo cuenta con diez minutos de tolerancia en su cita, y Neuromodulaci&oacute;n GDL, S.A. de C.V. se reserva el derecho de reagendar o de otorgar la sesi&oacute;n.</p>

<p><strong>S&eacute;ptima: </strong>EL PACIENTE se obliga en caso de no poder asistir a su cita, notificar con 24 horas de anticipaci&oacute;n para poder reagendar, sin afectar su tratamiento.</p>

<p><strong>Octava. </strong>Las partes convienen que el(los) pago(s) de la(s) sesi&oacute;n(es) de Terapia de Estimulaci&oacute;n Transcraneal de Corriente Directa (TDCs) <strong>deber&aacute;n ser previos a recibir el servicio</strong>.</p>

<p><strong>Novena</strong>. Las partes no podr&aacute;n ceder los derechos y obligaciones de este acuerdo, en la inteligencia de que solo las obligaciones preimpresas pactadas en este instrumento regir&aacute;n entre las partes.</p>

<p><strong>D&eacute;cima. </strong>En caso de que EL PACIENTE decida no continuar con la sesi&oacute;n(es) de Terapia de Estimulaci&oacute;n Transcraneal de Corriente Directa (TDCs) y haya efectuado alg&uacute;n pago(s) correspondiente (s), &eacute;ste no ser&aacute; reembolsado.</p>

<p><strong>Onceava. </strong>La Terapia de Estimulaci&oacute;n Transcraneal de Corriente Directa (TDCs) requiere de continuidad para su mejor funcionamiento, es as&iacute; que el paciente se compromete a tomar sus sesiones completas en tiempo y forma, de no ser as&iacute; su tratamiento no ser&aacute; el &oacute;ptimo y puede influir en sus resultados.</p>
<p>&nbsp;</p><br>
$footer
<pagebreak />
$header
<p>&nbsp;</p>


<h1>Paquete contratado:</h1>

<p> __________________________________</p>

<p><strong>Cantidad de sesiones:</strong></p>

<p>________________________</p>

<p><strong>Padecimiento:</strong></p>

<p>$diagnostico</p>

<p>&nbsp;</p>

<p><strong>M&eacute;dico tratante:</strong></p>

<p>$medico</p>



<p>Total, a pagar:</p>


<p>________________________</p>


	<table style='width: 100%' >
		<tr>
			<td align='center' style='background: #fff; width: 45%; height: 220px; '>
				<img style=' width: 170px' src='../images/vacio.png' >
				<p style='vertical-align: bottom;'>_____________________________</p> 				
			</td>
			<td align='center'  style='background: #fff; width: 10%'>
	
			</td>
			<td align='center' style='background: #fff; width: 45%; height: 220px;'>
				<img style=' width: 170px' src='../images/firma.png' >
				<p style='vertical-align: bottom;'>_____________________________</p>
			</td>			
		</tr>	
		<tr>
			<td align='center' style='background: #fff; width: 45%'>
				<p>Nombre y firma<br>El paciente</p> 				
			</td>
			<td align='center'  style='background: #fff; width: 10%'>
	
			</td>
			<td align='center' style='background: #fff; width: 45%'>
				<p>Nombre y firma<br>El responsable</p>
			</td>			
		</tr>
	</table>
<br>
$footer
<pagebreak />
$header

<h2 align='center'>Aviso de privacidad<br />
&nbsp;</h2>

<p><strong>DECLARO</strong></p>

<p>Con fundamento en lo dispuesto por los art&iacute;culos 3, fracci&oacute;n I, 15, 40 y 43, fracci&oacute;n III, de la Ley Federal de Protecci&oacute;n de Datos Personales en Posesi&oacute;n de los Particulares y sus correlativos; 23 y 26 de su Reglamento; adem&aacute;s de lo considerado en el art&iacute;culo 16 de la Constituci&oacute;n Pol&iacute;tica de los Estados Unidos Mexicanos en el que se reconoce que toda persona tiene derecho a la Protecci&oacute;n de sus Datos Personales.</p>

<p><strong>Identificaci&oacute;n del responsable</strong></p>

<p>NEUROMODULACION GDL, S.A. DE C.V., el responsable para efectos de la Ley Federal de Protecci&oacute;n de Datos personales en Posesi&oacute;n de los Particulares y sus disposiciones reglamentarias (la &ldquo;Ley de Datos&rdquo;), con domicilio en Av. De los Arcos No. 876, Jardines del Bosque, Guadalajara, Jalisco, C.P. 44520; le informa que tratar&aacute; los datos personales que recabe de Usted con las siguientes:</p>

<p><strong>Finalidades</strong></p>

<p>Brindarle la atenci&oacute;n m&eacute;dica que requiera conforme al Contrato de la Prestaci&oacute;n de Servicios M&eacute;dicos, as&iacute; como a las pol&iacute;ticas, procedimientos, protocolos y dem&aacute;s normatividad institucional de Neuromodulaci&oacute;n GDL, S.A. de C.V.</p>

<p>Con relaci&oacute;n a lo considerado sensible seg&uacute;n lo establece la Ley Federal de Protecci&oacute;n de Datos en Posesi&oacute;n de los Particulares, la informaci&oacute;n necesaria al respecto.</p>

<p>Su informaci&oacute;n personal ser&aacute; utilizada para proveer los servicios de salud que ha solicitado, con fines de diagn&oacute;stico, terap&eacute;utico y de tratamiento m&eacute;dico, sus datos cl&iacute;nicos servir&aacute;n para investigaci&oacute;n, seguimiento, mejora en la calidad del servicio y avances en la medicina, para los fines antes se&ntilde;alados, requerimos obtener los siguientes datos personales:</p>

<p>Nombre completo, direcci&oacute;n, tel&eacute;fono, CURP, corre&oacute; electr&oacute;nico y El tratamiento leg&iacute;timo, controlado e informado de sus Datos Personales es de vital importancia para alcanzar los objetivos de prestaci&oacute;n de servicios de atenci&oacute;n m&eacute;dica, reiteramos nuestro compromiso con la privacidad y a su derecho a la autodeterminaci&oacute;n informativa, por lo que se hace de su conocimiento que los Datos Personales y sensibles que proporcione durante su consulta y atenci&oacute;n, le ser&aacute;n recabados en forma licita y con su </p>
<br>
$footer
<pagebreak />
$header

<p>consentimiento, BAJO LA RESPONSABILIDAD de su m&eacute;dico tratante, EN LOS TERMINOS DEL AVISO DE PRIVACIDAD QUE &Eacute;STE LE PRESENTE con estricto apego a la Ley Federal de Protecci&oacute;n de Datos Personales en Posesi&oacute;n de Particulares y su Reglamento.</p>

<ul>
	<li>Incorporar sus datos a nuestras bases de atenci&oacute;n de pacientes.</li>
	<li>Integrar su expediente cl&iacute;nico.</li>
	<li>Compartir sus datos con su m&eacute;dico tratante y m&eacute;dicos Interconsultantes que indique su m&eacute;dico tratante, quienes son profesionistas independientes de Neuromodulaci&oacute;n GDL y quienes han asumido frente a Usted, la responsabilidad de su diagn&oacute;stico, pron&oacute;stico y tratamiento.</li>
	<li>Subir al sistema de Consulta de Resultados</li>
</ul>

<p><strong>Fines publicitarios</strong></p>

<p>Sus datos personales de contacto (domicilio, tel&eacute;fono y/o correo electr&oacute;nico) pueden llegar a ser empleados para hacerle llegar informaci&oacute;n acerca de las promociones y de las caracter&iacute;sticas de los servicios que ofrece Neuromodulaci&oacute;n GDL, S.A. de C.V</p>

<p>Si usted no desea recibir ning&uacute;n tipo de informaci&oacute;n al respecto o que sus datos no sean utilizados para alguna de las finalidades secundarias, le solicitamos as&iacute; lo informe a este NEUROMODULACI&Oacute;N GDL, S.A. DE C.V., enviando un correo a neuromodulacion.gdl@gmail.com</p>

<p><strong>Datos personales</strong></p>

<p>Para alcanzar las finalidades antes expuestas, se tratar&aacute;n los siguientes datos personales: nombre completo, CURP, domicilio, tel&eacute;fono, correo electr&oacute;nico, estado civil, edad, sexo, nacionalidad, fecha de nacimiento, nombre, domicilio y tel&eacute;fono de alg&uacute;n familiar que designe como familiar responsable y con quien podamos comunicarnos en caso de urgencia. En algunos servicios, tambi&eacute;n se tomar&aacute;n fotograf&iacute;as o videos que se integrar&aacute;n a su expediente cl&iacute;nico, con la finalidad de llevar un registro de su evoluci&oacute;n o del tratamiento.</p>


<p><strong>Datos personales sensibles</strong></p>

<p>A fin de poder brindar la atenci&oacute;n y conforme a la legislaci&oacute;n en salud aplicable, le ser&aacute;n solicitados los datos personales sensibles que se requieran para tal efecto: , estado de salud actual, padecimientos pasados y presentes, antecedentes heredofamiliares, s&iacute;ntomas, antecedentes patol&oacute;gicos relevantes, antecedentes de salud, y en algunos casos, cuando se requiera para su adecuada atenci&oacute;n m&eacute;dica, tambi&eacute;n podr&aacute;n ser tratados datos personales sensibles como su preferencia sexual e informaci&oacute;n gen&eacute;tica (este &uacute;ltimo dato, para estudios de diagn&oacute;stico cl&iacute;nico que usted o su m&eacute;dico tratante hayan solicitado).</p>


$footer
<pagebreak />
$header
<p><strong>Modificaciones al aviso de privacidad:</strong></p>

<p>NEUROMDULACION GDL, S.A. DE C.V., se reserva el derecho de efectuar en cualquier momento modificaciones o actualizaciones al presente aviso de privacidad, lo cual dar&aacute; a conocer de forma personal o bien, por medio de la publicaci&oacute;n de un aviso en lugar visible y/o en la p&aacute;gina de internet&nbsp;www.neuromodulaciongdl.com<br />
&nbsp;</p>

<p><strong>Consentimiento</strong></p>

<p>En caso de que Usted desee revocar o negar su consentimiento para que sus datos personales sean usados para las finalidades secundarias, le solicitamos nos lo haga saber a trav&eacute;s del correo electr&oacute;nico: neuromodulacion.gdl@gmail.com</p>

<p>&nbsp;</p>

<p><strong>Guadalajara, Jalisco a $dia del mes de $mes del $anio.<strong></p>
<br>
<br>
<br>
<br>
<p>$paciente<br><b>Nombre y Firma del Paciente</b></p>

<p>&nbsp;</p>

<p><b>M&eacute;dico tratante:</b><br> $medico</p>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>


$footer
<pagebreak />
$header1

<h2 align='center'><strong>Consentimiento para recibir el tratamiento con TDCs </strong></h2>

<h3>Estimulaci&oacute;n cerebral no invasiva y sus variantes.</h3>

<p>La funci&oacute;n cerebral puede ser modificada mediante la aplicaci&oacute;n de una corriente el&eacute;ctrica d&eacute;bil utilizando electrodos situados sobre el cuero cabelludo. Este tipo de estimulaci&oacute;n cerebral recibe el nombre de Estimulaci&oacute;n El&eacute;ctrica Transcraneal o Estimulaci&oacute;n Cerebral No Invasiva (ECNI).</p>

<p>La TDCs (transcraneal direct current stimulation) o estimulaci&oacute;n transcraneal con corriente continua es un tipo no invasivo de neuroestimulaci&oacute;n que se est&aacute; usando cada d&iacute;a con mayor frecuencia para el tratamiento de trastornos neurol&oacute;gicos y psiqui&aacute;tricos.</p>

<p>Consiste en aplicar peque&ntilde;as corrientes el&eacute;ctricas, generalmente entre 1-2 mA, a trav&eacute;s de unos electrodos dispuestos sobre el cuero cabelludo, empapados en suero salino para favorecer la conducci&oacute;n el&eacute;ctrica. Con la TDCs se incrementa la excitabilidad de las neuronas pr&oacute;ximas al &aacute;nodo o electrodo positivo y se reduce en las pr&oacute;ximas al c&aacute;todo o electrodo negativo. La localizaci&oacute;n de los electrodos, depender&aacute; de las zonas cerebrales a estimular o inhibir.</p>

<p>Aplicada regular y frecuentemente la TDCs consigue incrementar la plasticidad de las redes neuronales.</p>

<h3>Riesgos y complicaciones.</h3>

<p>Despu&eacute;s de varias d&eacute;cadas de uso y cientos de estudios cl&iacute;nicos y experimentales, no se han descrito efectos secundarios relevantes a consecuencia de la TDCs.</p>

<p>Entre los efectos secundarios leves m&aacute;s habituales se encuentran: cosquilleo, sensaci&oacute;n de pinchazo o picor en la zona donde se sit&uacute;a el &aacute;nodo (s&oacute;lo durante la aplicaci&oacute;n del tratamiento); sensaciones visuales (fosfenos) (s&oacute;lo al inicio o final de la sesi&oacute;n).</p>

<p>Entre los efectos secundarios leves, poco frecuentes, se encuentran: enrojecimiento cut&aacute;neo en la zona de aplicaci&oacute;n del &aacute;nodo; ligera sensaci&oacute;n dolorosa bajo la zona de aplicaci&oacute;n, fatiga leve, alteraciones en el sue&ntilde;o en los primeros d&iacute;as, cefalea, mareos leves o desorientaci&oacute;n. Se ha descrito alg&uacute;n caso de &aacute;nimo expansivo.</p>

<p>Todos estos efectos son pasajeros, reversibles y de corta duraci&oacute;n</p>

<p>Se aconseja usarla con precauci&oacute;n en pacientes epil&eacute;pticos.</p>

$footer
<pagebreak />
$header

<p>El&nbsp;TDCs puede ser un tratamiento que potencie la eficacia de otros tratamientos farmacol&oacute;gicos, permitiendo reducir la dosis de los mismos. Tambi&eacute;n tiene un gran potencial en los programas de rehabilitaci&oacute;n neurol&oacute;gica, mejorando y acelerando la recuperaci&oacute;n cl&iacute;nica.</p>

<h3>Aplicaciones de la TDCs</h3>

<p>El TDCs&nbsp;puede proporcionar un alivio para el dolor cr&oacute;nico (migra&ntilde;a, fibromialgia, dolor neurop&aacute;tico, disfunci&oacute;n de la articulaci&oacute;n temporomandibular y dolor p&eacute;lvico), la depresi&oacute;n, el trastorno bipolar, tinnitus, accidente cerebrovascular y las adicciones. El t CS tambi&eacute;n puede mejorar el funcionamiento cognitivo, la memoria y el aprendizaje, trastorno con d&eacute;ficit de atenci&oacute;n con hiperactividad (T AH), especialmente en aquellos con discapacidades.</p>

<p>Muchos de los tratamientos farmacol&oacute;gicos utilizados para el tratamiento del dolor pueden producir efectos secundarios.</p>

<p>La TDCs&nbsp; puede ser una alternativa o un complemento para el tratamiento del dolor, teniendo en cuenta su no invasividad y excelente tolerabilidad.</p>

<p>La TDCs&nbsp; se ha estudiado en varias aplicaciones relacionadas con el dolor como son la migra&ntilde;a, la fibromialgia, el dolor neurop&aacute;tico, el dolor postoperatorio y el dolor de la esclerosis m&uacute;ltiple.</p>

<h3>TDCs&nbsp;y el&nbsp;desempe&ntilde;o cognitivo</h3>

<p>El TDCs&nbsp;mejora el desempe&ntilde;o cognitivo en una gran variedad de tareas, dependiendo del &aacute;rea estimulada y de las necesidades de cada individuo. t CS se ha utilizado para mejorar el lenguaje, la lectura, la habilidad matem&aacute;tica, la resoluci&oacute;n de problemas, la impulsividad, la memoria, la socializaci&oacute;n y la coordinaci&oacute;n.</p>

<p>Las sesiones de tratamiento con TDCs son variables dependiendo el diagn&oacute;stico y el tiempo del curso de la patolog&iacute;a.</p>

<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

$footer
<pagebreak />
$header

<p><b>Responda este cuestionario y firme debajo.</b></p>

<p>&iquest;Est&aacute; usted embarazada?</p>

<p>&iquest;Tiene alg&uacute;n metal magn&eacute;tico en su cabeza?</p>

<p>&iquest;Existe alguna raz&oacute;n por la que no puede pasar por una resonancia magn&eacute;tica?</p>

<p>&iquest;Durmi&oacute; por menos de 4 horas?</p>

<p>&iquest;Ha consumido alcohol durante las &uacute;ltimas 24 horas?</p>

<p>&iquest;Ha consumido alguna sustancia que podr&iacute;a disminuir su umbral motor en las &uacute;ltimas 24 horas?</p>

<p>Si ha respondido SI a alguna de las preguntas anteriores, debe de hac&eacute;rselo saber al responsable de la aplicaci&oacute;n del tratamiento.</p>
<br>
<p>A trav&eacute;s del presente escrito manifiesto que yo:</p>

<p>________________________________________________________________________ acud&iacute; por mi propia voluntad y bajo mi responsabilidad a Neuromodulacion GDL, el d&iacute;a <b>$dia de $mes del $anio </b>, para que con mi consentimiento se me realice la aplicaci&oacute;n de un protocolo de estimulación Transcraneal de Corriente Directa o estimulaci&oacute;n el&eacute;ctrica directa indicada por mi m&eacute;dico tratante. Reconozco que el personal de Neuromodulaci&oacute;n GDL inform&oacute; y asesor&oacute; acerca de la naturaleza del tratamiento, los posibles resultados tras el tratamiento, as&iacute; como&nbsp; tambi&eacute;n se me informo de los y riesgos las consecuencias que puede tener para mi salud este tratamiento.</p>

<p>Asimismo, se me dio la oportunidad de hacer las preguntas que consider&eacute; necesarias, las cuales fueron respondidas a mi entera satisfacci&oacute;n.</p>

<p>Adem&aacute;s, el personal de Neuromodulacion GDL me inform&oacute; el procedimiento de detecci&oacute;n y las molestias derivadas del mismo. Expreso que se aclararon mis dudas y se ampli&oacute; la informaci&oacute;n cuando as&iacute; lo solicit&eacute;, incluso se me comunic&oacute; que tengo el derecho de cambiar de decisi&oacute;n en cualquier momento y manifestarla previo al procedimiento.</p>

<p>A efecto de facilitar mi atenci&oacute;n integral, me comprometo a acudir a revisi&oacute;n m&eacute;dica cuando se me indique, o en el caso de presentar alguna molestia o duda al procedimiento.</p>


$footer
<pagebreak />
$header

<p>Se me inform&oacute; que todos los datos que proporcione a Neuromodulacion GDL ser&aacute;n utilizados de manera estrictamente confidencial y si es mi voluntad se considerar&aacute;n de manera an&oacute;nima.</p>

<p>Acorde con lo anterior, declaro que es mi decisi&oacute;n libre, consciente e informada de aceptar el procedimiento de Estimulación Transcraneal de Corriente Directa □ / Estimulaci&oacute;n Directa Craneal □ a fin de llevar a cabo las acciones m&eacute;dico preventivas requeridas en beneficio de mi salud.</p>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

<br>
<br>
<br>
	<table style='width: 100%' >
		<tr>
			<td align='center' style='background: #fff; width: 45%'>
				<img style=' width: 170px' src='../images/vacio.png' >
				<p>_____________________________</p> 				
			</td>
			<td align='center'  style='background: #fff; width: 10%'>
	
			</td>
			<td align='center' style='background: #fff; width: 45%'>
				<img style=' width: 170px' src='../images/firma.png' >
				<p>_____________________________</p>
			</td>			
		</tr>	
		<tr>
			<td align='center' style='background: #fff; width: 45%'>
				<p>Nombre y firma<br>El paciente</p> 				
			</td>
			<td align='center'  style='background: #fff; width: 10%'>
	
			</td>
			<td align='center' style='background: #fff; width: 45%'>
				<p>Nombre y firma<br>El responsable</p>
			</td>			
		</tr>
	</table>
<br>
<br>
<br>
<br>
$footer
<pagebreak />
$header1 

<table width='100%'>
	<tr>
		<td  align='center' colspan='11'>
			<h2> <b>REGISTRO DE SESIONES APLICADAS </b></h2>
		</td>
	</tr>
	<tr>
		<td align='center' colspan='11'>
			<h3><b>$tratamiento</h3><hr>
		</td>
	</tr>	
	<tr>
		<td colspan='11'>
			<b>PACIENTE:</b> $paciente
		</td>
	</tr>
	<tr>			
		<td colspan='11'>
			<b>PADECIMIENTO:</b> $diagnostico
		</td>
	</tr>
	<tr>		
		<td colspan='11'>
			<b>MEDICO TRATANTE:</b> $medico<hr>
		</td>						
	</tr>

	$tabla_header
	<tr>
		<td colspan='11'>
			<br>
		</td>
	</tr>
	
	$tabla_lineas
	
	<tr>
		<td colspan='11'>
			<br>
		</td>
	</tr>		
	<tr>		
		<td colspan='11'>
			<h3><b>OBSERVACIONES:</b></h3><br><br><br><br>
		</td>						
	</tr>
</table>

$footer
</body>
";




// echo $cuerpo_pdf;
// Require composer autoload
require_once __DIR__ . '/../vendor/autoload.php';
// Create an instance of the class:
$mpdf = new \Mpdf\Mpdf();

// Write some HTML code:
$mpdf->WriteHTML($cuerpo_pdf);

// D descarga
// F guarda
// I imprime

// Output a PDF file directly to the browser
$mpdf->Output('Paciente_'.$paciente_id.'.pdf','I');

?>