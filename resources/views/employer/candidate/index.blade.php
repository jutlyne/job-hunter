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
        .view_meet {
            cursor: pointer;
        }
        .view_meet span:hover {
            color: blueviolet;
        }

        @media only screen and (min-width: 576px) {
            .modal-dialog {
                max-width: 650px;
            }
        }

        @media (min-width: 992px) {
            .modal-lg, .modal-xl {
                max-width: 800px;
            }
        }

    </style>
@endpush

@section('content')
    <div class="card">
        <div class="card-header">&nbsp;<i class="fa fa-align-justify"></i>&nbsp;Apply Manage</div>
        {{-- </form> --}}
        <div style="overflow: auto">
            <table class="table table-responsive-sm">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User Name</th>
                        <th>Recruitment</th>
                        <th>Status</th>
                        <th>Meeting</th>
                        <th>Apply At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($apply as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td><span>{{ $item->user->name }}</span></td>
                            <td><span>{{ $item->recruitment->name }}</span></td>
                            <td><span>{{ \App\Enums\ApplicationStatus::getDescription($item->status) }}</span></td>
                            <td>
                                <span>
                                    @if ($item->status == \App\Enums\ApplicationStatus::ACCEPT)
                                        <a class="view_meet" data-url="{{ route('employer.zoom.info', $item->id) }}"><span>View Meeting</span></a>
                                    @endif
                                </span>
                            </td>
                            <td><span>{{ date('d/m/Y', strtotime($item->apply_date)) }}</span></td>
                            <td>
                                <button type="button" data-url="{{ route('employer.candidate.show', $item->user->id) }}"
                                    class="btn btn-info btn-sm" data-toggle="modal"><i class="fa fa-eye"></i></button>
                                @if ($item->status == \App\Enums\ApplicationStatus::PENDING)
                                    <a href="{{ route('employer.message.agree', $item->id) }}" class="btn btn-info btn-sm"><i class="fas fa-check-square"></i></a>
                                    <a href="{{ route('employer.message.refuse', $item->id) }}" class="btn btn-info btn-sm"><i class="fas fa-times-circle"></i></a>
                                @elseif($item->status == \App\Enums\ApplicationStatus::CANCELED)
                                    <button class="btn btn-info btn-sm" style="color: red" disabled><i class="fas fa-times-circle" style="color: black"></i></button>
                                @else
                                    <button class="btn btn-info btn-sm" style="color: green" disabled><i class="fas fa-check-square" style="color: white"></i></button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="9">Không có dữ liệu</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <!-- Modal -->
    @include('employer.candidate._modal')
@endsection

@push('script')
    <script src={{ asset('js/select2.min.js') }}></script>
    <script>
        $(function() {
            $('.js-example-basic-multiple').select2();
        })

        $(document).on("click", ".btn-danger", function(e) {
            if (!confirm('Deleted data will not be recoverable ?')) {
                e.preventDefault();
            }
        });
        $(document).on("click", ".btn-info", function(e) {
            url = $(this).attr('data-url');
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    profile = data.profile;
                    $('#education').html(profile.education);
                    $('#exp').html(profile.experience);
                    $('#lang').html(profile.language);
                    $('#quote').html(profile.quote);

                    $('#myModal').modal('show');
                },
                error: function(e) {
                    console.log(e.message);
                }
            });
        });
        $('.view_meet').on('click', function () {
            url = $(this).attr('data-url');
            $.ajax({
                url: url,
                type: 'post',
                data: {
                    _token: $('meta[name=csrf-token]').attr('content')
                },
                success: function(data) {
                    array = Object.entries(data);

                    array.forEach(element => {
                        if (element[0] == 'zoom_url') {
                            $('#zoom_url').attr('href', element[1]).html(element[1]);
                        } else {
                            $('#' + element[0]).html(element[1]);
                        }
                    });

                    $('#exampleModalCenter').modal('show');
                },
                error: function(e) {
                    console.log(e.message);
                }
            });
        })
    </script>
@endpush
