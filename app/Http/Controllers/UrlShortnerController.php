<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Url;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UrlShortnerController extends Controller
{
    public function index(){
        return view('urlshortner');
    }

    public function urlShortner(Request $request){
        $request->validate([
            'long_url' => ['required', 'url']
        ]);
        try{
            $url = $request->input('long_url');
            $parsed = parse_url($url);
            $root = $parsed['scheme'].'://'.$parsed['host'];
            $uri  = ($parsed['path'] ?? '/').(isset($parsed['query']) ? '?' . $parsed['query'] : '');
            $uniqHash = Str::random(7);
            $shortUrl = ($uri == '/') ? $root : $root.'/'.$uniqHash;
            // do {
                // $hash = Str::random(7);
            // } while (Url::where('hash', $hash)->exists());
            // $shortUrl = url('/') . '/' . $hash;
            Url::updateOrCreate([
                'original_url' => $url,
                'user_id' => auth()->user()->id
            ],[
                'shortened_url' => $shortUrl,
                'hash' => $uniqHash,
            ]);
            return response()->json(['shortenedUrl' => $shortUrl, 'originalUrl' => $url]);
        }catch(Exception $e){
            Log::error($e);
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
