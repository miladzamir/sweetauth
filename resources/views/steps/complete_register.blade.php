<h3>Last register Steppppp!!!!</h3>
<br/>

<form method="POST" action="{{ route('create.user')  }}">
    @csrf
    <input name="password" type="password" placeholder="inter your password!" class="text" value="" />
    <input name="password_confirmation" type="password" placeholder="inter your password!" class="text" value="" />
    <br/>
    <input type="submit" class="submit">
    <br/>
    <br/>
</form>

@if(session()->has('isVerify'))
   {{ session('isVerify') }}
@endif

@if(!empty($errors))
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div>{{$error ?? ''}}</div>
        @endforeach
    @endif
@endif
