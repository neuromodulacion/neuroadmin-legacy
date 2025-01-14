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
$tratamiento = 'TMS';

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
			<td align='center' style='background: #fff; width: 20%'>
				<img style='width: auto; height: 100px;' src='../$logo' alt='grafica'>					
			</td>

			<td style='background: #fff; width: 60%'>
			<h3 align='center'><strong>NEUROMODULACI&Oacute;N GDL S.A. DE C.V.</strong></h3>	
			</td>
			<td align='center' style='background: #fff; width: 20%'>

			</td>            			
		</tr>
	</table>
    <hr><br>";
$header="
	<table style='width: 100%' >
		<tr>
			<td align='center' style='background: #fff; width: 20%'>
				<img style='width: auto; height: 100px;' src='../$logo' alt='grafica'>					
			</td>
			<td style='background: #fff; width: 65%'>
			<h3 align='center'><strong>NEUROMODULACI&Oacute;N GDL S.A. DE C.V.</strong></h3>	
			</td>            
			<td align='center' style='background: #fff; width: 20%'>

			</td>            

			
		</tr>
	</table>
    <hr><br>";	


$footer ="<br><hr>
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
<body style='font-family: Arial, sans-serif; text-align: justify; color: #07252C;'>


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

<pagebreak />

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

<pagebreak />

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

<pagebreak />

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

    <pagebreak />

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

<pagebreak />

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

<pagebreak />


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


<pagebreak />

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

<pagebreak />


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

    <pagebreak />

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

<pagebreak />

<p>resultados sobre an&aacute;lisis y pruebas de laboratorio y/o rayos x, consumo de sustancias enervantes y/o psicotr&oacute;picos, consumo de bebidas alcoh&oacute;licas, somatometr&iacute;a, etc&eacute;tera. Lo anterior, con la &uacute;nica reserva que al respecto se&ntilde;alan las Leyes Sanitarias del pa&iacute;s.</p>
<br>
<p><strong>SEGUNDA. - TITULARIDAD DE LA INFORMACI&Oacute;N.</strong> Expresamente reconocen las partes, que la Informaci&oacute;n Confidencial que han recibido y seguir&aacute;n recibiendo, as&iacute; como la que se obtenga o produzca derivado de la relaci&oacute;n &ldquo;Prestador del servicio&rdquo; &ndash; &ldquo;Paciente&rdquo;, no resulta evidente ni es del dominio p&uacute;blico, por lo que constituye propiedad o titularidad del &ldquo;Paciente&rdquo; y tiene un valor significativo para el mismo.</p>
<br>
<p><strong>TERCERA. - UTILIZACI&Oacute;N DE INFORMACI&Oacute;N.</strong> El &ldquo;Paciente&rdquo; reconoce que la informaci&oacute;n que le ha proporcionado el &ldquo;Prestador del servicio&rdquo;, es derivada de la atenci&oacute;n m&eacute;dica, por lo que se obliga a utilizar esa informaci&oacute;n en beneficio propio, siendo &uacute;nico responsable del cumplimiento u omisi&oacute;n que haga respecto a la informaci&oacute;n proporcionada por el &ldquo;Prestador del servicio&rdquo;, y &eacute;sta a su vez, utilizar&aacute; la informaci&oacute;n proporcionada por el &ldquo;Paciente&rdquo;, para proveer la atenci&oacute;n m&eacute;dica bajo los principios Bio&eacute;ticos.</p>
<br>
<p><strong>CUARTA. - VERACIDAD DE LA INFORMACI&Oacute;N.</strong> El &ldquo;Paciente&rdquo; reconoce que, todo lo manifestado al &ldquo;Prestador del servicio&rdquo; en o para la consulta, as&iacute; como los documentos, resultados de laboratorio y dem&aacute;s elementos proporcionados al&nbsp; &ldquo;Prestador del servicio&rdquo; son verdaderos. El &ldquo;Prestador del servicio&rdquo; no es responsable de la veracidad ni la precisi&oacute;n de la informaci&oacute;n proporcionada por el &ldquo;Paciente&rdquo;, ya que los mismos no han sido previamente validados y/o verificados. Asimismo, el &ldquo;Prestador del servicio&rdquo; no es responsable por la informaci&oacute;n que oculte u omita proporcionar el &ldquo;Paciente&rdquo;.</p>
<br>

