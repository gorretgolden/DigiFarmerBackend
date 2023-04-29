<?php

namespace App\DataTables;

use App\Models\VendorService;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

use DB;

class SellerProductDataTable extends DataTable
{

    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);


        return $dataTable->addColumn('image', function($data){
            return '<img src='.$data->image.' class="img-thumbnail"/>';

        })->rawColumns(['image', 'action'])
        ->addColumn('action', 'seller_products.datatables_actions');
    }


    public function query(VendorService $model)
    {



        return $model->newQuery()->with(['vendor','sub_category']);
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
            'stock_amount',
            'is_verified',
            'status',
            'category'=> new \Yajra\DataTables\Html\Column(['title'=>"Category",'data'=>'sub_category.name']),
            'vendor'=> new \Yajra\DataTables\Html\Column(['title'=>"Vendor",'data'=>'vendor.username']),
            'location'

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'seller_products_datatable_' . time();
    }
}
