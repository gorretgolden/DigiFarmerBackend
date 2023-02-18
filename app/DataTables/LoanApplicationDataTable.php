<?php

namespace App\DataTables;

use App\Models\LoanApplication;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class LoanApplicationDataTable extends DataTable
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

        return $dataTable->addColumn('action', 'loan_applications.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\LoanApplication $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(LoanApplication $model)
    {
        return $model->newQuery()->with(['user','finance_vendor_service']);
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
            'loan_number',
            'finance_vendor_service' => new \Yajra\DataTables\Html\Column(['title'=>"Finance Service",'data'=>'finance_vendor_service.name']),
            'user'=> new \Yajra\DataTables\Html\Column(['title'=>"Applicant",'data'=>'user.username']),
            'contact'=> new \Yajra\DataTables\Html\Column(['title'=>"Contact",'data'=>'user.phone']),
            'location',
            'gender',
            'dob',
            'age',
            'employment_status',
            'status',

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'loan_applications_datatable_' . time();
    }
}
