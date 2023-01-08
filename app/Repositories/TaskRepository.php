<?php

namespace App\Repositories;

use App\Models\Task;
use App\Repositories\BaseRepository;

/**
 * Class TaskRepository
 * @package App\Repositories
 * @version December 30, 2022, 10:42 am CET
*/

class TaskRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'task_date',
        'plot_id',
        'status_id'
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
        return Task::class;
    }
}
