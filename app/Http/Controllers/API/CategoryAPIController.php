<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCategoryAPIRequest;
use App\Http\Requests\API\UpdateCategoryAPIRequest;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

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

    /**
     * Display a listing of the Category.
     * GET|HEAD /categories
     *
     * @param Request $request
     * @return Response
     */

     /**
     * @OA\Get(
     *      path="/categories",
     *      operationId="getAllCategories",
     *      tags={"Categories"},
     *      summary="Get list of crop categories",
     *      description="Returns list of crop categories",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function index(Request $request)
    {
        $categories = Category::with('crops')->get();
        $response = [
            'success'=>true,
            'data'=> $categories,
            'message'=> 'Categories retrieved successfully'
         ];
         return response()->json($response,200);
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
        $crops = $category->crops;
       // dd( $category->sub_categories);

        if (empty($category)) {
            return $this->sendError('Category not found');
        }
        else{
            $response = [
                'success'=>true,
                'data'=> [
                    'category'=> $category,
                     'crops' => $crops
                ],

                'message'=> 'Crop details retrieved successfully'
             ];
        }

        return $this->sendResponse($category->toArray(), 'Category retrieved successfully');
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
