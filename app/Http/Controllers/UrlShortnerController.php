<?php

namespace App\Http\Controllers;

use App\RoleEnum;
use Exception;
use App\Models\Url;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UrlShortnerController extends Controller
{
    protected $loggedInUserRole;

    public function __construct(){
        if(auth()->check()){
            $this->loggedInUserRole = auth()->user()->roles[0]->pivot->user_role;
        }
    }
    public function index(){
        return view('urlshortner');
    }

    public function showAllUrls(){
        $urls = Url::with('user','company')->paginate(5);
        return view('urls')->with('urls',$urls);
    }

    public function urlShortner(Request $request){
        $request->validate([
            'long_url' => ['required', 'url']
        ]);
        try{
            $url = $request->input('long_url');
            $parsed = parse_url($url);
            $root = env("ROOT_DOMAIN",'127.0.0.1:8000');
            $uri  = ($parsed['path'] ?? '/').(isset($parsed['query']) ? '?' . $parsed['query'] : '');
            $uniqHash = Str::random(7);
            $shortUrl = $root.'/'.$uniqHash;
            Url::updateOrCreate([
                'original_url' => $url,
                'user_id' => auth()->user()->id,
                'company_id' => auth()->user()->company->id
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

    public function shortenedUrls(){
        $filterType = null;
        $filterValue = null;
        $urls = Url::with('user','company')->paginate(5);
        switch($this->loggedInUserRole){
            case (RoleEnum::MEMBER) : 
                $filterType = 'user_id';
                $filterValue = auth()->id();
            break;
            case (RoleEnum::ADMIN)  : 
                $filterType = 'company_id';
                $filterValue = auth()->user()->company->id ?? null;
            break;
            default:
                $filterType = null;
                $filterValue = null;
        }
        if($filterType && $filterValue){
            $urls = $urls->where($filterType,$filterValue);
        }
        return view('urls')->with('urls',$urls);
    }

    public function redirectUrl($hash){
        $url = Url::where('hash', $hash)->value('original_url');
        if (!$url) {
            abort(404);
        }
        return redirect($url);
    }
}
