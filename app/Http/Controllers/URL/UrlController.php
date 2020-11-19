<?php

namespace App\Http\Controllers\URL;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Models\URLShort;


class UrlController extends Controller
{
    public function short(Request $request){
    
        //checks url exists on database or not.s
       $url = URLShort::whereUrl($request->url)->first();
    
       if($url == null){
    
           $short = $this->generateShortURL();
           URLShort::create([
               'url' => $request->url,
               'short' => $short
             
           ]);

           $url = URLShort::whereUrl($request->url)->first();
           return view('url.short_url', compact('url'));
       }else{
        return view('url.short_url', compact('url'));
       }
         
       
    }

    public function generateShortURL(){
        $result = base_convert(rand(1000, 9999999), 10, 36);
        $data = URLShort::whereShort($result)->first();

        if($data != null){
            $this->generateShortUrl();
        }
        return $result;

    }

    public function shortLink($link){
        $url = URLShort::whereShort($link)->first();
        return redirect($url->url);

    }
}
