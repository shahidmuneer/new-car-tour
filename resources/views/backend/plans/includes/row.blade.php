
<x-livewire-tables::bs4.table.cell>
    {{ $row->meta_title }}
</x-livewire-tables::bs4.table.cell>

<x-livewire-tables::bs4.table.cell>
    {!! $row->meta_description !!}
</x-livewire-tables::bs4.table.cell>

<x-livewire-tables::bs4.table.cell>
    {{ $row->price }}
</x-livewire-tables::bs4.table.cell>


<x-livewire-tables::bs4.table.cell>
    {{ $row->status }}
</x-livewire-tables::bs4.table.cell>

<x-livewire-tables::bs4.table.cell>
    @include('backend.plans.includes.actions', ['model' => $row])
</x-livewire-tables::bs4.table.cell>
