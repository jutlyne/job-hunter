@extends('layouts.employer.app')
@section('title', 'Recruitment Create')
@section('breadcrumb', 'Recruitment Create')


@push('style')

@endpush

@section('content')

<form action="{{ route('employer.recruitment.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('employer.recruitment._form')
</form>
<!-- The Modal -->
@include('employer.recruitment._form-category')
@include('employer.recruitment._form-image')
@endsection

@push('script')

@endpush