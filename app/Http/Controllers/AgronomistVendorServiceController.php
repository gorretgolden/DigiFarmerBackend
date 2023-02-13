<?php


namespace App\Http\Controllers;


use App\DataTables\AgronomistVendorServiceDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateAgronomistVendorServiceRequest;
use App\Http\Requests\UpdateAgronomistVendorServiceRequest;
use App\Repositories\AgronomistVendorServiceRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Illuminate\Http\Request;
use App\Models\Crop;
use App\Models\VendorCategory;
use App\Models\AgronomistVendorService;
use App\Models\Address;
use App\Models\User;
use Illuminate\Support\Facades\File;


class AgronomistVendorServiceController extends AppBaseController
{
    /** @var AgronomistVendorServiceRepository $agronomistVendorServiceRepository*/
    private $agronomistVendorServiceRepository;


    public function __construct(AgronomistVendorServiceRepository $agronomistVendorServiceRepo)
    {
        $this->agronomistVendorServiceRepository = $agronomistVendorServiceRepo;
    }


    /**
     * Display a listing of the AgronomistVendorService.
     *
     * @param AgronomistVendorServiceDataTable $agronomistVendorServiceDataTable
     *
     * @return Response
     */
    public function index(AgronomistVendorServiceDataTable $agronomistVendorServiceDataTable)
    {
        return $agronomistVendorServiceDataTable->render('agronomist_vendor_services.index');
    }


    /**
     * Show the form for creating a new AgronomistVendorService.
     *
     * @return Response
     */
    public function create()
    {
        return view('agronomist_vendor_services.create');
    }


    /**
     * Store a newly created AgronomistVendorService in storage.
     *
     * @param CreateAgronomistVendorServiceRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {


        $rules = [
            'name' => 'required|string|max:50|unique:agronomists',
            'expertise' => 'required|string|max:255|min:20',
            'charge' => 'required|integer',
            'charge_unit' => 'nullable',
            'availability' => 'required|string',
            'description' => 'required|string|max:255',
            'location' => 'nullable',
            'image' => 'required|image',
            'user_id' => 'required|integer',
            'crops' =>'required',
        ];


        $request->validate($rules);


      //  dd($location);
        $vendor_category = VendorCategory::where('name','Agronomists')->first();
        $new_agro_service = new AgronomistVendorService();
        $new_agro_service->name = $request->name;
        $new_agro_service->charge = $request->charge;
        $new_agro_service->is_verified = $request->is_verified;
        $new_agro_service->charge_unit = "Per hour";


        //set user as a vendor
        $user = User::find($request->user_id);
        if(!$user->is_vendor ==1){
           $user->is_vendor =1;
           $user->save();
        }
        $new_agro_service->user_id = $request->user_id;
        $new_agro_service->vendor_category_id = $vendor_category->id;
        $new_agro_service->expertise = $request->expertise;
        $new_agro_service->description = $request->description;
        $new_agro_service->save();


        $new_agro_service->crops()->attach($request->crops);


        $new_agro_service = AgronomistVendorService::find($new_agro_service->id);


        if(!empty($request->file('image'))){
            $new_agro_service->image = \App\Models\ImageUploader::upload($request->file('image'),'agronomists');
            $new_agro_service->save();


        }




        if($request->availability == "Online"){
            $request->validate(['zoom_details' => 'required|string']);
            $new_agro_service->zoom_details = $request->zoom_details;
            $new_agro_service->save();
            Flash::success('Agronomist Vendor Service saved successfully.');
            return redirect(route('agronomistVendorServices.index'));






        }elseif($request->availability == "In-Person"){


            $request->validate(['address_id' => 'required|integer']);
            $location = Address::find($request->address_id);
            $new_agro_service->location= $location->district_name;
            $new_agro_service->save();
            Flash::success('Agronomist Vendor Service saved successfully.');


            return redirect(route('agronomistVendorServices.index'));


        }else{


            $new_agro_service->save();
            Flash::success('Agronomist Vendor Service saved successfully.');
            return redirect(route('agronomistVendorServices.index'));


        }


    }








    /**
     * Display the specified AgronomistVendorService.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $agronomistVendorService = $this->agronomistVendorServiceRepository->find($id);


        if (empty($agronomistVendorService)) {
            Flash::error('Agronomist Vendor Service not found');


            return redirect(route('agronomistVendorServices.index'));
        }


        return view('agronomist_vendor_services.show')->with('agronomistVendorService', $agronomistVendorService);
    }


    /**
     * Show the form for editing the specified AgronomistVendorService.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $agronomistVendorService = $this->agronomistVendorServiceRepository->find($id);


        if (empty($agronomistVendorService)) {
            Flash::error('Agronomist Vendor Service not found');


            return redirect(route('agronomistVendorServices.index'));
        }


        return view('agronomist_vendor_services.edit')->with('agronomistVendorService', $agronomistVendorService);
    }


    /**
     * Update the specified AgronomistVendorService in storage.
     *
     * @param int $id
     * @param UpdateAgronomistVendorServiceRequest $request
     *
     * @return Response
     */
    public function update($id,Request $request)
    {
        $rules = [
            'name' => 'required|string|max:100',
            'expertise' => 'required|min:10|string',
            'charge' => 'required|integer',
            'charge_unit' => 'nullable',
            'availability' => 'required|string',
            'description' => 'required|min:10',
            'zoom_details' => 'nullable',
            'location' => 'nullable',
            'image' => 'nullable|image',
            'user_id' => 'required|integer',
            'vendor_category_id' => 'nullable'
        ];
        $request->validate($rules);
        $agronomistVendorService = $this->agronomistVendorServiceRepository->find($id);


        if (empty($agronomistVendorService)) {
            Flash::error('Agronomist Vendor Service not found');
            return redirect(route('agronomistVendorServices.index'));
        }

        $agronomistVendorService->name = $request->name;
        $agronomistVendorService->charge = $request->charge;
        $agronomistVendorService->user_id = $request->user_id;
        $agronomistVendorService->expertise = $request->expertise;
        $agronomistVendorService->description = $request->description;
        $agronomistVendorService->is_verified = $request->is_verified;
        $agronomistVendorService->save();


        if(!empty($request->crops)){
            $agronomistVendorService->crops()->attach($request->crops);
            $agronomistVendorService->save();
        }


        if(!empty($request->address_id)){
            $location = Address::find($request->address_id);
            $agronomistVendorService->location = $location->district_name;
            $agronomistVendorService->save();


        }


        if(!empty($request->file('image'))){
            File::delete('storage/agronomists/'.$agronomistVendorService->image);
            $agronomistVendorService->image = \App\Models\ImageUploader::upload($request->file('image'),'agronomists');
            $agronomistVendorService->save();
        }


        Flash::success('Agronomist Vendor Service updated successfully.');


        return redirect(route('agronomistVendorServices.index'));
    }


    /**
     * Remove the specified AgronomistVendorService from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $agronomistVendorService = $this->agronomistVendorServiceRepository->find($id);


        if (empty($agronomistVendorService)) {
            Flash::error('Agronomist Vendor Service not found');


            return redirect(route('agronomistVendorServices.index'));
        }


        $this->agronomistVendorServiceRepository->delete($id);


        Flash::success('Agronomist Vendor Service deleted successfully.');


        return redirect(route('agronomistVendorServices.index'));
    }
}