<pagebreak />

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

<pagebreak />

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



<pagebreak />

<h2><strong>CARTA DE CONSENTIMIENTO V&Aacute;LIDAMENTE INFORMADO&nbsp;</strong></h2>

<p>Apellidos: <strong>$apellidos</strong> &nbsp; Nombre: <strong>$nom_simple</strong> &nbsp; Edad:_____________.</p>


<p>Sexo:&nbsp; $sexo</p>

<p>Fecha:&nbsp;&nbsp;&nbsp;&nbsp; _________________. Horario: &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ___.</p>

<p>En el establecimiento de servicios de salud del sector privado denominado Neuromodulaci&oacute;n GDL, S.A. DE C.V., ubicado en: Avenida de los Arcos, con n&uacute;mero exterior 876, en la Colonia/Fraccionamiento Jardines del Bosque Centro, del municipio de Guadalajara, Jalisco, C.P. 44520.</p>

<p><strong>Acto autorizado: ESTIMULACI&Oacute;N MAGN&Eacute;TICA TRANSCRANEAL.</strong></p>

<p>(EL/LA)C:</p>

<p>______________________________________________________________,</p>

<p>Declaro que voluntariamente he acudido a este establecimiento de Neuromodulaci&oacute;n GDL S.A. DE C.V., donde el responsable del centro {<strong>Dr. Alan Hinojosa God&iacute;nez</strong>}, m&eacute;dico con c&eacute;dula profesional {<strong>9512714</strong>}, me ha explicado en qu&eacute; consiste el procedimiento m&eacute;dico de estimulaci&oacute;n magn&eacute;tica transcraneal; as&iacute; como el objetivo, los resultados esperados, posibles reacciones, riesgos o complicaciones de este, as&iacute; como beneficios esperados y tratamientos alternativos.</p>

<p>Comprendo que el procedimiento m&eacute;dico autorizado consiste en: un tratamiento m&eacute;dico realizado por cl&iacute;nicos capacitados, en el cual se utiliza un aparato o dispositivo m&eacute;dico que cuenta con diferentes componentes, entre los m&aacute;s importantes, una bobina. En general, este aparato tiene la funci&oacute;n de generar un campo magn&eacute;tico que termina produciendo un campo el&eacute;ctrico en la zona cerebral en donde se posiciona su bobina.</p>

<p>Para comenzar a tratar con este aparato se debe determinar el umbral motor, es decir,&nbsp; la dosis del campo magn&eacute;tico. Este par&aacute;metro es determinado espec&iacute;ficamente con cada paciente.</p>

<p>Se realiza al implementar un pulso magn&eacute;tico sobre la corteza motora, determinando cu&aacute;nta energ&iacute;a se necesita para generar una corriente el&eacute;ctrica dentro de esta. Esta es la cantidad necesaria para que el aparato de TMS produzca un movimiento en sus dedos.</p>


<pagebreak />


<p>El m&eacute;dico tomar&aacute; la bobina que emite el pulso magn&eacute;tico sobre la cabeza del paciente mientras que una serie de pulsos (no m&aacute;s r&aacute;pidos que un pulso por segundo) ser&aacute; emitida hasta que los dedos de la mano contralateral de donde se est&aacute; aplicando realicen un movimiento. Durante este proceso, el &uacute;nico efecto que el paciente podr&aacute; notar es un sonido de &ldquo;clic&rdquo; cuando los pulsos se est&eacute;n emitiendo.</p>

<p>Como paciente podr&eacute; elegir utilizar tapones de los o&iacute;dos durante este proceso y todo su tratamiento para proteger su audici&oacute;n. Si los impulsos por serie de su protocolo son mayores a un pulso por segundo es recomendable usar estos tapones por comodidad y seguridad.</p>

