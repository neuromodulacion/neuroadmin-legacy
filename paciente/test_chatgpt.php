<?php
session_start();
error_reporting(7);
iconv_set_encoding('internal_encoding', 'utf-8'); 
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');
$_SESSION['time']=mktime();
// 
		// require_once "../vendor/autoload.php";
		// use UAParser\Parser;
$ruta = "../";
include($ruta.'functions/funciones_mysql.php');
		
extract($_POST);
//extract($_GET);
extract($_SESSION);
//print_r($_POST);
//echo "<h1>Chat Gpt</h1>";
//echo $contenido;

$hoy = date("d-m-Y");

$sql = "
SELECT
	pacientes.paciente_id, 
	pacientes.usuario_id, 
	pacientes.paciente, 
	pacientes.apaterno, 
	pacientes.amaterno, 
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
	pacientes.terapias, 
	pacientes.f_captura, 
	pacientes.h_captura, 
	pacientes.estatus, 
	pacientes.observaciones, 
	pacientes.notificaciones, 
	pacientes.comentarios_reporte, 
	pacientes.tratamiento,
	pacientes.recomendacion_gpt,
	pacientes.informe_gpt
FROM
	pacientes
	WHERE
	pacientes.paciente_id = $paciente_id";
	
	//echo $sql;
	
$result =ejecutar($sql); 
$row = mysqli_fetch_array($result);
 extract($row);	

// Convertir el array $row a JSON
$jsonData = json_encode($row);

