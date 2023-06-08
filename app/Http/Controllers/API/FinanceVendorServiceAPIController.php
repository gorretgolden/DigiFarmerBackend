<?php


namespace App\Http\Controllers\API;



y;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Models\LoanPlan;
use App\Models\LoanPayBack;
use App\Models\Address;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\District;
use DB;

require_once('vendor/autoload.php');
/**
 * Class FinanceVendorServiceController
 * @package App\Http\Controllers\API
 */


class FinanceVendorServiceAPIController extends Controller
{



    public function index(Request $request)
    {
        $financeVendorService = DB::table('vendor_services')
        ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
        ->join('categories','categories.id','=','sub_categories.category_id')
        ->where('categories.name','Finance')
        ->where('is_verified',1)
        ->where('status','available')
        ->orderBy('vendor_services.id','ASC')
        ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
        ->get();


        $response = [
            'success'=>true,
            'data'=> $financeVendorService,
            'message'=> 'Finance VendorService retrieved successfully'
         ];
         return response()->json($response,200);
    }



    //finance sub categories
    public function finance_sub_categories(Request $request){

        $finance_sub_categories = DB::table('categories')
            ->join('sub_categories','categories.id','=','sub_categories.category_id')
            ->where('categories.name','Finance')
            ->where('sub_categories.is_active',1)
            ->orderBy('sub_categories.name','ASC')
            ->select('sub_categories.id','sub_categories.name',DB::raw("CONCAT('storage/sub_categories/', sub_categories.image) AS image"),'categories.name as category')
            ->get();

            if ($finance_sub_categories->count() == 0) {
                $response = [
                    'success'=>false,
                    'message'=> 'No sub categories under farmer finances'
                 ];

                 return response()->json($response,404);

            }
            else{


                $response = [
                    'success'=>true,
                    'data'=> [
                        'total-finance-sub-categories' =>count($finance_sub_categories),
                        'finance-sub-categories'=>$finance_sub_categories
                    ],
                    'message'=> 'Farmer finance sub categories retrieved successfully'
                 ];

                 return response()->json($response,200);
            }


    }


    //finance services under a sub category
       public function subcategory_finance_services(Request $request,$id)
{
    $sub_category = SubCategory::find($id);



    if (empty($sub_category)) {
        $response = [
            'success'=>false,
            'message'=> 'Sub category not found'
         ];

         return response()->json($response,404);

    }

    $finance_services  = DB::table('vendor_services')
                          ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
                          ->join('categories','categories.id','=','sub_categories.category_id')
                          ->where('categories.name','Finance')
                          ->where('vendor_services.status','on-sale')->where('is_verified',1)
                          ->where('vendor_services.sub_category_id',$id)
                          ->orderBy('vendor_services.id','DESC')
                          ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
                          ->paginate(10);




    if ($finance_services->count() == 0) {
        $response = [
            'success'=>true,
            'message'=> 'No  finance services have been posted under '.$sub_category->name
         ];

         return response()->json($response,404);

    }
    else{


        $response = [
            'success'=>true,
            'data'=> [
                'total-finance-services' =>$finance_services->count(),
                'finance-services'=>$finance_services
            ],
            'message'=> 'Finance services under '.$sub_category->name.' retrieved successfully'
         ];

         return response()->json($response,200);
    }




}


