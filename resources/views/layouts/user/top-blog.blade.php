<section>
    <div class="block">
        <div data-velocity="-.1" style="background: url(images/resource/parallax3.jpg) repeat scroll 50% 422.28px transparent;" class="parallax scrolly-invisible no-parallax"></div><!-- PARALLAX BACKGROUND IMAGE -->
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="heading">
                        <h2>Quick Career Tips</h2>
                        <span>Found by employers communicate directly with hiring managers and recruiters.</span>
                    </div><!-- Heading -->
                    <div class="blog-sec">
                        <div class="row">
                            @foreach ($shareDataBlog as $item)
                            @php
                                $timestamp = strtotime($item->created_at);
                                $month = date('F j, Y', $timestamp);
                            @endphp
                            <div class="col-lg-4">
                                <div class="my-blog">
                                    <div class="blog-thumb">
                                        <a href="{{ route('user.blog.detail', $item->slug) }}" title=""><img src="{{ $item->blog_url }}" alt="" /></a>
                                        <div class="blog-metas">
                                            <a href="#" title="">{{$month}}</a>
                                        </div>
                                    </div>
                                    <div class="blog-details">
                                        <h3><a href="{{ route('user.blog.detail', $item->slug) }}" title="">{{ $item->title }}</a></h3>
                                        <p>{{ $item->description }} </p>
                                        <a href="{{ route('user.blog.detail', $item->slug) }}" title="">Read More <i class="la la-long-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>