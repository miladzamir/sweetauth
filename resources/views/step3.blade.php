@extends('vendor.swAuth.layouts.app')
@section('title')
    {{ $title ?? '' }}
@stop
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="mt-5">
                    <form method="POST" action="{{ route('create.user')  }}">
                        @csrf
                        <div class="form-group">
                            <label for="inputPassword">password</label>
                            <input type="password" name="password" class="form-control" id="inputPassword">

                            @if($errors->any())
                                <span role="alert">
                                    <strong>{{ $errors->first() }}</strong>
                                </span>
                            @endif

                        </div>

                        <div class="form-group">
                            <label for="inputPasswordConfirmation">password</label>
                            <input type="password" name="password_confirmation" class="form-control" id="inputPasswordConfirmation">
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
