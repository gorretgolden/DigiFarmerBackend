<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateVendorCategoryAPIRequest;
use App\Http\Requests\API\UpdateVendorCategoryAPIRequest;
use App\Models\VendorCategory;
use App\Repositories\VendorCategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;


/**
 * Class VendorCategoryController
 * @package App\Http\Controllers\API
 */

class VendorCategoryAPIController extends AppBaseController
{
    /** @var  VendorCategoryRepository */
    private $vendorCategoryRepository;

    public function __construct(VendorCategoryRepository $vendorCategoryRepo)
    {
        $this->vendorCategoryRepository = $vendorCategoryRepo;
    }

    /**
     * Display a listing of the VendorCategory.
     * GET|HEAD /vendorCategories
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $vendorCategories = VendorCategory::where('enabled',1)->latest()->get(['id','name','image']);
        return $this->sendResponse($vendorCategories->toArray(), 'Vendor Categories retrieved successfully');
    }


    //get training vendor services
    public function vendor_training_services($id)
    {

        $vendor_category = VendorCategory::find($id);

        if (empty($vendor_category)) {

            return $this->sendError(' Vendor category not found');

        }else{

            $trainings = $vendor_category->training_vendor_services;
           // dd($trainings);
            $response = [
                'success'=>true,
                'data'=> [
                    'total-trainings' => $trainings->count(),
                    'training-vendor-services'=> $trainings

                ],
                'message'=> 'Training Vendor Service retrieved successfully'
             ];
             return response()->json($response,200);

        }


    }


    //get seller vendor products

    public function vendor_seller_products($id)
    {

        $vendor_category = VendorCategory::find($id);

        if (empty($vendor_category)) {

            return $this->sendError(' Vendor category not found');

        }else{

            $seller_products = $vendor_category->farm_equipments;
            //dd($seller_products);
            $response = [
                'success'=>true,
                'data'=> [
                    'total-services' => $seller_products->count(),
                    'farm-equipments-services'=> $seller_products

                ],
                'message'=> 'seller farm products retrieved successfully'
             ];
             return response()->json($response,200);

        }


    }

     //get animal feeds

     public function vendor_animal_feeds($id)
     {

         $vendor_category = VendorCategory::find($id);

         if (empty($vendor_category)) {

             return $this->sendError(' Vendor category not found');

         }else{

             $animal_feeds = $vendor_category->animal_feeds;
             //dd($animal_feeds);
             $response = [
                 'success'=>true,
                 'data'=> [
                     'total-animal-feeds' => $animal_feeds->count(),
                     'animal-feeds'=> $animal_feeds

                 ],
                 'message'=> 'animal feeds retrieved successfully'
              ];
              return response()->json($response,200);

         }


     }


     //rent services

     public function vendor_rent_services($id)
     {

         $vendor_category = VendorCategory::where('id',$id)->with('rent_vendors')->get();
         $rent_services =collect($vendor_category)->pluck('rent_vendors')[0];




        //maping through the collection to concatanate rent images
        $rent_services = $rent_services->map(function ($item){
            return collect([
                'id' => $item->id,
                'name' => $item->name,
                'location' => $item->location,
                'charge' => $item->charge . " ". "per day" ,
                'quantity' => $item->quantity,
                'days' => $item->charge_day,
                'total_charge' => $item->total_charge,
                'description' => $item->description,
                'vendor' => $item->vendor->username,
                'category' => $item->rent_vendor_sub_category->name,
                'created_at' => $item->created_at->format('d/m/Y'),

                'rent_images' => $item->images()->get()->map(function ($details){
                    return [
                        'id' => $details->id,
                        'url' => $details->url,

                    ];
                }),
            ]);
        });

       // dd($rent_services);




         if (empty($vendor_category)) {

             return $this->sendError(' Vendor category not found');

         }else{


             if($vendor_category->count()==0){
                $response = [
                    'success'=>true,
                    'message'=> 'No rent services posted yet '
                 ];
                 return response()->json($response,200);

             }else{
                $response = [
                    'success'=>true,
                    'data'=> [
                        'total-rent-services' => $rent_services->count(),
                        'rent-services'=> $rent_services,


                    ],
                    'message'=> 'rent services retrieved successfully'
                 ];
                 return response()->json($response,200);

             }



         }


     }

     //get insuarance services

     public function vendor_insuarances($id)
     {

         $vendor_category = VendorCategory::find($id);

         if (empty($vendor_category)) {

             return $this->sendError(' Vendor category not found');

         }else{

             $insuarance_services = $vendor_category->insuarance_vendors;
             //dd($insuarance_services);
             $response = [
                 'success'=>true,
                 'data'=> [
                     'total-insuarance-services' => $insuarance_services->count(),
                     'insuarance-services'=> $insuarance_services

                 ],
                 'message'=> 'insuarance services retrieved successfully'
              ];
              return response()->json($response,200);

         }


     }

     //get agronomist services
     public function vendor_agronomists($id)
     {

         $vendor_category = VendorCategory::find($id);

         if (empty($vendor_category)) {

             return $this->sendError(' Vendor category not found');

         }else{

             $agro_services = $vendor_category->agronomist_vendors;
             //dd(agronomist_vendors);
             $response = [
                 'success'=>true,
                 'data'=> [
                     'total-agronomist-services' => $agro_services->count(),
                     'agronomist-services'=> $agro_services

                 ],
                 'message'=> 'agronomist services retrieved successfully'
              ];
              return response()->json($response,200);

         }


     }


     //ge veterinary vendor services
     public function vet_services($id)
     {

         $vendor_category = VendorCategory::find($id);

         if (empty($vendor_category)) {

             return $this->sendError(' Vendor category not found');

         }else{

             $vet_services = $vendor_category->vet_services;
             //dd(agronomist_vendors);
             $response = [
                 'success'=>true,
                 'data'=> [
                     'total-vet-services' => $vet_services->count(),
                     'vet-services'=> $vet_services

                 ],
                 'message'=> 'vet services retrieved successfully'
              ];
              return response()->json($response,200);

         }


     }




     //get finance services
     public function finance_services($id)
     {

         $vendor_category = VendorCategory::find($id);

         if (empty($vendor_category)) {

             return $this->sendError(' Vendor category not found');

         }else{

             $finance_services = $vendor_category->finance_vendor_services;
             //dd(agronomist_vendors);
             $response = [
                 'success'=>true,
                 'data'=> [
                     'total-finance-services' => $finance_services->count(),
                     'finance-services'=> $finance_services

                 ],
                 'message'=> 'Finance services retrieved successfully'
              ];
              return response()->json($response,200);

         }


     }

    /**
     * Store a newly created VendorCategory in storage.
     * POST /vendorCategories
     *
     * @param CreateVendorCategoryAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateVendorCategoryAPIRequest $request)
    {
        $input = $request->all();

        $vendorCategory = $this->vendorCategoryRepository->create($input);

        return $this->sendResponse($vendorCategory->toArray(), 'Vendor Category saved successfully');
    }

    /**
     * Display the specified VendorCategory.
     * GET|HEAD /vendorCategories/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var VendorCategory $vendorCategory */
        $vendorCategory = $this->vendorCategoryRepository->find($id);

        if (empty($vendorCategory)) {
            return $this->sendError('Vendor Category not found');
        }

        return $this->sendResponse($vendorCategory->toArray(), 'Vendor Category retrieved successfully');
    }

    /**
     * Update the specified VendorCategory in storage.
     * PUT/PATCH /vendorCategories/{id}
     *
     * @param int $id
     * @param UpdateVendorCategoryAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateVendorCategoryAPIRequest $request)
    {
        $input = $request->all();

        /** @var VendorCategory $vendorCategory */
        $vendorCategory = $this->vendorCategoryRepository->find($id);

        if (empty($vendorCategory)) {
            return $this->sendError('Vendor Category not found');
        }

        $vendorCategory = $this->vendorCategoryRepository->update($input, $id);

        return $this->sendResponse($vendorCategory->toArray(), 'VendorCategory updated successfully');
    }

    /**
     * Remove the specified VendorCategory from storage.
     * DELETE /vendorCategories/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var VendorCategory $vendorCategory */
        $vendorCategory = $this->vendorCategoryRepository->find($id);

        if (empty($vendorCategory)) {
            return $this->sendError('Vendor Category not found');
        }

        $vendorCategory->delete();

        return $this->sendSuccess('Vendor Category deleted successfully');
    }
}
