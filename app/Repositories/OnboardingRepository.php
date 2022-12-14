<?php

namespace App\Repositories;

use App\Models\Onboarding;
use App\Repositories\BaseRepository;

/**
 * Class OnboardingRepository
 * @package App\Repositories
 * @version December 12, 2022, 7:08 am UTC
*/

class OnboardingRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'description',
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
        return Onboarding::class;
    }
}
