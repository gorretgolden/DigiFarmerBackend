<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePrivacyPolicyAPIRequest;
use App\Http\Requests\API\UpdatePrivacyPolicyAPIRequest;
use App\Models\PrivacyPolicy;
use App\Repositories\PrivacyPolicyRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class PrivacyPolicyController
 * @package App\Http\Controllers\API
 */

class PrivacyPolicyAPIController extends AppBaseController
{
    /** @var  PrivacyPolicyRepository */
    private $privacyPolicyRepository;

    public function __construct(PrivacyPolicyRepository $privacyPolicyRepo)
    {
        $this->privacyPolicyRepository = $privacyPolicyRepo;
    }

    /**
     * Display a listing of the PrivacyPolicy.
     * GET|HEAD /privacyPolicies
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $privacyPolicies = PrivacyPolicy::all('id','title','description');

        return $this->sendResponse($privacyPolicies->toArray(), 'Privacy Policies retrieved successfully');
    }

    /**
     * Store a newly created PrivacyPolicy in storage.
     * POST /privacyPolicies
     *
     * @param CreatePrivacyPolicyAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatePrivacyPolicyAPIRequest $request)
    {
        $input = $request->all();

        $privacyPolicy = $this->privacyPolicyRepository->create($input);

        return $this->sendResponse($privacyPolicy->toArray(), 'Privacy Policy saved successfully');
    }

    /**
     * Display the specified PrivacyPolicy.
     * GET|HEAD /privacyPolicies/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var PrivacyPolicy $privacyPolicy */
        $privacyPolicy = $this->privacyPolicyRepository->find($id);

        if (empty($privacyPolicy)) {
            return $this->sendError('Privacy Policy not found');
        }

        return $this->sendResponse($privacyPolicy->toArray(), 'Privacy Policy retrieved successfully');
    }

    /**
     * Update the specified PrivacyPolicy in storage.
     * PUT/PATCH /privacyPolicies/{id}
     *
     * @param int $id
     * @param UpdatePrivacyPolicyAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePrivacyPolicyAPIRequest $request)
    {
        $input = $request->all();

        /** @var PrivacyPolicy $privacyPolicy */
        $privacyPolicy = $this->privacyPolicyRepository->find($id);

        if (empty($privacyPolicy)) {
            return $this->sendError('Privacy Policy not found');
        }

        $privacyPolicy = $this->privacyPolicyRepository->update($input, $id);

        return $this->sendResponse($privacyPolicy->toArray(), 'PrivacyPolicy updated successfully');
    }

    /**
     * Remove the specified PrivacyPolicy from storage.
     * DELETE /privacyPolicies/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var PrivacyPolicy $privacyPolicy */
        $privacyPolicy = $this->privacyPolicyRepository->find($id);

        if (empty($privacyPolicy)) {
            return $this->sendError('Privacy Policy not found');
        }

        $privacyPolicy->delete();

        return $this->sendSuccess('Privacy Policy deleted successfully');
    }
}
