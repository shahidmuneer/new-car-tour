@inject('model', '\App\Domains\Auth\Models\User')

@extends('backend.layouts.app')

@section('title', 'Create Cars')

@section('content')
    <x-forms.post :action="route('cars.store')" enctype="multipart/form-data">
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


                    <div class="form-group row">
                        <label for="control" class="col-md-2 col-form-label">Upload Image</label>
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
                <button class="btn btn-sm btn-primary float-right" type="submit">Create Cars</button>
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

    </script>

@endsection
