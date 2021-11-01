<aside class="col-lg-3 column">
   <div class="widget">
       <h3>Categories</h3>
       <div class="sidebar-links">
           @foreach ($shareBlogCategories as $item)
                <a href="{{ route('user.blog.category', $item->id) }}" title=""><i class="la la-angle-right"></i>{{ $item->name }}</a>
           @endforeach
       </div>
   </div>
   <div class="widget">
       <h3>Recent Posts</h3>
       @foreach ($shareDataBlog as $item)
        @php
            $timestamp = strtotime($item->created_at);
            $month = date('F j, Y', $timestamp);
        @endphp
        <div class="post_widget">
            <div class="mini-blog">
                <span><a href="{{ route('user.blog.detail', $item->slug) }}" title=""><img src="{{ $item->blog_url }}" height="70px" alt="" /></a></span>
                <div class="mb-info">
                    <h3><a href="{{ route('user.blog.detail', $item->slug) }}" title="">{{ $item->title }}</a></h3>
                    <span>{{ $month }}</span>
                </div>
            </div>
        </div>
       @endforeach
   </div>
</aside>