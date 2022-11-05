<?php

namespace App\Repositories;

use App\Models\Crop;
use App\Repositories\BaseRepository;

/**
 * Class CropRepository
 * @package App\Repositories
 * @version November 4, 2022, 12:16 pm UTC
*/

class CropRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'standard_price',
        'sub_category_id',
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
        return Crop::class;
    }
}
