@inject('model', '\App\Domains\Auth\Models\User')

@extends('backend.layouts.app')

@section('title', 'Create Cars')

@section('content')
    <x-forms.post :action="route('update_modals',$id)">
        <x-backend.card>
            <x-slot name="header">
                Edit Car Model
            </x-slot>

            <x-slot name="headerActions">
                <x-utils.link class="card-header-action" :href="route('modals.index')" :text="__('Cancel')" />
            </x-slot>

            <x-slot name="body">
                <div x-data="{ userType: '{{ $model::TYPE_USER }}' }">
                    <div class="form-group row">
                        <label for="name" class="col-md-2 col-form-label">Name</label>
                        <div class="col-md-10">
                            <input type="text" name="name" class="form-control" placeholder="Enter Name"
                                   value="{{ $name }}" maxlength="100" required />
                        </div>
                    </div>
                    <!--form-group-->



                </div>
            </x-slot>

            <x-slot name="footer">
                <button class="btn btn-sm btn-primary float-right" type="submit">Update Cars Modal</button>
            </x-slot>
        </x-backend.card>
    </x-forms.post>
@endsection
