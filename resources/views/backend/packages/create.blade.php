@inject('model', '\App\Domains\Auth\Models\User')

@extends('backend.layouts.app')

@section('title', 'Create Package')

@section('content')
    <x-forms.post :action="route('packages.store')">
        <x-backend.card>
            <x-slot name="header">
                Create Package
            </x-slot>

            <x-slot name="headerActions">
                <x-utils.link class="card-header-action" :href="route('packages.index')" :text="__('Cancel')" />
            </x-slot>

            <x-slot name="body">
                <div x-data="{ userType: '{{ $model::TYPE_USER }}' }">
                    <div class="form-group row">
                        <label for="title" class="col-md-2 col-form-label">Title</label>
                        <div class="col-md-10">
                            <input type="text" name="title" class="form-control" placeholder="Enter Title"
                                value="{{ old('title') }}" maxlength="100" required />
                        </div>
                    </div>

                    
                    <div class="form-group row">
                        <label for="number_of_cars" class="col-md-2 col-form-label">Number of Cars</label>
                        <div class="col-md-10">
                            <input type="text" name="number_of_cars" class="form-control" placeholder="Enter Number of Cars"
                                value="{{ old('number_of_cars') }}" maxlength="100" required />
                        </div>
                    </div>
                    <!--form-group-->



                    <div class="form-group row">
                        <label for="name" class="col-md-2 col-form-label">Duration</label>
                        <div class="col-md-10">

                            <select name="duration" class="form-control" required
                                x-on:change="duration = $event.target.value">
                                <option value="3 Hours">3 Hours Tour </option>
                                <option value="7 Hours">7 Hours Tour</option>
                            </select>
                        </div>
                    </div>
                    <!--form-group-->

                    
                    
                    <div class="form-group row">
                        <label for="availalable_times" class="col-md-2 col-form-label">Available Time Slots Per Day</label>
                        <div class="col-md-10">
                            <input type="text" name="availalable_times" class="form-control" placeholder="Enter Available Time Slots Per Day"
                                value="{{ old('availalable_times') }}" maxlength="100" required />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="single_seat_price" class="col-md-2 col-form-label">Single Seat Price</label>
                        <div class="col-md-10">
                            <input type="text" name="single_seat_price" class="form-control" placeholder="Enter Single Seat Price"
                                value="{{ old('single_seat_price') }}" maxlength="100" required />
                        </div>
                    </div>


                    

                    
                    <div class="form-group row">
                        <label for="double_seat_price" class="col-md-2 col-form-label">Double Seat Price</label>
                        <div class="col-md-10">
                            <input type="text" name="double_seat_price" class="form-control" placeholder="Enter Double Seat Price"
                                value="{{ old('double_seat_price') }}" maxlength="100" required />
                        </div>
                    </div>
                    <!--form-group-->
                    
                    <div class="form-group row">
                        <label for="guarranttee_seat_price" class="col-md-2 col-form-label">Guarrenttee Seat Price</label>
                        <div class="col-md-10">
                            <input type="text" name="guarranttee_seat_price" class="form-control" placeholder="Enter Guarrenttee Seat Price"
                                value="{{ old('guarranttee_seat_price') }}" maxlength="100" required />
                        </div>
                    </div>
                    <!--form-group-->
                    
                    <div class="form-group row">
                        <label for="insurance_price" class="col-md-2 col-form-label">Insurance Price</label>
                        <div class="col-md-10">
                            <input type="text" name="insurance_price" class="form-control" placeholder="Enter Insurance Price"
                                value="{{ old('insurance_price') }}" maxlength="100" required />
                        </div>
                    </div>
                    <!--form-group-->

                    <div class="form-group row" style="margin-bottom:90px;">
                        <label for="about" class="col-md-2 col-form-label ">About</label>

                        <div class="col-md-10">
                            <div id="aboutEditor">{{ old('about') }}</div>
                            <textarea name="about" class="form-control"  
                            style="display:none;"
                            id="aboutInput"
                            placeholder="Enter About" required>{{ old('about') }}</textarea>
                        </div>
                    </div>


                    
                
                    <div class="form-group row" style="margin-bottom:90px;">
                        <label for="about" class="col-md-2 col-form-label ">Highlights</label>

                        <div class="col-md-10">
                            <div id="hightlightsEditor">{{ old('hightlights') }}</div>
                            <textarea name="about" class="form-control"  
                            style="display:none;"
                            id="highlightsInput"
                            placeholder="Enter Highlights" required>{{ old('hightlights') }}</textarea>
                        </div>
                    </div>



                    <div class="form-group row">
                        <label for="name" class="col-md-2 col-form-label">Select Usually Supercars Used</label>
                        <div class="col-md-10" >
                            <select name="type" 
                            class="multiselect"
                            data-coreui-search="true"  
                            required
                            multiple
                            style="width:100%;"
                            x-on:change="supercars_used = $event.target.value">
                            @foreach($cars as $key=>$car)    
                                <option value="{{$car->id}}">{{$car->title}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <!--form-group-->


                </div>
            </x-slot>

            <x-slot name="footer">
                <button class="btn btn-sm btn-primary float-right" type="submit">Create Package</button>
            </x-slot>
        </x-backend.card>
    </x-forms.post>


    <script>

var container = document.getElementById('aboutEditor');
var aboutEditor = new Quill(container,{
  modules: {
    toolbar: [
      [{ header: [1, 2, 3, 4, 5, 6,  false] }],
      ['bold', 'italic', 'underline','strike'],
      ['image', 'code-block'],
      ['link'],
      [{ 'script': 'sub'}, { 'script': 'super' }],
      [{ 'list': 'ordered'}, { 'list': 'bullet' }],
      ['clean']
    ]
  },
  placeholder: 'Compose an epic...',
  theme: 'snow'  // or 'bubble'
});



aboutEditor.on('text-change', function(delta, source) {

    let html = aboutEditor.root.innerHTML;
    console.log ( html );
	document.getElementById("aboutInput").innerHTML=html;
})

var container = document.getElementById('hightlightsEditor');
var highlightEditor = new Quill(container,{
  modules: {
    toolbar: [
      [{ header: [1, 2, 3, 4, 5, 6,  false] }],
      ['bold', 'italic', 'underline','strike'],
      ['image', 'code-block'],
      ['link'],
      [{ 'script': 'sub'}, { 'script': 'super' }],
      [{ 'list': 'ordered'}, { 'list': 'bullet' }],
      ['clean']
    ]
  },
  placeholder: 'Compose an epic...',
  theme: 'snow'  // or 'bubble'
});


highlightEditor.on('text-change', function(delta, source) {
let html = highlightEditor.root.innerHTML;
console.log ( html );
document.getElementById("aboutInput").innerHTML=html;
})


$('.multiselect').multipleSelect()

    </script>
@endsection
