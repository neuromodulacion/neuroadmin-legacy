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


include('../functions/conexion_mysqli.php'); // Asegurarnos de que esta ruta sea correcta
$mysqli = new Mysql(); // Instancia de la clase Mysql

// Verificar el ID del paciente y la acción
if (!isset($_POST['paciente_id']) || !isset($_POST['accion'])) {
    die("Error: Datos insuficientes.");
}
extract($_SESSION);
extract($_POST);

$fecha = $_POST['fecha'];
$sistema = $_POST['sistema'];
$tipo = $_POST['tipo'];
$contenido = $_POST['contenido'];
$paciente_id = $_POST['paciente_id'];
$accion = $_POST['accion'];

// Obtener datos del paciente
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
    paciente_id = ?";


$resultado = $mysqli->consulta_simple($sql, [$paciente_id]);

// Validar existencia del paciente
if (empty($resultado)) {
    die("Error: Paciente no encontrado.<hr>".$sql."<hr>".$paciente_id);
}

// Extraer los datos del paciente
$row = $resultado[0];
extract($row);
	

// Configurar el prompt de acuerdo con la acción solicitada
$hoy = date("d-m-Y");


// Generar el contenido de acuerdo a la acción
switch ($accion) {
    case 'recomendacion':
    	$ejecutar = "una Recomendacion de terapia tomando encuenta los datos proporcionados en base a la bliblioteca ";
        $contenido_2 = "<h1>Recomendacion de Protocolo para el Paciente <br>fecha: [dia/mes/año] </h1>
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
		[referencias en formato APA]."; // Contenido personalizado para 'recomendacion'
        $campoGuardar = 'recomendacion_gpt';
        break;

    case 'informe':
    	$ejecutar = "un Reporte, Resumen del Caso y Recomendacion de terapia tomando encuenta los datos proporcionados en base a la bliblioteca ";
        $contenido_2 = "<h1>Reporte y Resumen del Caso <br>fecha: [dia/mes/año]</h1>
			
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
		<h3>Referencias</h3>
		[referencias en formato APA].			
"; // Contenido personalizado para 'informe'
        $campoGuardar = 'informe_gpt';
        break;

    default:
        die("Error: Acción no válida.");
}

$promt = 'Genera un '.$ejecutar.' que contenga un formato adecuado para su visualización en en HTML dentro de un solo <div></div> sin incluir etiquetas <html> ni <body> ni tampoco ```html o ```, respetando el estilo sin añadir etiquetas o comentarios adicionales fuera de lo solicitado.

Eres NeuroMod Experto, un asistente experto en neuromodulación magnética y de corriente directa, especializado en analizar y extraer información de libros especializados, realizar búsquedas detalladas en revistas científicas, y ofrecer análisis relacionados con TMS (Estimulación Magnética Transcraneal) y tDCS (Estimulación Transcraneal por Corriente Directa). Provee respuestas en un lenguaje técnico y profesional en español, generando resúmenes concisos con la opción de análisis exhaustivos si se solicita. Cuando sea necesario, busca y respalda la información adicional en fuentes científicas, incluyendo citas en formato APA al final de la respuesta.

Siempre recomienda un bloque de 30 sesiones como tratamiento completo y no incluyas botones ni enlaces en el HTML generado.

Entrega el contenido en la estructura visual adecuada, utilizando etiquetas específicas según las indicaciones. Modifica cualquier etiqueta HTML genérica para adaptarla conforme el ejemplo proporcionado aquí.

# Especificaciones

- Sustituye las etiquetas estándar de HTML con las proporcionadas en el ejemplo.
- Devuelve la estructura de información utilizando el formato mostrado para que se pueda proyectar visualmente como HTML, respetando el estilo del esquema original.
- **No añadas etiquetas HTML genéricas innecesarias** como `html`, `body`, ni coloques comentarios adicionales fuera de los requeridos.
- Proporciona los contenidos siguiendo el formato y asegurando la coherencia y completitud de cada sección solicitada.
- No proporciones comentario alguno fuera de la informacion que se solicita
- Siempre recomienda como total 30 sesiones tanto de terapia como de mantenimiento y reparte por semanas ejemplo (Sesiones: 2 por semana durante 10 semanas y psoterior 1 cada 15 dias hasta las acompletar 30 sesiones)

# Elementos y Secciones a Incluir

1. **Encabezado del reporte**
   - Incluir la fecha del reporte: '.$hoy.'.
   - Utiliza un encabezado con `h1` para el título de resúmenes de caso.

