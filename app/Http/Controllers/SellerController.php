<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Flash;
use Hash;

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
        $sellers = User::where('user_type','seller')->paginate(10);

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
    public function store(Request $request)
    {

        $seller_rules = [
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
          $user->user_type = "seller";
          $password = $request->input('password');
          $user->password = Hash::make($password);

          //assign a user a role depending on the user type

           $user->assignRole('seller');
           $user->save();

           $user = User::find($user->id);

           $user->image_url = \App\Models\ImageUploader::upload($request->file('image_url'),'users');
           $user->save();

           Flash::success('Seller saved successfully.');


        }

        else{
            Flash::error('User with this email already exists');
        }
        return redirect(route('sellers.index'));

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
        }

        Flash::success('User updated successfully.');

        return redirect(route('sellers.index'));
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
            Flash::error('User not found');

            return redirect(route('sellers.index'));
        }

        $this->userRepository->delete($id);

        Flash::success('User deleted successfully.');

        return redirect(route('sellers.index'));
    }

}
