<?php

namespace Illuminate\Foundation\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Office;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Settings;
use Illuminate\Support\Facades\Mail;
use Config;
use Session;

trait RegistersUsers
{
    use RedirectsUsers;

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('auth.register', ['offices' => Office::all()]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        $title = Settings::getSeoTags()['title'];
        Mail::send('auth.emails.registration', ['token' => $user->confirm_token], function($message) use ($title, $user) {
            $message->subject(trans('auth.message_from').$title);
            $message->from(Config::get('app.master_mail'), $title);
            $message->to($user->email);
        });
        Session::flash('message', trans('auth.check_your_mail'));
    }
}
