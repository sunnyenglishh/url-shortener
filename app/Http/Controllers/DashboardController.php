<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'SuperAdmin') {

            $companies = Company::get();

            $shortUrls = ShortUrl::with(['user', 'company'])
                ->latest()
                ->get();

            return view('dashboard', compact(
                'companies',
                'shortUrls'
            ));
        }

        if ($user->role === 'Admin') {

            $shortUrls = ShortUrl::with('user')
                ->where('company_id', $user->company_id)
                ->latest()
                ->get();

            $teamMembers = User::where('company_id', $user->company_id)
                ->whereIn('role', ['Admin', 'Member'])
                ->get();

            return view('dashboard', compact(
                'shortUrls',
                'teamMembers'
            ));
        }

        $shortUrls = ShortUrl::where('user_id', $user->id)
            ->latest()
            ->get();

        return view('dashboard', compact('shortUrls'));
    }
}
