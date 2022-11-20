<?php

namespace App\Http\Livewire\Backend;

use App\Models\PackagePrice;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

/**
 * Class RolesTable.
 */
class PriceTable extends DataTableComponent
{
    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return PackagePrice::when($this->getFilter('search'), fn ($query, $term) => $query->search($term));
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
        return 'backend.packageprice.includes.row';
    }
}
