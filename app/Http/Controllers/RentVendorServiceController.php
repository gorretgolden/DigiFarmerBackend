<?php

namespace App\Http\Controllers;

use App\DataTables\RentVendorServiceDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateRentVendorServiceRequest;
use App\Http\Requests\UpdateRentVendorServiceRequest;
use App\Repositories\RentVendorServiceRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\RentVendorService;
use App\Models\RentVendorImage;
use App\Models\VendorCategory;
use Illuminate\Http\Request;
use App\Models\RentVendorSubCategory;
use App\Models\Address;
use App\Models\User;
use Illuminate\Support\Facades\File;


class RentVendorServiceController extends AppBaseController
{
    /** @var RentVendorServiceRepository $rentVendorServiceRepository*/
    private $rentVendorServiceRepository;

    public function __construct(RentVendorServiceRepository $rentVendorServiceRepo)
    {
        $this->rentVendorServiceRepository = $rentVendorServiceRepo;
    }

    /**
     * Display a listing of the RentVendorService.
     *
     * @param RentVendorServiceDataTable $rentVendorServiceDataTable
     *
     * @return Response
     */
    public function index(RentVendorServiceDataTable $rentVendorServiceDataTable)
    {
        return $rentVendorServiceDataTable->render('rent_vendor_services.index');
    }

    /**
     * Show the form for creating a new RentVendorService.
     *
     * @return Response
     */
    public function create()
    {
        return view('rent_vendor_services.create');
    }

      //fetch user addresses
      public function fetchSubCategories(Request $request)
      {


        $data['Sub_categories'] = RentVendorSubCategory::where("rent_vendor_category_id", $request->rent_vendor_category_id)->get(["name", "id"]);


          return response()->json($data);
      }

    /**
     * Store a newly created RentVendorService in storage.
     *
     * @param CreateRentVendorServiceRequest $request
     *
     * @return Response
     */
    public function store(CreateRentVendorServiceRequest $request)
    {
        $input = $request->all();

        $vendor_category = VendorCategory::where('name','Rent')->first();
        $location = Address::where('id',$request->address_id)->first();


        $rent_vendor_service = new RentVendorService();
        $rent_vendor_service->name = $request->name;
        $rent_vendor_service->rent_vendor_sub_category_id = $request->rent_vendor_sub_category_id;
        $rent_vendor_service->charge = $request->charge;
        $rent_vendor_service->charge_frequency= $request->charge_frequency;
        $rent_vendor_service->quantity = $request->quantity;
        $rent_vendor_service->status = 'available for rent';
        $rent_vendor_service->is_verified = $request->is_verified;
        $rent_vendor_service->image = $request->image;




         //set user as a vendor
         $user = User::find($request->user_id);
         if(!$user->is_vendor ==1){
            $user->is_vendor =1;
            $user->save();
         }
        $rent_vendor_service->user_id = $request->user_id;

        $rent_vendor_service->location = $location->district_name;
        $rent_vendor_service->description = $request->description;
        $rent_vendor_service->vendor_category_id = $vendor_category->id;
        $rent_vendor_service->save();


        if(!empty($request->file('image'))){
            $rent_vendor_service->image = \App\Models\ImageUploader::upload($request->file('image'),'rent');
        }
        $rent_vendor_service->save();

        // if($request->hasFile('images')){

        //     foreach ($request->file('images') as $imagefile) {
        //         $image = new RentVendorImage();
        //         $path = $imagefile->store('/storage/rent', ['disk' =>   'rent-images']);
        //         $image->url = $path;
        //         $image->rent_vendor_service_id = $rent_vendor_service->id;
        //         $image->save();
        //       }
        // }

          //dd($input);



        Flash::success('Rent Vendor Service saved successfully.');

        return redirect(route('rentVendorServices.index'));
    }

