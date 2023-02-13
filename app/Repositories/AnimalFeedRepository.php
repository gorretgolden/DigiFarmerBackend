<?php

namespace App\Repositories;

use App\Models\AnimalFeed;
use App\Repositories\BaseRepository;

/**
 * Class AnimalFeedRepository
 * @package App\Repositories
 * @version February 8, 2023, 8:44 pm CET
*/

class AnimalFeedRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'price',
        'price_unit',
        'weight',
        'weight_unit',
        'stock_amount',
        'location',
        'image',
        'description',
        'status',
        'is_verified',
        'user_id',
        'animal_feed_category_id',
        'vendor_category_id'
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
