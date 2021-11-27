<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Cast;
use App\Crew;
use App\Genre;
use App\Iframe;
use Image;
use App\Movie;
use App\MoviePoster;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Helper\Slug;

class MovieController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create|edit|delete');
    }

    public function movies(){
        $movies = Movie::select('id', 'title', 'language', 'length', 'release_date','premium_status', 'status')->orderBy('updated_at', 'DESC')->get();

        $movies->map(function($movie){
            $movie['duration'] = $this->hoursandmins($movie->length);
        });

        return view('movies.manage', compact('movies'));
    }

    public function addMovie(){
        $distributors = Admin::select('id', 'name')->where('active', 1)->get();
        return view('movies.add_movie', compact('distributors'));
    }

    public function store(Request $request){
        $this->validate($request, [
            'title'             => 'required|string',
            'distributor'       => 'required|numeric',
            'description'       => 'required|string',
            'language'          => 'required|string',
            'type'              => 'required|numeric',
            'premium_status'    => 'required|numeric',
            'amount'            => 'required|numeric',
            'length'            => 'required|numeric',
            'release_date'      => 'required|date',
            'revenue'           => 'nullable|numeric',
            'budget'            => 'nullable|numeric',
            'link'              => 'nullable|string',
            'banner'            => 'required|image|max:750',
        ]);

        $banner = $request->banner;
        $filename = time() . '.' . $banner->getClientOriginalExtension();
        //Store Image
        $location = public_path('storage/movies/') . $filename;
        Image::make($banner)->resize(534,799)->save($location);

        $slug1 = new Slug();
        $slug = $slug1->createSlug($request->input('title'));

        $data = ([
            'title'             => $request->title,
            'distributor_id'    => $request->distributor,
            'description'       => $request->description,
            'language'          => $request->language,
            'language'          => $request->language,
            'type'              => $request->type,
            'premium_status'    => $request->premium_status,
            'amount'            => $request->amount,
            'length'            => $request->length,
            'release_date'      => $request->release_date,
            'revenue'           => $request->revenue,
            'budget'            => $request->budget,
            'banner'            => $filename,
            'status'            => 0,
            'slug'              => $slug,
        ]);

        Movie::create($data);

        return redirect(route('add.movies'))->with('success', 'Movie has been added successfully. Please go to manage movie to add more details and active the movie.');
    }

    public function view($id){
        $distributors = Admin::select('id', 'name')->where('active', 1)->get();
        $movie = Movie::find($id);
        return view('movies.view', compact('movie', 'distributors'));
    }

    public function update(Request $request){

        $this->validate($request, [
            'movie_id'          => 'required|numeric',
            'title'             => 'required|string',
            'distributor'       => 'required|numeric',
            'description'       => 'required|string',
            'language'          => 'required|string',
            'type'              => 'required|numeric',
            'premium_status'    => 'required|numeric',
            'amount'            => 'required|numeric',
            'length'            => 'required|numeric',
            'release_date'      => 'required|date',
            'revenue'           => 'nullable|numeric',
            'budget'            => 'nullable|numeric',
            'link'              => 'nullable|string',
            'banner'            => 'nullable|image|max:750',
        ]);

        $movie = Movie::find($request->movie_id);

        $slug1 = new Slug();
        $slug = $slug1->createSlug($request->input('title'));

        $movie->title             = $request->title;
        $movie->distributor_id    = $request->distributor;
        $movie->description       = $request->description;
        $movie->language          = $request->language;
        $movie->type              = $request->type;
        $movie->premium_status    = $request->premium_status;
        $movie->amount            = $request->amount;
        $movie->length            = $request->length;
        $movie->release_date      = $request->release_date;
        $movie->budget            = $request->budget;
        $movie->revenue           = $request->revenue;
        $movie->link              = $request->link;
        $movie->slug              = $slug;

        $banner = $request->banner;
        if($banner != null){
            $folder = 'movies';
            $this->unlinked($movie->banner, $folder);

            $filename = time() . '.' . $banner->getClientOriginalExtension();
            //Store Image
            $location = public_path('storage/movies/') . $filename;
            Image::make($banner)->resize(534,799)->save($location);

            $movie->banner = $filename;
        }
        $movie->save();

        return redirect(route('movie.view',['id'=>$movie->id]))->with('success', 'Movie has been successfully updated. Please go to manage movie to add more details and active the movie.');
    }

    public function edit($id){
        $movie = Movie::select('id', 'title', 'banner', 'length', 'language', 'status', 'carousal')->where('id', $id)->firstOrFail();
        $duration = $this->hoursandmins($movie->length);
        $crews = Crew::all();
        $casts = Cast::all();
        $genres = Genre::all();
        return view('movies.edit', compact('movie', 'casts', 'crews', 'genres', 'duration'));
    }

    //Add Cast View
    public function movieCast(Request $request){
        $data = [];
        $data['status']  = false;
        $cast = Cast::find($request->id);

        if($cast){
            $data['name'] = $cast->name;
            $data['photo'] = $cast->photo;
            $data['status'] = true;
        }

        return $data;
    }

    //Add Cast
    public function movieCastAdd(Request $request){
        $this->validate($request, [
            'cast_id' => 'required|numeric',
            'movie_id' => 'required|numeric',
            'role' => 'required|string',
        ]);

        $data = [];
        $data['status'] = false;

        $movie = Movie::find($request->movie_id);

        $movie->casts()->attach($request->cast_id, [
            'role' => $request->role,
        ]);

        $data['status'] = true;

        return $data;
    }

    //Remove Cast
    public function movieCastRemove(Request $request){
        $cast = $request->cast;
        $role = $request->role;
        $movie_id = $request->movie_id;

        $data = [];
        $data['status'] = false;
        $movie = Movie::find($movie_id);
        if($movie){
            $movie->casts()->where('cast_id', $cast)->wherePivot('role', $role)->detach();
            $data['status'] = true;
        }

        return $data;
    }

    //Add Crew View
    public function movieCrew(Request $request){
        $data = [];
        $data['status']  = false;
        $crew = Crew::find($request->id);

        if($crew){
            $data['name'] = $crew->name;
            $data['photo'] = $crew->photo;
            $data['status'] = true;
        }

        return $data;
    }

    //Add Crew
    public function movieCrewAdd(Request $request){
        $this->validate($request, [
            'crew_id' => 'required|numeric',
            'movie_id' => 'required|numeric',
            'designation' => 'required|string',
        ]);

        $data = [];
        $data['status'] = false;

        $movie = Movie::find($request->movie_id);

        $movie->crews()->attach($request->crew_id, [
            'designation' => $request->designation,
        ]);

        $data['status'] = true;

        return $data;
    }

    //Remove Crew
    public function movieCrewRemove(Request $request){
        $crew = $request->crew;
        $designation = $request->designation;
        $movie_id = $request->movie_id;

        $data = [];
        $data['status'] = false;
        $movie = Movie::find($movie_id);
        if($movie){
            $movie->crews()->where('crew_id', $crew)->wherePivot('designation', $designation)->detach();
            $data['status'] = true;
        }

        return $data;
    }

    //Add Genre
    public function movieGenre(Request $request){
        $movie_id = $request->movie_id;
        $genre = $request->genre;

        $data = [];
        $data['status'] = false;
        $movie = Movie::find($movie_id);
        if($movie){
            $movie->genres()->syncWithoutDetaching($genre);
            $data['status'] = true;
        }

        return $data;
    }
    //Remove Genre
    public function movieGenreRemove(Request $request){
        $movie_id = $request->movie_id;
        $genre = $request->genre;

        $data = [];
        $data['status'] = false;
        $movie = Movie::find($movie_id);
        if($movie){
            $movie->genres()->detach($genre);
            $data['status'] = true;
        }

        return $data;
    }

    //Add Movie poster
    public function moviePoster(Request $request){
        $this->validate($request, [
            'movie_id' => 'required|numeric',
            'file'     => 'required|image|max:750',
        ]);

        $poster = $request->file;
        $filename = time() . '.' . $poster->getClientOriginalExtension();
        //Store Image
        $location = public_path('storage/posters/') . $filename;
        Image::make($poster)->resize(534,799)->save($location);

        MoviePoster::create([
            'movie_id' => $request->movie_id,
            'poster'   => $filename,
        ]);

        return true;
    }

    //Remove Poster
    public function moviePosterRemove(Request $request){
        $this->validate($request, [
            'movie_id'   => 'required|numeric',
            'poster_id'  => 'required|numeric',
        ]);

        $data = [];
        $data['status'] = false;
        $poster = MoviePoster::where('id', $request->poster_id)->where('movie_id', $request->movie_id)->first();
        if($poster){
            $folder = 'posters';
            $this->unlinked($poster->poster, $folder);
            $poster->delete();
            $data['status']  = true;
        }
        return $data;
    }

    //Activate Movie
    public function movieActivate(Movie $movie){

        //Check for movie details
        $casts = count($movie->casts);
        $crews = count($movie->crews);
        $genres = count($movie->genres);

        if($casts == 0){
            return back()->with('error', 'You must add cast details before activating this movie');
        }
        if($crews == 0){
            return back()->with('error', 'You must add crew details before activating this movie');
        }
        if($genres == 0){
            return back()->with('error', 'You must add genre details before activating this movie');
        }

        $movie->status = 1;
        $movie->save();
        return redirect(route('movie.edit', ['id' => $movie->id]))->with('success', 'Movie has been activated successfully.');
    }

    //Deactivate Movie
    public function moviedeactivate(Movie $movie){
        $movie->status = 0;
        $movie->save();
        return redirect(route('movie.edit', ['id' => $movie->id]))->with('success', 'Movie has been deactivated successfully.');
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
