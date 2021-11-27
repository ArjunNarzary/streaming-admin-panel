<?php

namespace App\Http\Controllers;

use App\SubscriptionPlan;
use Illuminate\Http\Request;

class SubscriptionPlanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create|edit|delete');
    }

    public function index(){
        $subPlans = SubscriptionPlan::orderBy('updated_at', 'DESC')->get();
        return view('subscriptions.index', compact('subPlans'));
    }

    public function create(){
        $subPlan = new SubscriptionPlan();
        return view('subscriptions.create', compact('subPlan'));
    }

    public function store(Request $request){
        $sub = $this->validate($request, [
            'name'                  => 'required|string',
            'description'           => 'required|string',
            'fee'                   => 'required|numeric',
            'tax'                   => 'required|numeric',
            'time_period_type'      => 'required|string',
            'time_period'           => 'required|numeric',
            'status'                => 'required|numeric',
        ]);

        SubscriptionPlan::create($sub);

        return redirect(route('subscription.plan'))->with('success', 'Subscription Plan has been create successfully.');
    }

    //Edit View
    public function edit($id){
        $id = \decrypt($id);

        $subPlan = SubscriptionPlan::findOrFail($id);

        if($subPlan){
            return view('subscriptions.edit', compact('subPlan'));
        }else{
            return redirect(route('subscription.plan'))->with('error', 'Please try again');
        }
    }

    public function update(Request $request){
        $this->validate($request, [
            'sub_id'                => 'required|numeric',
        ]);
        $sub = $this->validate($request, [
            'name'                  => 'required|string',
            'description'           => 'required|string',
            'fee'                   => 'required|numeric',
            'tax'                   => 'required|numeric',
            'time_period_type'      => 'required|string',
            'time_period'           => 'required|numeric',
            'status'                => 'required|numeric',
        ]);

        SubscriptionPlan::updateOrCreate(['id' => $request->sub_id], $sub);

        return redirect(route('subscription.plan'))->with('success', 'Subcription plan has been updated successfully.');
    }

    //View Plan
    public function view(Request $request){
        $this->validate($request, [
            'id' => 'required',
        ]);

        $data = [];
        $data['status'] = false;

        $id = $request->id;
        $subs = SubscriptionPlan::find(decrypt($id));

        if($subs){
            $data['sub']    = $subs;
            $data['status'] = true;
        }

        return $data;
    }

    //Delete Plan
    public function delete($id){
        $id = \decrypt($id);
        $sub = SubscriptionPlan::findOrFail($id);

        if($sub){
            $sub->delete();
            return redirect(route('subscription.plan'))->with('success', 'Subcription plan has been successfully removed.');
        }
        else{
            return back()->with('error', 'Please try again.');
        }
    }
}
