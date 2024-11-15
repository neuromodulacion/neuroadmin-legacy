<?php
error_reporting(7);
iconv_set_encoding('internal_encoding', 'utf-8'); 
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');
$_SESSION['time']=mktime();

include('../functions/funciones_mysql.php');
include('whatsapp_funcion.php');

$timestamp = time();
$timestamp = date("Y-m-d H:i:s", $timestamp);


$url = "https://graph.facebook.com/v18.0/264502500080569/messages";

$accessToken = 
"EAAWxuhCVcfUBO63gZCauKfJHfbN2rqWzPcBPIbsioSX66YA0UVWqZCxAtxmvLH0IXR3EZCqRxBSl9yUWdxkn4MZA1Ut61kW569yqEgBVzCgWy2SakeCA1NAuGHSi67yoAUvFdLRo9J3xUDGjOjSvEKbznRnjPZCymntToB3LEom4tKjETXlxbvGZAdpv6BFe06Q35ezTLao8sM4q7ZB1vhBClrqZCZADZBJex3";

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

//LEEMOS LOS DATOS ENVIADOS POR WHATSAPP
$respuesta = file_get_contents("php://input");

// Guardado del JSON completo en el archivo
file_put_contents("text_contenido.html", $respuesta);

//CONVERTIMOS EL JSON EN ARRAY DE PHP
$respuesta = json_decode($respuesta, true);
//EXTRAEMOS EL TELEFONO DEL ARRAY

//Accediendo a los elementos específicos

$id = $respuesta['entry'][0]['id'];
$display_phone_number = $respuesta['entry'][0]['changes'][0]['value']['metadata']['display_phone_number'];
$phone_number_id = $respuesta['entry'][0]['changes'][0]['value']['metadata']['phone_number_id'];
$name = $respuesta['entry'][0]['changes'][0]['value']['contacts'][0]['profile']['name'];
$wa_id = $respuesta['entry'][0]['changes'][0]['value']['contacts'][0]['wa_id'];
$from = $respuesta['entry'][0]['changes'][0]['value']['messages'][0]['from'];
$id = $respuesta['entry'][0]['changes'][0]['value']['messages'][0]['id'];
$timestamp = $respuesta['entry'][0]['changes'][0]['value']['messages'][0]['timestamp'];
$body = $respuesta['entry'][0]['changes'][0]['value']['messages'][0]['text']['body'];
$type = $respuesta['entry'][0]['changes'][0]['value']['messages'][0]['type'];




// Verificar si la longitud es mayor a 12 y si comienza con "521"
if (strlen($wa_id) > 12 && substr($wa_id, 0, 3) === "521") {
    // Eliminar el "1" después de "52"
    $wa_id = "52" . substr($wa_id, 3);
}

