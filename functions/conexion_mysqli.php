<?php // conexion_mysqli.php


class Mysql {
    
    private $servidor = "174.136.25.64";
    private $usuario = "lamanad1_conexion";
    private $contrasena = "7)8S!K{%NBoL";
    private $baseDatos = "lamanad1_medico";



    public function conectarse() {
        $link = mysqli_connect($this->servidor, $this->usuario, $this->contrasena, $this->baseDatos);
        
        if (!$link) {
            echo "Error conectando a la base de datos.";
            exit();
        }
        
        mysqli_set_charset($link, "utf8"); // Establecer la codificación de caracteres
        
        return $link;
    }

public function consulta_simple($query, $params = []) {
    $link = $this->conectarse();
    
    // Preparar la consulta
    $stmt = mysqli_prepare($link, $query);
    if (!$stmt) {
        echo "Error preparando consulta: " . mysqli_error($link);
        exit();
    }
    
    if (!empty($params)) {
        // Genera el string de tipos basado en el número de parámetros
        $types = str_repeat('s', count($params)); // Asume que todos los parámetros son strings
        // Vincula los parámetros
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }
    
    // Ejecutar la consulta
    $resultado = mysqli_stmt_execute($stmt);
    
    // Verificar si hubo un error en la ejecución
    if ($resultado === false) {
        echo "Error ejecutando consulta: " . mysqli_error($link);
        exit();
    }
    
    mysqli_stmt_close($stmt);
    $this->desconectarse($link);
    return $resultado;
}



public function consulta($query, $params = []) {
    $link = $this->conectarse();
    
    // Preparar la consulta
    $stmt = mysqli_prepare($link, $query);
    if (!$stmt) {
        echo "Error preparando consulta: " . mysqli_error($link);
        exit();
    }
    
    if (!empty($params)) {
        // Genera el string de tipos basado en el número de parámetros
        $types = str_repeat('s', count($params)); // Asume que todos los parámetros son strings
        // Prepara los parámetros para bind_param
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }
    
    mysqli_stmt_execute($stmt);
    
    // Obtener los resultados manualmente sin mysqli_stmt_get_result
    $meta = $stmt->result_metadata();
    $fields = [];
    $row = [];

    while ($field = $meta->fetch_field()) {
        $fields[] = &$row[$field->name];
    }

    call_user_func_array([$stmt, 'bind_result'], $fields);
    
    $data = [];
    $numFilas = 0;

    while ($stmt->fetch()) {
        $numFilas++;
        $record = [];
        foreach ($row as $key => $val) {
            $record[$key] = $val;
        }
        $data[] = $record;
    }
    
    $stmt->close();
    $this->desconectarse($link);

    return ['resultado' => $data, 'numFilas' => $numFilas];
}

		
	
    /**
     * Ejecuta una operación de inserción en la base de datos.
     *
     * @param string $query La consulta SQL a ejecutar.
     * @param array $params Los parámetros de la consulta.
     * @param string $types Los tipos de los parámetros en un string (opcional).
     * @return mixed El ID del último elemento insertado o false si hay un error.
     */
    public function insertar($query, $params = [], $types = '') {
        $link = $this->conectarse();
        $stmt = mysqli_prepare($link, $query);
        
        if (!$stmt) {
            echo "Error preparando consulta: " . mysqli_error($link);
            exit();
        }
        
        if ($params) {
            if (!$types) {
                $types = str_repeat('s', count($params)); // Asume todos como strings si no se especifica
            }
            mysqli_stmt_bind_param($stmt, $types, ...$params);
        }
        
        $resultado = mysqli_stmt_execute($stmt);
        
        if ($resultado) {
            $idInsertado = mysqli_stmt_insert_id($stmt);
        } else {
            echo "Error ejecutando consulta: " . mysqli_error($link);
            $idInsertado = false;
        }
        
        mysqli_stmt_close($stmt);
        $this->desconectarse($link);
        
        return $idInsertado;
    }

    /**
     * Ejecuta una operación de actualización en la base de datos y devuelve el número de filas afectadas.
     *
     * @param string $query La consulta SQL a ejecutar.
     * @param array $params Los parámetros de la consulta.
     * @param string $types Los tipos de los parámetros en un string (opcional).
     * @return int El número de filas afectadas.
     */
    public function actualizar($query, $params = [], $types = '') {
        $link = $this->conectarse();
        $stmt = mysqli_prepare($link, $query);
        
        if (!$stmt) {
            echo "Error preparando consulta: " . mysqli_error($link);
            exit();
        }
        
        if (!empty($params)) {
            if (!$types) {
                $types = str_repeat('s', count($params)); // Asume todos como strings si no se especifica
            }
            mysqli_stmt_bind_param($stmt, $types, ...$params);
        }
        
        $resultado = mysqli_stmt_execute($stmt);
        
        if ($resultado) {
            $filasAfectadas = mysqli_stmt_affected_rows($stmt);
        } else {
            echo "Error ejecutando consulta: " . mysqli_error($link);
            $filasAfectadas = -1; // Un valor de error, ya que 0 es un valor válido que indica que ninguna fila fue afectada.
        }
        
        mysqli_stmt_close($stmt);
        $this->desconectarse($link);
        
        return $filasAfectadas;
    }

    /**
     * Ejecuta una sentencia SQL para crear una nueva tabla o estructura en la base de datos.
     *
     * @param string $query La consulta SQL `CREATE TABLE` a ejecutar.
     * @return bool Verdadero si la tabla se creó con éxito, falso en caso contrario.
     */
    public function crear($query) {
        $link = $this->conectarse();
        $resultado = mysqli_query($link, $query);

        if ($resultado) {
            echo "La tabla se ha creado con éxito.";
        } else {
            echo "Error creando la tabla: " . mysqli_error($link);
        }

        $this->desconectarse($link);
        return $resultado;
    }

    private function desconectarse($link) {
        mysqli_close($link);
    }
}
?>