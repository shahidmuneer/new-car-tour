@extends('backend.layouts.app')

@section('title', "Plans Management")

@section('content')
    <x-backend.card>
        <x-slot name="header">
            Plan Management 
        </x-slot>

        <x-slot name="headerActions">
            <x-utils.link
                icon="c-icon cil-plus"
                class="card-header-action"
                :href="route('admin.plans.list.create')"
                text="Create Plans"
            />
        </x-slot>

        <x-slot name="body">
            <livewire:backend.plans-table />
        </x-slot>
    </x-backend.card>
@endsection
