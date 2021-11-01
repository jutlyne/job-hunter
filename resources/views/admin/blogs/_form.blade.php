@push('style')
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css" />
    <style>
        label {
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
                <label for="">Title</label>
                <input type="text" class="form-control" required name="title" placeholder="Please enter title"
                    value="{{ $blog->title ?? old('title') }}">
                @error('title')
                    <code>{{ $message }}</code>
                @enderror
            </div>
            <div class="col-md-12">
                <label for="">Slug</label>
                <input type="text" class="form-control" required name="slug" placeholder="Please enter slug"
                    value="{{ $blog->slug ?? old('slug') }}">
                @error('slug')
                    <code>{{ $message }}</code>
                @enderror
            </div>
            <div class="col-md-12">
                <label for="">Description</label>
                <input type="text" class="form-control" required name="description"
                    placeholder="Please enter description" value="{{ $blog->description ?? old('description') }}">
                @error('description')
                    <code>{{ $message }}</code>
                @enderror
            </div>
            <div class="col-md-12">
                <label for="">Content</label>
                <textarea id="summernote" data-url="{{ route('admin.imageUpload') }}" class="form-control"
                    name="content">{{ $blog->content ?? old('content') }}</textarea>
                @error('content')
                    <code>{{ $message }}</code>
                @enderror
                <div id="content">
                    <input type="hidden" id="img_content" name="img_content[]">
                </div>
            </div>
            <div class="col-md-12">
                <label for="">Seo title</label>
                <input type="text" class="form-control" required name="seo_title"
                    placeholder="Please enter seo title" value="{{ $blog->seo_title ?? old('seo_title') }}">
                @error('seo_title')
                    <code>{{ $message }}</code>
                @enderror
            </div>
            <div class="col-md-12">
                <label for="">Breadcrumb seo keyword</label>
                <input type="text" class="form-control" required name="breadcrumb_seo_keyword"
                    placeholder="Please enter SEO breadcrumb SEO keyword" maxlength="40"
                    value="{{ $blog->breadcrumb_seo_keyword ?? old('breadcrumb_seo_keyword') }}">
                @error('breadcrumb_seo_keyword')
                    <code>{{ $message }}</code>
                @enderror
            </div>
            <div class="col-md-12">
                <label for="">Seo description</label>
                <input type="text" class="form-control" required name="seo_description"
                    placeholder="Please enter SEO description"
                    value="{{ $blog->seo_description ?? old('seo_description') }}">
                @error('seo_description')
                    <code>{{ $message }}</code>
                @enderror
            </div>
            <div class="col-md-12">
                <label for="">Seo keyword</label>
                <input type="text" class="form-control" required name="seo_keyword"
                    placeholder="Please enter SEO keyword" value="{{ $blog->seo_keyword ?? old('seo_keyword') }}">
                @error('seo_keyword')
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
                        <img src="{{ $blog->blog_url ?? '' }}" alt="" id="showImg"
                            style="height: 150px; width: 100%; display: {{ isset($blog->blog_url) ? '' : 'none' }}">
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
                        <select class="js-example-basic-multiple form-control" required name="category[]"
                            multiple="multiple">
                            @foreach ($listCategory as $item)
                                <option value="{{ $item->id }}"
                                    {{ isset($blogCategories) && in_array($item->id, $blogCategories) ? 'selected' : '' }}>
                                    {{ $item->name }}</option>
                            @endforeach
                            <option value="new">New category</option>

                        </select>
                        @error('category')
                            <code>{{ $message }}</code>
                        @enderror
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

        $('#summernote').summernote({
            placeholder: 'Please enter content',
            tabsize: 1,
            height: 180,
            lang: 'vi-VN', // default: 'en-US'
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']],
            ],
            callbacks: {
                onImageUpload: (files) => {
                    var length = files.length;
                    let imgFile = new FormData
                    for (var i = 0; i < length; i++) {
                        imgFile.append('image[]', files[i])
                    }
                    let url = $('#summernote').data('url')
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    })
                    $.ajax({
                        url: url,
                        type: 'post',
                        dataType: 'json',
                        data: imgFile,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            response.arrPath.forEach(element => {
                                imgContent.unshift(element);
                            });
                            $('#img_content').val(imgContent);
                            console.log($('#img_content').val())
                            response.image.forEach(element => {
                                var img = $("<img>").attr({
                                    src: element,
                                    width: "100%",
                                    class: "img-content"
                                });
                                $('#summernote').summernote('insertNode', img[0])
                            });
                        }
                    })
                },
                onMediaDelete: function(target) {
                    var img = target[0].src;
                    $.ajax({
                        url: '{{ route('admin.removeImage') }}',
                        type: 'post',
                        dataType: 'json',
                        data: {
                            img: img,
                            _token: $('meta[name=csrf-token]').attr('content')
                        },
                        success: function(response) {
                            console.log(response.messenger);
                        }
                    })
                }
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
                aspectRatio: 300 / 150,
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
            $('.js-example-basic-multiple').select2();
            $('.js-example-basic-multiple').change(function() {
                let str = $(this).val() + '';
                let arrValue = str.split(",");
                let index = arrValue.indexOf('new');

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
                url: '{{ route('admin.blogs.category.store') }}',
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
                        url: '{{ route('admin.blog.category.check') }}',
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
