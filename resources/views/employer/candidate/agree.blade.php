@extends('layouts.employer.app')
@section('title', 'Applies Manage')
@section('breadcrumb', 'Recruitments')

@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

    </style>
@endpush

@section('content')
    <form action="{{ route('employer.message.agree', $info->id) }}" method="post">
        @csrf
        <div class="card">
            <div class="row">
                <div class="col-md-8 pb-3" style="background: #fff">
                    <div class="row">
                        <div class="col-md-12 pt-3">
                            <label for="">Subject</label>
                            <input type="hidden" name="id" value="{{ $info->id }}" id="">
                            <input type="text" class="form-control" readonly required name="name"
                                placeholder="Please enter your name" value="Dear {{ $info->user->name ?? old('name') }}">
                            @error('title')
                                <code>{{ $message }}</code>
                            @enderror
                        </div>
                        <div class="col-md-12 pt-3">
                            <label for="">Duration</label>
                            <input type="number" class="form-control" name="duration" placeholder="Default 30"
                                value="{{ old('duration') }}">
                            @error('title')
                                <code>{{ $message }}</code>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-4" style="margin: inherit">
                    <div class="row">
                        <div class='col-md-12 pt-3'>
                            <div class="form-group" style="margin-bottom: 0">
                                <label for="">Time</label>
                                <div class='input-group date' id='fromDate'>
                                    <input type='text' name="date" required class="form-control date-time" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class='col-md-12 pt-3'>
                            <div class="form-group">
                                <label for="">Password</label>
                                <input type='text' name="password" class="form-control" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-11 p-3" style="background: #fff">
                    <div class="row d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                </div>
                <div class="col-md-1"></div>

            </div>
        </div>
    </form>
@endsection

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js">
    </script>
    <script>
        $(function() {
            const nDate = new Date();

            $('.date-time').on('click', function() {
                $('.input-group-addon').click();
            });

            $('#fromDate').datetimepicker({
                minDate: nDate,
                format: 'YYYY-MM-DD LT',
                icons: {
                    time: "fa fa-clock",
                    date: "fa fa-calendar",
                },
            });
            // $('#fromDate').on('dp.change', function(e){ console.log(e.date); })
        });
    </script>
@endpush
