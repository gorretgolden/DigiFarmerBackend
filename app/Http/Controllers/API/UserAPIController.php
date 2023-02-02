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
use Session;
use Illuminate\Support\Str;
use Laravel\Sanctum\PersonalAccessToken;
use App\Models\UserType;
use App\Models\OtpPhoneNumber;
use App\Models\UserVerification;
 require_once('../external/AfricasTalkingGateway.php');
use AfricasTalking\SDK\AfricasTalking;
use Tjmugova\Dpo\Facades\Dpo;



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
        $users =User::all();
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

    public function sendOtp(Request $request){

        $input = $request->all();

        $existing_phone_number = User::where('phone',$request->phone)->first();


        if(empty($input['phone'])){

            $response = [
                'success'=>false,
                'message'=> 'Phone number is required'
             ];
             return response()->json($response,400);

        }elseif($existing_phone_number){

            $response = [
                'success'=>false,
                'message'=> 'Phone number already in use'
             ];
             return response()->json($response,409);

        }

        else{

            $otp = rand(1000, 9999);
            $content = "Digi Farmer App verification OTP - ". $otp;
            $new_phone_otp = new OtpPhoneNumber();
            $new_phone_otp->otp = $otp;
            $new_phone_otp->phone = $request->phone;

            $new_phone_otp->save();





            $this->sendSms($content,$request->phone);

            $response = [
                'success'=>true,
                'message'=> 'OTP has been sent to your phone number',

            ];
             return response()->json($response,200);

        }


    }



    public function verifyOtp(Request $request){




         if(empty($request->otp)){

            $response = [
                    'success'=>false,
                    'message'=> 'Please enter your otp'

            ];
            return response()->json($response,403);


        }
        else{

            $otp = OtpPhoneNumber::where('otp',$request->otp)->first();
            $invalid_phone = OtpPhoneNumber::where('otp',$request->phone)->first();

            if(!$invalid_phone){
                $response = [
                    'success'=>false,
                    'message'=> 'Invalid phone number'

             ];
            return response()->json($response,403);

            }else{


                $phone_otp = OtpPhoneNumber::where('otp','=',(int)$request->otp)->where('phone','=',$request->phone)->first();


                $phone_otp_id = collect($phone_otp)->get('id');
                //dd($phone_otp_id);

                //for a valid otp delete it after phone verification
                if($otp){

                    $verified_otp = OtpPhoneNumber::find($phone_otp_id);
                    $verified_otp->delete();

                   $response = [
                    'success'=>true,
                    'message'=> 'Your phone number has been verified successfully '
                   ];
                    return response()->json($response,200);



                }else{
                    $response = [
                        'success'=>false,
                        'message'=> 'Invalid OTP'
                     ];
                     return response()->json($response,403);

                }



            }




        }






    }

    public function userWallet(Request $request){

        $user = User::find(auth()->user()->id);
    //     $user->deposit(200.22);
    //     $balance = $user->balance;
    //     $dpo = new Dpo();
    //     $order = [
    //     'paymentAmount' => "10000",
    //     'paymentCurrency' => "TZS",
    //     'customerFirstName' => "Novath",
    //     'customerLastName' => "Thomas",
    //     'customerAddress' => "Tanzania",
    //     'customerCity' => "Dodoma",
    //     'customerPhone' => "0752771650",
    //     'customerEmail' => "novath@zepson.co.tz",
    //    'companyRef' => "34TESTREFF"
    //    ];
    //     // Now make  payment
    //     $new = $dpo->directPayment($order);

    //     dd($new);
        $token=Dpo::token();
        $token->addService([
          'serviceType' => 1111,
          'serviceDescription' => 'Invoice',
          'serviceDate' => \Carbon\Carbon::now()->format("Y/m/d h:i"),
        ]);
        $response = $token->createToken([
        'paymentAmount' => 200,
        'customerFirstName' => 'Test',
        'companyRef' => '15',
        'paymentCurrency' => 'USD',
        'redirectURL' => 'https://example.com',
        'backURL' => 'https://example.com',
]);
    }


    public function createNewAccount(Request $request)
    {




        $existing_email = User::where('email',$request->email)->first();
        $existing_phone = User::where('phone',$request->phone)->first();
       // dd($existing_phone);

        if($existing_email){

            $response = [
                'success'=>false,
                'message'=> 'User with this email  already exists'
             ];
             return response()->json($response,403);

        }
        elseif($existing_phone){

            $response = [
                'success'=>false,
                'message'=> 'User with this phone number  already exists'
             ];
             return response()->json($response,403);

        }
        else{

            $rules = [
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'email' => 'required|unique:users,id|email',
                'image_url' => 'nullable',
                'phone' => 'required',
                'password' => 'required',
                'email_verified_at' => 'datetime',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $user = new User();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->username = $request->last_name . " " .$request->first_name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->user_type = 'farmer';
            $user->isAdmin = 0;
            $user->is_active = 1;
            $user->image_url = $request->image_url;
            $password = $request->password;
            $user->password = Hash::make($password);
            $user->is_verified_otp = true;
            $user->save();


            //assign a user a role depending on the user type
             if($user->user_type_id == 1){
              $user->assignRole('admin');
             }

             elseif($user->user_type_id == 4){
              $user->assignRole('vendor');
             }
             elseif($user->user_type_id == 3){
              $user->assignRole('buyer');
             }
             else{
              $user->assignRole('farmer');

             }

             $user->save();

             $user_token = Str::random(60);
             $success['token'] = $user->createToken($user_token)->plainTextToken;
             $success['id'] = $user->id;
             $success['username'] = $user->username;
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





    }



    public function login(Request $request)
    {


        $existing_user = User::where('phone',$request->phone)->first();

        if(!$existing_user){

            $response = [
                'success'=>false,
                'message'=> 'Invalid phone number provided'
             ];
             return response()->json($response);
        }
        elseif ($existing_user && !Hash::check($request->password, $existing_user->password)) {
            $response = [
                'success'=>false,
                'message'=> 'Invalid password'
             ];
             return response()->json($response);

            }else{

            $user = Auth::user();
            $user_token = Str::random(60);
            $success['token'] =  $existing_user->createToken($user_token)->plainTextToken;
            $success['id'] =  $existing_user->id;
            $success['email'] =  $existing_user->email;
            $success['phone'] =  $existing_user->phone;
            $success['image_url'] =  $existing_user->image_url;
            $success['first_name'] =  $existing_user->first_name;
            $success['last_name'] =  $existing_user->last_name;
            $success['username'] =  $existing_user->username;
            $success['is_verified'] =  $existing_user->is_verified;

            return $this->sendResponse($success, 'You successfully logged into your account');

        }


    }



    public function checkPhoneNumber(Request $request){


        $user_phone_number = User::where('phone', $request['phone'])->first();
        if($user_phone_number){
          //dd('yes');
          $response = [
            'success'=>true,
            'message'=> 'Phone number verified successfully'
          ];
          return response()->json($response,200);
       }
        else{

          //dd('no');
          $response = [
            'success'=>false,
            'message'=> 'Phone number does not exist'
           ];
          return response()->json($response,404);
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
        $success['username'] = $user->username;
        $success['first_name'] = $user->first_name;
        $success['last_name'] = $user->last_name;
        $success['email'] = $user->email;
        $success['phone'] = $user->phone;
        $success['user_type'] = $user->user_type;
        $success['image_url'] = $user->image_url;
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
    public function update($id,Request $request)
    {

        $user = User::find($id);


        if (empty($user)) {

            $response = [
                'success'=>false,
                'message'=> 'User not found'
               ];
            return response()->json($response,200);

         }else{


            $rules = [
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'email' => 'required|unique:users,id|email',
                'phone' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
            else{

                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->username = $request->last_name." ".$request->first_name;
                $user->email = $request->email;
                $user->phone = $request->phone;

                if(!empty($request->file('image_url'))){
                    $user->image_url = \App\Models\ImageUploader::upload($request->file('image_url'),'users');
                     $user->save();
                 }
                $user->update();



                $response = [
                       'success'=>true,
                        'message'=> 'User Details updated successfully'
                ];
                return response()->json($response,200);
            }




        }










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


    //user upload profile image
    public function updateProfileImage(Request $request){

        $user = User::find(auth()->user()->id);
        dd($request->all());


        $rules = [
            'image_url' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ];
        $request->validate($rules);

        if(!empty($request->file('image_url'))){
            $user->image_url = \App\Models\ImageUploader::upload($request->file('image_url'),'users');
            $user->save();
        }
        $response = [
            'success'=>true,
            'message'=>'Profile image updated successfully'
           ];

           return response()->json($response,200);

    }


    public function userVerifications(Request $request)
   {
       if(!$request->hasFile('image')) {
           return response()->json(['upload_file_not_found'], 400);
        }

       $allowedfileExtension=['pdf','jpg','png'];
       $files = $request->file('image');
       $errors = [];

       foreach ($files as $file) {

        $extension = $file->getClientOriginalExtension();

        $check = in_array($extension,$allowedfileExtension);

        $existing_user = UserVerification::where('user_id',auth()->user()->id)->first();



        if($check) {
            foreach ($request->file('image') as $imagefile) {

                if($existing_user){
                    $response = [
                        'success'=>false,
                        'message'=>'You already uploaded your documents for verification'
                       ];

                    return response()->json($response,200);
                }else{
                    $verification = new UserVerification();
                    $path = $imagefile->store('/images/resource', ['disk' =>   'user-verification-documents']);
                    $verification->image = $path;
                    $verification->user_id = auth()->user()->id;
                    $verification->verified = false;
                    $verification->save();

                }




              }

      }
        else{

            return response()->json(['invalid_file_format'], 422);
        }

        return response()->json(['file_uploaded'], 200);

    }
}

    public function userVerificationsff(Request $request)
    {


        $validator = Validator::make($request->all(),['image.*' => 'image|mimes:jpeg,png,jpg|max:2048']);

        if($validator->fails())
        {
           return response()->json(['message'=>$validator->errors()->all(),'success'=>0]);
        }else{


            $user = User::where('id', auth()->user()->id)->first();


            if($request->hasfile('image'))
            {

                $image = $request->image;
               foreach ($image as $key => $value) {
                  $name = time().$key.'.'.$value->getClientOriginalExtension();
                  $path = public_path('images/user-docs');
                  $value->move($path,$name);

                  $existing_user = UserVerification::where('user_id',auth()->user()->id)->first();
                  if(!$existing_user){

                    $verification = new UserVerification();
                    $verification->user_id = auth()->user()->id;
                    $verification->verified = false;
                    $verification->image = $name ;
                    $verification->save();
                  }else{

                    $response = [
                        'success'=>false,
                        'message'=>'You already uploaded your documents for verification'
                       ];

                       return response()->json($response,200);
                  }
               }



               $response = [
                'success'=>true,
                'message'=> 'Documents uploaded successfully'
               ];

               return response()->json($response,200);


            }


        }
        }


}

