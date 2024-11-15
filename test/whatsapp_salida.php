<?php

$url = "https://graph.facebook.com/v18.0/193060653900543/messages";

// $accessToken = "EAAWxuhCVcfUBOxOKYx3qCz0QMHizGVZAERpUplSDmqMAjCc4EZBgIfHs3jURUzTFZCOV0KxSZACM0vJaMJ46GWuCPwD4hYQ4yUs0a2r9GXuPZBzUznLdS69j0lM1iRVFKKFk11V4MnWQy7rfKuMi5Rebi7eFbgASFZCFdx37rXSvtVEmlyPkFKktJeOR7RhZAxCuMoF1W6Hmgpvu7N3UX3IvH077qWSKixIKgZDZD";
$accessToken = 
"EAAWxuhCVcfUBO8XZAX19cbnZCdsK1ssBYZBMXRdoqyoZAFnh2CuE7fXbZAikRT7SZCL5a4WPywGY9OJCRGPlkmDPTZBzrEJ2AlvHEua0LPO6PWtB9LZCXpnJYc7vgEcZAzg9tz3O8RHFpZBDmmYVuaDVktsfAFfjlsgJp1JwyJ4nqI3ZB1SrwOo8g4bwa2rivvF54RbF5QOgZCIB6aYOtJfx";

// // Envio con plantilla
// $data = [
    // "messaging_product" => "whatsapp",
    // "to" => "523338148472",
    // "type" => "template",
    // "template" => [
        // "name" => "prueba ",
        // "language" => [
            // "code" => "es_MX"
        // ]
    // ]
// ];


// envio de texto    
// $data = [
    // "messaging_product" => "whatsapp",
    // "to" => "523338148472",
    // "type" => "text",
    // "text" => [
       // "preview_url" => true,
        // "body" => "hello_world https://neuromodulaciongdl.com/"    
    	// ]
// ];

// // marca leido el mensaje
// $data = [
    // "messaging_product" => "whatsapp",
    // "status" => "read",
    // "message_id" => "wamid.HBgNNTIxMzMzODE0ODQ3MhUCABIYIDk2NkE0QUM0RDdGNDYxQTI4ODREOUU4QzUxMUFDQzY1AA==" // Reemplaza MESSAGE_ID con el ID del mensaje específico
// ];



// // //solicita una ubicacion
// $data = [
    // "messaging_product" => "whatsapp",
    // "recipient_type" => "individual",
    // "type" => "interactive",
    // "to" => "523338148472", // Sustituye con el número de teléfono del usuario de WhatsApp
    // "interactive" => [
        // "type" => "location_request_message",
        // "body" => [
            // "text" => "manda tu ubicacions" // Sustituye con el texto que deseas enviar en el cuerpo del mensaje
        // ],
        // "action" => [
            // "name" => "send_location"
        // ]
    // ]
// ];


$data = [
    "messaging_product" => "whatsapp",
    "to" => "523338148472",
    "type" => "image",
    "text" => [
       "preview_url" => false,
        "body" => "hello_world image"    
    	],
	"image" => [
		"link" => "https://neuromodulaciongdl.com/images/news-image1.jpg"]
];


// Con botones
// $data = [
    // "messaging_product" => "whatsapp",
    // "recipient_type" => "individual",
    // "to" => "523338148472", // Sustituye PHONE_NUMBER por el número de teléfono correspondiente
    // "type" => "interactive",
    // "interactive" => [
        // "type" => "list",
        // "header" => [
            // "type" => "text",
            // "text" => "Servicios Prestados" // Sustituye HEADER_TEXT por el texto correspondiente
        // ],
        // "body" => [
            // "text" => "Selecciona el Servicio" // Sustituye BODY_TEXT por el texto del cuerpo
        // ],
        // "footer" => [
            // "text" => "La manada de Leo" // Sustituye FOOTER_TEXT por el texto del pie de página
        // ],
        // "action" => [
            // "button" => "MENU", // Sustituye BUTTON_TEXT por el texto del botón
            // "sections" => [
                // [
                    // "title" => "Obediencia", // Sustituye SECTION_1_TITLE por el título de la sección
                    // "rows" => [
                        // [
                            // "id" => "SECTION_1_ROW_1_ID", // Sustituye por el ID correspondiente
                            // "title" => "Obediencia a domicilio", // Sustituye por el título correspondiente
                            // "description" => "SECTION_1_ROW_1_DESCRIPTION" // Descripción
                        // ],
                        // [
                            // "id" => "SECTION_1_ROW_2_ID",
                            // "title" => "Correcion de conductas",
                            // "description" => "SECTION_1_ROW_2_DESCRIPTION"
                        // ]
                    // ]
                // ],
                // [
                    // "title" => "SECTION_2_TITLE",
                    // "rows" => [
                        // [
                            // "id" => "SECTION_2_ROW_1_ID",
                            // "title" => "SECTION_2_ROW_1_TITLE",
                            // "description" => "SECTION_2_ROW_1_DESCRIPTION"
                        // ],
                        // [
                            // "id" => "SECTION_2_ROW_2_ID",
                            // "title" => "SECTION_2_ROW_2_TITLE",
                            // "description" => "SECTION_2_ROW_2_DESCRIPTION"
                        // ]
                    // ]
                // ]
            // ]
        // ]
    // ]
