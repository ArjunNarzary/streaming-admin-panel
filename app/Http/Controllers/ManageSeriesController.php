<?php

namespace App\Http\Controllers;

use App\Cast;
use App\Crew;
use App\Genre;
use Image;
use App\Series;
use App\SeriesPoster;
use Illuminate\Http\Request;

class ManageSeriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create|edit|delete');
    }

    public function index($id){
        $series = Series::select('id', 'title', 'banner', 'language', 'release_date', 'status')->where('id', $id)->first();
        $crews = Crew::all();
        $genres = Genre::all();
        return view('series.manage_edit', compact('series', 'crews', 'genres'));
    }

    //Add Crew
    public function seriesCrew(Request $request){
        $this->validate($request, [
            'crew_id' => 'required|numeric',
            'series_id' => 'required|numeric',
            'designation' => 'required|string',
        ]);

        $data = [];
        $data['status'] = false;

        $series = Series::find($request->series_id);

        $series->crews()->attach($request->crew_id, [
            'designation' => $request->designation,
        ]);

        $data['status'] = true;

        return $data;
    }

    //Remove Crew
    public function seriesCrewRemove(Request $request){
        $crew = $request->crew;
        $designation = $request->designation;
        $series_id = $request->series_id;

        $data = [];
        $data['status'] = false;
        $series = Series::find($series_id);
        if($series){
            $series->crews()->where('crew_id', $crew)->wherePivot('designation', $designation)->detach();
            $data['status'] = true;
        }

        return $data;
    }

    //Add Genre
    public function addGenre(Request $request){
        $series_id = $request->series_id;
        $genre = $request->genre;

        $data = [];
        $data['status'] = false;
        $series = Series::find($series_id);
        if($series){
            $series->genres()->syncWithoutDetaching($genre);
            $data['status'] = true;
        }

        return $data;
    }
    //Remove Genre
    public function removeGenre(Request $request){
        $series_id = $request->series_id;
        $genre = $request->genre;

        $data = [];
        $data['status'] = false;
        $series = Series::find($series_id);
        if($series){
            $series->genres()->detach($genre);
            $data['status'] = true;
        }

        return $data;
    }

    //Add poster
    public function addPoster(Request $request){
        $this->validate($request, [
            'series_id' => 'required|numeric',
            'file'     => 'required|image|max:750',
        ]);

        $poster = $request->file;
        $filename = time() . '.' . $poster->getClientOriginalExtension();
        //Store Image
        $location = public_path('storage/posters/') . $filename;
        Image::make($poster)->resize(534,799)->save($location);

        SeriesPoster::create([
            'series_id' => $request->series_id,
            'poster'   => $filename,
        ]);

        return true;
    }

    //Remove Poster
    public function removePoster(Request $request){
        $this->validate($request, [
            'series_id'   => 'required|numeric',
            'poster_id'  => 'required|numeric',
        ]);

        $data = [];
        $data['status'] = false;
        $poster = SeriesPoster::where('id', $request->poster_id)->where('series_id', $request->series_id)->first();
        if($poster){
            $folder = 'posters';
            $this->unlinked($poster->poster, $folder);
            $poster->delete();
            $data['status']  = true;
        }
        return $data;
    }

    //Activate Series
    public function activate($id){
        $series = Series::find($id);
        if($series){
            //Check for series details
            $crews = count($series->crews);
            $genres = count($series->genres);
            $seasons = count($series->seasons);

            if($crews == 0){
                return back()->with('error', 'You must add crew details before activating this series');
            }
            if($genres == 0){
                return back()->with('error', 'You must add genre details before activating this series');
            }
            if($seasons == 0){
                return back()->with('error', 'You must add atleast 1 season before activating this series');
            }

            $series->status = 1;
            $series->save();
            return redirect(route('series.manage', ['id' => $series->id]))->with('success', 'Series has been activated successfully.');

        }else{
            return back();
        }
    }

    //Deactivate Series
    public function deactivate($id){
        $series = Series::find($id);
        if($series){
            $series->status = 0;
            $series->save();
            return redirect(route('series.manage', ['id' => $series->id]))->with('success', 'Series has been deactivated successfully.');
        }else{
            return back();
        }
    }

    //Add Iframe
    public function addIframe(Request $request){
        $data = $this->validate($request, [
            'movie_id' => 'required|numeric',
            'iframe_tag'      => 'required|string',
        ]);

        Iframe::create($data);

        return true;
    }
    //Remove Iframe
    public function removeIframe(Request $request){
        $this->validate($request, [
            'movie_id' => 'required|numeric',
            'tag_id'      => 'required|numeric',
        ]);

        $data = [];
        $data['status'] = false;

        $iframe = Iframe::where('id', $request->tag_id)->where('movie_id', $request->movie_id)->first();
        if($iframe){
            $iframe->delete();
            $data['status'] = true;
        }

        return $data;
    }


    public function unlinked($name, $folder)
    {
        if ($name != null && $name != 'default.jpg') {
            $old = 'storage/'.$folder.'/' . $name;
            unlink($old);
        }
    }

    //Calculate movie length
    function hoursandmins($time, $format = '%02dh : %02dm')
    {
        if ($time < 1) {
            return;
        }
        $hours = floor($time / 60);
        $minutes = ($time % 60);
        return sprintf($format, $hours, $minutes);
    }
}
