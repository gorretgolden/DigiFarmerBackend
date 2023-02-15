<?php

namespace App\DataTables;

use App\Models\SellerProduct;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class SellerProductDataTable extends DataTable
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
            return '<img src='.$data->image.' class="img-thumbnail"/>';

        })->rawColumns(['image', 'action'])
        ->addColumn('action', 'seller_products.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\SellerProduct $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(SellerProduct $model)
    {
        return $model->newQuery()->with(['user','seller_product_category']);
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
            'category'=> new \Yajra\DataTables\Html\Column(['title'=>"Category",'data'=>'seller_product_category.name']),
            'user'=> new \Yajra\DataTables\Html\Column(['title'=>"Farmer",'data'=>'user.username','username'=>'user.username']),
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
