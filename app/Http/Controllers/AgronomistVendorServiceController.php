<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAgronomistVendorServiceRequest;
use App\Http\Requests\UpdateAgronomistVendorServiceRequest;
use App\Repositories\AgronomistVendorServiceRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use App\Models\AgronomistVendorService;
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
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $agronomistVendorServices = $this->agronomistVendorServiceRepository->all();

        return view('agronomist_vendor_services.index')
            ->with('agronomistVendorServices', $agronomistVendorServices);
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
            'name' => 'required|string|max:50',
            'expertise' => 'required|string|max:255|min:20',
            'charge' => 'required|integer',
            'charge_unit' => 'nullable',
            'availability' => 'required|string',
            'description' => 'required|string|max:255',
            'zoom_details' => 'nullable',
            'location_details' => 'nullable',
            'image' => 'required|image',
            'user_id' => 'required|integer',
            'vendor_category_id' => 'required|integer'
        ];

        $request->validate($rules);
        $new_agro_service = new AgronomistVendorService();
        $new_agro_service->name = $request->name;
        $new_agro_service->charge = $request->charge;
        $new_agro_service->charge_unit = "Per hour";
        $new_agro_service->user_id = $request->user_id;
        $new_agro_service->vendor_category_id = $request->vendor_category_id;
        $new_agro_service->expertise = $request->expertise;
        $new_agro_service->image = $request->image;
        $new_agro_service->description = $request->description;
        $new_agro_service->availability = $request->availability;
        $new_agro_service->save();

        $new_agro_service = AgronomistVendorService::find($new_agro_service->id);

        $new_agro_service->image = \App\Models\ImageUploader::upload($request->file('image'),'agronomists');
        $new_agro_service->save();





        if($request->availability == "Online"){

            $request->validate(['zoom_details' => 'required|string']);
            $new_agro_service->zoom_details = $request->zoom_details;
            $new_agro_service->save();

            Flash::success('Agronomist Vendor Service saved successfully.');

            return redirect(route('agronomistVendorServices.index'));

        }elseif($request->availability == "In-Person"){

            $request->validate(['location_details' => 'required|string']);
            $new_agro_service->location_details = $request->location_details;
            $new_agro_service->save();
            Flash::success('Agronomist Vendor Service saved successfully.');

            return redirect(route('agronomistVendorServices.index'));



        }
        else{
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
    public function update($id, UpdateAgronomistVendorServiceRequest $request)
    {
        $agronomistVendorService = $this->agronomistVendorServiceRepository->find($id);

        if (empty($agronomistVendorService)) {
            Flash::error('Agronomist Vendor Service not found');

            return redirect(route('agronomistVendorServices.index'));
        }

        $agronomistVendorService = $this->agronomistVendorServiceRepository->update($request->all(), $id);

        Flash::success('Agronomist Vendor Service updated successfully.');

        return redirect(route('agronomistVendorServices.index'));
    }

    /**
     * Remove the specified AgronomistVendorService from storage.
     *
     * @param int $id
     *
     * @throws \Exception
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
