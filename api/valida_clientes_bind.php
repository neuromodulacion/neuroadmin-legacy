<?php

function ejecutar($sql){
    $mysqli = new mysqli("174.136.25.64","lamanad1_conexion","7)8S!K{%NBoL", "lamanad1_medico");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
    
    $resultado = $mysqli->query($sql);
    mysqli_close($mysqli);
    return $resultado;  
}   



// // Georgina
// $key = "neuromodulaciongdl";
// $authorization = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1bmlxdWVfbmFtZSI6Imdlb3JnaW5hIHJhbWlyZXp8MTI3NzkyIiwiSW50ZXJuYWxJRCI6ImVmNDc3NjhmLTA4Y2YtNGIzMi1hZGIzLTExYmI1YzY1NTk1NCIsIm5iZiI6MTcxMjc2OTU3NCwiZXhwIjoxNzQ0MzA1NTc0LCJpYXQiOjE3MTI3Njk1NzQsImlzcyI6Ik1pbm50X1NvbHV0aW9uc19TQV9ERV9DViIsImF1ZCI6IkJpbmRfRVJQX0FQSV9Vc2VycyJ9.CZKLXY1Dl9fanwsXj74BWgE7pVVpKqn26iTVke3kuaE";

// Leonardo
// $key = "neuromodulaciongdl";
// $authorization = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1bmlxdWVfbmFtZSI6Imxlb25hcmRvIHNhbnp8MTI3NzkyIiwiSW50ZXJuYWxJRCI6ImUzNzM4OWVkLTdmM2EtNDM0OS1iMmNmLTU3YTZmMDdjZDEwZCIsIm5iZiI6MTcxMzU0NTY3MiwiZXhwIjoxNzQ1MDgxNjcyLCJpYXQiOjE3MTM1NDU2NzIsImlzcyI6Ik1pbm50X1NvbHV0aW9uc19TQV9ERV9DViIsImF1ZCI6IkJpbmRfRVJQX0FQSV9Vc2VycyJ9.lA7OgjBx9QDh6dwMGkYeKdCa4eNTFlx7wtPy3gF7M_E";
// $cnt = 1;
// echo "<h1>Clients</h1>";
// $url = 'https://api.bind.com.mx/api/Clients?$skip:100';
// echo $url."<hr>";
// //$url = "https://api.bind.com.mx/api/Clients";
// $curl = curl_init($url);
// 
// curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
// curl_setopt($curl, CURLOPT_URL, $url);
// curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
// 
// $headers = array(
    // 'Cache-Control: no-cache',
    // 'Ocp-Apim-Subscription-Key: '.$key.'',
    // 'Authorization: Bearer '.$authorization.'' // Asegúrate de que el token JWT esté completo
// );
// curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
// 
// $resp = curl_exec($curl);
// if ($resp === false) {
    // echo 'Error de cURL: ' . curl_error($curl);
    // curl_close($curl);
    // exit;
// }
// curl_close($curl);

