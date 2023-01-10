<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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

    protected $guard = 'web';

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/?basket=1';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:'.$this->guard)->except('logout');
    }

    /**
     * Login page
     *
     * @return Illuminate\Support\Facades\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Log the user out of the application.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::guard($this->guard)->logout();
        return redirect($this->redirectAfterLogout());
    }

    /**
     * Where to redirect users after logout.
     *
     * @return string
     */
    protected function redirectAfterLogout()
    {
        return route('face.home');
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postLogin(Request $request)
    {
        // validate input data
        $this->validate($request, [
            $this->username() => ['required', 'email', 'max:255'],
            'password' => ['required', 'min:3'],
        ]);
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }
        $credentials = [$this->username() => $request->email, 'password' => $request->password];
        if (Auth::guard($this->guard)->attempt($credentials, $request->has('remember'))) {
			return redirect()->intended($this->redirectTo);
		}
        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);
        // throw exception
        // if ($request->expectsJson()) {
        //     throw ValidationException::withMessages([$this->username() => [trans('auth.failed')]]);
        // }
		return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
			->withErrors([$this->username() => [trans('auth.failed')]]);
	}
}
