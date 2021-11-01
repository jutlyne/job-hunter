@extends('layouts.employer.app')
@section('title', 'Recruitment Edit')
@section('breadcrumb', 'Recruitment Edit')

@push('style')

@endpush

@section('content')

<form action="{{ route('employer.recruitment.update', $recruitment->id) }}" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="{{ $recruitment->id }}">
    @method('PUT')
    @csrf
    @include('employer.recruitment._form')
</form>
@include('employer.recruitment._form-category')
@include('employer.recruitment._form-image')

@endsection

@push('script')

@endpush