<p>El paciente se debe de mantener despierto durante el tratamiento completo de estimulaci&oacute;n magn&eacute;tica transcraneal. Si surgen efectos indeseables durante el tratamiento, este puede ser pausado en cualquier momento sin consecuencias en sus efectos.</p>

<p>Se me ha explicado que bajo dicho procedimiento los posibles riesgos, complicaciones o reacciones secundarias al tratamiento pueden ser los siguientes: sensaci&oacute;n de golpeteo en la zona del tratamiento, espasmos faciales o sensaci&oacute;n de&nbsp; dolor en el sitio del tratamiento mientras se enciende la espiral magn&eacute;tica; de igual forma se han reportado por otros pacientes la aparici&oacute;n de dolores de cabeza y en casos muy poco habituales se han reportado episodios de convulsiones.</p>

<p>Cerca de un tercio de los pacientes ha informado sobre este tipo de sensaciones, por lo que comprendo que debo informar al personal m&eacute;dico si esto ocurre para que el personal m&eacute;dico encargado del tratamiento pueda ajustar los valores de estimulaci&oacute;n o hacer cambios en el sitio de colocaci&oacute;n de la espiral con el fin de ayudar a hacer que el procedimiento sea m&aacute;s c&oacute;modo para m&iacute;.</p>

<p>El riesgo m&aacute;s grave conocido de la EMT es la producci&oacute;n de una convulsi&oacute;n. Aunque ha habido algunos informes sobre casos de ataques con el uso de dispositivos de EMT, el riesgo es tambi&eacute;n peque&ntilde;o en extremo, y no se han conocido casos de convulsiones con el uso de este dispositivo particular de EMT. No obstante, se me ha explicado que si presento antecedentes de alg&uacute;n trastorno convulsivo, debo informar de forma inmediata al personal m&eacute;dico del establecimiento, ya que esto podr&iacute;a influir en mi riesgo particular de desarrollar convulsiones con este procedimiento; a&uacute;n cuando el personal c&iacute;nico siga los lineamientos de seguridad actualizados para el uso de EMT dise&ntilde;ados para minimizaci&oacute;n de riesgos convulsivos con esta t&eacute;cnica.</p>
<br><br><br>

<pagebreak />

<p>En cuanto al uso de &eacute;sta t&eacute;cnica para el tratamiento de la depresi&oacute;n, se me ha informado de que no es eficaz para todos los pacientes, por lo que, cualquier signo o s&iacute;ntoma de empeoramiento debe informarse de inmediato al Doctor y de que es posible que necesite pedir a un familiar o cuidador que vigile los s&iacute;ntomas para ayudar a detectar cualquier signo de empeoramiento de la depresi&oacute;n.</p>


<p>No se han reportado efectos adversos cognitivos (pensamiento y memoria) asociados con la terapia de EMT.</p>

<p>He sido informado(a) de que el procedimiento motivo de la presente carta de consentimiento v&aacute;lidamente informado puede causar dolor, malestar o molestia en la zona del tratamiento, s&iacute;ntomas que deber&iacute;an ceder en el transcurso de d&iacute;as o semanas y que en caso de que no cesen, debo acudir a ser valorado(a) por el m&eacute;dico; adem&aacute;s de que dicho procedimiento no se encuentra contraindicado para pacientes en mis circunstancias.</p>

<p>Declaro que he recibido informaci&oacute;n precisa y me han aclarado dudas. Se me ha explicado que para una recuperaci&oacute;n satisfactoria debo seguir las indicaciones del especialista y que el incumplimiento de estas ser&aacute; motivo para eximir al profesional de las condiciones negativas que esto pueda provocar al estado de salud de cada paciente.</p>

<p>Tras haber sido informado(a) de los riesgos y beneficios, de forma verbal y por este medio escrito, sin haber ninguna duda de mi parte al respecto, acepto voluntariamente estos riesgos para someterme al procedimiento se&ntilde;alado.</p>

