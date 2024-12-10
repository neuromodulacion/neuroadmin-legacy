<?php
// Incluir archivos de funciones necesarias
include('../functions/funciones_mysql.php');
include('../functions/email.php'); 
include('../api/funciones_api.php');

// Iniciar sesión y configuración de la zona horaria
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

// Ruta base
$ruta = "../";
extract($_SESSION);

// ID de moneda para Bind ERP
$CurrencyID = "b7e2c065-bd52-40ca-b508-3accdd538860"; 	

extract($_POST);
$ticket = time();	
// print_r($_POST);
// echo "<hr>";

// Validar y ajustar variables de protocolo y doctor
if ($protocolo_ter_id == '') {
    $protocolo_ter_id = $protocolo_ter_id1;
}

if ($doctor == '') {
    $doctor = $doctor1;
}

// Capturar fecha y hora actuales
$f_captura = date("Y-m-d");
$h_captura = date("H:i:s");

// Validar IDs de paciente
if ($paciente_id == '') {
    $paciente_id = 0;
}
if ($paciente_cons_id == '') {
    $paciente_cons_id = 0;
}

// Ajustar el nombre del doctor para ciertos tipos
if ($tipo == 'Renta Consultorio' || $tipo == 'Otros') {
    $doctor = 'Neuromodulacion GDL';
}

// Determinar listas de precios y otros detalles basados en el tipo
switch ($tipo) {
    case 'Consulta Medica':
        $PriceListID = "1c47a12f-2719-4315-9bf9-18ad44817679"; // ALDANA
        if ($consultax == 'Cita primera vez') {
            $ID = "f2c9264a-2afa-4a49-b9a8-62c85d610e90";
            $Title = "CONSULTA MEDICA 1ERA VEZ";
            $Description = "Cita primera vez";
        } else {
            $ID = "a0d6de8d-4e14-429d-81ca-1be82211d7fe";
            $Title = "CONSULTA MEDICA SUBSECUENTE";
            $Description = "Cita ordinaria";			
        }
        break;
    case 'Renta Consultorio':
    case 'Terapia':
    case 'Otros':
        $PriceListID = "f7929bd7-a45b-4eef-b272-78bd36261754"; // Neuromodulacion		
        break;
}

// Determinar la ubicación y almacén basados en el doctor
switch ($doctor) {
    case 'Neuromodulacion GDL':
        $LocationID = "5110f104-2530-4727-9edb-cb3d172c8b1d"; // Neuromodulacion
        $WarehouseID = "7bd33fc1-9fc2-40a5-93d9-0da551c4408e"; // Neuromodulacion
        break;
    case 'Dr. Alejandro Aldana':
        $LocationID = "b644ac68-663a-45fe-875e-fa4aee3f77c9"; // ALDANA
        $WarehouseID = "affa8228-2347-4cc3-92a1-547633ba7bf2"; // alejandro aldana
        break;
    case 'Dra. Eleonora Ocampo':
        $LocationID = "8be4576e-d656-4d5c-a845-ccc535b57bb6"; // Eleonora
        $WarehouseID = "f53cc729-7a81-4a6d-8cf9-67f1be902f36"; // Eleonora	
        break;		
    case 'Dr Capacitacion':
    case 'Capacitacion Neuromodulacion':
        $LocationID = "a790a1c9-fef8-47d7-8add-15a0089fe86c"; // PRUEBA
        $WarehouseID = "807a4560-f643-4c1c-94e1-c6871c018b1f"; // prueba
        break;	
}

// Insertar datos en la tabla de cobros
$insert = "
    INSERT IGNORE INTO cobros 
    ( 	
        cobros.usuario_id, 
        cobros.tipo, 
        cobros.doctor, 
        cobros.paciente_consulta,
        cobros.consulta,
        cobros.protocolo_ter_id, 
        cobros.f_pago, 
        cobros.importe, 
        cobros.f_captura, 
        cobros.h_captura,
        cobros.otros,
        cobros.cantidad,
        cobros.protocolo,
        cobros.ticket,
        cobros.facturado,
        cobros.email,
        cobros.empresa_id,
        cobros.paciente_id,
        cobros.paciente_cons_id,
        req_factura
    )
    values
    ( 
        $usuario_id,
        '$tipo',
        '$doctor',
        '$paciente_consulta',
        '$consulta',
        '$protocolo_ter_id',
        '$f_pago',
        $importe,
        '$f_captura',
        '$h_captura',
        '$otros',
        '$cantidad',
        '$protocolo',
        '$ticket',
        'no',
        '$email',
        '$empresa_id',
        '$paciente_id',
        '$paciente_cons_id',
        '$fact1'
    )
