<?php
class Mysql{
    public function __construct(){}
    
    public function conectarse(){
        if (!($link = mysqli_connect("65.99.252.206", "lamanad1_conexion","7)8S!K{%NBoL"))){
            //mysqli_query("SET NAMES 'utf8'", $link);
            mysqli_query($link);
            echo "Error conectando a la base de datos.";
            exit();
        }
        if (!mysqli_select_db("lamanad1_coto2784", $link)) {
            echo "Error seleccionando la base de datos.";
            exit();
        }
        return $link;
    }
    
    public function desconectarse($link) {
        mysqli_close($link);
    }
    
    public function insert($tabla, $array){
        $sql="INSERT IGNORE INTO $tabla (";
        $sql2=" VALUES(";
        $i=0;
        
        $leng=count($array);
        foreach($array as $key => $value){
            if($i==$leng-1){
                $sql.="$key)";
                $sql2.="'$value')";
            }
            else{
                $sql.="$key, ";
                $sql2.="'$value', ";
            }
            $i++;
        }
        $query=$sql.$sql2;
        $link=$this->conectarse();
        $result=mysqli_query($query) or die(mysqli_error());
        if($result==1)
            $last_id=mysqli_insert_id();
        $this->desconectarse($link);
        return $last_id;
    }
    
    public function update($tabla, $array_set, $array_where){
        $sql="UPDATE $tabla SET ";
        $sql2=" WHERE ";
        $i=0;
        $j=0;
        $leng=count($array_set);
        $leng2=count($array_where);
        foreach($array_set as $key => $value){
            if($i==$leng-1){
                $sql.="$key='$value'";
            }
            else{
                $sql.="$key='$value', ";
            }
            $i++;
        }
        foreach($array_where as $key2 => $value2){
            if($j==$leng2-1){
                $sql2.=" $key2='$value2'";
            }
            else{
                $sql2.=" $key2='$value2' AND";
            }
            $j++;
        }
        $query=$sql.$sql2;
        return $this->consulta($query);
    }
    
    public function delete($tabla, $array){
        $sql="DELETE FROM $tabla WHERE ";
        $i=0;
        $leng=count($array);
        foreach($array as $key => $value){
            if($i==$leng-1){
                $sql.="$key='$value'";
            }
            else{
                $sql.="$key=$value AND";
            }
            $i++;
        }
        $sql.=" LIMIT 1";
        $r=$this->consulta($sql);
        return $r;
    }
    
    public function consulta($query){
        $link=$this->conectarse();
        $result=mysqli_query($query) or die(mysqli_error());
        $this->desconectarse($link);
        return $result;
    }
    
    public function create_tables($table,$n){
        if($n==1){
            $sql="CREATE TABLE IF NOT EXISTS `$table` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `id_encuesta` int(11) NOT NULL,
                `id_pregunta` int(11) NOT NULL,
                `respuesta` text NOT NULL,
                `usuario` varchar(10) NOT NULL,
                `activo` tinyint NOT NULL,
                PRIMARY KEY(`id`)) ENGINE=InnoDB";
        }
        else{
            $sql="CREATE TABLE IF NOT EXISTS `$table` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `id_encuesta` int(11) NOT NULL,
                `usuario` varchar(10) NOT NULL, ";
            for($i=0; $i<count($n); $i++){
                switch($n[$i]){
                    case 1:
                        $campo="n_empresa";
                        $sql.="`$campo` varchar(10) NOT NULL, ";
                        break;
                    case 2:
                        $campo="n_cuadrilla";
                        $sql.="`$campo` varchar(11) NOT NULL, ";
                        break;
                    case 3:
                        $campo="region";
                        $sql.="`$campo` int(11) NOT NULL, ";
                        break;
                    case 4:
                        $campo="estado";
                        $sql.="`$campo` int(11) NOT NULL, ";
                        break;
                    case 5:
                        $campo="municipio";
                        $sql.="`$campo` int(11) NOT NULL, ";
                        break;
                    case 6:
                        $campo="n_cliente";
                        $sql.="`$campo` int(11) NOT NULL, ";
                        break;
                }
            }
            $sql.="PRIMARY KEY(`id`)) ENGINE=InnoDB";
        }
        $link=$this->conectarse();
        $result=mysqli_query($sql);
        $this->desconectarse($link);
    }
    
    public function get_var($sql){
        $link=$this->conectarse();
        $result=mysqli_query($sql);
        $this->desconectarse($link);
        $row = mysqli_fetch_row($result);
        if($row)
            $r=$row[0];
        else
            $r='';
        return $r;
    }
    
    public function get_results($sql){
        $link=$this->conectarse();
        $result=mysqli_query($sql);
        $this->desconectarse($link);
        $array=array();
        while($row = mysqli_fetch_assoc($result)){
            $array[]=$row;
        }
        return $array;
    }
    
    public function query($sql){
        $link=$this->conectarse();
        $result=mysqli_query($sql) or die(mysqli_error());
        $this->desconectarse($link);
        $row = mysqli_fetch_array($result);
        return $row;
    }
    
    public static function crear_array_id_preg(&$array_id_preg,$id_p){
        array_push($array_id_preg, $id_p);
        return $array_id_preg;
    }
    
    public static function print_array_id_preg($array_id_preg){
        print_r($array_id_preg);
    }
    
    public function usuario_actividad($user){
        $m_time=mktime();
        $link=$this->conectarse();
        $result=mysqli_query("UPDATE usuario_actividad SET h_mktime='$m_time' WHERE usuarios='$user'");
        $this->desconectarse($link);
    }
    

}
 
?>