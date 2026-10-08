<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\GeneratedUrl;

class DashboardController extends Controller
{
    public function index()
    {
        $companies = Company::withCount(['users', 'generatedUrls'])
        ->withSum('generatedUrls', 'url_hits')
        ->get();

        $urls = GeneratedUrl::with(['company', 'user'])->get();

        return view('superadmin.dashboard', compact('companies', 'urls'));
    }
}