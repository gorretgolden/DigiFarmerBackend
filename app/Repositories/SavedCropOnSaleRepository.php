<?php

namespace App\Repositories;

use App\Models\SavedCropOnSale;
use App\Repositories\BaseRepository;

/**
 * Class SavedCropOnSaleRepository
 * @package App\Repositories
 * @version January 17, 2023, 2:04 pm CET
*/

class SavedCropOnSaleRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
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
        return SavedCropOnSale::class;
    }
}
