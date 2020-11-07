@extends('vendor.sweetauth.layout')
@section('title')
    فراموشی رمز عبور
@stop
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="mt-5">
                    <form method="POST" action="{{ route('receive.request')  }}">
                        @csrf
                        <div class="form-group">
                            <label for="inputPhone">شماره همراه</label>
                            <input type="number" name="phone" class="form-control" id="inputPhone">

                            @if($errors->any())
                                <span class="" role="alert">
                                    <strong>{{ $errors->first() }}</strong>
                                </span>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary">ثبت</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
