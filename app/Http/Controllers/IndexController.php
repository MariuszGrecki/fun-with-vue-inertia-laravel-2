<?php

namespace App\Http\Controllers;

class IndexController extends Controller
{
    public function index()
    {
        return inertia('Welcome');
    }

    public function show()
    {
        return inertia('Show');
    }
}
