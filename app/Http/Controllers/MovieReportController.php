<?php

namespace App\Http\Controllers;

use App\Movie;
use App\RentedMovieBilling;
use auth;
use Illuminate\Http\Request;

class MovieReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        if(auth::user()->hasRole('admin')){
            $movies = Movie::select('id', 'title', 'distributor_id', 'language', 'release_date', 'premium_status', 'status', 'type')->orderBy('updated_at', 'DESC')->get();
        }else{
            $movies = Movie::select('id', 'title', 'distributor_id', 'language', 'release_date', 'premium_status', 'status', 'type')->where('distributor_id', auth::user()->id)->orderBy('updated_at', 'DESC')->get();
        }

        $movies->map(function($movie, $total){
            $total = 0;
            foreach($movie->rentedBillings as $rented){
                $total = $total + $rented->amount;
            }
            $movie->total = $total;
        });

        return view('reports.movies.index', compact('movies'));
    }

    public function detail($id){
        $movie = Movie::find($id);
        if($movie){
            if(auth::user()->hasRole('admin') || $movie->distributor_id == auth::user()->id ){
                return view('reports.movies.details', compact('movie'));

            }else{
                return back()->with('error', 'Your not authorise to access this page');
            }
        }else{
            return back();
        }
    }


    //Monthly report
    public function montly(Request $request){
        $id = $request->movie_id;
        $month = $request->month;

        $movie = Movie::find($id);
        if($movie){
            if(auth::user()->hasRole('admin') || $movie->distributor_id == auth::user()->id ){

                if($month != null){
                    $payments = RentedMovieBilling::where('movie_id', $id)->whereMonth('updated_at', date($month))->whereYear('updated_at', date('Y'))->where('payment_status', 1)->orderBy('updated_at', 'desc')->get();
                }else{
                    $payments = RentedMovieBilling::where('movie_id', $id)->whereMonth('updated_at', date('m'))->whereYear('updated_at', date('Y'))->where('payment_status', 1)->orderBy('updated_at', 'desc')->get();
                }
                $total = 0;
                foreach($payments as $payment){
                    $total = $total + $payment->amount;
                }
                $count = 0;
                $payments->map(function($payment, $count){
                    $payment['slno'] = $count+1;
                    $payment['user_name'] = $payment->user->first_name.' '.$payment->user->last_name;
                    $payment['update'] = \Carbon\Carbon::parse($payment->updated_at)->format('d-m-Y');
                    $count++;
                });

                $data['payments'] = $payments;
                $data['total']    = $total;
                return response()->json($data);

            }else{
                return false;
            }
        }else{
            return false;
        }

    }
}
