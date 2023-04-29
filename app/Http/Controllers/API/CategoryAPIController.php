<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCategoryAPIRequest;
use App\Http\Requests\API\UpdateCategoryAPIRequest;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\SubCategory;
use DB;

/**
 * Class CategoryController
 * @package App\Http\Controllers\API
 */

class CategoryAPIController extends AppBaseController
{
    /** @var  CategoryRepository */
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepository = $categoryRepo;
    }


    public function index(Request $request)
    {
        $categories = Category::where('is_active',1)->latest()->get(['id','name','image']);
        $response = [
            'success'=>true,
            'data'=> [
                'total'=>count($categories),
                'all-categories'=>$categories
            ],
            'message'=> 'Categories retrieved successfully'
         ];
         return response()->json($response,200);
    }

    //get vendor categories
    public function vendor_categories(Request $request)
    {
        $categories = Category::where('is_active',1)->where('type','vendors')->
        orderBy('name','ASC')->get(['id','name','image']);
        $response = [
            'success'=>true,
            'data'=> [
                'total'=>count($categories),
                'vendor-categories'=>$categories
            ],
            'message'=> 'Vendor categories retrieved successfully'
         ];
         return response()->json($response,200);
    }


    //animal categories
    public function animal_categories(Request $request)
    {
        $categories = Category::where('is_active',1)->where('type','animals')->orderBy('name','ASC')->get(['id','name','image']);
        $response = [
            'success'=>true,
            'data'=> [
                'total'=>count($categories),
                'animal-categories'=>$categories
            ],
            'message'=> 'Animal categories retrieved successfully'
         ];
         return response()->json($response,200);
    }

    //crop categories
    public function crop_categories(Request $request)
    {
        $categories = Category::where('is_active',1)->where('type','crops')->orderBy('name','ASC')->get(['id','name','image']);
        $response = [
            'success'=>true,
            'data'=> [
                'total'=>count($categories),
                'crop-categories'=>$categories
            ],
            'message'=> 'Crop categories retrieved successfully'
         ];
         return response()->json($response,200);
    }

    //crops under a crop category
    public function category_crops(Request $request,$id)
    {

        $category = Category::find($id);
        $crops = DB::table('crops')
                ->join('categories','categories.id','=','crops.category_id')
                ->where('crops.is_active',1)
                ->where('categories.type','crops')
                ->where('categories.id',$id)
                ->orderBy('name','ASC')
                ->select('categories.name as category','crops.name as name','crops.image as image')
                ->get();
                if(empty($category)){


                    $response = [
                       'success'=>false,
                      'message'=> 'Category not found'
                    ];
                    return response()->json($response,404);


                }

                elseif(count($crops) == 0){


                    $response = [
                       'success'=>false,
                      'message'=> 'No crops under '.$category->name
                    ];
                    return response()->json($response,404);


                }else{

                    $response = [
                        'success'=>true,
                        'data'=> [
                            'total'=>count($crops),
                            'category'=>$category->name,
                            'crops'=>$crops
                        ],
                        'message'=> 'Crops under'.$category->name.' retrieved successfully'
                     ];
                     return response()->json($response,200);

                }


    }


    //get faq categories
    public function faq_categories(Request $request)
    {
        $categories = Category::where('is_active',1)->where('type','faqs')->orderBy('name','ASC')->get(['id','name','image']);
        $response = [
            'success'=>true,
            'data'=> [
                'total'=>count($categories),
                'faq-categories'=>$categories
            ],
            'message'=> 'Faq categories retrieved successfully'
         ];
         return response()->json($response,200);
    }


    //get sub categories under a category
    public function category_sub_categories(Request $request, $id)
    {
        $category = Category::find($id);

        $sub_categories = DB::table('categories')
        ->join('sub_categories', 'sub_categories.category_id', '=','categories.id')
        ->where('categories.id', '=', $category->id)
        ->where('sub_categories.is_active',1)
        ->select('sub_categories.id','sub_categories.name','sub_categories.image','categories.name as category')
        ->orderBy('sub_categories.name','ASC')
        ->get();




        if (empty($category)) {
            $response = [
                'success'=>false,
                'message'=> 'Category not found'
              ];
             return response()->json($response,404);

        }elseif(count($sub_categories) == 0){

            $response = [
                'success'=>false,
                'message'=> 'Category '.$category->name.' has no sub_categories'
              ];
             return response()->json($response,404);

        }
        else{


            $response = [
                'success'=>true,
                'data'=>[
                    'total-sub-categories'=>count($sub_categories),
                    'sub-categories'=>$sub_categories
                ],
                'message'=> 'Category  sub categories retrieved'
              ];
             return response()->json($response,200);


        }


    }



    /**
     * Store a newly created Category in storage.
     * POST /categories
     *
     * @param CreateCategoryAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCategoryAPIRequest $request)
    {


        $input = $request->all();

        $category = $this->categoryRepository->create($input);

        return $this->sendResponse($category->toArray(), 'Category saved successfully');
    }

    /**
     * Display the specified Category.
     * GET|HEAD /categories/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Category $category */
        $category = Category::find($id);

       // dd( $category->sub_categories);

        if (empty($category)) {
            return $this->sendError('Category not found');
        }
        else{
            $response = [
                'success'=>true,
                'data'=> [
                    'category'=> $category,
                     'subCategories' => $category->sub_categories
                ],

                'message'=> 'Category details retrieved successfully'
             ];
        }

        return $this->sendResponse($category->toArray(), 'Category retrieved successfully');
    }

    //get crop crops under a crop category
    public function crops($id)
    {
        /** @var Category $category */
        $category = Category::find($id);
        $crops = $category->crops;
        //dd($crops);


        if (empty($category)) {
            return $this->sendError('Category not found');
        }
        else{
            $response = [
                'success'=>true,
                'data'=>$crops,
                'message'=> 'Crop details retrieved successfully'
             ];
        }
        return response()->json($response,200);
    }

    /**
     * Update the specified Category in storage.
     * PUT/PATCH /categories/{id}
     *
     * @param int $id
     * @param UpdateCategoryAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCategoryAPIRequest $request)
    {
        $input = $request->all();

        /** @var Category $category */
        $category = $this->categoryRepository->find($id);

        if (empty($category)) {
            return $this->sendError('Category not found');
        }

        $category = $this->categoryRepository->update($input, $id);

        return $this->sendResponse($category->toArray(), 'Category updated successfully');
    }

    /**
     * Remove the specified Category from storage.
     * DELETE /categories/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Category $category */
        $category = $this->categoryRepository->find($id);

        if (empty($category)) {
            return $this->sendError('Category not found');
        }

        $category->delete();

        return $this->sendSuccess('Category deleted successfully');
    }
}