$resp = '
{
    "value": [
        {
            "ID": "498307d1-da81-407d-8c84-56c80311b1c4",
            "Number": 1236,
            "ClientName": "SANTIAGO TEST AYALA",
            "LegalName": "SANTIAGO TEST AYALA",
            "RFC": "XAXX010101000",
            "Email": "TEST@gmail.com",
            "Phone": "3338148472",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "01eb47fa-007f-4496-8694-56d5e9bfe83c",
            "Number": 1198,
            "ClientName": "Daniel  Plascencia  ",
            "LegalName": "Daniel  Plascencia  ",
            "RFC": "XAXX010101000",
            "Email": "danielplasdlt@gmail.com",
            "Phone": "56 23 34 55 18",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "19baa181-a568-4d58-9dde-5816dd017ff3",
            "Number": 1162,
            "ClientName": "Araceli  Palencia  Martell ",
            "LegalName": "Araceli  Palencia  Martell ",
            "RFC": "XAXX010101000",
            "Email": "med04rodrigo@gmail.com",
            "Phone": "33 3100 2368",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "f5804a13-ac8c-4071-8220-583062ee293f",
            "Number": 1156,
            "ClientName": "Karen  Navarro  Álvarez ",
            "LegalName": "Karen  Navarro  Álvarez ",
            "RFC": "XAXX010101000",
            "Email": "desarrollo1@protonmail.com",
            "Phone": "52 1 33 1348 2123",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "24cf73c2-3414-4001-aa84-585050687655",
            "Number": 1259,
            "ClientName": "Omar  Nuñez ",
            "LegalName": "Omar  Nuñez ",
            "RFC": "XAXX010101000",
            "Email": "no@no.com",
            "Phone": "33 10 20 86 47",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "615ab41f-1092-4bc3-aa7a-5b6fc08a3377",
            "Number": 1022,
            "ClientName": "Roxana del Carmen Sanz Reyes",
            "LegalName": "Roxana del Carmen Sanz Reyes",
            "RFC": "XAXX010101000",
            "Email": "roxysanz@live.com",
            "Phone": "3338148472",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "3dabe845-a673-4218-ac10-5ba187b362d8",
            "Number": 1281,
            "ClientName": "Beatriz Amalia  Suarez  Tamayo",
            "LegalName": "Beatriz Amalia  Suarez  Tamayo",
            "RFC": "XAXX010101000",
            "Email": "no@no.com",
            "Phone": "374 104 22 22",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "7db5519a-684a-4348-b8e9-5be873e92f87",
            "Number": 1214,
            "ClientName": "Marcela Priscila  Ruiz  Perea",
            "LegalName": "Marcela Priscila  Ruiz  Perea",
            "RFC": "XAXX010101000",
            "Email": "no@no.com",
            "Phone": "33 14 22 93 55 ",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "acafb7ff-bc54-49e0-a43c-5cc3bce21c7a",
            "Number": 1008,
            "ClientName": "José Raúl Ramos Estrada",
            "LegalName": "José Raúl Ramos Estrada",
            "RFC": "XAXX010101000",
            "Email": "coord.medica@manonvachez.com",
            "Phone": "3333913303",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "8e974fa6-42c2-4ec6-b82f-5cc415318e0f",
            "Number": 1157,
            "ClientName": "Beatriz de Guadalupe Alcantar  Garibay",
            "LegalName": "Beatriz de Guadalupe Alcantar  Garibay",
            "RFC": "XAXX010101000",
            "Email": "no@no.com",
            "Phone": "3326357007",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": "616"
        },
        {
            "ID": "f506baec-b4b8-4cbf-8f01-5ce9eda5525c",
            "Number": 1045,
            "ClientName": "Javier Alejandro Rodríguez Núñ-ez",
            "LegalName": "Javier Alejandro Rodríguez Núñ-ez",
            "RFC": "XAXX010101000",
            "Email": "no@no.com",
            "Phone": "3319741259",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "56700323-c09f-408d-91cd-5e6fafd8752b",
            "Number": 1147,
            "ClientName": "María Guadalupe Delgadillo Lara",
            "LegalName": "María Guadalupe Delgadillo Lara",
            "RFC": "XAXX010101000",
            "Email": "no@aplica.com",
            "Phone": "3781009514‬",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "bc3b2755-4bcf-4a97-b7db-5f6ece4c038a",
            "Number": 1006,
            "ClientName": "Edgar Fabricio Blanco Gallegos",
            "LegalName": "Edgar Fabricio Blanco Gallegos",
            "RFC": "XAXX010101000",
            "Email": "efabricio@hotmail.com",
            "Phone": "354 541 0141",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "7770347d-f9b7-49ca-b169-6370f2c43e16",
            "Number": 1114,
            "ClientName": "Carmen Janete  Gónzalez  Delgado",
            "LegalName": "Carmen Janete  Gónzalez  Delgado",
            "RFC": "XAXX010101000",
            "Email": "gonzalezjanette@gmail.com",
            "Phone": "33 1301 4654",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "f738cc6a-3855-4756-916b-63a249244d35",
            "Number": 1171,
            "ClientName": "Daniel  Garibay González",
            "LegalName": "Daniel  Garibay González",
            "RFC": "XAXX010101000",
            "Email": "no@no.com",
            "Phone": "33 2042 0672",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "d9c60315-058a-44cb-91e8-641564b55020",
            "Number": 1161,
            "ClientName": "Jazmin López Olguin",
            "LegalName": "Jazmin López Olguin",
            "RFC": "XAXX010101000",
            "Email": "jazminolguin1990@gmail.com",
            "Phone": "3334647220",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "97fa4f86-f8f2-41d0-9ec1-64dab8f4de3f",
            "Number": 1227,
            "ClientName": "Juan Gabriel  Chavez ",
            "LegalName": "Juan Gabriel  Chavez ",
            "RFC": "XAXX010101000",
            "Email": "no@no.com",
            "Phone": "33 17 96 71 68",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "77204508-d691-4cde-8d43-6600983f9d92",
            "Number": 1088,
            "ClientName": "Elsa Margarita Altamirano Valdéz",
            "LegalName": "Elsa Margarita Altamirano Valdéz",
            "RFC": "XAXX010101000",
            "Email": "no@no.com",
            "Phone": "3316054711",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "28bb05cc-4543-4e7e-b88e-677ab343d895",
            "Number": 1139,
            "ClientName": "Melissa Coss Hernández",
            "LegalName": "Melissa Coss Hernández",
            "RFC": "XAXX010101000",
            "Email": "pendiente@gmail.com",
            "Phone": "33 3258 2926",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "ddc1680b-7f4d-4d50-bd43-6790687d8b54",
            "Number": 1224,
            "ClientName": "Luisa Fernanda  Romero ",
            "LegalName": "Luisa Fernanda  Romero ",
            "RFC": "XAXX010101000",
            "Email": "no@no.com",
            "Phone": "33 12 19 44 30",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "0b5fd591-52b2-4ce5-b1ed-67ce9bfb2920",
            "Number": 1101,
            "ClientName": "Octavio Francisco Silva",
            "LegalName": "Octavio Francisco Silva",
            "RFC": "XAXX010101000",
            "Email": "no@no.com",
            "Phone": "3323707715",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "5a2b74b8-0338-4d28-a14d-68da48d74613",
            "Number": 1168,
            "ClientName": "Marian  Quirarte  Sánchez ",
            "LegalName": "Marian  Quirarte  Sánchez ",
            "RFC": "XAXX010101000",
            "Email": "drsergio.campos@hotmail.com",
            "Phone": "3318570315",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "68b509a6-1988-4b13-b455-69c739b7b859",
            "Number": 1035,
            "ClientName": "Maria Elena Ramos Marcial",
            "LegalName": "Maria Elena Ramos Marcial",
            "RFC": "XAXX010101000",
            "Email": "no@no.com",
            "Phone": "3312986068",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "24f9bee9-bf01-4b66-b9f2-6a16b0943cd3",
            "Number": 1318,
            "ClientName": "Juan Sebastián Martínez Ramírez",
            "LegalName": "Juan Sebastián Martínez Ramírez",
            "RFC": "XAXX010101000",
            "Email": "pendiente@pendiente.com",
            "Phone": "33 1397 8820",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "b408eb3c-346b-4885-8d45-6a2d8a0f41cf",
            "Number": 1054,
            "ClientName": "Cesar Manuel  Lepe Medina",
            "LegalName": "Cesar Manuel  Lepe Medina",
            "RFC": "XAXX010101000",
            "Email": "no@no.com",
            "Phone": "3318324640",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "619e029c-b958-43f0-8826-6a4af13fa043",
            "Number": 1099,
            "ClientName": "Ana Karen Ríos Velazco",
            "LegalName": "Ana Karen Ríos Velazco",
            "RFC": "XAXX010101000",
            "Email": "no@no.com",
            "Phone": "3331673328",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "47036ba3-87e5-4fad-8d93-6b174b43148c",
            "Number": 1248,
            "ClientName": "Casa Luah  ",
            "LegalName": "Casa Luah  ",
            "RFC": "XAXX010101000",
            "Email": "Contabilidad@manonvachez.com",
            "Phone": "33 15 33 13 72 ",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "bd3d9fb0-bb9d-404e-862c-6b6aeb1e5e53",
            "Number": 1302,
            "ClientName": "test1 test test",
            "LegalName": "test1 test test",
            "RFC": "XAXX010101000",
            "Email": "test1@gmail.com",
            "Phone": "3338148472",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "365041bb-5f2f-4ae4-9ca5-6bc74c012ed2",
            "Number": 1282,
            "ClientName": "Casa Luah  ",
            "LegalName": "Casa Luah  ",
            "RFC": "XAXX010101000",
            "Email": "Contabilidad@manonvachez.com",
            "Phone": "33 15 33 13 72 ",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "1085ab1e-43c5-4af2-a34b-6d40d042101c",
            "Number": 1189,
            "ClientName": "MARIA GUADALUPE LEAL SANCHEZ",
            "LegalName": "MARIA GUADALUPE LEAL SANCHEZ",
            "RFC": "XAXX010101000",
            "Email": "lgeorginaleal@gmail.com",
            "Phone": "311 166 76 39",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "1af1d223-fd6d-498b-8d23-6d6474f9169f",
            "Number": 1226,
            "ClientName": "Fernando  Chavez  ",
            "LegalName": "Fernando  Chavez  ",
            "RFC": "XAXX010101000",
            "Email": "no@no.com",
            "Phone": "33 14 44 64 69",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "1f04a63e-481f-4177-a99e-6dd07040291d",
            "Number": 1197,
            "ClientName": "Beatriz  Torres ",
            "LegalName": "Beatriz  Torres ",
            "RFC": "XAXX010101000",
            "Email": "beatriztorresss@gmail.com",
            "Phone": "333 955 61 32",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "73ffdcd9-2afe-486c-be57-6f6546fe7207",
            "Number": 1113,
            "ClientName": "Pedro García Mayer",
            "LegalName": "Pedro García Mayer",
            "RFC": "XAXX010101000",
            "Email": "marleneangeles28@gmail.com",
            "Phone": "33 1166 2703",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "517428a2-9d94-4634-9bf9-7043627679c8",
            "Number": 1293,
            "ClientName": "Juan Gabriel  Chavez ",
            "LegalName": "Juan Gabriel  Chavez ",
            "RFC": "XAXX010101000",
            "Email": "no@no.com",
            "Phone": "33 17 96 71 68",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "6bee615c-155e-42b0-a730-713f461a2716",
            "Number": 1235,
            "ClientName": "Daniel  Plascencia  ",
            "LegalName": "Daniel  Plascencia  ",
            "RFC": "XAXX010101000",
            "Email": "danielplasdlt@gmail.com",
            "Phone": "56 23 34 55 18",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "59beafd3-e034-47f1-918e-726fbfa79e4e",
            "Number": 1247,
            "ClientName": "Casa Luah  ",
            "LegalName": "Casa Luah  ",
            "RFC": "XAXX010101000",
            "Email": "Contabilidad@manonvachez.com",
            "Phone": "33 15 33 13 72 ",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "0e93c67a-9d6d-4bb1-bb73-7276373d7970",
            "Number": 1275,
            "ClientName": "Jovita  Galvan  ",
            "LegalName": "Jovita  Galvan  ",
            "RFC": "XAXX010101000",
            "Email": "no@no.com",
            "Phone": "55 38 77 81 24 ",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "44e989eb-d869-4bd5-9126-7335adce55cc",
            "Number": 1023,
            "ClientName": "Juan Pedro Echeveste García de Alba",
            "LegalName": "Juan Pedro Echeveste García de Alba",
            "RFC": "XAXX010101000",
            "Email": "juanpedroe@hotmail.com",
            "Phone": "3314115761",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "4933d3a8-bcd3-407b-8296-73d9535224dd",
            "Number": 1120,
            "ClientName": "Raquel Castillo Oregel",
            "LegalName": "Raquel Castillo Oregel",
            "RFC": "XAXX010101000",
            "Email": "osgarcia8@yahoo.com",
            "Phone": "351 128 6450",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "3caed9d4-1f08-4b0b-8778-759950857ab4",
            "Number": 1270,
            "ClientName": "SANTIAGO TEST AYALA",
            "LegalName": "SANTIAGO TEST AYALA",
            "RFC": "XAXX010101000",
            "Email": "TEST@gmail.com",
            "Phone": "3338148472",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "b42a09ea-7230-4de0-8e9f-75b06b0f13f1",
            "Number": 1016,
            "ClientName": "Abel de Jesús Aguilar Castañeda",
            "LegalName": "Abel de Jesús Aguilar Castañeda",
            "RFC": "XAXX010101000",
            "Email": "admin@neuromodulaciongdl.com",
            "Phone": "33 1457 3737\n33 1047 5648",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": "605"
        },
        {
            "ID": "2f7ccd50-8b68-4966-9024-776f2882822a",
            "Number": 1170,
            "ClientName": "Sergio López Carrillo",
            "LegalName": "Sergio López Carrillo",
            "RFC": "XAXX010101000",
            "Email": "no@no.com",
            "Phone": "33 1904 4794",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "25ba0ace-d775-42f8-ae55-7789554e714e",
            "Number": 1217,
            "ClientName": "Casa Luah  ",
            "LegalName": "Casa Luah  ",
            "RFC": "XAXX010101000",
            "Email": "Contabilidad@manonvachez.com",
            "Phone": "33 15 33 13 72 ",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "8f4fee82-742b-4228-b689-77f3b3941343",
            "Number": 1000,
            "ClientName": "Público en General",
            "LegalName": "Público en General",
            "RFC": "XAXX010101000",
            "Email": "",
            "Phone": "",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "387623fc-2c88-414d-ba1a-786f78662c63",
            "Number": 1057,
            "ClientName": "Liliana Lizbeth  Santillan   Alonso",
            "LegalName": "Liliana Lizbeth  Santillan   Alonso",
            "RFC": "XAXX010101000",
            "Email": "no@no.com",
            "Phone": "3320780004",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "22e3308f-5e40-41c6-b826-7ae1a6905086",
            "Number": 1063,
            "ClientName": "María Guadalupe  Barba  Ibarra ",
            "LegalName": "María Guadalupe  Barba  Ibarra ",
            "RFC": "XAXX010101000",
            "Email": "no@no.com",
            "Phone": "",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "d28900b7-9a44-4179-b839-7b479ec19507",
            "Number": 1225,
            "ClientName": "Ana Paula  Meixueiro ",
            "LegalName": "Ana Paula  Meixueiro ",
            "RFC": "XAXX010101000",
            "Email": "no@no.com",
            "Phone": "33 13 96 27 61 ",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "50dd39c0-a806-4c3e-a987-7bb7b227c35f",
            "Number": 1269,
            "ClientName": "SANTIAGO TEST AYALA",
            "LegalName": "SANTIAGO TEST AYALA",
            "RFC": "XAXX010101000",
            "Email": "TEST@gmail.com",
            "Phone": "3338148472",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "b4aaa4be-ce34-4429-be43-7bc2c06dffaa",
            "Number": 1003,
            "ClientName": "América Cecilia Pérez Morelos",
            "LegalName": "América Cecilia Pérez Morelos",
            "RFC": "XAXX010101000",
            "Email": "ameperez74@gmail.com",
            "Phone": "+1 (386) 916-6389",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "35dd395e-fd92-4082-8da8-7ccb2eaea2f0",
            "Number": 1182,
            "ClientName": "Adriana Perpuli Davis",
            "LegalName": "Adriana Perpuli Davis",
            "RFC": "PEDX771124KU7",
            "Email": "adrianaperpuli986@gmail.com",
            "Phone": "33 1326 6190",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": "606"
        },
        {
            "ID": "1dc3fe2f-ca8f-4778-9918-7f49829b3aac",
            "Number": 1260,
            "ClientName": "Jaime Miguel  Enriquez  Díaz",
            "LegalName": "Jaime Miguel  Enriquez  Díaz",
            "RFC": "XAXX010101000",
            "Email": "no@no.com",
            "Phone": "3322424022",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "bcd34178-f85c-4843-aac0-827829cbd9e3",
            "Number": 1261,
            "ClientName": "Adan Nestor Chavez ",
            "LegalName": "Adan Nestor Chavez ",
            "RFC": "XAXX010101000",
            "Email": "no@no.com",
            "Phone": "33 13 51 83 73 ",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "e8fc9aee-505e-46e5-9c15-83316aa65230",
            "Number": 1055,
            "ClientName": "José Juan Covarrubias González",
            "LegalName": "José Juan Covarrubias González",
            "RFC": "XAXX010101000",
            "Email": "no@no.com",
            "Phone": "3331703904",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "b8644728-c405-4fc0-86a6-837ee5865e1c",
            "Number": 1230,
            "ClientName": "Adan Nestor Chavez ",
            "LegalName": "Adan Nestor Chavez ",
            "RFC": "XAXX010101000",
            "Email": "no@no.com",
            "Phone": "33 13 51 83 73 ",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "4ee9fa7a-64aa-41d0-b028-83cfacec7ac3",
            "Number": 1160,
            "ClientName": "Edgardo Osorno López",
            "LegalName": "Edgardo Osorno López",
            "RFC": "XAXX010101000",
            "Email": "edwatches1@hotmail.com",
            "Phone": "3334061079",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "dde9f1e1-72fb-44f1-8d6c-83f8bda25bdc",
            "Number": 1062,
            "ClientName": "Yoli Márquez Vega",
            "LegalName": "Yoli Márquez Vega",
            "RFC": "XAXX010101000",
            "Email": "no@no.com",
            "Phone": "3335760538",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "c287ebc1-532c-4d0f-b0ca-8527d7e861be",
            "Number": 1053,
            "ClientName": "Yami García ",
            "LegalName": "Yami García ",
            "RFC": "XAXX010101000",
            "Email": "no@no.com",
            "Phone": "3310967033",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "47cc37ed-ce97-4b19-a405-85c658ee5288",
            "Number": 1193,
            "ClientName": "Felix Palau ",
            "LegalName": "Felix Palau ",
            "RFC": "XAXX010101000",
            "Email": "felixpalaul@yahoo.com",
            "Phone": "3331901103",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "796ba160-f1dd-4a5e-9b4c-87782d376c98",
            "Number": 1005,
            "ClientName": "Salvador Medardo de La Torre Ascensio",
            "LegalName": "Salvador Medardo de La Torre Ascensio",
            "RFC": "XAXX010101000",
            "Email": null,
            "Phone": "33 1957 8568",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": "601"
        },
        {
            "ID": "6fb3a13a-d7bd-4ef8-acc1-8820eb3f94b6",
            "Number": 1312,
            "ClientName": "Rosalba  Gutiérrez  Hernández ",
            "LegalName": "Rosalba  Gutiérrez  Hernández ",
            "RFC": "XAXX010101000",
            "Email": "xxx@hotmail.com",
            "Phone": "33 1441 3373",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "b8c871de-a0c4-43d3-b589-88374141012a",
            "Number": 1152,
            "ClientName": "Carlos Gabriel Ochoa Ramos",
            "LegalName": "Carlos Gabriel Ochoa Ramos",
            "RFC": "XAXX010101000",
            "Email": "drakaremguerrero@gmail.com",
            "Phone": "3314236038",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "1f70524d-d17a-42c5-a6cc-8936e7861248",
            "Number": 1104,
            "ClientName": "Jesús alejandro Aldana Lopez",
            "LegalName": "Jesús alejandro Aldana Lopez",
            "RFC": "AALJ871226N11",
            "Email": "no@no.com",
            "Phone": "",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": "612"
        },
        {
            "ID": "f9a33f5f-d443-492b-a856-896c81c4e353",
            "Number": 1047,
            "ClientName": "Diana Guadalupe Ramirez Silva",
            "LegalName": "Diana Guadalupe Ramirez Silva",
            "RFC": "XAXX010101000",
            "Email": "no@no.com",
            "Phone": "3326245019",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "25409030-d917-436f-8738-8979a8396abf",
            "Number": 1209,
            "ClientName": "Consuelo  Camacho ",
            "LegalName": "Consuelo  Camacho ",
            "RFC": "XAXX010101000",
            "Email": "no@no.com",
            "Phone": "722 764 49 71 ",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "76726580-d8b8-474a-a2b9-8a0e3178eadb",
            "Number": 1018,
            "ClientName": "Santiago Leonardo Sanz Ayala test",
            "LegalName": "Santiago Leonardo Sanz Ayala",
            "RFC": "XAXX010101000",
            "Email": "sanzaleonardo@gmail.com",
            "Phone": null,
            "NextContactDate": null,
            "LocationID": null,
            "RegimenFiscal": "616"
        },
        {
            "ID": "70bc02fc-57e2-48ab-9e8c-8a14a0f81940",
            "Number": 1123,
            "ClientName": "Ximena Padilla Saldate",
            "LegalName": "Ximena Padilla Saldate",
            "RFC": "XAXX010101000",
            "Email": "dr.alejandro.aldana@gmail.com",
            "Phone": "3310745265",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "9be5f770-c8e9-483e-8dd1-8b6c8d7a05e9",
            "Number": 1320,
            "ClientName": "LEONARDO SANZ AYALA",
            "LegalName": "LEONARDO SANZ AYALA",
            "RFC": "XAXX010101000",
            "Email": "sanzaleonardo@gmail.com",
            "Phone": "3338148472",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "b5a1f055-d41d-4656-b27d-8b6e3fbf9c0c",
            "Number": 1021,
            "ClientName": "Santiago Leonardo Sanz Ayala",
            "LegalName": "Santiago Leonardo Sanz Ayala",
            "RFC": "XAXX010101000",
            "Email": "sanzaleonardo@gmail.com",
            "Phone": "3338148472",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "81ea493a-b7e5-4deb-af4b-8c654e15f181",
            "Number": 1046,
            "ClientName": "María Candelaria Aceves Camarena",
            "LegalName": "María Candelaria Aceves Camarena",
            "RFC": "XAXX010101000",
            "Email": "no@no.com",
            "Phone": "3481048755",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "d0b06902-c936-4bcf-9d51-8cb0a77ce156",
            "Number": 1191,
            "ClientName": "Roxana del Carmen Sanz Reyes",
            "LegalName": "Roxana del Carmen Sanz Reyes",
            "RFC": "XAXX010101000",
            "Email": "roxysanz@gmail.com",
            "Phone": "3312505796",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "e9f45630-848f-420d-a7d6-8cc27637548e",
            "Number": 1238,
            "ClientName": "Alejandro Sanz lopez",
            "LegalName": "Alejandro Sanz lopez",
            "RFC": "XAXX010101000",
            "Email": "sanz@prueba.com",
            "Phone": "33333454565",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "a1126121-549f-488f-a12e-8d7a10200a60",
            "Number": 1029,
            "ClientName": "Alejandro Najar Hinojosa",
            "LegalName": "Alejandro Najar Hinojosa",
            "RFC": "XAXX010101000",
            "Email": "no@no.com",
            "Phone": "3336768106",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "192a4cfb-345f-4cc8-b13f-8ebb55c59082",
            "Number": 1136,
            "ClientName": "Ana Sofía Macedo Domínguez ",
            "LegalName": "Ana Sofía Macedo Domínguez ",
            "RFC": "XAXX010101000",
            "Email": "asmacedod@gmail.com",
            "Phone": " 33 2714 3299",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "f7897543-3605-4b74-a815-8f6bfc2dd6be",
            "Number": 1140,
            "ClientName": "Edwin Sánchez Romero",
            "LegalName": "Edwin Sánchez Romero",
            "RFC": "XAXX010101000",
            "Email": "vanesgael@hotmail.com",
            "Phone": "‪33 1292 3123‬",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "34ba5e18-f81e-4e3a-9166-9070dc88d80d",
            "Number": 1279,
            "ClientName": "Marcela Priscila  Ruiz  Perea",
            "LegalName": "Marcela Priscila  Ruiz  Perea",
            "RFC": "XAXX010101000",
            "Email": "no@no.com",
            "Phone": "33 14 22 93 55 ",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "c768b2ce-64ce-4385-9ee9-90a266561ccc",
            "Number": 1077,
            "ClientName": "petra cruz  lomas",
            "LegalName": "petra cruz  lomas",
            "RFC": "XAXX010101000",
            "Email": "no@no.com",
            "Phone": "3312257295",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "ee818969-908c-4b9b-acb8-9211c6bced83",
            "Number": 1072,
            "ClientName": "Sandy Lizeth  Figueroa  Bojorquez",
            "LegalName": "Sandy Lizeth  Figueroa  Bojorquez",
            "RFC": "XAXX010101000",
            "Email": "no@no.com",
            "Phone": "3339527826",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "a67bbf6a-d2f3-48ec-ba0b-9300cffe3cd9",
            "Number": 1159,
            "ClientName": "Adolfo Galvan Ramos",
            "LegalName": "Adolfo Galvan Ramos",
            "RFC": "XAXX010101000",
            "Email": "aramos88@gmail.com",
            "Phone": "3312985970",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "2bc8f887-ef34-41f6-984f-93e99736c591",
            "Number": 1203,
            "ClientName": "Casa Luah  ",
            "LegalName": "Casa Luah  ",
            "RFC": "XAXX010101000",
            "Email": "Contabilidad@manonvachez.com",
            "Phone": "33 15 33 13 72 ",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "1c54e88e-2401-4a51-a046-958608da2b69",
            "Number": 1070,
            "ClientName": "Víctor Hugo Farías González",
            "LegalName": "Víctor Hugo Farías González",
            "RFC": "XAXX010101000",
            "Email": "no@no.com",
            "Phone": "3787070024",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": "616"
        },
        {
            "ID": "b531c60b-f7b7-4ce0-be2b-961c1e293aa9",
            "Number": 1034,
            "ClientName": "Ana Sofía Garcia Garcia",
            "LegalName": "Ana Sofía Garcia Garcia",
            "RFC": "XAXX010101000",
            "Email": "no@no.com",
            "Phone": "3338096077",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "e5151362-a91f-440c-9729-962d1bbafb12",
            "Number": 1184,
            "ClientName": "GEORGINA RAMIREZ",
            "LegalName": "GEORGINA RAMIREZ CARDENAS",
            "RFC": "RACG761010I12",
            "Email": "admin@neuromodulaciongdl.com",
            "Phone": null,
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": "626"
        },
        {
            "ID": "a26bd550-9baf-42ff-81ca-9660fd8216cc",
            "Number": 1169,
            "ClientName": "Nancy Alvarado Zavala",
            "LegalName": "Nancy Alvarado Zavala",
            "RFC": "XAXX010101000",
            "Email": "psiqmanuelosandoval@gmail.com",
            "Phone": " 33 1039 3160",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "7d57282f-f671-451a-8404-96654d690f21",
            "Number": 1100,
            "ClientName": "Carlos Schultz Guzmán",
            "LegalName": "Carlos Schultz Guzmán",
            "RFC": "XAXX010101000",
            "Email": "carlos.schultz@sel.com.mx",
            "Phone": "3338142194",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "5f222f2c-ffce-41e7-a3a1-97e20c34a9eb",
            "Number": 1154,
            "ClientName": "Leonardo  Sanz Ayala",
            "LegalName": "Leonardo  Sanz Ayala",
            "RFC": "XAXX010101000",
            "Email": "sanzaleonardo@gmail.com",
            "Phone": null,
            "NextContactDate": null,
            "LocationID": null,
            "RegimenFiscal": "616"
        },
        {
            "ID": "8d8875af-3aac-4379-bc2e-986050e47f45",
            "Number": 1071,
            "ClientName": "Renata Romero Torres",
            "LegalName": "Renata Romero Torres",
            "RFC": "XAXX010101000",
            "Email": "no@no.com",
            "Phone": "3311414548",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "d8f5f81c-5195-45bd-8b67-99476cd2b6af",
            "Number": 1105,
            "ClientName": "MIGUEL ANGEL Anaya Tabares",
            "LegalName": "MIGUEL ANGEL Anaya Tabares",
            "RFC": "XAXX010101000",
            "Email": "no@no.com",
            "Phone": "",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "06437cae-5cd3-45d2-8a40-9a891b7e910f",
            "Number": 1004,
            "ClientName": "Yalee Elorza García",
            "LegalName": "Yalee Elorza García",
            "RFC": "XAXX010101000",
            "Email": "yalee_elorza89@hotmail.com",
            "Phone": "3310892265",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "4bbb4651-53a4-4f84-bca0-9b224f9b640f",
            "Number": 1106,
            "ClientName": "Aldo  Michel  Rodríguez ",
            "LegalName": "Aldo  Michel  Rodríguez ",
            "RFC": "XAXX010101000",
            "Email": "no@no.com",
            "Phone": "3310929074",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "ad612ea1-1570-4081-a018-9ba3ca732826",
            "Number": 1276,
            "ClientName": "Adrian Emiliano  Pacheco ",
            "LegalName": "Adrian Emiliano  Pacheco ",
            "RFC": "XAXX010101000",
            "Email": "no@no.com",
            "Phone": "33 32 36 60 66",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "e9ad4020-27fa-41d9-8e59-9c326955522b",
            "Number": 1242,
            "ClientName": "Felix Palau ",
            "LegalName": "Felix Palau ",
            "RFC": "XAXX010101000",
            "Email": "felixpalaul@yahoo.com",
            "Phone": "3331901103",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "64e66ea7-ff9c-41a0-b61f-9cdf245e8973",
            "Number": 1163,
            "ClientName": "Olivia Georgina Flores   Vázquez ",
            "LegalName": "Olivia Georgina Flores   Vázquez ",
            "RFC": "XAXX010101000",
            "Email": "no@aplica.com",
            "Phone": "3310446846",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "1555b6e2-a579-43ba-a1e0-9d35c630a112",
            "Number": 1192,
            "ClientName": "Alejandro Sanz lopez",
            "LegalName": "Alejandro Sanz lopez",
            "RFC": "XAXX010101000",
            "Email": "sanz@prueba.com",
            "Phone": "33333454565",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "a90afbd3-3d18-4427-8bf7-9d40c8fb2722",
            "Number": 1232,
            "ClientName": "Moises  Sanchez Sanchez ",
            "LegalName": "Moises  Sanchez Sanchez ",
            "RFC": "XAXX010101000",
            "Email": "no@no.com",
            "Phone": "33 18 63 98 10",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "00729dbc-59d3-455e-89c2-9d6e91eb1050",
            "Number": 1083,
            "ClientName": "LAURA LOPEZ AMEZCUA",
            "LegalName": "LAURA LOPEZ AMEZCUA",
            "RFC": "XAXX010101000",
            "Email": "no@no.com",
            "Phone": "3335525185",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "5a719d45-02f3-46ed-b19a-9e0eaca84653",
            "Number": 1268,
            "ClientName": "test test test",
            "LegalName": "test test test",
            "RFC": "XAXX010101000",
            "Email": "test@gmail.com",
            "Phone": "3338148472",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "a6a1c225-2d7c-4cb5-8231-9e19ee566351",
            "Number": 1229,
            "ClientName": "Jaime Miguel  Enriquez  Díaz",
            "LegalName": "Jaime Miguel  Enriquez  Díaz",
            "RFC": "XAXX010101000",
            "Email": "no@no.com",
            "Phone": "3322424022",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "5ad029d3-f28f-4999-9833-9e64cfacf310",
            "Number": 1012,
            "ClientName": "Juan José Díaz Degollado",
            "LegalName": "Juan José Díaz Degollado",
            "RFC": "XAXX010101000",
            "Email": null,
            "Phone": "33 1960 4334",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "6ee8c327-91a8-48d5-a9a5-a0e961c08ac7",
            "Number": 1306,
            "ClientName": "test prueba ayala",
            "LegalName": "test prueba ayala",
            "RFC": "XAXX010101000",
            "Email": "sanzaleonardo@gmail.com",
            "Phone": "3338148472",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": null
        },
        {
            "ID": "f6dfad1d-8b87-41c8-9abf-a1716f95cbbe",
            "Number": 1175,
            "ClientName": "Gilberto Eduardo Lepe Vigil",
            "LegalName": "Gilberto Eduardo Lepe Vigil",
            "RFC": "XAXX010101000",
            "Email": "no@no.com",
            "Phone": "3751260050",
            "NextContactDate": null,
            "LocationID": "5110f104-2530-4727-9edb-cb3d172c8b1d",
            "RegimenFiscal": "616"
        }
    ],
    "nextLink": "https://api.bind.com.mx/api/Clients?$skip=200",
    "count": 221
}';


