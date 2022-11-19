<?php

namespace App\Repositories;

use App\Models\CropBuyer;
use App\Repositories\BaseRepository;

/**
 * Class CropBuyerRepository
 * @package App\Repositories
 * @version November 19, 2022, 11:23 am UTC
*/

class CropBuyerRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'buying_price',
        'has_bought',
        'contact_one',
        'contact_two',
        'email',
        'is_accepted',
        'crop_on_sale_id',
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
        return CropBuyer::class;
    }
}
