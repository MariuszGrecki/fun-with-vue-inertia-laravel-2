<?php

namespace App\Http\Controllers;

use Inertia\Response;

class IndexController extends Controller
{
    public function index(): Response
    {
        return inertia(
            'Welcome',
            [
                'message' => 'hello from laravel',
            ]
        );
    }

    public function show(): Response
    {
        return inertia('Show');
    }
}
