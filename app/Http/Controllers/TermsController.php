<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTermsRequest;
use App\Http\Requests\UpdateTermsRequest;
use App\Repositories\TermsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class TermsController extends AppBaseController
{
    /** @var TermsRepository $termsRepository*/
    private $termsRepository;

    public function __construct(TermsRepository $termsRepo)
    {
        $this->termsRepository = $termsRepo;
    }

    /**
     * Display a listing of the Terms.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $terms = $this->termsRepository->all();

        return view('terms.index')
            ->with('terms', $terms);
    }

    /**
     * Show the form for creating a new Terms.
     *
     * @return Response
     */
    public function create()
    {
        return view('terms.create');
    }

    /**
     * Store a newly created Terms in storage.
     *
     * @param CreateTermsRequest $request
     *
     * @return Response
     */
    public function store(CreateTermsRequest $request)
    {
        $input = $request->all();

        $terms = $this->termsRepository->create($input);

        Flash::success('Terms saved successfully.');

        return redirect(route('terms.index'));
    }

    /**
     * Display the specified Terms.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $terms = $this->termsRepository->find($id);

        if (empty($terms)) {
            Flash::error('Terms not found');

            return redirect(route('terms.index'));
        }

        return view('terms.show')->with('terms', $terms);
    }

    /**
     * Show the form for editing the specified Terms.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $terms = $this->termsRepository->find($id);

        if (empty($terms)) {
            Flash::error('Terms not found');

            return redirect(route('terms.index'));
        }

        return view('terms.edit')->with('terms', $terms);
    }

    /**
     * Update the specified Terms in storage.
     *
     * @param int $id
     * @param UpdateTermsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTermsRequest $request)
    {
        $terms = $this->termsRepository->find($id);

        if (empty($terms)) {
            Flash::error('Terms not found');

            return redirect(route('terms.index'));
        }

        $terms = $this->termsRepository->update($request->all(), $id);

        Flash::success('Terms updated successfully.');

        return redirect(route('terms.index'));
    }

    /**
     * Remove the specified Terms from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $terms = $this->termsRepository->find($id);

        if (empty($terms)) {
            Flash::error('Terms not found');

            return redirect(route('terms.index'));
        }

        $this->termsRepository->delete($id);

        Flash::success('Terms deleted successfully.');

        return redirect(route('terms.index'));
    }
}
