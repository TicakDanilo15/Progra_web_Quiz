<?php

class RankingModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getRanking()
    {
        $sql = "SELECT
                    (SELECT COUNT(*)
                     FROM usuario u2
                     WHERE u2.puntaje > u1.puntaje) + 1 AS posicion,
                    u1.username,
                    u1.puntaje
                FROM usuario u1
                ORDER BY u1.puntaje DESC";

        Log::info("SQL: $sql");

        return $this->database->query($sql);
    }
}