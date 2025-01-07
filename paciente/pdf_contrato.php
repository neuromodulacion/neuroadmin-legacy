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
//print_r($_SESSION);
//echo "<hr><br>";
include('../functions/funciones_mysql.php');
include('../functions/functions.php');
include('../paciente/calendario.php');

include('../paciente/fun_paciente.php');

//$paciente_id=26;

$sql ="
SELECT
	pacientes.paciente_id, 
	pacientes.usuario_id, 
	CONCAT(pacientes.paciente,' ',pacientes.apaterno,' ',pacientes.amaterno) as paciente, 
    CONCAT(pacientes.apaterno,' ',pacientes.amaterno) as apellidos, 
    pacientes.paciente as nom_simple,
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


if (strpos($tratamiento, 'tDCS') !== false) {
    $terapia == "tDCS";
    $tratamiento_info ="
        <h2  align='center'> <strong>Terapia de Estimulaci&oacute;n Transcraneal de Corriente Directa</strong></h2>
        <br>
        <p>La TDCs es un procedimiento m&eacute;dico no invasivo y autorizado en varios pa&iacute;ses, incluyendo su aprobaci&oacute;n en Estados Unidos por la FDA (Food and Drug Agency) para el tratamiento de diversos padecimientos. La TDCs es una t&eacute;cnica de estimulaci&oacute;n cerebral que se basa en la generaci&oacute;n de campos magn&eacute;ticos breves por medio de una espiral recubierta por un aislante que se coloca sobre el cuero cabelludo.</p>
        <p>Estos campos magn&eacute;ticos son del mismo tipo y potencia que los empleados en las m&aacute;quinas de imagenolog&iacute;a por resonancia magn&eacute;tica (IRM). Los pulsos magn&eacute;ticos generan una corriente el&eacute;ctrica d&eacute;bil en el cerebro que activa en forma breve los circuitos neuronales en el sitio de estimulaci&oacute;n. Se ha demostrado que la TDCs es un procedimiento seguro y bien tolerado que puede ser un tratamiento eficaz para los pacientes.</p>
        <p>El beneficio potencial de la $terapia es que puede conducir a mejor&iacute;as en los s&iacute;ntomas de mi condici&oacute;n psiqui&aacute;trica. Comprendo que no todos los pacientes responden igualmente bien a la TDCs. Lo mismo que todas las formas de tratamiento m&eacute;dico, algunos pacientes se recuperan con rapidez, otros se recuperan por un tiempo corto y luego recaen, mientras que otros no logran tener respuesta alguna a la terapia por tDCS.</p>";

} elseif (strpos($tratamiento, 'TMS') !== false) {
    $terapia == "EMT";
    $tratamiento_info = "
    <h2  align='center'> <strong>Terapia de Estimulaci&oacute;n Magn&eacute;tica Transcraneal</strong></h2>
    <br>
    <p>La EMT es un procedimiento m&eacute;dico no invasivo y autorizado en varios pa&iacute;ses, incluyendo su aprobaci&oacute;n en Estados Unidos por la FDA (Food and Drug Agency) para el tratamiento de diversos padecimientos. La EMT es una t&eacute;cnica de estimulaci&oacute;n cerebral que se basa en la generaci&oacute;n de campos magn&eacute;ticos breves por medio de una espiral recubierta por un aislante que se coloca sobre el cuero cabelludo.</p>
    <p>Estos campos magn&eacute;ticos son del mismo tipo y potencia que los empleados en las m&aacute;quinas de imagenolog&iacute;a por resonancia magn&eacute;tica (IRM). Los pulsos magn&eacute;ticos generan una corriente el&eacute;ctrica d&eacute;bil en el cerebro que activa en forma breve los circuitos neuronales en el sitio de estimulaci&oacute;n. Se ha demostrado que la EMT es un procedimiento seguro y bien tolerado que puede ser un tratamiento eficaz para los pacientes.</p>
    <p>El beneficio potencial de la $terapia es que puede conducir a mejor&iacute;as en los s&iacute;ntomas de mi condici&oacute;n psiqui&aacute;trica. Comprendo que no todos los pacientes responden igualmente bien a la EMT. Lo mismo que todas las formas de tratamiento m&eacute;dico, algunos pacientes se recuperan con rapidez, otros se recuperan por un tiempo corto y luego recaen, mientras que otros no logran tener respuesta alguna a la terapia por EMT.</p>
    ";
    
} else {
    $terapia == "";
    $tratamiento_info = "";
}


$tabla_lineas ="";
$tabla_header ="";


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
    </tr>";

for ($i=1; $i <16 ; $i++) { 
    $e = $i+15;
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
}
		
$dia = date("d");
$hoy = date('y-m-d');
$mes = obMesActualespaniol($hoy);
$anio = date("Y");    

$header1="
	<table style='width: 100%' >
		<tr>
			<td align='center' style='background: #fff; width: 30%'>
				<img style='width: auto; height: 150px;' src='../$logo' alt='grafica'>					
			</td>
			<td align='center' style='background: #fff; width: 5%'>

			</td>
			<td style='background: #fff; width: 65%'>
			<h3 align='center'><strong>NEUROMODULACI&Oacute;N GDL S.A. DE C.V.</strong></h3>	
			</td>			
		</tr>
	</table>";
$header="
	<table style='width: 100%' >
		<tr>
			<td align='center' style='background: #fff; width: 30%'>
				<img style='width: auto; height: 150px;' src='../$logo' alt='grafica'>					
			</td>
			<td align='center' style='background: #fff; width: 5%'>

			</td>            
			<td style='background: #fff; width: 65%'>
			<h3 align='center'><strong>NEUROMODULACI&Oacute;N GDL S.A. DE C.V.</strong></h3>	
			</td>
			
		</tr>
	</table>";	
