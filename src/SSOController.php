<?php

namespace Dudyali\SsoBappenasLib;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use InvalidArgumentException;

class SSOController extends Controller
{
    public function getLogin(Request $request)
    {
        $request->session()->put('state', $state = Str::random(40));
        $query = http_build_query([
            'redirect_uri' => config('auth.callback'),
            'response_type' => 'code',
            'scope' => config('auth.scopes'),
            'state' => $state,
            'prompt' => true,
        ]);

        return redirect(config('sso_config.sso_host').'/request?'.$query);

    }

    public function getCallback(Request $request)
    {
        $state = $request->session()->pull('state');

        throw_unless(strlen($state) > 0 && $state == $request->state, InvalidArgumentException::class);

        $response = Http::asForm()->post(
            config('sso_config.sso_host').'/api/token-user',
            [
                'state' => $state,
                'grant_type' => 'authorization_code',
                'client_id' => config('auth.client_id'),
                'client_secret' => config('auth.client_secret'),
                'redirect_uri' => config('auth.callback'),
                'code' => $request->code,
            ]
        );

        $request->session()->put($response->json());

        return redirect(route('sso.connect'));
    }

    public function connectUser(Request $request)
    {
        $access_token = $request->session()->get('access_token');
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$access_token,
        ])->get(config('sso_config.sso_host').'/api/user');
        $userArray = $response->json();

        try {
            $email = $userArray['email'];
        } catch (\Throwable $th) {
            return redirect('login')->withError('Failed to get login information! Try again.');
        }

        $user = User::where('email', $email)->first();
        if (! $user) {
            $user = new User;
            $user->name = $userArray['name'];
            $user->email = $userArray['email'];
            $user->save();
        }

        Auth::login($user);

        return redirect('/');
    }

    public function getCallbackSession(Request $request)
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$request->token,
        ])
            ->get(config('sso_config.sso_host').'/api/verify-token');

        if ($response->status() == 200) {
            $cekUser = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '.$request->token,
            ])->get(config('sso_config.sso_host').'/api/cek-user');

            $user = json_decode($cekUser);

            $nip = isset($user->nip) ? $user->nip : '';
            $email = $user->email;

            $getUser = User::where('email', $email)->first();
            if ($getUser) {
                Session::put('access_token', $request->token);
                Auth::login($getUser);

                return redirect('/');
            } else {
                if (Schema::hasColumn('users', 'NIP')) {

                    $getUserNIP = User::where('nip', $nip)->first();
                    if ($getUserNIP) {
                        Session::put('access_token', $request->token);
                        Auth::login($getUserNIP);

                        return redirect('/');
                    } else {
                        return response()->json(['error' => 'Unauthorized Access'], 404);
                    }
                } else {
                    Session::flash('fail', 'Email Anda Tidak Terdaftar pada Aplikasi Ini');

                    return redirect('logout-user');
                }
            }
        } else {
            return response()->json(['error' => 'Unauthorized.'], 401);
        }
    }

    public function logout(Request $request)
    {
        if (session()->get('access_token') != '') {
            SSOHelper::logoutFromSSO();
            Auth::logout();

            $urlSso = config('sso_config.sso_host');

            return redirect($urlSso.'/logout-api');
        }

        Auth::logout();

        return redirect('login')->with('success', 'Anda Berhasil Logout');
    }
}
