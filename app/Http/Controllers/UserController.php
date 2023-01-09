<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Network;
use Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function loadRegister()
    {
        return view('register');
    }
    public function registered(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);
        $referralCode = Str::random(10);
        $token=Str::random(50);

        if (isset($request->referral_code)) {

            $userdata = User::where('referral_code', '=', $request->referral_code)->get();
            // $admin = AdminAuth::where('email', '=', $request->email)->first();
            //error_log($userdata);
         // print_r(gettype($userdata));



            if (count($userdata) > 0) {

                // $user_id = User::insertGetID([
                //     'name' => $request->name,
                //     error_log($request->name),
                //     'email' => $request->email,
                //     error_log($request->email),
                //     'password' => Hash::make($request->password),

                //     'referral_code' => $referralCode,
                //     error_log($referralCode)
                // ]);
                $user = new User;
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = Hash::make($request->password);
                $user->referral_code =$referralCode;
                $user->remember_token= $token;
               $user->save();


                $network=new Network;
                $network->referral_code= $request->referral_code;
                $network->user_id = $user->id;
                $network->parant_user_id = $userdata[0]['id'];
                $network->save();
                // Network::insert([
                //     'referral_code' => $request->referral_code,
                //     'user_id' => $res,
                //     'parant-user_id' => $userdata[0]['id'],
                // ]);

                //return redirect('registerd');
            } else {

                return back()->with('error', 'Please enter Valid Referral Code!!!');
            }
        } else {
            User::insert([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'referral_code' => $referralCode,
                'remember_token'=> $token
            ]);
        }
//sent the mail
       $domain= URL::to('/');

       $url =$domain.'/referral-register?ref='.$referralCode;

       $data['url']=$url;
       $data['name']=$request->name;
       $data['email']=$request->email;
       $data['password']=Hash::make($request->password);
       $data['title']='Registered';


        Mail::send('emails.registerMail',['data'=>$data],function($message) use($data){
           $message->to($data['email'])->subject($data['title']);
       });

       //Verification mail

       $url =$domain.'/email-verification/'.$token;

       $data['url']=$url;
       $data['name']=$request->name;
       $data['email']=$request->email;
       $data['title']='Referral Verification Mail';

       Mail::send('emails.verifyMail',['data'=>$data],function($message) use($data){
        $message->to($data['email'])->subject($data['title']);
    });

        return back()->with('success', 'Your Registration has been Successsful & Please verify your mail!!!');
    }
    public function loadReferralRegister(Request $request){
        if(isset($request->ref)){
            $referral=$request->ref;
            error_log($referral);
           $userData= User::where('referral_code',$referral)->get();
           error_log($userData);
           if(count($userData)>0){
            error_log(count($userData));
               return view('referralRegister',compact('referral'));

           }
           else{
               return view('404');
           }

        }else{
            return redirect('/');
        }
    }
    public function emailVerification($token){
$userToken=User::where('remember_token',$token)->get();
error_log(count($userToken));
if(count($userToken)>0){

        if($userToken[0]['is_verified']==1){
            error_log($userToken[0]['is_verified']);
            return view('emails.verified',['message'=>'Your mail is already verified!!']);
        }
        User::where('id',$userToken[0]['id'])->update([
            'is_verified'=>1,
            'email_verified_at'=>date('y-m-d H:i:s')
        ]);
        return view('emails.verified',['message'=>'Your' .$userToken[0]['email']. ' mail verified Successfulyl!!']);



    }else{
        return view('emails.verified',['message'=>'404 Page not Found']);
    }
}
public function loadLogin(){
    return view('login');
}
public function userLogin(Request $request){
    $request->validate([
        'email'=>'required|string|email',
        'password'=>'required'
    ]);

    $userLogin=User::where('email',$request->email)->first();
    // error_log($userLogin);
    if(!empty($userLogin)){
        if($userLogin->is_verified == 0){
            return back()->with('error','Please verify your mail!');
        }
    }

   $credentials = [
    'email' => $request['email'],
    'password' => $request['password'],
];


   if(Auth::attempt($credentials)){

    //    error_log(1);
       return redirect('/dashboard');
   }else{
        error_log(0);
        return back()->with('error','Username & Password is incoreect!');
   }
}
public function loaddashboard(){

$networkCount=Network::where('parant_user_id',Auth::user()->id)->orwhere('user_id',Auth::user()->id)->count();
error_log($networkCount);
$networkData=Network::with('user')->where('parant_user_id',Auth::user()->id)->get();
error_log($networkData);
return view('dashboard',compact(['networkCount','networkData']));
}
public function logout(Request $request){

    $request->session()->flush();
    Auth::logout();
    return redirect('/');

}
}
