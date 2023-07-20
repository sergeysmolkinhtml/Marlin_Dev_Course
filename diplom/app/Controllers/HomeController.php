<?php

namespace App\Controllers;
session_start();


use League\Plates\Engine;


class HomeController
{
    public function __construct(
        private readonly Engine $templateEngine
    ) {}

    public function index() : void
    {
        $this->templateEngine->render('users');
    }

}