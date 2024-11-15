<?php

// Tu clave de API de OpenAI
$openaiApiKey = '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';

// Inicialización de cURL
$ch = curl_init();

// Configuración de las opciones de cURL
curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/assistants');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    "instructions" => "Eres un tutor personal de matemáticas. Escribe y ejecuta código para responder preguntas de matemáticas.",
    "name" => "Math Tutor",
    "tools" => [["type" => "code_interpreter"]],
    "model" => "gpt-4o"
]));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer {$openaiApiKey}",
    "OpenAI-Beta: assistants=v2"
]);

// Ejecutar la solicitud cURL
$response = curl_exec($ch);

// Verificar si hay errores
if(curl_errno($ch)) {
    echo 'Error de cURL: ' . curl_error($ch);
}

// Cerrar la sesión de cURL
curl_close($ch);

// Imprimir la respuesta
//echo $response;

// Decodificar el JSON a un objeto PHP
$data = json_decode($response);

// Extraer cada propiedad en una variable
$id_asst = $data->id;
$object = $data->object;
$createdAt = $data->created_at;
$name = $data->name;
$description = $data->description;
$model = $data->model;
$instructions = $data->instructions;
$tools = $data->tools; // Esto es un array de objetos
$topP = $data->top_p;
$temperature = $data->temperature;
$toolResources = $data->tool_resources;
$metadata = $data->metadata;
$responseFormat = $data->response_format;

// Ejemplo de cómo acceder a las propiedades de un objeto dentro de un array
$firstToolType = $data->tools[0]->type;

// Imprimir las variables con <br> para el formato HTML
echo "ID: $id_asst<br>";
echo "Object: $object<br>";
echo "Created at: $createdAt<br>";
echo "Name: $name<br>";
echo "Description: " . ($description === null ? "null" : $description) . "<br>";
echo "Model: $model<br>";
echo "Instructions: $instructions<br>";
echo "First Tool Type: $firstToolType<br>";
echo "Top P: $topP<br>";
echo "Temperature: $temperature<br>";
echo "Response Format: $responseFormat<br>";


?>
<hr>
<?php

// Inicialización de cURL
$ch = curl_init();

// Configuración de las opciones de cURL
curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/threads');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([]));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer {$openaiApiKey}",
    'id: '.$id_asst.'',
    "OpenAI-Beta: assistants=v2"
]);

// Ejecutar la solicitud cURL
$response = curl_exec($ch);

// Verificar si hay errores
if(curl_errno($ch)) {
    echo 'Error de cURL: ' . curl_error($ch);
}

// Cerrar la sesión de cURL
curl_close($ch);

// Imprimir la respuesta
//echo $response; 
//echo $response;
// Decodificar el JSON a un objeto PHP
$data = json_decode($response);

// Extraer cada propiedad en una variable
$threads = $data->id;
$object = $data->object;
$createdAt = $data->created_at;
$metadata = $data->metadata; // Este es un objeto, podría necesitar manejo adicional si tuviera datos
$toolResources = $data->tool_resources; // Igual que metadata, manejo según sea necesario

// Imprimir las variables con <br> para formato HTML
echo "ID: $threads<br>";
echo "Object: $object<br>";
echo "Created at: $createdAt<br>";
echo "Metadata: " . (empty((array) $metadata) ? "empty object" : json_encode($metadata)) . "<br>";
echo "Tool Resources: " . (empty((array) $toolResources) ? "empty object" : json_encode($toolResources)) . "<br>";

?>
<hr>
<?php


// Inicialización de cURL
$ch = curl_init();

// Configuración de las opciones de cURL
curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/threads/'.$threads.'/messages');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    "role" => "user",
    "content" => "I need to solve the equation `3x + 11 = 14`. Can you help me?"
]));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer {$openaiApiKey}",
    "assistant_id" => "$id_asst",
    "OpenAI-Beta: assistants=v2"
]);

// Ejecutar la solicitud cURL
$response = curl_exec($ch);

// Verificar si hay errores
if(curl_errno($ch)) {
    echo 'Error de cURL: ' . curl_error($ch);
}

