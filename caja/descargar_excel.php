<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
extract($_SESSION);



require '../vendor/autoload.php';
include('../functions/funciones_mysql.php'); // Asegúrate de incluir el archivo donde está la función ejecutar()

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;




function exportToExcel() {
    // Crear la carpeta si no existe
    
extract($_POST);
//print_r($_POST);    
    
    $dir = 'exports';
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }

    // Parámetros de la consulta
    $empresa_id = 1; // Cambia por el ID de la empresa
    // $mes_sel = date('m'); // Cambia por el mes deseado
    // $anio_sel = date('Y'); // Cambia por el año deseado

    // Crear una nueva hoja de cálculo
    $spreadsheet = new Spreadsheet();
    $spreadsheet->removeSheetByIndex(0); // Eliminar la hoja predeterminada

    // Consultas SQL
    $queries = [
        'Cobros_Neuromodulacion' => "
            SELECT
                cobros.cobros_id,
                cobros.usuario_id,
                cobros.tipo,
                cobros.doctor,
                cobros.protocolo_ter_id,
                cobros.f_pago,
                cobros.importe,
                cobros.f_captura,
                cobros.h_captura,
                cobros.otros,
                cobros.paciente_id,
                (SELECT CONCAT(pacientes.paciente, ' ', pacientes.apaterno, ' ', pacientes.amaterno) AS paciente FROM pacientes WHERE pacientes.paciente_id = cobros.paciente_id) AS paciente,
                (SELECT DISTINCT CONCAT(paciente_consultorio.paciente, ' ', paciente_consultorio.apaterno, ' ', paciente_consultorio.amaterno) AS paciente FROM paciente_consultorio WHERE paciente_consultorio.paciente_cons_id = cobros.paciente_cons_id) AS paciente_con,
                cobros.empresa_id,
                admin.nombre,
                cobros.req_factura,
                cobros.ticket
            FROM
                cobros
                INNER JOIN admin ON cobros.usuario_id = admin.usuario_id
            WHERE
                cobros.empresa_id = $empresa_id
                AND cobros.doctor = 'Neuromodulacion GDL'
                AND MONTH(f_captura) = $mes_sel
                AND YEAR(f_captura) = $anio_sel
            ORDER BY
                cobros.f_captura DESC
        ",
        'Cobros_Dr_Aldana' => "
            SELECT
                cobros.cobros_id,
                cobros.usuario_id,
                cobros.tipo,
                cobros.doctor,
                cobros.protocolo_ter_id,
                cobros.f_pago,
                cobros.importe,
                cobros.f_captura,
                cobros.h_captura,
                cobros.otros,
                cobros.paciente_cons_id,
                cobros.paciente_consulta,
                cobros.empresa_id,
                cobros.consulta,
                admin.nombre,
                cobros.req_factura,
                cobros.ticket
            FROM
                cobros
                INNER JOIN admin ON cobros.usuario_id = admin.usuario_id
            WHERE
                cobros.empresa_id = $empresa_id
                AND cobros.doctor = 'Dr. Alejandro Aldana'
                AND MONTH(f_captura) = $mes_sel
                AND YEAR(f_captura) = $anio_sel
            ORDER BY
                cobros.f_captura DESC
        ",
        'Cobros_Dra_Eleonora' => "
            SELECT
                cobros.cobros_id,
                cobros.usuario_id,
                cobros.tipo,
                cobros.doctor,
                cobros.protocolo_ter_id,
                cobros.f_pago,
                cobros.importe,
                cobros.f_captura,
                cobros.h_captura,
                cobros.otros,
                cobros.paciente_cons_id,
                cobros.paciente_consulta,
                cobros.empresa_id,
                cobros.consulta,
                admin.nombre,
                cobros.req_factura,
                cobros.ticket
            FROM
                cobros
                INNER JOIN admin ON cobros.usuario_id = admin.usuario_id
            WHERE
                cobros.empresa_id = $empresa_id
                AND cobros.doctor = 'Dra. Eleonora Ocampo'
                AND MONTH(f_captura) = $mes_sel
                AND YEAR(f_captura) = $anio_sel
            ORDER BY
                cobros.f_captura DESC
        ",        
        'Pagos_Neuromodulacion' => "
            SELECT
                pagos.pagos_id,
                pagos.usuario_id,
                pagos.empresa_id,
                pagos.f_captura,
                pagos.h_captura,
                pagos.importe,
                pagos.tipo,
                pagos.f_pago,
                pagos.concepto,
                pagos.terapeuta AS terapeuta_id,
                (SELECT ad.nombre FROM admin AS ad WHERE ad.usuario_id = pagos.terapeuta) AS terapeuta,
                (SELECT ad.nombre FROM admin AS ad WHERE ad.usuario_id = pagos.usuario_id) AS usuario
            FROM
                pagos
            WHERE
                pagos.empresa_id = $empresa_id
                AND MONTH(f_captura) = $mes_sel
                AND YEAR(f_captura) = $anio_sel
                AND negocio = 'Neuromodulacion GDL'
            ORDER BY
                pagos.f_captura DESC
        ",
        'Pagos_Dr_Aldana' => "
            SELECT
                pagos.pagos_id,
                pagos.usuario_id,
                pagos.empresa_id,
                pagos.f_captura,
                pagos.h_captura,
                pagos.importe,
                pagos.tipo,
                pagos.f_pago,
                pagos.concepto,
                pagos.terapeuta AS terapeuta_id,
                pagos.negocio,
                (SELECT ad.nombre FROM admin AS ad WHERE ad.usuario_id = pagos.terapeuta) AS terapeuta,
                (SELECT ad.nombre FROM admin AS ad WHERE ad.usuario_id = pagos.usuario_id) AS usuario
            FROM
                pagos
            WHERE
                pagos.empresa_id = $empresa_id
                AND MONTH(f_captura) = $mes_sel
                AND YEAR(f_captura) = $anio_sel
                AND negocio = 'Dr. Alejandro Aldana'
            ORDER BY
                pagos.f_captura DESC
        ",
        'Pagos_Dra_Eleonora ' => "
            SELECT
                pagos.pagos_id,
                pagos.usuario_id,
                pagos.empresa_id,
                pagos.f_captura,
                pagos.h_captura,
                pagos.importe,
                pagos.tipo,
                pagos.f_pago,
                pagos.concepto,
                pagos.terapeuta AS terapeuta_id,
                pagos.negocio,
                (SELECT ad.nombre FROM admin AS ad WHERE ad.usuario_id = pagos.terapeuta) AS terapeuta,
                (SELECT ad.nombre FROM admin AS ad WHERE ad.usuario_id = pagos.usuario_id) AS usuario
            FROM
                pagos
            WHERE
                pagos.empresa_id = $empresa_id
                AND MONTH(f_captura) = $mes_sel
                AND YEAR(f_captura) = $anio_sel
                AND negocio = 'Dra. Eleonora Ocampo'
            ORDER BY
                pagos.f_captura DESC
        "        
    ];
    
