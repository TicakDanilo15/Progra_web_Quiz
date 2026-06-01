<?php

class MyDatabase
{
    private $conexion;

    public function __construct($hostname, $username, $password, $database)
    {
        $this->conexion = new mysqli($hostname, $username, $password, $database);
    }

    public function query($sql, $params = [])
    {
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) {
            throw new Exception('Error al preparar consulta: ' . $this->conexion->error);
        }

        $this->bindParams($stmt, $params);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function execute($sql, $params = [])
    {
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) {
            throw new Exception('Error al preparar consulta: ' . $this->conexion->error);
        }

        $this->bindParams($stmt, $params);
        $stmt->execute();
        return $this->conexion->affected_rows;
    }

    private function bindParams($stmt, $params)
    {
        if (empty($params)) {
            return;
        }

        $types = '';
        foreach ($params as $param) {
            if (is_int($param)) {
                $types .= 'i';
            } elseif (is_float($param)) {
                $types .= 'd';
            } else {
                $types .= 's';
            }
        }

        $refs = [];
        foreach ($params as $index => $value) {
            $refs[$index] = &$params[$index];
        }

        array_unshift($refs, $types);
        call_user_func_array([$stmt, 'bind_param'], $refs);
    }

    public function __destruct()
    {
        $this->conexion->close();
    }
}
