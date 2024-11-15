<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://sandbox.factura.com/api/v4/cfdi40/create',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
     "Receptor" : {
        "UID": "6169fc02637e1"
      },
      "TipoDocumento":"factura",
      "Conceptos": [{
        "ClaveProdServ": "81112101",
        "Cantidad":1,
        "ClaveUnidad":"E48",
        "Unidad": "Unidad de servicio",
        "ValorUnitario": 229.90,
        "Descripcion": "Desarrollo a la medida",
        "AddendaEnvasesUniversales": {
            "idFactura": "1230",
            "fechaMensaje": "03/06/2024",
            "idTransaccion": "456GFD",
            "transaccion": "00001",
            "consecutivo": "EUM1234",
            "idPedido": "40YB34U33",
            "albaran": "50MXYU383",
            "monedaCve": "MXN",
            "tipoCambio": 1.0000,
            "totalM": "273.58",
            "subtotalM": "229.90",
            "impuestoM": "36.784",
            "baseImpuesto": "0.16"
            },
         "Impuestos":{
            "Traslados":[
               {
                  "Base": 229.90,
                  "Impuesto":"002",
                  "TipoFactor":"Tasa",
                  "TasaOCuota":"0.16",
                  "Importe":36.784
               }
            ],
            "Locales":[
                {
                    "Base": 229.90,
                    "Impuesto": "ISH",
                    "TipoFactor": "Tasa",
                    "TasaOCuota": "0.03",
                    "Importe": 6.897

                }
            ]
         }
      }],
      "UsoCFDI": "P01",
      "Serie": 17317,
      "FormaPago": "03",
      "MetodoPago": "PUE",
      "Moneda": "MXN",
      "EnviarCorreo": false
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'F-PLUGIN: 9d4095c8f7ed5785cb14c0e3b033eeb8252416ed',
    'F-Api-Key: JDJ5JDEwJE1Ma09wa3pvalNrRzhXT1FTY0gxUXVldm5Zb3VwZHI5bUpPQWt6Q1dyR1VjYWQzZ0Nrc1ph',
    'F-Secret-Key: JDJ5JDEwJEUvMmMwbkg1UUVJd1FXN3pFQU9zRGU4MUJ1QTBPb1E5VnVCckJtWkM5MFQ1ZWRDME5iQmVX'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
