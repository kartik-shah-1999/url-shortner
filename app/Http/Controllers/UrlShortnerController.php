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
        $urls = Url::with('user','company')->paginate(5);
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
        $filterType = null;
        $filterValue = null;
        $urls = Url::with('user','company')->paginate(5);
        switch($this->loggedInUserRole){
            case (RoleEnum::MEMBER) : 
                $filterType = 'user_id';
                $filterValue = [auth()->id()];
            break;
            case (RoleEnum::ADMIN)  : 
                $filterType = 'company_id';
                if(count(auth()->user()->company)){
                    foreach(auth()->user()->company as $company){
                        $filterValue[] = $company->id;
                    }
                }else{
                    $filterValue = null;
                }
            break;
            default:
                $filterType = null;
                $filterValue = null;
        }
        // return $filterValue;
        if($filterType && $filterValue){
            $urls = $urls->whereIn($filterType,$filterValue);
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
