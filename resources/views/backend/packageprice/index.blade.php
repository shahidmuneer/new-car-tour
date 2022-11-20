@extends('backend.layouts.app')

@section('title', 'Package Price Management')

@section('content')
    <x-backend.card>
        <x-slot name="header">
            packageprice Management
        </x-slot>

        <x-slot name="headerActions">
            <x-utils.link icon="c-icon cil-plus" class="card-header-action" :href="route('packageprice.create')" text="Create Package Price" />
        </x-slot>

        <x-slot name="body">
            <livewire:backend.price-table />
        </x-slot>
    </x-backend.card>
@endsection