// public function store(CreateFarmAPIRequest $request)
// {
//     $existing_farm = Farm::where('name',$request->name)->first();
//     if(!$existing_farm){
//         $new_farm = new Farm();
//         $new_farm->name = $request->name;
//         $new_farm->address = $request->addresss;
//         $new_farm->latitude = $request->latitude;
//         $new_farm->longitude = $request->longitude;
//         $new_farm->field_area = $request->field_area;
//         $new_farm->image = $request->image;
//         $new_farm->size_unit = $request->size_unit;
//         $new_farm->user_id = auth()->user()->id;
//         $new_farm->save();

//         $success['name'] = $new_farm->name;
//         $success['address'] = $new_farm->address;
//         $success['latitude'] = $new_farm->latitude;
//         $success['longitude'] = $new_farm->longitude;
//         $success['field_area'] = $new_farm->field_area;
//         $success['size_unit '] = $new_farm->size_unit;
//         $success['image'] = $new_farm->image;
//         $success['image'] = $new_farm->image;
//         $success['user_id'] = $new_farm->user_id;
//         $success['farm_owner'] = $new_farm->user->email;

//         $new_farm = Farm::find($new_farm->id);

//         $new_farm->image = \App\Models\ImageUploader::upload($request->file('image'),'farms');
//         $new_farm->save();
//         $response = [
//            'success'=>false,
//            'message'=> 'Farm created successfully'
//         ];

//     return response()->json($response,200);
//     }
//     else{

//         $response = [
//             'success'=>true,
//             'data'=> $success,
//             'message'=> 'Farm name already exists'
//          ];

//          return response()->json($response,401);

//     }


// }
