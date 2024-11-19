<?php // conexion_mysqli.php
// Clase Mysql para gestionar la conexión y consultas a la base de datos con métodos para transacciones y manejo de errores
class Mysql {
    // Propiedades privadas para la configuración de la conexión
    
    private $servidor = "174.136.25.64";
    private $usuario = "lamanad1_conexion";
    private $contrasena = "7)8S!K{%NBoL";
    private $baseDatos = "lamanad1_medico";
        
    // private $servidor;
    // private $usuario;
    // private $contrasena;
    // private $baseDatos;
// 	
    private $link; // Almacenará la conexión activa a la base de datos

    /**
     * Constructor de la clase Mysql que recibe los parámetros de conexión.
     *
     * @param string $servidor   Nombre del servidor de la base de datos.
     * @param string $usuario    Nombre de usuario para la base de datos.
     * @param string $contrasena Contraseña para la base de datos.
     * @param string $baseDatos  Nombre de la base de datos.
     */
    public function __construct($servidor, $usuario, $contrasena, $baseDatos) {
        $this->servidor = $servidor;
        $this->usuario = $usuario;
        $this->contrasena = $contrasena;
        $this->baseDatos = $baseDatos;
    }

    /**
     * Establece la conexión a la base de datos y configura el juego de caracteres a UTF-8.
     *
     * @throws Exception Si ocurre un error en la conexión.
     */
    public function conectarse() {
        $this->link = new mysqli($this->servidor, $this->usuario, $this->contrasena, $this->baseDatos);

        if ($this->link->connect_error) {
            throw new Exception("Error conectando a la base de datos.");
        }

        $this->link->set_charset("utf8"); // Establece la codificación de caracteres a UTF-8
    }

    /**
     * Cierra la conexión a la base de datos.
     */
    public function desconectarse() {
        if ($this->link) {
            $this->link->close();
        }
    }

    /**
     * Devuelve una cadena de tipos para los parámetros en una consulta preparada.
     *
     * @param array $params Lista de parámetros para la consulta.
     * @return string Cadena con los tipos de los parámetros.
     */
    private function getParamTypes($params) {
        $types = '';
        foreach ($params as $param) {
            if (is_int($param)) {
                $types .= 'i'; // Entero
            } elseif (is_float($param)) {
                $types .= 'd'; // Doble
            } elseif (is_string($param)) {
                $types .= 's'; // String
            } else {
                $types .= 'b'; // Blob (para tipos binarios)
            }
        }
        return $types;
    }

    /**
     * Ejecuta una consulta preparada con parámetros.
     *
     * @param string $query La consulta SQL.
     * @param array  $params Parámetros de la consulta.
     * @return mysqli_stmt La sentencia preparada ejecutada.
     * @throws Exception Si ocurre un error al preparar o ejecutar la consulta.
     */
    private function executeQuery($query, $params = []) {
        $this->conectarse();
        $stmt = $this->link->prepare($query);

        if (!$stmt) {
            throw new Exception("Error preparando consulta.");
        }

        if ($params) {
            $types = $this->getParamTypes($params); // Obtiene el tipo de cada parámetro
            $stmt->bind_param($types, ...$params); // Vincula los parámetros a la consulta
        }

        if (!$stmt->execute()) {
            throw new Exception("Error ejecutando consulta.");
        }

        return $stmt;
    }

    /**
     * Ejecuta una consulta simple (sin retorno de datos, como INSERT o DELETE).
     *
     * @param string $query La consulta SQL.
     * @param array  $params Parámetros de la consulta.
     * @return bool True si la consulta se ejecuta con éxito, false si hay un error.
     */
    public function consulta_simple($query, $params = []) {
        try {
            $stmt = $this->executeQuery($query, $params); // Ejecuta la consulta
            $stmt->close();
            $this->desconectarse();
            return true;
        } catch (Exception $e) {
            $this->desconectarse();
            return false; // En caso de error
        }
    }

    /**
     * Ejecuta una consulta SQL y retorna el resultado como un arreglo asociativo.
     *
     * @param string $query La consulta SQL.
     * @param array  $params Parámetros de la consulta.
     * @return array Resultado de la consulta con 'resultado' y 'numFilas'.
     */
    public function consulta($query, $params = []) {
        try {
            $stmt = $this->executeQuery($query, $params); // Ejecuta la consulta
            $resultado = $stmt->get_result(); // Obtiene el resultado de la consulta
            $data = $resultado->fetch_all(MYSQLI_ASSOC); // Convierte el resultado en un arreglo asociativo
            $stmt->close();
            $this->desconectarse();
            return ['resultado' => $data, 'numFilas' => count($data)];
        } catch (Exception $e) {
            $this->desconectarse();
            return ['resultado' => [], 'numFilas' => 0]; // Retorna vacío en caso de error
        }
    }

