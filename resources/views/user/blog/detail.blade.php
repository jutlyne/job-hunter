@extends('layouts.user.app')
@section('title', $blog->seo_title)
@section('description', $blog->seo_description)
@section('keywords', $blog->seo_keyword)
@section('ogurl', url()->current())
@section('ogtitle', $blog->seo_title)
@section('ogdescription', $blog->seo_description)
@section('ogimage', $blog->blog_url)
@section('ogtype', 'article')



@push('styles')
    <link rel="stylesheet" href="{{ asset('custom/css/detail.css') }}">
    <style>
        p {
            word-wrap: break-word;
        }

        .blog-single img {
            width: 100%;
        }

    </style>

@endpush

@section('content')
    <div id="fb-root"></div>
    <section class="overlape">
        <div class="block no-padding">
            <div data-velocity="-.1"
                style="background: url(images/resource/mslider1.jpg) repeat scroll 50% 422.28px transparent;"
                class="parallax scrolly-invisible no-parallax"></div><!-- PARALLAX BACKGROUND IMAGE -->
            <div class="container fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="inner-header">
                            <h3>{{ $blog->title }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        @php
            $timestamp = strtotime($blog->created_at);
            $month = date('F j, Y', $timestamp);
        @endphp
        <div class="block">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 column">
                        <div class="blog-single">
                            <div class="bs-thumb"><img src="{{ $blog->blog_url }}" alt="" /></div>
                            @foreach ($blog->blogCategories as $item)
                                <ul class="post-metas">
                                    <li><a href="#" title=""><i class="la la-calendar-o"></i>{{ $month }}</a></li>
                                    <li><a href="{{ route('user.blog.category', $item->category->id) }}"" title=""><i class="
                                            
                                            la la-file-text"></i>{{ $item->category->name ?? '' }}</a>
                                    </li>
                                </ul>
                            @endforeach
                            <h2>{{ $blog->description }}</h2>
                            {!! nl2br($blog->content) !!}
                            <div class="tags-share">
                                    <div class="share-bar fb-share-button" data-href="{{ url()->current() }}"
                                        data-layout="button_count" data-size="small"><a target="_blank"
                                            href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}"
                                            class="fb-xfbml-parse-ignore">Chia sẻ</a></div>
                            </div>
                        </div>
                        <div class="fb-comments" data-href="{{ route('user.blog.detail', $blog->slug) }}"
                            data-width="100%" data-numposts="5"></div>
                    </div>
                    @include('layouts.user.blog-right')
                </div>
            </div>
        </div>
    </section>

@endsection

@push('script')
    <script src="{{ asset('rating/jquery.barrating.min.js') }}"></script>
    <script type="text/javascript" src="jquery.iframe-auto-height.plugin.js"></script>
    <script async defer crossorigin="anonymous"
        src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v12.0&appId=633590544477813&autoLogAppEvents=1"
        nonce="hxi6KvP1"></script>
@endpush
