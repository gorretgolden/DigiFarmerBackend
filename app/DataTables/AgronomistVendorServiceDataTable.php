<?php


namespace App\DataTables;


use App\Models\AgronomistVendorService;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;


class AgronomistVendorServiceDataTable extends DataTable
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


        return
        $dataTable->addColumn('image', function($data){
            return '<img src='.$data->image.'  class="img-thumbnail" />';


        })->
        addColumn('action', 'agronomist_vendor_services.datatables_actions')
        ->rawColumns(['image','action']);
    }


    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\AgronomistVendorService $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(AgronomistVendorService $model)
    {
        return $model->newQuery()->with('user','vendor_category');
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
            'charge_unit',
            'availability',
            'location',
            'user'=> new \Yajra\DataTables\Html\Column(['title'=>"Vendor",'data'=>'user.username']),
            'contact'=> new \Yajra\DataTables\Html\Column(['title'=>"Contact",'data'=>'user.phone']),
            'is_verified',
            'vendor_category'=> new \Yajra\DataTables\Html\Column(['title'=>"Vendor Category",'data'=>'vendor_category.name']),


        ];
    }


    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'agronomist_vendor_services_datatable_' . time();
    }
}