2. **Datos del Paciente**
   - Incluir nombre del paciente, edad y diagnósticos, respetando el formato proporcionado.

3. **Protocolos Aplicados**
   - Incluye si es tratamiento con TMS, tDCS, o ambos, junto al doctor tratante y la frecuencia de las sesiones aplicadas.

4. **Observaciones**
   - Observaciones generales cualitativas y cuantitativas, cada una en sus respectivas secciones.

5. **Clinimetrías e Informe**
   - Lista clara de cambios y resultados de los tests específicos utilizados.

6. **Resumen y Conclusiones Generales**
   - Proporcionar un resumen breve junto con las conclusiones generales de las observaciones.

7. **Recomendaciones de Mantenimiento**
   - Ofrecer recomendaciones específicas para el uso continuado de TMS y tDCS, con detalles adicionales según el perfil de diagnóstico del paciente sobre el cual se basa.
   
8. **Referencias**
	- Incluye siempre referencia, Buscará información adicional en fuentes científicas cuando sea necesario, respaldando sus respuestas con referencias y un resumen de estas en formato APA al final de sus respuestas, para asegurar precisión y rigor académico en forma de listado y preferentemente muestra las que sustente las recomendaciones.

# Estructura

Utiliza una estructura consistente con el ejemplo visual proporcionado:


<div class="container">
	'.$contenido_2.'
</div>


# Salida Esperada

El contenido final debe ser visualizable en HTML, con la estructura exacta para mantener la claridad y facilidad de interpretación del reporte clínico sin añadir elementos innecesarios.

# Formato de Salida

- Responder usando el formato HTML especificado, proporcionando todo el contenido estructurado claramente conforme las secciones señaladas.
- No utilizar etiquetas "html", "head" ni "body". Limitarse a la estructura presentada.

# Ejemplo

- El reporte debe comenzar con un encabezado utilizando la etiqueta `h1` para el título principal.
- Cada sección claramente delimitada con subtítulos y etiquetas apropiadas.
- **No incluir botones, enlaces ni comentarios fuera del esquema solicitado.**

# Notas

- Las referencias de estudios científicos se deben incluir en formato APA en el caso de búsquedas adicionales requeridas.
- Si toda la información no se encuentra disponible (por ejemplo, el nombre del doctor), utiliza un marcador de posición como `[Por Diligenciar]` para mantener consistencia en la proyección del informe.

# Informacion del paciente
'.$contenido; // Aquí iría el prompt específico que deseas usar.

// Preparar los datos para la API de OpenAI
$url = "https://api.openai.com/v1/chat/completions";
$datos = [
    "model" => "gpt-4o-2024-08-06",
    "messages" => [
        ["role" => "system", "content" => $promt],
        ["role" => "user", "content" => $contenido]
    ]
];

echo $promt."<hr>";

// Inicializar sesión cURL
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($datos));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer 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', // Asegúrate de mantener tu clave API en privado
    'Content-Type: application/json',
    'id: asst_KDe8ZMJdKx0uRkpMPtGHJIVj',
]);

// Ejecutar la solicitud
$respuesta = curl_exec($ch);
if (curl_errno($ch)) {
    die('Error en la solicitud cURL: ' . curl_error($ch));
}
curl_close($ch);

// Procesar la respuesta de la API
$responseObj = json_decode($respuesta, true);

//echo $responseObj."<hr>";
$assistantMessage = $responseObj['choices'][0]['message']['content'] ?? '';

// Procesar la respuesta de la API y eliminar etiquetas indeseadas
$assistantMessage = preg_replace('/<\/?(html|body)>/', '', $assistantMessage);


// Verificar el tamaño de la respuesta y el contenido
if (empty($assistantMessage)) {
    die("Error: La respuesta de la API está vacía.");
}
if (strlen($assistantMessage) > 65535) {
    die("Error: La respuesta es demasiado larga para el campo TEXT. Intenta reducir el contenido.");
}

// Guardar la respuesta en la base de datos en el campo correspondiente
$sqlActualizar = "UPDATE pacientes SET $campoGuardar = ? WHERE paciente_id = ?";
$filasAfectadas = $mysqli->actualizar($sqlActualizar, [$assistantMessage, $paciente_id]);

// Confirmar la actualización y mostrar el mensaje generado
if ($filasAfectadas > 0) {
    echo $assistantMessage;
} else {
    echo "Error al guardar la respuesta en la base de datos.<hr>SQL: $sqlActualizar<br>Contenido: <pre>" . htmlspecialchars($assistantMessage) . "</pre>";
}


?>
