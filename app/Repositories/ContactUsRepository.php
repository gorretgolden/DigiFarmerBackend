<?php

namespace App\Repositories;

use App\Models\ContactUs;
use App\Repositories\BaseRepository;

/**
 * Class ContactUsRepository
 * @package App\Repositories
 * @version December 19, 2022, 6:17 pm UTC
*/

class ContactUsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'subject',
        'message'
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
        return ContactUs::class;
    }
}