// Cerrar la sesión de cURL
curl_close($ch);

// Imprimir la respuesta
echo $response;
?>
<hr>
<?php


// Inicialización de cURL
$ch = curl_init();

// Configuración de las opciones de cURL
curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/threads/'.$threads.'/runs');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    "assistant_id" => "$id_asst",
    "instructions" => "Please address the user as Jane Doe. The user has a premium account."
]));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer {$openaiApiKey}",
    'id: '.$id_asst.'',
    "OpenAI-Beta: assistants=v2"
]);

// Ejecutar la solicitud cURL
$response = curl_exec($ch);

// Verificar si hay errores
if(curl_errno($ch)) {
    echo 'Error de cURL: ' . curl_error($ch);
}

// Cerrar la sesión de cURL
curl_close($ch);

// Imprimir la respuesta
echo $response;

$data = json_decode($response);

// // Extraer cada propiedad en una variable
// $id = $data->id;
// $object = $data->object;
// $createdAt = $data->created_at;
// $assistantId = $data->assistant_id;
// $threadId = $data->thread_id;
// $runId = $data->run_id;
// $role = $data->role;
// $content = $data->content; // Esto es un array de objetos
// $attachments = $data->attachments;
// $metadata = $data->metadata;
// 
// // Imprimir las variables con <br> para formato HTML
// echo "ID: $id<br>";
// echo "Object: $object<br>";
// echo "Created at: $createdAt<br>";
// echo "Assistant ID: $assistantId<br>";
// echo "Thread ID: $threadId<br>";
// echo "Run ID: $runId<br>";
// echo "Role: $role<br>";
// echo "Content Type: " . $content[0]->type . "<br>";
// echo "Content Value: " . $content[0]->text->value . "<br>";
// echo "Attachments: $attachments<br>";
// echo "Metadata: $metadata<br>";
// 
// $errorJson = '{ "error": { "message": "No assistant found with id \'asst_abc123\'.", "type": "invalid_request_error", "param": null, "code": null } }';
// $errorData = json_decode($errorJson);
// 
// if (isset($errorData->error)) {
    // echo "Error Message: " . $errorData->error->message . "<br>";
    // echo "Error Type: " . $errorData->error->type . "<br>";
// }


?>

<?php
/*
// URL de la API de OpenAI
$url = "https://api.openai.com/v1/chat/completions";

$contenido = "Explicame como funciona el estimulador magnetico";


// Prompt inicial
$promt = "NeuroMod Experto eres un asistente experto en neuromodulación magnética y de corriente directa, especializado en analizar y extraer información de libros especializados y realizar búsquedas detalladas en revistas científicas y artículos en línea. Posees un conocimiento profundo en neurociencia y procesa información técnica y científica a un nivel alto. Sus respuestas serán en un lenguaje técnico y profesional, proporcionando resúmenes breves y concisos, con la opción de análisis detallados bajo solicitud. Las respuestas serán siempre en español, a menos que se solicite explícitamente otro idioma. Buscará información adicional en fuentes científicas cuando sea necesario, respaldando sus respuestas con referencias y un resumen de estas en formato APA al final de sus respuestas, para asegurar precisión y rigor académico. Eres un experto en psiquiatría y neuromodulación y Importante: esto se proyecta siempre en HTML directamente a una página web, por lo que requiero que la información sea presentada en un formato HTML que se pueda ver en una app privada. No agregar ningún botón o enlace: ";

// Datos de la solicitud
$datos = [
    "model" => "gpt-4",
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
    'Content-Type: application/json'
]);

// Enviar la solicitud y guardar la respuesta
$respuesta = curl_exec($ch);

// Verificar si hubo errores en la solicitud
if (curl_errno($ch)) {
    echo 'Error en la solicitud cURL: ' . curl_error($ch);
}

// Cerrar sesión cURL
curl_close($ch);

// Convertir la cadena JSON en un objeto PHP
$responseObj = json_decode($respuesta);

print_r($responseObj);

// Acceder al contenido del mensaje del asistente
$assistantMessage = $responseObj->choices[0]->message->content;

// Imprimir el mensaje
echo $assistantMessage;
*/
?>