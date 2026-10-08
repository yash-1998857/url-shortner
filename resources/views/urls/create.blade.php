<!DOCTYPE html>
<html>
<head>
    <title>Create Short URL</title>
</head>
<body>

<h2>Create Short URL</h2>
@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif
<form method="POST" action="{{ route('urls.store') }}">
    @csrf

    <div>
        <label>Long URL</label>
        <input type="url" name="long_url">
    </div>

    <br>

    <button type="submit">Create Short URL</button>
</form>

</body>
</html>