<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
    protected $model;
    protected $title;
    protected $indexRoute;

    public function __construct(User $model)
    {
        $this->model = $model;
        $this->title = trans('admin_fields.user');
        $this->indexRoute = 'users';
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('serial', fn($q) => request()->get('start', 0) + ++$this->rowIndex)
            ->editColumn('status', fn($q) => $q->status == 1 ? '<span class="badge bg-success">' . trans('admin_fields.active') . '</span>' : '<span class="badge bg-danger">' . trans('admin_fields.inactive') . '</span>')
            ->addColumn('action', function ($q) {
                return view('backend.common.actions', [
                    'id' => $q->id,
                    'title' => $this->title,
                    'route' => $this->indexRoute
                ])->render();
            })
            ->rawColumns(['status', 'action']);
    }

    public function query(): QueryBuilder
    {
        return $this->model->newQuery();
    }

    public function html(): HtmlBuilder
    {
        $buttons = [
            Button::make('excel'),
            Button::make('csv'),
            Button::make('print'),
            Button::make('reload')
        ];
        return $this->builder()
            ->setTableId('datatable-' . $this->indexRoute)
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->buttons($buttons);
    }

    public function getColumns(): array
    {
        return [
            Column::computed('serial')->title('#'),
            Column::make('name')->title(trans('admin_fields.name')),
            Column::make('status')->title(trans('admin_fields.status')),
            Column::computed('action')->title(trans('admin_fields.action'))->exportable(false)->printable(false),
        ];
    }

    protected function filename(): string
    {
        return $this->title . '_' . date('YmdHis');
    }
}
