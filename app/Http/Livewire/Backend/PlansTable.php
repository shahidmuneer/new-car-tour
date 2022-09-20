<?php

namespace App\Http\Livewire\Backend;

use App\Domains\Auth\Models\Plans;
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
        return Plans::when($this->getFilter('search'), fn ($query, $term) => $query->search($term));
    }

    public function columns(): array
    {
        return [
            Column::make("Meta Title")
                ->sortable(),
            Column::make("Meta Description")
                ->sortable(),
            Column::make("Price"),
            Column::make("Status")
                ->sortable(),
            Column::make(__('Actions')),
        ];
    }

    public function rowView(): string
    {
        return 'backend.plans.includes.row';
    }
}