/*    $header="
	<table style='width: 100%' >
		<tr>
			<td align='center' style='background: #fff; width: 30%'>
				<img style='width: auto; height: 150px;' src='../$logo' alt='grafica'>					
			</td>
			<td align='center'  style='background: #fff; width: 50%'>
	
			</td>
			<td align='center' style='background: #fff; width: 20%'>

			</td>			
		</tr>
	</table>";*/	

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

<p><strong>Guadalajara, Jalisco a $dia de $mes del $anio.</strong></p>
<p><strong>Nombre del paciente:</strong>  $paciente</p>
$tratamiento_info
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/><br/><br/><br/><br/>
$footer
<pagebreak />
$header
<p><strong>CONTRATO DE PRESTACI&Oacute;N DE SERVICIOS DE NEUROMODULACI&Oacute;N</strong><br />
<strong>NEUROMODULACI&Oacute;N GDL, S.A. DE C.V.</strong></p>

<p><br />
En Guadalajara, Jalisco a $dia de $mes del $anio., las partes:</p>

<ol>
	<li><strong>NEUROMODULACI&Oacute;N GDL, S.A. DE C.V.</strong>, representada por el <strong>Dr. Jes&uacute;s Alejandro Aldana L&oacute;pez</strong>, con domicilio fiscal en <strong>Av. De los Arcos 876, Col. Jardines del Bosque, Guadalajara, Jalisco, C.P. 44520</strong>, RFC: <strong>NGD240109G4A</strong>, y</li>
	<li><strong>EL PACIENTE</strong> (Nombre completo): $paciente<br />
	Domicilio: ___________________________________________________<br />
	RFC (si aplica): ________________________</li>
</ol>

<p>Manifiestan que tienen capacidad legal para obligarse en los t&eacute;rminos de este contrato, conforme al C&oacute;digo Civil vigente y dem&aacute;s leyes aplicables.</p>

<p><strong>DECLARACIONES</strong></p>

<ol>
	<li><strong>NEUROMODULACI&Oacute;N GDL, S.A. DE C.V.</strong> declara:<br />
	a) Ser una persona moral constituida legalmente en M&eacute;xico.<br />
	b) Tener como objeto social la prestaci&oacute;n de servicios de neuromodulaci&oacute;n (EMT y tDCS).<br />
	c) Contar con las licencias y permisos correspondientes (COFEPRIS, aviso de funcionamiento).<br />
	d) Contar con equipo m&eacute;dico certificado y personal capacitado.</li>
	<li><strong>EL PACIENTE</strong> declara:<br />
	a) Que ha sido informado del procedimiento, beneficios y riesgos del tratamiento de neuromodulaci&oacute;n.<br />
	b) Haber firmado el <strong>Consentimiento Informado</strong> previo a la sesi&oacute;n.</li>
</ol>

<hr />
<p><strong>CL&Aacute;USULAS</strong></p>

<p><strong>PRIMERA.- OBJETO DEL CONTRATO.</strong><br />
El presente contrato tiene como objetivo la prestaci&oacute;n de <strong>terapia de neuromodulaci&oacute;n (EMT/tDCS)</strong> en las instalaciones ubicadas en <strong>Av. De los Arcos 876, Col. Jardines del Bosque, Guadalajara, Jalisco</strong>.</p>
<br>
$footer
<pagebreak />
$header
<p><strong>SEGUNDA.- HORARIOS DE SERVICIO.</strong><br />
Las sesiones se ofrecer&aacute;n <strong>de lunes a viernes de 9:00 am a 8:00 pm y s&aacute;bados de 10:00 am a 2:00 pm</strong>, previa cita y confirmaci&oacute;n de disponibilidad.</p>

<p><strong>TERCERA.- PRECIO Y FORMA DE PAGO.</strong><br />
El costo de cada sesi&oacute;n ser&aacute; determinado durante la evaluaci&oacute;n inicial y deber&aacute; ser cubierto <strong>previo a la sesi&oacute;n</strong>, mediante transferencia bancaria o pago en efectivo.</p>

<p><strong>CUARTA.- OBLIGACIONES DEL PACIENTE.</strong></p>

<ol>
	<li>Asistir puntualmente a cada sesi&oacute;n.</li>
	<li>En caso de inasistencia, notificar con al menos <strong>24 horas de anticipaci&oacute;n</strong> para reagendar.</li>
	<li>Aceptar que solo cuenta con <strong>10 minutos de tolerancia</strong> para su cita.</li>
</ol>

<p><strong>QUINTA.- CANCELACIONES Y PENALIZACIONES.</strong></p>

<ol>
	<li>Si <strong>EL PACIENTE</strong> no asiste sin previo aviso, se considerar&aacute; como sesi&oacute;n otorgada.</li>
	<li>En caso de pagos anticipados, no proceder&aacute; el reembolso.</li>
</ol>

<p><strong>SEXTA.- CONSENTIMIENTO INFORMADO.</strong><br />
EL PACIENTE reconoce que ha sido informado por el m&eacute;dico tratante de los alcances, beneficios, riesgos y efectos secundarios posibles del tratamiento, as&iacute; como de la necesidad de continuidad para su eficacia.</p>

<p><strong>S&Eacute;PTIMA.- CONFIDENCIALIDAD.</strong><br />
Toda la informaci&oacute;n m&eacute;dica y personal de <strong>EL PACIENTE</strong> ser&aacute; tratada conforme a la <strong>Ley Federal de Protecci&oacute;n de Datos Personales</strong> y su <strong>Aviso de Privacidad</strong> vigente.</p>

<p><strong>OCTAVA.- NO CESI&Oacute;N DE DERECHOS.</strong><br />
Este contrato es intransferible y personal. Ninguna de las partes podr&aacute; ceder los derechos y obligaciones aqu&iacute; establecidos.</p>

