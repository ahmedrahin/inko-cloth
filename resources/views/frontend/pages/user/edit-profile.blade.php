@extends('frontend.layout.app')

@section('page-title')
    Edit Profile
@endsection


@section('body-content')

<section class="after-header p-tb-10">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="material-icons" title="Home">home</i></a></li>
            <li><a href="{{ route('user.dashboard') }}">Account</a></li>
            <li><a href="">Edit Profile</a></li>
        </ul>
    </div>
</section>

<div class="container ac-layout">
    <div class="ac-header">
        <div class="left">
            <span class="avatar">
                <img src="{{ auth()->user()->avatar ? asset(auth()->user()->avatar) : asset('frontend/image/user.png') }}"
                    width="80" height="80" alt="Ra"></span>
            <div class="name">
                <p>Hello,</p>
                <p class="user">{{ auth()->user()->name }}</p>
            </div>
        </div>
    </div>

    @include('frontend.pages.user.user-menu')

    <div class="ac-title">
        <h1>My Account Information</h1>
    </div>

    <livewire:frontend.user.edit-profile :user_id="$user->id" />

</div>

@endsection
