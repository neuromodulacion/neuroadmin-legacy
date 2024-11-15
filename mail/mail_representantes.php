<?php

function fotos($foto){	
switch ($foto) {
		case 'si':
			$imagen="http://aseguramientocalidad.dish.intra/images/calif/accept.png";

			break;
		case 'bien':
			$imagen="http://aseguramientocalidad.dish.intra/images/calif/accept.png";
			break;			
		case 'no':
			$imagen="http://aseguramientocalidad.dish.intra/images/calif/remove.png";

			break;							
		case 'mal':
			$imagen="http://aseguramientocalidad.dish.intra/images/calif/remove.png";

			break;		
		default:
			$imagen="http://aseguramientocalidad.dish.intra/images/calif/page.png";
			break;
	}
	return $imagen;		
	}	
	
function dir_fotos($dir_fotos_name){

if (is_file($dir_fotos_name.'.jpg')) {
	$dir_file_fotos=$dir_fotos_name.'.jpg' ;
}
elseif (is_file($dir_fotos_name.'.jpeg')) {
	$dir_file_fotos=$dir_fotos_name.'.jpeg' ;
}
elseif (is_file($dir_fotos_name.'.png')) {
	$dir_file_fotos=$dir_fotos_name.'.png' ;
}	
elseif (is_file($dir_fotos_name.'.gif')) {
	$dir_file_fotos=$dir_fotos_name.'.gif' ;
}	
elseif (is_file($dir_fotos_name.'.png')) {
	$dir_file_fotos=$dir_fotos_name.'.png' ;
}	
elseif (is_file($dir_fotos_name.'.JPG')) {
	$dir_file_fotos=$dir_fotos_name.'.JPG' ;
}	
elseif (is_file($dir_fotos_name.'.JPEG')) {
	$dir_file_fotos=$dir_fotos_name.'.JPEG' ;
}	
elseif (is_file($dir_fotos_name.'.PNG')) {
	$dir_file_fotos=$dir_fotos_name.'.PNG' ;
}	
elseif (is_file($dir_fotos_name.'.GIF')) {
	$dir_file_fotos=$dir_fotos_name.'.GIF' ;
}else {
	$dir_file_fotos="http://aseguramientocalidad.dish.intra/images/calif/page.png";
}	
		return $dir_file_fotos;	
}

include ("../funciones/funciones_mysql.php");
include ("../funciones/funciones.php");     
	
//require("class.phpmailer.php");
require 'php_mailer/class.phpmailer.php';
$conexion = conectar("dish_calidad"); 


$id=268 ;//$_POST['id'];
//id=11;
	                   	
//$B_ORIGEN = $_POST["B_ORIGEN"];	
//$empresa = $_POST["empresa"];

$sql_man_equi2 = "SELECT b.d_empins,b.B_ORIGEN,a.* from cartera_representantes a, cat_empinst b WHERE a.empresa=b.C_EMPINS and f_supervis BETWEEN '2013-03-01' and '2013-03-31' and id=$id";
$sql_man_equi  = "SELECT b.d_empins,b.B_ORIGEN,a.* from cartera_representantes a, cat_empinst b WHERE a.empresa=b.C_EMPINS and f_supervis BETWEEN '2013-03-01' and '2013-03-31' and id=$id";

$result_emp = ejecutar($sql_man_equi,$conexion);
$result_emp2 = ejecutar($sql_man_equi2,$conexion);

$sql_man_equi1 = "SELECT b.d_empins,b.B_ORIGEN,a.* from cartera_representantes a, cat_empinst b WHERE a.empresa=b.C_EMPINS and f_supervis BETWEEN '2013-03-01' and '2013-03-31' and id=$id";

$result_emp1 = ejecutar($sql_man_equi1,$conexion);
				//revisado='si'	AND			
