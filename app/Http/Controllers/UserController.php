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
use App\Mail\SendUserPasswordMail;
use Illuminate\Support\Facades\Mail;
use App\Models\UserUserType;
require_once('../external/AfricasTalkingGateway.php');
use URL;
use Illuminate\Support\Facades\File;
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
        $farmers = User::where('user_type',"farmer")->latest()->paginate(8);

        return view('users.index')
            ->with('farmers', $farmers);
    }




    public function buyers(Request $request)
    {
        $buyers = User::where('user_type_id',3)->paginate(10);

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




    public function sendSms($content,$tell){



        $rand = "3242";

        $message    = $content;
        $apikey = "32e6988167f57dc60e425bb7ff9808f6fa322d017c2341be040c6bf9f881bb3c";
        $username='medaasi';

        $gateway    = new \AfricasTalkingGateway($username, $apikey);
       try
       {
         $recipients='+'.$tell;
         //$recipients='+256779815657';
         $results = $gateway->sendMessage($recipients, $message);

       }
       catch ( \AfricasTalkingGatewayException $e )
       {
        echo "Encountered an error while sending: ".$e->getMessage();
      }


    }

    public function store(Request $request)
    {

        $file = URL::asset('storage/users/user.png');
        //dd($file);

        $farmer_rules = [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|unique:users,id|email',
            'image_url' => 'nullable',
            'country_id' => 'nullable',
            'phone' => 'required|unique:users,id|min:9',
            'email_verified_at' => 'datetime',

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
          $user->phone = $request->input('phone');
          $user->is_active = $request->input('is_active');
          $user->image_url = $request->image_url;
          $user->user_type= "farmer";
          $password = "12345678";
          $user->password = Hash::make($password);


          //assign a user a role depending on the user type

           $user->assignRole('farmer');

           $user->save();

           $user = User::find($user->id);
           if(!empty($request->file('image_url'))){
            $user->image_url = \App\Models\ImageUploader::upload($request->file('image_url'),'users');
          }
           $user->save();
           $content = "Digi Farmer App login password - ". $request->password;
           $this->sendSms($content,$request->phone);

           $data = [
            'password' => $password,
            'subject' => "user auto generated password"

          ];
          Mail::to($user->email)->send(new SendUserPasswordMail($data));


           Flash::success('Farmer saved successfully.');


           return redirect(route('farmers.index'));


        }

        else{
            Flash::error('User already exists');
            return redirect(route('farmers.index'));

        }


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

        $user = User::find($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('farmers.index'));
        }
        $user->fill($request->all());


        $user->username = $request->last_name." ".$request->first_name;
        $user->last_name= $request->last_name;
        $user->first_name= $request->first_name;
        $user->email = $request->email ;
        $user->phone = $request->phone;
        $user->is_active = $request->is_active;
        $user->save();

        if(!empty($request->file('image_url'))){
            File::delete('storage/users/'.$user->image_url);
            $user->image_url = \App\Models\ImageUploader::upload($request->file('image_url'),'users');
            $user->save();
        }else{

            $user->image_url= $request->image_url;
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
