<?php

namespace App\Repositories;

use App\Models\Crop;
use App\Repositories\BaseRepository;

/**
 * Class CropRepository
 * @package App\Repositories
 * @version October 31, 2022, 8:52 am UTC
*/

class CropRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'farm_id',
        'category_id',
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