//print_r($queries);
    // Añadir los datos a las diferentes hojas
    foreach ($queries as $sheetName => $sql) {
        $result = ejecutar($sql);
        if ($result) {
            if ($result->num_rows > 0) {
                $sheet = $spreadsheet->createSheet();
                $sheet->setTitle($sheetName);

                // Escribir los encabezados de la tabla
                $headers = array_keys($result->fetch_assoc());
                $sheet->fromArray($headers, NULL, 'A1');

                // Escribir los datos de la tabla
                $result->data_seek(0); // Volver al primer registro
                $rowIndex = 2; // Empezar desde la segunda fila
                while ($row = $result->fetch_assoc()) {
                    $sheet->fromArray(array_values($row), NULL, 'A' . $rowIndex);
                    $rowIndex++;
                }

                // Autoajustar el ancho de las columnas
                foreach (range('A', $sheet->getHighestColumn()) as $columnID) {
                    $sheet->getColumnDimension($columnID)->setAutoSize(true);
                }
            } else {
                echo "No se encontraron datos para la consulta en la hoja: $sheetName<br>";
            }
        } else {
            echo "Error en la consulta SQL para la hoja: $sheetName<br>";
        }
    }

    // Guardar el archivo Excel en la carpeta 'exports'
    $filename = 'cobros_pagos_de_mes_'.$mes_sel.'_anio_'.$anio_sel.'_creado_'. date('Ymd_His') . '.xlsx';
    $savePath = $dir . '/' . $filename;
    $writer = new Xlsx($spreadsheet);
    $writer->save($savePath);

    // Verificar si el archivo se guardó correctamente
    if (file_exists($savePath)) {
        echo "<b>Archivo guardado correctamente en: $savePath</b><br>";
    } else {
        echo "Error al guardar el archivo en el servidor<br>";
    }

    return $savePath; // Devolver la ruta del archivo guardado
}
    // // Añadir los datos a las diferentes hojas
    // foreach ($queries as $sheetName => $sql) {
        // $result = ejecutar($sql);
        // if ($result) {
            // $sheet = $spreadsheet->createSheet();
            // $sheet->setTitle($sheetName);
