<link href="{{ asset('frontend/css/styles.css') }}" type="text/css" rel="stylesheet" media="screen" />
<link rel="stylesheet" href="{{ asset('frontend/css/custom.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/swiper-bundle.min.css') }}">
<link rel="stylesheet" href="https://sibforms.com/forms/end-form/build/sib-styles.css">
<link rel="stylesheet" href="{{ asset('frontend/css/animate.css') }}">

{{-- font & icons --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('frontend/fonts/fonts.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/icon/icomoon/style.css') }}">


@yield('page-css')
@stack('css')
