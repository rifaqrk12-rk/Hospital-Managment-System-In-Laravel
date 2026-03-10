<?php

namespace App\Http\Controllers\login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\patient;

class RegisterController extends Controller
{
    public function index(Request $request)
    {

        $request->validate([

            'name' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed',
            'phone' => 'required|',
            'address' => 'required'
        ]);

        $data = patient::create([

            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'phone' => $request->phone,
            'address' => $request->address,
            'role'=>'patient'
        ]);

        if (!$data) {
            return redirect()->route('register')->with('error', 'Not Inserted Successfully');
        }

        return redirect()->route('login')->with('success', 'Inserted Successfully');
    }

    public function login(Request $request){

        $request->validate([

            'email'=>'required',
            'password'=>'required',
        ]);

        $data=patient::where('email',$request->email)->where('password',$request->password)->first();

        if($data){
            session()->put('user_id',$data->id);
            session()->put('email',$data->email);
            session()->put('role',$data->role);

            if($data->role=='admin'){
                return redirect()->route('admin')->with('success','Welcome to dashbord');
            }
            elseif($data->role=='patient'){
                 return redirect()->route('patient')->with('success','Welcome to dashbord');
            }

        }
        else{
            return redirect()->route('login')->with('error','Account Not found ');
        }

       
    }

    public function logout(){
        session()->flush();
        return redirect()->route('login')->with('success','You are successfully Logout');
    }
}
