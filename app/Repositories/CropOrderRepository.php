<?php

namespace App\Repositories;

use App\Models\CropOrder;
use App\Repositories\BaseRepository;

/**
 * Class CropOrderRepository
 * @package App\Repositories
 * @version November 26, 2022, 7:00 pm UTC
*/

class CropOrderRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'is_paid',
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
