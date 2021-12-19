@extends('layouts.employer.app')
@section('title', 'Applies Manage')
@section('breadcrumb', 'Recruitments')

@push('style')
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <style>
        td {
            max-width: 80px;
            max-height: 60px;
        }

        td span {
            width: 100%;
            overflow: hidden;
            display: -webkit-inline-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .pagination {
            justify-content: center;
        }

        @media only screen and (min-width: 576px) {
            .modal-dialog {
                max-width: 650px;
            }
        }

    </style>
@endpush

@section('content')
    <form action="{{ route('employer.message.agree', $info->id) }}" method="post">
        @csrf
        <div class="card">
            <div class="row">
                <div class="col-md-12 pt-3 pb-3" style="background: #fff">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="id" value="{{ $info->id }}" id="">
                            <input type="text" class="form-control" readonly required name="name"
                                placeholder="Please enter your name" value="Dear {{ $info->user->name ?? old('name') }}">
                            @error('title')
                                <code>{{ $message }}</code>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label for="">Title</label>
                            <input type="text" class="form-control" required name="title" placeholder="Please enter slug"
                                value="{{ $recruitment->slug ?? old('slug') }}">
                            @error('title')
                                <code>{{ $message }}</code>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label for="">Description</label>
                            <textarea id="summernote" class="summernote form-control"
                                name="">{{ old('description') }}</textarea>
                            @error('description')
                                <code>{{ $message }}</code>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12 pt-3">
                        <div class="row d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">Send</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('script')
    <script src={{ asset('js/select2.min.js') }}></script>
    <script>
        $('.summernote').summernote({
            placeholder: 'Please enter',
            tabsize: 1,
            height: 100,
            lang: 'vi-VN', // default: 'en-US'
            toolbar: [
                ['view', ['codeview', 'help']],
            ],
            callbacks: {}
        });
    </script>
@endpush