    /**
     * Inserta un nuevo registro en la base de datos y devuelve el último ID insertado.
     *
     * @param string $query La consulta SQL de inserción.
     * @param array  $params Parámetros de la consulta.
     * @return mixed ID del último registro insertado o false si hay un error.
     */
    public function insertar($query, $params = []) {
        try {
            $stmt = $this->executeQuery($query, $params); // Ejecuta la consulta
            $idInsertado = $stmt->insert_id; // Obtiene el ID del último registro insertado
            $stmt->close();
            $this->desconectarse();
            return $idInsertado;
        } catch (Exception $e) {
            $this->desconectarse();
            return false; // En caso de error
        }
    }

    /**
     * Actualiza registros en la base de datos y devuelve el número de filas afectadas.
     *
     * @param string $query La consulta SQL de actualización.
     * @param array  $params Parámetros de la consulta.
     * @return int Número de filas afectadas o -1 en caso de error.
     */
    public function actualizar($query, $params = []) {
        try {
            $stmt = $this->executeQuery($query, $params); // Ejecuta la consulta
            $filasAfectadas = $stmt->affected_rows; // Obtiene el número de filas afectadas
            $stmt->close();
            $this->desconectarse();
            return $filasAfectadas;
        } catch (Exception $e) {
            $this->desconectarse();
            return -1; // Valor de error en caso de que la actualización falle
        }
    }

    /**
     * Elimina registros de la base de datos (internamente usa actualizar).
     *
     * @param string $query La consulta SQL para eliminar.
     * @param array  $params Parámetros de la consulta.
     * @return int Número de filas afectadas o -1 en caso de error.
     */
    public function eliminar($query, $params = []) {
        return $this->actualizar($query, $params);
    }

    /**
     * Crea una nueva tabla o estructura en la base de datos.
     *
     * @param string $query La consulta SQL `CREATE TABLE`.
     * @return bool True si la tabla se crea con éxito, false en caso de error.
     */
    public function crear($query) {
        try {
            $this->conectarse();
            if (!$this->link->query($query)) {
                throw new Exception("Error creando la tabla.");
            }
            $this->desconectarse();
            return true;
        } catch (Exception $e) {
            $this->desconectarse();
            return false; // Retorna false en caso de error
        }
    }

    // Métodos para transacciones

    /**
     * Inicia una transacción en la base de datos.
     */
    public function comenzarTransaccion() {
        $this->conectarse();
        $this->link->begin_transaction();
    }

    /**
     * Confirma la transacción actual.
     */
    public function confirmarTransaccion() {
        $this->link->commit();
        $this->desconectarse();
    }

    /**
     * Revierte la transacción actual.
     */
    public function revertirTransaccion() {
        $this->link->rollback();
        $this->desconectarse();
    }
}

// class Mysql {
//     
    // private $servidor = "174.136.25.64";
    // private $usuario = "lamanad1_conexion";
    // private $contrasena = "7)8S!K{%NBoL";
    // private $baseDatos = "lamanad1_medico";
// 
// 
// 
    // public function conectarse() {
        // $link = mysqli_connect($this->servidor, $this->usuario, $this->contrasena, $this->baseDatos);
//         
        // if (!$link) {
            // echo "Error conectando a la base de datos.";
            // exit();
        // }
//         
        // mysqli_set_charset($link, "utf8"); // Establecer la codificación de caracteres
//         
        // return $link;
    // }
// 
// public function consulta_simple($query, $params = []) {
    // $link = $this->conectarse();
//     
    // // Preparar la consulta
    // $stmt = mysqli_prepare($link, $query);
    // if (!$stmt) {
        // echo "Error preparando consulta: " . mysqli_error($link);
        // exit();
    // }
//     
    // if (!empty($params)) {
        // // Genera el string de tipos basado en el número de parámetros
        // $types = str_repeat('s', count($params)); // Asume que todos los parámetros son strings
        // // Vincula los parámetros
        // mysqli_stmt_bind_param($stmt, $types, ...$params);
    // }
//     
    // // Ejecutar la consulta
    // $resultado = mysqli_stmt_execute($stmt);
//     
    // // Verificar si hubo un error en la ejecución
    // if ($resultado === false) {
        // echo "Error ejecutando consulta: " . mysqli_error($link);
        // exit();
    // }
//     
    // mysqli_stmt_close($stmt);
    // $this->desconectarse($link);
    // return $resultado;
// }
// 
// 
// 
// public function consulta($query, $params = []) {
    // $link = $this->conectarse();
//     
    // // Preparar la consulta
    // $stmt = mysqli_prepare($link, $query);
    // if (!$stmt) {
        // echo "Error preparando consulta: " . mysqli_error($link);
        // exit();
    // }