// Decodificar el JSON
$data = json_decode($resp, true);

// Verificar si la decodificación fue exitosa
if (json_last_error() === JSON_ERROR_NONE) {
    // Acceder a los datosh
    echo "Número total de clientes: " . count($data['value']) . "<br>"."<hr>";
    foreach ($data['value'] as $client) {
        echo "ID: " . $client['ID'] . "<br>"."<br>";
        echo "Nombre del Cliente: " . $client['ClientName'] . "<br>"."<br>";
        echo "RFC: " . $client['RFC'] . "<br>"."<br>";
        echo "Correo Electrónico: " . $client['Email'] . "<br>"."<br>";
        echo "Teléfono: " . $client['Phone'] . "<br>"."<br>";
        echo "Fecha del Próximo Contacto: " . ($client['NextContactDate'] ?? 'No disponible') . "<br>"."<br>";
        echo "ID de Ubicación: " . $client['LocationID'] . "<br>"."<br>";
        echo "Régimen Fiscal: " . ($client['RegimenFiscal'] ?? 'No disponible') . "<br><br>"."<hr>";
		
	    $ID = $client['ID'];
	    $Number = $client['Number'];
	    $ClientName = $client['ClientName'];
	    $LegalName = $client['LegalName'];
	    $RFC = $client['RFC'];
	    $Email = $client['Email'];
	    $Phone = $client['Phone'];
	    $NextContactDate = $client['NextContactDate'];
	    $LocationID = $client['LocationID'];
	    $RegimenFiscal = $client['RegimenFiscal'];
	
	    $sql = "INSERT INTO clients_bind (ID, Number, ClientName, LegalName, RFC, Email, Phone, NextContactDate, LocationID, RegimenFiscal)
	            VALUES ('$ID', $Number, '$ClientName', '$LegalName', '$RFC', '$Email', '$Phone', " . ($NextContactDate ? "'$NextContactDate'" : "NULL") . ", '$LocationID', " . ($RegimenFiscal ? "'$RegimenFiscal'" : "NULL") . ")";
	     echo "<h2>$cnt</h2>".$sql."<hr>";
	    
	    ejecutar($sql);	
		$cnt++;	
    }
} else {
    echo "Error decodificando JSON: " . json_last_error_msg();
}
echo "<hr>";

