<?php

namespace App\Repositories;

use App\Models\GeneralSetting;
use App\Repositories\BaseRepository;

/**
 * Class GeneralSettingRepository
 * @package App\Repositories
 * @version January 7, 2023, 8:42 am CET
*/

class GeneralSettingRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'commission',
        'commission_unit',
        'app_name',
        'currency_unit'
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
        return GeneralSetting::class;
    }
}
