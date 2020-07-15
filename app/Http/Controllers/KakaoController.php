<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

class KakaoController extends Controller
{
    public function login()
    {
        return Redirect::to('https://kauth.kakao.com/oauth/authorize?client_id='.
            config('services.kakao.client_id').
            '&redirect_uri='.
            config('services.kakao.redirect_uri').
            '&response_type=code&scope=talk_message,friends');
    }

    public function redirect()
    {
        $response = Http::asForm()->post('https://kauth.kakao.com/oauth/token', [
            'grant_type' => 'authorization_code',
            'client_id' => config('services.kakao.client_id'),
            'redirect_uri' => config('services.kakao.redirect_uri'),
            'code' => Request::input('code'),
        ]);

        Auth::user()->update([
            'kakao_token' => json_decode($response->body(), true)['access_token'],
        ]);

        return Redirect::route('admin.dashboard')->with('success', 'Logged into Kakao');
    }

    public function send()
    {
        $response = Http::withHeaders(['Authorization' => 'Bearer '.Auth::user()->kakao_token])
            ->asForm()
            ->post('https://kapi.kakao.com/v2/api/talk/memo/default/send', [
                'template_object' => json_encode([
                    'object_type' => 'text',
                    'text' => 'order placed. hahah',
                    'link' => null,
            ]),
        ]);

        return Redirect::route('admin.dashboard')->with('success', 'message sent');
    }
}
