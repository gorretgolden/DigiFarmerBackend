<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCropRequest;
use App\Http\Requests\UpdateCropRequest;
use App\Repositories\CropRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use App\Models\Crop;
use Illuminate\Support\Facades\File;

class CropController extends AppBaseController
{
    /** @var CropRepository $cropRepository*/
    private $cropRepository;

    public function __construct(CropRepository $cropRepo)
    {
        $this->cropRepository = $cropRepo;
    }

    /**
     * Display a listing of the Crop.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $crops = Crop::latest()->paginate(6);

        return view('crops.index')
            ->with('crops', $crops);
    }

    /**
     * Show the form for creating a new Crop.
     *
     * @return Response
     */
    public function create()
    {
        return view('crops.create');
    }

    /**
     * Store a newly created Crop in storage.
     *
     * @param CreateCropRequest $request
     *
     * @return Response
     */
    public function store(CreateCropRequest $request)
    {
         //existing crop
         $existing_crop = Crop::where('name',$request->name)->first();

         if(!$existing_crop){
            $request->validate(Crop::$rules);
            $new_crop = new Crop();
            $new_crop->name = $request->name;
            $new_crop->is_active = $request->is_active;
            $new_crop->standard_price = $request->standard_price;
            $new_crop->category_id = $request->category_id;
            $new_crop->image = $request->image;
            $new_crop->price_unit = $request->price_unit;
            $new_crop->save();

            $new_crop = Crop::find($new_crop->id);

            $new_crop->image = \App\Models\ImageUploader::upload($request->file('image'),'crops');
            $new_crop->save();

            Flash::success('Crop saved successfully.');
         }
         else{
            Flash::error('Crop already exists');
         }



        return redirect(route('crops.index'));
    }

    /**
     * Display the specified Crop.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $crop = $this->cropRepository->find($id);

        if (empty($crop)) {
            Flash::error('Crop not found');

            return redirect(route('crops.index'));
        }

        return view('crops.show')->with('crop', $crop);
    }

    /**
     * Show the form for editing the specified Crop.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $crop = $this->cropRepository->find($id);

        if (empty($crop)) {
            Flash::error('Crop not found');

            return redirect(route('crops.index'));
        }

        return view('crops.edit')->with('crop', $crop);
    }

    /**
     * Update the specified Crop in storage.
     *
     * @param int $id
     * @param UpdateCropRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCropRequest $request)
    {
        $crop = Crop::find($id);

        if (empty($crop)) {
            Flash::error('Crop not found');

            return redirect(route('crops.index'));
        }

        if($crop){

            $crop->name = $request->name;
            $crop->category_id = $request->category_id;
            $crop->standard_price = $request->standard_price;
            $crop->price_unit = $request->price_unit;
            $crop->is_active = $request->is_active;

            if(!empty($request->file('image'))){
                File::delete('storage/crops/'.$category->image);
                $crop->image = \App\Models\ImageUploader::upload($request->file('image'),'crops');
                $crop->save();
            }else{
                $crop->image = $request->image;
            }


        }

        Flash::success('Crop updated successfully.');

        return redirect(route('crops.index'));
    }

    /**
     * Remove the specified Crop from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $crop = $this->cropRepository->find($id);

        if (empty($crop)) {
            Flash::error('Crop not found');

            return redirect(route('crops.index'));
        }

        $this->cropRepository->delete($id);

        Flash::success('Crop deleted successfully.');

        return redirect(route('crops.index'));
    }
}
