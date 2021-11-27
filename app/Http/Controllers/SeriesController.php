<?php

namespace App\Http\Controllers;

use auth;
use Image;
use App\Series;
use Illuminate\Http\Request;
use App\Helper\Slug;

class SeriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create|edit|delete');
    }

    public function addSeries(){
        $series = new Series();
        return view('series.add_series', compact('series'));
    }

    public function store(Request $request){
        $this->validate($request, [
            'title'             => 'required|string',
            'description'       => 'required|string',
            'release_date'      => 'required|date',
            'language'          => 'required|string',
            'revenue'           => 'nullable|numeric',
            'budget'            => 'nullable|numeric',
            'banner'            => 'required|image|max:750',
        ]);

        $banner = $request->banner;
        $filename = time().'.'.$banner->getClientOriginalExtension();

        //Store Banner
       //Store Image
       $location = public_path('storage/series/') . $filename;
       Image::make($banner)->resize(534,799)->save($location);

       $slug1 = new Slug();
       $slug = $slug1->createSlug($request->input('title'));

        Series::create([
            'title'          => $request->title,
            'description'    => $request->description,
            'slug'           => $slug,
            'release_date'   => $request->release_date,
            'language'       => $request->language,
            'revenue'        => $request->revenue,
            'budget'         => $request->budget,
            'banner'         => $filename,
        ]);

        return back()->with('success', 'Series has been successfully added. Please go to manage series to manage series.');
    }

    //Manage Series
    public function series(){
        $serieses = Series::select('id', 'title', 'language', 'release_date', 'status')->orderBy('updated_at', 'DESC')->get();
        return view('series.manage', compact('serieses'));
    }

    //edit view
    public function edit($id){
        $series = Series::find($id);

        if($series){
            return view('series.edit_series', compact('series'));
        }
        else{
            return redirect(route('series'));
        }
    }

    //update series
    public function update(Request $request, $id){
        $this->validate($request, [
            'title'             => 'required|string',
            'description'       => 'required|string',
            'release_date'      => 'required|date',
            'language'          => 'required|string',
            'revenue'           => 'nullable|numeric',
            'budget'            => 'nullable|numeric',
            'banner'            => 'nullable|image|max:750',
        ]);

        $series = Series::find($id);

        if($series == null){
            return redirect(route('series'));
        }

        $banner = $request->banner;
        $folder = 'series';
        if($banner != null){
            $this->unlinked($series->banner, $folder);

            $new_banner = $request->banner;
            $filename   = time().'.'.$banner->extension();

            $location = public_path('storage/series/').$filename;
            Image::make($banner)->resize(534,799)->save($location);

            $series->banner = $filename;
        }

        $slug1 = new Slug();
        $slug = $slug1->createSlug($request->input('title'));

        $series->title              = $request->title;
        $series->description        = $request->description;
        $series->release_date       = $request->release_date;
        $series->language           = $request->language;
        $series->revenue            = $request->revenue;
        $series->budget             = $request->budget;
        $series->slug               = $slug;
        $series->save();

        return redirect(route('series.view', ['id' => $series->id]))->with('success', 'Series inforamtion has been successfully updated');
    }


    //Unlink Banner
    public function unlinked($name, $folder)
    {
        if ($name != null && $name != 'default.jpg') {
            $old = 'storage/'.$folder.'/' . $name;
            unlink($old);
        }
    }
}
