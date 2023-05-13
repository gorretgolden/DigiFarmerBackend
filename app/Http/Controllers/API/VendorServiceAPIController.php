<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VendorService;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\Category;
use App\Models\Address;
use App\Models\User;
use Illuminate\Support\Facades\File;
use App\Models\District;
use App\Models\LoanPlan;
use App\Models\SubCategory;
use Notification;
use App\Notifications\NewVendorServiceNotification;


class VendorServiceAPIController extends Controller
{


    /**
     * Display a listing of the TrainingVendorService.
     * GET|HEAD /trainingVendorServices
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $trainingVendorServices =  TrainingVendorService::where('is_verified',1)->latest()->get();
        return $this->sendResponse($trainingVendorServices->toArray(), 'Training Vendor Services retrieved successfully');
    }

    //create a vendor service
    public function store(Request $request)
    {

      //validate request
       $rules = [
        'name' => 'required|string|max:200|unique:vendor_services',
        'image' => 'required|image',
        'image.*' => 'image|mimes:png,jpg,jpeg|max:2048',
        'description' => 'required|string|min:20|max:255',
        'sub_category_id' => 'required|integer',
        'address_id'=>'required|integer'
       ];
       $request->validate($rules);

        $sub_category = SubCategory::find($request->sub_category_id);
        $category = $sub_category->category->name;
     //   dd($category);
        $location = Address::where('id',$request->address_id)->first();

        if(empty($location)){

        $response = [
            'success'=>false,
            'message'=> 'Address not found'
         ];

        return response()->json($response,404);

        }


        $vendor_service = new VendorService();

        //required fields
        $vendor_service->name = ucfirst(strtolower($request->name));
        $vendor_service->is_verified = false;
        $vendor_service->price_unit = 'UGX';
        if(!empty($request->file('image'))){
            $vendor_service->image = \App\Models\ImageUploader::upload($request->file('image'),'vendor_services');
        }

        $vendor_service->user_id = auth()->user()->id;
        $vendor_service->location = $location->district_name;
        $vendor_service->description = $request->description;
        $vendor_service->sub_category_id = $request->sub_category_id;




        //animal feeds
        if($category == 'Animal Feeds'){
            $request->validate([

                'price'=>'required|integer',
                'weight'=>'required|integer',
                'weight_unit'=>'required|string',
                'stock_amount' =>'required|integer',
                'animal_categories'=>'required|array'
            ]);
           // dd($request->animal_categories);
            $vendor_service->price = $request->price;
            $vendor_service->stock_amount = $request->stock_amount;
            $vendor_service->weight = $request->weight;
            $vendor_service->weight_unit = $request->weight_unit;
            $vendor_service->status = 'on-sale';
            $vendor_service->save();
            $vendor_service->animal_categories()->attach($request->animal_categories);
        }


        //trainings
        if($category == 'Farmer Trainings'){
            $request->validate([
                'charge' => 'required|integer',
                'period' => 'nullable|integer',
                'access' => 'required|string',
                'starting_date' => 'required|date',
                'ending_date' => 'required|after_or_equal:starting_date',
                'starting_time' => 'required|before:ending_time',
                'ending_time' => 'required|after:starting_time',

            ]);

            //access
            if($request->access == 'online'){
                $request->validate([
                    'zoom_details' => 'required|string',

                ]);
                $vendor_service->zoom_details = $request->zoom_details;

            }
            $vendor_service->charge = $request->charge;
            $vendor_service->access = $request->access;
            $vendor_service->starting_date = $request->starting_date;
            $vendor_service->ending_date = $request->ending_date;
            $vendor_service->starting_time = $request->starting_time;
            $vendor_service->ending_time = $request->ending_time;
            $vendor_service->ending_time = $request->ending_time;
            $vendor_service->status = 'open';
            $vendor_service->save();
        }

        //farm equipments
        if($category == 'Farm Equipments'){
            $request->validate([

                'price'=>'required|integer',
                'stock_amount' =>'required|integer'

            ]);


            $vendor_service->price = $request->price;
            $vendor_service->stock_amount = $request->stock_amount;
            $vendor_service->status = 'on-sale';
            $vendor_service->save();
        }


        //rent
        if($category == 'Rent'){
            $request->validate([

                'charge'=>'required|integer',
                'charge_frequency'=>'required|string',
                'stock_amount' =>'required|integer'

            ]);


            $vendor_service->charge = $request->charge;
            $vendor_service->charge_frequency = $request->charge_frequency;
            $vendor_service->stock_amount = $request->stock_amount;
            $vendor_service->status = 'available-for-rent';
            $vendor_service->save();
        }


        //insurance
        if($category == 'Insurance'){
            $request->validate([
                'terms'=>'required|string|min:10'

            ]);
            $vendor_service->terms = $request->terms;
            $vendor_service->save();
        }

        //agronomist
          if($category == 'Agronomists'){
            $request->validate([
                'expertise'=>'required|string|min:10',
                'charge' => 'required|integer',
                'charge_unit'=>'required|string',
                'access' => 'required|string',
                'crops'=>'required|array'

            ]);

              //access
              if($request->access == 'online'){
                $request->validate([
                    'zoom_details' => 'required|string',

                ]);
                $vendor_service->zoom_details = $request->zoom_details;

            }
            $vendor_service->expertise = $request->expertise;
            $vendor_service->charge = $request->charge;
            $vendor_service->charge_unit = $request->charge_unit;
            $vendor_service->access = $request->access;
            $vendor_service->save();
            $vendor_service->crops()->attach($request->crops);
        }

        //vet
        if($category == 'Veterinary'){
            $request->validate([
                'expertise'=>'required|string|min:10',
                'charge' => 'required|integer',
                'charge_unit'=>'required|string',
                'access' => 'required|string'

            ]);

              //access
              if($request->access == 'online'){
                $request->validate([
                    'zoom_details' => 'required|string',

                ]);
                $vendor_service->zoom_details = $request->zoom_details;

            }
            $vendor_service->expertise = $request->expertise;
            $vendor_service->charge = $request->charge;
            $vendor_service->charge_unit = $request->charge_unit;
            $vendor_service->access = $request->access;
            $vendor_service->save();
        }


        //finance
        if($category == 'Finance'){
            $request->validate([

                'principal'=>'required|integer',
                'interest_rate' =>'required|integer',
                'document_type'=>'required|string',
                'loan_plan_id' =>'integer|required',
                'terms'=>'required|string|min:10'

            ]);


            $vendor_service->principal = $request->principal;
            $vendor_service->interest_rate = $request->interest_rate;
            $vendor_service->interest_rate_unit = '%';
            $vendor_service->status = 'available';
            $vendor_service->loan_plan_id = $request->loan_plan_id;
            $vendor_service->loan_pay_back = $request->loan_pay_back;
            $vendor_service->terms = $request->terms;
            $vendor_service->document_type = $request->document_type;

            //percentage simple interest
             $percentage_interest_rate = ($request->interest_rate / 100);


             //loan  duration period in months
             $loan_plan = LoanPlan::find($request->loan_plan_id);
             $loan_plan_duration =$loan_plan->value;
             $time = ($loan_plan_duration/12);
             // dd($request->principal,$percentage_interest_rate,$time);


             $calculated_year_simple_interest = (int)($request->principal * $percentage_interest_rate * $time);
             $total_pay_amount = $calculated_year_simple_interest + $request->principal;
             $vendor_service->simple_interest = $calculated_year_simple_interest;
             $vendor_service->total_amount_paid_back = $total_pay_amount;
             $vendor_service->save();

             if($request->loan_pay_back == "Daily"){

                #a month has 30.417 days
                $total_days = $loan_plan_duration * 30.417 ;
                $daily_pay = ($total_pay_amount / $total_days);
                $vendor_service->payment_frequency_pay = $daily_pay;
                $vendor_service->save();


            }elseif($request->loan_pay_back  == "Weekly"){
                #a month has 4 weeks
                $total_weeks = $loan_plan_duration * 4;
                $weekly_pay = ($total_pay_amount / $total_weeks);
                $vendor_service->payment_frequency_pay = $weekly_pay;
                $vendor_service->save();


            }elseif($request->loan_pay_back  == "Monthly"){


                $monthly_payment = ($total_pay_amount / $loan_plan_duration) ;
                $vendor_service->payment_frequency_pay = $monthly_payment;
                $vendor_service->save();


            }


        }


        $vendor_service->save();

        //set user as a vendor
        $user = User::find(auth()->user()->id);
        if(!$user->is_vendor ==1){
           $user->is_vendor =1;
           $user->save();
        }

        $admin = User::where('user_type','admin')->first();
        $admin->notify(new NewVendorServiceNotification($vendor_service));

        $response = [
            'success'=>true,
            'data'=> $vendor_service,
            'message'=> 'Vendor service  created successfully waiting for verifications'
         ];

        return response()->json($response,200);


    }


    //get by id
    public function show($id)
    {
        /** @var VendorService $rentVendorService */
        $vendor_service = VendorService::find($id);


