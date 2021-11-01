@extends('layouts.admin.app')
@section('title', 'Employers Request')
@section('breadcrumb', 'Employer Request')

@section('content')
    <div class="card">
        <div class="card-header"><i class="fa fa-align-justify"></i>Mở tài khoản Employer</div>
        <div class="card-body">
            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
            <div class="row">
                <div class="col-md-6 col-12">
                    <a class="btn btn-secondary"
                       href="{{ route('admin.employers.index') }}">Quay lại</a>
                </div>
                <div class="col-md-6 col-12 d-flex justify-content-end mb-3">
                    <a class="btn btn-primary" href="{{ route('admin.employers.create') }}">Thêm employer mới</a>
                </div>
            </div>

            <table class="table table-responsive-sm">
                <thead>
                <tr>
                    <th>Chủ employer</th>
                    <th>Email</th>
                    <th>Tên employer</th>
                    <th>Địa chỉ</th>
                    <th>Số điện thoại</th>
                    <th>&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($employers as $item)
                    <tr>
                        <td>{{ $item->owner ?? ''}}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->address ?? '' }}</td>
                        <td>{{ $item->phone }}</td>
                        <td>
                            <a class="btn btn-success"  href="#" data-employer-id="{{ $item->id }}"
                               data-toggle="modal" data-target="#active-employer-modal">
                                Kích hoạt
                            </a>
{{--                            <a class="btn btn-success" href="{{ route('admin.employers.request.active', $item->id) }}">Active</a>--}}
                            <a class="btn btn-danger"  href="#" data-employer-id="{{ $item->id }}"
                               data-toggle="modal" data-target="#delete-employer-modal">
                                Từ chối
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {!! $employers->links() !!}
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="active-employer-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Kích hoạt employer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Xác nhận yêu cầu kích hoạt?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <form method="POST" action="">
                        @csrf
                        <button type="submit" class="btn btn-primary">Xác nhận</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="delete-employer-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Xóa yêu cầu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc muốn xóa yêu cầu?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <form method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-primary">Xóa</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
      $('#active-employer-modal').on('show.coreui.modal', function(e) {
        const employerId = e.relatedTarget.dataset.employerId;
        const url = "{{ route('admin.employers.request.active', ':id') }}";
        $(this).find('form').attr('action', url.replace(':id', employerId));
      })

      $('#delete-employer-modal').on('show.coreui.modal', function(e) {
        const employerId = e.relatedTarget.dataset.employerId;
        const url = "{{ route('admin.employers.destroy', ':id') }}";
        $(this).find('form').attr('action', url.replace(':id', employerId));
      })
    </script>
@endpush