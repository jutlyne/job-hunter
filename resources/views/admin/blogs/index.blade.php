@extends('layouts.admin.app')
@section('title', 'Blogs Manage')
@section('breadcrumb', 'Blog')

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

    </style>
@endpush

@section('content')
    <div class="card">
        <div class="card-header">&nbsp;<i class="fa fa-align-justify"></i>&nbsp;Blogs Manage</div>
        <div class="card-body">
            <div class="d-flex mb-3">
                <a class="btn btn-primary" href="{{ route('admin.blogs.create') }}">Add New Blog</a>
            </div>
            <form action="{{ route('admin.blogs.index') }}" method="GET">
                <div class="row">

                    <div class="col-md-4 mt-2">
                        <input type="text" name="title" class="form-control" placeholder="Nhập title"
                            {{ request()->title ? 'value=' . request()->title : '' }}>
                    </div>
                    <div class="col-md-3 mt-2">
                        <select class="js-example-basic-multiple form-control" name="category[]" multiple="multiple"
                            placeholder="Category">
                            @foreach ($listCategory as $item)
                                <option value="{{ $item->id }}"
                                    {{ isset(request()->category) && in_array($item->id, request()->category) ? 'selected' : '' }}>
                                    {{ $item->name }}</option>
                            @endforeach
                        </select>

                    </div>
                    <div class="col-md-3 mt-2">
                        <button class="btn btn-success" type="submit">
                            <i class="fa fa-search"></i> Search
                        </button>
                        @if (isset(request()->title) || isset(request()->category))
                            <a href="{{ route('admin.blogs.index') }}">
                                <button class="btn btn-info" type="button">
                                    <i class="fa fa-reply-all"></i> Back
                                </button>
                            </a>
                        @endif
                    </div>

                </div>

        </div>
        </form>
        <div style="overflow: auto">
            <table class="table table-responsive-sm">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Image</th>
                        <th>Slug</th>
                        <th>Description</th>
                        <th>Seo title</th>
                        <th>Seo description</th>
                        <th>Seo keyword</th>
                        <th>Category</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($blogs as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td><span>{{ $item->title }}</span></td>
                            <td>
                                <img style="height: 64px" class="img-thumbnail rounded"
                                    src="{{ $item->blog_url }}" />
                                </td>
                            <td><span>{{ $item->slug }}</span></td>
                            <td><span>{{ $item->description }}</span></td>
                            <td><span>{{ $item->seo_title }}</span></td>
                            <td><span>{{ $item->seo_description }}</span></td>
                            <td><span>{{ $item->seo_keyword }}</span></td>
                            <td>
                                <span>
                                @foreach ($item->blogCategories as $itemCategory)
                                    <span>{{ $itemCategory->category->name ?? '' }} </span><br>
                                @endforeach
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.blogs.edit', $item->id) }}"> <button
                                        class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button></a>
                                <form action="{{ route('admin.blogs.destroy', $item->id) }}" method="POST"
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
                            <td class="text-center" colspan="9">No data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div>
                {{ $blogs->links() }}
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
    </script>
@endpush
