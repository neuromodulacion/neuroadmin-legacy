<?php

// Función que valida la existencia de una imagen y retorna la ruta válida
function valida_fotos($fotos_name) {
    // Elimina los espacios en blanco alrededor del nombre de la foto
	$fotos_name = trim($fotos_name);

    // Verificar si es una URL válida y si el archivo existe en la URL
    if (filter_var($fotos_name, FILTER_VALIDATE_URL)) {
        // Obtiene los encabezados HTTP de la URL proporcionada
        $headers = @get_headers($fotos_name, 1);
        // Verifica si el estado del encabezado es 200 (OK), lo que indica que el archivo existe
        if ($headers && strpos($headers[0], '200')) {
            // Si es una URL válida y el archivo existe, retorna la URL
            return $fotos_name;
        }
    }

    // Verificar si es un archivo local y si existe en la ruta proporcionada
    if (is_file($fotos_name)) {
        // Si el archivo existe localmente, retorna la ruta del archivo
        return $fotos_name;
    }

    // Verificar si la imagen existe en el directorio '../images/'
    if (is_file('../images/' . $fotos_name)) {
        // Si la imagen existe en el directorio '../images/', retorna la ruta correspondiente
        return '../images/' . $fotos_name;
    }

    // Array de extensiones soportadas para archivos de imagen
    $extensiones = ['jpeg', 'jpg', 'png', 'gif'];

    // Verificar si la imagen existe con diferentes extensiones en la ruta proporcionada
    foreach ($extensiones as $ext) {
        // Si encuentra un archivo con una de las extensiones soportadas, retorna la ruta del archivo
        if (is_file($fotos_name . "." . $ext)) {
            return $fotos_name . "." . $ext;
        }
    }

    // Verificar si la imagen existe con diferentes extensiones en el directorio '../images/'
    foreach ($extensiones as $ext) {
        // Si encuentra un archivo con una de las extensiones soportadas en el directorio '../images/', retorna la ruta del archivo
        if (is_file('../images/' . $fotos_name . "." . $ext)) {
            return '../images/' . $fotos_name . "." . $ext;
        }
    }

    // Si el archivo es un PDF, retorna una imagen predeterminada para PDFs
    if (is_file($fotos_name . ".pdf") || is_file('../images/' . $fotos_name . ".pdf")) {
        return "../images/pdf.jpg";
    }

    // Si no se encuentra la imagen, retorna una imagen predeterminada para indicar que no hay foto disponible
    return "../images/nofoto.png";
}

// Función que valida la existencia de una imagen para un encabezado y retorna la ruta válida
function valida_fotos_heder($fotos_name, $ruta) {
    // Verificar si el archivo existe en la ruta proporcionada
    if (is_file($fotos_name)) {
        if (is_file($fotos_name)) {
            // Si el archivo existe, asigna la ruta a $dir_file_fotos
            $dir_file_fotos = $fotos_name;
        } else {
            // Si el archivo no existe, asigna una ruta alternativa (esta parte parece no tener efecto ya que la condición se repite)
            $dir_file_fotos = $foto2;
        }
    } elseif (is_file($ruta . 'images/' . $fotos_name)) {
        // Verificar si el archivo existe en el directorio 'images/' dentro de la ruta proporcionada
        $dir_file_fotos = $ruta . 'images/' . $fotos_name;
    } elseif (is_file($fotos_name . ".jpeg")) {
        // Verificar si el archivo existe con la extensión .jpeg
        $dir_file_fotos = $fotos_name . ".jpeg";
    } elseif (is_file($fotos_name . ".jpg")) {
        // Verificar si el archivo existe con la extensión .jpg
        $dir_file_fotos = $fotos_name . ".jpg";
    } elseif (is_file($fotos_name . ".JPEG")) {
        // Verificar si el archivo existe con la extensión .JPEG
        $dir_file_fotos = $fotos_name . ".JPEG";
    } elseif (is_file($fotos_name . ".JPG")) {
        // Verificar si el archivo existe con la extensión .JPG
        $dir_file_fotos = $fotos_name . ".JPG";
    } elseif (is_file($fotos_name . ".PNG")) {
        // Verificar si el archivo existe con la extensión .PNG
        $dir_file_fotos = $fotos_name . ".PNG";
    } elseif (is_file($fotos_name . ".png")) {
        // Verificar si el archivo existe con la extensión .png
        $dir_file_fotos = $fotos_name . ".png";
    } elseif (is_file($fotos_name . ".gif")) {
        // Verificar si el archivo existe con la extensión .gif
        $dir_file_fotos = $fotos_name . ".gif";
    } elseif (is_file($fotos_name . ".GIF")) {
        // Verificar si el archivo existe con la extensión .GIF
        $dir_file_fotos = $fotos_name . ".GIF";
    } elseif (is_file($fotos_name . ".PDF")) {
        // Verificar si el archivo es un PDF y asignar la imagen predeterminada para PDFs
        $dir_file_fotos = $ruta . "images/pdf.jpg";
    } elseif (is_file($fotos_name . ".pdf")) {
        // Verificar si el archivo es un PDF con extensión en minúscula y asignar la imagen predeterminada para PDFs
        $dir_file_fotos = $ruta . "images/pdf.jpg";
    } else {
        // Si no se encuentra ninguna imagen, asigna una imagen predeterminada
        $dir_file_fotos = $ruta . "images/nofoto.jpg";
    }

    // Retorna la ruta del archivo de imagen válida
    return $dir_file_fotos; 
} 
?>
