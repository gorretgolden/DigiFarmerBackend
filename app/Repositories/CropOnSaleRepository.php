<?php

namespace App\Repositories;

use App\Models\CropOnSale;
use App\Repositories\BaseRepository;

/**
 * Class CropOnSaleRepository
 * @package App\Repositories
 * @version November 9, 2022, 11:04 pm UTC
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
        'status',
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
