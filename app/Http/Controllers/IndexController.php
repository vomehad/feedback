<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class IndexController extends Controller
{
    public function auth(): View
    {
        return view('login', [
            'title' => __('message.auth.login'),
        ]);
    }
}
