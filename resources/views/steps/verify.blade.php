@extends('vendor.sweetauth.layout')
@section('title')
    تایید شماره
@stop
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="mt-5">
                    <form method="POST" action="{{ route('verify.request')  }}">
                        @csrf
                        <div class="form-group">
                            <label for="inputToken">کد تایید</label>
                            <input type="number" name="token" class="form-control" id="inputToken">

                            @if($errors->any())
                                <span class="" role="alert">
                                    <strong>{{ $errors->first() }}</strong>
                                </span>
                            @endif
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
