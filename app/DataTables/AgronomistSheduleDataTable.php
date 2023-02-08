<?php

namespace App\DataTables;

use App\Models\AgronomistShedule;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class AgronomistSheduleDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable->addColumn('action', 'agronomist_shedules.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\AgronomistShedule $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(AgronomistShedule $model)
    {
        return $model->newQuery()->with(['agronomist_vendor_service','day']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '120px', 'printable' => false])
            ->parameters([
                'dom'       => 'Bfrtip',
                'stateSave' => true,
                'order'     => [[0, 'desc']],
                'buttons'   => [
                    ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'reset', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'reload', 'className' => 'btn btn-default btn-sm no-corner',],
                ],
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id',
            'agronomist_vendor_service'=>new \Yajra\DataTables\Html\Column(['title'=>"Agronomist Service",'data'=>'agronomist_vendor_service.name']),
            'date',
            'starting_time',
            'ending_time',
            'time_interval'

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'agronomist_shedules_datatable_' . time();
    }
}