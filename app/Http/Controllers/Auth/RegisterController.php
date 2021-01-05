<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Role;
use App\Traits\TransRolesTrait;
use App\Traits\ValidatorTrait;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Events\TransactionBeginning;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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

    use RegistersUsers,TransRolesTrait,ValidatorTrait;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = 'dashboard';



    /**
     * show registration form
     * @return [type]
     */
    public function showRegistrationForm()
    {
        $rolesTrans = $this->transRolesName();

        return view('auth.register')->with('rolesTrans',$rolesTrans);
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('role:superAdmin');
    }


    //overwrite user register function
    public function register(Request $request)
    {

        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        //overwrite redirectTo
        $this->redirectTo  = !empty($user->id) ? 'view/user/account/' . $user->id : $this->redirectTo;

        return redirect($this->redirectPath());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        if(Role::where('name','admin')->first()->name = $data['role']){
            $password = 'admin';
        }
        elseif(Role::where('name','seller')->first()->name = $data['role']){
            $password = 'seller';
        }
        elseif(Role::where('name','cashier')->first()->name = $data['role']){
            $password = 'cashier';
        }

        $userRole = Role::where('name',$data['role'])->first();




        return  DB::transaction(function () use ($data,$password,$userRole) {

                //user account
                $user =  User::create([
                    'username' => $data['username'],
                    'password' => Hash::make($password),
                ]);

                //user info
                $user->info()->create([
                    'firstname'=>ucfirst($data['firstname']),
                    'lastname'=>ucfirst($data['lastname']),
                    'email'=>$data['email'],
                    'telephone'=>$data['telephone'],
                    'address'=>$data['address'],
                ]);


                $image = isset($data['image']) ? $data['image'] : null;

                if($image){

                    // path to store the image
                    $path = 'profil/' .  $user->id . '-' . time() . '-profil-image.' . $image->extension();

                    //upload the image
                    $imageURL = $user->uploadProfilImage($image,$path);

                    //save the image url
                    $user->image()->create([
                        'image_url'=> $imageURL,
                    ]);
                }

                //attach user role
                $user->roles()->attach($userRole);

                return $user;
            });



    }
}
