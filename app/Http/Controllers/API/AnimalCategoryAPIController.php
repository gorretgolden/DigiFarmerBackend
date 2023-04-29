<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAnimalCategoryAPIRequest;
use App\Http\Requests\API\UpdateAnimalCategoryAPIRequest;
use App\Models\AnimalCategory;
use App\Repositories\AnimalCategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use DB;

/**
 * Class AnimalCategoryController
 * @package App\Http\Controllers\API
 */

class AnimalCategoryAPIController extends AppBaseController
{
    /** @var  AnimalCategoryRepository */
    private $animalCategoryRepository;

    public function __construct(AnimalCategoryRepository $animalCategoryRepo)
    {
        $this->animalCategoryRepository = $animalCategoryRepo;
    }

    /**
     * Display a listing of the AnimalCategory.
     * GET|HEAD /animalCategories
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $animalCategories = AnimalCategory::where('is_active',1)->orderBy('name','ASC')->get(['id','name','type','image']);
        $response = [
            'success'=>true,
            'data'=> $animalCategories,
            'message'=> 'Animal Categories retrieved successfully'
         ];
         return response()->json($response,200);
    }


    //get livestock animals
    public function livestock(Request $request)
    {
        $livestock_animals = AnimalCategory::where('is_active',1)->where('type','livestock')->orderBy('name','ASC')->get(['id','name','type','image']);
        $response = [
            'success'=>true,
            'data'=> $livestock_animals,
            'message'=> 'Livestock animal Categories retrieved successfully'
         ];
         return response()->json($response,200);
    }

     //get poultry animals
     public function poultry(Request $request)
     {
         $poultry = AnimalCategory::where('is_active',1)->where('type','poultry')->orderBy('name','ASC')->get(['id','name','type','image']);
         $response = [
             'success'=>true,
             'data'=> $poultry,
             'message'=> 'Poultry animal Categories retrieved successfully'
          ];
          return response()->json($response,200);
     }

     //get vendor services under an animal
     public function animal_feed_service(Request $request,$id)
     {

        $animal_category = AnimalCategory::find($id);
        $animal_feeds = DB::table('animal_category_vendor_service')
                        ->join('animal_categories','animal_categories.id','=','animal_category_vendor_service.animal_category_id')
                        ->join('vendor_Services','vendor_Services.id','=','animal_category_vendor_service.vendor_Service_id')
                        ->where('vendor_Services.is_verified',1)
                        ->where('vendor_Services.status','on-sale')
                        ->where('animal_categories.id',$id)
                        ->orderBy('vendor_Services.id','DESC')
                        ->select('vendor_services.id as id','vendor_services.name as name','animal_categories.name as animal_category','vendor_services.image','description','price_unit','price','stock_amount','weight','weight_unit','status','is_verified','location')
                        ->get();

    // dd($animal_feeds);

         $response = [
             'success'=>true,
             'data'=> [
                'total-animal-feeds'=>count($animal_feeds),
                'animal-category'=>$animal_category->name,
                'animal-category-type'=>$animal_category->type,
                'animal-feeds' =>  $animal_feeds
             ],
             'message'=> 'Animal feeeds under'.$animal_category .' retrieved successfully'
          ];
          return response()->json($response,200);
     }


    /**
     * Store a newly created AnimalCategory in storage.
     * POST /animalCategories
     *
     * @param CreateAnimalCategoryAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateAnimalCategoryAPIRequest $request)
    {
        $input = $request->all();


        $animalCategory = $this->animalCategoryRepository->create($input);

        return $this->sendResponse($animalCategory->toArray(), 'Animal Category saved successfully');
    }



    public function animal_feeds($id)
    {
        $animal_category = AnimalCategory::find($id);
        //dd($animal_category);

        if(empty($animal_category)) {
            $response = [
                'success'=>false,
                'message'=> 'Animal  category not found'
             ];

             return response()->json($response,404);

        }elseif(count($animal_category->animal_feed_categories) == 0){
            $response = [
                'success'=>false,
                'message'=> "No feed categories under category ".$animal_category->name
             ];

             return response()->json($response,404);


        }
        else{

            $response = [
                'success'=>true,
                'data'=>[
                    'total-'=>count($animal_category->animal_feed_categories),
                    'category'=>$animal_category->name,
                    'animal-feed-categories'=>$animal_category->animal_feed_categories
                ],
                'message'=> "Animal feed categories under ".$animal_category->name." retrieved successfully"
             ];

             return response()->json($response,200);
        }




    }
    /**
     * Display the specified AnimalCategory.
     * GET|HEAD /animalCategories/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var AnimalCategory $animalCategory */
        $animalCategory = $this->animalCategoryRepository->find($id);

        if (empty($animalCategory)) {
            return $this->sendError('Animal Category not found');
        }

        return $this->sendResponse($animalCategory->toArray(), 'Animal Category retrieved successfully');
    }

    /**
     * Update the specified AnimalCategory in storage.
     * PUT/PATCH /animalCategories/{id}
     *
     * @param int $id
     * @param UpdateAnimalCategoryAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAnimalCategoryAPIRequest $request)
    {
        $input = $request->all();

        /** @var AnimalCategory $animalCategory */
        $animalCategory = $this->animalCategoryRepository->find($id);

        if (empty($animalCategory)) {
            return $this->sendError('Animal Category not found');
        }

        $animalCategory = $this->animalCategoryRepository->update($input, $id);

        return $this->sendResponse($animalCategory->toArray(), 'AnimalCategory updated successfully');
    }

    /**
     * Remove the specified AnimalCategory from storage.
     * DELETE /animalCategories/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var AnimalCategory $animalCategory */
        $animalCategory = $this->animalCategoryRepository->find($id);

        if (empty($animalCategory)) {
            return $this->sendError('Animal Category not found');
        }

        $animalCategory->delete();

        return $this->sendSuccess('Animal Category deleted successfully');
    }
}
