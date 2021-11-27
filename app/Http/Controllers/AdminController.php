<?php

namespace App\Http\Controllers;

use Auth;
use App\Admin;
use App\Distributor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function profile(){
        $distributor = Distributor::where('user_id', auth::user()->id)->first();
        return view('admin.profile', compact('distributor'));
    }

    public function profileSave(Request $request){
        $this->validate($request, [
            'name'    => 'required|string',
            'email'   => 'required|email|unique:mysql2.admins,email, '.auth::user()->id,
            'company' => 'nullable|string',
        ]);

        $distributor = Distributor::where('user_id', auth::user()->id)->first();
        if($distributor){
            $this->validate($request, [
                'gender'    => 'required|string',
            ]);
        }

        Admin::updateOrcreate(['id' => auth::user()->id], [
            'name'    => $request->name,
            'email'   => $request->email,
        ]);

        if($distributor){
            $distributor->company = $request->company;
            $distributor->gender       = $request->gender;
            $distributor->save();
        }

        return back()->with('success', 'Your profile has been updated successfully.');
    }

    public function profilePassword(){
        $distributor = Distributor::where('user_id', auth::user()->id)->first();
        return view('admin.profile', compact('distributor'));
    }

    public function PasswordChange(Request $request){
        $this->validate($request, [
            'current_password' => 'required|string',
            'password' => 'required|string|confirmed',
        ]);

        $old_pass = $request->input('current_password');

        $user = Admin::find(auth::user()->id);
        if (Hash::check($old_pass, $user->password)) {

            $password = Hash::make($request->input('password'));
            $user->password = $password;
            $user->save();
            return back()->with('success', 'Your password has been successfully updated.');
        }else{
            return back()->withErrors(array('current_password' => 'Your current password didnot matched.'));
        }

    }

}
