@extends('layouts.user.app')
@section('title', 'List Recruitment Job Hunt')
@section('description', 'List Recruitment Job Hunt')
@section('keywords', 'List Recruitment Job Hunt')
@section('ogtype', 'article')
@section('ogurl', url()->current())


@push('styles')
    <link rel="stylesheet" href="{{ asset('custom/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }} ">
    <style>
        .slide {
            max-width: 100%;
        }

    </style>
@endpush

@section('content')

    <section>
        <div class="block">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="filterbar">
                            <h5>{{ count($recruitment) }} Jobs & Vacancies</h5>
                            <div class="sortby-sec">
                                <span>Sort by</span>
                                {{-- <form action="{{ route('user.recruitment.index') }}" method="get"> --}}
                                    
                                    <select name="sortBy" data-placeholder="20 Per Page" class="chosen paginate">
                                        @foreach (\App\Enums\LimitEnums::toSelectArray() as $key => $value)
                                            <option value="{{ $key }}" {{ request()->get('paginate') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>

                                    <select data-placeholder="province" class="chosen province">
                                        <option value="">Tất cả</option>
                                        @foreach ($province as $item)
                                            <option value="{{ $item->id }}" {{ request()->get('province') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                        @endforeach
                                        
                                    </select>
                            </div>
                        </div>
                        <div class="job-grid-sec">
                            <div class="row">
                                @foreach ($recruitment as $item)
                                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                        <div class="job-grid border">
                                            <div class="job-title-sec">
                                                <div class="c-logo"> <img src="{{ $item->recruitmentUrl }}"
                                                        alt="" /> </div>
                                                <h3><a href="{{ route('user.recruitment.detail', $item->slug) }}"
                                                        title="">{{ $item->name }}</a></h3>
                                                <span>{{ $item->employer->name }}</span>
                                            </div>
                                            <span class="job-lctn">{{ $item->province->name }}</span>
                                            <a href="javascript:void(0)" data-url="{{ route('user.apply.job') }}"
                                                data-id="{{ $item->id }}" data-employer="{{ $item->employer->id }}"
                                                class="apply-job" title="">APPLY NOW</a>
                                        </div><!-- JOB Grid -->
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="pagination">
                            {{ $recruitment->links('vendor.pagination.custom') }}
                        </div><!-- Pagination -->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script>

        $('.paginate').change(function() {
            location.assign('?paginate=' + $(this).val() + '&province=' + $('.province').val());
        });
        $('.province').change(function() {
            location.assign('?paginate=' + $('.paginate').val() + '&province=' + $(this).val());
        });

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