//echo $jsonData."<hr>";
switch ($accion) {
	case 'recomendacion':
		$accion="Formato siempre entregarlo en formato html5 necesito que evites las etiquetas <html><body></body></html> y la sustitullas por <div class=\"container\"></div> hoy es $hoy
		<h1>Recomendacion de Protocolo para el Paciente fecha: [dia/mes/año] </h1>
		<p>Para el paciente <b>[Nombre completo]</b> diagnosticado con [diagnostico 1, diagnostico 2, etc] se podría considerar la neuromodulación como parte del tratamiento. Dado que la pregunta especifica la especialización en neuromodulación magnética y de corriente directa, detallaré un posible protocolo para cada una de estas modalidades. Cabe destacar que cualquier protocolo de neuromodulación debería ser implementado por un profesional de la salud y de acuerdo con las guías clínicas actuales.</p>
		
		<h3>Neuromodulación Magnética Transcraneal (TMS)</h3>
		[Definición del motivo a mejorar con las indicaciones diagnostico 1]
		<ul>
			<li><b>Objetivo:</b> [ definir ubicación del iman y motivo a mejorar]</li> [(motivo a mejorar)].
			<li><b>Frecuencia:</b> [frecuencia]1</li>
			<li><b>Intensidad:</b> [umbra].</li>
			<li><b>Sesiones:</b> [duración días y semanas].</li>
			<li><b>Duración de la sesión:</b> [duración en minutos de la sesión].</li>
		</ul>
		<p>[Definición del motivo a mejorar con las indicaciones diagnostico 2]</p>
		<ul>
			<li><b>Objetivo:</b> [ definir ubicación del iman y motivo a mejorar]</li> [(motivo a mejorar)].
			<li><b>Frecuencia:</b> [frecuencia]1</li>
			<li><b>Intensidad:</b> [umbra].</li>
			<li><b>Sesiones:</b> [duración días y semanas].</li>
			<li><b>Duración de la sesión:</b> [duración en minutos de la sesión].</li>
		</ul>
		
		<p>[Definición del motivo a mejorar con las indicaciones etc, ]</p>
		<ul>
			<li><b>Objetivo:</b> [ definir ubicación del iman y motivo a mejorar]</li> [(motivo a mejorar)].
			<li><b>Frecuencia:</b> [frecuencia]1</li>
			<li><b>Intensidad:</b> [umbra].</li>
			<li><b>Sesiones:</b> [duración días y semanas].</li>
			<li><b>Duración de la sesión:</b> [duración en minutos de la sesión].</li>
		</ul>
		
		<h3>Estimulación Transcraneal por Corriente Directa (tDCS)</h3>
		<p>La tDCS es otra modalidad de neuromodulación que podría ayudar en la gestión [Definición del motivo a mejorar con las indicaciones diagnostico 1]</p>
		Protocolo general podría incluir:
		<ul>
			<li><b>Anodo: :</b> [ definir ubicación del ánodo y motivo a mejorar].</li> [(motivo a mejorar)].
			<li><b>Catodo:</b> [ definir ubicación del cátodo y motivo a mejorar] [(motivo a mejorar)].</li>
			<li><b>Intensidad:</b> [intensidad en mA].</li>
			<li><b>Sesiones:</b> [duración días y semanas].</li>
			<li><b>Duración:</b> [duración en minutos de la sesión].</li>
		</ul>
		
		[Definición del motivo a mejorar con las indicaciones diagnostico 2]
		. Un protocolo general podría incluir:
		<ul>
			<li><b>Anodo: :</b> [ definir ubicación del ánodo y motivo a mejorar].</li> [(motivo a mejorar)].
			<li><b>Catodo:</b> [ definir ubicación del cátodo y motivo a mejorar] [(motivo a mejorar)].</li>
			<li><b>Intensidad:</b> [intensidad en mA].</li>
			<li><b>Sesiones:</b> [duración días y semanas].</li>
			<li><b>Duración:</b> [duración en minutos de la sesión].</li>
		</ul>
		[Definición del motivo a mejorar con las indicaciones etc.]
		<ul>
			<li><b>Anodo:</b> [ definir ubicación del ánodo y motivo a mejorar].</li> [(motivo a mejorar)].
			<li><b>Catodo:</b> [ definir ubicación del cátodo y motivo a mejorar] [(motivo a mejorar)].</li>
			<li><b>Intensidad:</b> [intensidad en mA].</li>
			<li><b>Sesiones:</b> [duración días y semanas].</li>
			<li><b>Duración:</b> [duración en minutos de la sesión].</li>
		</ul>
		<p>Es esencial considerar que estos protocolos pueden variar según la evidencia más reciente y las características específicas del paciente. Además, el tratamiento farmacológico actual del paciente debe tenerse en cuenta, ya que los fármacos pueden influir en la respuesta a la neuromodulación.</p>
		<h3>Referencias</h3>
		[referencias en formato APA].
		";
		break;
	
	case 'informe':
		$accion="Formato siempre entregarlo en formato html5 necesito que evites las etiquetas <html><body></body></html> y la sustitullas por <div class=\"container\"></div> 
		
			hoy es $hoy
			<h1>Reporte y Resumen del Caso fecha: [dia/mes/año]</h1>
			
			<h3>El paciente Datos</h3>
			<b>Nombre:</b> [paciente nombre]<br>
			<b>Edad:</b> [Edad]<br>
			<b>Diagnósticos:</b> [Diagnostico 1, diagnostico 2]<br> 
			<h3>Protocolos aplicados:</h3> [Protocolos especificar si fue TMS o tDCS o ambos]<br>
			<b>Doctor Tratante:</b> [doctor tratante]<br>
			<b>Temporalidad de las Sesiones:</b> [frecuencia de las sesiones]<br>
			<b>Observaciones Generales:</b> [obesevaciones]<br>
			<h3>Informe de las clinimetrias:</h3> [ ejemplos
			<ul>
				<li>PHQ9 (Depresión): comenzó con un puntaje de 3 (sin síntomas), tuvo una fluctuación leve y terminó en 2 (sin síntomas), resultando en una disminución de 33%.</li>
				<li>GAD7 (Ansiedad): el paciente se mantuvo mayormente sin síntomas, sin una disminución significativa de su línea de base.</li>
				<li>Y-BOCS (TOC): mostró una disminución sostenida desde un puntaje de 27 (moderadamente severo) a 18 (moderado).</li>
			<ul>
			]
			<b>A nivel cualitativo:</b> [Observaciones a nivel cualitativo]<br> 
			<b>A nivel cuantitativo:</b> [Observaciones a nivel cuantitativo]<br> 
			
			<p>El reporte indica que a lo largo del tratamiento, el paciente recibió varias modalidades de neuromodulación:</p>
			[ejemplo:
			<ul>
				<li>Frecuencia Alta 10 Hz en corteza frontal izquierda (5 sesiones activas).</li>
				<li>Frecuencia Baja 1 Hz en corteza frontal derecha (15 sesiones activas).</li>
			</ul>
			]
			
			<h3>Resumen general de las Observaciones:</h3> [Resumen general de las Observaciones]
			
			<h3>Conclusiones Generales:</h3> [Conclusiones Generales]
			
			<h3>Recomendaciones de Sesiones de Mantenimiento:</h3>
			
			
			<p>Para un paciente diagnosticado con [diagnostico 1, diagnostico 2, etc] se podría considerar la neuromodulación como parte del tratamiento de mantenimiento. Dado que la pregunta especifica la especialización en neuromodulación magnética y de corriente directa, detallaré un posible protocolo para cada una de estas modalidades. Cabe destacar que cualquier protocolo de neuromodulación debería ser implementado por un profesional de la salud y de acuerdo con las guías clínicas actuales.</p>
			<h3>Neuromodulación Magnética Transcraneal (TMS)</h3>
			[Definición del motivo a mejorar con las indicaciones diagnostico 1]
		<ul>
			<li><b>Objetivo:</b> [ definir ubicación del iman y motivo a mejorar]</li> [(motivo a mejorar)].
			<li><b>Frecuencia:</b> [frecuencia]1</li>
			<li><b>Intensidad:</b> [umbra].</li>
			<li><b>Sesiones:</b> [duración días y semanas].</li>
			<li><b>Duración de la sesión:</b> [duración en minutos de la sesión].</li>
		</ul>
			[Definición del motivo a mejorar con las indicaciones diagnostico 2]
		<ul>
			<li><b>Objetivo:</b> [ definir ubicación del iman y motivo a mejorar]</li> [(motivo a mejorar)].
			<li><b>Frecuencia:</b> [frecuencia]1</li>
			<li><b>Intensidad:</b> [umbra].</li>
			<li><b>Sesiones:</b> [duración días y semanas].</li>
			<li><b>Duración de la sesión:</b> [duración en minutos de la sesión].</li>
		</ul>
			[Definición del motivo a mejorar con las indicaciones etc, ]
		<ul>
			<li><b>Objetivo:</b> [ definir ubicación del iman y motivo a mejorar]</li> [(motivo a mejorar)].
			<li><b>Frecuencia:</b> [frecuencia]1</li>
			<li><b>Intensidad:</b> [umbra].</li>
			<li><b>Sesiones:</b> [duración días y semanas].</li>
			<li><b>Duración de la sesión:</b> [duración en minutos de la sesión].</li>
		</ul>
			
			<h3>Estimulación Transcraneal por Corriente Directa (tDCS)</h3>
			La tDCS es otra modalidad de neuromodulación que podría ayudar en la gestión [Definición del motivo a mejorar con las indicaciones diagnostico 1]
			. Un protocolo general podría incluir:
			<ul>
				<li><b>Anodo:</b> [ definir ubicación del ánodo y motivo a mejorar].</li> [(motivo a mejorar)].
				<li><b>Catodo:</b> [ definir ubicación del cátodo y motivo a mejorar] [(motivo a mejorar)].</li>
				<li><b>Intensidad:</b> [intensidad en mA].</li>
				<li><b>Sesiones:</b> [duración días y semanas].</li>
				<li><b>Duración:</b> [duración en minutos de la sesión].</li>
			</ul>
			[Definición del motivo a mejorar con las indicaciones diagnostico 2]
			. Un protocolo general podría incluir:
			<ul>
				<li><b>Anodo:</b> : [ definir ubicación del ánodo y motivo a mejorar].</li> [(motivo a mejorar)].
				<li><b>Catodo:</b> [ definir ubicación del cátodo y motivo a mejorar] [(motivo a mejorar)].</li>
				<li><b>Intensidad:</b> [intensidad en mA].</li>
				<li><b>Sesiones:</b> [duración días y semanas].</li>
				<li><b>Duración:</b> [duración en minutos de la sesión].</li>
			</ul>
			[Definición del motivo a mejorar con las indicaciones etc.]
			. Un protocolo general podría incluir:
			<ul>
				<li><b>Anodo:</b> [ definir ubicación del ánodo y motivo a mejorar].</li> [(motivo a mejorar)].
				<li><b>Catodo:</b> [ definir ubicación del cátodo y motivo a mejorar] [(motivo a mejorar)].</li>
				<li><b>Intensidad:</b> [intensidad en mA].</li>
				<li><b>Sesiones:</b> [duración días y semanas].</li>
				<li><b>Duración:</b> [duración en minutos de la sesión].</li>
			</ul>
			<p>Es esencial considerar que estos protocolos pueden variar según la evidencia más reciente y las características específicas del paciente. Además, el tratamiento farmacológico actual del paciente debe tenerse en cuenta, ya que los fármacos pueden influir en la respuesta a la neuromodulación.</p>

		";
		break;
}


