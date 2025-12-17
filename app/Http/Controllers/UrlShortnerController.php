<?php

namespace App\Http\Controllers;

use App\Models\UserCompany;
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
        $companies = UserCompany::with('userCompany')->where('user_id',auth()->id())->get();
        return view('urlshortner')->with('companies',$companies);
    }

    public function showAllUrls(){
        $urls = Url::with('user','company')->get();
        return view('urls')->with('urls',$urls);
    }

    public function urlShortner(Request $request){
        $request->validate([
            'long_url' => ['required', 'url'],
            'company_id' => ['required']
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
            ],[
                'company_id' => $request->input('company_id'),
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
        $filterValue = null;
        $urls = Url::with('user','company')->get();
        switch($this->loggedInUserRole){
            case (RoleEnum::MEMBER) : 
                $filterValue = auth()->id();
                $urls = $urls->where('user_id',auth()->id());
            break;
            case (RoleEnum::ADMIN)  : 
                if(count(auth()->user()->company->toArray())){
                    foreach(auth()->user()->company as $company){
                        $filterValue[] = $company->id;
                    }
                }else{
                    $filterValue = null;
                }
                $urls = $urls->whereIn('company_id',$filterValue);
            break;
            default:
                $filterValue = null;
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
