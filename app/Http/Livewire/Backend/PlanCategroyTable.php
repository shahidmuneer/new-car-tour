<?php

namespace App\Http\Livewire\Backend;
use App\Models\Plan;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

/**
 * Class RolesTable.
 */
class PlansTable extends DataTableComponent
{
    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return Plan::when($this->getFilter('search'), fn ($query, $term) => $query->search($term));
    }

    public function columns(): array
    {
        return [
            Column::make("id"),
            Column::make("Name")
                ->sortable(),
            Column::make("Models")
                ->sortable(),

            Column::make(__('Actions')),
        ];
    }

    public function rowView(): string
    {
        return 'backend.plans.includes.row';
    }
}
