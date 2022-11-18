<?php

namespace App\Repositories;

use App\Models\FarmerBuySellerProduct;
use App\Repositories\BaseRepository;

/**
 * Class FarmerBuySellerProductRepository
 * @package App\Repositories
 * @version November 18, 2022, 1:18 am UTC
*/

class FarmerBuySellerProductRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'is_product_bought',
        'seller_product_id',
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
        return FarmerBuySellerProduct::class;
    }
}