//     
    // if (!empty($params)) {
        // // Genera el string de tipos basado en el número de parámetros
        // $types = str_repeat('s', count($params)); // Asume que todos los parámetros son strings
        // // Prepara los parámetros para bind_param
        // mysqli_stmt_bind_param($stmt, $types, ...$params);
    // }
//     
    // mysqli_stmt_execute($stmt);
//     
    // // Obtener los resultados manualmente sin mysqli_stmt_get_result
    // $meta = $stmt->result_metadata();
    // $fields = [];
    // $row = [];
// 
    // while ($field = $meta->fetch_field()) {
        // $fields[] = &$row[$field->name];
    // }
// 
    // call_user_func_array([$stmt, 'bind_result'], $fields);
//     
    // $data = [];
    // $numFilas = 0;
// 
    // while ($stmt->fetch()) {
        // $numFilas++;
        // $record = [];
        // foreach ($row as $key => $val) {
            // $record[$key] = $val;
        // }
        // $data[] = $record;
    // }
//     
    // $stmt->close();
    // $this->desconectarse($link);
// 
    // return ['resultado' => $data, 'numFilas' => $numFilas];
// }
// 
// 		
// 	
    // /**
     // * Ejecuta una operación de inserción en la base de datos.
     // *
     // * @param string $query La consulta SQL a ejecutar.
     // * @param array $params Los parámetros de la consulta.
     // * @param string $types Los tipos de los parámetros en un string (opcional).
     // * @return mixed El ID del último elemento insertado o false si hay un error.
     // */
    // public function insertar($query, $params = [], $types = '') {
        // $link = $this->conectarse();
        // $stmt = mysqli_prepare($link, $query);
//         
        // if (!$stmt) {
            // echo "Error preparando consulta: " . mysqli_error($link);
            // exit();
        // }
//         
        // if ($params) {
            // if (!$types) {
                // $types = str_repeat('s', count($params)); // Asume todos como strings si no se especifica
            // }
            // mysqli_stmt_bind_param($stmt, $types, ...$params);
        // }
//         
        // $resultado = mysqli_stmt_execute($stmt);
//         
        // if ($resultado) {
            // $idInsertado = mysqli_stmt_insert_id($stmt);
        // } else {
            // echo "Error ejecutando consulta: " . mysqli_error($link);
            // $idInsertado = false;
        // }
//         
        // mysqli_stmt_close($stmt);
        // $this->desconectarse($link);
//         
        // return $idInsertado;
    // }
// 
    // /**
     // * Ejecuta una operación de actualización en la base de datos y devuelve el número de filas afectadas.
     // *
     // * @param string $query La consulta SQL a ejecutar.
     // * @param array $params Los parámetros de la consulta.
     // * @param string $types Los tipos de los parámetros en un string (opcional).
     // * @return int El número de filas afectadas.
     // */
    // public function actualizar($query, $params = [], $types = '') {
        // $link = $this->conectarse();
        // $stmt = mysqli_prepare($link, $query);
//         
        // if (!$stmt) {
            // echo "Error preparando consulta: " . mysqli_error($link);
            // exit();
        // }
//         
        // if (!empty($params)) {
            // if (!$types) {
                // $types = str_repeat('s', count($params)); // Asume todos como strings si no se especifica
            // }
            // mysqli_stmt_bind_param($stmt, $types, ...$params);
        // }
//         
        // $resultado = mysqli_stmt_execute($stmt);
//         
        // if ($resultado) {
            // $filasAfectadas = mysqli_stmt_affected_rows($stmt);
        // } else {
            // echo "Error ejecutando consulta: " . mysqli_error($link);
            // $filasAfectadas = -1; // Un valor de error, ya que 0 es un valor válido que indica que ninguna fila fue afectada.
        // }
//         
        // mysqli_stmt_close($stmt);
        // $this->desconectarse($link);
//         
        // return $filasAfectadas;
    // }
// 
    // /**
     // * Ejecuta una sentencia SQL para crear una nueva tabla o estructura en la base de datos.
     // *
     // * @param string $query La consulta SQL `CREATE TABLE` a ejecutar.
     // * @return bool Verdadero si la tabla se creó con éxito, falso en caso contrario.
     // */
    // public function crear($query) {
        // $link = $this->conectarse();
        // $resultado = mysqli_query($link, $query);
// 
        // if ($resultado) {
            // echo "La tabla se ha creado con éxito.";
        // } else {
            // echo "Error creando la tabla: " . mysqli_error($link);
        // }
// 
        // $this->desconectarse($link);
        // return $resultado;
    // }
// 
    // private function desconectarse($link) {
        // mysqli_close($link);
    // }
// }
?>