<p>Autorizo al m&eacute;dico tratante para atender cualquier contingencia o emergencia derivada del acto autorizado, atendiendo al principio de libertad prescriptiva.</p>

<p>Tambi&eacute;n se han informado los cuidados y acciones que debe llevar a cabo el paciente despu&eacute;s del procedimiento para efecto de recuperaci&oacute;n y obtener el mayor beneficio o menor perjuicio, derivado del mismo.</p>

<p>As&iacute; mismo se me inform&oacute; de que en caso de ser necesario, se podr&aacute; solicitar mi autorizaci&oacute;n expresa para efecto de toma de fotograf&iacute;as para diversas finalidades como dar seguimiento al tratamiento, observar el avance o evoluci&oacute;n del mismo, para fines de investigaci&oacute;n o aportes al avance de la ciencia y la medicina, entre otros; lo cual tambi&eacute;n se autoriza por medio de la firma que se plasma dentro de la presente carta de consentimiento.</p>
<br>

<pagebreak />

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

<pagebreak />


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


</body>
";



 //echo $cuerpo_pdf;
 
// Require composer autoload
require_once __DIR__ . '/../vendor/autoload.php';
// Create an instance of the class:
$mpdf = new \Mpdf\Mpdf([
    'margin_top' => 45, // Ajusta este valor según necesites
    'margin_left' => 20,
    'margin_right' => 20,
    'margin_bottom' => 45,
]);

$mpdf->SetHTMLHeader($header);
$mpdf->SetHTMLFooter($footer);
// Write some HTML code:
$mpdf->WriteHTML($cuerpo_pdf);

// D descarga
// F guarda
// I imprime

// Output a PDF file directly to the browser
$mpdf->Output('Contrato_Paciente_'.$paciente_id.'.pdf','I');

