@extends('layouts.admin.app')
@section('title', 'Blog Categories')
@section('breadcrumb', 'Blog Categories')

@push('style')
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <style>
        td span {
            overflow: hidden;
            display: -webkit-inline-box;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
        }

    </style>
@endpush

@section('content')
    <div class="card">
        <div class="card-header">&nbsp;<i class="fa fa-align-justify"></i>&nbsp;Category</div>
        <div>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>
                                <form action="{{ route('admin.category.destroy', $item->id) }}" method="POST"
                                    style="display: inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" type="submit"><i
                                            class="far fa-trash-alt"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="3">Không có dữ liệu</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $categories->links() }}
        </div>
    </div>
   
@endsection

@push('script')
    <script>
        $(document).on("click", ".btn-danger", function(e) {
            if (!confirm('Dữ liệu xóa sẽ không thể phục hồi ?')) {
                e.preventDefault();
            }
        });
    </script>
@endpush
