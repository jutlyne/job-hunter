@extends('layouts.admin.app')
@section('title', 'Recruitment Edit')
@section('breadcrumb', 'Recruitment Edit')

@push('style')

@endpush

@section('content')

<form action="{{ route('admin.recruitment.update', $recruitment->id) }}" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="{{ $recruitment->id }}">
    @method('PUT')
    @csrf
    @include('admin.recruitment._form')
</form>
@include('admin.recruitment._form-category')
@include('admin.recruitment._form-image')

@endsection

@push('script')

@endpush