$row = mysql_fetch_array($result_emp1);
	$xid = $row["id"];	
	$empresa = $row["empresa"];	
	$nombre = $row["d_empins"];			
	$area = $row["B_ORIGEN"];
	$f_supervis = $row["f_supervis"];
	$fecha= date('d/m/Y',strtotime($f_supervis));
	$mes= date('m',strtotime($f_supervis));
	$ano= date('Y',strtotime($f_supervis));
	$estado = $row["estado"];
	$ruta = $row["ruta"];
	?><?
		$p1 = $row["p1"]; //¿El local está abierto?
			$images1= fotos($p1);  
			$dir_fotos_name="http://aseguramientocalidad.dish.intra/prueba/fotos_aseg/".$ano."/".$mes."/representantes/".$empresa."/id_".$xid."/local_abierto"; 
			$dir_file_fotos1= dir_fotos($dir_fotos_name);   		
		$p2 = $row["p2"]; //¿Cuentan con tv o pantalla con la programación de Dish?
			$images2= fotos($p2);  
			$dir_fotos_name="http://aseguramientocalidad.dish.intra/prueba/fotos_aseg/".$ano."/".$mes."/representantes/".$empresa."/id_".$xid."/pantalla_tv"; 
			$dir_file_fotos2= dir_fotos($dir_fotos_name);  		
		$p3 = $row["p3"]; //¿Tienen instalado el equipo Dish con All Access?
			$images3= fotos($p3);  
			$dir_fotos_name="http://aseguramientocalidad.dish.intra/prueba/fotos_aseg/".$ano."/".$mes."/representantes/".$empresa."/id_".$xid."/all_access"; 
			$dir_file_fotos3= dir_fotos($dir_fotos_name);  		
		$p4 = $row["p4"]; //¿Tiene buena presentación?
			//$images4= fotos($p4);  
			//$dir_fotos_name="http://aseguramientocalidad.dish.intra/prueba/fotos_aseg/".$ano."/".$mes."/representantes/".$empresa."/id_".$xid."/local_abierto"; 
			//$dir_file_fotos4= dir_fotos($dir_fotos_name);  		
		$p5 = $row["p5"]; //Aseo
			//$images5= fotos($p5);  
			//$dir_fotos_name="http://aseguramientocalidad.dish.intra/prueba/fotos_aseg/".$ano."/".$mes."/representantes/".$empresa."/id_".$xid."/local_abierto"; 
			//$dir_file_fotos5= dir_fotos($dir_fotos_name);  		
		$p6 = $row["p6"]; //Orden
		
		$p7 = $row["p7"]; //¿Exterior del local pintado con los colores de dish?
		
		$p8 = $row["p8"]; //¿Interior del local pintado con los colores de dish?
		
		$p9 = $row["p9"]; //Logotipos de dish en el exterior del local
		
		$p10 = $row["p10"]; //¿Variedad de material promocional (suficientes bolantes,folletos,tripticos)?
		$p11 = $row["p11"]; //Información de ventas vigente
		$p12 = $row["p12"]; //¿Tienen señalados los dias y horarios de atención visibles para el cliente?
		$p13 = $row["p13"]; //¿Tienen buzón de quejas y sugerencias?
		$p14 = $row["p14"]; //¿Llevan bitacora de seguimiento a quejas del cliente?
		$p15 = $row["p15"]; //¿Cuentan con equipo de computo en buenas condiciones?
		$p16 = $row["p16"]; //¿Cuentan con telefono en buenas condiciones?
		$p17 = $row["p17"]; //¿Cuentan con internet en buen funcionamiento?
		$p18 = $row["p18"]; //¿Cuentan con folios de ventas?
		$p19 = $row["p19"]; //¿Cuentan con formatos universales?
		$p20 = $row["p20"]; //¿Cuentan con cartas telmex?
		$xp20 = $row["xp20"]; //¿Cuentan con tarjeta Dish?
		$p21 = $row["p21"]; //¿Viste con el uniforme Dish?
		$p22 = $row["p22"]; //¿Porta el gafete de Dish?
		$p23 = $row["p23"]; //¿Tiene equipos disponibles para la instalación?
		$p24 = $row["p24"]; //¿Tiene equipos defectuosos?
		$p25 = $row["p25"]; //¿Cuentan con espacio destinado e identificado para el almacenaje de equipos?
		$p26 = $row["p26"]; //¿Cuentan con espacio destinado e identificado para el almacenaje de componentes?
		$p27 = $row["p27"]; //¿Cuentan con vehículos?
		$xp27 = $row["xp27"]; //¿Cuentan con los rotulos?
		$p28 = $row["p28"]; //¿Se encuentra fisicamente en buen estado?
		$p29 = $row["p29"]; //¿Se encuentra limpia la unidad?
		$p30 = $row["p30"]; //Observaciones



	
	
