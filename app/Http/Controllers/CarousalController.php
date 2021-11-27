<?php

namespace App\Http\Controllers;

use Image;
use App\Movie;
use App\Season;
use Illuminate\Http\Request;

class CarousalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create|edit|delete');
    }

    public function upload(Request $request){
        $this->validate($request, [
            'id'        => 'required|numeric',
            'category'  => 'required|numeric',
            'file'      => 'required|image|max:750',
        ]);

        $category = $request->category;
        $id       = $request->id;
        $carousal       = $request->file;
        if($category == 1){
            $table = Movie::findOrFail($id);
        }else{
            $table = Season::findOrFail($id);
        }

        if($table != null){
            if($table->carousal != null){
                $folder = 'carousals';
                $this->unlinked($table->carousal, $folder);
            }

            $filename = time() . '.' . $carousal->getClientOriginalExtension();
            //Store Image
            $location = public_path('storage/carousals/') . $filename;
            Image::make($carousal)->resize(1280, 500)->save($location);

            $table->carousal = $filename;
            $table->save();

            if($category == 1){
               $link = "/movies/edit/".$table->id;
            }else{
                $link = "/seasons/manage/".$table->id;
            }

            return $link;

        }
    }

    //Remove Carousal from movie
    public function mRemove(Movie $movie){
        $folder = 'carousals';
        $this->unlinked($movie->carousal, $folder);

        $movie->carousal = null;
        $movie->save();
        return redirect(route('movie.edit', ['id' => $movie->id]))->with('success', 'Carousal has been removed successfully.');
    }

    //Remove Carousal from movie
    public function sRemove(Season $season){
        $folder = 'carousals';
        $this->unlinked($season->carousal, $folder);

        $season->carousal = null;
        $season->save();
        return redirect(route('season.manage', ['season' => $season->id]))->with('success', 'Carousal has been removed successfully.');
    }



    public function unlinked($name, $folder)
    {
        if ($name != null && $name != 'default.jpg') {
            $old = 'storage/'.$folder.'/' . $name;
            unlink($old);
        }
    }
}
