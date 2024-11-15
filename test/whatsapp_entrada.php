<?php
/*
 * VERIFICACION DEL WEBHOOK
*/
//TOQUEN QUE QUERRAMOS PONER 
$token = '12345';
//RETO QUE RECIBIREMOS DE FACEBOOK
$palabraReto = $_GET['hub_challenge'];
//TOQUEN DE VERIFICACION QUE RECIBIREMOS DE FACEBOOK
$tokenVerificacion = $_GET['hub_verify_token'];
//SI EL TOKEN QUE GENERAMOS ES EL MISMO QUE NOS ENVIA FACEBOOK RETORNAMOS EL RETO PARA VALIDAR QUE SOMOS NOSOTROS
if ($token === $tokenVerificacion) {
    echo $palabraReto;
    exit;
}

/*
 * RECEPCION DE MENSAJES
 */
//LEEMOS LOS DATOS ENVIADOS POR WHATSAPP
$respuesta = file_get_contents("php://input");

// Guardado del JSON completo en el archivo
file_put_contents("text_contenido.html", $respuesta);

//CONVERTIMOS EL JSON EN ARRAY DE PHP
$respuesta = json_decode($respuesta, true);
//EXTRAEMOS EL TELEFONO DEL ARRAY

// $mensaje="";
// 
// $datos = json_decode($respuesta, true);
// 
// // Acceso a elementos de nivel superior
// $object = $datos['object'];
// $entries = $datos['entry'];
// 
// foreach ($entries as $entry) {
    // $mensaje.="ID de entrada: " . $entry['id'] . "\n";
    // $changes = $entry['changes'];
//     
    // foreach ($changes as $change) {
        // $value = $change['value'];
        // $mensaje.="Producto de mensajería: " . $value['messaging_product'] . "\n";
        // // Y así sucesivamente para acceder a otros elementos anidados...
    // }
// }


$contenidoJson = file_get_contents('php://input');
$datos = json_decode($contenidoJson, true);

// Procesar cada entrada
foreach ($datos['entry'] as $entry) {
    echo "ID de la cuenta de WhatsApp Business: " . $entry['id'] . "\n";

    // Procesar cada cambio dentro de la entrada
    foreach ($entry['changes'] as $change) {
        $value = $change['value'];
        echo "Producto de mensajería: " . $value['messaging_product'] . "\n";

        // Metadata
        if (isset($value['metadata'])) {
            echo "Número de teléfono mostrado: " . $value['metadata']['display_phone_number'] . "\n";
            echo "ID de número de teléfono: " . $value['metadata']['phone_number_id'] . "\n";
        }

        // Mensajes
        if (isset($value['messages'])) {
            foreach ($value['messages'] as $message) {
                if (isset($message['type']) && $message['type'] == 'audio') {
                    echo "Audio ID: " . $message['audio']['id'] . "\n";
                    echo "Audio MIME type: " . $message['audio']['mime_type'] . "\n";
                }

                if (isset($message['type']) && $message['type'] == 'button') {
                    echo "Button payload: " . $message['button']['payload'] . "\n";
                    echo "Button text: " . $message['button']['text'] . "\n";
                }

                if (isset($message['context'])) {
                    echo "Forwarded: " . ($message['context']['forwarded'] ? 'Yes' : 'No') . "\n";
                    echo "Frequently forwarded: " . ($message['context']['frequently_forwarded'] ? 'Yes' : 'No') . "\n";
                    echo "From: " . $message['context']['from'] . "\n";
                    echo "Message ID: " . $message['context']['id'] . "\n";
                    if (isset($message['context']['referred_product'])) {
                        echo "Catalog ID: " . $message['context']['referred_product']['catalog_id'] . "\n";
                        echo "Product retailer ID: " . $message['context']['referred_product']['product_retailer_id'] . "\n";
                    }
                }
            }
        }

        // Errores
        if (isset($value['errors'])) {
            foreach ($value['errors'] as $error) {
                echo "Error code: " . $error['code'] . "\n";
                echo "Error title: " . $error['title'] . "\n";
                echo "Error message: " . $error['message'] . "\n";
            }
        }

        // Contactos
        if (isset($value['contacts'])) {
            foreach ($value['contacts'] as $contact) {
                echo "WhatsApp ID: " . $contact['wa_id'] . "\n";
                if (isset($contact['profile'])) {
                    echo "Contact name: " . $contact['profile']['name'] . "\n";
                }
            }
        }
    }
}


// Asegúrate de responder correctamente para confirmar la recepción del webhook
echo 'SUCCESS';

// $mensaje = "";
// // Concatenar los datos de 'object'
// $mensaje .= "Object: " . $respuesta['object'] . "</br>";
// 
// // Iterar a través de 'entry'
// foreach ($respuesta['entry'] as $entry) {
    // $mensaje .= "ID de entrada: " . $entry['id'] . "</br>";
