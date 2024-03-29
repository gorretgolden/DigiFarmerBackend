<?php

namespace App\DataTables;

use App\Models\RentVendorService;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class RentVendorServiceDataTable extends DataTable
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
            return '<img src='.$data->image.'  class="img-thumbnail"/>';

        })->addColumn('action', 'rent_vendor_services.datatables_actions')
        ->rawColumns(['image','action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\RentVendorService $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(RentVendorService $model)
    {
        return $model->newQuery()->with(['rent_vendor_sub_category','vendor']);
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
            'rent_vendor_sub_category'=> new \Yajra\DataTables\Html\Column(['title'=>"Sub Category",'data'=>'rent_vendor_sub_category.name']),
            'charge',
            'charge_frequency',
            'location',
             'quantity',
            'status',
            'vendor'=> new \Yajra\DataTables\Html\Column(['title'=>"Vendor",'data'=>'vendor.username']),

            'is_verified' => new \Yajra\DataTables\Html\Column(['title'=>"Verified",'data'=>'is_verified']),



        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'rent_vendor_services_datatable_' . time();
    }
}
