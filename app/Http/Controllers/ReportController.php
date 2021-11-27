<?php

namespace App\Http\Controllers;

use App\User;
use App\RentedMovieBilling;
use App\RentedSeriesBilling;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create|edit|delete');
    }

    public function users(){
        $users = User::all();

        $users->map(function($user){

            $count = 0;
            foreach($user->seasonBillings as $bills){
                $count = $count + $bills->amount;
            }

            foreach($user->movieBillings as $bills){
                $count = $count + $bills->amount;
            }

            $user['name'] = $user->first_name.' '.$user->last_name;
            $user['totalBillings'] = $count;
        });

        return view('reports.users.index', compact('users'));

    }

    public function transactions(User $user){

        $seasonTrans = RentedSeriesBilling::where('user_id', $user->id)->orderBy('updated_at', 'DESC')->get();
        $movieTrans = RentedMovieBilling::where('user_id', $user->id)->orderBy('updated_at', 'DESC')->get();

        $seasonTrans->map(function($seasonTran){
            $seasonTran['section'] = 'Season';
        });

        $movieTrans->map(function($movieTran){
            $movieTran['section'] = 'Movie';
        });

        $totalAmount = 0;
        foreach($seasonTrans as $trans){
            $totalAmount = $totalAmount + $trans->amount;
        }

        foreach($movieTrans as $trans){
            $totalAmount = $totalAmount + $trans->amount;
        }

        return view('reports.users.transactions', compact('user', 'seasonTrans', 'movieTrans', 'totalAmount'));
    }
}
