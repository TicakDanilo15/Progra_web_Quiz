<?php

class RankingController
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
        Log::info("RankingController::ver");

        $this->renderer->render("rankedView", [
            "usuarios" => $this->model->getRanking()
        ]);
    }
}