<p><strong>NOVENA.- TERMINACI&Oacute;N ANTICIPADA.</strong><br />
Si <strong>EL PACIENTE</strong> decide interrumpir el tratamiento, <strong>NEUROMODULACI&Oacute;N GDL, S.A. DE C.V.</strong> quedar&aacute; liberada de cualquier responsabilidad respecto a los resultados cl&iacute;nicos.</p>
<br><br>
$footer
<pagebreak />
$header
<p><strong>D&Eacute;CIMA.- JURISDICCI&Oacute;N.</strong><br />
Para la interpretaci&oacute;n y cumplimiento de este contrato, ambas partes se someten a los tribunales de Guadalajara, Jalisco, renunciando a cualquier otro fuero que pudiera corresponderles.</p>
<br><br>
<p><strong>DATOS ESPEC&Iacute;FICOS DEL TRATAMIENTO</strong></p>

<ul>
	<li><strong>Paquete contratado:</strong> _________________________</li>
	<li><strong>Cantidad de sesiones:</strong> _______________________</li>
	<li><strong>Padecimiento:</strong> $diagnostico</li>
	<li><strong>M&eacute;dico tratante:</strong> $medico</li>
	<li><strong>Total a pagar:</strong> ____________________________</li>
</ul>
<br><br><br>
<p>&nbsp;</p>

<p>&nbsp;</p>
	<table style='width: 100%' >
		<tr>
			<td align='center' style='background: #fff; width: 45%; height: 220px;'>
				<img style=' width: 170px' src='../images/firma.png' >
				<p style='vertical-align: bottom;'>_____________________________</p>
			</td>
			<td align='center'  style='background: #fff; width: 10%'>
	
			</td>
			<td align='center' style='background: #fff; width: 45%; height: 220px; '>
				<img style=' width: 170px' src='../images/vacio.png' >
				<p style='vertical-align: bottom;'>_____________________________</p> 				
			</td>		
		</tr>	
		<tr>
			<td align='center' style='background: #fff; width: 45%'>
				<p><em>Representante Legal<br />
			C. Jes&uacute;s Alejandro Aldana L&oacute;pez</em></p>
			</td>        
			<td align='center'  style='background: #fff; width: 10%'>
	
			</td>
			<td align='center' style='background: #fff; width: 45%'>
				<p>$paciente<br /> 
                &ldquo;PACIENTE&rdquo;<br />				
			</td>			
		</tr>
	</table>
$footer
<pagebreak />
$header
<p>En Guadalajara, Jalisco a $dia de $mes del $anio.</p>
<h2><strong><em>AVISO DE PRIVACIDAD.</strong></h2>

<p>El establecimiento de servicios de salud del sector privado denominado &ldquo;<strong>Neuromodulaci&oacute;n GDL Bosque</strong>&rdquo;, a travez de su representante legal C. Jes&uacute;s Alejandro Aldana L&oacute;pez, con domicilio&nbsp; en: Avenida de los Arcos, con n&uacute;mero exterior 876, en la Colonia/Fraccionamiento Jardines del Bosque Centro, del municipio de Guadalajara, Jalisco, C.P. 44520, y&nbsp; quien en adelante ser&aacute; denominado como el &ldquo;Prestador del servicio&rdquo;.</p>

<p>El presente Aviso de Privacidad tiene como prop&oacute;sito informarle sobre el uso, manejo, tratamiento y resguardo que se les dar&aacute; a sus datos personales, en cumplimiento a lo establecido por la Ley Federal de Protecci&oacute;n de Datos Personales en Posesi&oacute;n de los Particulares y su Reglamento.</p>

<p><strong>TRATAMIENTO DE SUS DATOS.</strong></p>

<p>Todos sus datos ser&aacute;n tratados con base en los principios de licitud, consentimiento, informaci&oacute;n, calidad, finalidad, lealtad, proporcionalidad y responsabilidad en t&eacute;rminos de Ley.</p>

<p><strong>DATOS PERSONALES QUE SE RECABAN.</strong></p>

<p>Los datos personales que recabamos de usted a trav&eacute;s de medios electr&oacute;nicos, f&iacute;sicos o por v&iacute;a telef&oacute;nica, de manera verbal y/o escrita, los utilizaremos para los siguientes fines necesarios:</p>

<p><strong>Generales:</strong></p>
<ul>
	<li>Nombre completo del paciente, nombre completo de su c&oacute;nyuge o concubino (a) y/o familiar responsable.</li>
	<li>Edad, tanto la del paciente como la de su c&oacute;nyuge o concubino (a) y/o familiar responsable.</li>
	<li>Fecha de nacimiento, tanto la del paciente como la de su c&oacute;nyuge o concubino (a) y/o familiar responsable.</li>
	<li>Domicilio, tanto la del paciente como la de su c&oacute;nyuge o concubino (a) y/o familiar responsable.</li>
	<li>Correo electr&oacute;nico, del paciente, de su c&oacute;nyuge o concubino (a) y/o familiar responsable.</li>
	<li>Tel&eacute;fono particular, celular y del trabajo.</li>
	<li>Datos Fiscales.</li>
</ul>
<br>
$footer
<pagebreak />
$header

<p><strong>Sensibles:</strong></p>

<ul>
	<li>Atenci&oacute;n m&eacute;dica de primer contacto a padecimientos generales.</li>
	<li>Referencia de padecimientos espec&iacute;ficos.</li>
	<li>Atenci&oacute;n de urgencias m&eacute;dicas.</li>
	<li>Dosis inicial de medicamento para el padecimiento que se presente.</li>
	<li>Aplicaci&oacute;n de medicamentos bajo prescripci&oacute;n y receta m&eacute;dica.</li>
	<li>Orientaci&oacute;n y asesor&iacute;a m&eacute;dica.</li>
	<li>Creaci&oacute;n, estudio, an&aacute;lisis, actualizaci&oacute;n, y conservaci&oacute;n del expediente de pacientes.</li>
	<li>Estudios, registros, estad&iacute;sticas y an&aacute;lisis de informaci&oacute;n de salud.</li>
	<li>Contacto con usted para concertar citas, as&iacute; como informarle de cambios de fecha, horario y ubicaci&oacute;n de las consultas m&eacute;dicas, cuidados del paciente, proporcionar informaci&oacute;n sobre ex&aacute;menes m&eacute;dicos practicados, ampliar informaci&oacute;n sobre su padecimiento, y/o evaluar la calidad del servicio brindado.</li>
	<li>Conservaci&oacute;n de registros para seguimiento a consultas y padecimientos.</li>
	<li>Obtenci&oacute;n de signos vitales.</li>
