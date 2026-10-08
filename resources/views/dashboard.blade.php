<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>

<h2>User Dashboard</h2>

<p>
    Logged in as: {{ auth()->user()->email }}
</p>

<p>
    Role: {{ auth()->user()->role }}
</p>
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Logout</button>
</form>
<a href="{{ route('urls.create') }}">Create Short URL</a>
@if(auth()->user()->role == 'admin')
    <a href="{{ route('invite.user') }}">Invite User</a>
@endif
<br><br>

<table border="1" cellpadding="8">
    <tr>
        <th>Long URL</th>
        <th>Short URL</th>
        <th>Hits</th>
    </tr>

    @foreach($urls as $url)
        <tr>
            <td>{{ $url->long_url }}</td>
            <td>
                <a href="{{ url($url->short_url) }}" target="_blank">
                    {{ url($url->short_url) }}
                </a>
            </td>
            <td>{{ $url->url_hits }}</td>
        </tr>
    @endforeach

</table>

</body>
</html>