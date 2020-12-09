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
        //checks original_url entered by customer exists on database or not.
       $url = URLShort::where('original_url',$request->original_url)->first();

       if($url == null){
            $user_id = Auth::user()->id;
            $original_url = $request->original_url;
            $custom_alias= $request->custom_alias;
            $hash = md5($original_url);  
           $short_url = $this->generateShortURL($custom_alias, $hash, $user_id);
           $expiration_date = $request->expiration_date;
           if($expiration_date == null){
            $expiration_date =$this->expire_date();
           }
           URLShort::create([
                'user_id'=> $user_id,
               'original_url' => $original_url,
               'custom_alias'=> $custom_alias,
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

    public function generateShortURL($custom_alias, $hash,$user_id){
      
        if($custom_alias==null){
            $short_url = $this->make_short($hash);
            $result = $short_url.$user_id;
        }else{
            $check_custom_alias = URLShort::where('short_url',$custom_alias)->first();
            if($check_custom_alias != null){
                print("The alias you enter is already in use. Please try again!");
                exit();
            }else{
                return $custom_alias;
            }
            
        }
        $check_short_url = URLShort::where('original_url',$result)->first();
        if($check_short_url != null){
            $this->generateShortUrl($custom_alias, $hash,$user_id);
        }
        return $result;

    }
   
    public function make_short($hash){
        $first_six = substr($hash,0,6);
        $first_str =$first_six[0];
        $last_str =$first_six[5];
        $hash_result = substr_replace($first_six,$last_str,0,1);
        $hash_result = substr_replace($hash_result,$first_str,5,1);
        return $hash_result;
    }

    public function shortLink($link){
       
        $url = URLShort::where('short_url',$link)->first();
        return redirect($url->original_url);

    }
    public function expire_date(){
        $todays_date= date("d-m-Y");
        $exp_date = date('d-m-Y', strtotime($todays_date. ' + 1 years'));
        return $exp_date;
    }
    public function logout(){
        auth()->logout();
    // redirect to homepage
    return redirect('/');
    }
}
