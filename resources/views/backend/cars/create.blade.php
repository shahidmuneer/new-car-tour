@inject('model', '\App\Domains\Auth\Models\User')

@extends('backend.layouts.app')

@section('title', 'Create Cars')

@section('content')
    <x-forms.post :action="route('cars.store')">
        <x-backend.card>
            <x-slot name="header">
                Create Cars
            </x-slot>

            <x-slot name="headerActions">
                <x-utils.link class="card-header-action" :href="route('cars.index')" :text="__('Cancel')" />
            </x-slot>

            <x-slot name="body">
                <div x-data="{ userType: '{{ $model::TYPE_USER }}' }">
                    <div class="form-group row">
                        <label for="name" class="col-md-2 col-form-label">Title</label>
                        <div class="col-md-10">
                            <input type="text" name="title" class="form-control" placeholder="Enter Title"
                                value="{{ old('name') }}" maxlength="100" required />
                        </div>
                    </div>
                    <!--form-group-->

                    <div class="form-group row">
                        <label for="name" class="col-md-2 col-form-label">Model</label>
                    
                        <div class="col-md-10">

                            <select name="model" class="form-control" required
                                x-on:change="model = $event.target.value">
                            @foreach($modals as $key=>$modal)
                                <option value="{{$modal->id}}">{{$modal->name}}</option>
                            @endforeach
                            </select>
                    </div>

                    </div>


                    <!--form-group-->
                    <div class="form-group row">
                        <label for="top_speed" class="col-md-2 col-form-label">Top Speed</label>
                        <div class="col-md-10">
                            <input type="number" name="top_speed" class="form-control" placeholder="Enter Top Speed"
                                value="{{ old('top_speed') }}" maxlength="999" required />
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="power" class="col-md-2 col-form-label">Power</label>
                        <div class="col-md-10">
                            <input type="number" name="power" class="form-control" placeholder="Enter Hourse Power of the Car"
                                value="{{ old('power') }}" maxlength="999" required />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="accelaration_time" class="col-md-2 col-form-label">Accelaration Time</label>
                        <div class="col-md-10">
                            <input type="text" name="accelaration_time" class="form-control" placeholder="Enter Accelaration Time"
                                value="{{ old('accelaration_time') }}" maxlength="999" required />
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="price" class="col-md-2 col-form-label">Price</label>
                        <div class="col-md-10">
                            <input type="text" name="price" class="form-control" placeholder="Enter Price"
                                value="{{ old('price') }}" maxlength="999" required />
                        </div>
                    </div>
                    

                    
                    <div class="form-group row">
                        <label for="accelaration" class="col-md-2 col-form-label">Accelaration</label>
                        <div class="col-md-10">
                            <input type="text" name="accelaration" class="form-control" placeholder="Enter Accelaration"
                                value="{{ old('accelaration') }}" maxlength="999" required />
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="control" class="col-md-2 col-form-label">Control/Suspetion/Stearing Response</label>
                        <div class="col-md-10">
                            <input type="text" name="control" class="form-control" placeholder="Enter Control/Suspetion/Stearing Response"
                                value="{{ old('control') }}" maxlength="999" required />
                        </div>
                    </div>


                    
                    <div class="form-group row">
                        <label for="overall" class="col-md-2 col-form-label">Overall Performance</label>
                        <div class="col-md-10">
                            <input type="number" name="overall" class="form-control" placeholder="Enter Overall Performance"
                                value="{{ old('overall') }}" maxlength="999" required />
                        </div>
                    </div>

                    
                    <div class="form-group row">
                        <label for="control" class="col-md-2 col-form-label">Control/Suspetion/Stearing Response</label>
                        <div class="col-md-10">
                            <input type="text" name="control" class="form-control" placeholder="Enter Control/Suspetion/Stearing Response"
                                value="{{ old('control') }}" maxlength="999" required />
                        </div>
                    </div>

                    

                </div>
            </x-slot>

            <x-slot name="footer">
                <button class="btn btn-sm btn-primary float-right" type="submit">Create Cars</button>
            </x-slot>
        </x-backend.card>
    </x-forms.post>
@endsection