// 
// echo "<h1>Clients 100</h1>";
// 
// $url = "https://api.bind.com.mx/api/Clients?$skip=100";
// $curl = curl_init($url);
// 
// curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
// curl_setopt($curl, CURLOPT_URL, $url);
// curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
// 
// $headers = array(
    // 'Cache-Control: no-cache',
    // 'Ocp-Apim-Subscription-Key: '.$key.'',
    // 'Authorization: Bearer '.$authorization.'' // Asegúrate de que el token JWT esté completo
// );
// curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
// 
// $resp = curl_exec($curl);
// if ($resp === false) {
    // echo 'Error de cURL: ' . curl_error($curl);
    // curl_close($curl);
    // exit;
// }
// curl_close($curl);
// 
// // Decodificar el JSON
// $data = json_decode($resp, true);
// 
// // Verificar si la decodificación fue exitosa
// if (json_last_error() === JSON_ERROR_NONE) {
    // // Acceder a los datosh
    // echo "Número total de clientes: " . count($data['value']) . "<br>"."<hr>";
    // foreach ($data['value'] as $client) {
        // echo "ID: " . $client['ID'] . "<br>"."<br>";
        // echo "Nombre del Cliente: " . $client['ClientName'] . "<br>"."<br>";
        // echo "RFC: " . $client['RFC'] . "<br>"."<br>";
        // echo "Correo Electrónico: " . $client['Email'] . "<br>"."<br>";
        // echo "Teléfono: " . $client['Phone'] . "<br>"."<br>";
        // echo "Fecha del Próximo Contacto: " . ($client['NextContactDate'] ?? 'No disponible') . "<br>"."<br>";
        // echo "ID de Ubicación: " . $client['LocationID'] . "<br>"."<br>";
        // echo "Régimen Fiscal: " . ($client['RegimenFiscal'] ?? 'No disponible') . "<br><br>"."<hr>";
