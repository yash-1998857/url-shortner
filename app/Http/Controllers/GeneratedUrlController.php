<?php

namespace App\Http\Controllers;

use App\Models\GeneratedUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GeneratedUrlController extends Controller
{
    public function create()
    {
        return view('urls.create');
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'long_url' => 'required|url',
        ]);

        $user = auth()->user();
        if ($user->role !== 'admin' && $user->role !== 'member') {
            abort(403);
        }
        $shortCode = Str::random(6);

        GeneratedUrl::create([
            'company_id' => $user->company_id,
            'user_id' => $user->id,
            'long_url' => $request->long_url,
            'short_url' => $shortCode,
        ]);

        return redirect('/dashboard');
    }

    public function redirect($shortUrl)
    {
        $url = GeneratedUrl::where('short_url', $shortUrl)->first();

        if (!$url) {
            return 'Short URL not found';
        }

        $url->increment('url_hits');

        return redirect($url->long_url);
    }
}