$mail = new PHPMailer();


		$mail->IsSMTP();                           // tell the class to use SMTP
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
		$mail->Port       = 25;                    // set the SMTP server port
		$mail->Host       = "191.1.1.199"; // SMTP server
		$mail->Username   = "fueradenorma@dish.com.mx";     // SMTP server username
		$mail->Password   = "Dish1200";            // SMTP server password
	
		$mail->IsSendmail();  // tell the class to use Sendmail
	
		$mail->AddReplyTo("fueradenorma@dish.com.mx","Fuera de Norma");
	
		$mail->From       = "fueradenorma@dish.com.mx";
		$mail->FromName   = "Fuera de Norma";
		$mail->AddAddress("sanzaleonardo@gmail.com");
$mail->IsHTML(true);

$mail->Subject  = "Mi tercer correo PHPMailer ";
$mail->Body     = "


    <span style='font-size: 16px; font-weight: bold'>Área de $area<br />
    	 Estado $estado <br />
    	 Empresa $empresa a nombre de $nombre <br />
    	 Asegurada el día $fecha <br></span>
    <br>
    <br>
 	<table style='width: 100%;border: solid 1px #000000; border-collapse: collapse' align='center'>
        <thead>
            <tr>
                <th style='width: 100%; text-align: center; border: solid 1px #000000; background: #F7871E'><H4>ASPECTOS VERIFICADOS</H4></th>
            </tr>
        </thead>       
        <tbody>
            <tr>
                <td style='width: 100%; text-align: left; border: solid 0px #000000 '></td>
            </tr>            
        </tbody>
    </table>    
<br>
	<table style='width: 100%;border: solid 1px #000000; border-collapse: collapse' align='center'>
        <thead>
            <tr>
                <td style='width: 30%; text-align: left; border: solid 1px #000000 '>EL LOCAL ESTA ABIERTO</td>
                <td style='width: 10%; text-align: center; border: solid 1px #000000'>$p1</td>
                <td style='width: 10%; text-align: center; border: solid 1px #000000'><img src='$images1' alt='calificacion'  ></td>	  
                <td style='width: 50%; text-align: center; border: solid 1px #000000'><img src='$dir_file_fotos1' alt='local_abierto' height='200px' ></td> <!---->
                
            </tr>            
             <tr>
                <td style='width: 30%; text-align: left; border: solid 1px #000000 '>CUENTAN CON TV O PANTALLA CON LA PROGRAMACIÓN DE DISH</td>
                <td style='width: 10%; text-align: center; border: solid 1px #000000'>$p2</td>
                <td style='width: 10%; text-align: center; border: solid 1px #000000'><img src='$images2' alt='calificacion'  ></td>
                <td style='width: 50%; text-align: center; border: solid 1px #000000'><img src='$dir_file_fotos2' alt='pantalla_tv'  height='200px'  ></td> <!---->                
                
            </tr>           
             <tr>
                <td style='width: 30%; text-align: left; border: solid 1px #000000 '>TIENEN INSTALADO EL EQUIPO DISH CON ALL ACCESS</td>
                <td style='width: 10%; text-align: center; border: solid 1px #000000'>$p3</td>
                <td style='width: 10%; text-align: center; border: solid 1px #000000'><img src='$images3' alt='calificacion'  ></td>
                <td style='width: 50%; text-align: center; border: solid 1px #000000'><img src='$dir_file_fotos3' alt='all_access' height='200px' ></td> <!---->                
                 
            </tr>                                  
        </tbody>
    </table>      

<address>http://aseguramientocalidad.dish.intra/prueba/ejecuta_liga_representantes.php?id=268</address>   ";


$mail->WordWrap = 50;

if(!$mail->Send()) {
  echo 'El mensaje no ha sido enviado.';
  echo 'Mailer error: ' . $mail->ErrorInfo;
} else {
  echo 'El mensaje ha sido enviado.';
}

	mysql_close($conexion);	?>