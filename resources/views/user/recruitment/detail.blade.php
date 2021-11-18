@extends('layouts.user.app')
@section('title', $recruitment->name)

@push('styles')
    <link rel="stylesheet" href="{{ asset('custom/css/detail.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }} ">
    <style>
        p {
            word-wrap: break-word;
        }

        p span {
            font-size: 15px !important;
            padding: 5px 0;
        }

        span::first-letter {
            text-transform: capitalize;
        }

    </style>

@endpush

@section('content')
    <section>
        <div class="block">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 column">
                        <div class="job-single-sec">
                            <div class="job-single-head">
                                <div class="job-thumb"> <img src="{{ $recruitment->recruitmentUrl }}" alt="" /> </div>
                                <div class="job-head-info">
                                    <h4>{{ $recruitment->employer->name }}</h4>
                                    <span>{{ $recruitment->province->name }}</span>
                                    <p><i class="la la-phone"></i>{{ $recruitment->employer->phone }}</p>
                                    <p><i class="la la-envelope-o"></i> <a
                                            href="{{ $recruitment->employer->staff->email }}" class="__cf_email__"
                                            data-cfemail="94f5f8fdbae0e1f2f5fad4fefbf6fce1fae0baf7fbf9">[email&#160;protected]</a>
                                    </p>
                                </div>
                            </div><!-- Job Head -->
                            <div class="job-details">
                                <h3>Job Description</h3>
                                <p>{!! $recruitment->preview_text !!}</p>
                                <h3>Required Knowledge, Skills, and Abilities</h3>
                                <ul>
                                    <p>{!! $recruitment->profile_text !!}</p>
                                </ul>
                                <h3>Benefit</h3>
                                <ul>
                                    <p>{!! $recruitment->benefit_text !!}</p>
                                </ul>
                            </div>
                            <div class="recent-jobs">
                                <h3>Recent Jobs</h3>
                                <div class="job-list-modern">
                                    <div class="job-listings-sec no-border">
                                        @foreach ($recruits as $item)
                                            <div class="job-listing wtabs">
                                                <div class="job-title-sec">
                                                    <div class="c-logo" style="padding-right: 20px"> <img
                                                            src="{{ $item->recruitmentUrl }}" alt="" /> </div>
                                                    <h3><a href="{{ route('user.recruitment.detail', $item->slug) }}"
                                                            title="">{{ $item->name }}</a></h3>
                                                    <span>{{ $item->employer->name }}</span>
                                                    <div class="job-lctn"><i
                                                            class="la la-map-marker"></i>{{ $item->province->name }}
                                                    </div>
                                                </div>
                                                <div class="job-style-bx">
                                                    <span class="job-is ft">{{ $item->experience . 'Years' }}</span>
                                                    {{-- <i>5 months ago</i> --}}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 column">
                        <a class="apply-thisjob apply-job" data-url="{{ route('user.apply.job') }}"
                            data-id="{{ $item->id }}" data-employer="{{ $item->employer->id }}" title=""><i
                                class="la la-paper-plane"></i>Apply for job</a>
                        <div class="job-overview">
                            <h3>Job Overview</h3>
                            <ul>
                                <li><i class="la la-money"></i>
                                    <h3>Offerd Salary</h3><span>Up to ${{ $recruitment->salary }}</span>
                                </li>
                                <li>
                                    <i class="la la-mars-double"></i>
                                    <h3>
                                        Gender
                                    </h3>
                                    <span>
                                        @if ($recruitment->gender == 0)
                                            Not required
                                        @elseif ($recruitment->gender == 1)
                                            Male
                                        @else
                                            Female
                                        @endif
                                    </span>
                                </li>
                                <li><i class="la la-thumb-tack"></i>
                                    <h3>Career Level</h3><span>{{ \App\Enums\LevelJob::toSelectArray()[$recruitment->level] }}</span>
                                </li>
                                <li><i class="la la-shield"></i>
                                    <h3>Experience</h3>
                                    <span>
                                        @if ($recruitment->experience < 1)
                                            {{ $recruitment->experience }}
                                        @else
                                            {{ $recruitment->experience }} Years
                                        @endif
                                    </span>
                                </li>
                            </ul>
                        </div><!-- Job Overview -->
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('script')
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script>
        $('.apply-job').on('click', function() {
            url = $(this).data('url');
            id = $(this).data('id');
            employer = $(this).data('employer');
            $.ajax({
                url: url,
                type: 'get',
                data: {
                    'id': id,
                    'employer_id': employer
                },
                success: function(data) {
                    if (data.status) {
                        Swal.fire({
                            title: 'Successfully applied',
                            text: 'Do you want to go to the apply management page?',
                            icon: 'success',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location = '{{ url('/apply/user-job') }}';
                            }
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: `Looks like you've applied for this position!`,
                        })
                    }

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    window.location.href = '/login_choose';
                }
            });
        })
    </script>
@endpush
