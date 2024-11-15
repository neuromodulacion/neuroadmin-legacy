<?php

$url = "https://api.bind.com.mx/api/Invoices";
$curl = curl_init($url);

curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

# Request headers
$headers = array(
    'Content-Type: application/json',
    'Cache-Control: no-cache',
    'Ocp-Apim-Subscription-Key: neuromodulaciongdl',
    'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1bmlxdWVfbmFtZSI6Imdlb3JnaW5hIHJhbWlyZXp8MTI3NzkyIiwiSW50ZXJuYWxJRCI6ImVmNDc3NjhmLTA4Y2YtNGIzMi1hZGIzLTExYmI1YzY1NTk1NCIsIm5iZiI6MTcxMjc2OTU3NCwiZXhwIjoxNzQ0MzA1NTc0LCJpYXQiOjE3MTI3Njk1NzQsImlzcyI6Ik1pbm50X1NvbHV0aW9uc19TQV9ERV9DViIsImF1ZCI6IkJpbmRfRVJQX0FQSV9Vc2VycyJ9.CZKLXY1Dl9fanwsXj74BWgE7pVVpKqn26iTVke3kuaE',);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

# Request body
$request_body = '{
    "CurrencyID": "b7e2c065-bd52-40ca-b508-3accdd538860",
    "ClientID": "5f222f2c-ffce-41e7-a3a1-97e20c34a9eb",
    "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
    "WarehouseID": "7bd33fc1-9fc2-40a5-93d9-0da551c4408e",
    "CFDIUse": 3,
    "InvoiceDate": "2024-05-12T09:38:00",
    "PriceListID": "f7929bd7-a45b-4eef-b272-78bd36261754",
    "ExchangeRate": 1.0000,
    "ISRRetRate": 0.0000,
    "VATRetRate": 0.0000,
    "Comments": "string",
    "VATRate": 0.0000,
    "DiscountType": 0,
    "DiscountAmount": 0,
    "Services": [{
        "ID": "ff96a2de-378b-4225-96bc-41dffbc1733a",
        "Title": "CONSULTA MEDICA SEGUIMIENTO TRATAMIENTO ESTIMULACION MAGNETICA TRANSCRANEAL",
        "Price": 1.0000,
        "Qty": 1,
        "VAT": 0,
        "Comments": "prueba",
        "VATExempt": false,
        "IndexNumber": false,
        "VariableConcept": true,
        "OrderItemID": false
    }],
    "Emails": ["sanzaleonardo@gmail.com"],
    "PurchaseOrder": null,
    "CreditDays": 0,
    "IsFiscalInvoice": false,
    "ShowIEPS": true,
    "Number": 0,
    "Account": "105-03-001",
    "Payments": [{
        "PaymentMethod": 0,
        "AccountID": "690d3446-de60-4121-939c-0a308cd2c021",
        "Amount": 0,
        "Reference": "string",
        "ExchangeRate": 0,
        "ExchangeRateAccount": 0
    }],
    "Serie": "string",
    "Reference": "string",
    "PaymentTerm": 0
}';
curl_setopt($curl, CURLOPT_POSTFIELDS, $request_body);

$resp = curl_exec($curl);
curl_close($curl);
var_dump($resp);
?>