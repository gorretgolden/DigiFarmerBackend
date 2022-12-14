<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateOnboardingAPIRequest;
use App\Http\Requests\API\UpdateOnboardingAPIRequest;
use App\Models\Onboarding;
use App\Repositories\OnboardingRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class OnboardingController
 * @package App\Http\Controllers\API
 */

class OnboardingAPIController extends AppBaseController
{
    /** @var  OnboardingRepository */
    private $onboardingRepository;

    public function __construct(OnboardingRepository $onboardingRepo)
    {
        $this->onboardingRepository = $onboardingRepo;
    }

    /**
     * Display a listing of the Onboarding.
     * GET|HEAD /onboardings
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $onboardings = $this->onboardingRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($onboardings->toArray(), 'Onboardings retrieved successfully');
    }

    /**
     * Store a newly created Onboarding in storage.
     * POST /onboardings
     *
     * @param CreateOnboardingAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateOnboardingAPIRequest $request)
    {
        $input = $request->all();

        $onboarding = $this->onboardingRepository->create($input);

        return $this->sendResponse($onboarding->toArray(), 'Onboarding saved successfully');
    }

    /**
     * Display the specified Onboarding.
     * GET|HEAD /onboardings/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Onboarding $onboarding */
        $onboarding = $this->onboardingRepository->find($id);

        if (empty($onboarding)) {
            return $this->sendError('Onboarding not found');
        }

        return $this->sendResponse($onboarding->toArray(), 'Onboarding retrieved successfully');
    }

    /**
     * Update the specified Onboarding in storage.
     * PUT/PATCH /onboardings/{id}
     *
     * @param int $id
     * @param UpdateOnboardingAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateOnboardingAPIRequest $request)
    {
        $input = $request->all();

        /** @var Onboarding $onboarding */
        $onboarding = $this->onboardingRepository->find($id);

        if (empty($onboarding)) {
            return $this->sendError('Onboarding not found');
        }

        $onboarding = $this->onboardingRepository->update($input, $id);

        return $this->sendResponse($onboarding->toArray(), 'Onboarding updated successfully');
    }

    /**
     * Remove the specified Onboarding from storage.
     * DELETE /onboardings/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Onboarding $onboarding */
        $onboarding = $this->onboardingRepository->find($id);

        if (empty($onboarding)) {
            return $this->sendError('Onboarding not found');
        }

        $onboarding->delete();

        return $this->sendSuccess('Onboarding deleted successfully');
    }
}
