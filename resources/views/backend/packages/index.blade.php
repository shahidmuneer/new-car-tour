@extends('backend.layouts.app')

@section('title', 'Package Management')

@section('content')
    <x-backend.card>
        <x-slot name="header">
            Package Management
        </x-slot>

        <x-slot name="headerActions">
            <x-utils.link icon="c-icon cil-plus" class="card-header-action" :href="route('packages.create')" text="Create Plans" />
        </x-slot>

        <x-slot name="body">
            <livewire:backend.package-table />
        </x-slot>
    </x-backend.card>
@endsection
