@extends('layouts.user.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }} ">
@endpush
@section('title', 'User Profile')
@section('content')
    @include('layouts.user.info')
    <section>
        <div class="block no-padding">
            <div class="container">
                <div class="row no-gape">
                    @include('layouts.user.leftbar')
                    <div class="col-lg-9 column">
                        <div class="padding-left">
                            <div class="manage-jobs-sec">
                                <h3>Manage Jobs</h3>
                                <table>
                                    <thead>
                                        <tr>
                                            <td>Applied Job</td>
                                            <td>Employer</td>
                                            <td>Position</td>
                                            <td>Date</td>
                                            <td></td>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($apply as $item)

                                            <tr>
                                                <td>
                                                    <div class="table-list-title">
                                                        <i>{{ $item->recruitment->name }}</i><br />
                                                        <span><i
                                                                class="la la-map-marker"></i>{{ $item->recruitment->province->name }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="table-list-title">
                                                        <h3><a href="#"
                                                                title="">{{ $item->recruitment->employer->name }}</a></h3>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="table-list-title">
                                                        <h3><a href="#" title="">{{ $item->recruitment->category->name }}
                                                                / {{ $item->recruitment->level }}</a></h3>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span>{{ date('d/m/Y H:i', strtotime($item->apply_date)) }}</span><br />
                                                </td>
                                                <td>
                                                    <ul class="action_job">
                                                        <li><span>Delete</span><a href="" class="remove-apply"
                                                                data-id="{{ $item->id }}"
                                                                data-url="{{ route('user.apply.destroy') }}" title=""><i
                                                                    class="la la-trash-o"></i></a></li>
                                                    </ul>
                                                </td>
                                            </tr>

                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script>
        $('.remove-apply').on('click', function(e) {
            e.preventDefault();
            id = $(this).data('id');
            url = $(this).data('url');
            item = $(this); //using $(this) in ajax not working
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, cancel it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'get',
                        data: {
                            'id': id,
                        },
                        success: function(data) {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal
                                        .stopTimer)
                                    toast.addEventListener('mouseleave', Swal
                                        .resumeTimer)
                                }
                            })

                            Toast.fire({
                                icon: 'success',
                                title: 'Cancellation successfully'
                            })

                            item.parents('tr').remove();
                        }
                    });
                }
            })

        })
    </script>
@endpush
