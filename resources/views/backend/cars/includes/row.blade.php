<x-livewire-tables::bs4.table.cell>
    {{ $row->id }}
</x-livewire-tables::bs4.table.cell>
<x-livewire-tables::bs4.table.cell>
    {{ $row->title }}
</x-livewire-tables::bs4.table.cell>

<x-livewire-tables::bs4.table.cell>
    {!! $row->model !!}
</x-livewire-tables::bs4.table.cell>


<x-livewire-tables::bs4.table.cell>
    {!! $row->top_speed !!}
</x-livewire-tables::bs4.table.cell>


<x-livewire-tables::bs4.table.cell>
    {!! $row->power !!}
</x-livewire-tables::bs4.table.cell>



<x-livewire-tables::bs4.table.cell>
    {!! $row->accelaration_time !!}
</x-livewire-tables::bs4.table.cell>



<x-livewire-tables::bs4.table.cell>
    {!! $row->price !!}
</x-livewire-tables::bs4.table.cell>


<x-livewire-tables::bs4.table.cell>
    {!! $row->accelaration !!}
</x-livewire-tables::bs4.table.cell>


<x-livewire-tables::bs4.table.cell>
    {!! $row->control !!}
</x-livewire-tables::bs4.table.cell>


<x-livewire-tables::bs4.table.cell>
    {!! $row->overall !!}
</x-livewire-tables::bs4.table.cell>



<x-livewire-tables::bs4.table.cell>
    @include('backend.cars.includes.actions', ['model' => $row])
</x-livewire-tables::bs4.table.cell>
