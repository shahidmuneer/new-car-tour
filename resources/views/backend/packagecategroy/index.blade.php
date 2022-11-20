@extends('backend.layouts.app')

@section('title', 'Package Categroy Management')

@section('content')
    <x-backend.card>
        <x-slot name="header">
            Package Categroy Management
        </x-slot>

        <x-slot name="headerActions">
            <x-utils.link icon="c-icon cil-plus" class="card-header-action" :href="route('packagecategroy.create')"
                text="Create Package Categroy" />
        </x-slot>

        <x-slot name="body">
            <livewire:backend.packagecategroy-table />
        </x-slot>
    </x-backend.card>
@endsection