// 		
	    // $ID = $client['ID'];
	    // $Number = $client['Number'];
	    // $ClientName = $client['ClientName'];
	    // $LegalName = $client['LegalName'];
	    // $RFC = $client['RFC'];
	    // $Email = $client['Email'];
	    // $Phone = $client['Phone'];
	    // $NextContactDate = $client['NextContactDate'];
	    // $LocationID = $client['LocationID'];
	    // $RegimenFiscal = $client['RegimenFiscal'];
// 	
	    // $sql = "INSERT INTO clients_bind (ID, Number, ClientName, LegalName, RFC, Email, Phone, NextContactDate, LocationID, RegimenFiscal)
	            // VALUES ('$ID', $Number, '$ClientName', '$LegalName', '$RFC', '$Email', '$Phone', " . ($NextContactDate ? "'$NextContactDate'" : "' '") . ", '$LocationID', " . ($RegimenFiscal ? "'$RegimenFiscal'" : "' '") . ")";
	    // echo "<h2>$cnt</h2>".$sql."<hr>";
// 		
	    // ejecutar($sql);	
		// $cnt++;	
    // }
// } else {
    // echo "Error decodificando JSON: " . json_last_error_msg();
// }
// echo "<hr>";
// 
// 
// echo "<h1>Clients 200</h1>";
// 
// $url = "https://api.bind.com.mx/api/Clients?$skip=200";
// $curl = curl_init($url);
// 
// curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
// curl_setopt($curl, CURLOPT_URL, $url);
// curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
// 
// $headers = array(
    // 'Cache-Control: no-cache',
    // 'Ocp-Apim-Subscription-Key: '.$key.'',
    // 'Authorization: Bearer '.$authorization.'' // Asegúrate de que el token JWT esté completo
