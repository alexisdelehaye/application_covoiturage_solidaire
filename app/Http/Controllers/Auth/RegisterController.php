<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
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
    protected $redirectTo = '/dashboard';

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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
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
        $first_name = $data['first_name'];
        $first_name = explode('-', $first_name);

        if ($first_name[0] == $data['first_name'])
            $first_name = explode(' ', $first_name[0]);

        if ($first_name[0] != $data['first_name']) {
            for($i = 0 ; $i < count($first_name) ; $i++) {
                $first_name[$i] = ucfirst(strtolower($first_name[$i]));
            }
        } else
            $first_name[0] = ucfirst(strtolower($first_name[0]));

        $data['first_name'] = implode("-", $first_name);



        $last_name = $data['last_name'];
        $last_name = explode('-', $last_name);

        if ($last_name[0] == $data['last_name']) {
            $last_name = explode(' ', $last_name[0]);
        }

        if ($last_name[0] != $data['last_name']) {
            for($i = 0 ; $i < count($last_name) ; $i++) {
                $last_name[$i] = ucfirst(strtolower($last_name[$i]));
            }
        } else
            $last_name[0] = ucfirst(strtolower($last_name[0]));

        $data['last_name'] = implode(' ', $last_name);


        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'registered' => 0
        ]);
    }
}
