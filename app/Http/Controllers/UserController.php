<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Repositories\UserRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use App\Models\User;
use Hash;

class UserController extends AppBaseController
{
    /** @var UserRepository $userRepository*/
    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }

    /**
     * Display a listing of the User.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $farmers = User::where('user_type','farmer')->paginate(8);

        return view('users.index')
            ->with('farmers', $farmers);
    }




    public function buyers(Request $request)
    {
        $buyers = User::where('user_type','buyer')->paginate(10);

        return view('users.buyers')->with('buyers', $buyers);
    }




    /**
     * Show the form for creating a new User.
     *
     * @return Response
     */
    public function create()
    {
        return view('users.create');
    }

    public function createBuyers()
    {
        return view('users.create-buyers');
    }

    /**
     * Store a newly created User in storage.
     *
     * @param CreateUserRequest $request
     *
     * @return Response
     */





    public function store(Request $request)
    {

        $farmer_rules = [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|unique:users,id|email',
            'image_url' => 'nullable',
            'country_id' => 'nullable',
            'phone' => 'required|unique:users,id',
            'password' => 'required',
            'email_verified_at' => 'datetime',
            'confirm-password'=>'required|same:password'
        ];
        $request->validate($farmer_rules);

        $existing_user = User::where('email',$request->input('email'))->first();
        //if not existing user
        if(!$existing_user){

          $user = new User();
          $user->first_name = $request->input('first_name');
          $user->last_name = $request->input('last_name');
          $user->username = $request->last_name ." " . $request->first_name;
          $user->email = $request->input('email');
          $user->country_id = $request->input('country_id');
          $user->phone = $request->input('phone');
          $user->image_url = $request->input('image_url');
          $user->user_type = "farmer";
          $password = $request->input('password');
          $user->password = Hash::make($password);

          //assign a user a role depending on the user type

           $user->assignRole('farmer');

           $user->save();

           $user = User::find($user->id);

           $user->image_url = \App\Models\ImageUploader::upload($request->file('image_url'),'users');
           $user->save();

           Flash::success('User saved successfully.');


        }

        else{
            Flash::error('User already exists');
        }
        return redirect(route('farmers.index'));


    }

    /**
     * Display the specified User.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('farmers.index'));
        }

        return view('users.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified User.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('farmers.index'));
        }

        return view('users.edit')->with('user', $user);
    }

    /**
     * Update the specified User in storage.
     *
     * @param int $id
     * @param UpdateUserRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {

        $request->validate(User::$rules);
        $user = User::find($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('farmers.index'));
        }


        if($user){

            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->country_id = $request->country_id;
            $user->phone = $request->phone;
            $user->user_type = $request->user_type;
            $user->image_url = $request->image_url;
            $password = $request->password;
            $user->password = Hash::make($password);

            if(!empty($request->file('image_url'))){
                $user->image_url = \App\Models\ImageUploader::upload($request->file('image_url'),'users');
            }
            $user->save();
        }

        Flash::success('User updated successfully.');

        return redirect(route('farmers.index'));
    }

    /**
     * Remove the specified User from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('farmers.index'));
        }

        $this->userRepository->delete($id);

        Flash::success('User deleted successfully.');

        return redirect(route('farmers.index'));
    }
}
