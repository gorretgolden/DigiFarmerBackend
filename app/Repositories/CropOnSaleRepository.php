<?php

namespace App\Repositories;

use App\Models\CropOnSale;
use App\Repositories\BaseRepository;

/**
 * Class CropOnSaleRepository
 * @package App\Repositories
 * @version November 19, 2022, 9:54 am UTC
*/

class CropOnSaleRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'quantity',
        'quantity_unit',
        'selling_price',
        'price_Uunit',
        'description',
        'image',
        'is_sold',
        'crop_id',
        'user_id'
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
        return CropOnSale::class;
    }
}
