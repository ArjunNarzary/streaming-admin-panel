<?php

namespace App\Http\Controllers;

use Image;
use App\Cast;
use App\Admin;
use App\Season;
use App\Series;
use App\Helper\Slug;
use Illuminate\Http\Request;

class SeasonsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create|edit|delete');
    }

    public function index($id){
        $series = Series::select('id', 'title')->where('id', $id)->first();
        if($series){
            return view('series.seasons.index', compact('series'));
        }
        else{
            return back();
        }
    }

    public function add($id){
        $series = Series::select('title')->where('id', $id)->first();
        if($series){
            $title = $series->title;
            $season = new Season();
            $distributors = Admin::select('id', 'name')->get();
            return view('series.seasons.add_season', compact('id', 'title', 'season', 'distributors'));
        }else{
            return back();
        }
    }

    public function store(Request $request){
        $this->validate($request, [
            'series_id'         => 'required|numeric',
            'distributor'       => 'required|numeric',
            'title'             => 'required|string',
            'description'       => 'required|string',
            'premium_type'      => 'required|numeric',
            'amount'            => 'required|numeric',
            'season_no'         => 'required|numeric',
            'total_episodes'    => 'required|numeric',
            'release_date'      => 'required|date',
            'revenue'           => 'nullable|numeric',
            'budget'            => 'nullable|numeric',
            'cover'             => 'required|image|max:750',
        ]);

        $series = Series::find($request->series_id);

        //If season with same season number exist
        $existing_seasons = Season::where('series_id', $request->series_id)->where('season_no', $request->season_no)->get();
        if(count($existing_seasons) > 0){
            return back()->withInput()->withErrors(['season_no' => 'This season number already exist']);;
        }

        $cover = $request->cover;
        $filename = time() . '.' . $cover->getClientOriginalExtension();
        //Store Image
        $location = public_path('storage/series/seasons/') . $filename;
        Image::make($cover)->resize(534,799)->save($location);

        $slug1 = new Slug();
        $slug = $slug1->createSlug($request->input('title'));

        $data = ([
            'series_id'         => $request->series_id,
            'distributor_id'    => $request->distributor,
            'title'             => $request->title,
            'slug'              => $series->title.'-'.$slug,
            'season_no'         => $request->season_no,
            'description'       => $request->description,
            'premium_type'      => $request->premium_type,
            'amount'            => $request->amount,
            'total_episodes'    => $request->total_episodes,
            'release_date'      => $request->release_date,
            'revenue'           => $request->revenue,
            'budget'            => $request->budget,
            'cover'             => $filename,
        ]);

        Season::create($data);

        return redirect(route('series.seasons',['id' => $request->series_id]))->with('success', 'Season has been added successfully !');
    }

    public function edit($id){
        $season = Season::find($id);
        if($season){
            $distributors = Admin::select('id', 'name')->get();
            return view('series.seasons.edit_season', compact('season', 'distributors'));
        }else{
            return back();
        }
    }

    public function update(Request $request){
        $this->validate($request, [
            'season_id'         => 'required|numeric',
            'distributor'       => 'required|numeric',
            'title'             => 'required|string',
            'description'       => 'required|string',
            'premium_type'      => 'required|numeric',
            'amount'            => 'required|numeric',
            'season_no'         => 'required|numeric',
            'total_episodes'    => 'required|numeric',
            'release_date'      => 'required|date',
            'revenue'           => 'nullable|numeric',
            'budget'            => 'nullable|numeric',
            'cover'             => 'nullable|image|max:750',
        ]);

        $season = Season::find($request->season_id);


        if($season){
            $series = Series::find($season->series_id);

            //If season with same season number exist
            $existing_seasons = Season::where('series_id', $season->series_id)->where('season_no', $request->season_no)->where('id', '!=', $request->season_id)->get();
            if(count($existing_seasons) > 0){
                return back()->withInput()->withErrors(['season_no' => 'This season number already exist']);
            }

            $slug1 = new Slug();
            $slug = $slug1->createSlug($request->input('title'));

            $season->title           = $request->title;
            $season->distributor_id  = $request->distributor;
            $season->slug            = $series->title.'-'.$slug;
            $season->description     = $request->description;
            $season->season_no       = $request->season_no;
            $season->premium_type    = $request->premium_type;
            $season->amount          = $request->amount;
            $season->total_episodes  = $request->total_episodes;
            $season->release_date    = $request->release_date;
            $season->revenue         = $request->revenue;
            $season->budget          = $request->budget;

            $cover = $request->cover;
            if($cover){
                $filename = time(). '.' . $cover->getClientOriginalExtension();
                $folder = 'seasons';
                $this->unlinked($season->cover, $folder);

                $location = public_path('storage/series/seasons/') . $filename;
                Image::make($cover)->resize(534,799)->save($location);
                $season->cover = $filename;
            }

            $season->save();

            return redirect(route('series.seasons',['id' => $season->series->id]))->with('success', 'Season has been updated successfully !');


        }else{
            return back();
        }
    }

    public function manage(Season $season){
        if($season){
            $casts = Cast::all();
            return view('series.seasons.manage', compact('casts', 'season'));
        }else{
            return back();
        }
    }

    //Add Cast
    public function addCast(Request $request){
        $this->validate($request, [
            'cast_id' => 'required|numeric',
            'season_id' => 'required|numeric',
            'role' => 'required|string',
        ]);

        $data = [];
        $data['status'] = false;

        $season = Season::find($request->season_id);

        $season->casts()->attach($request->cast_id, [
            'role' => $request->role,
        ]);

        $data['status'] = true;

        return $data;
    }

    //Activate Seaseon
    public function activate(Season $season){
        if($season){
            if(count($season->episodes) > 0){
                $season->status = '1';
                $season->save();
                return redirect(route('season.manage', ['season' => $season->id]))->with('success', 'Season has been activate successfully');
            }else{
                return redirect(route('season.manage', ['season' => $season->id]))->with('error', 'No episode has been added for this season.');
            }
        }else{
            return back();
        }
    }

    //Deactivate Season
    public function deactivate(Season $season){
        if($season){
            $season->status = '0';
            $season->save();
            return redirect(route('season.manage', ['season' => $season->id]))->with('success', 'Season has been deactivate successfully');
        }else{
            return back();
        }
    }

     //Remove Cast
     public function removeCast(Request $request){
        $cast = $request->cast;
        $role = $request->role;
        $season_id = $request->season_id;

        $data = [];
        $data['status'] = false;
        $season = Season::find($season_id);
        if($season){
            $season->casts()->where('cast_id', $cast)->wherePivot('role', $role)->detach();
            $data['status'] = true;
        }

        return $data;
    }


    //Unlink Season Cover
    public function unlinked($name, $folder)
    {
        if ($name != null && $name != 'default.jpg') {
            $old = 'storage/series/'.$folder.'/' . $name;
            unlink($old);
        }
    }

}
