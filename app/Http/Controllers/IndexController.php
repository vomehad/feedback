<?php

namespace App\Http\Controllers;

use App\Exceptions\UserNotFoundException;
use App\Http\Requests\FeedbackRequest;
use App\Http\Requests\LoginRequest;
use App\Models\Feedback;
use App\Services\FeedbackService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\RedirectResponse;

class IndexController extends Controller
{
    private FeedbackService $feedbackService;

    public function __construct(FeedbackService $feedbackService)
    {
        $this->feedbackService = $feedbackService;
    }

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
            return redirect(route('auth_form'))
                ->withErrors(['email' => __('message.auth.error')])
                ->withInput();
        }

        Auth::login($user);

        return redirect()
            ->intended(route('main'))
            ->with(['success' => __('message.auth.success')]);
    }

    public function feedback(): View
    {
        $feedback = new Feedback();

        return view('feedback', [
            'title' => __('message.feedback.title'),
            'model' => $feedback,
        ]);
    }

    /**
     * @throws \App\Exceptions\BaseException
     */
    public function feedbackStore(FeedbackRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $feedback = $this->feedbackService->create($data);

        if ($feedback?->id) {
            return redirect()
                ->route('main')
                ->with(['success' => __('message.feedback.saved')]);
        } else {
            return back()
                ->withErrors(['msg' => __('message.feedback.error')])
                ->withInput();
        }
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();

        return redirect(route('auth_form'));
    }
}
