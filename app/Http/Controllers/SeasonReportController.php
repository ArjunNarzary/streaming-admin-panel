<?php

namespace App\Http\Controllers;

use auth;
use App\Season;
use App\RentedSeriesBilling;
use Illuminate\Http\Request;

class SeasonReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        if(auth::user()->hasRole('admin')){
            $seasons = Season::select('id', 'title', 'series_id', 'distributor_id', 'season_no', 'release_date', 'premium_type', 'status', 'total_episodes')->orderBy('updated_at', 'DESC')->get();
        }else{
            $seasons = Season::select('id', 'title', 'series_id', 'distributor_id', 'season_no', 'release_date', 'premium_type', 'status', 'total_episodes')->where('distributor_id', auth::user()->id)->orderBy('updated_at', 'DESC')->get();
        }

        $seasons->map(function($season, $total){
            $total = 0;
            foreach($season->rentedBillings as $rented){
                $total = $total + $rented->amount;
            }
            $season->total = $total;
        });

        return view('reports.seasons.index', compact('seasons'));
    }

    public function detail($id){
        $season = Season::find($id);
        if($season){
            if(auth::user()->hasRole('admin') || $season->distributor_id == auth::user()->id ){
                return view('reports.seasons.details', compact('season'));

            }else{
                return back()->with('error', 'Your not authorise to access this page');
            }
        }else{
            return back();
        }
    }


    //Monthly report
    public function montly(Request $request){
        $id = $request->season_id;
        $month = $request->month;

        $season = Season::find($id);
        if($season){
            if(auth::user()->hasRole('admin') || $season->distributor_id == auth::user()->id ){

                if($month != null){
                    $payments = RentedSeriesBilling::where('season_id', $id)->whereMonth('updated_at', date($month))->whereYear('updated_at', date('Y'))->where('payment_status', 1)->orderBy('updated_at', 'desc')->get();
                }else{
                    $payments = RentedSeriesBilling::where('season_id', $id)->whereMonth('updated_at', date('m'))->whereYear('updated_at', date('Y'))->where('payment_status', 1)->orderBy('updated_at', 'desc')->get();
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
