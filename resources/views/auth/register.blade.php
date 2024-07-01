<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #f107a3 0%, #a044ff 50%, #6a3093 100%);
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .register-container {
            background: white;
            padding: 40px 30px;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 300px;
        }
        .register-container h1 {
            margin-bottom: 20px;
            font-size: 28px;
            font-weight: bold;
            color: #6a3093;
        }
        .register-container input {
            width: calc(100% - 22px);
            padding: 10px;
            margin: 12px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .register-container button {
            width: 50%;
            padding: 10px;
            background: #a044ff;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 10px;
            cursor: pointer;
            margin-top: 15px;
        }
        .register-container button:hover {
            background: #6a3093;
        }
        .register-container .login-link {
            margin-top: 15px;
            display: block;
            color: #6a3093;
            text-decoration: none;
            font-size: 14px;
        }
        .register-container .login-link:hover {
            text-decoration: underline;
        }
        .error-messages {
            color: red;
            margin-bottom: 20px;
        }
        .error-messages ul {
            list-style-type: none;
            padding: 0;
        }
    </style>
</head>
<body>
<div class="register-container">
    <h1>Register</h1>
    @if ($errors->any())
        <div class="error-messages">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <input type="text" name="username" value="{{ old('username') }}" placeholder="username" required>
        <input type="email" name="email" value="{{ old('email') }}" placeholder="email" required>
        <input type="password" name="password" placeholder="password" required>
        <input type="password" name="password_confirmation" placeholder="confirm password" required>
        <input type="text" name="first_name" value="{{ old('first_name') }}" placeholder="first name" required>
        <input type="text" name="last_name" value="{{ old('last_name') }}" placeholder="last name" required>
        <button type="submit">Register</button>
    </form>
    <a class="login-link" href="{{ route('login') }}">Already have an account? Login</a>
</div>
</body>
</html>
