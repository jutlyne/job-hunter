@push('style')
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css" />
    <style>
        label {
            padding: 10px 0;
            font-weight: bold !important;
        }

        img {
            display: block;
            max-width: 100%;
        }

        .preview {
            overflow: hidden;
            width: 160px;
            height: 160px;
            margin: 10px;
            border: 1px solid red;
        }

        .modal-lg {
            max-width: 1000px !important;
        }

        img {
            object-fit: cover;
            -o-object-fit: contain;
            object-position: top;
            -o-object-position: top;
            width: 600px;
            height: 500px;
        }

        .error {
            visibility: hidden;
            transition: 1.5 ease;
        }
        iframe {
            width: 100%;
        }

    </style>
@endpush
<div class="row">
    <div class="col-md-8 pt-3 pb-3" style="background: #fff">
        <div class="row">
            <div class="col-md-12">
                <label for="">Name</label>
                <input type="hidden" name="employer_id" value="6">
                <input type="text" class="form-control" required name="name" placeholder="Please enter your name"
                    value="{{ $recruitment->name ?? old('name') }}">
                @error('title')
                    <code>{{ $message }}</code>
                @enderror
            </div>
            <div class="col-md-12">
                <label for="">Slug</label>
                <input type="text" class="form-control" required name="slug" placeholder="Please enter slug"
                    value="{{ $recruitment->slug ?? old('slug') }}">
                @error('slug')
                    <code>{{ $message }}</code>
                @enderror
            </div>
            <div class="col-md-12">
                <label for="">Job Description</label>
                <textarea id="summernote" class="summernote form-control"
                    name="preview_text">{{ $recruitment->preview_text ?? old('preview_text') }}</textarea>
                @error('preview_text')
                    <code>{{ $message }}</code>
                @enderror
            </div>
            <div class="col-md-12">
                <label for="">Required Knowledge, Skills, and Abilities</label>
                <textarea id="summernote" class="summernote form-control"
                    name="profile_text">{{ $recruitment->profile_text ?? old('profile_text') }}</textarea>
                @error('profile_text')
                    <code>{{ $message }}</code>
                @enderror
            </div>
            <div class="col-md-12">
                <label for="">Job Benefit</label>
                <textarea id="summernote" class="summernote form-control"
                    name="benefit_text">{{ $recruitment->benefit_text ?? old('benefit_text') }}</textarea>
                @error('preview_text')
                    <code>{{ $message }}</code>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="row">
            <div class="col-md-12 ml-1 pb-3" style="background: #fff">
                <div id="imgUpload" style="display: none; visibility: hidden">
                    <input type="file" accept=".jpg,.jpeg,.png" class="fileUpload" id="fileUpload"
                        style="visibility: hidden; position: absolute">
                </div>
                <label for="" class="mt-3 mb-3">Upload Image</label>
                <div id="divUpload" style="width: 100%; margin: auto; border: 1px dotted">

                    <div style="width: 80%;text-align: center; margin: auto" class="mt-5 mb-5">
                        <img src="{{ $recruitment->recruitment_url ?? '' }}" alt="" id="showImg"
                            style="height: 150px; width: 100%; display: {{ isset($recruitment->recruitment_url) ? '' : 'none' }}">
                        <i class="fas fa-arrow-circle-up" style="font-size: 50px"></i><br>
                        @error('thumbnail')
                            <code>{{ $message }}</code><br>
                        @enderror
                        <button class="btn btn-default mt-2" type="button" style="border: 1px solid #ddd;">Upload
                            Image</button>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        <label for="">Category</label>
                        <select class="form-control js-example-basic-multiple" required name="category_id"">
                            
                            @foreach ($categories as $item)
                                <option value="{{ $item->id }}"
                                    {{ isset($recruitment->category_id) && $recruitment->category_id == $item->id  ? 'selected' : '' }}>
                                    {{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('category')
                            <code>{{ $message }}</code>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <label for="">Gender</label>
                        <select class="form-control form-select" required name="gender">
                                <option value="2" {{ isset($recruitment->gender) && $recruitment->gender == 2 ? 'selected' : '' }}>All</option>
                                <option value="0" {{ isset($recruitment->gender) && $recruitment->gender == 0 ? 'selected' : '' }}>Male</option>
                                <option value="1" {{ isset($recruitment->gender) && $recruitment->gender == 1 ? 'selected' : '' }}>Female</option>
                        </select>
                        @error('gender')
                            <code>{{ $message }}</code>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <label for="">City</label>
                        <select class="form-control form-select" required name="province_id">
                                @foreach ($provinces as $item)
                                <option value="{{ $item->id }}"
                                    {{ isset($recruitment->province_id) && $recruitment->province_id == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}</option>
                                @endforeach
                        </select>
                        @error('city')
                            <code>{{ $message }}</code>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <label for="">Quantity</label>
                        <input type="number" class="form-control" name="qty" value="{{ $recruitment->qty ?? old('qty') }}">
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
<div class="row mt-3">
    <div class="col-md-8">
        <div class="row float-right">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </div>

</div>

@push('script')
    <script src={{ asset('js/select2.min.js') }}></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"
        integrity="sha512-ooSWpxJsiXe6t4+PPjCgYmVfr1NS5QXJACcR/FPpsdm6kqG1FmQ2SVyg2RXeVuCRBLr0lWHnWJP6Zs1Efvxzww=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        var imgContent = []

        $('.summernote').summernote({
            placeholder: 'Please enter',
            tabsize: 1,
            height: 100,
            lang: 'vi-VN', // default: 'en-US'
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['view', ['codeview', 'help']],
            ],
            callbacks: {
            }
        });

        var $modal = $('#modal');
        var image = document.getElementById('image');
        var cropper;
        $('#divUpload').click(function() {
            $('#fileUpload').click();
        });
        $('#fileUpload').on('change', function(e) {
            var files = e.target.files;
            let done = function(url) {
                image.src = url;
                $modal.modal('show');
            };
            if (files && files.length > 0) {
                reader = new FileReader();
                reader.onload = function(event) {
                    done(reader.result);
                };
                reader.readAsDataURL(files[0]);
            }
        });
        $('#modal').on('shown.bs.modal', function() {
            cropper = new Cropper(image, {
                aspectRatio: 300 / 150,
                viewMode: 1,
                autoCrop: true,
                autoCropArea: 1,
                minContainerHeight: 400,
                background: false,
                preview: '.preview'
            });
        }).on('hidden.bs.modal', function() {
            cropper.destroy();
            cropper = null;
        });
        $('#crop-carousel').on('click', function() {
            canvas = cropper.getCroppedCanvas({
                aspectRatio: 400 / 150,
                minWidth: 256,
                minHeight: 256,
                maxWidth: 512,
                maxHeight: 512,
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high',
            });
            canvas.toBlob(function(blob) {
                url = URL.createObjectURL(blob);
                let reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function() {
                    let base64data = reader.result;
                    $modal.modal('hide');
                    $('#showImg').css('display', '');
                    $('#showImg').attr("src", base64data);
                    let html_append =
                        `<input type="hidden" name="thumbnail" value="${ base64data }" style="visibility: hidden; position: absolute">`
                    $('#imgUpload').append(html_append);
                }
            });
        });
        $(function() {
            $('.js-example-basic-multiple').change(function() {
                let str = $(this).val() + '';
                let arrValue = str.split(",");
                let index = arrValue.indexOf('new');
                console.log(index);
                if (index !== -1) {
                    arrValue.splice(index);
                    console.log(arrValue);
                    $('#myModal').modal();
                    $('.js-example-basic-multiple').val(arrValue).trigger('change');
                }

            })
        })

        function smFrmCategory() {
            $('#myModal').modal('hide');

            var category = $('#newCategory').val();
            $.ajax({
                url: "{{ route('admin.recruitment.category.store') }}",
                type: 'post',
                dataType: 'json',
                data: {
                    category: category,
                    _token: $('meta[name=csrf-token]').attr('content')
                },
                success: function(data) {
                    var newOption = new Option(data.name, data.id, false, false);
                    $('.js-example-basic-multiple').prepend(newOption).trigger('change');
                    $('#newCategory').val('');
                },
                error: function() {
                    alert('Có lỗi xảy ra');
                }
            })
        }

        function delay(callback, ms) {
            var timer = 0;
            return function() {
                var context = this,
                    args = arguments;
                clearTimeout(timer);
                timer = setTimeout(function() {
                    callback.apply(context, args);
                }, ms || 0);
            };
        }


        $(document).ready(function() {
            $("#newCategory").keyup(delay(function(e) {
                var category = $(this).val();
                if (category.length > 255 || category.length <= 0) {
                    alert('Category cannot exceed 255 characters and cannot be left blank!');
                    $('#btnAddCategory').prop('disabled', true);
                } else {
                    $.ajax({
                        url: "{{ route('admin.recruitment.category.check') }}",
                        type: 'get',
                        data: {
                            category: category,
                            _token: $('meta[name=csrf-token]').attr('content')
                        },
                        success: function(data) {
                            if (data == 0) {
                                $('#btnAddCategory').prop('disabled', false);
                                $('#btnAddCategory').removeClass('error');
                            } else {
                                alert('The category name is already on the system');
                                $('#btnAddCategory').prop('disabled', true);
                                $('#btnAddCategory').addClass('error');
                            }
                        },
                        error: function() {
                            alert('Có lỗi xảy ra');
                        }
                    })
                }
            }, 800))
        })
    </script>

@endpush
