<?php


namespace App\DataTables;


use App\Models\TrainingVendorService;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;


class TrainingVendorServiceDataTable extends DataTable
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
        ->addColumn('action', 'training_vendor_services.datatables_actions')
        ->rawColumns(['image','action']);
    }


    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\TrainingVendorService $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(TrainingVendorService $model)
    {
        return $model->newQuery()->with(['vendor','vendor_category']);
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
            'charge',
            'access',
            'starting_date',
            'ending_date',
            'starting_time',
            'ending_time',
            'vendor'=> new \Yajra\DataTables\Html\Column(['title'=>"Vendor",'data'=>'vendor.username']),
            'contact'=> new \Yajra\DataTables\Html\Column(['title'=>"Contact",'data'=>'vendor.phone']),
            'is_verified' => new \Yajra\DataTables\Html\Column(['title'=>"Verified",'data'=>'is_verified'])
        ];
    }


    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'training_vendor_services_datatable_' . time();
    }
}


