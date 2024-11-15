hola <hr>
<?php
function ejecutar($sql){
    $mysqli = new mysqli("174.136.25.64", "lamanad1_conexion", "7)8S!K{%NBoL", "lamanad1_medico");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
    $resultado = $mysqli->query($sql);
    mysqli_close($mysqli);
    return $resultado;  
}

$json_data = '{
    "value": [
        {
            "ID": "e12c4c8b-65fe-4f0e-a6a3-096f84b8ce5e",
            "Code": "CMST TMS  30",
            "Cost": 0.0,
            "Title": "CONSULTA MEDICA EN SEGUIMIENTO A TRATAMIENTO DE ESTIMULACION MAGNETICA 30",
            "Description": "CONSULTA MEDICA EN SEGUIMIENTO A TRATAMIENTO DE ESTIMULACION MAGNETICA 30",
            "CreationDate": "2024-02-19T19:09:56.843",
            "Category1ID": null,
            "Category2ID": null,
            "Category3ID": null,
            "ChargeVAT": true,
            "PricingType": 0,
            "PricingTypeText": "Listas",
            "Unit": "SERVICIO",
            "CurrencyID": "b7e2c065-bd52-40ca-b508-3accdd538860",
            "CurrencyCode": "MXN",
            "VariableConcept": true,
            "SATCode": 1,
            "SATUnit": 3984
        },
        {
            "ID": "fe97a613-99bb-4425-9e78-0d22e5768717",
            "Code": "CMST  TDCS",
            "Cost": 0.0,
            "Title": "CONSULTAS MEDICAS SEGUIMIENTO TRATAMIENTO ESTIMULACION TRANSCRANEALPOR CORRIENTE DIRECTA",
            "Description": "CONSULTAS MEDICAS SEGUIMIENTO TRATAMIENTO ESTIMULACION TRANSCRANEALPOR CORRIENTE DIRECTA",
            "CreationDate": "2024-05-15T17:40:26.19",
            "Category1ID": null,
            "Category2ID": null,
            "Category3ID": null,
            "ChargeVAT": true,
            "PricingType": 0,
            "PricingTypeText": "Listas",
            "Unit": "SERVICIO",
            "CurrencyID": "b7e2c065-bd52-40ca-b508-3accdd538860",
            "CurrencyCode": "MXN",
            "VariableConcept": false,
            "SATCode": 1,
            "SATUnit": 3984
        },
        {
            "ID": "a0d6de8d-4e14-429d-81ca-1be82211d7fe",
            "Code": "CMS",
            "Cost": 0.0,
            "Title": "CONSULTA MEDICA SUBSECUENTE",
            "Description": "CONSULTA MEDICA SUBSECUENTE",
            "CreationDate": "2024-06-04T11:03:44.87",
            "Category1ID": null,
            "Category2ID": null,
            "Category3ID": null,
            "ChargeVAT": true,
            "PricingType": 0,
            "PricingTypeText": "Listas",
            "Unit": "SERVICIO",
            "CurrencyID": "b7e2c065-bd52-40ca-b508-3accdd538860",
            "CurrencyCode": "MXN",
            "VariableConcept": true,
            "SATCode": 1,
            "SATUnit": 3984
        },
        {
            "ID": "ff96a2de-378b-4225-96bc-41dffbc1733a",
            "Code": "CMST TDCS 15",
            "Cost": 0.0,
            "Title": "CONSULTA MEDICA SEGUIMIENTO TRATAMIENTO ESTIMULACION MAGNETICA TRANSCRANEAL",
            "Description": "CONSULTA MEDICA SEGUIMIENTO TRATAMIENTO ESTIMULACION MAGNETICA TRANSCRANEAL PE",
            "CreationDate": "2024-05-10T13:20:28.827",
            "Category1ID": null,
            "Category2ID": null,
            "Category3ID": null,
            "ChargeVAT": true,
            "PricingType": 0,
            "PricingTypeText": "Listas",
            "Unit": "SERVICIO",
            "CurrencyID": "b7e2c065-bd52-40ca-b508-3accdd538860",
            "CurrencyCode": "MXN",
            "VariableConcept": false,
            "SATCode": 1,
            "SATUnit": 3984
        },
        {
            "ID": "ef82a1ef-d1e7-4360-a334-55783f896013",
            "Code": "CMST TMS 30",
            "Cost": 0.0,
            "Title": "CONSULTA MEDICA EN SEGUIMIENTO DE TRATAMIENTO  ESTIMULACION MAGNETICA TRANSCRANEAL 30",
            "Description": "CONSULTA MEDICA EN SEGUIMIENTO DE TRATAMIENTO DE ESTIMULACION MAGNETICA TRANSCRANEAL PAGO UNA SOLA EXHIBICION",
            "CreationDate": "2024-02-19T19:12:52.463",
            "Category1ID": null,
            "Category2ID": null,
            "Category3ID": null,
            "ChargeVAT": true,
            "PricingType": 0,
            "PricingTypeText": "Listas",
            "Unit": "SERVICIO",
            "CurrencyID": "b7e2c065-bd52-40ca-b508-3accdd538860",
            "CurrencyCode": "MXN",
            "VariableConcept": true,
            "SATCode": 1,
            "SATUnit": 3984
        },
        {
            "ID": "f2c9264a-2afa-4a49-b9a8-62c85d610e90",
            "Code": "CM 1ER",
            "Cost": 0.0,
            "Title": "CONSULTA MEDICA 1ERA VEZ",
            "Description": "CONSULTA MEDICA PRIMERA VEZ",
            "CreationDate": "2024-06-04T11:01:46.777",
            "Category1ID": null,
            "Category2ID": null,
            "Category3ID": null,
            "ChargeVAT": true,
            "PricingType": 0,
            "PricingTypeText": "Listas",
            "Unit": "SERVICIO",
            "CurrencyID": "b7e2c065-bd52-40ca-b508-3accdd538860",
            "CurrencyCode": "MXN",
            "VariableConcept": true,
            "SATCode": 1,
            "SATUnit": 3984
        },
        {
            "ID": "8ae327b3-1254-41e4-b13d-91f25ac4cd95",
            "Code": "CMST TDCS 1",
            "Cost": 0.0,
            "Title": "CONSULTA MEDICA EN SEGUIMIENTO A TRATAMIENTO DE ESTIMULACION TRANSCRANEAL POR CORRIENTE DIRECTA",
            "Description": "CONSULTA MEDICA EN SEGUIMIENTO A TRATAMIENTO TDCS 1 CORRIENTE DIRECTA TRANSCRANEAL",
            "CreationDate": "2024-02-06T15:17:15.623",
            "Category1ID": null,
            "Category2ID": null,
            "Category3ID": null,
            "ChargeVAT": true,
            "PricingType": 0,
            "PricingTypeText": "Listas",
            "Unit": "Servicio",
            "CurrencyID": "b7e2c065-bd52-40ca-b508-3accdd538860",
            "CurrencyCode": "MXN",
            "VariableConcept": true,
            "SATCode": 51701,
            "SATUnit": 3984
        },
        {
            "ID": "a57e1a32-c9a9-484b-a296-95780fa00770",
            "Code": "CMST TDCS 15",
            "Cost": 0.0,
            "Title": "CONSULTA MEDICA EN SEGUIMIENTO A TRATAMIENTO CORRIENTE DIRECTA TRANSCRANEAL",
            "Description": "CONSULTA MEDICA EN SEGUIMIENTO A TRATAMIENTO CORRIENTE DIRECTA TRANSCRANEAL 15 CONTADO",
            "CreationDate": "2024-04-23T16:03:31.933",
            "Category1ID": null,
            "Category2ID": null,
            "Category3ID": null,
            "ChargeVAT": true,
            "PricingType": 0,
            "PricingTypeText": "Listas",
            "Unit": "SERVICIO",
            "CurrencyID": "b7e2c065-bd52-40ca-b508-3accdd538860",
            "CurrencyCode": "MXN",
            "VariableConcept": true,
            "SATCode": 51701,
            "SATUnit": 3984
        },
        {
            "ID": "a381dada-740e-4b35-a8a8-b16de6957b8d",
            "Code": "PF1",
            "Cost": 0.0,
            "Title": "CONSULTA MEDICA SEGUIMIENTO TRATAMIENTO TMS",
            "Description": "PF1 CONSULTA MEDICA SEGUIMIENTO TRATAMIENTO TMS",
            "CreationDate": "2024-05-10T13:23:03.81",
            "Category1ID": null,
            "Category2ID": null,
            "Category3ID": null,
            "ChargeVAT": true,
            "PricingType": 0,
            "PricingTypeText": "Listas",
            "Unit": "SERVICIO",
            "CurrencyID": "b7e2c065-bd52-40ca-b508-3accdd538860",
            "CurrencyCode": "MXN",
            "VariableConcept": true,
            "SATCode": 1,
            "SATUnit": 3984
        },
        {
            "ID": "635fa606-53f6-4866-9d20-c5aab2c84346",
            "Code": "CMST TDCS PE",
            "Cost": 0.0,
            "Title": "CONSULTAS MEDICAS SEGUIMIENTO TRATAMIENTO ESTIMULACION TRANSCRANEAL POR CORRIENTE DIRECTA",
            "Description": "CONSULTA MEDICA SEGUIMIENTO TRATAMIENTO ESTIMULACION TRANSCRANEAL POR CORRIENTE DIRECTA",
            "CreationDate": "2024-05-15T17:36:13.773",
            "Category1ID": null,
            "Category2ID": null,
            "Category3ID": null,
            "ChargeVAT": true,
            "PricingType": 0,
            "PricingTypeText": "Listas",
            "Unit": "SERVICIO",
            "CurrencyID": "b7e2c065-bd52-40ca-b508-3accdd538860",
            "CurrencyCode": "MXN",
            "VariableConcept": false,
            "SATCode": 1,
            "SATUnit": 3984
        },
        {
            "ID": "7934fc8a-c309-44d7-ad69-d83f4362ab78",
            "Code": "CMST TDCs PE",
            "Cost": 0.0,
            "Title": "CONSULTA MEDICA SEGUIMIENTO TRATAMIENTO ESTIMULACION MAGNETICA POR CORRIENTE DIRECTA 16",
            "Description": "CONSULTA MEDICA SEGUIMIENTO TRATAMIENTO ESTIMULACION MAGNETICA POR CORRIENTE DIRECTA",
            "CreationDate": "2024-05-02T18:49:07.147",
            "Category1ID": null,
            "Category2ID": null,
            "Category3ID": null,
            "ChargeVAT": true,
            "PricingType": 0,
            "PricingTypeText": "Listas",
            "Unit": "SERVICIO",
            "CurrencyID": "b7e2c065-bd52-40ca-b508-3accdd538860",
            "CurrencyCode": "MXN",
            "VariableConcept": true,
            "SATCode": 1,
            "SATUnit": 3984
        },
        {
            "ID": "bdc8e887-40d5-4051-bed5-e15bcc348f2f",
            "Code": "CMST TMS 1",
            "Cost": 0.0,
            "Title": "CONSULTA MEDICA EN SEGUIMIENTO TRATAMIENTO ESTIMULACIÓN MAGNETICA TRANSCRANEAL",
            "Description": "CONSULTA MEDICA EN SEGUIMIENTO A TRATAMIENTO DE TMS 1",
            "CreationDate": "2024-02-06T15:16:04.17",
            "Category1ID": null,
            "Category2ID": null,
            "Category3ID": null,
            "ChargeVAT": true,
            "PricingType": 0,
            "PricingTypeText": "Listas",
            "Unit": "Servicio",
            "CurrencyID": "b7e2c065-bd52-40ca-b508-3accdd538860",
            "CurrencyCode": "MXN",
            "VariableConcept": true,
            "SATCode": 1,
            "SATUnit": 3984
        }
    ],
    "nextLink": null,
    "count": 12
}';

