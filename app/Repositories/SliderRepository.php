<?php

namespace App\Repositories;

use App\Models\Slider;
use App\Repositories\BaseRepository;

/**
 * Class SliderRepository
 * @package App\Repositories
 * @version November 4, 2022, 12:05 pm UTC
*/

class SliderRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
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
        return Slider::class;
    }
}
