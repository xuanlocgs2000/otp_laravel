<div>
    <h1>
        Login with phone number
    </h1>
    @if(session('error')){
        <div style="color: red">
        {{ $message }}</div>
    }
    @endif
        
  
    <form action="{{ route(otp.generate) }}" method="POST">
    @csrf
        <label for="">Enter mobile</label>
        <input type="text" name="mobile_no" value="{{ old('mobile_no') }}" required placeholder="Enter mobile">
        <br>
        @error('mobile no')
        <strong style="color: red">
            {{ $message }}

        </strong>
        @enderror
        <br>
        <button type="submit">generate OTP</button>
    
    </form>
</div>