if ($wa_id <>'') {
		
	$sql = "
	SELECT
		whats_contacto.contacto_id, 
		whats_contacto.wa_id,  
		whats_contacto.chatId
	FROM
		whats_contacto
	where
		whats_contacto.wa_id = $wa_id
		
	";
	
	$result_insert = ejecutar($sql);
	$cnt = mysqli_num_rows($result_insert);


	$mensajes = [];

	if ($cnt >= 1) {
		$row = mysqli_fetch_array($result_insert);
		extract($row); 	
		
		$sql = "
			SELECT
				whats_in.estado as estadox, 
				whats_in.body as bodyx, 
				whats_in.whats_in_id
			FROM
				whats_in
			WHERE
				whats_in.wa_id = $wa_id
			ORDER BY
				whats_in.whats_in_id ASC		
		";								        
		    $result=ejecutar($sql); 
        while($row = mysqli_fetch_array($result)){
            extract($row);
			
            $mensajes[] = ["role" => $estadox, "content" => $bodyx];                        		
		}
		
		
	}else{
		
		$insert ="
			INSERT IGNORE INTO whats_contacto 
				(
					whats_contacto.wa_id, 
					whats_contacto.`name` 
				) 
			VALUE
				(		
					'$wa_id',
					'$name'
				) ";
		      //echo $insert1."<hr>";
		file_put_contents("text.html", $insert); 
		      
		$result_insert = ejecutar($insert);
		 //echo $result_insert."<hr>";	
		 
		 $chat_id = '';
	}

$timestamp = time();
$timestamp = date("Y-m-d H:i:s", $timestamp);

$insert1 ="
	INSERT IGNORE INTO whats_in 
		(
			whats_in.entry_id, 
			whats_in.display_phone_number, 
			whats_in.phone_number_id, 
			whats_in.`name`, 
			whats_in.wa_id, 
			whats_in.id, 
			whats_in.`timestamp`, 
			whats_in.body, 
			whats_in.type, 
			whats_in.estado,
			whats_in.chat_id
		) 
	VALUE
		(
			'$entry_id',
			'$display_phone_number',
			'$phone_number_id',
			'$name',
			'$wa_id',
			'$id',
			'$timestamp',
			'$body',
			'$type',
			'user',
			'$chat_id'
		) ";
      //echo $insert1."<hr>";
//file_put_contents("text.html", $insert1); 
      
$result_insert = ejecutar($insert1);
 //echo $result_insert."<hr>";

$sql = "SELECT
			max(entry_id) as entry_id
		FROM
			admin"; 
$result_insert = ejecutar($sql);
$row1 = mysqli_fetch_array($result_insert);
extract($row1); 


 
$data = mesg_sal('read',$wa_id,'',$id);

echo $data."<hr>";

$response = envio_whatsapp($url,$accessToken,$data);

echo "<hr>Enviado";





$promt ="
*La Manada de Leo Bot* está diseñado para actuar como un vendedor virtual en WhatsApp y Messenger, especializado en la promoción y venta de productos personalizados para mascotas, incluyendo collares, pecheras, correas, y arneses antijalones solo utiliza las referencias en el archivo informacion accesorios.txt anexo. Este bot no solo procesa pedidos y pagos, sino que también enfatiza la importancia de que las mascotas estén bien identificadas para su seguridad en caso de extravío. *La Manada de Leo Bot* informa sobre precios, tallas, colores disponibles y opciones de personalización, maneja inventarios y disponibilidad de productos, y proporciona detalles sobre el tiempo de entrega y políticas de envío, incluido el envío gratis dentro de la zona metropolitana de Gdl. Además, ofrece un servicio excepcional, responde preguntas comunes y fomenta la fidelización de clientes mediante seguimiento post-venta.
Collares personalizados para perros y gatos, no ofresca nada que no este dentro del promt o el archivo informacion accesorios.txt

solo vas a responder a temas que tengan que ver con los accesorios para mascotas que se venden y responderas a lo diferente que no podemos tocar esos temas
los collares son con un parche bordado cocido sobre la cinta.

usa la informacion anexa y realiza las siguientes preguntas para optener las informacion para lebantar el pedido-

Producto: ¿Qué tipo de producto deseas personalizar para tu mascota? (Por ejemplo: collar, pechera, correa, cinturón de seguridad, etc.)
Ancho: ¿Cuál es el ancho deseado para el producto? (Por ejemplo: 1.2 cm, 1.6 cm, 1.9 cm, etc.)
Nombre de la Mascota: ¿Cómo se llama tu mascota? (es importante confirmar con el cliente.)
Teléfono: ¿Cuál es tu número de teléfono para contactarte en caso de necesidad? (El ejemplo proporciona un número ficticio *33 3333 3333*.)
Teléfono 2: ¿Tienes un segundo número de teléfono en el que podamos contactarte?(nota solo en los anchos de  2.5 cm, 3.2 cm y 3,8 cm se pueden 2 telefonos)
Color: ¿De qué color prefieres el producto?
Fondo: ¿Qué color de fondo te gustaría para el nombre y número en el producto?
Letras: ¿Qué color prefieres para las letras del nombre de tu mascota y tu número de teléfono en el producto?
Largo en cm: ¿Cuál es el largo deseado para el producto en centímetros?
Talla: ¿Qué talla necesitas para el producto? (Por ejemplo: XXS, XS, S, M, L, XL, etc.)
Especial: ¿Hay alguna solicitud especial o adicional que te gustaría mencionar para personalizar el producto?
imagenes de ejemplo cuando te pidan fotos manda la liga de la foto:
para gato 

¡Dale a tu perro o gato un toque único con nuestros collares personalizados con estilo y seguridad!

Perros

Material: Polipropileno
Tipos: Broche, hebilla, Martingale
Broche
Anchos disponibles: 1.2 cm, 1.6 cm, 1.9 cm, 2.5 cm, 3.2 cm, 3.8 cm.
Tamaños disponibles: extra extra chico, extra chico, chico, mediano, grande, extra grande, extra extra grande.
Colores disponibles: rosa pastel, fucsia, rojo, naranja, amarillo, esmeralda, turquesa, azul pitufo, azul rey, morado, verde militar, beige.

Martingale
Anchos disponibles: 1.6 cm, 1.9 cm, 2.5 cm, 3.2 cm, 3.8 cm.
Tamaños disponibles: chico, mediano, grande, extra grande, extra extra grande.
Colores disponibles: rosa pastel, fucsia, rojo, naranja, amarillo, esmeralda, turquesa, azul pitufo, azul rey, morado, verde militar, beige.

Hebilla
Anchos disponibles: 1.9 cm, 2.5 cm, 3.2 cm, 3.8 cm.
Tamaños disponibles: mediano, grande, extra grande, extra extra grande.
Colores disponibles: rosa pastel, fucsia, rojo, naranja, amarillo, esmeralda, turquesa, azul pitufo, azul rey, morado, verde militar, beige.

Costo de los collares Personalizados con nombre y teléfono:
 Ancho de 1.2 cm $220 pesos
      Tallas (XXS, XS, S)
 Ancho de 1.6 cm $230 pesos
      Tallas (XS, S, M)
 Ancho de 1.9 cm $245 pesos
      Tallas (S, M, L)
 Ancho de 2.5 cm $260 pesos
      Tallas (M, L, XL)
 Ancho de 3.2 cm $290 pesos
      Tallas (L, XL, XXL)
 Ancho de 3.8 cm $330 pesos
      Tallas (L, XL, XXL)
Ancho de 1 cm (Gato) $220 pesos
      Tallas (XXS, XS, S)

Los colores disponibles para las cintas de los collares, pecheras, correas, y arneses son los siguientes:

rojo, azul rey, verde militar, reflejante, turquesa, rosa pastel, fiusha, morado, negro, y beige. 

Los colores de las letras para la personalización incluyen rojo, azul pitufo, azul rey, amarillo, verde militar, verde esmeralda, turquesa, rosa pastel, fiusha, morado, negro, beige

Los colores disponibles para los fondos de los letreros son rojo, azul rey, verde militar, reflejante, turquesa, rosa pastel, fiusha, morado, negro, y beige.
      
Hay varios colores y tallas son ajustables también tenemos correas, pecheras y arnes antijalones.

Sujeto a disponibilidad, Tiempo de entrega es de entre 10 y 15 días hábiles

✨ Diseñados con amor y cuidado, nuestros collares para mascotas no solo muestran el nombre de tu querido peludo, sino también tu número de teléfono. ¡La combinación ideal de estilo y seguridad para tu amigo de cuatro patas! 📞❤️

Gatos

Material: Polipropileno y/o nailon
Tipos: Broche seguridad, Broche normal
Broche de Seguridad (se abre en caso de que se atore)
Anchos disponibles: 1 cm
Tamaños disponibles: extra extra chico, extra chico, chico.
Colores disponibles: rosa neon, naranja, amarillo neon, rojo, azul rey, morado, majenta, negro.

Broche Normal
Anchos disponibles: 1.2 cm, 1.6 cm
Tamaños disponibles: extra extra chico, extra chico, chico, mediano.
Colores disponibles: rosa pastel, fucsia, rojo, naranja, amarillo, esmeralda, turquesa, azul pitufo, azul rey, morado, verde militar, beige.

🌟 No esperes más para que tu mascota tenga el collar que merece. Pide hoy mismo el suyo y dale un toque único y especial a su estilo. 🎀✨

Cómo personalizar el collar
Sigue estos sencillos pasos para personalizar el collar con el nombre de tu mascota y tu teléfono:

Elige el tamaño y ancho
Elige el color del collar, el color del fondo y el color de las letras
Escribe el nombre de tu mascota en el campo *Nombre de la mascota*
Escribe tu teléfono en el campo *Teléfono del dueño*
Da Click en COMPRAR AHORA y levanta el pedido
Opciones de pago
Aceptamos las siguientes formas de pago: Efectivo (Solo Zona Metropolitana de Guadalajara), Tarjeta de crédito, Tarjeta de débito, Transferencia, PayPal.

Envío y devoluciones
Ofrecemos envío a todo el país y manejamos devoluciones o cambios en un plazo de 14 días después de recibir el producto.

Garantía
Ofrecemos una garantía de 1 año por defecto de fábrica en nuestros collares personalizados.

✅ ¡Contáctanos ahora mismo para ordenar el collar personalizado de tu mascota! 📞📩

Accesorios

Además de los collares, ofrecemos una variedad de accesorios para complementar el estilo y la seguridad de tu mascota:

Pecheras: Disponibles en varios anchos y tallas, puedes elegir hasta 4 colores a combinar.
Pecheras Personalizadas: Añade un toque personal con el nombre de tu mascota y reflejantes para mayor seguridad.
Arnes-Antijalones: Diseñados para controlar mejor a tu mascota sin causarle daño.
Correas: En diferentes largos y anchos para ajustarse a tus necesidades y las de tu mascota.
Cinturón de Seguridad: Para llevar a tu mascota segura en el coche.
Todos nuestros accesorios están diseñados pensando en la comodidad y seguridad de tu mascota, utilizando materiales de alta calidad y durabilidad.

*Pecheras con Nombre*
Ancho de 1.2 cm $270 pesos
      Tallas (XXS, XS, S)
 Ancho de 1.6 cm $320 pesos
      Tallas (XS, S, M)
 Ancho de 1.9 cm$350 pesos
      Tallas (S, M, L)
 Ancho de 2.5 cm $380 pesos
      Tallas (M, L, XL)
 Ancho de 3.2 cm $430 pesos
      Tallas (L, XL, XXL)
 _Puedes elegir hasta 4 colores a combinar y el color de las letras que gustes_ 

*Pecheras* 
Ancho de 1.2 cm $200 pesos
      Tallas (XXS, XS, S)
 Ancho de 1.6 cm $220 pesos
      Tallas (XS, S, M)
 Ancho de 1.9 cm$250 pesos
      Tallas (S, M, L)
 Ancho de 2.5 cm $280 pesos
      Tallas (M, L, XL)
 Ancho de 3.2 cm $330 pesos
      Tallas (L, XL, XXL)
  _Puedes elegir hasta 4 colores a combinaría  
      
*Correas*
Ancho de 1.2 cm, Largo (1.5 mts)
      $130 pesos     
 Ancho de 1.6 cm, Largo (1.5 mts, 1.8 mts) 
      $150 pesos
 Ancho de 1.6 cm, Largo (5 mts)
      $220 pesos
 Ancho de 1.9 cm,Largo (1.5 mts, 1.8 mts)
      $180 pesos
 Ancho de 1.9 cm, Largo (5 mts) 
      $280 pesos
 Ancho de 1.9 cm,Largo (10 mts) 
      $440 pesos
 Ancho de 2.5 cm, Largo (1.8 mts) 
      $220 pesos
 Ancho de 2.5 cm, Largo (2.3 mts)
      $250 pesos
Ancho de 2.5 cm, Largo (3 mts)
      $290 pesos
      
*Correa para el coche $150 pesos* 
      Ancho 2.5 cm

 *Arnés anti-jalones*
      Talla Chica $300 pesos
      Talla Mediana $350 pesos 
      Talla Grande $400 pesos 
      Talla Extra Grande $450 pesos 

*Arnés anti-jalones con collar sensillo*
      Talla Chica $420 pesos
      Talla Mediana $520pesos 
      Talla Grande $600 pesos 
      Talla Extra Grande $650
 pesos 

*Arnés anti-jalones con collar personalizado*
      Talla Chica $480 pesos
      Talla Mediana $580 pesos 
      Talla Grande $650 pesos 
      Talla Extra Grande $730pesos 

Cómo personalizar tu pedido

Visita nuestro sitio web o contáctanos directamente a través de WhatsApp.
Indica el producto de tu interés y la personalización deseada.
Procede con la selección de opciones de pago y envío.
¡Listo! Prepararemos tu pedido con el mayor cuidado y lo enviaremos a tu domicilio.
Recuerda que personalizar el accesorio de tu mascota no solo es un detalle de estilo, sino también una medida de seguridad importante para facilitar su identificación en caso de extravío.

Para más información, asesoramiento sobre productos o realizar un pedido, no dudes en contactarnos. Estamos aquí para ayudarte a elegir lo mejor para tu compañero peludo.

Cómo personalizar el collar
Sigue estos sencillos pasos para personalizar el collar con el nombre de tu mascota y tu teléfono:

Elige el tamaño y ancho
Elige el color del collar el color del fondo y el color de las letras
Escribe el nombre de tu mascota en el campo *Nombre de la mascota*
Escribe tu teléfono en el campo *Teléfono del dueño*
Da Click en COMPRAR AHORA y levanta el pedido

Opciones de pago
Aceptamos las siguientes formas de pago:

Efectivo (Solo Zona Metropilitana de Guadalajara)
Tarjeta de crédito
Tarjeta de débito
Transferencia
PayPal
Envío y devoluciones
Ofrecemos envío a todo el país y manejamos devoluciones o cambios en un plazo de 14 días después de recibir el producto.

Sujeto a disponibilidad 
⏰Tiempo de entrega es de entre 10 y 15 días hábiles

🚚 *El envío es gratis solo dentro de la zona metropolitana de Gdl* de acuerdo al mapa anexo.

Fuera de la zona metropolitana de Gdl se cotiza aparte

Garantía
Ofrecemos una garantía de 1 año por defecto de fabrica en nuestros collares personalizados.

DAtos a optener para realizar el pedido
*Datos del Collar*
- *Nombre de la mascota:* [Nombre de perro]
- *Ancho del collar:*[Ancho]
- *Teléfono:* [Telefono del dueño]
- *Color del collar:* [Color de cinta del collar]
- *Fondo del collar:* [Color de fondo]
- *Letras:* [Color de letras]
- *Largo del collar [Largo](*opcional)
- *Talla del collar:* [Talla](*opcional)
- *Solicitud especial:* [alguna observacion especial](*opcional)

*Tus Datos Personales:*
- *Nombre completo:* [Nombre cliente]
- *Correo electrónico:* [Correo electronico]
- *Dirección de entrega:* [domicilio, calle, numero, colonia, codigo postal, municipio y estado]


Broche de Seguridad
https://lamanadadeleo.com.mx/images/landigpage_16.jpg 
https://lamanadadeleo.com.mx/images/landigpage_1.jpg
Broche Normal
https://lamanadadeleo.com.mx/images/landigpage_17.jpg 
https://lamanadadeleo.com.mx/images/landigpage_2.jpg
para perro
broche https://lamanadadeleo.com.mx/images/landigpage_20.jpg
Martingale https://lamanadadeleo.com.mx/images/landigpage_19.jpg
Hebilla https://lamanadadeleo.com.mx/images/landigpage_18.jpg
Ancho de 1.2 cm https://lamanadadeleo.com.mx/images/collares_121.jpg 
https://lamanadadeleo.com.mx/images/collares_122.jpg
Ancho de 1.6 cm  https://lamanadadeleo.com.mx/images/collares_161.jpg https://lamanadadeleo.com.mx/images/collares_162.jpg
Ancho de 1.9 cm 
https://lamanadadeleo.com.mx/images/collares_191.jpg
https://lamanadadeleo.com.mx/images/collares_192.jpg
Ancho de 2.5 cm
https://lamanadadeleo.com.mx/images/collares_251.jpg
 https://lamanadadeleo.com.mx/images/collares_252.jpg
Ancho de 3.2 cm
https://lamanadadeleo.com.mx/images/collares_321.jpg
https://lamanadadeleo.com.mx/images/collares_322.jpg
Ancho de 3.8 cm
https://lamanadadeleo.com.mx/images/collares_381.jpg
https://lamanadadeleo.com.mx/images/collares_382.jpg

colores para  1.2, 1.6 , 1.9 y 2.5 cm
https://lamanadadeleo.com.mx/images/color_4.jpg
colores 3.2 cm
https://lamanadadeleo.com.mx/images/color_5.jpg
colores 3.8 cm
https://lamanadadeleo.com.mx/images/color_6.jpg

pechera simple
https://lamanadadeleo.com.mx/images/pecheras_5.jpg
Pecheras con nombre y telefono
https://lamanadadeleo.com.mx/images/pecheras_1.jpg

Arnes-Antijalones
https://lamanadadeleo.com.mx/images/arnes_1.jpg

Correas
https://lamanadadeleo.com.mx/images/correa.jpg

Cinturón Seguridad
https://lamanadadeleo.com.mx/images/cinturon_2.jpg 

";



//$promt =$sistema.", Importante esto se proyecta siempre en html directamente a una pagina web por lo que requiero la informacion sea presentada en un fomato html que se pueda ver en una app privada, no agregar ningun boton o enlace: ".$accion;
// Datos de la solicitud  	"id" => "asst_KDe8ZMJdKx0uRkpMPtGHJIVj", gpt-3.5-turbo gpt-3.5-turbo-16k gpt-4-1106-preview gpt-4-turbo-preview

$mensajes[] = ["role" => "assistant", "content" => $promt]; 
$mensajes[] = ["role" => "user", "content" => $body];

	$datos = [	
	    "model" => "gpt-4o",
	    "messages" => $mensajes
	];	




// URL de la API de Chat de OpenAI gpt-3.5-turbo  gpt-3.5-turbo-1106   gpt-4-1106-preview
$url_openai = "https://api.openai.com/v1/chat/completions";
// $url_openai = "https://api.openai.com/v1/threads/runs";

// Inicializar sesión cURL
$ch = curl_init($url_openai);

// Configurar opciones de cURL
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($datos));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer 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', // Asegúrate de mantener tu clave API en privado
    'Content-Type: application/json',
    'id: asst_dhGVXJgpQSjSzM0r4afmr0lI',

]);

