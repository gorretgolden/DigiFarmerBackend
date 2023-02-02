<?php

namespace App\Http\Controllers;

use App\DataTables\VeterinaryDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateVeterinaryRequest;
use App\Http\Requests\UpdateVeterinaryRequest;
use App\Repositories\VeterinaryRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Illuminate\Http\Request;
use App\Models\VendorCategory;
use App\Models\Veterinary;
use App\Models\Address;
use App\Models\User;

class VeterinaryController extends AppBaseController
{
    /** @var VeterinaryRepository $veterinaryRepository*/
    private $veterinaryRepository;

    public function __construct(VeterinaryRepository $veterinaryRepo)
    {
        $this->veterinaryRepository = $veterinaryRepo;
    }

    /**
     * Display a listing of the Veterinary.
     *
     * @param VeterinaryDataTable $veterinaryDataTable
     *
     * @return Response
     */
    public function index(VeterinaryDataTable $veterinaryDataTable)
    {
        return $veterinaryDataTable->render('veterinaries.index');
    }

    /**
     * Show the form for creating a new Veterinary.
     *
     * @return Response
     */
    public function create()
    {
        return view('veterinaries.create');
    }

    /**
     * Store a newly created Veterinary in storage.
     *
     * @param CreateVeterinaryRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {

        $rules = [
        'name' => 'required|string|max:50|unique:veterinaries',
        'expertise' => 'required|string|max:255|min:20',
        'charge' => 'required|integer',
        'charge_unit' => 'nullable',
        'availability' => 'required|string',
        'description' => 'required|string|max:255',
        'location' => 'nullable',
        'image' => 'required|image',
        'user_id' => 'required|integer',
        'animals' =>'required',
      ];

      $request->validate($rules);

     //  dd($location);
      $vendor_category = VendorCategory::where('name','Agronomists')->first();
      $new_vet_service = new Veterinary();
      $new_vet_service->name = $request->name;
      $new_vet_service->charge = $request->charge;
      $new_vet_service->charge_unit = "Per hour";

        //set user as a vendor
      $user = User::find($request->user_id);
        if(!$user->is_vendor ==1){
         $user->is_vendor =1;
         $user->save();
        }
      $new_vet_service->user_id = $request->user_id;

      $new_vet_service->vendor_category_id = $vendor_category->id;
      $new_vet_service->expertise = $request->expertise;
      $new_vet_service->image = $request->image;
      $new_vet_service->description = $request->description;
      $new_vet_service->save();

      $new_vet_service->animal_categories()->attach($request->animals);

      $new_vet_service = Veterinary::find($new_vet_service->id);

      $new_vet_service->image = \App\Models\ImageUploader::upload($request->file('image'),'vet');
      $new_vet_service->save();


     if($request->availability == "Online"){
        $request->validate(['zoom_details' => 'required|string']);
        $new_vet_service->zoom_details = $request->zoom_details;
        $new_vet_service->save();
        Flash::success('Veterinary service saved successfully.');

        return redirect(route('veterinaries.index'));



     }elseif($request->availability == "In-Person"){

        $request->validate(['address_id' => 'required|integer']);
        $location = Address::find($request->address_id);
        $new_agro_service->location= $location->district_name;
        $new_agro_service->save();
        Flash::success('Veterinary saved successfully.');
        return redirect(route('veterinaries.index'));


     }else{

        Flash::success('Veterinary saved successfully.');
        return redirect(route('veterinaries.index'));

     }


    }

    /**
     * Display the specified Veterinary.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $veterinary = $this->veterinaryRepository->find($id);

        if (empty($veterinary)) {
            Flash::error('Veterinary not found');

            return redirect(route('veterinaries.index'));
        }

        return view('veterinaries.show')->with('veterinary', $veterinary);
    }

    /**
     * Show the form for editing the specified Veterinary.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $veterinary = $this->veterinaryRepository->find($id);

        if (empty($veterinary)) {
            Flash::error('Veterinary not found');

            return redirect(route('veterinaries.index'));
        }

        return view('veterinaries.edit')->with('veterinary', $veterinary);
    }

    /**
     * Update the specified Veterinary in storage.
     *
     * @param int $id
     * @param UpdateVeterinaryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateVeterinaryRequest $request)
    {
        $veterinary = $this->veterinaryRepository->find($id);

        if (empty($veterinary)) {
            Flash::error('Veterinary not found');

            return redirect(route('veterinaries.index'));
        }

        $veterinary = $this->veterinaryRepository->update($request->all(), $id);

        Flash::success('Veterinary updated successfully.');

        return redirect(route('veterinaries.index'));
    }

    /**
     * Remove the specified Veterinary from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $veterinary = $this->veterinaryRepository->find($id);

        if (empty($veterinary)) {
            Flash::error('Veterinary not found');

            return redirect(route('veterinaries.index'));
        }

        $this->veterinaryRepository->delete($id);

        Flash::success('Veterinary deleted successfully.');

        return redirect(route('veterinaries.index'));
    }
}
