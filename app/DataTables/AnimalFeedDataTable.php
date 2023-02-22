<?php


namespace App\DataTables;


use App\Models\AnimalFeed;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;


class AnimalFeedDataTable extends DataTable
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


        })
        ->addColumn('action', 'animal_feeds.datatables_actions')
        ->rawColumns(['image','action']);
    }


    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\AnimalFeed $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(AnimalFeed $model)
    {
        return $model->newQuery()->with(['category','vendor','address']);
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
            'category'=> new \Yajra\DataTables\Html\Column(['title'=>"Category",'data'=>'category.name']),
            'price',
            'stock_amount' => new \Yajra\DataTables\Html\Column(['title'=>"Stock",'data'=>'stock_amount']),
            'weight',
            // 'weight_unit'=> new \Yajra\DataTables\Html\Column(['title'=>"Unit",'data'=>'weight_unit']),
            'status',
            'vendor'=> new \Yajra\DataTables\Html\Column(['title'=>"Vendor",'data'=>'vendor.username']),
            'contact'=> new \Yajra\DataTables\Html\Column(['title'=>"Contact",'data'=>'vendor.phone']),
            'location',
            'is_verified'=> new \Yajra\DataTables\Html\Column(['title'=>"Verified",'data'=>'is_verified']),




        ];
    }


    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'animal_feeds_datatable_' . time();
    }
}
