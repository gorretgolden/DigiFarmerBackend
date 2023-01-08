<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAnimalFeedAPIRequest;
use App\Http\Requests\API\UpdateAnimalFeedAPIRequest;
use App\Models\AnimalFeed;
use App\Repositories\AnimalFeedRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\VendorCategory;
use App\Models\User;

/**
 * Class AnimalFeedController
 * @package App\Http\Controllers\API
 */

class AnimalFeedAPIController extends AppBaseController
{
    /** @var  AnimalFeedRepository */
    private $animalFeedRepository;

    public function __construct(AnimalFeedRepository $animalFeedRepo)
    {
        $this->animalFeedRepository = $animalFeedRepo;
    }

    /**
     * Display a listing of the AnimalFeed.
     * GET|HEAD /animalFeeds
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {

        $animalFeeds = AnimalFeed::with('category','vendor')->get();
        $response = [
            'success'=>true,
            'data'=> $animalFeeds,
            'message'=> 'Animal Feeds retrieved successfully'
         ];
         return response()->json($response,200);

    }

    /**
     * Store a newly created AnimalFeed in storage.
     * POST /animalFeeds
     *
     * @param CreateAnimalFeedAPIRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|unique:animal_feeds',
            'price' => 'required|integer',
            'price_unit' => 'nullable',
            'description' => 'required|string',
            'image' => 'required',
            'quantity' => 'required|integer',
            'animal_category_id' => 'integer|required',
            'animal_feed_category_id' => 'required|integer',
            'address_id'  => 'required|integer'

        ];
        $request->validate($rules);
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
          $new_animal_feed->user_id = auth()->user()->id;
          $new_animal_feed->quantity = $request->quantity;
          $new_animal_feed->image = $request->image;

          $new_animal_feed->save();

          if(!empty($request->file('image'))){
            $new_animal_feed->image = \App\Models\ImageUploader::upload($request->file('image'),'animal_feeds');
          }

          $new_animal_feed->save();

        return $this->sendResponse($new_animal_feed->toArray(), 'Animal Feed saved successfully');
    }

    /**
     * Display the specified AnimalFeed.
     * GET|HEAD /animalFeeds/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var AnimalFeed $animalFeed */
        $animalFeed = $this->animalFeedRepository->find($id);

        if (empty($animalFeed)) {
            return $this->sendError('Animal Feed not found');
        }
        else{
            $success['name'] = $animalFeed ->name;
            $success['price'] = $animalFeed ->price;
            $success['price_unit'] = $animalFeed ->price_unit;
            $success['sub_category'] = $animalFeed ->sub_category;
            $success['description'] = $animalFeed ->description;
            $success['vendor'] = $animalFeed ->vendor;


            $response = [
                'success'=>true,
                'data'=> $success,
                'message'=> 'Animal Feed retrieved successfully'
             ];

             return response()->json($response,200);
        }


    }

    //get animal feeds for a vendor
    public function vendorAnimalFeeds(Request $request)
    {
       $vendor = User::find(auth()->user()->id);
       //dd($vendor->animal_feeds->count());

        if ($vendor->animal_feeds->count() == 0) {
            return $this->sendError('Vendor has no animal feeds');
        }
        else{
            $success['vendor'] = $vendor;
            $success['total-animal-feeds'] = $vendor->animal_feeds->count();
            $success['animal-feeds'] = $vendor->animal_feeds;

            $response = [
                'success'=>true,
                'data'=> $success,
                'message'=> 'Vendor feeds retrieved'
             ];

             return response()->json($response,200);
        }




    }



    /**
     * Update the specified AnimalFeed in storage.
     * PUT/PATCH /animalFeeds/{id}
     *
     * @param int $id
     * @param UpdateAnimalFeedAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAnimalFeedAPIRequest $request)
    {
        $input = $request->all();

        /** @var AnimalFeed $animalFeed */
        $animalFeed = $this->animalFeedRepository->find($id);

        if (empty($animalFeed)) {
            return $this->sendError('Animal Feed not found');
        }

        $animalFeed = $this->animalFeedRepository->update($input, $id);

        return $this->sendResponse($animalFeed->toArray(), 'AnimalFeed updated successfully');
    }

    /**
     * Remove the specified AnimalFeed from storage.
     * DELETE /animalFeeds/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var AnimalFeed $animalFeed */
        $animalFeed = $this->animalFeedRepository->find($id);

        if (empty($animalFeed)) {
            return $this->sendError('Animal Feed not found');
        }

        $animalFeed->delete();

        return $this->sendSuccess('Animal Feed deleted successfully');
    }
}
