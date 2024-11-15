<?php
session_start();
error_reporting(0);
    include('funciones_mysql.php');
date_default_timezone_set('America/Monterrey');

extract($_POST);
switch($action){
	case 'A':
		inicia_sesion($email,$pwd);
		break;
	case 'B':
		//valida_actividad($time,$user,$n);
		valida_actividad($user,$n);
		break;
	case 'C':
		get_mensajes($user_re,$user_em);
		break;
	case 'D':
		add_mensajes($user_re,$user_em,$msg);
		break;
	case 'E':
		checking_msg();
		break;
	case 'F':
		actividad_usuarios();
		break;
}
function inicia_sesion($email,$pwd){

	//$obj=new Mysql;
    $contra="
	SELECT
    admin.usuario_id,
    admin.nombre,
    admin.casa_id,
    admin.usuario,
    admin.pwd,
    admin.acceso,
    admin.funcion,
    admin.saldo,
    admin.observaciones,
    herramientas_sistema.perfil_id,
    herramientas_sistema.usuario_id,
    herramientas_sistema.foto,
    herramientas_sistema.nombre_corto,
    herramientas_sistema.body,
    herramientas_sistema.notificaciones
FROM
    admin
INNER JOIN herramientas_sistema ON admin.usuario_id = herramientas_sistema.usuario_id
WHERE admin.usuario='$email' AND admin.pwd='$pwd'
    ";
   //echo $contra."<br>";
      $result_tabla=ejecutar($contra); 
     //echo $result_tabla."<br>";
     $cnt= mysqli_num_rows($result_tabla);
    $row_tabla = mysqli_fetch_array($result_tabla);
    
    //print_r($row_tabla);

             
    $b=ejecutar("SELECT version FROM versiones_sis ORDER BY versiones_id DESC LIMIT 1");
    extract($b);
    if ($cnt==1) {
        extract($row_tabla); 
        //$hora = date("H:i:s");
        $mktime = time();
        $fecha = date("Y-m-d H:i:s");

        $_SESSION['nombre_user']  = $nombre;
        $_SESSION['user_id'] = $usuario_id;
        $_SESSION['usuario']  = $usuario;
        $_SESSION['sesion'] = 'On';
        $_SESSION['time'] = $mktime;
        $_SESSION['body'] = $body;
        $_SESSION['nombre_corto_user'] = $nombre_corto;
        $_SESSION['email'] = $email;
        $_SESSION['notificaciones'] = $notificaciones;
        $_SESSION['funcion'] = $funcion;
        $_SESSION['version'] = $version;
        $_SESSION['foto_user'] = $foto;
        $_SESSION['contra_cambio'] = $pwd;
        
        $monitoreo="SELECT monitoreo_id FROM monitoreo WHERE usuario_id='$usuario_id'";
        $result_tabla=ejecutar($monitoreo); 
        $cnt1= mysqli_num_rows($result_tabla);
        
        if ($cnt1>=1) {
            $update="
            UPDATE monitoreo 
                SET 
                fecha = '$fecha', 
                mktime ='$mktime', 
                estatus= 'ACTIVO' 
            WHERE monitoreo_id = '$monitoreo_id'";
            $result_tabla=ejecutar($update); 
        } else {
            $insert ="INSERT IGNORE INTO  monitoreo 
            (usuario_id,fecha,mktime,estatus) VALUE
            ('$usuario_id','$fecha','$mktime','$estatus') ";
            $result_tabla=ejecutar($insert);
        }
        
        echo 1;
    }else{
        session_destroy();
        echo 'Usuario y Contraseña Erróneo...';    
    }
	// if($a){
		// extract($a);
// 

//             
			// $sql_access= "";
			// $b=$obj->get_var("SELECT monitoreo_id FROM monitoreo WHERE usuario_id='$usuario_id'");
			// if($b!=0)
				// $c=$obj->update('monitoreo',array('fecha'=>$fecha,'mktime'=>$mktime,'estatus'=>'ACTIVO'),array('monitoreo_id'=>$b));
			// else
				// $d=$obj->insert('monitoreo',array('usuario_id'=>$usuario_id,'fecha'=>$fecha,'mktime'=>$mktime,'estatus'=>'ACTIVO'));
			// echo 1;
		// echo "hola";
	// }
	// else{
		// session_destroy();
		// echo 'Usuario y Contraseña Erróneo...';
	// }
}
function valida_actividad($user,$n){
	// $obj=new Mysql;
	// $time=$obj->get_var("SELECT mktime FROM usuario_actividad WHERE usuarios='$user'");
	// $session_life=mktime()-$time;
	// $val=0;
	// $txt_head='';
	// $table='';
	// if($session_life>=1800 || $n==2){
		// $a=$obj->update('usuario_actividad',array('estatus'=>'INACTIVO','activo'=>0),array('usuarios'=>$user));
		// session_destroy();
		// $val=1;
	// }
	// if($val!=1){
		// $sql="SELECT DISTINCT a.usuarios, b.nombre_corto FROM usuario_actividad a INNER JOIN directorio b ON a.usuarios=b.usuario WHERE a.activo=1 AND a.usuarios NOT IN('$user')";
		// $users=$obj->consulta($sql);
		// $cnt_users=mysqli_num_rows($users);
		// $txt_head="Usuarios ($cnt_users)";
		// if($cnt_users>0){
			// $i_u=0;
			// while($row_users=mysqli_fetch_array($users)){
				// $i_u++;
				// extract($row_users);
				// $table.=
				// "<tr>
					// <td><span class='glyphicon glyphicon-user' style='color:green'></span></td>
					// <td><a href='javascript:void(0)' onclick='chat_usuario(\"$usuarios\",\"$nombre_corto\",0)'>$nombre_corto</a></td>
				// </tr>";
			// }
		// }
		// else{
			// $table.='<tr><td>No hay usuarios conectados...</td></tr>';
		// }
	// }
	// $exit_arr=array('val'=>$val,'head'=>$txt_head,'body'=>$table);
	// echo json_encode($exit_arr);
}

function actividad_usuarios(){
	// $obj=new Mysql;
	// $a=$obj->consulta("SELECT usuarios, mktime FROM usuario_actividad WHERE estatus='ACTIVO' AND activo='1'");
	// $cnt=mysqli_num_rows($a);
	// if($cnt>0){
		// $time=mktime();
		// while($row=mysqli_fetch_array($a)){
			// extract($row);
			// $session_life=$time-$mktime;
			// if($session_life>=2400)
				// $b=$obj->update('usuario_actividad',array('estatus'=>'INACTIVO','activo'=>0),array('usuarios'=>$usuarios));
		// }
	// }
}

?>