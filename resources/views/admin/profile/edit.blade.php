@extends('layouts.admin.app')
@section('title', 'Admin Edit')
@section('breadcrumb', 'Admin')

@section('style')
    <link rel="stylesheet" href="{{ mix('tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.min.css') }}">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><i class="fa fa-align-justify"></i>Update admin</div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('admin.profile.update', $admin->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-7">
                        <div class="form-group">
                            <label for="password">Name</label>
                            <input class="form-control" id="name" type="text" value="{{ $admin->name }}" placeholder="name" name="name">
                        </div>
                        <div class="form-group">
                            <label for="password">Title</label>
                            <input class="form-control" id="title" type="text" value="{{ $admin->title }}" placeholder="title" name="title">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input class="form-control" id="password" type="password" placeholder="password" name="password">
                        </div>
                        <div class="form-group">
                            
                            {{-- <label for="admin-avatar">Avatar</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input preview-image" data-target="#admin-avatar" name="avatar" accept="image/*">
                                <label class="custom-file-label" for="admin-avatar">Choose file</label>
                            </div>
                            <div class="mt-3">
                                <img class="img-avatar rounded" id="admin-avatar" src="{{ $admin->avatar_url }}" width="400" height="350"/>
                            </div> --}}
                        </div>
                        <div class="form-group">
                            <label for="admin-description">Description</label>
                            <textarea id='admin-description' class="form-control" name="description" rows="3">{{ $admin->description }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div id="imgUpload" style="display: none; visibility: hidden">
                            <input type="file" accept=".jpg,.jpeg,.png" class="fileUpload" id="fileUpload"
                                style="visibility: hidden; position: absolute" name="avatar">
                        </div>
                        <label for="" class="mt-3 mb-3">Upload Image</label>
                        <div id="divUpload" style="width: 100%; margin: auto; border: 1px dotted">
        
                            <div style="width: 80%;text-align: center; margin: auto" class="mt-5 mb-5">
                                <img src="{{ $admin->avatar_url ?? '' }}" alt="" id="showImg"
                                    style="height: 150px; width: 100%; display: {{ isset($admin->avatar_url) ? '' : 'none' }}">
                                <i class="fas fa-arrow-circle-up" style="font-size: 50px"></i><br>
                                @error('thumbnail')
                                    <code>{{ $message }}</code><br>
                                @enderror
                                <button class="btn btn-default mt-2" type="button" style="border: 1px solid #ddd;">Upload
                                    Image</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <button class="btn btn-primary" type="submit">Update</button>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ mix('js/moment.js') }}"></script>
    <script src="{{ mix('tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script>
        $('.timepicker').datetimepicker({
          format: 'HH:mm',
          stepping: 30
        });
        $('#divUpload').click(function() {
            $('#fileUpload').click();
        });
        $('#fileUpload').change(function (e) {
            const [file] = fileUpload.files
            if (file) {
                $('#showImg').css('display', '');
                showImg.src = URL.createObjectURL(file)
            }
        });
    </script>
@endpush
