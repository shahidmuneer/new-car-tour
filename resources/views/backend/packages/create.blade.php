@inject('model', '\App\Domains\Auth\Models\User')

@extends('backend.layouts.app')

@section('title', 'Create Package')

@section('content')
    <x-forms.post :action="route('packages.store')" enctype="multipart/form-data">
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
                            <input type="text" name="available_times" class="form-control" placeholder="Enter Available Time Slots Per Day"
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
                            <input type="text" name="guarranttee_car_price" class="form-control" placeholder="Enter Guarrenttee Seat Price"
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
                            placeholder="Enter About">{{ old('about') }}</textarea>
                        </div>
                    </div>




                    <div class="form-group row" style="margin-bottom:90px;">
                        <label for="highlights" class="col-md-2 col-form-label ">Highlights</label>

                        <div class="col-md-10">
                            <div id="hightlightsEditor">{{ old('hightlights') }}</div>
                            <textarea name="highlights" class="form-control"
                            style="display:none;"
                            id="highlightsInput"
                            placeholder="Enter Highlights">{{ old('hightlights') }}</textarea>
                        </div>
                    </div>



{{--                    <div class="form-group row">--}}
{{--                        <label for="name" class="col-md-2 col-form-label">Select Usually Supercars Used</label>--}}
{{--                        <div class="col-md-10" >--}}
{{--                            <select name="type"--}}
{{--                            class="multiselect"--}}
{{--                            data-coreui-search="true"--}}
{{--                            required--}}
{{--                            multiple--}}
{{--                            style="width:100%;"--}}
{{--                            x-on:change="supercars_used = $event.target.value">--}}
{{--                            @foreach($cars as $key=>$car)--}}
{{--                                <option value="{{$car->id}}">{{$car->title}}</option>--}}
{{--                            @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <!--form-group-->


                    <div class="form-group row">
                        <label for="control" class="col-md-2 col-form-label">Upload Cover Photo</label>
                        <div class="input_bx"><!-- start input box -->
                            {{--                            <label class="">Profile Image</label>--}}
                            <input tabindex="25" type="file" name="image" id="image"
                                   class="inputs_up form-control"
                                   accept=".png,.jpg,.jpeg"
                                   style="width: 100px !important; background-color: #eee; border:none; box-shadow: none !important; display: none;">
                            <span id="image_error_msg" class="validate_sign"> </span>

                            <div class="db">

                                <div class="db">
                                    <label id="image1"
                                           style="display: none; cursor:pointer; color:blue; text-decoration:underline;">
                                        <i style=" color:#04C1F3"
                                           class="fa fa-window-close"></i>
                                    </label>
                                </div>
                                <div>
                                    <img id="imagePreview1"
                                         style="border-radius:50%; position:relative; cursor:pointer;  width: 100px; height: 100px;"
                                         src="{{ asset('uploads/cars/default.png') }}"/>
                                </div>
                            </div>


                        </div><!-- end input box -->
                    </div>



                </div>
            </x-slot>

            <x-slot name="footer">
                <button class="btn btn-sm btn-primary float-right" type="submit">Create Package</button>
            </x-slot>
        </x-backend.card>
    </x-forms.post>


    <script>

        jQuery("#imagePreview1").click(function () {
            jQuery("#image").click();
        });
        var image1RemoveBtn = document.querySelector("#image1");
        var imagePreview1 = document.querySelector("#imagePreview1");


        $(document).ready(function () {
            $('#email_confirmation, #email').on("cut copy paste", function (e) {
                e.preventDefault();
            });


            $('#image').change(function () {
                var file = this.files[0],
                    val = $(this).val().trim().toLowerCase();
                if (!file || $(this).val() === "") {
                    return;
                }

                var fileSize = file.size / 1024 / 1024,
                    regex = new RegExp("(.*?)\.(jpeg|png|jpg)$"),
                    errors = 0;

                if (fileSize > 200) {
                    errors = 1;

                    document.getElementById("image_error_msg").innerHTML = "Only png.jpg,jpeg files & max size:200 mb";
                }
                if (!(regex.test(val))) {
                    errors = 1;

                    document.getElementById("image_error_msg").innerHTML = "Only png.jpg,jpegs files & max size:200 mb";
                }

                var fileInput = document.getElementById('image');
                var reader = new FileReader();

                if (errors == 1) {
                    $(this).val('');

                    image1RemoveBtn.style.display = "none";
                    document.getElementById("imagePreview1").src = 'uploads/cars/default.png';

                } else {

                    image1RemoveBtn.style.display = "block";
                    imagePreview1.style.display = "block";

                    reader.onload = function (e) {
                        document.getElementById("imagePreview1").src = e.target.result;
                    };
                    reader.readAsDataURL(fileInput.files[0]);

                    document.getElementById("image_error_msg").innerHTML = "";
                }
                // document.getElementById("").innerHTML = "";
            });

            $("#make_salary_account").trigger("change");
            $("#make_credentials").trigger("change");
        });


        image1RemoveBtn.onclick = function () {

            var image = document.querySelector("#image");
            image.value = null;
            var imagea = document.querySelector("#imagePreview1");
            imagea.value = null;
            image1RemoveBtn.style.display = "none";
            //imagePreview1.style.display = "none";
            document.getElementById("imagePreview1").src = 'uploads/cars/default.png';

        }











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


// For Highlights
var hcontainer = document.getElementById('hightlightsEditor');
var hightlightsEditor = new Quill(hcontainer,{
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



hightlightsEditor.on('text-change', function(delta, source) {

    let html = hightlightsEditor.root.innerHTML;
    console.log ( html );
    document.getElementById("highlightsInput").innerHTML=html;
})


// For Multi select
$('.multiselect').multipleSelect()




    </script>
@endsection
