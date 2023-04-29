<?php

namespace App\Http\Controllers;

use App\DataTables\VendorServiceDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateVendorServiceRequest;
use App\Http\Requests\UpdateVendorServiceRequest;
use App\Repositories\VendorServiceRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\SubCategory;
use App\Models\Address;
use App\Models\User;
use App\Models\LoanPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class VendorServiceController extends AppBaseController
{
    /** @var VendorServiceRepository $vendorServiceRepository*/
    private $vendorServiceRepository;

    public function __construct(VendorServiceRepository $vendorServiceRepo)
    {
        $this->vendorServiceRepository = $vendorServiceRepo;
    }

    /**
     * Display a listing of the VendorService.
     *
     * @param VendorServiceDataTable $vendorServiceDataTable
     *
     * @return Response
     */
    public function index(VendorServiceDataTable $vendorServiceDataTable)
    {
        return $vendorServiceDataTable->render('vendor_services.index');
    }

    /**
     * Show the form for creating a new VendorService.
     *
     * @return Response
     */
    public function create()
    {
        return view('vendor_services.create');
    }

    /**
     * Store a newly created VendorService in storage.
     *
     * @param CreateVendorServiceRequest $request
     *
     * @return Response
     */
    public function store(CreateVendorServiceRequest $request)
    {

        $sub_category = SubCategory::find($request->sub_category_id);
        $category = $sub_category->category->name;
        $location = Address::where('id',$request->address_id)->first();


        $vendor_service = new VendorService();

        //required fields
        $vendor_service->name = ucwords($request->name);
        $vendor_service->rent_vendor_sub_category_id = $request->rent_vendor_sub_category_id;
        $vendor_service->is_verified = $request->is_verified;
        $vendor_service->price_unit = 'UGX';
        if(!empty($request->file('image'))){
            $vendor_service->image = \App\Models\ImageUploader::upload($request->file('image'),'rent');
        }
        $vendor_service->user_id = $request->user_id;
        $vendor_service->location = $location->district_name;
        $vendor_service->description = $request->description;
        $vendor_service->sub_category_id = $request->sub_category_id;
        $vendor_service->save();



        //set user as a vendor
        $user = User::find($request->user_id);
        if(!$user->is_vendor ==1){
           $user->is_vendor =1;
           $user->save();
        }



        //animal feeds
        if($category == 'Animal Feeds'){
            $request->validate([

                'price'=>'required|integer',
                'weight'=>'required|integer',
                'stock_amount' =>'required|integer',
                'weight_unit'=> 'required|string'
            ]);
            $vendor_service->charge = $request->charge;
            $vendor_service->stock_amount = $request->stock_amount;
            $vendor_service->weight = $request->weight;
            $vendor_service->weight_unit = $request->weight_unit;
            $vendor_service->status = 'on-sale';
            $vendor_service->save();
        }


        //trainings
        if($category == 'Farmer Trainings'){
            $request->validate([
                'name' => 'required|string|unique:training_vendor_services',
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
            $vendor_service->status = 'availab;r';
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

        Flash::success('Vendor Service saved successfully.');

        return redirect(route('vendorServices.index'));
    }

    /**
     * Display the specified VendorService.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $vendorService = $this->vendorServiceRepository->find($id);

        if (empty($vendorService)) {
            Flash::error('Vendor Service not found');

            return redirect(route('vendorServices.index'));
        }

        return view('vendor_services.show')->with('vendorService', $vendorService);
    }

    /**
     * Show the form for editing the specified VendorService.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $vendorService = $this->vendorServiceRepository->find($id);

        if (empty($vendorService)) {
            Flash::error('Vendor Service not found');

            return redirect(route('vendorServices.index'));
        }

        return view('vendor_services.edit')->with('vendorService', $vendorService);
    }

    /**
     * Update the specified VendorService in storage.
     *
     * @param int $id
     * @param UpdateVendorServiceRequest $request
     *
     * @return Response
     */

     public function update($id, Request $request)
    {

        $vendorService = $this->vendorServiceRepository->find($id);


        if (empty($vendorService)) {
            Flash::error('Vendor Service not found');

            return redirect(route('vendorServices.index'));
        }

        $vendorService->name = ucwords($request->name);
        $vendorService->price = $request->price;
        $vendorService->is_verified = $request->is_verified;
        $vendorService->description = $request->description;
        $vendorService->save();


        if(!empty($request->file('image'))){
            File::delete('storage/vendor_services'.$vendorService->image);
            $vendorService->image = \App\Models\ImageUploader::upload($request->file('image'),'vendor_services');
            $vendorService->save();
        }



        Flash::success('Vendor Service updated successfully.');

         return redirect(route('vendorServices.index'));
    }
    // public function update($id, UpdateVendorServiceRequest $request)
    // {
    //     $vendorService = $this->vendorServiceRepository->find($id);




    //     if (empty($vendorService)) {

    //         Flash::success('Vendor Service updated successfully.');

    //         return redirect(route('vendorServices.index'));
    //     }

    //     $vendorService = $this->vendorServiceRepository->update($request->all(), $id);

    //     Flash::success('Vendor Service updated successfully.');

    //     return redirect(route('vendorServices.index'));
    // }

    /**
     * Remove the specified VendorService from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $vendorService = $this->vendorServiceRepository->find($id);

        if (empty($vendorService)) {
            Flash::error('Vendor Service not found');

            return redirect(route('vendorServices.index'));
        }

        $this->vendorServiceRepository->delete($id);

        Flash::success('Vendor Service deleted successfully.');

        return redirect(route('vendorServices.index'));
    }
}
