<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        form {
            text-align: center;
        }
    </style>
</head>
<body>
    <div>
        @if(session('success'))
            <div style="color: green">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div style="color: red">
                {{ session('error') }}
            </div>
        @endif
        <form action="{{ route('otp.getlogin') }}" method="POST">
            @csrf
            <input type="hidden" name="user_id" value= "{{ $user_id }}">
            <label for="otp">OTP</label>
            <br>
            <input type="text" id="otp" name="otp" value="{{ old('otp') }}" required placeholder="ENTER OTP">
            <br>
            @error('otp')
                <strong style="color: red">{{ $message }}</strong>
            @enderror
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
