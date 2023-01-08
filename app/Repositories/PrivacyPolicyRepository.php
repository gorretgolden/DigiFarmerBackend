<?php

namespace App\Repositories;

use App\Models\PrivacyPolicy;
use App\Repositories\BaseRepository;

/**
 * Class PrivacyPolicyRepository
 * @package App\Repositories
 * @version December 20, 2022, 9:59 am CET
*/

class PrivacyPolicyRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'description'
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
        return PrivacyPolicy::class;
    }
}
