<!DOCTYPE html>
<html>
<head>
    <title>Invite User</title>
</head>
<body>

<h2>Invite User</h2>
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Logout</button>
</form>
<a href="{{ route('urls.create') }}">Create Short URL</a>
@if(auth()->user()->role == 'admin')
    <a href="{{ route('invite.user') }}">Invite User</a>
@endif

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif
<form method="POST" action="{{ route('invite.user.store') }}">
    @csrf

    <div>
        <label>Email</label>
        <input type="email" name="email">
    </div>

    <br>

    <div>
        <label>Role</label>

        <select name="role">
            <option value="member">Member</option>
            <option value="admin">Admin</option>
        </select>
    </div>

    <br>

    <button type="submit">Send Invitation</button>
</form>

</body>
</html>