";	
 // echo "<hr>".$insert;
$result_insert = ejecutar($insert);

// echo "<hr>doctor ".$doctor."<br>";

// Obtener datos del paciente basados en el tipo de consulta
if ($tipo == 'Terapia') {
    $sql_medico = "
        SELECT
            pacientes.paciente_id, 
            pacientes.email, 
            pacientes.celular, 
            pacientes.id_bind as ClientID
        FROM
            pacientes
        WHERE
            pacientes.paciente_id = $paciente_id
    ";
    // echo $sql_medico."<hr>";
    $result_medico = ejecutar($sql_medico); 
    $row_medico = mysqli_fetch_array($result_medico); 
    extract($row_medico);	
} else {
    $sql_medico = "
        SELECT
            paciente_consultorio.paciente_cons_id, 
            paciente_consultorio.celular, 
            paciente_consultorio.email, 
            paciente_consultorio.id_bind as ClientID, 
            paciente_consultorio.medico
        FROM
            paciente_consultorio
        WHERE
            paciente_consultorio.paciente_cons_id = $paciente_cons_id
    ";
    // echo $sql_medico."<hr>";
    $result_medico = ejecutar($sql_medico); 
    $row_medico = mysqli_fetch_array($result_medico); 
    extract($row_medico);	
}

// Determinar la cuenta bancaria basada en el doctor y el método de pago
switch ($doctor) {
    case 'Neuromodulacion GDL':
        if ($f_pago == 'Efectivo' || $f_pago == 'Cortesía') {
            $AccountID = '63f2db72-7510-4996-b73e-1d14e8d4ea63'; // CAJA CHICA NEUROMODULACION GDL
        } else {
            $AccountID = '5edb1722-64cd-4236-9563-dcfe7edbde2d'; // BBVA NEUROMODULACION
        }		
        break;	
    case 'Dr Capacitacion':
    case 'Capacitacion Neuromodulacion':
        $AccountID = '00bf530b-a4d8-4859-b58d-8304b7f09eee'; // PRUEBA
        break;
    case 'Dr. Alejandro Aldana':
        if ($f_pago == 'Efectivo' || $f_pago == 'Cortesía') {
            $AccountID = 'bebc26c7-7e46-4330-a35f-8217057f7aea'; // CAJA CHICA JAAL
        } else {
            $AccountID = '0c49dc25-f1eb-449f-ba0b-170a3db4c515'; // MERCADO PAGO
        }			
        break;
    case 'Renta Consultorio':
        $AccountID = '63f2db72-7510-4996-b73e-1d14e8d4ea63'; // CAJA CHICA NEUROMODULACION GDL
        break;
    case 'Dra. Eleonora Ocampo':
        // Configuración adicional para Dra. Eleonora Ocampo si es necesario
        $AccountID = ''; // CAJA CHICA NEUROMODULACION GDL
        break;
}

// Procesar los costos si está presente
if (isset($_POST['costos_id'])) {
    $costos_id = $_POST['costos_id'];
    $partes = explode('|', $costos_id);

    if (count($partes) === 5) {
        list($id, $descripcion, $costo, $sesiones, $uuid) = $partes;
        $ID = htmlspecialchars($ID);
        $uuid = htmlspecialchars($uuid);
        $Description = htmlspecialchars($descripcion) . " Sesiones: " . htmlspecialchars($sesiones);
        $Title = htmlspecialchars($descripcion);
    } else {
        echo "El formato de la cadena 'costos_id' es incorrecto.";
    }
} else {
    echo "La variable 'costos_id' no está presente en el arreglo POST.";
}	

// Mostrar detalles para depuración
echo "<hr> CurrencyID: ".$CurrencyID.
    "<br>ClientID: ".$ClientID.
    "<br>LocationID: ".$LocationID.
    "<br>WarehouseID: ".$WarehouseID.
    "<br>PriceListID: ".$PriceListID.
    "<br>Comments: ".$tipo.
    "<br>ID: ".$ID.
    "<br>Title: ".$Title.
    "<br>importe: ".$importe.
    "<br>Description: ".$Description.
    "<br>email: ".$email.
    "<br>ticket: ".$ticket."<hr>";

// Configurar cantidad de venta
$Qty = 1; 					 
// Guardar la venta y obtener el ID de la remisión
$InvoiceID = guarda_venta($CurrencyID, $ClientID, $LocationID, $WarehouseID, $PriceListID, $tipo, $ID, $Title, $importe, $Qty, $Description, $email, $ticket);
// echo $InvoiceID."<hr>";
// echo $AccountID."  Cuenta de banco<hr>";
$resultado = procesa_pago($CurrencyID, $InvoiceID, $AccountID);
// echo $resultado;

