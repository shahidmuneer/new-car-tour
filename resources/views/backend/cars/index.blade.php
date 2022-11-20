@extends('backend.layouts.app')
@include('sweetalert::alert')
@section('title', 'Cars Management')

@section('content')
    <x-backend.card>
        <x-slot name="header">
            Cars Management
        </x-slot>

        <x-slot name="headerActions">
            <x-utils.link icon="c-icon cil-plus" class="card-header-action" :href="route('cars.create')" text="Add Car" />
        </x-slot>

        <x-slot name="body">
            <livewire:backend.cars-table />
        </x-slot>
    </x-backend.card>
@endsection
