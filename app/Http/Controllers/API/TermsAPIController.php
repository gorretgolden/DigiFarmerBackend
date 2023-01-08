<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTermsAPIRequest;
use App\Http\Requests\API\UpdateTermsAPIRequest;
use App\Models\Terms;
use App\Repositories\TermsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class TermsController
 * @package App\Http\Controllers\API
 */

class TermsAPIController extends AppBaseController
{
    /** @var  TermsRepository */
    private $termsRepository;

    public function __construct(TermsRepository $termsRepo)
    {
        $this->termsRepository = $termsRepo;
    }

    /**
     * Display a listing of the Terms.
     * GET|HEAD /terms
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $terms = Terms::all(['title','description'] );

        return $this->sendResponse($terms->toArray(), 'Terms retrieved successfully');
    }

    /**
     * Store a newly created Terms in storage.
     * POST /terms
     *
     * @param CreateTermsAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateTermsAPIRequest $request)
    {
        $input = $request->all();

        $terms = $this->termsRepository->create($input);

        return $this->sendResponse($terms->toArray(), 'Terms saved successfully');
    }

    /**
     * Display the specified Terms.
     * GET|HEAD /terms/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Terms $terms */
        $terms = $this->termsRepository->find($id);

        if (empty($terms)) {
            return $this->sendError('Terms not found');
        }

        return $this->sendResponse($terms->toArray(), 'Terms retrieved successfully');
    }

    /**
     * Update the specified Terms in storage.
     * PUT/PATCH /terms/{id}
     *
     * @param int $id
     * @param UpdateTermsAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTermsAPIRequest $request)
    {
        $input = $request->all();

        /** @var Terms $terms */
        $terms = $this->termsRepository->find($id);

        if (empty($terms)) {
            return $this->sendError('Terms not found');
        }

        $terms = $this->termsRepository->update($input, $id);

        return $this->sendResponse($terms->toArray(), 'Terms updated successfully');
    }

    /**
     * Remove the specified Terms from storage.
     * DELETE /terms/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Terms $terms */
        $terms = $this->termsRepository->find($id);

        if (empty($terms)) {
            return $this->sendError('Terms not found');
        }

        $terms->delete();

        return $this->sendSuccess('Terms deleted successfully');
    }
}
