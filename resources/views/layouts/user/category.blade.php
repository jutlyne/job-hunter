<section id="scroll-here">
  <div class="block">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="heading">
            <h2>Popular Categories</h2>
          </div><!-- Heading -->
          <div class="cat-sec">
            <div class="row no-gape" style="justify-content: center">
              @foreach ($categories as $item)
                <div class="col-lg-3 col-md-3 col-sm-6">
                  <div class="p-category">
                    <a href="#" title="">
                      <i class="{{ $item->icon}}"></i>
                      <span>{{ $item->name }}</span>
                    </a>
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
<section>
  <div class="block double-gap-top double-gap-bottom">
    <div data-velocity="-.1" style="background: url(images/resource/parallax1.jpg) repeat scroll 50% 422.28px transparent;" class="parallax scrolly-invisible layer color"></div><!-- PARALLAX BACKGROUND IMAGE -->
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="simple-text-block">
            <h3>Make a Difference with Your Online Resume!</h3>
            <span>Your resume in minutes with JobHunt resume assistant is ready!</span>
            <a href="#" title="">Create an Account</a>
          </div>
        </div>
      </div>
    </div>	
  </div>
</section>