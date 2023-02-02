<?php

namespace App\Http\Controllers;

use App\DataTables\TrainingVendorServiceDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateTrainingVendorServiceRequest;
use App\Http\Requests\UpdateTrainingVendorServiceRequest;
use App\Repositories\TrainingVendorServiceRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Illuminate\Http\Request;
use App\Models\TrainingVendorService;
use App\Models\User;
use Carbon;
use App\Models\VendorCategory;
use App\Models\Address;

class TrainingVendorServiceController extends AppBaseController
{
    /** @var TrainingVendorServiceRepository $trainingVendorServiceRepository*/
    private $trainingVendorServiceRepository;

    public function __construct(TrainingVendorServiceRepository $trainingVendorServiceRepo)
    {
        $this->trainingVendorServiceRepository = $trainingVendorServiceRepo;
    }

    /**
     * Display a listing of the TrainingVendorService.
     *
     * @param TrainingVendorServiceDataTable $trainingVendorServiceDataTable
     *
     * @return Response
     */
    public function index(TrainingVendorServiceDataTable $trainingVendorServiceDataTable)
    {
        return $trainingVendorServiceDataTable->render('training_vendor_services.index');
    }

    /**
     * Show the form for creating a new TrainingVendorService.
     *
     * @return Response
     */
    public function create()
    {
        return view('training_vendor_services.create');
    }

    /**
     * Store a newly created TrainingVendorService in storage.
     *
     * @param CreateTrainingVendorServiceRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {

        $rules = [
            'name' => 'required|string|unique:training_vendor_services',
            'charge' => 'required|integer',
            'description' => 'required|string',
            'period' => 'nullable|integer',
            'access' => 'required|string',
            'user_id' => 'required|integer',
            'image'=>'required',
            'image.*' => 'image|mimes:png,jpg,jpeg|max:2048',
            'starting_date' => 'required|date',
            'ending_date' => 'required|after_or_equal:starting_date',
            'starting_time' => 'required|before:ending_time',
            'ending_time' => 'required|after:starting_time',
            'location' => 'nullable',
            'period_unit_id'  => 'nullable|integer',
        ];
        $request->validate($rules);
        $vendor_category = VendorCategory::where('name','Training')->first();

        //get days and ending date
    //     if($request->ending_date> Carbon::now()->subDays(2)->toDateTimeString()){
    //         dd('yes');
    //    }else{
    //        dd('no');
    //    }

        //access if (DateTime.Now.AddDays(-30).CompareTo(date) > 0)
        if($request->access == 'Online'){

            $request->validate(['zoom_details' => 'required|string']);
            $input['zoom_details'] = $request->zoom_details;
            $online_training = new TrainingVendorService();
            $online_training->name = $request->name;
            $online_training->charge = $request->charge;
            $online_training->description = $request->description;
            $online_training->image = $request->image;
            $online_training->access = $request->access;
            $online_training->starting_time = $request->starting_time;
            $online_training->ending_time = $request->ending_time;
            $online_training->starting_date = $request->starting_date;
            $online_training->ending_date = $request->ending_date;
            $online_training->vendor_category_id = $vendor_category->id;

             //set user as a vendor
            $user = User::find($request->user_id);
            if(!$user->is_vendor ==1){
             $user->is_vendor =1;
             $user->save();
            }
            $online_training->user_id = $request->user_id;

            $online_training->image = $request->image;
            $online_training->zoom_details = $request->zoom_details;
            $online_training->save();

            $online_training = TrainingVendorService::find($online_training->id);

            if(!empty($request->file('image'))){
                $online_training->image= \App\Models\ImageUploader::upload($request->file('image'),'trainings');
            }

            $online_training->save();

            Flash::success('Training Vendor Service saved successfully.');
            return redirect(route('trainingVendorServices.index'));


        }else{
            if($request->access =='Offline'){


                $request->validate(['address_id' => 'required|integer']);
                $location = Address::find($request->address_id);

                $online_training = new TrainingVendorService();
                $online_training->name = $request->name;
                $online_training->charge = $request->charge;
                $online_training->description = $request->description;
                $online_training->image = $request->image;
                $online_training->access = $request->access;
                $online_training->starting_time = $request->starting_time;
                $online_training->ending_time = $request->ending_time;
                $online_training->starting_date = $request->starting_date;
                $online_training->ending_date = $request->ending_date;
                $online_training->vendor_category_id = $vendor_category->id;

                //set user as a vendor
                $user = User::find($request->user_id);
                if(!$user->is_vendor ==1){
                 $user->is_vendor =1;
                 $user->save();
                }


                $online_training->user_id = $request->user_id;
                $online_training->location = $location->district_name;
                $online_training->save();


                $online_training = TrainingVendorService::find($online_training->id);
                if(!empty($request->file('image'))){
                    $online_training->image= \App\Models\ImageUploader::upload($request->file('image'),'trainings');
                }

                $online_training->save();

                Flash::success('Training Vendor Service saved successfully.');

                return redirect(route('trainingVendorServices.index'));

            }


        }


    }

    /**
     * Display the specified TrainingVendorService.
     *
     * @param int $id
     *
     * @return Response
     */



    public function show($id)
    {
        $trainingVendorService = $this->trainingVendorServiceRepository->find($id);

        if (empty($trainingVendorService)) {
            Flash::error('Training Vendor Service not found');

            return redirect(route('trainingVendorServices.index'));
        }

        return view('training_vendor_services.show')->with('trainingVendorService', $trainingVendorService);
    }

    /**
     * Show the form for editing the specified TrainingVendorService.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $trainingVendorService = $this->trainingVendorServiceRepository->find($id);

        if (empty($trainingVendorService)) {
            Flash::error('Training Vendor Service not found');

            return redirect(route('trainingVendorServices.index'));
        }

        return view('training_vendor_services.edit')->with('trainingVendorService', $trainingVendorService);
    }

    /**
     * Update the specified TrainingVendorService in storage.
     *
     * @param int $id
     * @param UpdateTrainingVendorServiceRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTrainingVendorServiceRequest $request)
    {
        $trainingVendorService = $this->trainingVendorServiceRepository->find($id);

        if (empty($trainingVendorService)) {
            Flash::error('Training Vendor Service not found');

            return redirect(route('trainingVendorServices.index'));
        }

        $trainingVendorService->fill($request->all());

        if(!empty($request->file('image'))){
            $trainingVendorService->image = \App\Models\ImageUploader::upload($request->file('image'),'training-services');
        }
        $trainingVendorService->save();


        Flash::success('Training Vendor Service updated successfully.');

        return redirect(route('trainingVendorServices.index'));
    }

    /**
     * Remove the specified TrainingVendorService from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $trainingVendorService = $this->trainingVendorServiceRepository->find($id);

        if (empty($trainingVendorService)) {
            Flash::error('Training Vendor Service not found');

            return redirect(route('trainingVendorServices.index'));
        }

        $this->trainingVendorServiceRepository->delete($id);

        Flash::success('Training Vendor Service deleted successfully.');

        return redirect(route('trainingVendorServices.index'));
    }
}