</ul>

<p>Adicionalmente, la lista de datos personales sensibles necesarios que podremos tratar y/o transmitir, que requieren especial protecci&oacute;n consisten en:</p>
<ul>
	<li>Padecimiento actual.</li>
	<li>Antecedentes heredo-familiares</li>
	<li>Antecedentes personales no patol&oacute;gicos</li>
	<li>Antecedentes personales patol&oacute;gicos</li>
	<li>Tratamientos m&eacute;dicos y/o quir&uacute;rgicos</li>
	<li>Tipo de Sangre.</li>
	<li>Resultados sobre pruebas de enfermedades infecto-contagiosas</li>
	<li>Estado de salud actual y padecimientos anteriores.</li>
	<li>Resultados sobre an&aacute;lisis y pruebas de laboratorio y/o rayos x</li>
	<li>Consumo de sustancias enervantes y/o psicotr&oacute;picos.</li>
	<li>Consumo de bebidas alcoh&oacute;licas.</li>
	<li>Somatometr&iacute;a.</li>
</ul>
<br><br><br>
$footer
<pagebreak />
$header

<p><strong>TODO LO ANTERIOR SE RECABA CON LA FINALIDAD DE PROVEER LOS SERVICIOS DE SALUD QUE SE HAN SOLICITADO CON LAS POSIBLES DIVERSAS FINALIDADES DE DIAGN&Oacute;STICO, TRATAMIENTO M&Eacute;DICO, TERAP&Eacute;UTICOS O DE SEGUIMIENTO M&Eacute;DICO; AS&Iacute; COMO&nbsp; TAMBI&Eacute;N PUEDEN SER UTILIZADOS PARA FINES DE INVESTIGACI&Oacute;N CIENT&Iacute;FICA, APORTACIONES AL AVANCE DE LA MEDICINA Y PARA MEJORAMIENTO DE LA CALIDAD DE LOS SERVICIOS PRESTADOS.</strong></p>


<p><strong>VERACIDAD Y PRECISI&Oacute;N DE LOS DATOS.</strong></p>


<p>El &ldquo;Prestador del servicio&rdquo; no es responsable de la veracidad ni la precisi&oacute;n de los datos personales y/o datos sensibles que usted nos proporciona, ya que los mismos no han sido previamente validados y/o verificados.</p>

<p><strong>PROTECCI&Oacute;N Y RESGUARDO DE DATOS.</strong></p>

<p>El &ldquo;Prestador del servicio&rdquo;, implementar&aacute; las medidas de seguridad, t&eacute;cnicas, administrativas y f&iacute;sicas, necesarias para procurar la integridad de sus datos personales y evitar su da&ntilde;o, p&eacute;rdida, alteraci&oacute;n, destrucci&oacute;n o el uso, acceso o tratamiento no autorizado.</p>
<p><strong>TRANSFERENCIA DE DATOS PERSONALES. </strong></p>
<p>Se informa que no realizar&aacute;n transferencias que requieran su consentimiento, salvo aquellas que sean necesarias para atender requerimientos de informaci&oacute;n de una autoridad competente, debidamente fundados y motivados.</p>
<p>El &ldquo;Prestador del servicio&rdquo; &uacute;nicamente podr&aacute; transferir sus datos personales en los casos espec&iacute;ficamente previstos en la Ley, as&iacute; como a instituciones m&eacute;dicos u hospitales p&uacute;blicos o privados, m&eacute;dicos particulares, cuando el paciente amerite un traslado para su atenci&oacute;n integral.</p>
<p><strong>CONSENTIMIENTO PARA LA TOMA Y USO DE FOTOGRAF&Iacute;AS Y VIDEO</strong></p>
<p>Al firmar este documento, SE OTORGA su consentimiento para una posible toma de fotograf&iacute;as del &aacute;rea intervenida a lo largo de los procedimientos. Dichas fotograf&iacute;as, en el caso de ser tomadas, le ser&aacute; informado y permitir&aacute;n no solamente evidenciar los avances de su tratamiento, sino tambi&eacute;n llevar a cabo valoraciones m&eacute;dicas para su beneficio personal. </p>

$footer
<pagebreak />
$header
<p>Cabe mencionar que dichas fotos pueden ser utilizadas no solamente para fines m&eacute;dicos, sino tambi&eacute;n para fines de investigaci&oacute;n, de educaci&oacute;n y de publicidad. En caso de que no desee que sus fotograf&iacute;as sean utilizadas para alguno de estos fines, o bien, desea que sean editadas para ocultar su identidad en caso necesario, favor de indicarlo al personal m&eacute;dico.</p>


<p><strong>CAMBIOS AL AVISO DE PRIVACIDAD.</strong></p>

<p>El presente Aviso de Privacidad puede sufrir modificaciones, cambios o actualizaciones en cualquier momento, derivadas de nuevos requerimientos legales; de nuestras propias necesidades por la atenci&oacute;n m&eacute;dico que se le proporciona; de nuestras</p>

<p>pr&aacute;cticas de privacidad; de cambios de modelo de negocio; o por otras causas, por lo que el &ldquo;Prestador del servicio&rdquo; se reserva el derecho de realizar los cambios o modificaciones sin necesidad de notificarle al paciente.</p>

<p><strong>&iquest;D&Oacute;NDE PUEDO EJERCER MIS DERECHOS ARCO? </strong></p>

<p>Usted podr&aacute; ejercer sus derechos de acceso, rectificaci&oacute;n, cancelaci&oacute;n u oposici&oacute;n de sus datos personales (derechos ARCO) mediante solicitud que se haga directamente a la direcci&oacute;n de correo electr&oacute;nico: <a href='mailto:neuromodulacion.gdl@gmail.com'>neuromodulacion.gdl@gmail.com</a>&nbsp; acorde a lo siguiente:</p>

