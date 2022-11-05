<?php

namespace App\Repositories;

use App\Models\SellerProduct;
use App\Repositories\BaseRepository;

/**
 * Class SellerProductRepository
 * @package App\Repositories
 * @version November 4, 2022, 12:46 pm UTC
*/

class SellerProductRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description',
        'price',
        'seller_product_category_id',
        'image'
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
