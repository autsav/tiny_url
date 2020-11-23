<?php

namespace App\Http\Controllers\URL;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Models\URLShort;
use Illuminate\Support\Facades\Auth;

class UrlController extends Controller
{
    public function short(Request $request){
        $this->validate($request, [
            'original_url' => 'required|url',
            'custom_alias' => 'nullable|alpha_dash'
        ]);
        //checks url exists on database or not.
       $url = URLShort::where('original_url',$request->original_url)->first();
       if($url == null){
            $user_id = Auth::user()->id;
            $original_url = $request->original_url;
            $custom_alias= $request->custom_alias;
            $hash = md5($original_url);
           
           $short_url = $this->generateShortURL($custom_alias, $hash);
           $expiration_date =$this->expire_date();
    
           URLShort::create([
                'user_id'=> $user_id,
               'original_url' => $original_url,
               'custom_alias'=> $custom_alias=null,
               'hash'=> $hash,
               'short_url' => $short_url,
               'expiration_date'=>$expiration_date, 
           ]);
           $url = URLShort::where('original_url',$request->original_url)->first();
           return view('url.short_url', compact('url'));
       }else{
        return view('url.short_url', compact('url'));
       }
         
       
    }

    public function generateShortURL($custom_alias, $hash){
      
        if($custom_alias==null){
            $short_url = $this->make_short($hash);
            $result = $short_url;
        }
        $check_short_url = URLShort::where('original_url',$result)->first();
        if($check_short_url != null){
            $this->generateShortUrl($custom_alias, $hash);
        }
        return $result;

    }
    public function make_short($hash){
        $first_eight = substr($hash,0,8);
        $first_str =$first_eight[0];
        $last_str =$first_eight[6];
        $hash_result = substr_replace($first_eight,$last_str,0,1);
        $hash_result = substr_replace($hash_result,$first_str,6,1);
        return $hash_result;
    }

    public function shortLink($link){
       
        $url = URLShort::where('short_url',$link)->first();
        return redirect($url->original_url);

    }
    public function expire_date(){
        $todays_date= date("Y-m-d");
        $exp_date = date('Y-m-d', strtotime($todays_date. ' + 1 years'));
        return $exp_date;
    }
    
}
