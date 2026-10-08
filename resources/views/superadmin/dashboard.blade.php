<h1>SuperAdmin Dashboard</h1>

<p>Welcome, {{ Auth::guard('superadmin')->user()->username }}</p>

<a href="{{ route('superadmin.company.create') }}">Invite New Client</a>

<form method="POST" action="{{ route('superadmin.logout') }}">
    @csrf
    <button type="submit">Logout</button>
</form>

<h2>Companies</h2>

<table border="1" cellpadding="8">
    <thead>
        <tr>
            <th>Company Name</th>
            <th>Users</th>
            <th>Total Generated URLs</th>
            <th>Total URL Hits</th>
        </tr>
    </thead>

    <tbody>
        @foreach($companies as $company)
            <tr>
                <td>{{ $company->company_name }}</td>
                <td>{{ $company->users_count }}</td>
                <td>{{ $company->generated_urls_count }}</td>
                <td>{{ $company->generated_urls_sum_url_hits ?? 0 }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<h2>All Generated URLs</h2>

<table border="1" cellpadding="8">
    <thead>
        <tr>
            <th>Company</th>
            <th>Created By</th>
            <th>Long URL</th>
            <th>Short URL</th>
            <th>Hits</th>
        </tr>
    </thead>

    <tbody>
        @foreach($urls as $url)
            <tr>
                <td>{{ $url->company->company_name }}</td>
                <td>{{ $url->user->email }}</td>
                <td>{{ $url->long_url }}</td>
                <td>
                    <a href="{{ url($url->short_url) }}" target="_blank">
                        {{ url($url->short_url) }}
                    </a>
                </td>
                <td>{{ $url->url_hits }}</td>
            </tr>
        @endforeach
    </tbody>
</table>