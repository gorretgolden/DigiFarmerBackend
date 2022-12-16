<?php

namespace App\DataTables;

use App\Models\FinanceVendorService;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class FinaceVendorServiceDataTable extends DataTable
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

        return $dataTable->addColumn('action', 'finace_vendor_services.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\FinaceVendorService $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(FinanceVendorService $model)
    {
        return $model->newQuery()->with(['vendor_category','user','loan_plan','loan_pay_back']);
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
            'name',
            'principal',
            'interest_rate',
            'interest_rate_unit',
            'payment_frequency_pay',
            'status',
            'simple_interest',
            'total_amount_paid_back',
            'vendor_category'=> new \Yajra\DataTables\Html\Column(['title'=>"Vendor Category",'data'=>'vendor_category.name']),
            'user'=> new \Yajra\DataTables\Html\Column(['title'=>"Vendor",'data'=>'user.username']),
            'loan_Plan'=> new \Yajra\DataTables\Html\Column(['title'=>"Loan Plan",'data'=>'loan_plan.value','loan_plan.period_unit']),
            'loan_pay_back_id' => new \Yajra\DataTables\Html\Column(['title'=>"Pay Back Period",'data'=>'loan_pay_back.name','loan_pay_back.name'])
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'finace_vendor_services_datatable_' . time();
    }
}