// );
// curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
// 
// $resp = curl_exec($curl);
// if ($resp === false) {
    // echo 'Error de cURL: ' . curl_error($curl);
    // curl_close($curl);
    // exit;
// }
// curl_close($curl);
// 
// // Decodificar el JSON
// $data = json_decode($resp, true);
// 
// // Verificar si la decodificación fue exitosa
// if (json_last_error() === JSON_ERROR_NONE) {
    // // Acceder a los datosh
    // echo "Número total de clientes: " . count($data['value']) . "<br>"."<hr>";
    // foreach ($data['value'] as $client) {
        // echo "ID: " . $client['ID'] . "<br>"."<br>";
        // echo "Nombre del Cliente: " . $client['ClientName'] . "<br>"."<br>";
        // echo "RFC: " . $client['RFC'] . "<br>"."<br>";
        // echo "Correo Electrónico: " . $client['Email'] . "<br>"."<br>";
        // echo "Teléfono: " . $client['Phone'] . "<br>"."<br>";
        // echo "Fecha del Próximo Contacto: " . ($client['NextContactDate'] ?? 'No disponible') . "<br>"."<br>";
        // echo "ID de Ubicación: " . $client['LocationID'] . "<br>"."<br>";
        // echo "Régimen Fiscal: " . ($client['RegimenFiscal'] ?? 'No disponible') . "<br><br>"."<hr>";
