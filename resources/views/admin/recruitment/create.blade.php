@extends('layouts.admin.app')
@section('title', 'Recruitment Create')
@section('breadcrumb', 'Recruitment Create')


@push('style')

@endpush

@section('content')

<form action="{{ route('admin.recruitment.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('admin.recruitment._form')
</form>
<!-- The Modal -->
@include('admin.recruitment._form-category')
@include('admin.recruitment._form-image')
@endsection

@push('script')

@endpush