<?php

namespace App\Repositories;

use App\Models\CropBuyer;
use App\Repositories\BaseRepository;

/**
 * Class CropBuyerRepository
 * @package App\Repositories
 * @version November 9, 2022, 11:28 pm UTC
*/

class CropBuyerRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'buying_price',
        'crop_on_sale_id',
        'status',
        'is_bought'
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
        return CropBuyer::class;
    }
}
