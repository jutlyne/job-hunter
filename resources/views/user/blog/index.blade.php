@extends('layouts.user.app')
@section('title', 'List blog Job Hunt')
@section('description', 'List blog Job Hunt')
@section('keywords', 'List blog Job Hunt')
@section('ogtype', 'article')
@section('ogurl', url()->current())


@push('styles')
    <link rel="stylesheet" href="{{ asset('custom/css/app.css') }}">
    <style>
        .slide {
            max-width: 100%;
        }

    </style>
@endpush

@section('content')
<section class="overlape">
    <div class="block no-padding">
        <div data-velocity="-.1" style="background: url(images/resource/mslider1.jpg) repeat scroll 50% 422.28px transparent;" class="parallax scrolly-invisible no-parallax"></div><!-- PARALLAX BACKGROUND IMAGE -->
        <div class="container fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner-header">
                        <h3>Blog</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="block">
        <div class="container">
             <div class="row">
                 <div class="col-lg-9 column">
                     <div class="bloglist-sec">
                         @foreach ($blogs as $item)
                            @php
                                $timestamp = strtotime($item->created_at);
                                $month = date('F j, Y', $timestamp);
                            @endphp
                            <div class="blogpost">
                                <div class="blog-posthumb"> <a href="{{ route('user.blog.detail', $item->slug) }}" title=""><img src="{{ $item->blog_url }}" height="350" alt="" /></a> </div>
                                <div class="blog-postdetail">
                                    <ul class="post-metas"><li><a href="{{ route('user.blog.detail', $item->slug) }}" title=""><i class="la la-calendar-o"></i>{{ $month }}</a></li></ul>
                                    <h3><a href="{{ route('user.blog.detail', $item->slug) }}" title="">{{ $item->title }}</a></h3>
                                    <p>{{ $item->description }}</p>
                                    <a class="bbutton" href="{{ route('user.blog.detail', $item->slug) }}" title="">Read More</a>
                                </div>
                            </div><!-- Blog Post -->
                         @endforeach
                     </div>
                     {{ $blogs->links('vendor.pagination.custom') }}
                </div>
                @include('layouts.user.blog-right')
             </div>
        </div>
    </div>
</section>
@endsection

@push('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        // var j = 1, i = 0
        // function getData() {
        //     $.ajax({
        //         url: "/blogs/load/" + j,
        //         type: 'get',
        //         success: function (data) {
        //             for(i; i < data.blog.length; i++) {
        //                 $('.bloglist-sec').append(`
                        
        //                 `)
        //             }
        //             j++;
        //         },
        //         error: function (e) {
        //             console.log(e.message);
        //         }
        //     });
        // }
    </script>
@endpush
