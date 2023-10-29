<?php

namespace App\Http\Controllers\Home;

use Illuminate\Contracts\Foundation\Application as IApplication;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class MainController
{
    public function __invoke(): View|Application|Factory|IApplication
    {
        return view('home.main');
    }
}
