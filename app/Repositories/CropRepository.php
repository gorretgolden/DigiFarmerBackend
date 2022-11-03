<?php

namespace App\Repositories;

use App\Models\Crop;
use App\Repositories\BaseRepository;

/**
 * Class CropRepository
 * @package App\Repositories
 * @version November 3, 2022, 7:20 pm UTC
*/

class CropRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'standard_price',
        'image',
        'sub_category_id'
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
        return Crop::class;
    }
}
