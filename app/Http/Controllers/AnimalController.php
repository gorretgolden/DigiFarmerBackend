<?php

namespace App\Http\Controllers;

use App\DataTables\AnimalDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateAnimalRequest;
use App\Http\Requests\UpdateAnimalRequest;
use App\Repositories\AnimalRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\Animal;
use Illuminate\Http\Request;
class AnimalController extends AppBaseController
{
    /** @var AnimalRepository $animalRepository*/
    private $animalRepository;

    public function __construct(AnimalRepository $animalRepo)
    {
        $this->animalRepository = $animalRepo;
    }

    /**
     * Display a listing of the Animal.
     *
     * @param AnimalDataTable $animalDataTable
     *
     * @return Response
     */
    public function index(AnimalDataTable $animalDataTable)
    {
        return $animalDataTable->render('animals.index');
    }

    /**
     * Show the form for creating a new Animal.
     *
     * @return Response
     */
    public function create()
    {
        return view('animals.create');
    }

    /**
     * Store a newly created Animal in storage.
     *
     * @param CreateAnimalRequest $request
     *
     * @return Response
     */
    public function store(CreateAnimalRequest $request)
    {
        $input = $request->all();
        //dd($input);
        $animal_plot = Animal::where('plot_id',$request->plot_id)->where('animal_category_id',$request->animal_category_id)->first();
        //dd($animal_plot);
        if($animal_plot){
            Flash::error('Animal already exists on this plot.');

            return redirect(route('animals.index'));

        }


        $animal = new Animal;
        $animal->total = $request->total;
        $animal->animal_category_id = $request->animal_category_id;
        $animal->plot_id = $request->plot_id;
        $animal->save();


        Flash::success('Animal saved successfully.');

        return redirect(route('animals.index'));
    }

    /**
     * Display the specified Animal.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $animal = $this->animalRepository->find($id);

        if (empty($animal)) {
            Flash::error('Animal not found');

            return redirect(route('animals.index'));
        }

        return view('animals.show')->with('animal', $animal);
    }

    /**
     * Show the form for editing the specified Animal.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $animal = $this->animalRepository->find($id);

        if (empty($animal)) {
            Flash::error('Animal not found');

            return redirect(route('animals.index'));
        }

        return view('animals.edit')->with('animal', $animal);
    }

    /**
     * Update the specified Animal in storage.
     *
     * @param int $id
     * @param UpdateAnimalRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAnimalRequest $request)
    {
        $animal = $this->animalRepository->find($id);

        if (empty($animal)) {
            Flash::error('Animal not found');

            return redirect(route('animals.index'));
        }

        $animal = $this->animalRepository->update($request->all(), $id);

        Flash::success('Animal updated successfully.');

        return redirect(route('animals.index'));
    }

    /**
     * Remove the specified Animal from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $animal = $this->animalRepository->find($id);

        if (empty($animal)) {
            Flash::error('Animal not found');

            return redirect(route('animals.index'));
        }

        $this->animalRepository->delete($id);

        Flash::success('Animal deleted successfully.');

        return redirect(route('animals.index'));
    }
}
