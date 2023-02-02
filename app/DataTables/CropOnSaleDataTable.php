<?php

namespace App\DataTables;

use App\Models\CropOnSale;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class CropOnSaleDataTable extends DataTable
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

        return $dataTable->addColumn('image', function (CropOnSale $crop_on_sale) {
            $url=asset("storage/crops_on_sale/$crop_on_sale->image");
            return '<img src='.$url.' border="0" width="40" class="img-rounded" align="center" />';

        })->rawColumns(['image', 'action']);

    }
    /**
     * Get query source of dataTable.
     *   })->addColumn('action', 'crop_on_sales.datatables_actions')->
     * @param \App\Models\CropOnSale $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(CropOnSale $model)
    {
        return $model->newQuery()->with(['user','crop']);
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
            'quantity',
            'quantity_unit',
            'selling_price',
            'price_unit',
            'is_sold',
            'crop'=> new \Yajra\DataTables\Html\Column(['title'=>"Crop",'data'=>'crop.name','email'=>'crop.name']),
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
        return 'crop_on_sales_datatable_' . time();
    }
}
