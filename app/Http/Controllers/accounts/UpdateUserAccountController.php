<?php

namespace App\Http\Controllers\accounts;
use App\Http\Controllers\Controller;
use App\Role;
use App\Traits\TransRolesTrait;
use App\Traits\UploadImageTrait;
use App\Traits\ValidatorTrait;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UpdateUserAccountController extends Controller
{

    use TransRolesTrait,ValidatorTrait,UploadImageTrait;


    /**
     * show user account update form only for super admin user.
     * @param User $user
     *
     * @return [type]
     */
    public function showUserUpdateForm(User $user){
        $userInfo = $user->info;
        $userRole =  trans($user->roles->first()->name);
        $userImage = $user->getImage();
        $rolesTrans = $this->transRolesName();

        return view('user.updateForm',[
            'user'=>$user,
            'userInfo'=>$userInfo,
            'userImage'=>$userImage,
            'userRole'=>$userRole,
            'rolesTrans'=>$rolesTrans,
        ]);
    }

    /**
     * Show user account update form.
     * @return [type]
     */
    public function showProfilUpdateForm(){
        $user = Auth::user();
        $userImage = $user->getImage();

        return view('user.ProfilUpdateForm',[
            'user'=>$user,
            'userImage'=>$userImage,
        ]);
    }

    /**
     * Update user account.
     * @param Request $request
     *
     * @return [type]
     */
    public function updateProfil(Request $request){
        if($user = User::find($request->id)){
            Validator::make($request->all(),[
                'username' => ['required','string','regex:/^[a-zA-Z0-9_@]+$/','max:50'],
                'password' => ['required','string','regex:/^[a-zA-Z0-9éèçà_@\$\!-\&\%\(\)]+$/','min:8'],
                'password_confirm' => ['required','same:password'],
                'image' => ['image','nullable','mimes:jpeg,png','max:8000'],
            ])->validate();

            if($user->username != $request->username && User::where('username',$request->username)->first()){

                return redirect()
                                ->back()
                                    ->withErrors(['username' => trans('validation.unique')])
                                        ->withInput($request->all());
            }

            $user->updateModel([
                'username'=> $request->username,
                'password'=> Hash::make($request->password),
                'password_updated'=> TRUE,
            ]);

            $this->UpdateProfilImage($user,$request->image);

            $user->push();

            return redirect()->route('user.profil',['user'=>$user->id]);
        }
    }
    /**
     * update user account only for super admin user
     * @param Request $request
     *
     * @return [type]
     */
    public function update(Request $request){

        if($user = User::find($request->id)){

            $this->setUsernameValidationRule(['required','string','regex:/^[a-zA-Z0-9_@]+$/','max:50']);
            $this->setPasswordValidationRule([]);
            $this->setPasswordValidationRule([]);

            $this->validator($request->all())->validate();

            if($user->username != $request->username && User::where('username',$request->username)->first()){

                return redirect()
                                ->back()
                                    ->withErrors(['username' => trans('validation.unique')])
                                        ->withInput($request->all());
            }

                $user->updateModel([
                    'username'=> $request->username,
                ]);

                $user->info->updateModel([
                    'firstname'=> ucfirst($request->firstname),
                    'lastname'=> ucfirst($request->lastname),
                    'email'=> $request->email,
                    'telephone'=> $request->telephone,
                    'address'=> $request->address,
                ]);

                $this->updateProfilImage($user,$request->image);


                $userRole = $user->roles->first()->pivot;

                $userRole->role_id = Role::where('name',$request->role)->first()->id;

                $user->push();
        }

        return redirect()->route('user.SuperAdmin.account',['user'=>$user->id]);
    }

    /**
     * update the user profil picture.
     * @param mixed $user
     * @param mixed $image
     *
     * @return [type]
     */
    public function UpdateProfilImage($user,$image){

        if($image){
            $path = 'profil/' . $user->id . '-' . time() . '-profil-image';

            $imageURL = $this->uploadProfilImage($image,$path);

            if($user->image){
                $user->image->image_url = $imageURL;
                $user->save();
            }else{
                $user->image()->create([
                    'image_url'=>$imageURL,
                ]);
            }
            return $user->image;
        }

    }


}
