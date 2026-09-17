<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShortUrlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'SuperAdmin') {
            $shortUrls = ShortUrl::with(['user', 'company'])
                ->latest()
                ->get();
        } elseif ($user->role === 'Admin') {
            $shortUrls = ShortUrl::with('user')
                ->where('company_id', $user->company_id)
                ->latest()
                ->get();
        } else {
            $shortUrls = ShortUrl::where('user_id', $user->id)
                ->latest()
                ->get();
        }

        return view('short_urls.index', compact('shortUrls'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('short_urls.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'original_url' => ['required', 'url'],
        ]);

        $shortUrl = ShortUrl::create([
            'user_id' => auth()->id(),
            'company_id' => auth()->user()->company_id,
            'original_url' => $validated['original_url'],
            'short_code' => Str::random(6),
        ]);

        return redirect()
            ->back()
            ->with('success', 'Short URL created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ShortUrl $shortUrl)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShortUrl $shortUrl)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ShortUrl $shortUrl)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShortUrl $shortUrl)
    {
        //
    }
    public function redirect(ShortUrl $shortUrl)
    {
        return redirect()->away($shortUrl->original_url);
    }
}