<p>Los requisitos que debe cumplir su solicitud son:</p>

<ol>
	<li>El nombre del titular y su domicilio o cualquier otro medio para recibir notificaciones;</li>
	<li>Los documentos que acrediten la identidad del titular, y en su caso, la personalidad e identidad de su representante;</li>
	<li>De ser posible, el &aacute;rea responsable que trata los datos personales;</li>
	<li>La descripci&oacute;n clara y precisa de los datos personales respecto de los que se busca ejercer alguno de los derechos ARCO, salvo que se trate del derecho de acceso;</li>
	<li>La descripci&oacute;n del derecho ARCO que se pretende ejercer, o bien, lo que solicita el titular; y</li>
	<li>Cualquier otro elemento o documento que facilite la localizaci&oacute;n de los datos personales, en su caso.</li>
</ol>

<br><br><br><br>
$footer
<pagebreak />
$header

<p>En caso de solicitar la rectificaci&oacute;n, adicionalmente deber&aacute; indicar las modificaciones a realizarse y aportar la documentaci&oacute;n oficial necesaria que sustente su petici&oacute;n. En el derecho de cancelaci&oacute;n debe expresar las causas que motivan la eliminaci&oacute;n. Y en el derecho de oposici&oacute;n debe se&ntilde;alar los motivos que justifican se finalice el tratamiento de los datos personales y el da&ntilde;o o perjuicio que le causar&iacute;a, o bien, si la oposici&oacute;n es parcial, debe indicar las finalidades espec&iacute;ficas con las que se no est&aacute; de acuerdo, siempre que no sea un requisito obligatorio.</p>


<p>Es importante que el paciente tenga en cuenta, que no en todos los casos podremos atender su solicitud o concluir el uso de forma inmediata, ya que es posible que por alguna obligaci&oacute;n legal se requiera seguir tratando sus datos personales. As&iacute; tambi&eacute;n, para el caso de que la solicitud no cuente con los requisitos antes se&ntilde;alados, no se le podr&aacute; dar tr&aacute;mite a su solicitud, por cuestiones de seguridad.</p>
<br><br><br><br><br><br><br><br><br>

	<table style='width: 100%' >
		<tr>
			<td align='center' style='background: #fff; width: 45%; height: 220px;'>
				<img style=' width: 170px' src='../images/firma.png' >
				<p style='vertical-align: bottom;'>_____________________________</p>
			</td>
			<td align='center'  style='background: #fff; width: 10%'>
	
			</td>
			<td align='center' style='background: #fff; width: 45%; height: 220px; '>
				<img style=' width: 170px' src='../images/vacio.png' >
				<p style='vertical-align: bottom;'>_____________________________</p> 				
			</td>		
		</tr>	
		<tr>
			<td align='center' style='background: #fff; width: 45%'>
				<p><em>Representante Legal<br />
			C. Jes&uacute;s Alejandro Aldana L&oacute;pez</em></p>
			</td>        
			<td align='center'  style='background: #fff; width: 10%'>
	
			</td>
			<td align='center' style='background: #fff; width: 45%'>
				<p>$paciente<br /> 
                &ldquo;PACIENTE&rdquo;<br />				
			</td>			
		</tr>
	</table>
$footer
<pagebreak />
$header
<h2><strong>ACUERDO DE CONFIDENCIALIDAD QUE CELEBRAN:</strong></h2>

<ol>
	<li>El establecimiento de servicios de salud del sector privado denominado &ldquo;<strong>Neuromodulaci&oacute;n GDL Bosque</strong>&rdquo;, a travez de su representante legal C. Jes&uacute;s Alejandro Aldana L&oacute;pez, con domicilio&nbsp; en: Avenida de los Arcos, con n&uacute;mero exterior 876, en la Colonia/Fraccionamiento Jardines del Bosque Centro, del municipio de Guadalajara, Jalisco, C.P. 44520, y&nbsp; quien en adelante ser&aacute; denominado como el &ldquo;Prestador del servicio&rdquo;.</li>
    <li>El (la) $paciente, en su calidad de &ldquo;Paciente&rdquo; (en caso de impedimento del paciente, suscribe su c&oacute;nyuge, concubina, familiar o responsable), con domicilio en ____________________________________________________________________________________________________.</li>
    <li>Las partes, cuentan con capacidad legal para contratar y obligarse en los t&eacute;rminos del presente instrumento.</li>
    <li>Que es su deseo celebrar el presente ACUERDO DE CONFIDENCIALIDAD, por lo que manifiestan expresamente su voluntad de contratar, adem&aacute;s se&ntilde;alan que no existe vicio alguno de consentimiento, error, dolo o violencia y que la suscripci&oacute;n del mismo se encuentra basada en la legalidad, honradez y buena fe de ambas partes.</li>
</ol>
<p>Expuesto lo anterior, las partes que sujetan a las siguientes cl&aacute;usulas:</p>


<h2><strong>C L &Aacute; U S U L A S:</strong></h2>

