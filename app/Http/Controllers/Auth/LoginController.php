<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
// AuthenticatesUsersを呼び出しこのクラスで使用可能にする

use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected $maxAttempts = 2; //3回ログイン情報ミスると1分ログインできなくする
    //vendor下ThrottlesLogins.php内のmaxAttemptsメソッドをオーバーライド

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/todo'; // ログイン後/todoに飛ばす

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // ログアウト後にログイン画面に遷移させるメソッド
    protected function loggedOut(Request $request)
    {
        return redirect('/login');
    }
}
