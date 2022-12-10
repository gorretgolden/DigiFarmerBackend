<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAnimalAPIRequest;
use App\Http\Requests\API\UpdateAnimalAPIRequest;
use App\Models\Animal;
use App\Repositories\AnimalRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\User;
use Auth;
use App\Models\Farm;


/**
 * Class AnimalController
 * @package App\Http\Controllers\API
 */

class AnimalAPIController extends AppBaseController
{
    /** @var  AnimalRepository */
    private $animalRepository;


    public function __construct(AnimalRepository $animalRepo)
    {
        $this->animalRepository = $animalRepo;
    }

    /**
     * Display a listing of the Animal.
     * GET|HEAD /animals
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $animals = Animal::with('animal_category','plot')->get();
        $response = [
            'success'=>true,
            'data'=> $animals,
            'message'=> 'Animals retrieved successfully'
         ];
         return response()->json($response,200);
    }

    /**
     * Store a newly created Animal in storage.
     * POST /animals
     *
     * @param CreateAnimalAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateAnimalAPIRequest $request)
    {
        $farm_plots = [];//farm plots

        $input = $request->all();

        $farmer = User::where('id', auth()->user()->id)->first();

        //dd($user_farms->count());


        $animal_plot = Animal::where('animal_category_id',$request->animal_category_id)->first();


        if( $animal_plot){
            $response = [
                'success'=>false,
                'message'=> 'Animal already exists on the plot'
             ];

             return response()->json($response,403);
        }
        elseif($farmer->farms->count()== 0){

            //dd('Farmer has no farms');
            $response = [
                'success'=>false,
                'message'=> 'Farmer has no farms'
             ];

             return response()->json($response,404);

        }else{

             foreach ($farmer->farms as $farm){

                if($farm->plots->count() == 0){

                   // dd('No plots exit on this farm');
                    $response = [
                        'success'=>false,
                        'data'=> $success,
                        'message'=> 'No plots exit on this farm'
                     ];

                     return response()->json($response,404);


                }else{

                    $new_animal = new Animal();
                    $new_animal->animal_category_id = $request->animal_category_id;
                    $new_animal->plot_id = $request->plot_id;
                    $new_animal->total = $request->total;
                    $new_animal->save();

                    $success['animal_category'] = $new_animal->animal_category;
                    $success['plot'] = $new_animal->plot;
                    $success['total'] = $new_animal->total;


                   $response = [
                    'success'=>true,
                    'data'=>$success,
                    'message'=> 'Animal added successfully on the plot'
                 ];

                 return response()->json($response,201);
                }

            }
        }


    }

    /**
     * Display the specified Animal.
     * GET|HEAD /animals/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Animal $animal */
        $animal = $this->animalRepository->find($id);

        if (empty($animal)) {
            return $this->sendError('Animal not found');
        }

        return $this->sendResponse($animal->toArray(), 'Animal retrieved successfully');
    }

    /**
     * Update the specified Animal in storage.
     * PUT/PATCH /animals/{id}
     *
     * @param int $id
     * @param UpdateAnimalAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAnimalAPIRequest $request)
    {
        $input = $request->all();

        /** @var Animal $animal */
        $animal = $this->animalRepository->find($id);

        if (empty($animal)) {
            return $this->sendError('Animal not found');
        }

        $animal = $this->animalRepository->update($input, $id);

        return $this->sendResponse($animal->toArray(), 'Animal updated successfully');
    }

    /**
     * Remove the specified Animal from storage.
     * DELETE /animals/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Animal $animal */
        $animal = $this->animalRepository->find($id);

        if (empty($animal)) {
            return $this->sendError('Animal not found');
        }

        $animal->delete();

        return $this->sendSuccess('Animal deleted successfully');
    }
}