// Actualizar saldo si el pago fue en efectivo
if ($f_pago == "Efectivo") {
    $update = "
        UPDATE admin
        SET admin.saldo = (admin.saldo + $importe)
        WHERE admin.usuario_id = $usuario_id	
    ";
    // echo "<hr>".$update;
    $result_update = ejecutar($update);			
}

// Enviar correo si se solicitó factura
if ($fact1 == 'Si') {
    $correo = "admin@neuromodulaciongdl.com";
    $nombre = "Administrador";
    $asunto = "Cliente solicita factura del ticket $ticket con RFC $rfc";
    $cuerpo_correo = "Cliente con ticket no. $ticket y $rfc solicita la facturacion
    <h2>Detalles del Ticket</h2>
    <div> 				    
        <p><strong>Ticket:</strong>$ticket</p>
        <p><strong>Razón Social:</strong>$cRazonSocial</p>
        <p><strong>RFC:</strong>$cRFC</p>
        <p><strong>Régimen:</strong>$aRegimen</p>
        <p><strong>Correo Electronico:</strong>$email_address</p>		    				       				    
        <p><strong>Nombre Calle:</strong>$cNombreCalle</p>
        <p><strong>Número Exterior:</strong>$cNumeroExterior</p>
        <p><strong>Número Interior:</strong>$cNumeroInterior</p>
        <p><strong>Código Postal:</strong>$cCodigoPostal</p>
        <p><strong>Colonia:</strong>$cColonia</p>
        <p><strong>Ciudad:</strong>$cCiudad</p>
        <p><strong>Estado:</strong>$cEstado</p>
        <p><strong>País:</strong>$cPais</p>
    </div>"; 
	
    $accion = "RFC";
    // echo "<hr>";
    $mail = correo_electronico($correo, $asunto, $cuerpo_correo, $nombre, $empresa_id, $accion);	
}

// Redirigir a la página de cobro
header("Location: cobro_test.php?a=1&ticket=$ticket");

/*
 * Incluir archivos de funciones necesarias: 
 *     Se incluyen los archivos PHP que contienen las funciones requeridas.
 * Iniciar sesión y configuración de la zona horaria: 
 *     Inicia la sesión y establece la configuración de la zona horaria y localización.
 * Ruta base: 
 *     Define la ruta base utilizada en el script.
 * ID de moneda para Bind ERP: 
 *     Se define el ID de la moneda para las transacciones con Bind ERP.
 * Validar y ajustar variables de protocolo y doctor: 
 *     Ajusta las variables de protocolo y doctor si no están definidas.
 * Capturar fecha y hora actuales: 
 *     Obtiene y formatea la fecha y hora actuales.
 * Validar IDs de paciente: 
 *     Asegura que los IDs de paciente estén definidos.
 * Ajustar el nombre del doctor para ciertos tipos: 
 *     Define el doctor como 'Neuromodulacion GDL' para ciertos tipos de transacciones.
 * Determinar listas de precios y otros detalles basados en el tipo: 
 *     Configura las listas de precios y otros detalles según el tipo de transacción.
 * Determinar la ubicación y almacén basados en el doctor: 
 *     Define la ubicación y el almacén según el doctor asignado.
 * Insertar datos en la tabla de cobros: 
 *     Realiza la inserción de los datos en la tabla de cobros en la base de datos.
 * Obtener datos del paciente basados en el tipo de consulta: 
 *     Realiza consultas adicionales para obtener datos del paciente según el tipo de consulta.
 * Determinar la cuenta bancaria basada en el doctor y el método de pago: 
 *     Configura la cuenta bancaria utilizada según el doctor y el método de pago.
 * Procesar los costos si está presente: 
 *     Valida y procesa la información de costos si está presente en la solicitud.
 * Mostrar detalles para depuración: 
 *     Imprime detalles de la transacción para fines de depuración.
 * Configurar cantidad de venta: 
 *     Define la cantidad de la venta como 1.
 * Guardar la venta y obtener el ID de la remisión: 
 *     Llama a la función para guardar la venta y obtiene el ID de la remisión.
 * Actualizar saldo si el pago fue en efectivo: 
 *     Actualiza el saldo del administrador si el pago fue en efectivo.
 * Enviar correo si se solicitó factura: 
 *     Envía un correo solicitando factura si se seleccionó esa opción.
 */
?>

