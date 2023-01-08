<?php

namespace App\Http\Controllers;

use App\DataTables\FarmDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateFarmRequest;
use App\Http\Requests\UpdateFarmRequest;
use App\Repositories\FarmRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Response;
use App\Models\User;
use App\Models\Farm;
use App\Models\Address;

class FarmController extends AppBaseController
{
    /** @var FarmRepository $farmRepository*/
    private $farmRepository;

    public function __construct(FarmRepository $farmRepo)
    {
        $this->farmRepository = $farmRepo;
    }

    /**
     * Display a listing of the Farm.
     *
     * @param FarmDataTable $farmDataTable
     *
     * @return Response
     */
    public function index(FarmDataTable $farmDataTable)
    {
        return $farmDataTable->render('farms.index');
    }


    //get  all users
    public function farmers()
    {
        $farmers = User::where('user_type','farmer')->get(["username", "id"]);
        return view('farms.create')->with('farmers',$farmers);
    }

   //fetch user addresses
    public function fetchUserAddresses(Request $request)
    {


      $data['addresses'] = Address::where("user_id", $request->owner)->get(["district_name","address_name", "id"]);

        return response()->json($data);
    }
    /**
     * Show the form for creating a new Farm.
     *
     * @return Response
     */
    public function create()
    {
        return view('farms.create');
    }

    /**
     * Store a newly created Farm in storage.
     *
     * @param CreateFarmRequest $request
     *
     * @return Response
     */
    public function store(CreateFarmRequest $request)
    {
        $input = $request->all();
       // dd($input);
        $famer_id =   (int)$input['owner'];
        $famer = User::find($famer_id);

        //dd($famer_id);



        if(Farm::where('name',$request->name)->where('owner',$famer->username)->first()){
            Flash::error('Farm already exists.');

            return redirect(route('farms.index'));

        }else{
            $farm = new Farm();
            $farm->owner = $famer->username;
            $farm->name = $request->name;
            $farm->address_id = $request->address_id;
            $farm->field_area = $request->field_area;
            $farm->size_unit = $request->size_unit;
            $farm->save();
            Flash::success('Farm saved successfully.');

            return redirect(route('farms.index'));
        }


    }

    /**
     * Display the specified Farm.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $farm = $this->farmRepository->find($id);

        if (empty($farm)) {
            Flash::error('Farm not found');

            return redirect(route('farms.index'));
        }

        return view('farms.show')->with('farm', $farm);
    }

    /**
     * Show the form for editing the specified Farm.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $farm = $this->farmRepository->find($id);

        if (empty($farm)) {
            Flash::error('Farm not found');

            return redirect(route('farms.index'));
        }

        return view('farms.edit')->with('farm', $farm);
    }

    /**
     * Update the specified Farm in storage.
     *
     * @param int $id
     * @param UpdateFarmRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFarmRequest $request)
    {
        $farm = $this->farmRepository->find($id);

        if (empty($farm)) {
            Flash::error('Farm not found');

            return redirect(route('farms.index'));
        }

        $farm = $this->farmRepository->update($request->all(), $id);

        Flash::success('Farm updated successfully.');

        return redirect(route('farms.index'));
    }

    /**
     * Remove the specified Farm from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $farm = $this->farmRepository->find($id);

        if (empty($farm)) {
            Flash::error('Farm not found');

            return redirect(route('farms.index'));
        }

        $this->farmRepository->delete($id);

        Flash::success('Farm deleted successfully.');

        return redirect(route('farms.index'));
    }
}