// URL de la API de Chat de OpenAI gpt-3.5-turbo  gpt-3.5-turbo-1106   gpt-4-1106-preview
$url = "https://api.openai.com/v1/chat/completions";


$promt ="NeuroMod Experto eres un asistente experto en neuromodulación magnética y de corriente directa, especializado en analizar y extraer información de libros especializados y realizar búsquedas detalladas en revistas científicas y artículos en línea. Posees un conocimiento profundo en neurociencia y procesa información técnica y científica a un nivel alto. Sus respuestas serán en un lenguaje técnico y profesional, proporcionando resúmenes breves y concisos, con la opción de análisis detallados bajo solicitud. Las respuestas serán siempre en español, a menos que se solicite explícitamente otro idioma. Buscará información adicional en fuentes científicas cuando sea necesario, respaldando sus respuestas con referencias y un resumen de estas en formato APA al final de sus respuestas, para asegurar precisión y rigor académico. , eres un experto en psiquiatria y neuromodulacion y ".$sistema.", Siempre recomienda bloque de 30 sesiones el tratamiento completo, Importante esto se proyecta siempre en html directamente a una pagina web por lo que requiero la informacion sea presentada en un fomato html que se pueda ver en una app privada, no agregar ningun boton o enlace: ".$accion." fecha ".$fecha;

$datos = [

    "model" => "gpt-4o",
    "messages" => [
        ["role" => "system", "content" => $promt],
        ["role" => "user", "content" => $contenido]
    ]
];

// Inicializar sesión cURL
$ch = curl_init($url);

// Configurar opciones de cURL
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($datos));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer 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', // Asegúrate de mantener tu clave API en privado
    'Content-Type: application/json',
    'id: asst_KDe8ZMJdKx0uRkpMPtGHJIVj',
]);

// Enviar la solicitud y guardar la respuesta
$respuesta = curl_exec($ch);

// Verificar si hubo errores en la solicitud
if(curl_errno($ch)){
    echo 'Error en la solicitud cURL: ' . curl_error($ch);
}

// Cerrar sesión cURL
curl_close($ch);

// Convertir la cadena JSON en un objeto PHP
$responseObj = json_decode($respuesta);

//echo $respuesta."<hr>";

// Acceder al contenido del mensaje del asistente
$assistantMessage = $responseObj->choices[0]->message->content;
// Imprimir el mensaje
echo $assistantMessage;





 