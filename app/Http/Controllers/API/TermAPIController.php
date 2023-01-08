<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTermAPIRequest;
use App\Http\Requests\API\UpdateTermAPIRequest;
use App\Models\Term;
use App\Repositories\TermRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class TermController
 * @package App\Http\Controllers\API
 */

class TermAPIController extends AppBaseController
{
    /** @var  TermRepository */
    private $termRepository;

    public function __construct(TermRepository $termRepo)
    {
        $this->termRepository = $termRepo;
    }

    /**
     * Display a listing of the Term.
     * GET|HEAD /terms
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $terms = $this->termRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($terms->toArray(), 'Terms retrieved successfully');
    }

    /**
     * Store a newly created Term in storage.
     * POST /terms
     *
     * @param CreateTermAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateTermAPIRequest $request)
    {
        $input = $request->all();

        $term = $this->termRepository->create($input);

        return $this->sendResponse($term->toArray(), 'Term saved successfully');
    }

    /**
     * Display the specified Term.
     * GET|HEAD /terms/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Term $term */
        $term = $this->termRepository->find($id);

        if (empty($term)) {
            return $this->sendError('Term not found');
        }

        return $this->sendResponse($term->toArray(), 'Term retrieved successfully');
    }

    /**
     * Update the specified Term in storage.
     * PUT/PATCH /terms/{id}
     *
     * @param int $id
     * @param UpdateTermAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTermAPIRequest $request)
    {
        $input = $request->all();

        /** @var Term $term */
        $term = $this->termRepository->find($id);

        if (empty($term)) {
            return $this->sendError('Term not found');
        }

        $term = $this->termRepository->update($input, $id);

        return $this->sendResponse($term->toArray(), 'Term updated successfully');
    }

    /**
     * Remove the specified Term from storage.
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
        /** @var Term $term */
        $term = $this->termRepository->find($id);

        if (empty($term)) {
            return $this->sendError('Term not found');
        }

        $term->delete();

        return $this->sendSuccess('Term deleted successfully');
    }
}
