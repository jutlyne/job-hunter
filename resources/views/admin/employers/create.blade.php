@extends('layouts.admin.app')
@section('title', 'Employer Create')
@section('breadcrumb', 'Employer Create')

@section('content')
    <div class="card">
        <div class="card-header"><i class="fa fa-align-justify"></i>Thêm employer mới</div>
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
            <form action="{{ route('admin.employers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('admin.employers._form')
                <button class="btn btn-primary" type="submit">Create</button>
            </form>
        </div>
    </div>
@endsection

@push('script')
    
@endpush
