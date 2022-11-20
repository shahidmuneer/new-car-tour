<?php

namespace App\Http\Livewire\Backend;

use App\Models\Package;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

/**
 * Class RolesTable.
 */
class PackageTable extends DataTableComponent
{
    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return Package::when($this->getFilter('search'), fn ($query, $term) => $query->search($term));
    }

    public function columns(): array
    {
        return [
            Column::make("id"),
            Column::make("Cover Photo")
                    ->sortable(),
            Column::make("Title")
                    ->sortable(),
            Column::make("Total Number of Cars")
                            ->sortable(),
            Column::make("Duration")
                    ->sortable(),
            Column::make("Available Times")
                            ->sortable(),
            Column::make("Single Seat Price")
                            ->sortable(),
            Column::make("Double Seat Price")
                    ->sortable(),
            Column::make("Guarrenttee Car Price")
                            ->sortable(),
            Column::make("Insurance Price")
                                            ->sortable(),
            Column::make(__('Actions')),
        ];
    }

    public function rowView(): string
    {
        return 'backend.packages.includes.row';
    }
}
