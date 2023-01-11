<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostConroller extends Controller
{
    public function index(Request $request)
    {
        dd('/test');
    }
}