// 
            // // Escribir los encabezados de la tabla
            // $headers = array_keys($result->fetch_assoc());
            // $sheet->fromArray($headers, NULL, 'A1');
// 
            // // Escribir los datos de la tabla
            // $result->data_seek(0); // Volver al primer registro
            // $rowIndex = 2; // Empezar desde la segunda fila
            // while ($row = $result->fetch_assoc()) {
                // $sheet->fromArray(array_values($row), NULL, 'A' . $rowIndex);
                // $rowIndex++;
            // }
// 
            // // Autoajustar el ancho de las columnas
            // foreach (range('A', $sheet->getHighestColumn()) as $columnID) {
                // $sheet->getColumnDimension($columnID)->setAutoSize(true);
            // }
        // }
    // }
// 
    // // Guardar el archivo Excel en la carpeta 'exports'
    // $filename = 'cobros_pagos_de_mes_'.$mes_sel.'_anio_'.$anio_sel.'_creado_'. date('Ymd_His') . '.xlsx';
    // $savePath = $dir . '/' . $filename;
    // $writer = new Xlsx($spreadsheet);
    // $writer->save($savePath);
// 
    // // Verificar si el archivo se guardó correctamente
    // if (file_exists($savePath)) {
        // echo "<b>Archivo guardado correctamente <br>";
    // } else {
        // echo "Error al guardar el archivo en el servidor</b><br>";
    // }
// 
    // return $savePath; // Devolver la ruta del archivo guardado
// }

function sendEmailWithAttachment($filePath) {
    extract($_SESSION);	
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor de correo
        $mail->isSMTP();
        $mail->Host = 'mail.neuromodulacion.com.mx'; // Configura el servidor SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'contacto@neuromodulacion.com.mx'; // Correo SMTP
        $mail->Password = '1n%v&_*&FFc~'; // Contraseña SMTP
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587; // Cambiado a 587 para TLS

        // Habilitar el depurado
        $mail->SMTPDebug = 0; // 2; // Cambia a 3 para un depurado más detallado
        $mail->Debugoutput = 'html';

        // Remitente
        $mail->setFrom('contacto@neuromodulacion.com.mx', 'Neuromodulacion');

        // Destinatario
        $mail->addAddress('admin@neuromodulaciongdl.com', 'Georgina Ramirez');
		$mail->addCC('sanzaleonardo@gmail.com');
		$mail->addCC($usuario);
		
		
        // Adjuntar el archivo
        $mail->addAttachment($filePath);

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Reporte de Cobros y Pagos Generado '.date('d-m-Y');
        $mail->Body = 'Adjunto encontrarás el reporte de cobros y pagos en formato Excel.';

        $mail->send();
        echo 'El mensaje ha sido enviado con éxito';
    } catch (Exception $e) {
        echo "No se pudo enviar el mensaje. Error de correo: {$mail->ErrorInfo}";
    }
}
//print_r($_SESSION);
// Generar el archivo Excel y obtener la ruta del archivo guardado
$filePath = exportToExcel();

// Enviar el correo con el archivo adjunto
sendEmailWithAttachment($filePath);
?>