echo $json_data."<hr>";

$data = json_decode($json_data, true);

foreach ($data["value"] as $item) {
    $ID = $item["ID"];
    $Code = $item["Code"];
    $Cost = $item["Cost"];
    $Title = $item["Title"];
    $Description = $item["Description"];
    $CreationDate = $item["CreationDate"];
    $Category1ID = !is_null($item["Category1ID"]) ? "'".$item["Category1ID"]."'" : "NULL";
    $Category2ID = !is_null($item["Category2ID"]) ? "'".$item["Category2ID"]."'" : "NULL";
    $Category3ID = !is_null($item["Category3ID"]) ? "'".$item["Category3ID"]."'" : "NULL";
    $ChargeVAT = $item["ChargeVAT"] ? 1 : 0;
    $PricingType = $item["PricingType"];
    $PricingTypeText = $item["PricingTypeText"];
    $Unit = $item["Unit"];
    $CurrencyID = $item["CurrencyID"];
    $CurrencyCode = $item["CurrencyCode"];
    $VariableConcept = $item["VariableConcept"] ? 1 : 0;
    $SATCode = $item["SATCode"];
    $SATUnit = $item["SATUnit"];

    $sql = "
    INSERT INTO consultas_medicas (ID, Code, Cost, Title, Description, CreationDate, Category1ID, Category2ID, Category3ID, ChargeVAT, PricingType, PricingTypeText, Unit, CurrencyID, CurrencyCode, VariableConcept, SATCode, SATUnit)
    VALUES ('$ID', '$Code', $Cost, '$Title', '$Description', '$CreationDate', $Category1ID, $Category2ID, $Category3ID, $ChargeVAT, $PricingType, '$PricingTypeText', '$Unit', '$CurrencyID', '$CurrencyCode', $VariableConcept, $SATCode, $SATUnit);
    ";
	echo $sql."<br>";
    ejecutar($sql);
}
?>
