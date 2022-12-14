<?php

namespace App\Repositories;

use App\Models\UserVerification;
use App\Repositories\BaseRepository;

/**
 * Class UserVerificationRepository
 * @package App\Repositories
 * @version December 14, 2022, 8:49 am UTC
*/

class UserVerificationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'image',
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
        return UserVerification::class;
    }
}