// 		
	    // $ID = $client['ID'];
	    // $Number = $client['Number'];
	    // $ClientName = $client['ClientName'];
	    // $LegalName = $client['LegalName'];
	    // $RFC = $client['RFC'];
	    // $Email = $client['Email'];
	    // $Phone = $client['Phone'];
	    // $NextContactDate = $client['NextContactDate'];
	    // $LocationID = $client['LocationID'];
	    // $RegimenFiscal = $client['RegimenFiscal'];
// 	
	    // $sql = "INSERT INTO clients_bind (ID, Number, ClientName, LegalName, RFC, Email, Phone, NextContactDate, LocationID, RegimenFiscal)
	            // VALUES ('$ID', $Number, '$ClientName', '$LegalName', '$RFC', '$Email', '$Phone', " . ($NextContactDate ? "'$NextContactDate'" : "NULL") . ", '$LocationID', " . ($RegimenFiscal ? "'$RegimenFiscal'" : "NULL") . ")";
	     // echo "<h2>$cnt</h2>".$sql."<hr>";
	    // ejecutar($sql);	
		// $cnt++;	
    // }
// } else {
    // echo "Error decodificando JSON: " . json_last_error_msg();
// }
// echo "<hr>";
// 
// echo "<h1>Clients 300</h1>";
// 
// $url = "https://api.bind.com.mx/api/Clients?$skip=300";
// $curl = curl_init($url);
// 
// curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
// curl_setopt($curl, CURLOPT_URL, $url);
// curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
// 
// $headers = array(
    // 'Cache-Control: no-cache',
    // 'Ocp-Apim-Subscription-Key: '.$key.'',
    // 'Authorization: Bearer '.$authorization.'' // Asegúrate de que el token JWT esté completo