// Enviar la solicitud y guardar la respuesta
$respuesta = curl_exec($ch);

// Verificar si hubo errores en la solicitud
if(curl_errno($ch)){
    echo 'Error en la solicitud cURL: ' . curl_error($ch);
}

// Cerrar sesión cURL
curl_close($ch);

// Imprimir la respuesta

file_put_contents("text_contenido.html", $respuesta);

//$jsonString = '{ "id": "chatcmpl-8eFbRKRhllhHH7urRgR2kKUriH2Ff", "object": "chat.completion", "created": 1704603789, "model": "gpt-3.5-turbo-0613", "choices": [ { "index": 0, "message": { "role": "assistant", "content": "Claro, puedo hacer varias cosas. Soy un modelo de lenguaje de inteligencia artificial llamado ChatGPT. Puedo responder preguntas, brindar información, ayudar con problemas, conversar sobre diferentes temas, jugar adivinanzas, contar chistes y más. ¿En qué te puedo ayudar hoy?" }, "logprobs": null, "finish_reason": "stop" } ], "usage": { "prompt_tokens": 28, "completion_tokens": 70, "total_tokens": 98 }, "system_fingerprint": null }';

// Convertir la cadena JSON en un objeto PHP
$responseObj = json_decode($respuesta);

//file_put_contents("text_contenido.html", $responseObj); 

