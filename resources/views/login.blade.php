@extends('layout.app')

@section('title','Login | UD. Arisya')

@section('container')
<div class="content-body ml-0">
    <div class="login-form-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6">
                    <div class="form-input-content">
                        <div class="card login-form mb-0">
                            <div class="card-body pt-5">
                                <div class="text-center">
                                    <img src="{{asset('assets/images/Logo-abu.png')}}" width="150px" alt="">
                                </div>
                                <form action="/login" method="post" class="mt-5 mb-5 login-input">
                                    @csrf
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Username" name="username">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" placeholder="Password" name="password">
                                    </div>
                                    <button type="submit" class="btn login-form__btn submit w-100">Sign In</button>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(session()->has('status'))
    @include('layout.alert')
@endif
@endsection
    




