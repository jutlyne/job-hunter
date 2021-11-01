@extends('layouts.admin.app')
@section('title', 'Blog Create')
@section('breadcrumb', 'Blog Create')

@push('style')

@endpush

@section('content')

<form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('admin.blogs._form')
</form>
<!-- The Modal -->
@include('admin.blogs._form-category')
@include('admin.blogs._form-image')
@endsection

@push('script')

@endpush