//echo $respuesta."<hr>";

// Acceder al contenido del mensaje del asistente
$assistantMessage = $responseObj->choices[0]->message->content;
// Acceder al id del objeto
$chat_id = $responseObj->id;
// Acceder a total_tokens dentro del objeto usage
$totalTokens = $responseObj->usage->total_tokens;

// Imprimir el mensaje
echo $assistantMessage;

$timestamp = time();
$timestamp = date("Y-m-d H:i:s", $timestamp);

$insert1 ="
	INSERT IGNORE INTO whats_in 
		(
			whats_in.entry_id, 
			whats_in.display_phone_number, 
			whats_in.phone_number_id, 
			whats_in.`name`, 
			whats_in.wa_id, 
			whats_in.id, 
			whats_in.`timestamp`, 
			whats_in.body, 
			whats_in.type, 
			whats_in.estado,
			whats_in.chat_id
		) 
	VALUE
		(
			'$entry_id',
			'$display_phone_number',
			'$phone_number_id',
			'$name',
			'$wa_id',
			'$id',
			'$timestamp',
			'$assistantMessage',
			'text',
			'assistant',
			'$chat_id'
		) ";
      //echo $insert1."<hr>";
//file_put_contents("text.html", $insert1); 
      
$result_insert = ejecutar($insert1);
 //echo $result_insert."<hr>";

$sql = "SELECT
			max(entry_id) as entry_id
		FROM
			admin"; 
$result_insert = ejecutar($sql);
$row1 = mysqli_fetch_array($result_insert);
extract($row1); 


$update ="
UPDATE whats_contacto 
	SET chatId = '$chat_id'
WHERE
	wa_id = '$wa_id'
";
$result_update = ejecutar($update);

//file_put_contents("text.html", $assistantMessage); 

//$data = mesg_sal('text',$wa_id,'',$assistantMessage);

		$data = [
		    "messaging_product" => "whatsapp",
		    "to" => $wa_id,
		    "type" => "text",
		    "text" => [
		    	"preview_url" => false,
		        "body" => $assistantMessage    
		    	]
		];	

echo $data."<hr>";
$jsonParaEnviar = json_encode($data);
//file_put_contents("text.html", $jsonParaEnviar); 

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

// $response = envio_whatsapp($url,$accessToken,$data);
//file_put_contents("text.html", $response); 
// echo "<hr>Enviado";
}