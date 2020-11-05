<h3>inter your phone number!</h3>
<br/>

<form method="POST" action="{{ route('receive.request')  }}">
    @csrf
    <input name="phone" type="number" placeholder="inter your number!" class="text" value="{{ $phone ?? '' }}" />
    <br/>
    <input type="submit" class="submit">
    <br/>
    <br/>
</form>

@if(session()->has('ReceiveAndStored'))
    @dd(session('ReceiveAndStored'))
@endif

@if(!empty($errors))
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div>{{$error ?? ''}}</div>
        @endforeach
    @endif
@endif
