<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Models\PlanCategroy;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;


class PlanCategroyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd('abc');
        return view('backend.plancategroy.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.plancategroy.create');

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

          $planCategroy = PlanCategroy::create($data);

      return redirect()->route('plancategroy.index')->with('success', 'Plan Categroy  has been added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PlanCategroy  $planCategroy
     * @return \Illuminate\Http\Response
     */
    public function show(PlanCategroy $planCategroy)
    {
        $planCategroy = PackagePrice::find($id);

        return view('backend.plancategroy.edit', compact('planCategroy'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PlanCategroy  $planCategroy
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $planCategroy = PlanCategroy::find($id);

        return view('backend.plancategroy.edit', compact('planCategroy'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PlanCategroy  $planCategroy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',

        ]);
        
        $data = $request->all();
        unset($data['_token']);
        unset($data['_method']);
      

        $planCategroy = PlanCategroy::where('id', $id)->update($data);

        if ($planCategroy) {
            $planCategroy = PlanCategroy::find($id);
            $planCategroy->addAllMediaFromTokens();
            Alert::toast("Plan Categroy Updated Successfully", 'success');
            return redirect()->route('plancategroy.index');
        } else {
            Alert::toast('Fail to update Plan Categroy' , 'error');
            return redirect()->back();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PlanCategroy  $planCategroy
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $planCategroy = PlanCategroy::where('id', $id)->delete();
        if ($planCategroy) {
            Alert::toast("Package Categroy Deleted Successfully", 'success');
            return redirect()->route('plancategroy.index');
        } else {
            Alert::toast('Fail to delete Package Categroy', 'error');
            return redirect()->back();
        }
    }
}
