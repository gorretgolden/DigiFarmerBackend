<?php

namespace App\DataTables;

use App\Models\VendorService;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class VendorServiceDataTable extends DataTable
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
        return $dataTable->addColumn('image', function($data){
            return '<img src='.$data->image.' class="img-thumbnail w-75"/>';


        })
        ->addColumn('action', 'vendor_services.datatables_actions')
        ->rawColumns(['image','action']);


    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\VendorService $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(VendorService $model)
    {
        return $model->newQuery()->with(['sub_category','vendor'])->orderBy('id','DESC');
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
            'image',
            'name',
            'price_unit',
            'price',
             'charge',
          //  'description',
            // 'weight_unit',
            // 'stock_amount',
            'is_verified',
            // 'expertise',

            // 'charge_frequency',
            // 'zoom_details',
            'location',
            // 'starting_date',
            // 'ending_date',
            // 'starting_time',
            // 'ending_time',
            // 'principal',
            // 'interest_rate',
            // 'interest_rate_unit',
            // 'payment_frequency_pay',
            // 'simple_interest',
            // 'status',
            // 'total_amount_paid_back',
            // 'document_type',
            // 'terms',
            // 'loan_pay_back',
            // 'access',
            // 'loan_plan_id',
            'sub_category'=>new \Yajra\DataTables\Html\Column(['title'=>"Sub category",'data'=>'sub_category.name']),
            'vendor'=> new \Yajra\DataTables\Html\Column(['title'=>"Vendor",'data'=>'vendor.username'])
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'vendor_services_datatable_' . time();
    }
}
