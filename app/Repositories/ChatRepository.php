<?php

namespace App\Repositories;

use App\Models\Chat;
use App\Repositories\BaseRepository;

/**
 * Class ChatRepository
 * @package App\Repositories
 * @version December 17, 2022, 8:32 am UTC
*/

class ChatRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'is_private',
        'created_by'
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
        return Chat::class;
    }
}
