<?php

namespace App\DataTables;

use App\Models\Admin;
use Yajra\DataTables\Services\DataTable;

class AdminDatatable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
            ->addColumn('action', 'admindatatable.action');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return Admin::query();
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
            ->addAction(['width' => '80px'])
            //->parameters($this->getBuilderParameters())
            ->parameters([
                'dom' => '<"datatable-buttons-container"B>lfrtip',
                //'dom' => 'Bl<"pull-right"f>rtip',
                'lengthMenu' => [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, 'All'],
                ],
                'buttons' => [
                    [
                        'extend' => 'print',
                        'className' => 'btn btn-primary',
                        'text' => '<i class="fa fa-print"></i>'
                    ],
                    [
                        'extend' => 'csvHtml5',
                        'className' => 'btn btn-info',
                        'text' => '<i class="fa fa-file space-right"></i>Export CSV'
                    ],
                    [
                        'extend' => 'excelHtml5',
                        'className' => 'btn btn-success',
                        'text' => '<i class="fa fa-file space-right"></i>Export Excel'
                    ],
                    [
                        'text' => '<i class="fa fa-plus space-right"></i>' . trans('admin.create_admin'),
                        'className' => 'btn btn-danger',
                    ]
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
            'id',
            'name',
            'email',
            'created_at',
            'updated_at'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Admin_' . date('YmdHis');
    }
}
