<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCropAPIRequest;
use App\Http\Requests\API\UpdateCropAPIRequest;
use App\Models\Crop;
use App\Repositories\CropRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class CropController
 * @package App\Http\Controllers\API
 */

class CropAPIController extends AppBaseController
{
    /** @var  CropRepository */
    private $cropRepository;

    public function __construct(CropRepository $cropRepo)
    {
        $this->cropRepository = $cropRepo;
    }

    /**
     * Display a listing of the Crop.
     * GET|HEAD /crops
     *
     * @param Request $request
     * @return Response
     */

    public function index(Request $request)
    {
        $crops = $this->cropRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($crops->toArray(), 'Crops retrieved successfully');
    }

    /**
     * Store a newly created Crop in storage.
     * POST /crops
     *
     * @param CreateCropAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCropAPIRequest $request)
    {
        $input = $request->all();

        $crop = $this->cropRepository->create($input);

        return $this->sendResponse($crop->toArray(), 'Crop saved successfully');
    }

    /**
     * Display the specified Crop.
     * GET|HEAD /crops/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Crop $crop */
        $crop = $this->cropRepository->find($id);

        if (empty($crop)) {
            return $this->sendError('Crop not found');
        }

        return $this->sendResponse($crop->toArray(), 'Crop retrieved successfully');
    }

    /**
     * Update the specified Crop in storage.
     * PUT/PATCH /crops/{id}
     *
     * @param int $id
     * @param UpdateCropAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCropAPIRequest $request)
    {
        $input = $request->all();

        /** @var Crop $crop */
        $crop = $this->cropRepository->find($id);

        if (empty($crop)) {
            return $this->sendError('Crop not found');
        }

        $crop = $this->cropRepository->update($input, $id);

        return $this->sendResponse($crop->toArray(), 'Crop updated successfully');
    }

    /**
     * Remove the specified Crop from storage.
     * DELETE /crops/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Crop $crop */
        $crop = $this->cropRepository->find($id);

        if (empty($crop)) {
            return $this->sendError('Crop not found');
        }

        $crop->delete();

        return $this->sendSuccess('Crop deleted successfully');
    }
}
