@extends('layouts.employer.app')

@section('style')
    <link rel="stylesheet" href="{{ mix('tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.min.css') }}">
@endsection

@section('title', $title ?? 'Employer Dashboard')

@section('content')
    <div class="fade-in">
        <div class="card">
            <div class="card-body">
                <form method="get" class="row">
                    <div class="col-sm-3 col-12 mb-3">
                        <input type="text" class="form-control datepicker datetimepicker-input"
                               name="start_time" placeholder="Start day"
                               autocomplete="off" data-toggle="datetimepicker" id="start_time"
                               value="{{ request()->get('start_time') }}"
                               required>
                    </div>
                    <div class="col-sm-3 col-12 mb-3">
                        <input type="text" class="form-control datepicker datetimepicker-input"
                               name="end_time" placeholder="End day"
                               autocomplete="off" data-toggle="datetimepicker" id="end_time"
                               value="{{ request()->get('end_time') }}"
                               required>
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-primary">
                            Filter results
                        </button>
                        <a class="btn btn-secondary" href="{{ route('employer.dashboard') }}">
                            All
                        </a>
                    </div>
                </form>
            </div>
        </div>

        @if(request()->get('start_time') && request()->get('end_time'))
            <div class="card">
                <div class="card-header d-flex justify-content-center">
                    <h2 class="card-title">{{ request()->get('start_time') }} ~ {{ request()->get('end_time') }}</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 d-flex align-items-center flex-column">
                            <h3 class="text-muted">{{ $applicationFilter->where('status', \App\Enums\ApplicationStatus::PENDING)->pluck('count')->first() ?? 0}}</h3>
                            <span class="card-text">Applied</span>
                        </div>
                        <div class="col-md-4 d-flex align-items-center flex-column">
                            <h3 class="text-muted">{{ $applicationFilter->where('status', \App\Enums\ApplicationStatus::FINISHED)->pluck('count')->first() ?? 0}}</h3>
                            <p class="card-text">Accept</p>
                        </div>
                        <div class="col-md-4 d-flex align-items-center flex-column">
                            <h3 class="text-muted">{{ $applicationFilter->where('status', \App\Enums\ApplicationStatus::CANCELED)->pluck('count')->first() ?? 0}}</h3>
                            <p class="card-text">Refuse</p>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="card">
                <div class="card-header d-flex justify-content-center">
                    <h2 class="card-title">Today</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 d-flex align-items-center flex-column">
                            <h3 class="text-muted">{{ $applicationToday->where('status', \App\Enums\ApplicationStatus::PENDING)->pluck('count')->first() ?? 0}}</h3>
                            <span class="card-text">Applied</span>
                        </div>
                        <div class="col-md-4 d-flex align-items-center flex-column">
                            <h3 class="text-muted">{{ $applicationToday->where('status', \App\Enums\ApplicationStatus::FINISHED)->pluck('count')->first() ?? 0}}</h3>
                            <p class="card-text">Accept</p>
                        </div>
                        <div class="col-md-4 d-flex align-items-center flex-column">
                            <h3 class="text-muted">{{ $applicationToday->where('status', \App\Enums\ApplicationStatus::CANCELED)->pluck('count')->first() ?? 0}}</h3>
                            <p class="card-text">Refuse</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="card-header d-flex justify-content-center">
                        <h2>This month</h2>
                    </div>
                    <div class="row">
                        <div class="col-md-4 d-flex align-items-center flex-column">
                            <h3 class="text-muted">{{ $applicationMonth->where('status', \App\Enums\ApplicationStatus::PENDING)->pluck('count')->first() ?? 0}}</h3>
                            <span class="card-text">Applied</span>
                        </div>
                        <div class="col-md-4 d-flex align-items-center flex-column">
                            <h3 class="text-muted">{{ $applicationMonth->where('status', \App\Enums\ApplicationStatus::FINISHED)->pluck('count')->first() ?? 0}}</h3>
                            <p class="card-text">Accept</p>
                        </div>
                        <div class="col-md-4 d-flex align-items-center flex-column">
                            <h3 class="text-muted">{{ $applicationMonth->where('status', \App\Enums\ApplicationStatus::CANCELED)->pluck('count')->first() ?? 0}}</h3>
                            <p class="card-text">Refuse</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif


    </div>
@endsection

@push('script')
    <script src="{{ mix('js/moment.js') }}"></script>
    <script src="{{ mix('tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script>
      $(function () {
        $('.datepicker[name=start_time]').datetimepicker({
          format: 'DD-MM-YYYY',
        });

        $('.datepicker[name=end_time]').datetimepicker({
          format: 'DD-MM-YYYY',
          useCurrent: false,
        });

        $(".datepicker[name=start_time]").on("change.datetimepicker", function (e) {
          $('.datepicker[name=end_time]').datetimepicker('minDate', e.date);
        });

        $(".datepicker[name=end_time]").on("change.datetimepicker", function (e) {
          $('.datepicker[name=start_time]').datetimepicker('maxDate', e.date);
        });
      });
    </script>
@endpush