// );
// curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
// 
// $resp = curl_exec($curl);
// if ($resp === false) {
    // echo 'Error de cURL: ' . curl_error($curl);
    // curl_close($curl);
    // exit;
// }
// curl_close($curl);
// 
// // Decodificar el JSON
// $data = json_decode($resp, true);
// 
// // Verificar si la decodificación fue exitosa
// if (json_last_error() === JSON_ERROR_NONE) {
    // // Acceder a los datosh
    // echo "Número total de clientes: " . count($data['value']) . "<br>"."<hr>";
    // foreach ($data['value'] as $client) {
        // echo "ID: " . $client['ID'] . "<br>"."<br>";
        // echo "Nombre del Cliente: " . $client['ClientName'] . "<br>"."<br>";
        // echo "RFC: " . $client['RFC'] . "<br>"."<br>";
        // echo "Correo Electrónico: " . $client['Email'] . "<br>"."<br>";
        // echo "Teléfono: " . $client['Phone'] . "<br>"."<br>";
        // echo "Fecha del Próximo Contacto: " . ($client['NextContactDate'] ?? 'No disponible') . "<br>"."<br>";
        // echo "ID de Ubicación: " . $client['LocationID'] . "<br>"."<br>";
        // echo "Régimen Fiscal: " . ($client['RegimenFiscal'] ?? 'No disponible') . "<br><br>"."<hr>";
// 		
	    // $ID = $client['ID'];
	    // $Number = $client['Number'];
	    // $ClientName = $client['ClientName'];
	    // $LegalName = $client['LegalName'];
	    // $RFC = $client['RFC'];
	    // $Email = $client['Email'];
	    // $Phone = $client['Phone'];
	    // $NextContactDate = $client['NextContactDate'];
	    // $LocationID = $client['LocationID'];
	    // $RegimenFiscal = $client['RegimenFiscal'];
// 	
	    // $sql = "INSERT INTO clients_bind (ID, Number, ClientName, LegalName, RFC, Email, Phone, NextContactDate, LocationID, RegimenFiscal)
	            // VALUES ('$ID', $Number, '$ClientName', '$LegalName', '$RFC', '$Email', '$Phone', " . ($NextContactDate ? "'$NextContactDate'" : "NULL") . ", '$LocationID', " . ($RegimenFiscal ? "'$RegimenFiscal'" : "NULL") . ")";
	     // echo "<h2>$cnt</h2>".$sql."<hr>";
	    // ejecutar($sql);	
		// $cnt++;	
    // }
// } else {
    // echo "Error decodificando JSON: " . json_last_error_msg();
// }
// echo "<hr>";
?>
