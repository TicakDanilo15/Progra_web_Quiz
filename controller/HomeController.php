<?php

class HomeController
{
    private $model;
    private $renderer;
    private $request;

    public function __construct($model, $renderer, $request)
    {
        $this->model    = $model;
        $this->renderer = $renderer;
        $this->request  = $request;
    }

    public function ver()
    {
        Log::info("HomeController::ver");

        $usuario = $this->model->getUsuarioPrincipal();
        $partidas = $this->model->getUltimasPartidas();

        foreach ($partidas as &$partida) {
            $partida["puntos"] = "+" . $partida["puntaje"] . " pts";
            $partida["icono"] = $this->getIconoCategoria($partida["categoria"]);
            $partida["resultadoClase"] = $partida["resultado"] == "VICTORIA" ? "success" : "danger";
        }

        $this->renderer->render("homeView", [
            "usuario" => $usuario ? $usuario["username"] : "Invitado",
            "puntaje" => $usuario ? $usuario["puntaje"] : 0,
            "partidasJugadas" => $this->model->getCantidadPartidas(),
            "preguntasCorrectas" => $this->model->getPreguntasCorrectas(),
            "porcentajeAciertos" => $this->model->getPorcentajeAciertos(),
            "rachaActual" => "0 victorias",
            "partidas" => $partidas
        ]);
    }

    private function getIconoCategoria($categoria)
    {
        switch ($categoria) {
            case "Historia":
                return "🏛️";

            case "Deportes":
                return "⚽";

            case "Ciencia":
                return "🧪";

            case "Cultura General":
                return "🎨";

            default:
                return "❔";
        }
    }
}