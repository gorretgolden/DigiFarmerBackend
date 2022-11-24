<?php

namespace App\Repositories;

use App\Models\CropOder;
use App\Repositories\BaseRepository;

/**
 * Class CropOderRepository
 * @package App\Repositories
 * @version November 23, 2022, 9:37 am UTC
*/

class CropOderRepository extends BaseRepository
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
        return CropOder::class;
    }
}