<p><strong>PRIMERA.- INFORMACI&Oacute;N CONFIDENCIAL.</strong> Para los prop&oacute;sitos del presente ACUERDO, Informaci&oacute;n Confidencial significa: toda aquella informaci&oacute;n que surja de la relaci&oacute;n &ldquo;Prestador del servicio&rdquo; &ndash; &ldquo;Paciente&rdquo;, como lo es: atenci&oacute;n m&eacute;dica, padecimientos espec&iacute;ficos, atenci&oacute;n de urgencias m&eacute;dicas, dosis de medicamentos para el padecimiento que se presente, aplicaci&oacute;n de medicamentos bajo prescripci&oacute;n y receta m&eacute;dica, orientaci&oacute;n y asesor&iacute;a m&eacute;dica, el expediente de pacientes, estudios, registros, estad&iacute;sticas y an&aacute;lisis de informaci&oacute;n de salud, n&uacute;meros de contacto con el &ldquo;Paciente&rdquo;, citas, cambios de fecha, horario y ubicaci&oacute;n de las consultas m&eacute;dicas, cuidados del paciente, informaci&oacute;n sobre ex&aacute;menes m&eacute;dicos practicados, padecimiento, y/o evaluar la calidad del servicio brindado, registros para seguimiento a consultas y padecimientos, signos vitales, padecimiento actual, antecedentes heredo-familiares, antecedentes personales no patol&oacute;gicos, antecedentes personales patol&oacute;gicos, tratamientos m&eacute;dicos y/o quir&uacute;rgicos, tipo de sangre, resultados sobre pruebas de enfermedades infecto-contagiosas, estado de salud actual y padecimientos anteriores,
</p>
$footer
<pagebreak />
$header
<p>resultados sobre an&aacute;lisis y pruebas de laboratorio y/o rayos x, consumo de sustancias enervantes y/o psicotr&oacute;picos, consumo de bebidas alcoh&oacute;licas, somatometr&iacute;a, etc&eacute;tera. Lo anterior, con la &uacute;nica reserva que al respecto se&ntilde;alan las Leyes Sanitarias del pa&iacute;s.</p>
<br>
<p><strong>SEGUNDA. - TITULARIDAD DE LA INFORMACI&Oacute;N.</strong> Expresamente reconocen las partes, que la Informaci&oacute;n Confidencial que han recibido y seguir&aacute;n recibiendo, as&iacute; como la que se obtenga o produzca derivado de la relaci&oacute;n &ldquo;Prestador del servicio&rdquo; &ndash; &ldquo;Paciente&rdquo;, no resulta evidente ni es del dominio p&uacute;blico, por lo que constituye propiedad o titularidad del &ldquo;Paciente&rdquo; y tiene un valor significativo para el mismo.</p>
<br>
<p><strong>TERCERA. - UTILIZACI&Oacute;N DE INFORMACI&Oacute;N.</strong> El &ldquo;Paciente&rdquo; reconoce que la informaci&oacute;n que le ha proporcionado el &ldquo;Prestador del servicio&rdquo;, es derivada de la atenci&oacute;n m&eacute;dica, por lo que se obliga a utilizar esa informaci&oacute;n en beneficio propio, siendo &uacute;nico responsable del cumplimiento u omisi&oacute;n que haga respecto a la informaci&oacute;n proporcionada por el &ldquo;Prestador del servicio&rdquo;, y &eacute;sta a su vez, utilizar&aacute; la informaci&oacute;n proporcionada por el &ldquo;Paciente&rdquo;, para proveer la atenci&oacute;n m&eacute;dica bajo los principios Bio&eacute;ticos.</p>
<br>
<p><strong>CUARTA. - VERACIDAD DE LA INFORMACI&Oacute;N.</strong> El &ldquo;Paciente&rdquo; reconoce que, todo lo manifestado al &ldquo;Prestador del servicio&rdquo; en o para la consulta, as&iacute; como los documentos, resultados de laboratorio y dem&aacute;s elementos proporcionados al&nbsp; &ldquo;Prestador del servicio&rdquo; son verdaderos. El &ldquo;Prestador del servicio&rdquo; no es responsable de la veracidad ni la precisi&oacute;n de la informaci&oacute;n proporcionada por el &ldquo;Paciente&rdquo;, ya que los mismos no han sido previamente validados y/o verificados. Asimismo, el &ldquo;Prestador del servicio&rdquo; no es responsable por la informaci&oacute;n que oculte u omita proporcionar el &ldquo;Paciente&rdquo;.</p>
<br>
$footer
<pagebreak />
$header
<p><strong>QUINTA. - LIBERACIÓN DE OBLIGACIONES.</strong> El “Prestador del servicio” quedará liberada de sus obligaciones en los siguientes casos:</p>

<ol style='list-style-type: upper-alpha;'>
    <li>Cuando el “Paciente”, consienta en firmar un escrito en el cual autorice al “Prestador del servicio” a revelar cualquier información confidencial.</li>
    <li>Cuando sea necesaria para atender requerimientos de información de una autoridad competente, debidamente fundados y motivados.</li>
    <li>En los casos específicamente previstos en la Ley, así como a instituciones médicas u hospitales públicos o privados, médicos particulares, cuando el “Paciente” amerite un traslado para su atención integral.</li>
</ol>
<br>

