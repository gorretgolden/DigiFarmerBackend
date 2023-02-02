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
use App\Models\Address;
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

        $animalFeeds = AnimalFeed::with('category','vendor')->latest()->get();
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
            'description' => 'required|string|min:10',
            'image' => 'required',
            'weight' => 'required|integer',
            'address_id' => 'required|integer',



        ];

        $request->validate($rules);
        $input = $request->all();
        $vendor_category = VendorCategory::where('name','Animal Feeds')->first();
        $location = Address::find($request->address_id);
          //new animal feed
          $new_animal_feed = new AnimalFeed();


          $new_animal_feed->weight_unit = $request->weight_unit;
          $new_animal_feed->name = $request->name;
          $new_animal_feed->price = $request->price;
          $new_animal_feed->animal_feed_category_id = $request->animal_feed_category_id;
          $new_animal_feed->vendor_category_id = $vendor_category->id;
          $new_animal_feed->location = $location->district_name;
          $new_animal_feed->description = $request->description;

          $user = User::find(auth()->user()->id);
          if(!$user->is_vendor ==1){
           $user->is_vendor = 1;
           $user->save();
          }
          $new_animal_feed->user_id = auth()->user()->id;
          $new_animal_feed->weight = $request->weight;
          $new_animal_feed->image = $request->image;
          $new_animal_feed->status = "on-sale";
          $new_animal_feed->save();


        //   //update time since
        //   $new_animal_feed->time_since = $new_animal_feed->created_at->diffForHumans();
        //   $new_animal_feed->save();

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
            $success['price'] = $animalFeed ->price." ".$animalFeed ->price_unit;
            $success['weight'] = $animalFeed ->weight." ".$animalFeed ->weight_unit;
            $success['description'] = $animalFeed ->description;
            $success['location'] = $animalFeed ->location;
            $success['status'] = $animalFeed ->status;
            $success['vendor'] = $animalFeed ->vendor->username;
            $success['image'] = $animalFeed->image;
            $success['animal_feed_category'] = $animalFeed->animal_feed_category->name;
            $success['animal_category'] = $animalFeed->animal_feed_category->animal_category->name;
            $success['created_at'] = $animalFeed->created_at->format('d/m/Y');
            $success['time_since'] = $animalFeed->created_at->diffForHumans();


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

       $vendor_animal_feeds = AnimalFeed::with('animal_feed_category')->where('user_id',auth()->user()->id)->latest()->get();
       $animal_feed = [];

        if ($vendor_animal_feeds->count() == 0) {
            return $this->sendError('you havent posted any animal feed');
        }
        else{

            foreach($vendor_animal_feeds as $feed){
                $animal_feed = $feed;
            }

            $response = [
                'success'=>true,
                'data'=> [
                    'total-animal-feeds' =>$animal_feed->count(),
                    'animal-feeds'=>$vendor_animal_feeds
                ],
                'message'=> 'Vendor animal feeds retrieved'
             ];

             return response()->json($response,200);
        }




    }

    //search for an animal feed by name
    public function search_animal_feed_by_name(Request $request,$name){


        if($name == ''){
            $animal_feeds = \App\Models\AnimalFeed::orderby('name','asc')->select('id','name')->limit(5)->get();
        }
        else{

            $animal_feeds = \App\Models\AnimalFeed::orderby('name','asc')->where('name','like','%'.$name.'%')->limit(5)->get();

            $response = [
                'success'=>true,
                'data'=> [
                    'total-animal-feeds' =>$animal_feeds->count(),
                    'search-results'=>$animal_feeds
                ],

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
