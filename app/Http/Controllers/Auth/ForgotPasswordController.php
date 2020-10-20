<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    public function showLinkRequestForm()
    {
        return Inertia::render('Admin/Auth/ForgotPassword', [
            'success' => Session::get('status'),
        ]);
    }
}
