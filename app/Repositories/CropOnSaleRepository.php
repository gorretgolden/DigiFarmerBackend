<?php

namespace App\Repositories;

use App\Models\CropOnSale;
use App\Repositories\BaseRepository;

/**
 * Class CropOnSaleRepository
 * @package App\Repositories
 * @version December 29, 2022, 7:44 am CET
*/

class CropOnSaleRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'quantity',
        'selling_price',
        'price_unit',
        'description',
        'image',
        'is_sold',
        'crop_id',
        'user_id',
        'address_id'
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