        if (empty($vendor_service)) {
            $response = [
                'success'=>false,
                'message'=> 'Vendor Service not found'
             ];

             return response()->json($response,200);

        }else{

            // $success['id'] = $vendor_service->id;
            // $success['name'] = $vendor_service->name;
            // $success['location'] = $vendor_service->location;

            // //charge and price
            // if(empty($vendor_service->price)){
            //     $success['charge'] = $vendor_service->charge;
            //     $success['charge_unit'] = $vendor_service->charge_unit;
            //     $success['charge_frequency'] = $vendor_service->charge_frequency;
            // }else{
            //     $success['price'] = $vendor_service->price;
            //     $success['price_unit'] = $vendor_service->price_unit;
            // }


            // //weight
            // if(!empty($vendor_service->weight) && !empty($vendor_service->weight_unit)){
            //     $success['weight'] = $vendor_service->weight;
            //     $success['weight_unit'] = $vendor_service->weight_unit;

            // }

            // //stock
            // if(!empty($vendor_service->stock_unit)){
            //     $success['stock_unit'] = $vendor_service->stock_unit;
            // }

            // //expertise
            // if(!empty($vendor_service->expertise)){
            //     $success['expertise'] = $vendor_service->expertise;
            // }

            // //access
            // if(!empty($vendor_service->access)){
            //     $success['access'] = $vendor_service->access;
            // }


            // //zoom_details
            // if(!empty($vendor_service->zoom_details)){
            //     $success['zoom_details'] = $vendor_service->zoom_details;
            // }

            // if(!empty($vendor_service->starting_date) && !empty($vendor_service->starting_time) && !empty($vendor_service->ending_date) && !empty($vendor_service->ending_time)){
                // $success['starting_date'] = $vendor_service->starting_date;
                // $success['starting_time'] = $vendor_service->starting_time;
                // $success['ending_date'] = $vendor_service->ending_date;
                // $success['ending_time'] = $vendor_service->ending_time;
            // }

            // //finance
            // if(!empty($vendor_service->principal) && !empty($vendor_service->interest_rate) && !empty($vendor_service->interest_rate_unit) && !empty($vendor_service->payment_frequency_pay) && !empty($vendor_service->payment_frequency_pay)){
            //     $success['principal'] = $vendor_service->principal;
            //     $success['interest_rate'] = $vendor_service->interest_rate;
            //     $success['interest_rate_unit'] = $vendor_service->interest_rate_unit;
            //     $success['payment_frequency_pay'] = $vendor_service->payment_frequency_pay;
            //     $success['simple_interest'] = $vendor_service->simple_interest;
            //     $success['total_amount_paid_back'] = $vendor_service->total_amount_paid_back;
            //     $success['document_type'] = $vendor_service->document_type;
            //     $success['terms'] = $vendor_service->terms;
            //     $success['loan_pay_back'] = $vendor_service->loan_pay_back;



            // }



  $success['id'] = $vendor_service->id;
            $success['name'] = $vendor_service->name;
            $success['location'] = $vendor_service->location;

            //charge and price

                $success['charge'] = $vendor_service->charge;
                $success['charge_unit'] = $vendor_service->charge_unit;
                $success['charge_frequency'] = $vendor_service->charge_frequency;

                $success['price'] = $vendor_service->price;
                $success['price_unit'] = $vendor_service->price_unit;



            //weight

                $success['weight'] = $vendor_service->weight;
                $success['weight_unit'] = $vendor_service->weight_unit;



            //stock

             $success['stock_unit'] = $vendor_service->stock_unit;


            //expertise

                $success['expertise'] = $vendor_service->expertise;


            //access

                $success['access'] = $vendor_service->access;



            //zoom_details

                $success['zoom_details'] = $vendor_service->zoom_details;



                $success['starting_date'] = $vendor_service->starting_date;
                $success['starting_time'] = $vendor_service->starting_time;
                $success['ending_date'] = $vendor_service->ending_date;
                $success['ending_time'] = $vendor_service->ending_time;


        $success['starting_date'] = $vendor_service->starting_date;
        $success['starting_time'] = $vendor_service->starting_time;
        $success['ending_date'] = $vendor_service->ending_date;
        $success['ending_time'] = $vendor_service->ending_time;
          $success['principal'] = $vendor_service->principal;
          $success['interest_rate'] = $vendor_service->interest_rate;
          $success['interest_rate_unit'] = $vendor_service->interest_rate_unit;
          $success['payment_frequency_pay'] = $vendor_service->payment_frequency_pay;
          $success['simple_interest'] = $vendor_service->simple_interest;
          $success['total_amount_paid_back'] = $vendor_service->total_amount_paid_back;
          $success['document_type'] = $vendor_service->document_type;
          $success['terms'] = $vendor_service->terms;
          $success['loan_pay_back'] = $vendor_service->loan_pay_back;

            $success['status'] = $vendor_service->status;
            $success['description'] = $vendor_service->description;
            $success['vendor'] = $vendor_service->vendor->username;
            $success['category'] = $vendor_service->sub_category->category->name;
            $success['sub_category'] = $vendor_service->sub_category->name;
            $success['location'] = $vendor_service->location;
            $success['is_verified'] = $vendor_service->is_verified;
            $success['created_at'] = $vendor_service->created_at->format('d/m/Y');
            $success['time_since'] = $vendor_service->created_at->diffForHumans();
            $success['image']= $vendor_service->image;

        }
        $response = [
            'success'=>true,
            'data'=> $success,
            'message'=> 'Vendor Service retrieved successfully'
         ];

         return response()->json($response,200);


    }

      //training vendor services for a single vendor



}




