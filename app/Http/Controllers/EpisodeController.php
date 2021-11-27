<?php

namespace App\Http\Controllers;

use Image;
use App\Season;
use App\Episode;
use Illuminate\Http\Request;
use App\Helper\Slug;


class EpisodeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create|edit|delete');
    }

    public function index($id){
        $season = Season::where('id', $id)->first();

        if($season){
            $season->episodes->map(function($episode){
                $episode['duration'] = $this->hoursandmins($episode->length);
            });

            return view('series.episodes.index', compact('season'));
        }
        else{
            return back();

        }
    }

    public function add($id){
        $season = Season::select('id', 'title')->where('id', $id)->first();

        if($season){
            $episode = new Episode();
            return view('series.episodes.add_episode', compact('season', 'episode'));
        }
    }

    public function store(Request $request){
        $this->validate($request, [
            'season_id'     => 'required|numeric',
            'title'         => 'required|string',
            'description'   => 'required|string',
            'episode_no'    => 'required|numeric',
            'length'        => 'required|numeric',
            'release_date'  => 'required|date',
            'link'          => 'nullable|string',
            'banner'        => 'required|image|max:700',
        ]);

        $season = Season::find($request->season_id);

        if($season){
            $cover = $request->banner;
            $filename = time() . '.' . $cover->getClientOriginalExtension();
            //Store Image
            $location = public_path('storage/series/episodes/') . $filename;
            Image::make($cover)->resize(534,799)->save($location);

            $slug1 = new Slug();
            $slug = $slug1->createSlug($request->input('title'));

            $data = ([
                'season_id'     => $request->season_id,
                'title'         => $request->title,
                'slug'          => $slug,
                'description'   => $request->description,
                'episode_no'    => $request->episode_no,
                'length'        => $request->length,
                'release_date'  => $request->release_date,
                'link'          => $request->link,
                'banner'        => $filename,
            ]);

            Episode::create($data);

            return redirect(route('season.episodes', ['id' => $request->season_id]))->with('success', 'Episode has been successfully added.');

        }else{
            return back();
        }
    }

    public function edit($id){
        $episode = Episode::find($id);

        if($episode){
            return view('series.episodes.edit_episode', compact('episode'));
        }else{
            return back();
        }
    }

    public function update(Request $request){
        $this->validate($request, [
            'episode_id'    => 'required|numeric',
            'title'         => 'required|string',
            'description'   => 'required|string',
            'episode_no'    => 'required|numeric',
            'length'        => 'required|numeric',
            'release_date'  => 'required|date',
            'link'          => 'nullable|string',
            'banner'        => 'nullable|image|max:700',
        ]);

        $episode = Episode::find($request->episode_id);

        if($episode){
            $slug1 = new Slug();
            $slug = $slug1->createSlug($request->input('title'));

            $episode->title             = $request->title;
            $episode->slug              = $slug;
            $episode->description       = $request->description;
            $episode->episode_no        = $request->episode_no;
            $episode->length            = $request->length;
            $episode->release_date      = $request->release_date;
            $episode->link              = $request->link;

            $cover = $request->banner;
            if($cover){
                $filename = time(). '.' . $cover->getClientOriginalExtension();
                $folder = 'episodes';
                $this->unlinked($episode->banner, $folder);

                $location = public_path('storage/series/episodes/') . $filename;
                Image::make($cover)->resize(534,799)->save($location);
                $episode->banner = $filename;
            }

            $episode->save();

            return redirect(route('season.episodes', ['id' => $episode->season->id]))->with('success', 'Episode has been successfully upadeted.');

        }else{
            return back();
        }
    }

    public function activate(Episode $episode){
        if($episode){
            if($episode->link != null){
                $episode->status = '1';
                $episode->save();
                return redirect(route('episode.view', ['id' => $episode->id]))->with('success', 'Episode has been activate successfully');
            }else{
                return redirect(route('episode.view', ['id' => $episode->id]))->with('error', 'No video link has been linked for this episode.');
            }
        }else{
            return back();
        }
    }

    public function deactivate(Episode $episode){
        if($episode){
            $episode->status = '0';
            $episode->save();
            return redirect(route('episode.view', ['id' => $episode->id]))->with('success', 'Episode has been deactivate successfully');
        }else{
            return back();
        }
    }


    //Unlink Banner
    public function unlinked($name, $folder)
    {
        if ($name != null && $name != 'default.jpg') {
            $old = 'storage/series/'.$folder.'/' . $name;
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
