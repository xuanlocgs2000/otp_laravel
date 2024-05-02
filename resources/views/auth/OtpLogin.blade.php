<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login with phone number</title>
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
        <h1>Login with phone number</h1>
        @if(session('error'))
            <div style="color: red">
                {{ session('error')}}
            </div>
        @endif

        <form action="{{ route('otp.generate') }}" method="POST">
            @csrf
            <label for="mobile_no">Enter mobile</label>
            <input type="text" id="mobile_no" name="mobile_no" value="{{ old('mobile_no') }}" required placeholder="Enter mobile">
            <br>
            @error('mobile_no')
                <strong style="color: red">
                    {{ $message }}
                </strong>
            @enderror
            <br>
            <button type="submit">Generate OTP</button>
        </form>
    </div>
</body>
</html>
