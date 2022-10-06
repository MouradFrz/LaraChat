<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    @vite('resources/css/extra.css')
</head>
<body>
    <div>
        <div class="login-panel">
            <h2>Register</h2>
            <form action="{{ route('user.create') }}" method="POST">
                @csrf
                <label for="">E-mail</label>
                <input type="email" class="mb-2" name="email">
                @error('email')
                    <p class="error">{{ $message }}</p>
                @enderror
                <label for="">Phone number</label>
                <input type="text" class="mb-2" name="phonenumber">
                @error('phonenumber')
                <p class="error">{{ $message }}</p>
                @enderror
                <label for="">Password</label>
                <input type="password" name="password" id="">
                @error('password')
                <p class="error">{{ $message }}</p>
                @enderror
                <label for="">Confirm Password</label>
                <input type="password" name="passwordConfirm" id="">
                @error('passwordConfirm')
                <p class="error">{{ $message }}</p>
                @enderror
                <input type="submit" value="Register" class="custom-button mt-2">
            </form>
            <p>Already have an account? <a href="{{ route('user.login') }}">Login</a></p>
        </div>
    </div>
</body>
</html>