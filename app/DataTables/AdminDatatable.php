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
            ->addColumn('edit', 'admin.admins.btn.edit')
            ->addColumn('delete', 'admin.admins.btn.delete')
            ->rawColumns([
                'edit',
                'delete',
            ]);
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
            //->addAction(['width' => '80px'])
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
                'initComplete' => "function() {
                    this.api().columns([0,1,2,3,4]).every(function() {
                        var column = this;
                        var input = document.createElement('input');
                        $(input).appendTo($(column.footer()).empty())
                        .on('change', function() {
                            column.search($(this).val(), false, false, true).draw();
                        });
                    });
                }"
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
            [
                'name' => 'id',
                'data' => 'id',
                'title' => 'ID',
            ], [
                'name' => 'name',
                'data' => 'name',
                'title' => 'Admin Name',
            ], [
                'name' => 'email',
                'data' => 'email',
                'title' => 'Admin Email',
            ], [
                'name' => 'created_at',
                'data' => 'created_at',
                'title' => 'Created At',
            ], [
                'name' => 'updated_at',
                'data' => 'updated_at',
                'title' => 'Updated At',
            ], [
                'name' => 'edit',
                'data' => 'edit',
                'title' => 'Edit',
                'exportable' => false,
                'printable' => false,
                'orderable' => false,
                'searchable' => false,
            ], [
                'name' => 'delete',
                'data' => 'delete',
                'title' => 'Delete',
                'exportable' => false,
                'printable' => false,
                'orderable' => false,
                'searchable' => false,
            ],
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
