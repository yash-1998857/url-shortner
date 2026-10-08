<!DOCTYPE html>
<html>
<head>
    <title>Invitation Created</title>
</head>
<body>

<h2>Invitation Created</h2>
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Logout</button>
</form>
<a href="{{ route('urls.create') }}">Create Short URL</a>
@if(auth()->user()->role == 'admin')
    <a href="{{ route('invite.user') }}">Invite User</a>
@endif
<p>Share this invitation link with the user:</p>

<input type="text" value="{{ $invitationLink }}" readonly>

</body>
</html>