// ];


// botones
// $data = [
    // "messaging_product" => "whatsapp",
    // "recipient_type" => "individual",
    // "to" => "523338148472", // Reemplaza PHONE_NUMBER con el número de teléfono al que quieres enviar el mensaje
    // "type" => "interactive",
    // "interactive" => [
        // "type" => "button",
        // "body" => [
            // "text" => "Prueba" // Reemplaza BUTTON_TEXT con el texto que quieras que aparezca en el cuerpo del mensaje
        // ],
        // "action" => [
            // "buttons" => [
                // [
                    // "type" => "reply",
                    // "reply" => [
                        // "id" => "UNIQUE_BUTTON_ID_1", // Reemplaza UNIQUE_BUTTON_ID_1 con el ID único del botón
                        // "title" => "si" // Reemplaza BUTTON_TITLE_1 con el título del botón
                    // ]
                // ],
                // [
                    // "type" => "reply",
                    // "reply" => [
                        // "id" => "UNIQUE_BUTTON_ID_2", // Reemplaza UNIQUE_BUTTON_ID_2 con otro ID único para el segundo botón
                        // "title" => "no" // Reemplaza BUTTON_TITLE_2 con el título del segundo botón
                    // ]
                // ]
            // ]
        // ]
    // ]
// ];

//20.751158, -103.377693

// //ubicacion n
// $data = [
    // "messaging_product" => "whatsapp",
    // "to" => "523338148472", // Reemplaza PHONE_NUMBER con el número de teléfono destinatario
    // "type" => "location",
    // "location" => [
        // "longitude" => 20.751158, // Reemplaza LONG_NUMBER con la longitud de la ubicación
        // "latitude" => -103.377693, // Reemplaza LAT_NUMBER con la latitud de la ubicación
        // "name" => "LOCATION_NAME", // Opcional: Reemplaza LOCATION_NAME con el nombre de la ubicación
        // "address" => "LOCATION_ADDRESS" // Opcional: Reemplaza LOCATION_ADDRESS con la dirección de la ubicación
    // ]
// ];


// $data = [
    // "messaging_product" => "whatsapp",
    // "recipient_type" => "individual",
    // "to" => "523338148472", // Reemplaza con el número real del destinatario
    // "type" => "interactive",
    // "interactive" => [
        // "type" => "address_message",
        // "body" => [
            // "text" => "Thanks for your order! Tell us what address you’d like this order delivered to."
        // ],
        // "action" => [
            // "name" => "address_message",
            // "parameters" => [
                // "country" => "IN",
                // "saved_addresses" => [
                    // [
                        // "id" => "address1",
                        // "value" => [
                            // "name" => "CUSTOMER_NAME",
                            // "phone_number" => "+523338148472",
                            // "in_pin_code" => "400063",
                            // "floor_number" => "8",
                            // "building_name" => "",
                            // "address" => "Wing A, Cello Triumph, IB Patel Rd",
                            // "landmark_area" => "Goregaon",
                            // "city" => "Mumbai"
                        // ]
                    // ]
                // ]
            // ]
        // ]
    // ]
// ];


// Inicializa cURL
$ch = curl_init($url);

// Configura la solicitud HTTP
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer " . $accessToken,
    "Content-Type: application/json"
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// Ejecuta la solicitud y captura la respuesta
$response = curl_exec($ch);

// Cierra la sesión cURL
curl_close($ch);

// Opcional: Imprime la respuesta
echo $response;

?>
