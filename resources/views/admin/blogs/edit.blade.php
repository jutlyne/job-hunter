@extends('layouts.admin.app')
@section('title', 'Blog Edit')
@section('breadcrumb', 'Blog Edit')

@push('style')

@endpush

@section('content')

<form action="{{ route('admin.blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="{{ $blog->id }}">
    @method('PUT')
    @csrf
    @include('admin.blogs._form')
</form>
@include('admin.blogs._form-category')
@include('admin.blogs._form-image')

@endsection

@push('script')

@endpush