     public function random_strings($length_of_string)
     {

         // String of all alphanumeric character
         $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

         return substr(str_shuffle($str_result),0, $length_of_string);
     }


//filter by price range
public function principal_range(Request $request){



    if(empty($request->min_principal) || empty($request->max_principal)){

     $response = [
         'success'=>false,
         'message'=> 'Principal range required'
      ];

      return response()->json($response,400);

    }else{


     $finance_services = DB::table('vendor_services')
     ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
     ->join('categories','categories.id','=','sub_categories.category_id')
     ->where('categories.name','Finance')
     ->where('is_verified',1)
     ->where('status','available')
     ->whereBetween('principal', [$request->min_principal, $request->max_principal])
     ->orderBy('vendor_services.id','ASC')
     ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
     ->get();



     if(count($finance_services)==0){
        $response = [
            'success'=>false,
            'message'=> "No finance services found between"." "."UGX ".$request->min_principal ." and "."UGX ". $request->max_principal
         ];

         return response()->json($response,404);

     }else{

        $response = [
            'success'=>true,
            'data'=>[
                'total-results'=>count($finance_services),
                'finance-services'=>$finance_services
            ],
            'message'=> "finance services between "."UGX ".$request->min_charge ." and "."UGX ". $request->max_charge." "."retrieved successfully"
         ];

         return response()->json($response,200);
     }


    }




 }

 //filter products by location
 public function location_finance_services(Request $request){

     if(empty($request->district_id)){
         $response = [
             'success'=>false,
             'message'=> 'Please select a district'
          ];

          return response()->json($response,400);

     }

     $district= District::find($request->district_id);

     if(empty($district)){
        $response = [
            'success'=>false,
            'message'=> 'District not found'
         ];

         return response()->json($response,404);

     }


     $finance_services = DB::table('vendor_services')
     ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
     ->join('categories','categories.id','=','sub_categories.category_id')
     ->where('categories.name','Finance')
     ->where('is_verified',1)
     ->where('status','available')
     ->where('location',$district->name)
     ->orderBy('vendor_services.id','ASC')
     ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
     ->get();



     $all_finance_services = DB::table('vendor_services')
     ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
     ->join('categories','categories.id','=','sub_categories.category_id')
     ->where('categories.name','Finance')
     ->where('is_verified',1)
     ->where('status','available')
     ->orderBy('vendor_services.id','ASC')
     ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
     ->get();



     if(count($finance_services) == 0){

         $response = [
             'success'=>false,
             'message'=> "No results found for finance services in"." ".$district->name
          ];

          return response()->json($response,404);

     }

     else{



         $response = [
             'success'=>true,
             'data'=>[
                 'total-results'=>count($finance_services). " out of ".count($all_finance_services)." finance services" ,
                  'finance-services'=>$finance_services
             ],
             'message'=> "finance services in ".$district->name. " retrieved successfully"
          ];

          return response()->json($response,200);

     }




  }


 //sorting in ascending order

 public function finance_services_asc_sort(){

    $finance_services = DB::table('vendor_services')
    ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
    ->join('categories','categories.id','=','sub_categories.category_id')
    ->where('categories.name','Finance')
    ->where('is_verified',1)
    ->where('status','available')
    ->orderBy('vendor_services.id','ASC')
    ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
    ->get();




    $response = [
        'success'=>true,
        'data'=>[
            'total-finance-services'=>count($finance_services),
            'finance-services'=>$finance_services
        ],
        'message'=> 'finance services ordered by name in ascending order'
     ];

     return response()->json($response,200);


 }

 public function finance_services_desc_sort(){

    $finance_services = DB::table('vendor_services')
    ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
    ->join('categories','categories.id','=','sub_categories.category_id')
    ->where('categories.name','Finance')
    ->where('is_verified',1)
    ->where('status','available')
    ->orderBy('vendor_services.id','DESC')
    ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
    ->get();


    $response = [
        'success'=>true,
        'data'=>[
            'total-finance-services'=>count($finance_services),
            'finance-services'=>$finance_services
        ],
        'message'=> 'finance services ordered by name in descending order'
     ];

     return response()->json($response,200);


 }


