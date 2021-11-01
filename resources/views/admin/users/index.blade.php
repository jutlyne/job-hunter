@extends('layouts.admin.app')
@section('title', 'Users Manage')
@section('breadcrumb', 'User')
@section('content')

@push('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />    <style>
        .fit-content {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 160px;
            max-height: 60px;
        }
        button {
            border: none;
            background: none;
        }
        .action {
            font-size: 18px;
        }
    </style>

@endpush

    <div class="card">
        <div class="card-header"><i class="fa fa-align-justify"></i> Users Manage</div>
        <div class="card-body">
            <div class="row">
                <form action="{{ route('admin.users.index') }}" method="get" class='col-12 d-inline'>
                        <div class="col-md-5 col-xs-12 float-left p-0 mb-3 mr-3">
                            <input type="text" name="keyword" class="form-control bg-light" placeholder="Enter name or email" {{ request()->keyword ? "value=".request()->keyword : '' }}>
                        </div>
                </form>
            </div>
            <table class="table table-responsive-md">
                <thead>
                    <tr>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Address</th>
                      <th>Phone</th>
                      <th>Avatar</th>
                      <th>Registration Date</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($users as $item)
                        <tr>
                            <td>{{$item->name}}</td>
                            <td class="fit-content">{{$item->email}}</td>
                            <td class="fit-content">{{$item->address}}</td>
                            <td>{{$item->phone}}</td>
                            <td><img style="height: 50px" class="img-thumbnail rounded" src="{{$item->avatar_url}}"/></td>
                            <td>{{(isset($item->created_at)) ? date_format($item->created_at, "H:i d/m/Y") : "None"}}</td>
                            <td><button data-id="{{ $item->id }}">
                                @if ($item->status == 1)
                                    <i class="fa fa-check-circle action" style="color : green"></i>
                                @else
                                    <i class="fa fa-ban action" style="color : red"></i>
                                @endif
                            </button></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan='7'>
                            <div class='alert alert-warning col-12 text-center'>No users found</div>
                            </td>
                        </tr>
                    @endforelse   
                  </tbody>
            </table>
        </div>
    </div>
@endsection
@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
   $(document).ready(function(){
        $("button").click(function(){
            seft = $(this);
            id = $(this).data('id');
            $.ajax({
                url: "/admin2020/users/status/" + id,
                type: 'get',
                success: function (data) {
                    if (data.status == 1) {
                       seft.html(
                           `<i class="fa fa-check-circle action" style="color : green"></i>`
                       )
                       toastr.success('Change status success!', 'This page say')
                    } else {
                        seft.html(
                           `<i class="fa fa-ban action" style="color : red"></i>`
                        )
                       toastr.success('Change status success!', 'This page say')
                    }
                },
                error: function (e) {
                    console.log(e.message);
                }
            });
        });
    });
</script>
@endpush