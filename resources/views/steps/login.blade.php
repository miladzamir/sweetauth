@extends('vendor.sweetauth.layout')
@section('title')
    ورود
@stop
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="mt-5">
                    <form method="POST" action="{{ route('login')  }}">
                        @csrf
                        <div class="form-group">
                            <label for="inputPhone">شماره همراه</label>
                            <input type="number" name="phone" class="form-control" id="inputPhone" value="{{ old('phone') }}">

                            @error('phone')
                                <span class="" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="inputPassword">رمز عبور</label>
                            <input type="password" name="password" class="form-control" id="inputPassword">

                            @error('phone')
                            <span class="" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>


                        <button type="submit" class="btn btn-primary">ثبت</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
