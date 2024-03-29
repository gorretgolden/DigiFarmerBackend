<?php

namespace App\Http\Controllers;

use App\DataTables\RegionDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateRegionRequest;
use App\Http\Requests\UpdateRegionRequest;
use App\Repositories\RegionRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\District;
use Illuminate\Http\Request;

class RegionController extends AppBaseController
{
    /** @var RegionRepository $regionRepository*/
    private $regionRepository;

    public function __construct(RegionRepository $regionRepo)
    {
        $this->regionRepository = $regionRepo;
    }

    /**
     * Display a listing of the Region.
     *
     * @param RegionDataTable $regionDataTable
     *
     * @return Response
     */
    public function index(RegionDataTable $regionDataTable)
    {
        return $regionDataTable->render('regions.index');
    }

    /**
     * Show the form for creating a new Region.
     *
     * @return Response
     */
    public function create()
    {
        return view('regions.create');
    }

    /**
     * Store a newly created Region in storage.
     *
     * @param CreateRegionRequest $request
     *
     * @return Response
     */



     public function fetchRegionDistricts(Request $request)
     {


       $data['districts'] = District::where("region_id", $request->region_id)->get(["name", "id"]);


         return response()->json($data);
     }

    public function store(CreateRegionRequest $request)
    {
        $input = $request->all();

        $region = $this->regionRepository->create($input);

        Flash::success('Region saved successfully.');

        return redirect(route('regions.index'));
    }

    /**
     * Display the specified Region.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $region = $this->regionRepository->find($id);

        if (empty($region)) {
            Flash::error('Region not found');

            return redirect(route('regions.index'));
        }

        return view('regions.show')->with('region', $region);
    }

    /**
     * Show the form for editing the specified Region.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $region = $this->regionRepository->find($id);

        if (empty($region)) {
            Flash::error('Region not found');

            return redirect(route('regions.index'));
        }

        return view('regions.edit')->with('region', $region);
    }

    /**
     * Update the specified Region in storage.
     *
     * @param int $id
     * @param UpdateRegionRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRegionRequest $request)
    {
        $region = $this->regionRepository->find($id);

        if (empty($region)) {
            Flash::error('Region not found');

            return redirect(route('regions.index'));
        }

        $region = $this->regionRepository->update($request->all(), $id);

        Flash::success('Region updated successfully.');

        return redirect(route('regions.index'));
    }

    /**
     * Remove the specified Region from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $region = $this->regionRepository->find($id);

        if (empty($region)) {
            Flash::error('Region not found');

            return redirect(route('regions.index'));
        }

        $this->regionRepository->delete($id);

        Flash::success('Region deleted successfully.');

        return redirect(route('regions.index'));
    }
}
