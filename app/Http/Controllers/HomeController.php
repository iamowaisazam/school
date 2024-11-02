<?php

namespace App\Http\Controllers;


use App\Models\Brand;
use App\Models\Product;
use App\Models\newsletter;
use App\Models\Attribute;
use App\Models\Value;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Page;
use App\Models\ProductCollection;
use App\Models\Variation;
use App\Models\VariationAttribute;
use App\Models\Slider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mime\Part\HtmlPart;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function login()
    {
        if (Auth::check()){
                return redirect('/dashboard');
        }
        
        return view('login');
    }


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function login_submit(Request $request)
    {
        if (Auth::check()){
            return redirect('/dashboard'); 
       }

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8|max:255',
        ]);
        
    
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }


        $user = User::where('email',$request->email)->first();
        if($user == null){
            return back()
                ->withErrors([
                    "email" => ["Wrong Email Or Password"],
                    "password" => ["Wrong Email Or Password"]
                ])->withInput();
        }

        if(Hash::check($request->password, $user->password)) {
            
            if (Auth::attempt([
                'email' =>$request->email,
                'password' => $request->password])){
                 return redirect('/dashboard'); 
            }

        } else {

               return back()
                ->withErrors([
                    "email" => ["Wrong Email Or Password"],
                    "password" => ["Wrong Email Or Password"]
                ])->withInput();
        }


    }


    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function dashboard()
    {
        
        return view('dashboard');
    }

         
}
