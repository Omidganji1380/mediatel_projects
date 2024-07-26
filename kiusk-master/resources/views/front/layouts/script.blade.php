    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> --}}
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.nav-link').click(function(e) {
                // e.preventDefault(); // Prevent default redirect behavior
                console.log('clicked');
                // Check if the viewport width is less than or equal to 768px (Bootstrap's mobile breakpoint)
                if (window.innerWidth <= 768) {
                    // Toggle the "active" class on the nested <ul> element
                    $(this).next('.inner-ul').addClass('active');
                }
            });
        });
    </script>
    @if (
        !request()->routeIs(
            'front.blog.category.news.index.first.page',
            'front.blog.category.news.index',
            'front.blog.category.blog.index',
            'front.home'))
        <script>
            document.querySelector('.colpas-button').addEventListener("click", () => {
                document.querySelector(".fa-search").classList.toggle('d-none');
                document.querySelector(".fa-times").classList.toggle('disply');
            })
        </script>
    @endif

    @stack('scripts')
