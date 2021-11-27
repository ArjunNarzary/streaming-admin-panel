<?php

namespace App\Http\Controllers;

use App\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create|edit|delete');
    }

    public function index(){
        $genres = Genre::orderBy('updated_at', 'DESC')->get();
        return view('Genre.index', compact('genres'));
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|string',
        ]);

        Genre::create([
            'name' => $request->name,
        ]);

        $response = ['success' => 'Successfull'];
        return $response;

    }

    public function editView(Request $request){
        $this->validate($request, [
            'id' => 'required|string',
        ]);

        $data = [];
        $data['status'] = 0;
        $genre = Genre::findOrFail(decrypt($request->id));
        if($genre){
            $data['id'] = encrypt($genre->id);
            $data['name'] = $genre->name;
            $data['status'] = 1;
        }

        return $data;
    }

    public function editStore(Request $request){
        $this->validate($request, [
            'id'    => 'required|string',
            'name'  => 'required|string',
        ]);

        $data = [];
        $data['status']  = 0;

        $genre = Genre::findOrFail(decrypt($request->id));
        if($genre){
            $genre->name = $request->name;
            $genre->save();

            $data['status'] = 1;
        }

        return $data;
    }

    public function delete(Request $request){
        $id = decrypt($request->genre);

        $genre = Genre::findOrFail($id);
        if($genre){
            $genre->delete();
            return redirect(route('genre'))->with('success', 'Genre has been removed successfully.');
        }else{
            return redirect(route('genre'))->with('error', 'Please try again !');
        }
    }
}
