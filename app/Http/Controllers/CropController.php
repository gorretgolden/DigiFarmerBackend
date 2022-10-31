<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCropRequest;
use App\Http\Requests\UpdateCropRequest;
use App\Repositories\CropRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class CropController extends AppBaseController
{
    /** @var CropRepository $cropRepository*/
    private $cropRepository;

    public function __construct(CropRepository $cropRepo)
    {
        $this->cropRepository = $cropRepo;
    }

    /**
     * Display a listing of the Crop.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $crops = $this->cropRepository->all();

        return view('crops.index')
            ->with('crops', $crops);
    }

    /**
     * Show the form for creating a new Crop.
     *
     * @return Response
     */
    public function create()
    {
        return view('crops.create');
    }

    /**
     * Store a newly created Crop in storage.
     *
     * @param CreateCropRequest $request
     *
     * @return Response
     */
    public function store(CreateCropRequest $request)
    {
        $input = $request->all();

        $crop = $this->cropRepository->create($input);

        Flash::success('Crop saved successfully.');

        return redirect(route('crops.index'));
    }

    /**
     * Display the specified Crop.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $crop = $this->cropRepository->find($id);

        if (empty($crop)) {
            Flash::error('Crop not found');

            return redirect(route('crops.index'));
        }

        return view('crops.show')->with('crop', $crop);
    }

    /**
     * Show the form for editing the specified Crop.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $crop = $this->cropRepository->find($id);

        if (empty($crop)) {
            Flash::error('Crop not found');

            return redirect(route('crops.index'));
        }

        return view('crops.edit')->with('crop', $crop);
    }

    /**
     * Update the specified Crop in storage.
     *
     * @param int $id
     * @param UpdateCropRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCropRequest $request)
    {
        $crop = $this->cropRepository->find($id);

        if (empty($crop)) {
            Flash::error('Crop not found');

            return redirect(route('crops.index'));
        }

        $crop = $this->cropRepository->update($request->all(), $id);

        Flash::success('Crop updated successfully.');

        return redirect(route('crops.index'));
    }

    /**
     * Remove the specified Crop from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $crop = $this->cropRepository->find($id);

        if (empty($crop)) {
            Flash::error('Crop not found');

            return redirect(route('crops.index'));
        }

        $this->cropRepository->delete($id);

        Flash::success('Crop deleted successfully.');

        return redirect(route('crops.index'));
    }
}
