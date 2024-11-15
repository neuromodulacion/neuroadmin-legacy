<?php
include('whatsapp_funcion.php');

//264502500080569
//286086564580822


$url = "https://graph.facebook.com/v18.0/264502500080569/messages";

$accessToken = 
"EAAWxuhCVcfUBOw7oPnNcTtJUZBIUFXZC7yc0w9ILnwwy3Lr0iTr6MWHSKPLGzyhqGnZCinHyd6Q8E0Vz9yh1ta2oAvFFZAfYvrxZCZAusMV5moghFsTgxoH5AdSsqYQZBcjLsp50rDtbTAwe70oMlZB4wDua2ebUaAt2mZCI3JfbGdrKgHZAVhN3NdIBvOrG37qJSHVPZAWeLROb2qGnP14LNDLJGuJcxlGPC5L";

 $to = "523338148472"; // leo

$type = "template";
// $to = "523312219470";

//$type = "menu";
$preview_url = "false";
$body = "hello_world https://neuromodulaciongdl.com/";

$data = mesg_sal($type,$to,$preview_url,$body);

echo $data."<hr>";

$response = envio_whatsapp($url,$accessToken,$data);

echo "<hr>Enviado";