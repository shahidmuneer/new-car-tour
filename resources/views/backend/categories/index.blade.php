@extends('backend.layouts.app')

@section('title', 'Category Management')

@section('content')
    <x-backend.card>
        <x-slot name="header">
            Category Management
        </x-slot>

        <x-slot name="headerActions">
            <x-utils.link icon="c-icon cil-plus" class="card-header-action" :href="route('category.create')" text="Create Category" />
        </x-slot>

        <x-slot name="body">
            <livewire:backend.categories-table />
        </x-slot>
    </x-backend.card>
@endsection