<p><strong>SEXTA.- VIGENCIA.</strong> Este ACUERDO tendr&aacute; una vigencia forzosa para ambas partes, misma que comenzar&aacute; a partir de la fecha de firma del presente y terminar&aacute; cinco a&ntilde;os despu&eacute;s de que haya finalizado el acto m&eacute;dico. Una vez transcurrido el t&eacute;rmino de vigencia del presente ACUERDO, las obligaciones aqu&iacute; contra&iacute;das se tendr&aacute;n por finalizadas, sin necesidad de constancia alguna.</p>
<br>
<p><strong>S&Eacute;PTIMA.- DA&Ntilde;OS Y PERJUICIOS.</strong> Los da&ntilde;os y perjuicios ocasionados por el incumplimiento a este ACUERDO, ser&aacute;n cubiertos y pagados por quien resulte responsable del incumplimiento.</p>
<br>
<p><strong>OCTAVA.- ALCANCE DE LOS T&Iacute;TULOS DE LAS CL&Aacute;USULAS.</strong> Las partes establecen que lo establecido en el presente ACUERDO expresa todo lo acordado por las partes y que los t&iacute;tulos de cada cl&aacute;usula &uacute;nicamente fueron establecidos para facilitar la lectura del ACUERDO,&nbsp; por lo que se debe de estar a lo expresamente acordado por las partes en el clausulado respectivo.</p>
<br>
<p><strong>NOVENA.- MODIFICACIONES AL ACUERDO.</strong> Cualquier modificaci&oacute;n que las partes deseen realizar al contenido del presente ACUERDO, deber&aacute; efectuarse mediante acuerdo realizado por escrito y firmado por ambas partes.</p>
<br><br>
$footer
<pagebreak />
$header
<p><strong>D&Eacute;CIMA.- DOMICILIOS CONVENCIONALES.</strong> Las partes se&ntilde;alan como domicilios convencionales para recibir todo tipo de documentos, notificaciones y dem&aacute;s comunicaciones los se&ntilde;alados en el cap&iacute;tulo de declaraciones de este instrumento.</p>
<br>
<p><strong>D&Eacute;CIMA PRIMERA.- JURISDICCI&Oacute;N.</strong> Para la interpretaci&oacute;n, cumplimiento y ejecuci&oacute;n del presente ACUERDO, las partes convienen en someterse expresamente a las Leyes y Tribunales con jurisdicci&oacute;n en Guadalajara, Jalisco, haciendo renuncia expresa de cualquier otro fuero que pudiere corresponderles por raz&oacute;n de su domicilio presente o futuro, o que por cualquier otra raz&oacute;n pudiera llegar a corresponderles.</p>
<br>
<p>Le&iacute;do que fue el presente CONFIDENCIALIDAD por las partes y enterados de su alcance, responsabilidades y efectos legales lo firman de conformidad por duplicado en la Guadalajara, Jalisco a $dia de $mes del $anio.</p>
<br>
	<table style='width: 100%' >
		<tr>
			<td align='center' style='background: #fff; width: 45%; height: 220px;'>
				<img style=' width: 170px' src='../images/firma.png' >
				<p style='vertical-align: bottom;'>_____________________________</p>
			</td>
			<td align='center'  style='background: #fff; width: 10%'>
	
			</td>
			<td align='center' style='background: #fff; width: 45%; height: 220px; '>
				<img style=' width: 170px' src='../images/vacio.png' >
				<p style='vertical-align: bottom;'>_____________________________</p> 				
			</td>		
		</tr>	
		<tr>
			<td align='center' style='background: #fff; width: 45%'>
				<p><em>Representante Legal<br />
			C. Jes&uacute;s Alejandro Aldana L&oacute;pez</em></p>
			</td>        
			<td align='center'  style='background: #fff; width: 10%'>
	
			</td>
			<td align='center' style='background: #fff; width: 45%'>
				<p>$paciente<br /> 
                &ldquo;PACIENTE&rdquo;<br />				
			</td>			
		</tr>
	</table>

<p>&nbsp;</p>

<p>&nbsp;</p>


$footer
<pagebreak />
$header
<h2><strong>CARTA DE CONSENTIMIENTO V&Aacute;LIDAMENTE INFORMADO&nbsp;</strong></h2>

<p>Apellidos: <strong>$apellidos</strong> &nbsp; Nombre: <strong>$nom_simple</strong> &nbsp; Edad:_____________.</p>


<p>Sexo:&nbsp; $sexo</p>

<p>Fecha:&nbsp;&nbsp;&nbsp;&nbsp; _________________. Horario: &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ___.</p>

<p>En el establecimiento de servicios de salud del sector privado denominado Neuromodulaci&oacute;n GDL, S.A. DE C.V., ubicado en: Avenida de los Arcos, con n&uacute;mero exterior 876, en la Colonia/Fraccionamiento Jardines del Bosque Centro, del municipio de Guadalajara, Jalisco, C.P. 44520.</p>

<p><strong>Acto autorizado: ESTIMULACI&Oacute;N MAGN&Eacute;TICA TRANSCRANEAL.</strong></p>

<p>(EL/LA)C:</p>

<p>______________________________________________________________,</p>

