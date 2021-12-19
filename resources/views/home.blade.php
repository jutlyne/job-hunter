@extends('layouts.user.app')

@section('title', 'Jobs Hunt')
@section('content')
    @include('layouts.user.search')
    @include('layouts.user.category')
    <section>
		<div class="block">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="heading">
							<h2>Featured Jobs</h2>
							<span>Leading Employers already using job and talent.</span>
						</div><!-- Heading -->
						<div class="job-listings-sec">
							@foreach ($jobs as $item)
								<div class="job-listing">
									<div class="job-title-sec">
										<div class="c-logo"> <img src="{{ $item->recruitment_url }}" alt="" /></div>
										<h3 style="padding: 10px 20px"><a href="{{ route('user.recruitment.detail', $item->slug) }}" title="">&nbsp{{ $item->name }}</a></h3>
									</div>
									<span class="job-lctn"><i class="la la-map-marker"></i>{{ $item->province->name }}</span>
									<span class="fav-job"><i class="la la-heart-o"></i></span>
									<span class="job-is ft">{{ \App\Enums\Gender::toSelectArray()[$item->gender] }}</span>
								</div><!-- Job -->
							@endforeach
						</div>
					</div>
					{{-- <div class="col-lg-12">
						<div class="browse-all-cat">
							<a href="#" title="">Load more listings</a>
						</div>
					</div> --}}
				</div>
			</div>
		</div>
	</section>
    @include('layouts.user.top-blog')
@endsection

@push('script')
    <script>
      showSlides(1);

      function showSlides(slideIndex) {
        var slides = document.getElementsByClassName("mySlides");
        var dots = document.getElementsByClassName("clickSlider");
        for (let i = 0; i < slides.length; i++) {
          slides[i].style.display = "none";
        }
        for (let i = 0; i < dots.length; i++) {
          dots[i].className = dots[i].className.replace(" active", "");
          slides[i].className = slides[i].className.replace(" imageActive", "");
        }
        slides[slideIndex - 1].style.display = "block";
        dots[slideIndex - 1].className += " active";
        slides[slideIndex - 1].className += " imageActive";
      }
    </script>
@endpush
