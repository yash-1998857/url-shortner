<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>

<h2>Complete Registration</h2>
@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif
<form method="POST" action="{{ route('invitation.register.submit', $invitation->token) }}">
    @csrf
    <div>
        <label>Email</label>
        <input type="email" value="{{ $invitation->email }}" readonly>
    </div>

    <br>

    <div>
        <label>Password</label>
        <input type="password" name="password">
    </div>

    <br>

    <div>
        <label>Confirm Password</label>
        <input type="password" name="password_confirmation">
    </div>

    <br>

    <button type="submit">Register</button>
</form>

</body>
</html>