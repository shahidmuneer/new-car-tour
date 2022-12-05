


<x-livewire-tables::bs4.table.cell>
    {{ $row->id }}
</x-livewire-tables::bs4.table.cell>


<x-livewire-tables::bs4.table.cell>
    {{ $row->cover_photo }}
</x-livewire-tables::bs4.table.cell>


<x-livewire-tables::bs4.table.cell>
    {{ $row->title }}
</x-livewire-tables::bs4.table.cell>

<x-livewire-tables::bs4.table.cell>
    {!! $row->number_of_cars !!}
</x-livewire-tables::bs4.table.cell>

<x-livewire-tables::bs4.table.cell>
    {{ $row->duration }}
</x-livewire-tables::bs4.table.cell>


<x-livewire-tables::bs4.table.cell>
    {{ $row->available_times }}
</x-livewire-tables::bs4.table.cell>


<x-livewire-tables::bs4.table.cell>
    {{ $row->single_seat_price }}
</x-livewire-tables::bs4.table.cell>



<x-livewire-tables::bs4.table.cell>
    {{ $row->double_seat_price }}
</x-livewire-tables::bs4.table.cell>


<x-livewire-tables::bs4.table.cell>
    {{ $row->guarranttee_car_price }}
</x-livewire-tables::bs4.table.cell>


<x-livewire-tables::bs4.table.cell>
    {{ $row->insurance_price }}
</x-livewire-tables::bs4.table.cell>



<x-livewire-tables::bs4.table.cell>
    @include('backend.packages.includes.actions', ['model' => $row])
</x-livewire-tables::bs4.table.cell>
