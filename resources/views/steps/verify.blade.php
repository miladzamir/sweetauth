<h3>verify your phone number!</h3>
<br/>
<form method="POST" action="{{ route('verify.request')  }}">
    @csrf
    <input name="token" type="number" placeholder="inter your token!" class="text" />
    <br/>
    <input type="submit" class="submit">
    <br/>
    <br/>
</form>

@if(Session::has('isReceiveAndStored'))
    کد ارسال برای شماره {{ Session::get('isReceiveAndStored') }} ارسال شد
    <br /><br /><br />
    ۱۵ دقیقه فرصت دارید تا کد تایید را وارد کنید
@endif

@if (!empty($errors))
    @foreach ($errors->all() as $error)
        <div>{{$error ?? ''}}</div>
    @endforeach
@endif
