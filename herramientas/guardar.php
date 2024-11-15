<?php
include('../functions/funciones_mysql.php');
//$obj=new Mysql;
session_start();
error_reporting(0);
iconv_set_encoding('internal_encoding', 'utf-8');
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');
extract($_POST);
//print_r($_POST);
extract($_SESSION);

switch ($tipo_g) {
	case 'logo':
        $update ="
        UPDATE estudio
        SET estudio.logo = '$logo_estudio'
        WHERE
            estudio.estudio_id = $estudio_id;";
        $result_update = ejecutar($update);
        $_SESSION['logo_estudio'] = $logo_estudio;
		break;
	
    case 'foto_perfil':
        $update ="
        UPDATE herramientas_sistema
        SET herramientas_sistema.foto = '$foto_user'
        WHERE
            herramientas_sistema.user_id = $user_id;";
        $result_update = ejecutar($update);
        $_SESSION['foto_user'] = $foto_user;
        break;
    
    case 'guarda_perfil':
        $update ="
        UPDATE usuarios
        INNER JOIN herramientas_sistema ON herramientas_sistema.user_id = usuarios.user_id
        SET usuarios.nombre = '$nombre',
         usuarios.usuario = '$nombre',
         herramientas_sistema.nombre_corto = '$nombre_corto_user'
        WHERE
            usuarios.user_id = $user_id;";
            
        $result_update = ejecutar($update);

            $_SESSION['nombre_user']  = $nombre;
            $_SESSION['usuario']  = $usuario;
            $_SESSION['nivel'] = $tipo_id;
            $_SESSION['nombre_corto_user'] = $nombre_corto_user;
            $_SESSION['tipo_id'] = $tipo_id;
        break;
        
    case 'guarda_pwd':
        $update ="
        UPDATE usuarios
        SET usuarios.pwd = '$NewPasswordConfirm'
        WHERE
            usuarios.user_id = $user_id;";
            echo $update;
        $result_update = ejecutar($update);
        $_SESSION['contra_cambio'] = $NewPasswordConfirm;
        break;
        
    case 'guarda_emp':
        $update ="
        UPDATE estudio
        SET 
        estudio.nombre = '$nom_estudio',
        estudio.utilidad = $utilidad1
        WHERE
            estudio.estudio_id = $estudio_id;";
            echo $update;
        $result_update = ejecutar($update);
        $_SESSION['nom_estudio'] = $nom_estudio;
        $_SESSION['utilidad'] = $utilidad1;
        break;
        
    case 'alta_emp':
        $f_alta=date('Y-m-d H:m:s');
        $insert ="INSERT IGNORE INTO  usuarios
        (tipo_id,estudio_id,nombre,estatus,nivel,mail)
        value
        ($tipo_id_g,$estudio_id,'$nombre','pendiente','$tipo_id_g','$email_g')";
        //echo $insert;
        $sql_id="SELECT MAX(user_id) AS id FROM usuarios";
        //echo $sql_id;
        $result_insert = ejecutar($insert);
        $result_id = ejecutar($sql_id);
        $row_id = mysqli_fetch_array($result_id);
        extract($row_id);
        //print_r($row_id);
        $insert1 ="INSERT IGNORE INTO  herramientas_sistema
        (user_id,estudio_id,nombre_corto,email,body,notificaciones,f_alta)
        value
        ($id,$estudio_id,'$nombre','$email_g','$body','si','$f_alta')";
            echo $insert1;
        $result_insert = ejecutar($insert1);
        break;
        
    case 'editar_user':
        $sql="
            SELECT
                usuarios.user_id as id_mod,
                usuarios.nombre as nombre_mod,
                tipo_user.tipo as tipo_mod,
                tipo_user.tipo_id as tipo_id_mod,
                herramientas_sistema.nombre_corto as nombre_corto_mod,
                herramientas_sistema.email as email_mod
            FROM
                usuarios
            INNER JOIN tipo_user ON usuarios.tipo_id = tipo_user.tipo_id
            INNER JOIN herramientas_sistema ON herramientas_sistema.user_id = usuarios.user_id
            WHERE usuarios.user_id = $id";
            //echo $sql."<br>";
            $result_sql = ejecutar($sql);
            $row_id = mysqli_fetch_array($result_sql);
            extract($row_id);
        
        ?>
        <form id="mod_emp" class="form-horizontal">
            <div class="form-group">
                    <label for="nombre_user" class="col-sm-2 control-label">Nombre Completo</label>
                    <div class="col-sm-10">
                        <div class="form-line">
                            <input type="text" class="form-control " id="nombre_mod" name="nombre_mod" placeholder="Nombre Completo" value="<?php echo $nombre_mod; ?>" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="NameSurname" class="col-sm-2 control-label">Nombre Corto</label>
                    <div class="col-sm-10">
                        <div class="form-line">
                            <input type="text" class="form-control" id="nombre_corto_mod" name="nombre_corto_mod" placeholder="Nombre Corto" value="<?php echo $nombre_corto_mod; ?>" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="tipo_id" class="col-sm-2 control-label">Tipo de usuario</label>
                    <div class="col-sm-10">
                             <select class="form-control show-tick" id="tipo_id_mod" name="tipo_id_mod" >
                                <option value="">-- Seleciona --</option>
                                <?php if($nivel == "1"){ ?><option <?php if($tipo_id_mod == "1"){ echo "selected";} ?> value="1">Sistemas</option><?php } ?>
                                <option <?php if($tipo_id_mod == "2"){ echo "selected";} ?> value="2">Administracion</option>
                                <option <?php if($tipo_id_mod == "3"){ echo "selected";} ?> value="3">Editor</option>
                            </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="Email" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                        <div class="form-line">
                            <b><?php echo $email_mod; ?></b>
                            <!-- <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $email; ?>" required> -->
                        </div>
                    </div>
                </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-danger">GUARDAR ALTA</button>
                </div>
            </div>
            <input type="hidden" id="tipo_g1_<?php echo $id_mod; ?>" name="tipo_g" value="mod_emp" />
            <input type="hidden" id="id_mod" name="id_mod" value="<?php echo $id_mod; ?>" />
        </form>
        <script>
            $("#mod_emp").submit(function(){ 
                var datastring = $("#mod_emp").serialize();
                 //alert(datastring);
                $.ajax({
                    url: "guardar.php",
                    type: "POST",
                    data: datastring, 
                    cache: false,
                    success:function(html){
                        // alert(html);     
                     }
                 });
                
            });
        </script>
        <?php
        break;
        
    
    case 'mod_emp':
        
        $f_modif=date('Y-m-d H:m:s');
        $update ="
        UPDATE usuarios
        INNER JOIN herramientas_sistema ON herramientas_sistema.user_id = usuarios.user_id
        SET usuarios.nombre = '$nombre_mod',
         usuarios.usuario = '$nombre_mod',
         herramientas_sistema.nombre_corto = '$nombre_corto_mod',
         usuarios.tipo_id = $tipo_id_mod,
         usuarios.nivel = $tipo_id_mod,
         usuarios.f_modif = '$f_modif'
        WHERE
            usuarios.user_id = $id_mod";
         //echo $update;   
        $result_update = ejecutar($update);
        //echo $result_update;
        break;
}

