<?php
class Mysql {
    
    private $servidor = "174.136.25.64";
    private $usuario = "lamanad1_conexion";
    private $contrasena = "7)8S!K{%NBoL";
    private $baseDatos = "lamanad1_medico";
	

    private function conectarse() {
        $link = mysqli_connect($this->servidor, $this->usuario, $this->contrasena, $this->baseDatos);
        if (!$link) {
            echo "Error conectando a la base de datos.";
            exit();
        }
        mysqli_set_charset($link, "utf8");
        return $link;
    }

    private function determinarTipo($item) {
        switch (gettype($item)) {
            case 'integer': return 'i';
            case 'double':  return 'd';
            case 'string':  return 's';
            default:        return 'b'; // Considera 'b' para otros tipos, como blobs
        }
    }

    public function consulta($query, $params = []) {
        $link = $this->conectarse();
        $stmt = mysqli_prepare($link, $query);
        if (!$stmt) {
            echo "Error preparando consulta: " . mysqli_error($link);
            exit();
        }
        
        if (!empty($params)) {
            $types = '';
            foreach ($params as $param) {
                $types .= $this->determinarTipo($param);
            }
            
            mysqli_stmt_bind_param($stmt, $types, ...$params);
        }
        
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($result) {
            $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
            $numFilas = $result->num_rows;
            mysqli_free_result($result);
        } else {
            echo "Error ejecutando consulta: " . mysqli_error($link);
            $data = [];
            $numFilas = 0;
        }
        
        mysqli_stmt_close($stmt);
        $this->desconectarse($link);
        return ['resultado' => $data, 'numFilas' => $numFilas];
    }

    private function desconectarse($link) {
        mysqli_close($link);
    }
}
?>
