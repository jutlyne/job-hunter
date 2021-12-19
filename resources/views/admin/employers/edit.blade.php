@extends('layouts.admin.app')
@section('title', 'Employer Edit')
@section('breadcrumb', 'Employer Edit')

@section('style')
    <link rel="stylesheet" href="{{ mix('tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.min.css') }}">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><i class="fa fa-align-justify"></i>Update employer</div>
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
            <form action="{{ route('admin.employers.update', $employer->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('admin.employers._form')
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

        $('.preview-image').change(function (e) {
          if (e.currentTarget.files && e.currentTarget.files[0]) {
            const reader = new FileReader();
            const imageTarget = e.currentTarget.dataset.target;
            reader.onload = function (e) {
              $(imageTarget)
                  .attr('src', e.target.result)
                  .width(400)
                  .height(350);
            }

            reader.readAsDataURL(e.currentTarget.files[0]);
          }
        });
    </script>
@include('ckfinder::setup')
@endpush
