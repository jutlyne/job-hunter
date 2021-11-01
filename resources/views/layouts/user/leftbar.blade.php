@push('styles')
    <link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }} ">
@endpush

<aside class="col-lg-3 column border-right">
    <div class="widget">
        <div class="tree_widget-sec">
            <ul>
                <li><a href="{{ route('user.profile') }}" title=""><i class="la la-file-text"></i>My Profile</a></li>
                <li><a href="candidates_my_resume.html" class="building" title=""><i class="la la-briefcase"></i>My
                        Resume</a></li>
                <li><a href="{{ route('user.apply') }}" class="" title=""><i
                            class="la la-paper-plane"></i>Applied Job</a></li>
                <li><a href="candidates_cv_cover_letter.html" class="building" title=""><i
                            class="la la-file-text"></i>Cv & Cover
                        Letter</a></li>
                <li><a href="{{ route('user.password') }}" title=""><i class="la la-flash"></i>Change Password</a>
                </li>
                <li>
                    <a href="" title="">
                        <form id="logout-form" action="{{ route('user.logout') }}" method="POST">
                            @csrf
                            <button class="dropdown-item" type="submit" style="padding: 0; color: #888888"><i
                                    class="la la-unlink"></i>Logout</button>
                        </form>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</aside>

@push('script')
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script>
        $('.building').on('click', function(e) {
            e.preventDefault();
            let timerInterval
            Swal.fire({
                icon: 'error',
                title: 'Under development!',
                html: 'This feature is still in development',
                timer: 3500,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading()
                    const b = Swal.getHtmlContainer().querySelector('b')
                    timerInterval = setInterval(() => {
                        b.textContent = Swal.getTimerLeft()
                    }, 100)
                },
                willClose: () => {
                    clearInterval(timerInterval)
                }
            }).then((result) => {
                /* Read more about handling dismissals below */
                if (result.dismiss === Swal.DismissReason.timer) {
                    console.log('I was closed by the timer')
                }
            })
        })
    </script>
@endpush
