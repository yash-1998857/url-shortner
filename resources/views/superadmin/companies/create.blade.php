<!DOCTYPE html>
<html>
<head>
    <title>Invite New Client</title>
</head>
<body>

<h2>Invite New Client</h2>
@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif
<form method="POST" action="{{ route('superadmin.company.store') }}">
    @csrf

    <div>
        <label>Company Name</label>
        <input type="text" name="company_name">
    </div>

    <br>

    <div>
        <label>Admin Email</label>
        <input type="email" name="email">
    </div>

    <br>

    <button type="submit">Send Invitation</button>
</form>

</body>
</html>