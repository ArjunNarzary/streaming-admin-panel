<?php

namespace App\Http\Controllers;

use App\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create|edit|delete');
    }

    public function index(Movie $movie){
        return view('movies.video', compact('movie'));
    }

    public function upload(Request $request, $id){
        $this->validate($request, [
            'video' => 'required|file|mimes:mp4,mkv'
            // 'video' => 'required|file'
        ]);


        $movie_id = decrypt($id);
        $movie = Movie::find($movie_id);

        $data = [];

        if($movie){
            if($movie->link != null){
                Storage::disk('s3')->delete($movie->link);
                $movie->link = null;
                $movie->save();
            }
            $path = $request->file('video')->store(
                'movies', 's3'
            );

            $movie->link = $path;
            $movie->save();
            $data['success'] = true;
        }
        else{
            $data['error'] = true;;
        }
        return $data;

    }

    //Delete Video\
    public function delete(Movie $movie){
        if($movie->link != null){
            Storage::disk('s3')->delete($movie->link);
            $movie->link = null;
            $movie->save();
            return redirect(route('movies.videos', ['movie' => $movie->id]))->with('success', 'Video has been successfully removed');
        }else{
            return redirect(route('movies.videos', ['movie' => $movie->id]));
        }
    }
}
