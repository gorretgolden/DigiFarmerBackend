<?php

namespace App\Http\Controllers;

use App\DataTables\AnimalFeedDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateAnimalFeedRequest;
use App\Http\Requests\UpdateAnimalFeedRequest;
use App\Repositories\AnimalFeedRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class AnimalFeedController extends AppBaseController
{
    /** @var AnimalFeedRepository $animalFeedRepository*/
    private $animalFeedRepository;

    public function __construct(AnimalFeedRepository $animalFeedRepo)
    {
        $this->animalFeedRepository = $animalFeedRepo;
    }

    /**
     * Display a listing of the AnimalFeed.
     *
     * @param AnimalFeedDataTable $animalFeedDataTable
     *
     * @return Response
     */
    public function index(AnimalFeedDataTable $animalFeedDataTable)
    {
        return $animalFeedDataTable->render('animal_feeds.index');
    }

    /**
     * Show the form for creating a new AnimalFeed.
     *
     * @return Response
     */
    public function create()
    {
        return view('animal_feeds.create');
    }

    /**
     * Store a newly created AnimalFeed in storage.
     *
     * @param CreateAnimalFeedRequest $request
     *
     * @return Response
     */
    public function store(CreateAnimalFeedRequest $request)
    {
        $input = $request->all();
        $input['price_unit'] = "kg";

        $animalFeed = $this->animalFeedRepository->create($input);

        Flash::success('Animal Feed saved successfully.');

        return redirect(route('animalFeeds.index'));
    }

    /**
     * Display the specified AnimalFeed.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $animalFeed = $this->animalFeedRepository->find($id);

        if (empty($animalFeed)) {
            Flash::error('Animal Feed not found');

            return redirect(route('animalFeeds.index'));
        }

        return view('animal_feeds.show')->with('animalFeed', $animalFeed);
    }

    /**
     * Show the form for editing the specified AnimalFeed.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $animalFeed = $this->animalFeedRepository->find($id);

        if (empty($animalFeed)) {
            Flash::error('Animal Feed not found');

            return redirect(route('animalFeeds.index'));
        }

        return view('animal_feeds.edit')->with('animalFeed', $animalFeed);
    }

    /**
     * Update the specified AnimalFeed in storage.
     *
     * @param int $id
     * @param UpdateAnimalFeedRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAnimalFeedRequest $request)
    {
        $animalFeed = $this->animalFeedRepository->find($id);

        if (empty($animalFeed)) {
            Flash::error('Animal Feed not found');

            return redirect(route('animalFeeds.index'));
        }

        $animalFeed = $this->animalFeedRepository->update($request->all(), $id);

        Flash::success('Animal Feed updated successfully.');

        return redirect(route('animalFeeds.index'));
    }

    /**
     * Remove the specified AnimalFeed from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $animalFeed = $this->animalFeedRepository->find($id);

        if (empty($animalFeed)) {
            Flash::error('Animal Feed not found');

            return redirect(route('animalFeeds.index'));
        }

        $this->animalFeedRepository->delete($id);

        Flash::success('Animal Feed deleted successfully.');

        return redirect(route('animalFeeds.index'));
    }
}
