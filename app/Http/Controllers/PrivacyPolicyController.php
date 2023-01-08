<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePrivacyPolicyRequest;
use App\Http\Requests\UpdatePrivacyPolicyRequest;
use App\Repositories\PrivacyPolicyRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use App\Models\PrivacyPolicy;
class PrivacyPolicyController extends AppBaseController
{
    /** @var PrivacyPolicyRepository $privacyPolicyRepository*/
    private $privacyPolicyRepository;

    public function __construct(PrivacyPolicyRepository $privacyPolicyRepo)
    {
        $this->privacyPolicyRepository = $privacyPolicyRepo;
    }

    /**
     * Display a listing of the PrivacyPolicy.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $privacyPolicies = PrivacyPolicy::latest()->paginate(4);

        return view('privacy_policies.index')
            ->with('privacyPolicies', $privacyPolicies);
    }

    /**
     * Show the form for creating a new PrivacyPolicy.
     *
     * @return Response
     */
    public function create()
    {
        return view('privacy_policies.create');
    }

    /**
     * Store a newly created PrivacyPolicy in storage.
     *
     * @param CreatePrivacyPolicyRequest $request
     *
     * @return Response
     */
    public function store(CreatePrivacyPolicyRequest $request)
    {
        $input = $request->all();

        $privacyPolicy = $this->privacyPolicyRepository->create($input);

        Flash::success('Privacy Policy saved successfully.');

        return redirect(route('privacyPolicies.index'));
    }

    /**
     * Display the specified PrivacyPolicy.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $privacyPolicy = $this->privacyPolicyRepository->find($id);

        if (empty($privacyPolicy)) {
            Flash::error('Privacy Policy not found');

            return redirect(route('privacyPolicies.index'));
        }

        return view('privacy_policies.show')->with('privacyPolicy', $privacyPolicy);
    }

    /**
     * Show the form for editing the specified PrivacyPolicy.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $privacyPolicy = $this->privacyPolicyRepository->find($id);

        if (empty($privacyPolicy)) {
            Flash::error('Privacy Policy not found');

            return redirect(route('privacyPolicies.index'));
        }

        return view('privacy_policies.edit')->with('privacyPolicy', $privacyPolicy);
    }

    /**
     * Update the specified PrivacyPolicy in storage.
     *
     * @param int $id
     * @param UpdatePrivacyPolicyRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePrivacyPolicyRequest $request)
    {
        $privacyPolicy = $this->privacyPolicyRepository->find($id);

        if (empty($privacyPolicy)) {
            Flash::error('Privacy Policy not found');

            return redirect(route('privacyPolicies.index'));
        }

        $privacyPolicy = $this->privacyPolicyRepository->update($request->all(), $id);

        Flash::success('Privacy Policy updated successfully.');

        return redirect(route('privacyPolicies.index'));
    }

    /**
     * Remove the specified PrivacyPolicy from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $privacyPolicy = $this->privacyPolicyRepository->find($id);

        if (empty($privacyPolicy)) {
            Flash::error('Privacy Policy not found');

            return redirect(route('privacyPolicies.index'));
        }

        $this->privacyPolicyRepository->delete($id);

        Flash::success('Privacy Policy deleted successfully.');

        return redirect(route('privacyPolicies.index'));
    }
}
