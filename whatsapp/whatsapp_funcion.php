<?php


function mesg_sal($type,$to,$preview_url,$body){

switch ($type) {
	case 'text':
		// envio de texto    
		$data = [
		    "messaging_product" => "whatsapp",
		    "to" => "$to",
		    "type" => "text",
		    "text" => [
		    	"preview_url" => false,
		        "body" => "$body"    
		    	]
		];		
		break;
	
	case 'url':
		
		$data = [
		    "messaging_product" => "whatsapp",
		    "to" => "$to",
		    "type" => "text",
		    "text" => [
		       "preview_url" => true,
		        "body" => "hello_world https://neuromodulaciongdl.com/"    
		    	]
		];	
			
		// $data = [
		    // "messaging_product" => "whatsapp",
		    // "to" => "$to",
		    // "type" => "$type",
		    // "text" => [
		       // "preview_url" => "$preview_url",
		        // "body" => "$body"    
		    	// ]
		// ];		
		break;
		
	case 'template':
		$data = [
		    "messaging_product" => "whatsapp",
		    "to" => "$to",
		    "type" => "$type",
		    "template" => [
		        "name" => "prueba ",
		        "language" => [
		            "code" => "es_MX"
		        ]
		    ]
		];	
		break;		
		
	case 'read':
		// marca leido el mensaje
		$data = [
		    "messaging_product" => "whatsapp",
		    "status" => "read",
		    "message_id" => "$body" // Reemplaza MESSAGE_ID con el ID del mensaje específico
		];
		break;	
		
	case 'location_request_message':
		// //solicita una ubicacion
		$data = [
		    "messaging_product" => "whatsapp",
		    "recipient_type" => "individual",
		    "type" => "interactive",
		    "to" => "$to", // Sustituye con el número de teléfono del usuario de WhatsApp
		    "interactive" => [
		        "type" => "location_request_message",
		        "body" => [
		            "text" => "manda tu ubicacions" // Sustituye con el texto que deseas enviar en el cuerpo del mensaje
		        ],
		        "action" => [
		            "name" => "send_location"
		        ]
		    ]
		];
		break;	
				
	case 'menu':
		// marca leido el mensaje
		// Con botones
		$data = [
		    "messaging_product" => "whatsapp",
		    "recipient_type" => "individual",
		    "to" => "$to", // Sustituye PHONE_NUMBER por el número de teléfono correspondiente
		    "type" => "interactive",
		    "interactive" => [
		        "type" => "list",
		        "header" => [
		            "type" => "text",
		            "text" => "Servicios Prestados" // Sustituye HEADER_TEXT por el texto correspondiente
		        ],
		        "body" => [
		            "text" => "Selecciona el Servicio" // Sustituye BODY_TEXT por el texto del cuerpo
		        ],
		        "footer" => [
		            "text" => "La manada de Leo" // Sustituye FOOTER_TEXT por el texto del pie de página
		        ],
		        "action" => [
		            "button" => "MENU", // Sustituye BUTTON_TEXT por el texto del botón
		            "sections" => [
		                [
		                    "title" => "Obediencia", // Sustituye SECTION_1_TITLE por el título de la sección
		                    "rows" => [
		                        [
		                            "id" => "SECTION_1_ROW_1_ID", // Sustituye por el ID correspondiente
		                            "title" => "Obediencia a domicilio", // Sustituye por el título correspondiente
		                            "description" => "SECTION_1_ROW_1_DESCRIPTION" // Descripción
		                        ],
		                        [
		                            "id" => "SECTION_1_ROW_2_ID",
		                            "title" => "Correcion de conductas",
		                            "description" => "SECTION_1_ROW_2_DESCRIPTION"
		                        ]
		                    ]
		                ],
		                [
		                    "title" => "Accesorios",
		                    "rows" => [
		                        [
		                            "id" => "SECTION_2_ROW_1_ID",
		                            "title" => "SECTION_2_ROW_1_TITLE",
		                            "description" => "SECTION_2_ROW_1_DESCRIPTION"
		                        ],
		                        [
		                            "id" => "SECTION_2_ROW_2_ID",
		                            "title" => "SECTION_2_ROW_2_TITLE",
		                            "description" => "SECTION_2_ROW_2_DESCRIPTION"
		                        ]
		                    ]
		                ],
		                [
		                    "title" => "Seguros",
		                    "rows" => [
		                        [
		                            "id" => "SECTION_3_ROW_1_ID",
		                            "title" => "SECTION_2_ROW_1_TITLE",
		                            "description" => "SECTION_2_ROW_1_DESCRIPTION"
		                        ],
		                        [
		                            "id" => "SECTION_2_ROW_2_ID",
		                            "title" => "SECTION_2_ROW_2_TITLE",
		                            "description" => "SECTION_2_ROW_2_DESCRIPTION"
		                        ]
		                    ]
		                ]		                
		            ]
		        ]
		    ]
		];
		break;				
}                     

    return $data; 
}

function envio_whatsapp($url,$accessToken,$data){

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
	
    return $response; 
}  