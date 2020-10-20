<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Config;
use Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HelperTrait;
use App\User;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers, HelperTrait;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'phone' => $this->validationPhone,
            'email' => 'required|string|email|max:255|unique:users',
            'password' => $this->validationPassword,
            'office_id' => $this->validationOffice,
            'g-recaptcha-response' => 'required|string',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => bcrypt($data['password']),
            'confirm_token' => Str::random(32),
            'office_id' => $data['office_id'],
            'address' => $data['address'],
            'active' => false,
            'send_mail' => 1
        ]);
        return $user;
    }

    public function confirmRegistration($token)
    {
        $user = User::where('confirm_token',$token)->first();
        if ($user) {
            $user->active = 1;
            $user->confirm_token = '';
            $user->save();
            Session::flash('message', trans('auth.register_success'));
            Auth::login($user);
        } else Session::flash('message', trans('auth.register_error'));
        return redirect('/');
    }

    public function sendConfirmMail()
    {
        return view('auth.send_confirm_mail');
    }
}
