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
use App\Models\VendorCategory;
use App\Models\AnimalFeed;

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
        $vendor_category = VendorCategory::where('name','Animal Feeds')->first();


        //new animal feed
        $new_animal_feed = new AnimalFeed();


        $new_animal_feed->quantity_unit = "kg";
        $new_animal_feed->name = $request->name;
        $new_animal_feed->price = $request->price;
        $new_animal_feed->animal_feed_category_id = $request->animal_feed_category_id;
        $new_animal_feed->animal_category_id = $request->animal_category_id;
        $new_animal_feed->vendor_category_id = $vendor_category->id;
        $new_animal_feed->address_id = $request->address_id;
        $new_animal_feed->description = $request->description;
        $new_animal_feed->user_id = $request->user_id;
        $new_animal_feed->quantity = $request->quantity;
        $new_animal_feed->image = $request->image;

        $new_animal_feed->save();

        if(!empty($request->file('image'))){
            $new_animal_feed->image= \App\Models\ImageUploader::upload($request->file('image'),'animal_feeds');
        }

        $new_animal_feed->save();

        Flash::success('Animal Feed posted successfully.');

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