?>
<?php /*
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
include('../functions/functions.php');
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
$terapia == "TMS";

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
		</tr>	
		";




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
<h2  align='center'> <strong>Terapia de Estimulaci&oacute;n Magn&eacute;tica Transcraneal</strong></h2>
<br>
<p>La EMT es un procedimiento m&eacute;dico no invasivo y autorizado en varios pa&iacute;ses, incluyendo su aprobaci&oacute;n en Estados Unidos por la FDA (Food and Drug Agency) para el tratamiento de diversos padecimientos. La EMT es una t&eacute;cnica de estimulaci&oacute;n cerebral que se basa en la generaci&oacute;n de campos magn&eacute;ticos breves por medio de una espiral recubierta por un aislante que se coloca sobre el cuero cabelludo.</p>

<p>Estos campos magn&eacute;ticos son del mismo tipo y potencia que los empleados en las m&aacute;quinas de imagenolog&iacute;a por resonancia magn&eacute;tica (IRM). Los pulsos magn&eacute;ticos generan una corriente el&eacute;ctrica d&eacute;bil en el cerebro que activa en forma breve los circuitos neuronales en el sitio de estimulaci&oacute;n. Se ha demostrado que la EMT es un procedimiento seguro y bien tolerado que puede ser un tratamiento eficaz para los pacientes.</p>

<p>El beneficio potencial de la EMT es que puede conducir a mejor&iacute;as en los s&iacute;ntomas de mi condici&oacute;n psiqui&aacute;trica. Comprendo que no todos los pacientes responden igualmente bien a la EMT. Lo mismo que todas las formas de tratamiento m&eacute;dico, algunos pacientes se recuperan con rapidez, otros se recuperan por un tiempo corto y luego recaen, mientras que otros no logran tener respuesta alguna a la terapia por EMT.</p>
<br>
<h2>Cl&aacute;usulas</h2>

<p><strong>Primera.</strong> NEUROMODULACI&Oacute;N GDL, S.A. DE C.V. se compromete a brindar el servicio de la(s) sesi&oacute;n(es) de terapia de estimulaci&oacute;n magn&eacute;tica transcraneal (EMT) en el centro destinado para tal fin en un horario de lunes a viernes de 9:00 am a 8:00 pm y s&aacute;bados de 10:00 am a 2:00 pm con previa cita y confirmaci&oacute;n de la disponibilidad para el uso del equipo.</p>

$footer
<pagebreak />
$header
<br>
<p><strong>Segunda. </strong>NEUROMODULACI&Oacute;N GDL, S.A. DE C.V. y EL PACIENTE acuerdan que el precio de la sesi&oacute;n de terapia de estimulaci&oacute;n magn&eacute;tica transcraneal (EMT) se estipulara en la consulta &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;de evaluaci&oacute;n del paciente.</p>

<p><strong>Tercera. </strong>Las partes acuerdan que solo el titular del presente acuerdo podr&aacute; recibir el servicio antes descrito.</p>

<p><strong>Cuarta</strong>. EL PACIENTE comprende y acepta el &ldquo;Consentimiento Informado previo a la Terapia de Estimulaci&oacute;n Magn&eacute;tica Transcraneal (EMT)&rdquo; que se le entreg&oacute; por el m&eacute;dico explic&aacute;ndole el alcance del tratamiento y posibles efectos secundarios.</p>

<p><strong>Quinta. </strong>EL PACIENTE reconoce y acepta que su inasistencia a la sesi&oacute;n de terapia de estimulaci&oacute;n magn&eacute;tica transcraneal (EMT) no lo exime de las obligaciones contra&iacute;das, adem&aacute;s que se considerar&aacute; c&oacute;mo sesi&oacute;n otorgada.</p>

<p><strong>Sexta. </strong>El PACIENTE acepta que s&oacute;lo cuenta con diez minutos de tolerancia en su cita, y Neuromodulaci&oacute;n GDL, S.A. de C.V. se reserva el derecho de reagendar o de otorgar la sesi&oacute;n.</p>

<p><strong>S&eacute;ptima: </strong>EL PACIENTE se obliga en caso de no poder asistir a su cita, notificar con 24 horas de anticipaci&oacute;n para poder reagendar, sin afectar su tratamiento.</p>

<p><strong>Octava. </strong>Las partes convienen que el(los) pago(s) de la(s) sesi&oacute;n(es) de terapia de estimulaci&oacute;n magn&eacute;tica transcraneal (EMT) <strong>deber&aacute;n ser previos a recibir el servicio</strong>.</p>

<p><strong>Novena</strong>. Las partes no podr&aacute;n ceder los derechos y obligaciones de este acuerdo, en la inteligencia de que solo las obligaciones preimpresas pactadas en este instrumento regir&aacute;n entre las partes.</p>

<p><strong>D&eacute;cima. </strong>En caso de que EL PACIENTE decida no continuar con la sesi&oacute;n(es) de terapia de estimulaci&oacute;n magn&eacute;tica transcraneal (EMT) y haya efectuado alg&uacute;n pago(s) correspondiente (s), &eacute;ste no ser&aacute; reembolsado.</p>

<p><strong>Onceava. </strong>La terapia de estimulaci&oacute;n magn&eacute;tica transcraneal (EMT) requiere de continuidad para su mejor funcionamiento, es as&iacute; que el paciente se compromete a tomar sus sesiones completas en tiempo y forma, de no ser as&iacute; su tratamiento no ser&aacute; el &oacute;ptimo y puede influir en sus resultados.</p>
<p>&nbsp;</p><p>&nbsp;</p><br>
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

<p>&nbsp;</p>

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

<h2 align='center'><strong>Consentimiento para recibir el tratamiento con TMS </strong></h2>

<p><strong>Descripci&oacute;n de procedimiento</strong></p>

<p>La estimulaci&oacute;n magn&eacute;tica transcraneal, TMS, por sus siglas en ingles es un tratamiento m&eacute;dico que se realiza por cl&iacute;nicos capacitados. El aparato que se utiliza para ella tiene diferentes componentes. En general, este aparato genera un campo magn&eacute;tico que termina produciendo un campo el&eacute;ctrico en la zona cerebral en donde se posiciona su bobina.</p>

<p>Para comenzar a tratar al paciente con este aparato se debe determinar el umbral motor o la dosis del campo magn&eacute;tico. Esto es determinado espec&iacute;ficamente con cada uno de los pacientes. Se realiza al implementar un pulso magn&eacute;tico sobre la corteza motora, determinando cuanta energ&iacute;a se necesita para generar una corriente el&eacute;ctrica dentro de esta. Esta es la cantidad necesaria para que el aparato de TMS produzca un movimiento en sus dedos.</p>

<p>Una persona entrenada tomar&aacute; la bobina que emite el pulso magn&eacute;tico sobre la cabeza de su paciente mientras que una serie de pulsos (no m&aacute;s r&aacute;pidos que un pulso por segundo) que ser&aacute; emitida hasta que los dedos de la mano contralateral de donde se est&aacute; aplicando realicen un movimiento. Durante este proceso, el &uacute;nico efecto que el paciente podr&aacute; notar es un sonido de &ldquo;clic&rdquo; cuando los pulsos se est&eacute;n emitiendo.</p>

<p>El paciente podr&aacute; elegir utilizar tapones de los o&iacute;dos durante este proceso y todo su tratamiento para proteger su audici&oacute;n. Si los impulsos por serie de su protocolo son mayores a un pulso por segundo es recomendable usar estos tapones por comodidad y seguridad.</p>

<p>El paciente se debe de mantener despierto durante el tratamiento completo con TMS. Si efectos indeseables se desarrollan durante el tratamiento, este puede ser pausado en cualquier momento sin consecuencias en sus efectos.</p>

<p><strong>Riesgos</strong></p>

<p>Lo mismo que cualquier tratamiento m&eacute;dico, la EMT conlleva un riesgo de efectos&nbsp; secundarios. No obstante, la EMT por lo general es bien tolerada y s&oacute;lo un porcentaje&nbsp;peque&ntilde;o de pacientes suspende el tratamiento debido a efectos secundarios.&nbsp;&nbsp;</p>

<p>Es posible que, durante el tratamiento, sienta golpeteo, espasmos faciales o&nbsp; sensaciones dolorosas en el sitio del tratamiento mientras se enciende la espiral&nbsp; magn&eacute;tica.&nbsp;</p>

<br>


$footer
<pagebreak />
$header

<p>Cerca de un tercio de los pacientes ha informado sobre este tipo de&nbsp; sensaciones. Comprendo que debo informar al personal si esto ocurre. A continuaci&oacute;n, el&nbsp; personal de tratamiento puede ajustar los valores de estimulaci&oacute;n o hacer cambios en el&nbsp; sitio de colocaci&oacute;n de la espiral con el fin de ayudar a hacer que el procedimiento sea m&aacute;s&nbsp; c&oacute;modo para m&iacute;. Asimismo, cerca de la mitad de los pacientes tratados con EMT han&nbsp; sufrido dolores de cabeza.</p>

<p>Comprendo que tanto las molestias como los dolores de&nbsp; cabeza tienden a disminuir con el tiempo y que, por lo general, estos dolores&nbsp; respondieron bien a medicamentos analg&eacute;sicos que no requieren receta.</p>

<p>El riesgo m&aacute;s grave conocido de la EMT es la producci&oacute;n de una convulsi&oacute;n.&nbsp; Aunque ha habido algunos informes sobre casos de ataques con el uso de dispositivos de&nbsp; EMT, el riesgo es peque&ntilde;o en extremo, y no se han observado convulsiones con el uso de&nbsp; este dispositivo particular de EMT. No obstante, informar&eacute; a mi doctor si presento&nbsp; antecedentes de alg&uacute;n trastorno convulsivo, ya que esto podr&iacute;a influir en mi riesgo de&nbsp; desarrollar convulsiones con este procedimiento. El equipo de EMT sigue lineamientos de&nbsp; seguridad actualizados para el uso de EMT dise&ntilde;ados para minimizar el riesgo de convulsiones con esta t&eacute;cnica.</p>

<p>La terapia de EMT no es eficaz para todos los pacientes con depresi&oacute;n. Cualquier&nbsp; signo o s&iacute;ntoma de empeoramiento debe informarse de inmediato a su Doctor. Es posible&nbsp;que desee pedir a un familiar o cuidador que vigile sus s&iacute;ntomas para ayudarle a detectar&nbsp; cualquier signo de empeoramiento de la depresi&oacute;n. No se han reportado efectos&nbsp;adversos cognitivos (pensamiento y memoria) asociados con la terapia de EMT.&nbsp;</p>

<p>Con TMS, el sonido de &ldquo;clic&rdquo; hecho por el estimulador puede afectar temporalmente la audici&oacute;n, es por esto que se le ofrecer&aacute; utilizar protectores auditivos.</p>

<p>Responda este cuestionario y firme debajo.</p>

<p>&iquest;Est&aacute; usted embarazada?</p>

<p>&iquest;Tiene alg&uacute;n metal magn&eacute;tico en su cabeza?</p>

<p>&iquest;Existe alguna raz&oacute;n por la que no puede pasar por una resonancia magn&eacute;tica?</p>

<p>&iquest;Durmi&oacute; por menos de 4 horas?</p>

<p>&iquest;Ha consumido alcohol durante las &uacute;ltimas 24 horas?</p>

<p>&iquest;Ha consumido alguna sustancia que podr&iacute;a disminuir su umbral motor en las &uacute;ltimas 24 horas?</p>

$footer
<pagebreak />
$header

<p>Si ha respondido SI a alguna de las preguntas anteriores, debe de hac&eacute;rselo saber al responsable de la aplicaci&oacute;n del tratamiento.</p>

<p>&nbsp;A trav&eacute;s del presente escrito manifiesto que yo:</p>

<p>________________________________________________________________________ acud&iacute; por mi propia voluntad y bajo mi responsabilidad a Neuromodulacion GDL, el d&iacute;a <b>$dia de $mes del $anio </b>, para que con mi consentimiento se me realice la aplicaci&oacute;n de un protocolo de estimulaci&oacute;n magn&eacute;tica transcraneal o estimulaci&oacute;n el&eacute;ctrica directa indicada por mi m&eacute;dico tratante. Reconozco que el personal de Neuromodulaci&oacute;n GDL inform&oacute; y asesor&oacute; acerca de la naturaleza del tratamiento, los posibles resultados tras el tratamiento, as&iacute; como&nbsp; tambi&eacute;n se me informo de los y riesgos las consecuencias que puede tener para mi salud este tratamiento.</p>

<p>Asimismo, se me dio la oportunidad de hacer las preguntas que consider&eacute; necesarias, las cuales fueron respondidas a mi entera satisfacci&oacute;n.</p>

<p>Adem&aacute;s, el personal de Neuromodulacion GDL me inform&oacute; el procedimiento de detecci&oacute;n y las molestias derivadas del mismo. Expreso que se aclararon mis dudas y se ampli&oacute; la informaci&oacute;n cuando as&iacute; lo solicit&eacute;, incluso se me comunic&oacute; que tengo el derecho de cambiar de decisi&oacute;n en cualquier momento y manifestarla previo al procedimiento.</p>

<p>A efecto de facilitar mi atenci&oacute;n integral, me comprometo a acudir a revisi&oacute;n m&eacute;dica cuando se me indique, o en el caso de presentar alguna molestia o duda al procedimiento.</p>

<p>Se me inform&oacute; que todos los datos que proporcione a Neuromodulacion GDL ser&aacute;n utilizados de manera estrictamente confidencial y si es mi voluntad se considerar&aacute;n de manera an&oacute;nima.</p>

<p>Acorde con lo anterior, declaro que es mi decisi&oacute;n libre, consciente e informada de aceptar el procedimiento de Estimulaci&oacute;n Magn&eacute;tica Transcraneal □ / Estimulaci&oacute;n Directa Craneal □ a fin de llevar a cabo las acciones m&eacute;dico preventivas requeridas en beneficio de mi salud.</p>

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
*/
?>