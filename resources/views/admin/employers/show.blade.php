@extends('layouts.admin.app')
@section('title', 'Employers Infomation')
@section('breadcrumb', 'Employer Show')
@section('content')
    <div class="card">
        <div class="card-header"><i class="fa fa-align-justify"></i>&nbsp Employers</div>
        <div class="card-body">
            <div class="form-group">
                <label for="employer-name">Employer</label>
                <input class="form-control" id="employer-name" type="text" placeholder="name" spellcheck="false" data-ms-editor="true" value="{{ $employers->name }}" readonly>
            </div>
            <div class="form-group">
                <label for="employer-slug">Slug</label>
                <input class="form-control" id="employer-slug" type="text" placeholder="slug" spellcheck="false" data-ms-editor="true" value="{{ $employers->slug }}" readonly>
            </div>
            <div class="form-group">
                <label for="employer-address">Address</label>
                <input class="form-control" id="employer-address" type="text" placeholder="address" spellcheck="false" data-ms-editor="true" value="{{ $employers->address }}" readonly>
            </div>
            <div class="form-group">
                <label for="employer-address">Province</label>
                <input class="form-control" id="province" type="text" placeholder="province" spellcheck="false" data-ms-editor="true" value="{{ $employers->province->name ?? '' }}" readonly>
            </div>
            <div class="form-group">
                <label for="employer-address">Description</label>
                <div class="border-left">
                    {!! nl2br(e($employers->description)) !!}
                </div>
            </div>
        </div>
    </div>
@endsection
