@inject('model', '\App\Domains\Auth\Models\User')

@extends('backend.layouts.app')

@section('title', "Create Plans")

@section('content')
    <x-forms.post :action="route('admin.auth.role.store')">
        <x-backend.card>
            <x-slot name="header">
                Create Plans
            </x-slot>

            <x-slot name="headerActions">
                <x-utils.link class="card-header-action" :href="route('admin.plans.list')" :text="__('Cancel')" />
            </x-slot>

            <x-slot name="body">
                <div x-data="{userType : '{{ $model::TYPE_USER }}'}">
                    <div class="form-group row">
                        <label for="name" class="col-md-2 col-form-label">Title</label>
                        <div class="col-md-10">
                        <input type="text" name="name" class="form-control" placeholder="Enter Title" value="{{ old('name') }}" maxlength="100" required />
                        </div>
                    </div><!--form-group-->

                    <div class="form-group row">
                        <label for="name" class="col-md-2 col-form-label">Description</label>

                        <div class="col-md-10">
                            <textarea name="description" class="form-control" placeholder="Enter Description" required >{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-md-2 col-form-label">Price</label>
                        <div class="col-md-10">
                        <input type="number" name="price" class="form-control" placeholder="Enter Price" value="{{ old('price') }}" maxlength="100" required />
                        </div>
                    </div><!--form-group-->

                    
                    <div class="form-group row">
                        <label for="name" class="col-md-2 col-form-label">Status</label>
                        <div class="col-md-10">
                        
                    <select name="type" class="form-control" required x-on:change="userType = $event.target.value">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                         </div>
                    </div><!--form-group-->

                    <div class="form-group row">
                        <label for="name" class="col-md-2 col-form-label">Category</label>
                        <div class="col-md-10">
                        
                    <select name="type" class="form-control" required x-on:change="userType = $event.target.value">
                                <option value="3H">3HR Tour</option>
                                <option value="5HR">5HR Tour</option>
                            </select>
                         </div>
                    </div><!--form-group-->

                    
                </div>
            </x-slot>

            <x-slot name="footer">
                <button class="btn btn-sm btn-primary float-right" type="submit">Create Plans</button>
            </x-slot>
        </x-backend.card>
    </x-forms.post>
@endsection
