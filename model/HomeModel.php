<?php

class HomeModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getUsuarioPrincipal()
    {
        $sql = "SELECT * FROM usuario LIMIT 1";
        Log::info("SQL: $sql");

        $usuarios = $this->database->query($sql);

        return !empty($usuarios) ? $usuarios[0] : null;
    }

    public function getCantidadPartidas()
    {
        $sql = "SELECT COUNT(*) AS total FROM partida";
        Log::info("SQL: $sql");

        $resultado = $this->database->query($sql);

        return !empty($resultado) ? $resultado[0]["total"] : 0;
    }

    public function getPreguntasCorrectas()
    {
        $sql = "SELECT COUNT(*) AS total FROM partida WHERE resultado = 'VICTORIA'";
        Log::info("SQL: $sql");

        $resultado = $this->database->query($sql);

        return !empty($resultado) ? $resultado[0]["total"] : 0;
    }

    public function getPorcentajeAciertos()
    {
        $sql = "SELECT 
                    ROUND(
                        SUM(CASE WHEN resultado = 'VICTORIA' THEN 1 ELSE 0 END) * 100 / COUNT(*)
                    ) AS porcentaje
                FROM partida";

        Log::info("SQL: $sql");

        $resultado = $this->database->query($sql);

        return !empty($resultado) && $resultado[0]["porcentaje"] !== null
            ? $resultado[0]["porcentaje"]
            : 0;
    }

    public function getUltimasPartidas()
    {
        $sql = "SELECT * FROM partida ORDER BY fecha DESC LIMIT 4";
        Log::info("SQL: $sql");

        return $this->database->query($sql);
    }
}