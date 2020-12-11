<?php

namespace App\Http\Controllers\URL;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Models\URLShort;
use Illuminate\Support\Facades\Auth;

class UrlController extends Controller
{
    public function index(){
        return view('welcome');
    }
 
    public function short(Request $request){
       //Validate the origianal url and custom alias
        $this->validate($request, [
            'original_url' => 'required|url',
            'custom_alias' => 'nullable|alpha_dash'
        ]);
        //check original url in the database
       $url = URLShort::where('original_url',$request->original_url)->first();
       //If no url found 
       if($url == null){
        //Check if user is logged in
        $user_id = $this->check_auth_user();                 
           //Initialize all the fields
            $original_url = $request->original_url;
            $custom_alias= $request->custom_alias;
            $hash = md5($original_url); 
            //Create the short use
           $short_url = $this->generateShortURL($custom_alias, $hash, $user_id);
           $expiration_date = $request->expiration_date;
           //check if the user has entered custom expiration date
           if($expiration_date == null){
            $expiration_date =$this->expire_date();
           }
           //Insert data into database
           $this->insert_into_database($user_id,$original_url,$custom_alias,$hash,$short_url,$expiration_date);
           $url = URLShort::where('original_url',$request->original_url)->first();
           return view('url.short_url', compact('url'));
       }else{
           //if url found
        return view('url.short_url', compact('url'));
       }
         
       
    }
    public function insert_into_database($user_id,$original_url,$custom_alias,$hash,$short_url,$expiration_date){
        URLShort::create([
            'user_id'=> $user_id,
           'original_url' => $original_url,
           'custom_alias'=> $custom_alias,
           'hash'=> $hash,
           'short_url' => $short_url,
           'expiration_date'=>$expiration_date, 
       ]);

    }
    public function check_auth_user(){
        if($user = Auth::user())
        { 
            $user_id = Auth::user()->id;
            return $user_id;
        }else{      
            $user_id = 1;
            return $user_id;
        }
    }

    public function generateShortURL($custom_alias, $hash,$user_id){
      //Check if the user has entered the custom alias
        if($custom_alias==null){
            //if Custom alias is not entered
            $short_url = $this->make_short($hash);
            $result = $short_url.$user_id;
        }else{
              //if Custom alias is entered check if same custom alias is in database or not
            $check_custom_alias = URLShort::where('short_url',$custom_alias)->first();
            if($check_custom_alias != null){
                //If Custom alias is found in database
                print("The alias you enter is already in use. Please try again!");
                exit();
            }else{
                 //If Custom alias is not in database the accept it and return it as a short url
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
        $todays_date= date("Y-m-d");
        $exp_date = date('Y-m-d', strtotime($todays_date. ' + 1 years'));
        return $exp_date;
    }
    public function logout(){
        auth()->logout();
    // redirect to homepage
    return redirect('/');
    }
}
