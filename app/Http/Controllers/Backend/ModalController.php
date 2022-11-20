<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Car;
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
            'title' => 'required',
   
          ]);

          $data= $request->all();
          unset($data['_token']);

          $car = Car::create($data);

      return redirect()->route('cars.index')->with('success', 'Car  has been added Successfully');



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
        $car = Car::findorfail($id);

        return view('backend.cars.edit', compact('car'));
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
            'title' => 'required',

        ]);
        
        $data = $request->all();
        unset($data['_token']);
        unset($data['_method']);
      

        $car = Car::where('id', $id)->update($data);

        if ($car) {
            $car = Car::find($id);
            $car->addAllMediaFromTokens();
            Alert::toast("Car Updated Successfully", 'success');
            return redirect()->route('dailysitreps.index');
        } else {
            Alert::toast('Fail to update daily sitrep', 'error');
            return redirect()->back();
        }
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $car = Car::where('id', $id)->delete();
        if ($car) {
            Alert::toast("cars Deleted Successfully", 'success');
            return redirect()->route('cars.index');
        } else {
            Alert::toast('Fail to delete daily sitrep', 'error');
            return redirect()->back();
        }
    }
}
