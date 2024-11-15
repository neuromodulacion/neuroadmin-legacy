<?php

## ENABLE SoapClient on PHP 7.3.x ## 
/*
	Do the following:

	1. Locate php.ini in your apache bin folder, I.e Apache/bin/php.ini
	2. Remove the ; from the beginning of extension=soap  (extension=php_soap.dll in older versions) 
	3. Restart your Apache server
	4. Look up your phpinfo(); again and check if you see a similar picture to the one above
*/
	namespace TIMBRADORXPRESS\API;

	class Conexion
	{
    	private $wsdl;
    	private $client;
    	private $response;

		public function __construct($url){
			$this->wsdl = $url;
			$this->client = new \SoapClient($this->wsdl);
			$this->response = NULL;
		}

		public function operacion_timbrar($apikey, $cfdi){
			$res = $this->client->timbrar($apikey, $cfdi);

			$this->response = array(
				'operacion' => 'timbrar',
				'codigo' => $res->code,
				'mensaje' => $res->message,
				'cfdi' => $res->data
				);
			
			return json_encode($this->response, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
		}

		public function operacion_timbrarTFD($apikey, $cfdi){
			$res = $this->client->timbrarTFD($apikey, $cfdi);

			$this->response = array(
				'operacion' => 'timbrarTFD',
				'codigo' => $res->code,
				'mensaje' => $res->message,
				'timbre' => $res->data
				);
			
			return json_encode($this->response, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
		}

		public function operacion_timbrar3($apikey, $cfdi){
			$res = $this->client->timbrar3($apikey, $cfdi);

			$this->response = array(
				'operacion' => 'timbrar3',
				'codigo' => $res->code,
				'mensaje' => $res->message,
				'cfdi' => $res->data
				);
			
			return json_encode($this->response, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
		}

		public function operacion_timbrarConSello($apikey, $cfdi, $keyPEM){
			$res = $this->client->timbrarConSello($apikey, $cfdi, $keyPEM);

			$this->response = array(
				'operacion' => 'timbrarConSello',
				'codigo' => $res->code,
				'mensaje' => $res->message,
				'cfdi' => $res->data
				);
			
			return json_encode($this->response, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
		}

		public function operacion_consultar_creditos($apikey){
			$res = $this->client->consultarCreditosDisponibles($apikey);

			$this->response = array(
				'operacion' => 'consultar_creditos',
				'codigo' => $res->code,
				'mensaje' => $res->message,
				'creditos' => $res->data
				);
			
			return json_encode($this->response, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
		}

		public function operacion_consultarEstadoSAT($apikey, $uuid, $rfcEmisor, $rfcReceptor, $total){
			$res = $this->client->consultarEstadoSAT($apikey, $uuid, $rfcEmisor, $rfcReceptor, $total);

			$this->response = array(
				'operacion' => 'consultarEstadoSAT',
				'Codigo del SAT' => $res->CodigoEstatus,
				'Tipo de Cancelación' => $res->EsCancelable,
				'Estado' => $res->Estado,
				'Solicitud de cancelacion' => $res->EstatusCancelacion
				);
			
			return json_encode($this->response, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
		}

		public function operacion_cancelar($apikey, $keyCSD, $cerCSD, $passCSD, $uuid, $rfcEmisor, $rfcReceptor, $total){
			$res = $this->client->cancelar($apikey, $keyCSD, $cerCSD, $passCSD, $uuid, $rfcEmisor, $rfcReceptor, $total);

			## RESPUESTA ORIGINAL DEL SERVICIO ##
			//var_dump($res);

			$acuse = NULL;

			if ( $res->status == "success" )
			{
				$resData = json_decode($res->data);
				$acuse = $resData->acuse;
			}

			$this->response = array(
				'operacion' => 'cancelar',
				'codigo' => $res->code,
				'mensaje' => $res->message,
				'acuse' => $acuse,
				'resultado' => $res->status
				);

			## GUARDAR ACUSE EN DIRECTORIO ACTUAL ##
			//file_put_contents('rsc/acuse_cancelacion.xml', $acuse);
			
			return json_encode($this->response, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
		}

		public function operacion_cancelarPFX($apikey, $pfxB64, $passPFX, $uuid, $rfcEmisor, $rfcReceptor, $total){
			$res = $this->client->cancelarPFX($apikey, $pfxB64, $passPFX, $uuid, $rfcEmisor, $rfcReceptor, $total);

			## RESPUESTA ORIGINAL DEL SERVICIO ##
			//var_dump($res);

			$acuse = NULL;

			if ( $res->status == "success" )
			{
				$resData = json_decode($res->data);
				$acuse = $resData->acuse;
			}

			$this->response = array(
				'operacion' => 'cancelarPFX',
				'codigo' => $res->code,
				'mensaje' => $res->message,
				'acuse' => $acuse,
				'resultado' => $res->status
				);

			## GUARDAR ACUSE EN DIRECTORIO ACTUAL ##
			//file_put_contents('rsc/acuse_cancelacion.xml', $acuse);
			
			return json_encode($this->response, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
		}

/**
* 	NUEVAS FUNCIONES
**/

		public function operacion_cancelar2($apikey, $keyCSD, $cerCSD, $passCSD, $uuid, $rfcEmisor, $rfcReceptor, $total, $motivo, $folioSustitucion){
			$res = $this->client->cancelar2($apikey, $keyCSD, $cerCSD, $passCSD, $uuid, $rfcEmisor, $rfcReceptor, $total, $motivo, $folioSustitucion);

			## RESPUESTA ORIGINAL DEL SERVICIO ##
			//var_dump($res);

			$acuse = NULL;

			if ( $res->status == "success" )
			{
				$resData = json_decode($res->data);
				$acuse = $resData->acuse;
			}

			$this->response = array(
				'operacion' => 'cancelar2',
				'codigo' => $res->code,
				'mensaje' => $res->message,
				'acuse' => $acuse,
				'resultado' => $res->status
				);

			## GUARDAR ACUSE EN DIRECTORIO ACTUAL ##
			//file_put_contents('rsc/acuse_cancelacion.xml', $acuse);
			
			return json_encode($this->response, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
		}

		public function operacion_cancelarPFX2($apikey, $pfxB64, $passPFX, $uuid, $rfcEmisor, $rfcReceptor, $total, $motivo, $folioSustitucion){
			$res = $this->client->cancelarPFX2($apikey, $pfxB64, $passPFX, $uuid, $rfcEmisor, $rfcReceptor, $total, $motivo, $folioSustitucion);

			## RESPUESTA ORIGINAL DEL SERVICIO ##
			//var_dump($res);

			$acuse = NULL;

			if ( $res->status == "success" )
			{
				$resData = json_decode($res->data);
				$acuse = $resData->acuse;
			}

			$this->response = array(
				'operacion' => 'cancelarPFX2',
				'codigo' => $res->code,
				'mensaje' => $res->message,
				'acuse' => $acuse,
				'resultado' => $res->status
				);

			## GUARDAR ACUSE EN DIRECTORIO ACTUAL ##
			//file_put_contents('rsc/acuse_cancelacion.xml', $acuse);
			
			return json_encode($this->response, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
		}

		public function operation_consultarAutorizacionesPendientes($apikey, $keyPEM, $cerPEM){
			$res = $this->client->consultarAutorizacionesPendientes($apikey, $keyPEM, $cerPEM);

			$this->response = array(
				'operacion' => 'consultarAutorizacionesPendientes',
				'codigo' => $res->code,
				'mensaje' => $res->message,
				'datos' => $res->data
				);
			
			return json_encode($this->response, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
		}

		public function operation_autorizarCancelacion($apikey, $keyPEM, $cerPEM, $uuid, $respuesta){
			$res = $this->client->autorizarCancelacion($apikey, $keyPEM, $cerPEM, $uuid, $respuesta);

			$this->response = array(
				'operacion' => 'autorizarCancelacion',
				'codigo' => $res->code,
				'mensaje' => $res->message,
				'datos' => $res->data
				);
			
			return json_encode($this->response, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
		}

		public function operacion_timbrarTXT($apikey, $txtB64, $keyPEM, $cerPEM){
			$res = $this->client->timbrarTXT($apikey, $txtB64, $keyPEM, $cerPEM);

			$this->response = array(
				'operacion' => 'timbrarTXT',
				'codigo' => $res->code,
				'mensaje' => $res->message,
				'datos' => $res->data
				);
			
			return json_encode($this->response, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
		}

		public function operacion_timbrarTXT2($apikey, $txtB64, $keyPEM, $cerPEM, $plantilla, $logoB64){
			$res = $this->client->timbrarTXT2($apikey, $txtB64, $keyPEM, $cerPEM, $plantilla, $logoB64);

			$this->response = array(
				'operacion' => 'timbrarTXT2',
				'codigo' => $res->code,
				'mensaje' => $res->message,
				'datos' => $res->data
				);
			
			return json_encode($this->response, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
		}

		public function operacion_timbrarTXT3($apikey, $txtB64, $keyPEM, $cerPEM){
			$res = $this->client->timbrarTXT3($apikey, $txtB64, $keyPEM, $cerPEM);

			$this->response = array(
				'operacion' => 'timbrarTXT3',
				'codigo' => $res->code,
				'mensaje' => $res->message,
				'datos' => $res->data
				);
			
			return json_encode($this->response, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
		}

		public function operacion_timbrarJSON($apikey, $jsonB64, $keyPEM, $cerPEM){
			$res = $this->client->timbrarJSON($apikey, $jsonB64, $keyPEM, $cerPEM);

			$this->response = array(
				'operacion' => 'timbrarJSON',
				'codigo' => $res->code,
				'mensaje' => $res->message,
				'datos' => $res->data
				);
			
			return json_encode($this->response, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
		}

		public function operacion_timbrarJSON2($apikey, $jsonB64, $keyPEM, $cerPEM, $plantilla, $nombre){
			$ruta ='salida/'.$nombre;	
			ini_set('default_socket_timeout', 5000);
			$res = $this->client->timbrarJSON2($apikey, $jsonB64, $keyPEM, $cerPEM, $plantilla, $nombre);

			$this->response = array(
				'operacion' => 'timbrarJSON2',
				'codigo' => $res->code,
				'mensaje' => $res->message,
				'datos' => $res->data
				);
			
			if ($res->code == '200' || $res->code == '307') {
					// Se crea el objeto de la respuesta del Servicio.
					$dataOBJ = json_decode($res->data);

					// Creamos los archivos con la extencion .xml y .pdf de la respuesta obtenida del parametro "date"
					 file_put_contents($ruta.'.xml', $dataOBJ->XML);   //archivo XML
				 	 file_put_contents($ruta.'.pdf', base64_decode($dataOBJ->PDF)); //Archivo PDF
				}
		return json_encode($this->response, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
		}

		public function operacion_timbrarJSON3($apikey, $jsonB64, $keyPEM, $cerPEM){
			$res = $this->client->timbrarJSON3($apikey, $jsonB64, $keyPEM, $cerPEM);

			$this->response = array(
				'operacion' => 'timbrarJSON3',
				'codigo' => $res->code,
				'mensaje' => $res->message,
				'datos' => $res->data
				);
			
			return json_encode($this->response, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
			
		}
		/**
		* 	Timbrar Retenciones v2.0
		**/
		public function operacion_timbrarRetencionJSON($apikey, $jsonB64, $keyPEM, $cerPEM, $plantilla){
			$res = $this->client->timbrarRetencionJSON($apikey, $jsonB64, $keyPEM, $cerPEM, $plantilla);

			$this->response = array(
				'operacion' => 'timbrarRetencionesJSON',
				'codigo' => $res->code,
				'mensaje' => $res->message,
				'datos' => $res->data
				);
			
			return json_encode($this->response, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
		}

		public function operacion_timbrarRetencion($apikey, $cfdi){
			$res = $this->client->timbrarRetencion($apikey, $cfdi);

			$this->response = array(
				'operacion' => 'timbrarRetencion',
				'codigo' => $res->code,
				'mensaje' => $res->message,
				'datos' => $res->data
				);
			
			return json_encode($this->response, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
		}
		public function operacion_consultarCFDI($apikey, $uuid){
			$res = $this->client->consultarCFDI($apikey, $uuid);

			$this->response = array(
				'operacion' => 'consultarCFDI',
				'codigo' => $res->code,
				'mensaje' => $res->message,
				'datos' => $res->data
				);
			
			return json_encode($this->response, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
		}
	}
?>