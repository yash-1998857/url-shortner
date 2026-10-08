<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    public function create()
    {
        return view('superadmin.companies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required',
            'email' => 'required|email|unique:users,email',
        ]);
        DB::beginTransaction();

        try {
        $company = Company::create([
            'company_name' => $request->company_name,
        ]);

        $invitation = Invitation::create([
            'company_id' => $company->id,
            'email' => $request->email,
            'role' => 'admin',
            'token' => Str::random(40),
        ]);
        DB::commit();
        $invitationLink = url('/register/invite/' . $invitation->token);

        return view('superadmin.companies.invitation', compact('invitationLink'));
        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', 'Unable to create client. Please try again.');
        }
    }
}