<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>My Application</title>
</head>
<body>
@yield('content')
</body>
</html>
