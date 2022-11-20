<?php

namespace App\Http\Livewire\Backend;

use App\Models\Car;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

/**
 * Class RolesTable.
 */
class CarsTable extends DataTableComponent
{
    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return Car::when($this->getFilter('search'), fn ($query, $term) => $query->search($term));
    }

    public function columns(): array
    {
        return [
            Column::make("id"),
            Column::make("Name")
                ->sortable(),
            Column::make("Model")
                ->sortable(),
            Column::make("Top Speed")
                        ->sortable(),
            Column::make("Power")
                    ->sortable(),
            Column::make("Accelaration Time")
                            ->sortable(),
            Column::make("Price")
                    ->sortable(),
            Column::make("Acceleration")
                            ->sortable(),
            Column::make("Control")
                            ->sortable(),
            Column::make("Overall")
                            ->sortable(),
            Column::make(__('Actions')),
        ];
    }

    public function rowView(): string
    {
        return 'backend.cars.includes.row';
    }
}
