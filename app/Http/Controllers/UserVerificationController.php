<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserVerificationRequest;
use App\Http\Requests\UpdateUserVerificationRequest;
use App\Repositories\UserVerificationRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use App\Models\UserVerification;
use App\Models\User;

class UserVerificationController extends AppBaseController
{
    /** @var UserVerificationRepository $userVerificationRepository*/
    private $userVerificationRepository;

    public function __construct(UserVerificationRepository $userVerificationRepo)
    {
        $this->userVerificationRepository = $userVerificationRepo;
    }

    /**
     * Display a listing of the UserVerification.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $userVerifications = $this->userVerificationRepository->all();

        return view('user_verifications.index')
            ->with('userVerifications', $userVerifications);
    }

    /**
     * Show the form for creating a new UserVerification.
     *
     * @return Response
     */
    public function create()
    {
        return view('user_verifications.create');
    }

    /**
     * Store a newly created UserVerification in storage.
     *
     * @param CreateUserVerificationRequest $request
     *
     * @return Response
     */
    public function store(CreateUserVerificationRequest $request)
    {
        $input = $request->all();
        $verified_user = User::where('id',$request->user_id)->where('is_verified',1)->first();
        //dd($input);

        if($verified_user){
            Flash::success('User has already been verified');

            return redirect(route('userVerifications.index'));

        }
        else{
            if($request->hasFile('image')){

                foreach ($request->file('image') as $imagefile) {

                    $existing_user = UserVerification::where('user_id',auth()->user()->id)->first();

                    if($existing_user){
                        $response = [
                            'success'=>false,
                            'message'=>'You already uploaded your documents for verification'
                           ];

                        return response()->json($response,200);
                    }else{

                    }
                    $verification = new UserVerification();
                    $path = $imagefile->store('/images/resource', ['disk' =>   'user-verification-documents']);
                    $verification->image = $path;
                    $verification->user_id = $request->user_id;
                    $verification->verified = $request->verified;
                    $verification->save();
                    Flash::success('User Verification saved successfully.');

                    return redirect(route('userVerifications.index'));
                  }
            }

        }



    }

    /**
     * Display the specified UserVerification.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $userVerification = $this->userVerificationRepository->find($id);

        if (empty($userVerification)) {
            Flash::error('User Verification not found');

            return redirect(route('userVerifications.index'));
        }

        return view('user_verifications.show')->with('userVerification', $userVerification);
    }

    /**
     * Show the form for editing the specified UserVerification.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $userVerification = $this->userVerificationRepository->find($id);

        if (empty($userVerification)) {
            Flash::error('User Verification not found');

            return redirect(route('userVerifications.index'));
        }

        return view('user_verifications.edit')->with('userVerification', $userVerification);
    }

    /**
     * Update the specified UserVerification in storage.
     *
     * @param int $id
     * @param UpdateUserVerificationRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserVerificationRequest $request)
    {
        $userVerification = $this->userVerificationRepository->find($id);

        if (empty($userVerification)) {
            Flash::error('User Verification not found');

            return redirect(route('userVerifications.index'));
        }

        $userVerification = $this->userVerificationRepository->update($request->all(), $id);

        Flash::success('User Verification updated successfully.');

        return redirect(route('userVerifications.index'));
    }

    /**
     * Remove the specified UserVerification from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $userVerification = $this->userVerificationRepository->find($id);

        if (empty($userVerification)) {
            Flash::error('User Verification not found');

            return redirect(route('userVerifications.index'));
        }

        $this->userVerificationRepository->delete($id);

        Flash::success('User Verification deleted successfully.');

        return redirect(route('userVerifications.index'));
    }
}
