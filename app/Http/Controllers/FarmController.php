<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFarmRequest;
use App\Http\Requests\UpdateFarmRequest;
use App\Repositories\FarmRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use App\Models\Farm;

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
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $farms = $this->farmRepository->all();

        return view('farms.index')
            ->with('farms', $farms);
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
        $new_farm = new Farm();
        $new_farm->name = $request->name;
        $new_farm->latitude = $request->latitude;
        $new_farm->longitude= $request->longitude;
        $new_farm->address = $request->address;
        $new_farm->field_area = $request->field_area;
        $new_farm->size_unit = $request->size_unit;
        $new_farm->image = $request->image;
        $new_farm->user_id = $request->user_id;
        $new_farm->save();

        $new_farm = Farm::find($new_farm->id);

        $new_farm->image = \App\Models\ImageUploader::upload($request->file('image'),'farms');
        $new_farm->save();


        Flash::success('Farm saved successfully.');

        return redirect(route('farms.index'));
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
     * @throws \Exception
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
