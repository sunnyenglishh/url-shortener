<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class InvitationController extends Controller
{
    public function show(string $token)
    {
        $invitation = Invitation::where('token', $token)->firstOrFail();

        return view('invitations.register', compact('invitation'));
    }

    public function register(Request $request, string $token)
    {
        $invitation = Invitation::where('token', $token)->firstOrFail();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $invitation->email,
            'password' => Hash::make($validated['password']),
            'role' => $invitation->role,
            'company_id' => $invitation->company_id,
        ]);

        $invitation->delete();

        return redirect('/login')
            ->with('success', 'Registration successful. Please login.');
    }
}
