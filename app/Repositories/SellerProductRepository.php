<?php

namespace App\Repositories;

use App\Models\SellerProduct;
use App\Repositories\BaseRepository;

/**
 * Class SellerProductRepository
 * @package App\Repositories
 * @version February 15, 2023, 1:01 pm CET
*/

class SellerProductRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'image',
        'price',
        'stock_amount',
        'is_verified',
        'status',
        'price_unit',
        'description',
        'seller_product_category_id',
        'vendor_category_id',
        'location',
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
        return SellerProduct::class;
    }
}
