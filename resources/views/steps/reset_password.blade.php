@extends('vendor.sweetauth.layout')
@section('title')
    تغییر رمز عبور
@stop
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="mt-5">
                    <form method="POST" action="{{ route('user.password')  }}">
                        @csrf
                        <div class="form-group">
                            <label for="inputPassword">رمز عبور</label>
                            <input type="password" name="password" class="form-control" id="inputPassword">
                            @if($errors->any())
                                <span class="" role="alert">
                                    <strong>{{ $errors->first() }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="inputPasswordConfirmation">تکرار ‌رمز عبور</label>
                            <input type="password" name="password_confirmation" class="form-control" id="inputPasswordConfirmation">
                        </div>

                        <div>
                            @if(Session::has('isReceiveAndStored'))
                                کد ارسال برای شماره {{ Session::get('isReceiveAndStored') }} ارسال شد
                                <br /><br />
                                ۱۵ دقیقه فرصت دارید تا کد تایید را وارد کنید
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary">ثبت</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