//     
    // // Iterar a través de 'changes'
    // foreach ($entry['changes'] as $change) {
        // $value = $change['value'];
        // $mensaje .= "Producto de mensajería: " . $value['messaging_product'] . "</br>";
//         
        // // Metadata
        // $metadata = $value['metadata'];
        // $mensaje .= "Número de teléfono mostrado: " . $metadata['display_phone_number'] . "</br>";
        // $mensaje .= "ID de teléfono: " . $metadata['phone_number_id'] . "</br>";
//         
        // // Contacts
        // foreach ($value['contacts'] as $contact) {
            // $mensaje .= "Nombre de contacto: " . $contact['profile']['name'] . "</br>";
            // $mensaje .= "ID de WhatsApp: " . $contact['wa_id'] . "</br>";
        // }
//         
        // // Messages
        // foreach ($value['messages'] as $message) {
            // $mensaje .= "Mensaje de: " . $message['from'] . "</br>";
            // $mensaje .= "ID de mensaje: " . $message['id'] . "</br>";
            // $mensaje .= "Tipo de mensaje: " . $message['type'] . "</br>";
            // if (isset($message['image'])) {
                // $mensaje .= "Caption: " . $message['image']['caption'] . "</br>";
            // }
        // }
    // }
// }




// //Accediendo a los elementos específicos
// $account = $respuesta['object'];
// $entryId = $respuesta['entry'][0]['id'];
// $phoneNumber = $respuesta['entry'][0]['changes'][0]['value']['metadata']['display_phone_number'];
// $phoneNumberId = $respuesta['entry'][0]['changes'][0]['value']['metadata']['phone_number_id'];
// $contactName = $respuesta['entry'][0]['changes'][0]['value']['contacts'][0]['profile']['name'];
// $waId = $respuesta['entry'][0]['changes'][0]['value']['contacts'][0]['wa_id'];
// $messageFrom = $respuesta['entry'][0]['changes'][0]['value']['messages'][0]['from'];
// $messageId = $respuesta['entry'][0]['changes'][0]['value']['messages'][0]['id'];
// $timestamp = $respuesta['entry'][0]['changes'][0]['value']['messages'][0]['timestamp'];
// $messageBody = $respuesta['entry'][0]['changes'][0]['value']['messages'][0]['text']['body'];
// $messageType = $respuesta['entry'][0]['changes'][0]['value']['messages'][0]['type'];
// 
// $mensaje = "Cuenta: " .$account. "</br>";
// $mensaje .= "ID de entrada: " .$entryId. "</br>";
// $mensaje .= "Número de teléfono: " .$phoneNumber. "</br>";
// $mensaje .= "ID de número de teléfono: " .$phoneNumberId. "</br>";
// $mensaje .= "Nombre de contacto: " .$contactName. "</br>";
// $mensaje .= "ID de WhatsApp: " .$waId. "</br>";
// $mensaje .= "Mensaje de: " .$messageFrom. "</br>";
// $mensaje .= "ID de mensaje: " .$messageId. "</br>";
// $mensaje .= "Fecha y hora: " .$timestamp. "</br>";
// $mensaje .= "Cuerpo del mensaje: " .$messageBody. "</br>";
// $mensaje .= "Tipo de mensaje: " .$messageType. "</br>";
// 
// $mensaje="Telefono:".$respuesta['entry'][0]['changes'][0]['value']['messages'][0]['from']."</br>";
// // //EXTRAEMOS EL MENSAJE DEL ARRAY
// $mensaje.="Mensaje:".$respuesta['entry'][0]['changes'][0]['value']['messages'][0]['text']['body'];
// //GUARDAMOS EL MENSAJE Y LA RESPUESTA EN EL ARCHIVO text.txt
file_put_contents("text.html", $mensaje);


// 
// // Lee el cuerpo de la petición
// $datosCrudos = file_get_contents('php://input');
// 
// // Decodifica el JSON a un array asociativo
// $datos = json_decode($datosCrudos, true);
// 
// // Verifica si los datos se han recibido correctamente
// if ($datos) {
    // // Procesa los datos aquí. Por ejemplo, puedes guardarlos en una base de datos
    // // o realizar alguna acción en función de los datos recibidos.
    // // Esto es solo un ejemplo de registro en un archivo para propósitos de demostración.
    // file_put_contents('webhook.log', print_r($datos, true));
//     
    // // Envía una respuesta al servidor que envió el webhook para confirmar la recepción
    // header('Content-Type: application/json');
    // echo json_encode(['success' => true, 'message' => 'Datos recibidos correctamente']);
// } else {
    // // Manejo de error en caso de que los datos no se reciban correctamente
    // http_response_code(400); // Código de estado HTTP para indicar un error en la solicitud
    // echo 'Error al recibir los datos';
// }

?>
