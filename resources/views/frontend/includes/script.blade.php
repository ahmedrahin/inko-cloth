<script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
<script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('frontend/js/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('frontend/js/carousel.js') }}"></script>
<script src="{{ asset('frontend/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('frontend/js/lazysize.min.js') }}"></script>
<script src="{{ asset('frontend/js/wow.min.js') }}"></script>
<script src="{{ asset('frontend/js/infinityslide.js') }}"></script>
<script src="{{ asset('frontend/js/parallaxie.js') }}"></script>
<script src="{{ asset('frontend/js/count-down.js') }}"></script>
<script src="{{ asset('frontend/js/main.js') }}"></script>
<script src="{{ asset('frontend/js/sibforms.js') }}" defer></script>


@yield('page-script')
@yield('addcart-js')
@stack('scripts')
