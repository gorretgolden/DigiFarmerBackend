<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Flash;
use Hash;


class BuyerController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

       // dd('Test');
        $buyers = User::where('user_type','buyer')->paginate(10);

        return view('buyers.index')
            ->with('buyers', $buyers);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('buyers.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $buyer_rules = [
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
        $request->validate($buyer_rules);

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
          $user->user_type = "buyer";
          $password = $request->input('password');
          $user->password = Hash::make($password);

          //assign a user a role depending on the user type

           $user->assignRole('buyer');
           $user->save();

           $user = User::find($user->id);

           $user->image_url = \App\Models\ImageUploader::upload($request->file('image_url'),'users');
           $user->save();

           Flash::success('Buyer saved successfully.');


        }

        else{
            Flash::error('User with this email already exists');
        }
        return redirect(route('buyers.index'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $buyer = User::find($id);

        if (empty($buyer)) {
            Flash::error('Buyer not found');

            return redirect(route('buyers.index'));
        }

        return view('buyers.show')->with('buyer', $buyer);
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

            return redirect(route('buyers.index'));
        }

        return view('buyers.edit')->with('user', $user);
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

            return redirect(route('buyers.index'));
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

        Flash::success('Seller updated successfully.');

        return redirect(route('buyers.index'));
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

            return redirect(route('buyers.index'));
        }

        $user->delete($id);

        Flash::success('User deleted successfully.');

        return redirect(route('buyers.index'));
    }

}
