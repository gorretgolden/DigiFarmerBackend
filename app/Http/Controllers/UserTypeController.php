<?php

namespace App\Http\Controllers;

use App\DataTables\UserTypeDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateUserTypeRequest;
use App\Http\Requests\UpdateUserTypeRequest;
use App\Repositories\UserTypeRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class UserTypeController extends AppBaseController
{
    /** @var UserTypeRepository $userTypeRepository*/
    private $userTypeRepository;

    public function __construct(UserTypeRepository $userTypeRepo)
    {
        $this->userTypeRepository = $userTypeRepo;
    }

    /**
     * Display a listing of the UserType.
     *
     * @param UserTypeDataTable $userTypeDataTable
     *
     * @return Response
     */
    public function index(UserTypeDataTable $userTypeDataTable)
    {
        return $userTypeDataTable->render('user_types.index');
    }

    /**
     * Show the form for creating a new UserType.
     *
     * @return Response
     */
    public function create()
    {
        return view('user_types.create');
    }

    /**
     * Store a newly created UserType in storage.
     *
     * @param CreateUserTypeRequest $request
     *
     * @return Response
     */
    public function store(CreateUserTypeRequest $request)
    {
        $input = $request->all();

        $userType = $this->userTypeRepository->create($input);

        Flash::success('User Type saved successfully.');

        return redirect(route('userTypes.index'));
    }

    /**
     * Display the specified UserType.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $userType = $this->userTypeRepository->find($id);

        if (empty($userType)) {
            Flash::error('User Type not found');

            return redirect(route('userTypes.index'));
        }

        return view('user_types.show')->with('userType', $userType);
    }

    /**
     * Show the form for editing the specified UserType.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $userType = $this->userTypeRepository->find($id);

        if (empty($userType)) {
            Flash::error('User Type not found');

            return redirect(route('userTypes.index'));
        }

        return view('user_types.edit')->with('userType', $userType);
    }

    /**
     * Update the specified UserType in storage.
     *
     * @param int $id
     * @param UpdateUserTypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserTypeRequest $request)
    {
        $userType = $this->userTypeRepository->find($id);

        if (empty($userType)) {
            Flash::error('User Type not found');

            return redirect(route('userTypes.index'));
        }

        $userType = $this->userTypeRepository->update($request->all(), $id);

        Flash::success('User Type updated successfully.');

        return redirect(route('userTypes.index'));
    }

    /**
     * Remove the specified UserType from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $userType = $this->userTypeRepository->find($id);

        if (empty($userType)) {
            Flash::error('User Type not found');

            return redirect(route('userTypes.index'));
        }

        $this->userTypeRepository->delete($id);

        Flash::success('User Type deleted successfully.');

        return redirect(route('userTypes.index'));
    }
}
