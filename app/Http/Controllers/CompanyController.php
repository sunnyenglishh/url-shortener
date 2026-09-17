<?php

namespace App\Http\Controllers;

use App\Mail\UserInvitationMail;
use App\Models\Company;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Str;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::latest()->get();

        return view('companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('companies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        Company::create($validated);

        return redirect()
            ->route('companies.index')
            ->with('success', 'Company created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('companies.edit', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $company = Company::findOrFail($id);

        return view('companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $company = Company::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $company->update($validated);

        return redirect()
            ->route('companies.index')
            ->with('success', 'Company updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $company->delete();

        return redirect()
            ->route('companies.index')
            ->with('success', 'Company deleted successfully.');
    }

    public function invite(Company $company)
    {
        $users = User::where('company_id', $company->id)
            ->whereIn('role', ['Admin', 'Member'])
            ->get();

        return view('companies.invite', compact('company', 'users'));
    }

    public function sendInvite(Request $request, Company $company)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'role' => ['required', 'in:Admin,Member'],
        ]);

        $token = Str::random(64);

        $invitation = Invitation::create([
            'company_id' => $company->id,
            'email' => $validated['email'],
            'role' => $validated['role'],
            'token' => $token,
        ]);

        $invitation->load('company');

        Mail::to($invitation->email)
            ->send(new UserInvitationMail($invitation));
        return redirect()->route('companies.index')->with('success', 'Invitation created.');
    }
}
