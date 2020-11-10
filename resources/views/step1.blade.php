@extends('vendor.swAuth.layouts.app')
@section('title')
    {{ $title ?? '' }}
@stop
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="mt-5">
                    <form method="POST" action="{{ route('receive.request')  }}">
                        @csrf
                        <div class="form-group">
                            <label for="inputPhone">phone number</label>
                            <input type="number" name="phone" class="form-control" id="inputPhone">

                            @if($errors->any())
                                <span role="alert">
                                    <strong>{{ $errors->first() }}</strong>
                                </span>
                            @endif

                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