    /**
     * Display the specified RentVendorService.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $rentVendorService = $this->rentVendorServiceRepository->find($id);

        if (empty($rentVendorService)) {
            Flash::error('Rent Vendor Service not found');

            return redirect(route('rentVendorServices.index'));
        }

        return view('rent_vendor_services.show')->with('rentVendorService', $rentVendorService);
    }

    /**
     * Show the form for editing the specified RentVendorService.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $rentVendorService = $this->rentVendorServiceRepository->find($id);

        if (empty($rentVendorService)) {
            Flash::error('Rent Vendor Service not found');

            return redirect(route('rentVendorServices.index'));
        }

        return view('rent_vendor_services.edit')->with('rentVendorService', $rentVendorService);
    }

    /**
     * Update the specified RentVendorService in storage.
     *
     * @param int $id
     * @param UpdateRentVendorServiceRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {

        $rules = [
            'name' => 'required|string|min:10|max:100',
            'rent_vendor_category_id' => 'required|integer',
            'rent_vendor_sub_category_id' => 'nullable|integer',
            'charge' => 'required|integer',
            'description' => 'required|string|min:20|max:1000',
            'image' => 'nullable',
            'image.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'images' => 'max:1',
            'user_id' => 'required|integer',
            'address_id' => 'nullable|integer',
            'quantity'=> 'required|integer',
            'charge_frequency'=>'required|string'

        ];
        $request->validate($rules);
        $rentVendorService = $this->rentVendorServiceRepository->find($id);

        if (empty($rentVendorService)) {
            Flash::error('Rent Vendor Service not found');

            return redirect(route('rentVendorServices.index'));
        }



        if(!empty($request->address_id)){
            $location = Address::find($request->address_id);
            $rentVendorService->location = $location->district_name;
            $rentVendorService->save();
            $rentVendorService->name = $request->name;
            $rentVendorService->charge = $request->charge;
            $rentVendorService->quantity = $request->quantity;
            $rentVendorService->is_verified = $request->is_verified;
            $rentVendorService->description = $request->description;
            $rentVendorService->charge_frequency = $request->charge_frequency;
            $rentVendorService->user_id = $request->user_id;
            $rentVendorService->save();


        }elseif(!empty($request->file('image'))){

            File::delete('storage/rent/'.$rentVendorService->image);
            $rentVendorService->image = \App\Models\ImageUploader::upload($request->file('image'),'rent');
            $rentVendorService->save();
            $rentVendorService->name = $request->name;
            $rentVendorService->charge = $request->charge;
            $rentVendorService->quantity = $request->quantity;
            $rentVendorService->is_verified = $request->is_verified;
            $rentVendorService->description = $request->description;
            $rentVendorService->charge_frequency = $request->charge_frequency;
            $rentVendorService->user_id = $request->user_id;
            $rentVendorService->save();


        }elseif(!empty($request->rent_vendor_sub_category_id)){

            $rentVendorService->rent_vendor_sub_category_id = $request->rent_vendor_sub_category_id;
            $rentVendorService->save();
            $rentVendorService->name = $request->name;
            $rentVendorService->charge = $request->charge;
            $rentVendorService->quantity = $request->quantity;
            $rentVendorService->is_verified = $request->is_verified;
            $rentVendorService->description = $request->description;
            $rentVendorService->charge_frequency = $request->charge_frequency;
            $rentVendorService->user_id = $request->user_id;
            $rentVendorService->save();

        }else{

            $rentVendorService->name = $request->name;
            $rentVendorService->charge = $request->charge;
            $rentVendorService->quantity = $request->quantity;
            $rentVendorService->is_verified = $request->is_verified;
            $rentVendorService->description = $request->description;
            $rentVendorService->charge_frequency = $request->charge_frequency;
            $rentVendorService->user_id = $request->user_id;
            $rentVendorService->save();


        }


        Flash::success('Rent Vendor Service updated successfully.');

        return redirect(route('rentVendorServices.index'));
    }

    /**
     * Remove the specified RentVendorService from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $rentVendorService = $this->rentVendorServiceRepository->find($id);

        if (empty($rentVendorService)) {
            Flash::error('Rent Vendor Service not found');

            return redirect(route('rentVendorServices.index'));
        }

        $this->rentVendorServiceRepository->delete($id);

        Flash::success('Rent Vendor Service deleted successfully.');

        return redirect(route('rentVendorServices.index'));
    }
}
