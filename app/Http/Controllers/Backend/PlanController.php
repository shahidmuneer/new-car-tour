<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Models\plan;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;


class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.plans.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.plans.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',

          ]);

          $data= $request->all();
          unset($data['_token']);

          $plan = Plan::create($data);

      return redirect()->route('plans.index')->with('success', 'Plan   has been added Successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function show(plan $plan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $plan = Plan::find($id);
        return view('backend.plans.edit', compact('plan','id'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        $validator = Validator::make($request->all(), [
        'title' => 'required',

    ]);

    $data = $request->all();
    unset($data['_token']);
    unset($data['_method']);


    $plan = Plan::where('id', $id)->update($data);

    if ($plan) {
        $plan = Plan::find($id);
        $plan->addAllMediaFromTokens();
        Alert::toast("Plan  Updated Successfully", 'success');
        return redirect()->route('plans.index');
    } else {
        Alert::toast('Fail to update Plan ' , 'error');
        return redirect()->back();
    }

    }
    public function update_plan(Request $request,  $id)
    {
        $validator = Validator::make($request->all(), [
        'title' => 'required',
    ]);

    $data = $request->all();
    unset($data['_token']);
    unset($data['_method']);


    $plan = Plan::where('id', $id)->update($data);

    if ($plan) {
        $plan = Plan::find($id);
//        $plan->addAllMediaFromTokens();
        Alert::toast("Plan  Updated Successfully", 'success');
        return redirect()->route('plans.index');
    } else {
        Alert::toast('Fail to update Plan ' , 'error');
        return redirect()->back();
    }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $plan = Plan::where('id', $id)->delete();
        if ($plan) {
            Alert::toast("Plan  Deleted Successfully", 'success');
            return redirect()->route('plans.index');
        } else {
            Alert::toast('Fail to delete Plan ', 'error');
            return redirect()->back();
        }
    }
}
