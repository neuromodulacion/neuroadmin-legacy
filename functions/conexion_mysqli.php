<?php
// conexion_mysqli.php

// Clase Mysql mejorada para gestionar la conexión y consultas a la base de datos
class Mysql {
    // Propiedades privadas para la configuración de la conexión
    private $servidor;
    private $usuario;
    private $contrasena;
    private $baseDatos;
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
        // Configurar para que mysqli lance excepciones en caso de error
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        try {
            $this->link = new mysqli($this->servidor, $this->usuario, $this->contrasena, $this->baseDatos);
            $this->link->set_charset("utf8mb4"); // Establece la codificación de caracteres a UTF-8
        } catch (mysqli_sql_exception $e) {
            // Registrar el error y lanzar una excepción personalizada
            error_log($e->getMessage());
            throw new Exception("Error conectando a la base de datos.");
        }
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
     * @param string $query  La consulta SQL.
     * @param array  $params Parámetros de la consulta.
     * @return mysqli_stmt La sentencia preparada ejecutada.
     * @throws Exception Si ocurre un error al preparar o ejecutar la consulta.
     */
    private function executeQuery($query, $params = []) {
        if (!$this->link) {
            $this->conectarse();
        }

        $stmt = $this->link->prepare($query);

        if (!$stmt) {
            throw new Exception("Error preparando la consulta: " . $this->link->error);
        }

        if ($params) {
            $types = $this->getParamTypes($params); // Obtiene el tipo de cada parámetro
            $stmt->bind_param($types, ...$params); // Vincula los parámetros a la consulta
        }

        if (!$stmt->execute()) {
            throw new Exception("Error ejecutando la consulta: " . $stmt->error);
        }

        return $stmt;
    }

    /**
     * Ejecuta una consulta simple (sin retorno de datos, como INSERT o DELETE).
     *
     * @param string $query  La consulta SQL.
     * @param array  $params Parámetros de la consulta.
     * @return bool True si la consulta se ejecuta con éxito, false si hay un error.
     */
    public function consulta_simple($query, $params = []) {
        try {
            $stmt = $this->executeQuery($query, $params); // Ejecuta la consulta
            $stmt->close();
            return true;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false; // En caso de error
        }
    }

    /**
     * Ejecuta una consulta SQL y retorna el resultado como un arreglo asociativo.
     *
     * @param string $query  La consulta SQL.
     * @param array  $params Parámetros de la consulta.
     * @return array Resultado de la consulta con 'resultado' y 'numFilas'.
     */
    /*
    public function consulta($query, $params = []) {
        try {
            $stmt = $this->executeQuery($query, $params); // Ejecuta la consulta
            $resultado = $stmt->get_result(); // Obtiene el resultado de la consulta
            $data = $resultado->fetch_all(MYSQLI_ASSOC); // Convierte el resultado en un arreglo asociativo
            $stmt->close();
            return ['resultado' => $data, 'numFilas' => count($data)];
        } catch (Exception $e) {
            error_log($e->getMessage());
            return ['resultado' => [], 'numFilas' => 0]; // Retorna vacío en caso de error
        }
    }*/

    public function consulta($query, $params = [], $throwOnError = false) {
        try {
            $stmt = $this->executeQuery($query, $params);
            $resultado = $stmt->get_result();
            if (!$resultado) {
                throw new Exception("Error obteniendo el resultado: " . $this->link->error);
            }
            $data = $resultado->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            return ['resultado' => $data, 'numFilas' => count($data)];
        } catch (Exception $e) {
            error_log($e->getMessage());
            if ($throwOnError) {
                throw $e;
            }
            return ['resultado' => [], 'numFilas' => 0];
        }
    }
    

    /**
     * Inserta un nuevo registro en la base de datos y devuelve el último ID insertado.
     *
     * @param string $query  La consulta SQL de inserción.
     * @param array  $params Parámetros de la consulta.
     * @return mixed ID del último registro insertado o false si hay un error.
     */
    public function insertar($query, $params = []) {
        try {
            $stmt = $this->executeQuery($query, $params); // Ejecuta la consulta
            $idInsertado = $this->link->insert_id; // Obtiene el ID del último registro insertado
            $stmt->close();
            return $idInsertado;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false; // En caso de error
        }
    }

    /**
     * Actualiza registros en la base de datos y devuelve el número de filas afectadas.
     *
     * @param string $query  La consulta SQL de actualización.
     * @param array  $params Parámetros de la consulta.
     * @return int Número de filas afectadas o -1 en caso de error.
     */
    public function actualizar($query, $params = []) {
        try {
            $stmt = $this->executeQuery($query, $params); // Ejecuta la consulta
            $filasAfectadas = $stmt->affected_rows; // Obtiene el número de filas afectadas
            $stmt->close();
            return $filasAfectadas;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return -1; // Valor de error en caso de que la actualización falle
        }
    }

    /**
     * Elimina registros de la base de datos (internamente usa actualizar).
     *
     * @param string $query  La consulta SQL para eliminar.
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
            if (!$this->link) {
                $this->conectarse();
            }
            if (!$this->link->query($query)) {
                throw new Exception("Error creando la tabla: " . $this->link->error);
            }
            return true;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false; // Retorna false en caso de error
        }
    }

    // Métodos para transacciones

    /**
     * Inicia una transacción en la base de datos.
     */
    public function comenzarTransaccion() {
        if (!$this->link) {
            $this->conectarse();
        }
        $this->link->begin_transaction();
    }

    /**
     * Confirma la transacción actual.
     */
    public function confirmarTransaccion() {
        $this->link->commit();
    }

    /**
     * Revierte la transacción actual.
     */
    public function revertirTransaccion() {
        $this->link->rollback();
    }
} // Asegúrate de que este cierre de clase esté presente


