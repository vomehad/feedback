<?php

namespace App\Http\Controllers;

use App\Exceptions\UserNotFoundException;
use App\Http\Requests\LoginRequest;
use App\Models\Feedback;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function auth(): View
    {
        return view('login', [
            'title' => __('message.auth.login'),
        ]);
    }

    /**
     * @throws \App\Exceptions\UserNotFoundException
     */
    public function login(LoginRequest $request): string
    {
        $data = $request->validated();

        $user = User::where(['email' => $data['email']])->first();

        if (!$user) {
            throw new UserNotFoundException(__('message.user.not_found'));
        }

        if (!Auth::attempt($data)) {
            return redirect(route('auth_form'))->withErrors($user);
        }

        Auth::login($user);
        return redirect(route('main'));
    }

    public function feedback(): View
    {
        $feedback = new Feedback();

        return view('feedback', [
            'title' => __('message.feedback.title'),
            'model' => $feedback,
        ]);
    }
}
