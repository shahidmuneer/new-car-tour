<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Modal;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;



class ModalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.modal.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modals=\App\Models\Modal::get();
        return view('backend.modal.create');
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
            'name' => 'required',
          ]);

        $modalcar = new Modal();
        $modalcar->name=$request->name;
        $modalcar->save();

      return redirect()->route('modals.index')->with('success', 'Car Modal has been added Successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $carModal = Modal::findorfail($id);
        $name = $carModal->name;
        return view('backend.modal.edit', compact('name','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        $carModal = Modal::findorfail($id);
        $carModal->name = $request->name;
        $carModal->save();

        return redirect()->route('modals.index')->with('success', 'Car  has been updated Successfully');

    }

    public function update_modals(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        $carModal = Modal::findorfail($id);
        $carModal->name = $request->name;
        $carModal->save();
        return redirect()->route('modals.index')->with('success', 'Car  has been updated Successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $carModal = Modal::findorfail($id);
        $carModal->delete();
        return redirect()->route('modals.index')->with('success', 'Car Modal has been Deleted');
    }
}
