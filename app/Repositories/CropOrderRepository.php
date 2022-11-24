<?php

namespace App\Repositories;

use App\Models\CropOrder;
use App\Repositories\BaseRepository;

/**
 * Class CropOrderRepository
 * @package App\Repositories
 * @version November 23, 2022, 10:03 am UTC
*/

class CropOrderRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'buying_price',
        'has_brought',
        'is_accepted',
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
        return CropOrder::class;
    }
}
