<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

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
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data,
            ['name' => 'required|max:255', //            'userId' => 'required|max:20|unique:users',
                'email' => 'required|email|max:255|unique:users', 'password' => 'required|min:6|confirmed',]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create(['name' => $data['name'], //            'userId' => $data['userId'],
            'email' => $data['email'], 'password' => bcrypt($data['password']),]);
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  mixed $user
     * @return mixed
     */
    protected function registered(\Illuminate\Http\Request $request, User $user)
    {

        $superusers = User::superuser()->get();
        if ($superusers->isNotEmpty()) {
            Mail::raw("This is a messsage from AACTMAD events. A new user has registered: $user->email",
                function ($message) use ($superusers) {
                    foreach ($superusers as $user)
                        $message->to($user->email)->subject("New user registered");
                });
        }
    }
}
