<?php

namespace App\Http\Controllers;

use auth;
use App\User;
use App\Admin;
use App\Movie;
use App\Season;
use Carbon\Carbon;
use App\RentedMovieBilling;
use App\RentedSeriesBilling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(auth::user()->hasRole('admin')){
            $totUsers = User::count();
            $totMovies = Movie::where('status', 1)->count();
            $totSeasons = Season::where('status', 1)->count();
            $totCollection1 = RentedMovieBilling::where('payment_status', 1)->sum('amount');
            $totCollection2 = RentedSeriesBilling::where('payment_status', 1)->sum('amount');
            $totalBillings = $totCollection1 + $totCollection2;
            return view('home', compact('totUsers', 'totMovies', 'totSeasons', 'totalBillings'));
        }else{
            return redirect(route('report.movies'));
        }

    }

    //code for chart (Movies)
    public function revenueChartMovies(){
        $months = array();
        $revenues = [];
        for($i = -5; $i <= 0; $i++){
            $month = date('M Y', strtotime($i.' month'));
            array_push($months, $month);
        }

        $last_month = $months[0];
        $start_range = new Carbon('first day of' .$last_month );
        $now = Carbon::now();


        $transactions = RentedMovieBilling::select(
            DB::raw('sum(amount) as total'),
            DB::raw("date_format(created_at, '%M %Y') as month")
            )
            ->whereBetween('created_at', [$start_range, $now])
            ->groupBy('month')
            ->orderBy('month', 'DESC')
            ->get();

        foreach($months as $month){
            $revenue = 0;
            foreach($transactions as $trans){
                $date = Carbon::parse($trans->month)->format('M Y');
                if($date == $month){
                    $revenue = $trans->total;
                    break;
                }
                else{
                    $revenue = 0;
                }
            }

            array_push($revenues, $revenue);
        }

        $revenueReport = array(
            'months'   => $months,
            'revenues' => $revenues,
        );

        return $revenueReport;
    }

    //code for chart (Seasons)
    public function revenueChartSeasons(){
        $months = array();
        $revenues = [];
        for($i = -5; $i <= 0; $i++){
            $month = date('M Y', strtotime($i.' month'));
            array_push($months, $month);
        }

        $last_month = $months[0];
        $start_range = new Carbon('first day of' .$last_month );
        $now = Carbon::now();


        $transactions = RentedSeriesBilling::select(
            DB::raw('sum(amount) as total'),
            DB::raw("date_format(created_at, '%M %Y') as month")
            )
            ->whereBetween('created_at', [$start_range, $now])
            ->groupBy('month')
            ->orderBy('month', 'DESC')
            ->get();

        foreach($months as $month){
            $revenue = 0;
            foreach($transactions as $trans){
                $date = Carbon::parse($trans->month)->format('M Y');
                if($date == $month){
                    $revenue = $trans->total;
                    break;
                }
                else{
                    $revenue = 0;
                }
            }

            array_push($revenues, $revenue);
        }

        $revenueReport = array(
            'months'   => $months,
            'revenues' => $revenues,
        );

        return $revenueReport;
    }
}
