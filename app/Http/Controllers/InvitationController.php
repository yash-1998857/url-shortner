<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class InvitationController extends Controller
{
    public function showRegistration($token)
    {
        $invitation = Invitation::where('token', $token)->first();

        if (!$invitation) {
            return 'Invalid invitation link';
        }

        return view('auth.register', compact('invitation'));
    }

    public function register(Request $request, $token)
    {
        $invitation = Invitation::where('token', $token)->first();

        if (!$invitation) {
            return 'Invalid invitation link';
        }
        $email = $invitation->email;

        $name = explode('@', $email)[0];

        $request->validate([
            'password' => 'required|confirmed|min:6',
        ]);

        $user = User::create([
            'company_id' => $invitation->company_id,
            'name' => $name,
            'email' => $invitation->email,
            'password' => Hash::make($request->password),
            'role' => $invitation->role,
        ]);

        return redirect('/login');
    }

    public function create()
    {
        return view('auth.invite-user');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,member',
        ]);

        $user = auth()->user();

        $invitation = Invitation::create([
            'company_id' => $user->company_id,
            'email' => $request->email,
            'role' => $request->role,
            'token' => Str::random(40),
        ]);

        $invitationLink = url('/register/invite/' . $invitation->token);

        return view('auth.invitation', compact('invitationLink'));
    }
}