    public function store(Request $request)
    {


         //existing finance


        $rules = [
            'name' => 'required|string',
            'principal' => 'required|numeric|min:10000',
            'interest_rate' => 'required|integer|numeric|min:1|max:20',
            'loan_plan_id' => 'integer|required',
            'loan_pay_back' => 'string|required',
            'document_type' => 'required|string',
            'image' => 'required',
            'terms'=>'required|string|min:10',
            'address_id'=>'required|integer',
        ];


        $request->validate($rules);
        $existing_finance = FinanceVendorService::where('name',$request->name)->first();
        $vendor_category = VendorCategory::where('name','Finance')->first();
        $location = Address::find($request->address_id);
        if(!$existing_finance){


            $new_finance_service = new FinanceVendorService();
            $new_finance_service->name = $request->name;
            $new_finance_service->principal = $request->principal;
            $new_finance_service->interest_rate = $request->interest_rate;
            $new_finance_service->interest_rate_unit = "%";
            $new_finance_service->loan_plan_id = $request->loan_plan_id;
            $new_finance_service->loan_pay_back = $request->loan_pay_back;
            $new_finance_service->is_verified = $request->is_verified;
            $new_finance_service->terms = $request->terms;
            $new_finance_service->vendor_category_id = $vendor_category->id;
            $new_finance_service->document_type = $request->document_type;
            $new_finance_service->user_id = auth()->user()->id;
            $new_finance_service->location = $location->district_name;
            $new_finance_service->is_verified = 0;




            //simple interest
            $percentage_interest_rate = ($request->interest_rate / 100);


            //calculate duration
            $loan_plan = LoanPlan::find($request->loan_plan_id);
            $loan_plan_duration =$loan_plan->value;
            $time = ($loan_plan_duration/12);


            $calculated_year_simple_interest = (int)($request->principal * $percentage_interest_rate * $time);
            $total_pay_amount = $calculated_year_simple_interest + $request->principal;




            $new_finance_service->simple_interest = $calculated_year_simple_interest;
            $new_finance_service->total_amount_paid_back = $total_pay_amount;
            $new_finance_service->save();




                  //set user as a vendor
            $user = User::find(auth()->user()->id);
             if(!$user->is_vendor ==1){
                $user->is_vendor =1;
                 $user->save();
             }




            $new_finance_service = FinanceVendorService::find($new_finance_service->id);
            $new_finance_service->image = \App\Models\ImageUploader::upload($request->file('image'),'finance');
            $new_finance_service->save();








            if($request->loan_pay_back == "Daily"){


                $payment_frequency_pay =  $percentage_interest_rate * $request->principal;
                #a month has 30.417 days
                $total_days = $loan_plan_duration * 30.417 ;
                $daily_pay = ($total_pay_amount / $total_days);
                $new_finance_service->payment_frequency_pay = $daily_pay;
                $new_finance_service->save();




            }elseif($request->loan_pay_back == "Weekly"){
                #a month has 4 weeks
                $total_weeks = $loan_plan_duration * 4;
                $weekly_pay = ($total_pay_amount / $total_weeks);
                $new_finance_service->payment_frequency_pay = $weekly_pay;
                $new_finance_service->save();


            }elseif($request->loan_pay_back == "Monthly"){


                $monthly_payment =  ($total_pay_amount / $loan_plan_duration);
                $new_finance_service->payment_frequency_pay = $monthly_payment;
                $new_finance_service->save();




            }
            $success['name'] = $new_finance_service->name;
            $success['principal'] = $new_finance_service->principal;
            $success['interest_rate'] = $new_finance_service->interest_rate.$new_finance_service->interest_rate_unit;
            $success['simple_interest'] = $new_finance_service->simple_interest;
            $success['duration'] = $new_finance_service->loan_plan->value." ".$new_finance_service->loan_plan->period_unit;
            $success['total_amount_paid_back'] = $new_finance_service->total_amount_paid_back;
            $success['status'] = $new_finance_service->status;
            $success['payment_frequency'] = $new_finance_service->loan_pay_back;
            $success['vendor_category'] = $new_finance_service->vendor_category;
            $success['document_type'] = $new_finance_service->document_type;
            $success['vendor'] = $new_finance_service->username;


            $response = [
               'success'=>true,
               'data'=> $success,
               'message'=> 'Finance Vendor service created successfully'
            ];


       return response()->json($response,200);


       }
       else{
           $response = [
               'success'=>false,
               'message'=> 'Finance Vendor service name exists'
            ];
            return response()->json($response,409);
       }
    }


