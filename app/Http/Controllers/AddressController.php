<?php

namespace App\Http\Controllers;

use App\DataTables\AddressDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Repositories\AddressRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\Address;
use App\Models\District;

class AddressController extends AppBaseController
{
    /** @var AddressRepository $addressRepository*/
    private $addressRepository;

    public function __construct(AddressRepository $addressRepo)
    {
        $this->addressRepository = $addressRepo;
    }

    /**
     * Display a listing of the Address.
     *
     * @param AddressDataTable $addressDataTable
     *
     * @return Response
     */
    public function index(AddressDataTable $addressDataTable)
    {
        return $addressDataTable->render('addresses.index');
    }

    /**
     * Show the form for creating a new Address.
     *
     * @return Response
     */
    public function create()
    {
        return view('addresses.create');
    }

    /**
     * Store a newly created Address in storage.
     *
     * @param CreateAddressRequest $request
     *
     * @return Response
     */
    public function store(CreateAddressRequest $request)
    {

        $district = District::find($request->district_id);
        if(Address::where('user_id',$request->user_id)->where('district_id',$request->district_id)->first()){

            Flash::error('This address for the user exists');

            return redirect(route('addresses.index'));

        }else{
            $address = new Address();

            $address->user_id = $request->user_id;
            $address->district_id = $request->district_id;
            $address->district_name = $district->name;
            $address->address_name = $request->address_name;
            $address->save();

            Flash::success('Address saved successfully.');

            return redirect(route('addresses.index'));


        }



    }

    /**
     * Display the specified Address.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $address = $this->addressRepository->find($id);

        if (empty($address)) {
            Flash::error('Address not found');

            return redirect(route('addresses.index'));
        }

        return view('addresses.show')->with('address', $address);
    }

    /**
     * Show the form for editing the specified Address.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $address = $this->addressRepository->find($id);

        if (empty($address)) {
            Flash::error('Address not found');

            return redirect(route('addresses.index'));
        }

        return view('addresses.edit')->with('address', $address);
    }

    /**
     * Update the specified Address in storage.
     *
     * @param int $id
     * @param UpdateAddressRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAddressRequest $request)
    {
        $address = $this->addressRepository->find($id);

        if (empty($address)) {
            Flash::error('Address not found');

            return redirect(route('addresses.index'));
        }

        $address = $this->addressRepository->update($request->all(), $id);

        Flash::success('Address updated successfully.');

        return redirect(route('addresses.index'));
    }

    /**
     * Remove the specified Address from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $address = $this->addressRepository->find($id);

        if (empty($address)) {
            Flash::error('Address not found');

            return redirect(route('addresses.index'));
        }

        $this->addressRepository->delete($id);

        Flash::success('Address deleted successfully.');

        return redirect(route('addresses.index'));
    }
}
