<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Distributor;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Encryption\DecryptException;

class DistributorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create|edit|delete');
    }

    public function index(){
        $distributors = Admin::where('id', '>', 2)->get();
        return view("distributors.index", compact('distributors'));
    }

    public function store(Request $request){
        $this->validate($request, [
            'name'           => 'required|string',
            'email'          => 'required|string|email|max:255|unique:mysql2.admins,email',
            'gender'         => 'required|string',
            'company_name'   => 'nullable|string',
            'status'         => 'required|numeric',
        ]);

        $admin = Admin::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make('password'),
            'active'   => $request->status,
        ]);

        Distributor::create([
            'user_id' => $admin->id,
            'gender'  => $request->gender,
            'company' => $request->company_name,
        ]);

        //Assign role as distributor
        $admin->assignRole('distributor');

        $response = ['success' => 'Successfull'];
        return $response;
    }

    public function view(Request $request){
        $this->validate($request, [
            'id' => 'required',
        ]);

        $id = decrypt($request->id);

        $data = [];
        $data['status'] = false;
        $admin = Admin::findOrFail($id);
        if($admin){
            $data['id'] = encrypt($admin->id);
            $data['name'] = $admin->name;
            $data['email'] = $admin->email;
            $data['gender'] = $admin->distributor->gender;
            $data['company'] = $admin->distributor->company;
            $data['admin_status'] = $admin->active;
            $data['status'] = true;
        }

        return $data;
    }

    public function edit(Request $request){
        $this->validate($request, [
            'id'             => 'required|string',
            'name'           => 'required|string',
            'email'          => 'required|string|max:255|email',
            'gender'         => 'required|string',
            'company_name'   => 'nullable|string',
            'status'         => 'required|numeric',
        ]);
        $admin = Admin::findOrFail(decrypt($request->id));
        if($admin){
            $this->validate($request, [
                'email'          => 'unique:mysql2.admins,email,'.$admin->id.',id',
            ]);

            $admin->name = $request->name;
            $admin->email = $request->email;
            $admin->active = $request->status;
            $admin->save();

            Distributor::UpdateOrCreate(['user_id' => $admin->id], [
                'user_id' => $admin->id,
                'gender'  => $request->gender,
                'company' => $request->company_name,
            ]);
            $response = ['success' => 'Successfull'];
            return $response;
        }else{
            return false;
        }

    }

    public function delete($distributor){
        try {
            $id = decrypt($distributor);
        } catch (DecryptException $e) {
            return back()->with('error', 'Please try again !');
        }

        $distributor = Admin::findOrFail($id);
        $movieCount = count($distributor->moviesAdded);
        $seasonCount = count($distributor->seasonsAdded);
        if($movieCount == 0 && $seasonCount == 0){
            $distributor->distributor->delete();
            $distributor->delete();
            return back()->with('success', 'Distributor has been deleted successfully.');
        }
        else{
            return back()->with('error', 'This distributor has active movies or seasons !');
        }
    }

    public function test(){
        $admin = Admin::find(3);
        return $admin->distributor->gender;
    }

}