    /**
     * Display the specified FinanceVendorService.
     * GET|HEAD /financeVendorServices/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var FinanceVendorService $financeVendorService */
        $financeVendorService = $this->financeVendorServiceRepository->find($id);


        if (empty($financeVendorService)) {
            return $this->sendError('Finance Vendor Service not found');
        }
        else{
            $success['id'] = $financeVendorService->id;
            $success['name'] = $financeVendorService->name;
            $success['image'] = $financeVendorService->image;
            $success['principal'] = $financeVendorService->principal;
            $success['interest_rate'] = $financeVendorService->interest_rate;
            $success['interest_rate_unit'] = $financeVendorService->interest_rate_unit;
            $success['duration'] = $financeVendorService->loan_plan->value;
            $success['duration_unit'] = $financeVendorService->loan_plan->period_unit;
            $success['payment_frequency'] = $financeVendorService->payment_frequency_pay;
            $success['status'] = $financeVendorService->status;
            $success['simple_interest'] = $financeVendorService->simple_interest;
            $success['total_amount_paid_back'] = $financeVendorService->total_amount_paid_back;
            $success['loan_pay_back'] = $financeVendorService->loan_pay_back;
            $success['document-required']= $financeVendorService->document_type;
            $success['terms']= $financeVendorService->terms;
            $success['location']= $financeVendorService->location;
            $success['is_verified']= $financeVendorService->is_verified;
            $success['vendor'] = $financeVendorService->user->username;


            $response = [
                'success'=>true,
                'data'=> $success,
                'message'=> 'Finance details retrieved successfully'
             ];


             return response()->json($response,200);
        }
    }



    public function vendor_finance_services(Request $request)
    {

       $vendor_finances = DB::table('vendor_services')
       ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
       ->join('categories','categories.id','=','sub_categories.category_id')
       ->where('categories.name','Finance')
       ->where('is_verified',1)
       ->where('status','available')
       ->where('user_id',auth()->user()->id)
       ->orderBy('vendor_services.id','DESC')
       ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
       ->get();




        if ($vendor_finances->count() == 0) {

            $response = [
                'success'=>false,
                'message'=> "You haven't posted any finance service"
             ];

             return response()->json($response,200);

        }
        else{



            $response = [
                'success'=>true,
                'data'=> [
                    'total-finance-services' =>$vendor_finances->count(),
                    'finance-services'=>$vendor_finances
                ],
                'message'=> 'Vendor finance services  retrieved'
             ];

             return response()->json($response,200);
        }




    }


    public function finance_search(Request $request){
        $search = $request->keyword;

        if(empty($request->keyword)){

            $response = [
                'success'=>false,
                'message'=> 'Enter a search keyword'
              ];
             return response()->json($response,400);

        }
        $all_services = DB::table('vendor_services')
        ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
        ->join('categories','categories.id','=','sub_categories.category_id')
        ->where('categories.name','Finance')
        ->where('is_verified',1)
        ->where('status','available')
        ->orderBy('vendor_services.id','DESC')
        ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
        ->get();



        $finance = DB::table('vendor_services')
        ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
        ->join('categories','categories.id','=','sub_categories.category_id')
        ->where('categories.name','Finance')
        ->where('is_verified',1)
        ->where('status','available')
        ->where('name', 'like', '%' . $search. '%')->orWhere('terms','like', '%' . $search.'%')
        ->orderBy('vendor_services.id','DESC')
        ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
        ->get();




        if(count($finance) == 0){
            $response = [
                'success'=>false,
                'message'=> 'No results found'
              ];
             return response()->json($response,404);

        }else{
            $response = [
                'success'=>true,
                'data'=> [
                    'total-results'=>count($finance)." "."results found out of"." ".count($all_services),
                    'search-results'=>$finance,

                ],

                'message'=> 'search results'
              ];
             return response()->json($response,200);

        }



}




}
