@extends('backend.layouts.app')
@include('sweetalert::alert')
@section('title', 'Cars Modal Management')

@section('content')
    <x-backend.card>
        <x-slot name="header">
            Car Modal Management
        </x-slot>

        <x-slot name="headerActions">
            <x-utils.link icon="c-icon cil-plus" class="card-header-action" :href="route('modals.create')" text="Add Car Modal" />
        </x-slot>

        <x-slot name="body">
            <livewire:backend.modal-table />
        </x-slot>
    </x-backend.card>
@endsection
