@extends('layouts.employer.app')

@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css"
          integrity="sha512-zxBiDORGDEAYDdKLuYU9X/JaJo/DPzE42UubfBw9yg8Qvb2YRRIQ8v4KsGHOx2H1/+sdSXyXxLXv5r7tHc9ygg=="
          crossorigin="anonymous"/>
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
    <style>
        .toggle.ios, 
        .toggle-on.ios, 
        .toggle-off.ios { 
            border-radius: 20rem; 
        }
        .toggle.ios .toggle-handle { 
            border-radius: 20rem; 
        }
        .pac-container { 
            z-index: 10000 !important; 
        }
    </style>
@endsection

@section('title', $title ?? 'Setting')

@section('content')
    <div class="container-fluid">
        <h2 class="page-title">Set up employer information</h2>
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="row">
            <div class="col-lg-4 col-xlg-3 col-md-5">
                <div class="card">
                    <div class="card-body">
                        <div class="pb-3 mb-3 text-center border-bottom">
                            <a href="#" data-toggle="modal" data-target="#update-avatar-modal">
                                <img src="{{auth('store')->user()->employer->avatar_url}}" class="rounded-circle"
                                     style="width: 160px; height:160px"/>
                            </a>
                        </div>
                        <form action="{{ route('employer.password.update') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Current Password</label>
                                <input type="password" name="current_password" value="" class="form-control"
                                       placeholder="current password">
                            </div>
                            <div class="form-group">
                                <label>New password</label>
                                <input type="password" name="password" value="" class="form-control"
                                       placeholder="new password">
                            </div>
                            <div class="form-group">
                                <label>Confirm new password</label>
                                <input type="password" name="password_confirmation" value="" class="form-control"
                                       placeholder="confirm new password">
                            </div>
                            <button class="btn btn-primary" type='submit' name='submit_profile'>Change Password</button>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        {{-- <div class="d-flex justify-content-between align-items-center">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#sos_detail">
                                <i class="fa fa-info"></i> Company information
                            </button>
                        </div> --}}
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-xlg-9 col-md-7">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <img src="{{ $employer->thumbnail_url }}" alt="thumbnail" class="img-thumbnail"
                                 style="height: 200px"/>
                        </div>
                        <hr>
                        <form method='post' action="{{ route('employer.profile.update') }}">
                            @csrf
                            <div class="form-group">
                                <label>Name (<span class="text-danger">&#42;</span>)</label>
                                <input type="text" name="name" value="{{ $employer->name }}" class="form-control"
                                       placeholder="Name" required>
                            </div>
                            <div class="form-group">
                                <label>Province/City (<span class="text-danger">&#42;</span>)</label>
                                <select name="province_id" class="form-control" id="province_dropdown" required>
                                    <option value="0">Select province/city</option>
                                    @foreach($provinces as $item)
                                        <option
                                            @if($item->id == $employer->province_id)
                                            {{ "selected" }}
                                            @endif
                                            value="{{ $item->id }}">{{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>District (<span class="text-danger">&#42;</span>)</label>
                                <select name="district_id" class="form-control" id="district_dropdown" required>
                                    <option value="0">Select district</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Adress (<span class="text-danger">&#42;</span>)</label>
                                <input type="text" name="address" value="{{ $employer->address }}" class="form-control"
                                       placeholder="Adress" required>
                            </div>
                            <div class="form-group">
                                <label class="text-muted" for="thumbnail">Thumbnail</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="thumbnail">
                                    <input type="hidden" class="custom-file-input" name='thumbnail'>
                                    <label class="custom-file-label" for="thumbnail">Choose file</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Introduce</label>
                                <textarea id='editor4' name="description" rows="4" cols="5" class="form-control"
                                          placeholder="Introduce">{{ $employer->description }}</textarea>
                            </div>
                            <button class="btn btn-primary" type='submit' name='submit_profile'>
                                Update information
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label>Banner photo</label>
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#addImageModal">
                                    <i class="fa fa-save"></i> Add more photos
                                </button>
                            </div>
                            <div class="row">
                                @foreach($employer->images as $image)
                                    <div class="col-6 mt-3">
                                        <img class="w-100 cover-fill rounded" style="height: 150px"
                                             src="{{ $image->image_url }}">
                                        <div class="text-center mt-3">
                                            <button type="button" class="btn btn-danger btn-delete-banner"
                                                    data-action="{{ route('employer.profile.banners.delete', $image->id) }}"
                                                    data-toggle="modal" data-target="#deleteImageModal">
                                                    Delete photos
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteImageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="" method="post" class="modal-content">
                @csrf
                @method('delete')
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete the photo?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Delete</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="addImageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('employer.profile.banners.store') }}" method="post" class="modal-content"
                  enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="text-muted">Image</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name='banner' id="inputGroupFile01">
                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="update-avatar-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('employer.avatar.update') }}" method="post" class="modal-content"
                  enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Update avatar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label class="text-muted">Choose avatar</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name='avatar' id="avatar">
                        <label class="custom-file-label" for="avatar">Choose file</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img id="employer-thumbnail" style="width: 100%; max-width: 100%">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="crop-thumbnail">Crop image</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('js/mapInput.js') }}"></script>
    <script src="{{ asset('js/AjaxAct.js') }}"  ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"
            integrity="sha512-Gs+PsXsGkmr+15rqObPJbenQ2wB3qYvTHuJO6YJzPe/dTLvhy0fmae2BcnaozxDo5iaF8emzmCZWbQ1XXiX2Ig=="
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>  
    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ config('googlemaps.key') }}&libraries=places&callback=callback"></script>      
    <script>
      $(function () {
        var district = {{ $employer->district_id ?? "1" }};
        var url = new URL('{{ route('districts.index') }}');
        var params = { province:$('#province_dropdown').val() };
        Object.keys(params).forEach(key => url.searchParams.append(key, params[key]))
        fetch(url)
            .then(response => response.json())
            .then(result => {
              $('#district_dropdown').children().remove().end();
              result.data.forEach(function (data) {
                if(district == parseInt(data.id)) {
                  $("#district_dropdown").append('<option value="' + district + '" selected>'+ data.name + '</option>');
                } else {
                  $("#district_dropdown").append('<option value="' + data.id + '">'+ data.name + '</option>');
                }
              });
            })
            .catch(error => {
              console.error('Error:', error);
            });
        $("#district_dropdown").append();
      });

      $('#province_dropdown').change(function () {
        var district = {{ $employer->district_id ?? "1"}} ;
        var url = new URL('{{ route('districts.index') }}');
        var params = { province:$(this).val() };
        Object.keys(params).forEach(key => url.searchParams.append(key, params[key]))
        fetch(url)
        .then(response => response.json())
        .then(result => {
          $('#district_dropdown').children().remove().end();
          result.data.forEach(function (data) {
            if(district == parseInt(data.id)) {
              $("#district_dropdown").append('<option value="' + district + '" selected>'+ data.name + '</option>');
            } else {
              $("#district_dropdown").append('<option value="' + data.id + '">'+ data.name + '</option>');
            }
          });
        })
        .catch(error => {
          console.error('Error:', error);
        });
      });

      $('.btn-delete-banner').on('click', function () {
        $('#deleteImageModal form').attr('action', $(this).attr('data-action'));
      });

      const croppieOptions = {
        showZoomer: true,
        enableOrientation: true,
        mouseWheelZoom: "ctrl",
        viewport: {
          width: 700,
          height: 500,
          type: "square"
        },
        boundary: {
          width: '100%',
          height: '700px',
        },
      };

      const croppie = document.getElementById("employer-thumbnail");
      const c = new Croppie(croppie, croppieOptions);

      function readURL(input) {
        if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = (e) => {
            c.bind({url: reader.result});
          }

          reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
      }

      $("#thumbnail").change(function () {
        readURL(this);
        $('#exampleModalCenter').modal('show');
      });

      $('#crop-thumbnail').on('click', () => {
        c.result('base64').then(base64 => {
          $('input[name=thumbnail]').val(base64.replace(/data:.+?,/, ''));
        })
        $('#exampleModalCenter').modal('hide');
      });
    </script>
@endpush
