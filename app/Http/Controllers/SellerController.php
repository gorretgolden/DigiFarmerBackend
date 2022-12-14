<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Flash;
use Hash;
require_once('../external/AfricasTalkingGateway.php');

class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

       // dd('Test');
        $sellers = User::where('user_type_id',4)->paginate(10);

        return view('sellers.index')
            ->with('sellers', $sellers);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('sellers.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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

        $seller_rules = [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|unique:users,id|email',
            'image_url' => 'nullable',
            'country_id' => 'nullable',
            'phone' => 'required|unique:users,id',
            'email_verified_at' => 'datetime',

        ];
        $request->validate($seller_rules);

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
          $user->user_type_id = 4;
          $password = '12345678';
          $user->password = Hash::make($password);

          //assign a user a role depending on the user type

           $user->assignRole('vendor');
           $user->save();

           $user = User::find($user->id);

           $user->image_url = \App\Models\ImageUploader::upload($request->file('image_url'),'users');
           $user->save();

           $content = "Digi Farmer App login password - ". $request->password;
           $this->sendSms($content,$request->phone);

           Flash::success('Vendor saved successfully.');
           return redirect(route('sellers.index'));


        }

        else{
            Flash::error('User with this email already exists');
            return redirect(route('sellers.index'));
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $seller = User::find($id);

        if (empty($seller)) {
            Flash::error('Seller not found');

            return redirect(route('sellers.index'));
        }

        return view('sellers.show')->with('seller', $seller);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('sellers.index'));
        }

        return view('sellers.edit')->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate(User::$rules);
        $user = User::find($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('sellers.index'));
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
            Flash::success('User updated successfully.');

            return redirect(route('sellers.index'));
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (empty($user)) {
            Flash::error('Seller not found');

            return redirect(route('sellers.index'));
        }

        $user->delete($id);

        Flash::success('User deleted successfully.');

        return redirect(route('sellers.index'));
    }

}
