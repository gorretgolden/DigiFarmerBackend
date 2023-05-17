<?php

namespace App\Http\Controllers;

use App\DataTables\OnboardingDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateOnboardingRequest;
use App\Http\Requests\UpdateOnboardingRequest;
use App\Repositories\OnboardingRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Illuminate\Http\Request;
use App\Models\Onboarding;

class OnboardingController extends AppBaseController
{
    /** @var OnboardingRepository $onboardingRepository*/
    private $onboardingRepository;

    public function __construct(OnboardingRepository $onboardingRepo)
    {
        $this->onboardingRepository = $onboardingRepo;
    }

    /**
     * Display a listing of the Onboarding.
     *
     * @param OnboardingDataTable $onboardingDataTable
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $onBoardings = Onboarding::latest()->paginate(6);

        return view("onboardings.index")->with("onBoardings", $onBoardings);
    }

    /**
     * Show the form for creating a new Onboarding.
     *
     * @return Response
     */
    public function create()
    {
        return view("onboardings.create");
    }

    /**
     * Store a newly created Onboarding in storage.
     *
     * @param CreateOnboardingRequest $request
     *
     * @return Response
     */
    public function store(CreateOnboardingRequest $request)
    {
        //existing title
        $existing_title = Onboarding::where("title", $request->title)->first();

        if (!$existing_title) {
            $new_onboarding = new Onboarding();
            $new_onboarding->title = $request->title;
            $new_onboarding->is_active = $request->is_active;
            $new_onboarding->description = $request->description;
            $new_onboarding->image = $request->image;
            $new_onboarding->save();

            $new_onboarding = Onboarding::find($new_onboarding->id);

            $new_onboarding->image = \App\Models\ImageUploader::upload(
                $request->file("image"),
                "onboardings"
            );
            $new_onboarding->save();
            Flash::success("Onboarding saved successfully.");
            return redirect(route("onboardings.index"));
        } else {
            Flash::error("Title already already exists");
            return redirect(route("onboardings.index"));
        }
    }

    /**
     * Display the specified Onboarding.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $onboarding = $this->onboardingRepository->find($id);

        if (empty($onboarding)) {
            Flash::error("Onboarding not found");

            return redirect(route("onboardings.index"));
        }

        return view("onboardings.show")->with("onboarding", $onboarding);
    }

    /**
     * Show the form for editing the specified Onboarding.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $onboarding = $this->onboardingRepository->find($id);

        if (empty($onboarding)) {
            Flash::error("Onboarding not found");

            return redirect(route("onboardings.index"));
        }

        return view("onboardings.edit")->with("onboarding", $onboarding);
    }

    /**
     * Update the specified Onboarding in storage.
     *
     * @param int $id
     * @param UpdateOnboardingRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateOnboardingRequest $request)
    {
        $onboarding = $this->onboardingRepository->find($id);

        if (empty($onboarding)) {
            Flash::error("Onboarding not found");

            return redirect(route("onboardings.index"));
        }

        if (!empty($request->file("image"))) {
            $onboarding->image = \App\Models\ImageUploader::upload(
                $request->file("image"),
                "onboardings"
            );
        }
        $onboarding->save();
        $onboarding = $this->onboardingRepository->update($request->all(), $id);

        Flash::success("Onboarding updated successfully.");

        return redirect(route("onboardings.index"));
    }

    /**
     * Remove the specified Onboarding from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $onboarding = $this->onboardingRepository->find($id);

        if (empty($onboarding)) {
            Flash::error("Onboarding not found");

            return redirect(route("onboardings.index"));
        }

        $this->onboardingRepository->delete($id);

        Flash::success("Onboarding deleted successfully.");

        return redirect(route("onboardings.index"));
    }
}
