<?php

namespace App\Repositories;

use App\Models\AnimalFeed;
use App\Repositories\BaseRepository;

/**
 * Class AnimalFeedRepository
 * @package App\Repositories
 * @version November 29, 2022, 11:45 am UTC
*/

class AnimalFeedRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'animal_feed_sub_category_id',
        'price',
        'price_unit',
        'description',
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
        return AnimalFeed::class;
    }
}
