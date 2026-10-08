<!DOCTYPE html>
<html>
<head>
    <title>SuperAdmin Login</title>
</head>
<body>

<h2>SuperAdmin Login</h2>
<p>
    Are you Admin / Member?
    <a href="{{ route('login') }}">User Login</a>
</p>
@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif
<form method="POST" action="{{ route('superadmin.login.submit') }}">
    @csrf

    <div>
        <label>Email</label>
        <input type="email" name="email">
    </div>

    <div>
        <label>Password</label>
        <input type="password" name="password">
    </div>

    <button type="submit">Login</button>
</form>

@if ($errors->any())
    <div>
        {{ $errors->first() }}
    </div>
@endif

</body>
</html>