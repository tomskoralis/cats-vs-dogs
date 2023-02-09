<?php

namespace App\Controllers;

use App\Responses\Template;

class HomeController
{
    public function index(): Template
    {
        return new Template('home');
    }
}