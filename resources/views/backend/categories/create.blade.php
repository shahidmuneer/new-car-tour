@inject('model', '\App\Domains\Auth\Models\User')

@extends('backend.layouts.app')

@section('title', 'Create Category')

@section('content')
    <x-forms.post :action="route('category.store')">
        <x-backend.card>
            <x-slot name="header">
                Create Category
            </x-slot>

            <x-slot name="headerActions">
                <x-utils.link class="card-header-action" :href="route('category.index')" :text="__('Cancel')" />
            </x-slot>

            <x-slot name="body">
                <div x-data="{ userType: '{{ $model::TYPE_USER }}' }">
                    <div class="form-group row">
                        <label for="name" class="col-md-2 col-form-label">Title</label>
                        <div class="col-md-10">
                            <input type="text" name="meta_title" class="form-control" placeholder="Enter Title"
                                value="{{ old('name') }}" maxlength="100" required />
                        </div>
                    </div>
                    <!--form-group-->

                    <div class="form-group row">
                        <label for="name" class="col-md-2 col-form-label">Description</label>

                        <div class="col-md-10">
                            <textarea name="meta_description" class="form-control" placeholder="Enter Description" required>{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <!--form-group-->


                    <div class="form-group row">
                        <label for="name" class="col-md-2 col-form-label">Status</label>
                        <div class="col-md-10">

                            <select name="status" class="form-control" required
                                x-on:change="status = $event.target.value">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <!--form-group-->


                    <!--form-group-->


                </div>
            </x-slot>

            <x-slot name="footer">
                <button class="btn btn-sm btn-primary float-right" type="submit">Create Catrgory</button>
            </x-slot>
        </x-backend.card>
    </x-forms.post>
@endsection
