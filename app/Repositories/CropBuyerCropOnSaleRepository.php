<?php

namespace App\Repositories;

use App\Models\CropBuyerCropOnSale;
use App\Repositories\BaseRepository;

/**
 * Class CropBuyerCropOnSaleRepository
 * @package App\Repositories
 * @version November 20, 2022, 12:52 pm UTC
*/

class CropBuyerCropOnSaleRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'crop_on_sale_id',
        'crop_buyer_id'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CropBuyerCropOnSale::class;
    }
}
