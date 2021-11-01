@extends('layouts.admin.app')
@section('title', 'Employers Manage')
@section('breadcrumb', 'Employer')

@section('content')
    <div class="card">
        <div class="card-header"><i class="fa fa-align-justify"></i>&nbsp Employers</div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6 col-12 mb-2">
                    <a class="btn btn-outline-danger"
                       href="{{ route('admin.employers.request') }}">List of requests to create an employer</a>
                </div>
                <div class="col-sm-6 d-flex justify-content-end mb-3 col-12 button-add-new-employer">
                    <a class="btn btn-primary" href="{{ route('admin.employers.create') }}">Add a new employer</a>
                </div>
            </div>
            <div class="row">
                <form action="" method="get" class='col-12'>
                    <div class="col-xs-12 form-group col-md-5 float-left p-0 mb-3 mr-3">
                        <select name="province_id" class='form-control bg-light'>
                            <option value="">----</option>
                            @foreach ($provinces as $province)
                            <option value="{{ $province->province_id }}" {{ isset(request()->province_id) && request()->province_id == $province->province_id ? 'selected' : '' }}>
                                {{ $province->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 form-group col-xs-12 float-left p-0 mb-3 mr-3">
                        <button class="btn btn-success" type="submit">
                            <i class="fa fa-search"></i> Search
                        </button>
                        @if(isset(request()->province_id))
                            <a href="{{ route('admin.employers.index') }}">
                                <button class="btn btn-info" type="button">
                                    <i class="fa fa-reply-all"></i> Back
                                </button>
                            </a>
                        @endif
                    </div>
                </form>
            </div>
            <table class="table table-responsive-sm">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Adress</th>
                        <th>City</th>
                        <th>Phone</th>
                        <th>Prioritized</th>
                        <th>&nbsp;</th>
                    </tr>
                  </thead>
                  <tbody>
                      @foreach ($employers as $item)
                      <tr>
                        <td><img style="height: 64px" class="img-thumbnail rounded" src="{{ $item->thumbnail_url }}"/></td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->address }}</td>
                        <td>{{ $item->province->name ?? '' }}</td>
                        <td>{{ $item->phone }}</td>
                        <td>{{ ($item->prioritize == 1 )? 'Prioritize' : 'No prioritize' }}</td>
                        <td>
                            <a href="{{ route('admin.employers.show', $item->id) }}">view</a>/
                            <a href="{{ route('admin.employers.edit', $item->id) }}">edit</a>/
                            <a href="#" data-employer-id="{{ $item->id }}" data-toggle="modal" data-target="#delete-employer-modal">delete</a>/
                            <a href="#" data-employer-id="{{ $item->id }}" data-toggle="modal" data-target="#prioritize-employer-modal">{{$item->prioritize ? ' off-prioritize' : ' on-prioritize'}}</a>/
                            <a href="#" data-employer-id="{{ $item->id }}" data-toggle="modal" data-target="#status-employer-modal">in-active</a>
                        </td>
                      </tr>
                      @endforeach
                  </tbody>
            </table>
            {!! $employers->appends(request()->all())->links() !!}
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="delete-employer-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete employer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete employer?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <form method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-primary">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="prioritize-employer-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-employers">
                <div class="modal-header">
                    <h5 class="modal-title">Priority mode</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <p>Change this employer's preference?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <form method="POST" action="">
                        @csrf
                        <button type="submit" class="btn btn-primary">Agree</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="status-employer-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-employers">
                <div class="modal-header">
                    <h5 class="modal-title">Change employer status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Change this employer's status to inactive?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <form method="POST" action="">
                        @csrf
                        <button type="submit" class="btn btn-primary">Agree</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script>
    $('#delete-employer-modal').on('show.coreui.modal', function(e) {
        const employerId = e.relatedTarget.dataset.employerId;
        const url = "{{ route('admin.employers.destroy', ':id') }}";
        $(this).find('form').attr('action', url.replace(':id', employerId));
    })

    $('#prioritize-employer-modal').on('show.coreui.modal', function(e) {
        const employerId = e.relatedTarget.dataset.employerId;
        const url = "{{ route('admin.employers.prioritize', ':id') }}";
        $(this).find('form').attr('action', url.replace(':id', employerId));
    })
    
    $('#status-employer-modal').on('show.coreui.modal', function(e) {
        const employerId = e.relatedTarget.dataset.employerId;
        const url = "{{ route('admin.employers.status', ':id') }}";
        $(this).find('form').attr('action', url.replace(':id', employerId));
    })
</script>
@endpush
