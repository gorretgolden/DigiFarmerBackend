<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAddressAPIRequest;
use App\Http\Requests\API\UpdateAddressAPIRequest;
use App\Models\Address;
use App\Repositories\AddressRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\District;

/**
 * Class AddressController
 * @package App\Http\Controllers\API
 */

class AddressAPIController extends AppBaseController
{
    /** @var  AddressRepository */
    private $addressRepository;

    public function __construct(AddressRepository $addressRepo)
    {
        $this->addressRepository = $addressRepo;
    }

    /**
     * Display a listing of the Address.
     * GET|HEAD /addresses
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $addresses = $this->addressRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($addresses->toArray(), 'Addresses retrieved successfully');
    }

    /**
     * Store a newly created Address in storage.
     * POST /addresses
     *
     * @param CreateAddressAPIRequest $request
     *
     * @return Response
     */


    //address for a logged in user
    public function userAddress(Request $request)
    {
        $addresses = Address::where('user_id',auth()->user()->id)->get();
        if($addresses->count()==0){
            $response = [
                'success'=>true,
                'message'=> 'User has no addresses'
             ];
             return response()->json($response,200);

        }else{
            $response = [
                'success'=>true,
                'data'=> $addresses,
                'message'=> 'User addresses retrieved successfully'
             ];
             return response()->json($response,200);

        }

    }

    public function store(Request $request)
    {

        $rules = [
            'district_id' => 'required|integer',
            'address_name'=>'required|string|min:10'

        ];

        $request->validate($rules);

        $district = District::find($request->district_id);

        if(!$district){
            $response = [
                'success'=>false,
                'message'=> 'District not found'
             ];
             return response()->json($response,404);

        }

        if(Address::where('user_id',auth()->user()->id)->where('district_id',$request->district_id)->first()){
            $response = [
                'success'=>false,
                'message'=> 'This address exists'
             ];
             return response()->json($response,409);

        }else{
            $address = new Address();

            $address->user_id = auth()->user()->id;
            $address->district_id = $request->district_id;
            $address->district_name = $district->name;
            $address->address_name = $request->address_name;
            $address->save();


            return $this->sendResponse($address->toArray(), 'Address saved successfully');

        }


    }

    /**
     * Display the specified Address.
     * GET|HEAD /addresses/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Address $address */
        $address = $this->addressRepository->find($id);

        if (empty($address)) {
            return $this->sendError('Address not found');
        }

        return $this->sendResponse($address->toArray(), 'Address retrieved successfully');
    }

    /**
     * Update the specified Address in storage.
     * PUT/PATCH /addresses/{id}
     *
     * @param int $id
     * @param UpdateAddressAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAddressAPIRequest $request)
    {
        $input = $request->all();

        /** @var Address $address */
        $address = $this->addressRepository->find($id);

        if (empty($address)) {
            return $this->sendError('Address not found');
        }

        $address = $this->addressRepository->update($input, $id);

        return $this->sendResponse($address->toArray(), 'Address updated successfully');
    }

    /**
     * Remove the specified Address from storage.
     * DELETE /addresses/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Address $address */
        $address = $this->addressRepository->find($id);

        if (empty($address)) {
            return $this->sendError('Address not found');
        }

        $address->delete();

        return $this->sendSuccess('Address deleted successfully');
    }
}
