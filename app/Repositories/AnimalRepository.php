<?php

namespace App\Repositories;

use App\Models\Animal;
use App\Repositories\BaseRepository;

/**
 * Class AnimalRepository
 * @package App\Repositories
 * @version December 1, 2022, 12:56 pm UTC
*/

class AnimalRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'animal_category_id',
        'plot_id',
        'total'
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
        return Animal::class;
    }
}