<p>Declaro que voluntariamente he acudido a este establecimiento de Neuromodulaci&oacute;n GDL S.A. DE C.V., donde el responsable del centro {<strong>Dr. Alan Hinojosa God&iacute;nez</strong>}, m&eacute;dico con c&eacute;dula profesional {<strong>######</strong>}, me ha explicado en qu&eacute; consiste el procedimiento m&eacute;dico de estimulaci&oacute;n magn&eacute;tica transcraneal; as&iacute; como el objetivo, los resultados esperados, posibles reacciones, riesgos o complicaciones de este, as&iacute; como beneficios esperados y tratamientos alternativos.</p>

<p>Comprendo que el procedimiento m&eacute;dico autorizado consiste en: un tratamiento m&eacute;dico realizado por cl&iacute;nicos capacitados, en el cual se utiliza un aparato o dispositivo m&eacute;dico que cuenta con diferentes componentes, entre los m&aacute;s importantes, una bobina. En general, este aparato tiene la funci&oacute;n de generar un campo magn&eacute;tico que termina produciendo un campo el&eacute;ctrico en la zona cerebral en donde se posiciona su bobina.</p>

<p>Para comenzar a tratar con este aparato se debe determinar el umbral motor, es decir,&nbsp; la dosis del campo magn&eacute;tico. Este par&aacute;metro es determinado espec&iacute;ficamente con cada paciente.</p>

<p>Se realiza al implementar un pulso magn&eacute;tico sobre la corteza motora, determinando cu&aacute;nta energ&iacute;a se necesita para generar una corriente el&eacute;ctrica dentro de esta. Esta es la cantidad necesaria para que el aparato de TMS produzca un movimiento en sus dedos.</p>

$footer
<pagebreak />
$header

<p>El m&eacute;dico tomar&aacute; la bobina que emite el pulso magn&eacute;tico sobre la cabeza del paciente mientras que una serie de pulsos (no m&aacute;s r&aacute;pidos que un pulso por segundo) ser&aacute; emitida hasta que los dedos de la mano contralateral de donde se est&aacute; aplicando realicen un movimiento. Durante este proceso, el &uacute;nico efecto que el paciente podr&aacute; notar es un sonido de &ldquo;clic&rdquo; cuando los pulsos se est&eacute;n emitiendo.</p>

<p>Como paciente podr&eacute; elegir utilizar tapones de los o&iacute;dos durante este proceso y todo su tratamiento para proteger su audici&oacute;n. Si los impulsos por serie de su protocolo son mayores a un pulso por segundo es recomendable usar estos tapones por comodidad y seguridad.</p>

<p>El paciente se debe de mantener despierto durante el tratamiento completo de estimulaci&oacute;n magn&eacute;tica transcraneal. Si surgen efectos indeseables durante el tratamiento, este puede ser pausado en cualquier momento sin consecuencias en sus efectos.</p>

<p>Se me ha explicado que bajo dicho procedimiento los posibles riesgos, complicaciones o reacciones secundarias al tratamiento pueden ser los siguientes: sensaci&oacute;n de golpeteo en la zona del tratamiento, espasmos faciales o sensaci&oacute;n de&nbsp; dolor en el sitio del tratamiento mientras se enciende la espiral magn&eacute;tica; de igual forma se han reportado por otros pacientes la aparici&oacute;n de dolores de cabeza y en casos muy poco habituales se han reportado episodios de convulsiones.</p>

<p>Cerca de un tercio de los pacientes ha informado sobre este tipo de sensaciones, por lo que comprendo que debo informar al personal m&eacute;dico si esto ocurre para que el personal m&eacute;dico encargado del tratamiento pueda ajustar los valores de estimulaci&oacute;n o hacer cambios en el sitio de colocaci&oacute;n de la espiral con el fin de ayudar a hacer que el procedimiento sea m&aacute;s c&oacute;modo para m&iacute;.</p>

<p>El riesgo m&aacute;s grave conocido de la EMT es la producci&oacute;n de una convulsi&oacute;n. Aunque ha habido algunos informes sobre casos de ataques con el uso de dispositivos de EMT, el riesgo es tambi&eacute;n peque&ntilde;o en extremo, y no se han conocido casos de convulsiones con el uso de este dispositivo particular de EMT. No obstante, se me ha explicado que si presento antecedentes de alg&uacute;n trastorno convulsivo, debo informar de forma inmediata al personal m&eacute;dico del establecimiento, ya que esto podr&iacute;a influir en mi riesgo particular de desarrollar convulsiones con este procedimiento; a&uacute;n cuando el personal c&iacute;nico siga los lineamientos de seguridad actualizados para el uso de EMT dise&ntilde;ados para minimizaci&oacute;n de riesgos convulsivos con esta t&eacute;cnica.</p>
<br><br><br>
$footer
<pagebreak />
$header
<p>En cuanto al uso de &eacute;sta t&eacute;cnica para el tratamiento de la depresi&oacute;n, se me ha informado de que no es eficaz para todos los pacientes, por lo que, cualquier signo o s&iacute;ntoma de empeoramiento debe informarse de inmediato al Doctor y de que es posible que necesite pedir a un familiar o cuidador que vigile los s&iacute;ntomas para ayudar a detectar cualquier signo de empeoramiento de la depresi&oacute;n.</p>


<p>No se han reportado efectos adversos cognitivos (pensamiento y memoria) asociados con la terapia de EMT.</p>

<p>He sido informado(a) de que el procedimiento motivo de la presente carta de consentimiento v&aacute;lidamente informado puede causar dolor, malestar o molestia en la zona del tratamiento, s&iacute;ntomas que deber&iacute;an ceder en el transcurso de d&iacute;as o semanas y que en caso de que no cesen, debo acudir a ser valorado(a) por el m&eacute;dico; adem&aacute;s de que dicho procedimiento no se encuentra contraindicado para pacientes en mis circunstancias.</p>

<p>Declaro que he recibido informaci&oacute;n precisa y me han aclarado dudas. Se me ha explicado que para una recuperaci&oacute;n satisfactoria debo seguir las indicaciones del especialista y que el incumplimiento de estas ser&aacute; motivo para eximir al profesional de las condiciones negativas que esto pueda provocar al estado de salud de cada paciente.</p>

<p>Tras haber sido informado(a) de los riesgos y beneficios, de forma verbal y por este medio escrito, sin haber ninguna duda de mi parte al respecto, acepto voluntariamente estos riesgos para someterme al procedimiento se&ntilde;alado.</p>

<p>Autorizo al m&eacute;dico tratante para atender cualquier contingencia o emergencia derivada del acto autorizado, atendiendo al principio de libertad prescriptiva.</p>

<p>Tambi&eacute;n se han informado los cuidados y acciones que debe llevar a cabo el paciente despu&eacute;s del procedimiento para efecto de recuperaci&oacute;n y obtener el mayor beneficio o menor perjuicio, derivado del mismo.</p>

<p>As&iacute; mismo se me inform&oacute; de que en caso de ser necesario, se podr&aacute; solicitar mi autorizaci&oacute;n expresa para efecto de toma de fotograf&iacute;as para diversas finalidades como dar seguimiento al tratamiento, observar el avance o evoluci&oacute;n del mismo, para fines de investigaci&oacute;n o aportes al avance de la ciencia y la medicina, entre otros; lo cual tambi&eacute;n se autoriza por medio de la firma que se plasma dentro de la presente carta de consentimiento.</p>
<br>
$footer
<pagebreak />
$header
<p>Se me ha informado tambi&eacute;n con claridad que tengo derecho expreso de retirar mi consentimiento en cualquier momento, y en caso de retirar mi consentimiento, lo har&eacute; por escrito, de forma expresa al correo electr&oacute;nico: <a href='mailto:neuromodulacion.gdl@gmail.com'>neuromodulacion.gdl@gmail.com</a> &nbsp;</p>
<br>
<p>El presente documento se firma de manera aut&oacute;grafa por los intervinientes y testigos:&nbsp;</p>
<br><br><br>
<p>______________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; _________________________</p>

<p>Dr. Alan Hinojosa God&iacute;nez.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Paciente&nbsp;</p>
<br><br><br>

<p>_____________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; __________________________</p>

<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Testigo 1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Testigo 2</p>
<br><br><br><br><br><br><br><br><br><br><br><br>
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



 //echo $cuerpo_pdf;
 
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