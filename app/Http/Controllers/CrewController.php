<?php

namespace App\Http\Controllers;

use App\Crew;
use Image;
use Illuminate\Http\Request;

class CrewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create|edit|delete');
    }

    public function index(){
        $crew = Crew::orderBy('updated_at', 'DESC')->get();
        return view('crew.index', compact('crew'));
    }

    public function addCrew(Request $request){
        $this->validate($request, [
            'file' => 'required|file|image|max:200',
            'crewName'  => 'required|string',
            'gender'  => 'required|string',
        ]);

        $photo = $request->file('file');
        $filename = time() . '.' . $photo->getClientOriginalExtension();

        $location = public_path('storage/crews/') . $filename;
         //Store image in public folder
         Image::make($photo)->resize(276,350)->save($location);

        //store photo
         // $photo->storeAs('public/crews', $filename);

        Crew::create([
            'name' => $request->crewName,
            'gender' => $request->gender,
            'photo' => $filename,
        ]);

        $response = ['success' => 'Successfull'];

        return $response;
    }

    public function viewCrew(Request $request){
        $this->validate($request, [
            'id' => 'required',
        ]);

        $id = decrypt($request->id);

        $data = [];
        $data['status'] = false;
        $crew = Crew::findOrFail($id);
        if($crew){
            $data['id'] = encrypt($crew->id);
            $data['name'] = $crew->name;
            $data['gender'] = $crew->gender;
            $data['photo'] = $crew->photo;
            $data['status'] = true;
        }

        return $data;
    }

    public function editCrew(Request $request){
        $this->validate($request, [
            'id' => 'required|string',
            'crewName'  => 'required|string',
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

            $location = public_path('storage/crews/') . $filename;

            $crew = Crew::findOrFail(decrypt($request->id));
            //Delete Old photo
            $folder = "crews";
            $this->unlinked($crew->photo, $folder);
            //Store image in public folder
            Image::make($photo)->resize(276,350)->save($location);
            $crew->update([
                'name' => $request->crewName,
                'gender' => $request->gender,
                'photo' => $filename,
            ]);

            $data['status'] = true;
        }
        else{
            Crew::where('id',  decrypt($request->id))->update([
                'name' => $request->crewName,
                'gender' => $request->gender,
            ]);
            $data['status'] = true;
        }


        $response = ['success' => 'Successfull'];

        return $response;
     }

     public function deleteCrew(Request $request){
         $crew = Crew::findOrFail(decrypt($request->crew));
          //Delete Old photo
          $folder = "crews";
          $this->unlinked($crew->photo, $folder);
         $crew->delete();
         return redirect(route('crew'))->with('success', 'Crew has been deleted successfully');
     }

     public function unlinked($name, $folder)
    {
        if ($name != null && $name != 'default.jpg') {
            $old = 'storage/'.$folder.'/' . $name;
            unlink($old);
        }
    }
}
