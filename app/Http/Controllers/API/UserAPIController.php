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
use Illuminate\Support\Str;
use Laravel\Sanctum\PersonalAccessToken;
require_once('../external/AfricasTalkingGateway.php');


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
    /**
 * @OA\Info(
 *    title="APIs For Thrift Store",
 *    version="1.0.0",
 * ),
 *   @OA\SecurityScheme(
 *       securityScheme="bearerAuth",
 *       in="header",
 *       name="bearerAuth",
 *       type="http",
 *       scheme="bearer",
 *       bearerFormat="JWT",
 *    ),
 */
    public function index(Request $request)
    {
        $users =User::with(['district','country'])->get();
        $response = [
            'success'=>true,
            'data'=> $users,
            'message'=> 'Users retrieved successfully'
         ];
         return response()->json($response,200);
    }

    /**
     * Store a newly created User in storage.
     * POST /users
     *
     * @param CreateUserAPIRequest $request
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
    public function createUserAccount(Request $request)
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
        $existing_user = User::where('email',$request->input('email'))->orWhere('phone',$request->phone)->first();
        if(!$existing_user){
            $user = new User();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->country_id = (int)$request->country_id;
            $user->district_id = (int)$request->district_id;
            $user->phone = $request->phone;
            $user->isAdmin = 0;
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
             $user_token = Str::random(60);
             $success['token'] = $user->createToken($user_token)->plainTextToken;
             $success['id'] = $user->id;
             $success['first_name'] = $user->first_name;
             $success['last_name'] = $user->last_name;
             $success['email'] = $user->email;
             $success['phone'] = $user->phone;
             $success['user_type'] = $user->user_type;
             $success['image_url'] = $user->image_url;
             $success['country'] = $user->country->name;
             $success['district'] = $user->district->name;

             $user = User::find($user->id);

             $user->image_url = \App\Models\ImageUploader::upload($request->file('image_url'),'users');
             $user->save();

             $opt = rand(1000, 9999);
             $user->otp = $opt;
             $user->is_verified_otp = false;
             $user->save();

             $content = "Digi Farmer App verification OTP - ". $opt ;
             $this->sendSms($content,$request->phone);
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
                'message'=> 'User with this email or phone number already exists'
             ];
             return response()->json($response,403);
        }




    }


    public function verifyUserOtp(Request $request){

        $check_user_otp = User::where('otp',$request->otp)->first();

        if($check_user_otp){
          $check_user_otp->is_verified_otp = true;
          $check_user_otp->save();
          $response = [
            'success'=>true,
            'message'=> 'Phone number verified successfully'
         ];
         return response()->json($response,200);

        }
        else{

          $response = [
            'success'=>false,
            'message'=> 'Invalid Otp'
         ];
         return response()->json($response);
        }



    }


    public function login(Request $request){

         if (!Auth::attempt($request->only('phone', 'password'))) {
             return response()->json([ 'message' => 'Invalid login details' ], 401);
           }

         $user = User::where('phone', $request['phone'])->firstOrFail();
         $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['access_token' => $token,'token_type' => 'Bearer Token',    ]);
    }



    public function checkPhoneNumber(Request $request){



       if($user_phone_number){
        $response = [
            'success'=>true,
            'message'=> 'Phone number verified successfully'
         ];
         return response()->json($response,200);
       }
       else{

        $response = [
            'success'=>false,
            'message'=> 'Phone number does not exist'
         ];
         return response()->json($response);
       }

   }


   public function checkPassword(Request $request,$phone){


    $user_password = User::where('phone',$phone)->first();
    if(Hash::check($request->password, $user->password)) {
        return response()->json(['status'=>'true','message'=>'User password exists']);
    } else {
        return response()->json(['status'=>'false', 'message'=>'Password doesnt exist']);
    }


}


    public function loggedInUser(Request $request){
         return $request->user();
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
        $user = User::find($id);
        $success['first_name'] = $user->first_name;
        $success['last_name'] = $user->last_name;
        $success['email'] = $user->email;
        $success['phone'] = $user->phone;
        $success['user_type'] = $user->user_type;
        $success['image_url'] = $user->image_url;
        $success['country'] = $user->country->name;
        $success['district'] = $user->district->name;
        $success['email_verified_at'] = $user->email_verified_at;
        $success['created_at'] = $user->created_at;


        if (empty($user)) {
            return $this->sendError('User not found');
        }
        $response = [
            'success'=>true,
            'data'=> $success,
            'message'=> 'User retrieved successfully'
           ];

        return response()->json($response,200);
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
    public function update($id,UpdateUserAPIRequest $request)
    {
        $user = User::find($id);

        if (empty($user)) {
            $response = [
                'success'=>false,
                'message'=> 'User does not exist'
               ];
               return response()->json($response,200);

        }

        if( $user){

            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->country_id = (int)$request->country_id;
            $user->phone = $request->phone;
            $user->image_url = $request->image_url;
            $password = $request->password;
            $user->password = Hash::make($password);

            if(!empty($request->file('image_url'))){
                $user->image_url = \App\Models\ImageUploader::upload($request->file('image_url'),'users');
            }
            $user->save();

            $response = [
                'success'=>true,
                'data'=> $success,
                'message'=> 'User account created successfully'
             ];

        return response()->json($response,200);

        }
        else{
            $response = [
                'success'=>false,
                'message'=> 'User with this email already exists'
             ];
             return response()->json($response,403);
        }



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

    //user logout
    public function userLogOut(Request $request){
        {


            // Get bearer token from the request
           $accessToken = $request->bearerToken();

           // Get access token from database
           $token = PersonalAccessToken::findToken($accessToken);

           // Revoke token
           $token->delete();

            $response = [
                'success'=>true,
                'message'=> 'You logged out of your account'
             ];

        return response()->json($response,200);
        }
    }
}
