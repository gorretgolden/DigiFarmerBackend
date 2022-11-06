<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateUserAPIRequest;
use App\Http\Requests\API\UpdateUserAPIRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use Hash;
use Validator;
use Auth;

/**
 * Class UserController
 * @package App\Http\Controllers\API
 */

class UserAPIController extends AppBaseController
{
    /** @var  UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }

    /**
     * Display a listing of the User.
     * GET|HEAD /users
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $users = $this->userRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($users->toArray(), 'Users retrieved successfully');
    }

    /**
     * Store a newly created User in storage.
     * POST /users
     *
     * @param CreateUserAPIRequest $request
     *
     * @return Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),User::$rules);
        if($validator->fails()){
            $response = [
                'success'=>false,
                'message'=>$validator->errors()
            ];
            return response()->json($response,400);

        }

        //existing user
        $existing_user = User::where('email',$request->input('email'))->first();
        if(!$existing_user){
            $user = new User();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->country_id = (int)$request->country_id;
            $user->phone = $request->phone;
            $user->image_url = $request->image_url;
            $user->user_type = $request->user_type;
            $password = $request->password;
            $user->password = Hash::make($password);

            //assign a user a role depending on the user type
             if($user->user_type=='Admin'){
              $user->assignRole('admin');
             }

             elseif($user->user_type=='seller'){
              $user->assignRole('seller');
             }
             elseif($user->user_type=='vendor'){
              $user->assignRole('vendor');
             }
             elseif($user->user_type=='buyer'){
              $user->assignRole('buyer');
             }
             else{
              $user->assignRole('farmer');

             }

             $user->save();

             $success['token'] = $user->createToken('Farming')->plainTextToken;
             $success['first_name'] = $user->first_name;
             $success['last_name'] = $user->last_name;
             $success['email'] = $user->email;
             $success['phone'] = $user->phone;
             $success['user_type'] = $user->user_type;
             $success['image_url'] = $user->image_url;

             $user = User::find($user->id);

             $user->image_url = \App\Models\ImageUploader::upload($request->file('image_url'),'users');
             $user->save();
             $response = [
                'success'=>true,
                'data'=> $success,
                'message'=> 'Account created successfully'
             ];

        return response()->json($response,200);

        }
        else{
            $response = [
                'success'=>false,
                'message'=> 'User already exists'
             ];
             return response()->json($response,403);
        }




    }


    public function login(Request $request){
        if(Auth::attempt(['email'=>$request->email, 'password'=>$request->password] )){
            $user = Auth::user();
            $success['token'] = $user->createToken('Farming')->plainTextToken;
            $success['first_name'] = $user->first_name;
            $success['last_name'] = $user->last_name;
            $success['email'] = $user->email;
            $success['phone'] = $user->phone;
            $success['user_type'] = $user->user_type;
            $success['image_url'] = $user->image_url;

            $response = [
             'success'=>true,
             'data'=> $success,
             'message'=> 'You successfully logged into your account'
            ];
            return response()->json($response,200);
        }
        else{
            $response = [
                'success'=>true,
                'message'=> 'Unauthorized'
               ];
               return response()->json($response,401);
        }

    }
    /**
     * Display the specified User.
     * GET|HEAD /users/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var User $user */
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        return $this->sendResponse($user->toArray(), 'User retrieved successfully');
    }

    /**
     * Update the specified User in storage.
     * PUT/PATCH /users/{id}
     *
     * @param int $id
     * @param UpdateUserAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserAPIRequest $request)
    {
        $input = $request->all();

        /** @var User $user */
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        $user = $this->userRepository->update($input, $id);

        return $this->sendResponse($user->toArray(), 'User updated successfully');
    }

    /**
     * Remove the specified User from storage.
     * DELETE /users/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var User $user */
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        $user->delete();

        return $this->sendSuccess('User deleted successfully');
    }
}
