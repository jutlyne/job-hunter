@extends('layouts.employer.app')
@section('title', 'Recruitments Manage')
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
<form id="frmCreateOrder" action="https://sandbox.vnpayment.vn/button/websrc.html" method="POST" target="_top"> <input type="hidden" name="cmd" value="pay"> <input type="hidden" name="hosted_button_id" value="h5AV9t9IXV"> <input type="hidden" name="hosted_button_token" value="662a4bc8157fd1d2f6f9fa328b8ab04823e66416ef8d8bc1c6805a5f6e50cd4e"> <img alt="VNPAY - Thanh toan online" border="0" class="btnPopup" src="https://sandbox.vnpayment.vn/button/Images/paynow-1.png"> </form><script src="https://merchant.vnpay.vn/Scripts/jquery-3.5.1.min.js"></script><link href="https://merchant.vnpay.vn/Scripts/lib/vnpayframe.css" rel="stylesheet"/> <script src="https://merchant.vnpay.vn/Scripts/lib/vnpayframe.js"></script><script src="https://merchant.vnpay.vn/Scripts/lib/openbutton.js"></script>
    <div class="card">
        <div class="card-header">&nbsp;<i class="fa fa-align-justify"></i>&nbsp;Recruitments Manage</div>
        <div class="card-body">
            <div class="d-flex mb-3">
                <a class="btn btn-primary" href="{{ route('employer.recruitment.create') }}">Add new</a>
            </div>
            {{-- <form action="{{ route('employer.recruitment.index') }}" method="GET">
                <div class="row">

                    <div class="col-md-4 mt-2">
                        <input type="text" name="title" class="form-control" placeholder="title"
                            {{ request()->title ? 'value=' . request()->title : '' }}>
                    </div>
                    <div class="col-md-3 mt-2">
                        <select class="js-example-basic-multiple form-control" name="province[]" multiple="multiple">
                            @foreach ($province as $item)
                                <option value="{{ $item->province_id }}"
                                    {{ isset(request()->province) && in_array($item->province_id, request()->province) ? 'selected' : '' }}>
                                    {{ $item->name }}</option>
                            @endforeach
                        </select>

                    </div>
                    <div class="col-md-3 mt-2">
                        <button class="btn btn-success" type="submit">
                            <i class="fa fa-search"></i> Search
                        </button>
                        @if (isset(request()->title) || isset(request()->province))
                            <a href="{{ route('employer.recruitment.index') }}">
                                <button class="btn btn-info" type="button">
                                    <i class="fa fa-reply-all"></i> Back
                                </button>
                            </a>
                        @endif
                    </div>

                </div>

        </div>
        </form> --}}
        <div style="overflow: auto">
            <table class="table table-responsive-sm">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Slug</th>
                        <th>Preview Text</th>
                        <th>City</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @forelse($recruitment as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td><span>{{ $item->name }}</span></td>
                            <td>
                                <img style="height: 64px" class="img-thumbnail rounded"
                                    src="{{ $item->recruitment_url }}" />
                                </td>
                            <td><span>{{ $item->slug }}</span></td>
                            <td><span>{!! $item->preview_text !!}</span></td>
                            <td><span>{{ $item->province->name }}</span></td>
                            <td>
                                <a href="{{ route('employer.recruitment.edit', $item->id) }}"> <button
                                        class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button></a>
                                <form action="{{ route('employer.recruitment.destroy', $item->id) }}" method="POST"
                                    style="display: inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" type="submit"><i
                                            class="far fa-trash-alt"></i></button>
                                </form>

                                <button type="button" data-url="{{ route('employer.recruitment.show', $item->id) }}" class="btn btn-info btn-sm" data-toggle="modal"><i class="fa fa-eye"></i></button>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="9">Không có dữ liệu</td>
                        </tr>
                    @endforelse --}}
                </tbody>
            </table>
            <div>
                {{-- {{ $recruitment->links() }} --}}
            </div>
        </div>
    </div>
    <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
            
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div class="preview">
                        <h4>Job Description</h4>
                        <div class="preview-child"></div>
                    </div>
                    <div class="profile">
                        <h4>Required Knowledge, Skills, and Abilities</h4>
                        <div class="profile-child"></div>
                    </div>
                    <div class="benefit">
                        <h4>Education + Experience</h4>
                        <div class="benefit-child"></div>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
            
            </div>
        </div>
    </div>
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
                success: function (data) {
                    info = data.data;
                    console.log(info.preview_text);
                    $('.modal-title').html(info.name);
                    $('.preview-child').html(info.preview_text)
                    $('.profile-child').html(info.profile_text)
                    $('.benefit-child').html(info.benefit_text)
                    $('#myModal').modal('show');
                },
                error: function (e) {
                    console.log(e.message);
                }
            });
        });
    </script>
@endpush
