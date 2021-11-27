<?php

namespace App\Http\Controllers;

use Image;
use App\Cast;
use Illuminate\Http\Request;

class CastController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create|edit|delete');
    }

    public function index(){
        $casts = Cast::orderBy('updated_at', 'DESC')->get();
        return view('cast.index', compact('casts'));
    }

    public function addCast(Request $request){
       $this->validate($request, [
           'file' => 'required|file|image|max:200',
           'castName'  => 'required|string',
           'gender'  => 'required|string',
       ]);

       $photo = $request->file('file');
       $filename = time() . '.' . $photo->getClientOriginalExtension();

       $location = public_path('storage/casts/') . $filename;
        //Store image in public folder
        Image::make($photo)->resize(276,350)->save($location);

       //store photo
        // $photo->storeAs('public/casts', $filename);

       Cast::create([
           'name' => $request->castName,
           'gender' => $request->gender,
           'photo' => $filename,
       ]);

       $response = ['success' => 'Successfull'];

       return $response;
    }

    public function viewCast(Request $request){
        $this->validate($request, [
            'id' => 'required',
        ]);

        $id = decrypt($request->id);

        $data = [];
        $data['status'] = false;
        $cast = Cast::findOrFail($id);
        if($cast){
            $data['id'] = encrypt($cast->id);
            $data['name'] = $cast->name;
            $data['gender'] = $cast->gender;
            $data['photo'] = $cast->photo;
            $data['status'] = true;
        }

        return $data;
    }

    public function editCast(Request $request){
        $this->validate($request, [
            'id' => 'required|string',
            'castName'  => 'required|string',
            'gender'  => 'required|string',
        ]);

        if($request->file != '0'){
           $this->validate($request, [
            'file' => 'nullable|file|image|max:200',
           ]);
        }

        $data = [];
        $data['status'] = false;

        $photo = $request->file('file');
        if($photo != 0){
            $filename = time() . '.' . $photo->getClientOriginalExtension();

            $location = public_path('storage/casts/') . $filename;

            $cast = Cast::findOrFail(decrypt($request->id));
            //Delete Old photo
            $folder = "casts";
            $this->unlinked($cast->photo, $folder);
            //Store image in public folder
            Image::make($photo)->resize(276,350)->save($location);
            $cast->update([
                'name' => $request->castName,
                'gender' => $request->gender,
                'photo' => $filename,
            ]);

            $data['status'] = true;
        }
        else{
            Cast::where('id',  decrypt($request->id))->update([
                'name' => $request->castName,
                'gender' => $request->gender,
            ]);
            $data['status'] = true;
        }


        $response = ['success' => 'Successfull'];

        return $response;
     }

     public function deleteCast(Request $request){
         $cast = Cast::findOrFail(decrypt($request->cast));
         //Delete Old photo
         $folder = "casts";
         $this->unlinked($cast->photo, $folder);
         $cast->delete();
         return redirect(route('cast'))->with('success', 'Cast has been deleted successfully');
     }

     public function unlinked($name, $folder)
    {
        if ($name != null && $name != 'default.jpg') {
            $old = 'storage/'.$folder.'/' . $name;
            unlink($old);
        }
    }
}
