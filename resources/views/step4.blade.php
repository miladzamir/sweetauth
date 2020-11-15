@extends('vendor.swAuth.layouts.app')
@section('title')
    {{ $title ?? '' }}
@stop
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="mt-5">
                    <form method="POST" action="{{ route('logChar')  }}">
                        @csrf
                        <div class="form-group">
                            <label for="inputPassword">username</label>
                            <input type="number" name="phone" class="form-control" id="inputPhone" value="{{ old(('phone'))  }}">

                            @error('phone')
                                <span role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>

                        <div class="form-group">
                            <label for="inputPassword">password</label>
                            <input type="password" name="password" class="form-control" id="inputPassword">
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
