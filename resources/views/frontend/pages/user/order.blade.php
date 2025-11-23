@extends('frontend.layout.app')

@section('page-title')
    My Orders
@endsection


@section('body-content')

    <section class="s-page-title">
        <div class="container">
            <div class="content">
                <h1 class="title-page">@yield('page-title')</h1>
                <ul class="breadcrumbs-page">
                    <li><a href="{{ route('homepage') }}" class="h6 link">Home</a></li>
                    <li class="d-flex"><i class="icon icon-caret-right"></i></li>
                    <li><a href="{{ route('user.dashboard') }}" class="h6 link">My Dashboard</a></li>
                    <li class="d-flex"><i class="icon icon-caret-right"></i></li>
                    <li>
                        <h6 class="current-page fw-normal">@yield('page-title')</h6>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <section class="flat-spacing">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 d-none d-xl-block">
                    @include('frontend.pages.user.user-menu')
                </div>

                <div class="col-xl-9">
                   
                </div>
            </div>
        </div>
    </section>
@endsection
