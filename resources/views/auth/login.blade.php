<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #6a3093 0%, #a044ff 50%, #f107a3 100%);
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-container {
            background: white;
            padding: 40px 30px;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 300px;
        }
        .login-container h1 {
            margin-bottom: 20px;
            font-size: 28px;
            font-weight: bold;
            color: #6a3093;
        }
        .login-container input {
            width: calc(100% - 22px);
            padding: 10px;
            margin: 12px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .login-container button {
            width: 35%;
            padding: 10px;
            background: #a044ff;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 10px;
            cursor: pointer;
            margin-top: 15px;
        }
        .login-container button:hover {
            background: #6a3093;
        }
        .login-container .register-link {
            margin-top: 15px;
            display: block;
            color: #6a3093;
            text-decoration: none;
            font-size: 14px;
        }
        .login-container .register-link:hover {
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
<div class="login-container">
    <h1>Sign in</h1>
    @if ($errors->any())
        <div class="error-messages">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <input type="text" name="username" value="{{ old('username') }}" placeholder="username" required>
        <input type="password" name="password" placeholder="password" required>
        <button type="submit">LOGIN</button>
    </form>
    <a class="register-link" href="{{ route('register') }}">Don't have an account? Register</a>
</div>
</body>
</html>
